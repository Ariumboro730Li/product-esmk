<?php

namespace App\Http\Controllers\MasterData;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\Dirjen;
use App\Models\Signer;
use App\Models\User;
use App\Models\WorkUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Laravel\SerializableClosure\Serializers\Signed;

class DirJenController extends Controller
{

    public function index(Request $request)
    {
        // Validasi request
        $validated = $request->validate([
            'limit' => 'required|numeric|max:50',
            'ascending' => 'required|boolean'
        ]);

        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $validated['limit'];

        $query = Signer::orderBy('created_at', $meta['orderBy']);

        if ($request->search !== null) {
            $query->where(function ($query) use ($request) {
                $searchTerm = "%" . strtolower(trim($request->search)) . "%";
                $query->whereRaw("LOWER(name) LIKE ?", [$searchTerm]);
            });
        }

        $data = $query->paginate($meta['limit']);
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Ditampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data->items(),
            'paginate' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ],
        ], HttpStatusCodes::HTTP_OK);
    }


    public function show(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:dirjens,id',
            ],
            messages: [
                'id.required' => 'ID Di Perlukan',
                'id.exists' => 'ID Tidak Di Temukan',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0],
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $data = Signer::where('id', $request->id)->first();

        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Di Tampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data

        ], status: HttpStatusCodes::HTTP_OK);
    }

    public function create(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'position' => 'required',
            'identity_number' => 'required|unique:signers,identity_number', // Nomor identitas harus unik
            'identity_type' => 'required',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'position.required' => 'Jabatan wajib diisi.',
            'identity_number.required' => 'Nomor identitas wajib diisi.',
            'identity_number.unique' => 'Nomor identitas sudah terdaftar, harap gunakan nomor yang berbeda.',
            'identity_type.required' => 'Jenis identitas wajib diisi.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Nonaktifkan Dirjen yang sudah aktif di satuan kerja yang sama
        Signer::where('is_active', 1)
            ->update(['is_active' => 0]);

        // Buat data Dirjen baru
        $newData = new Signer();
        $newData->name = $request->name;
        $newData->position = $request->position;
        $newData->identity_number = $request->identity_number;
        $newData->identity_type = $request->identity_type;
        $newData->is_active = 1; // Set Dirjen baru sebagai aktif
        $newData->save();

        return response()->json([
            'message' => 'Sukses menambahkan direktur jenderal',
            'status' => true,
        ], HttpStatusCodes::HTTP_OK);
    }


    public function edit(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:signers,id',
            ],
            messages: [
                'id.required' => 'ID Di Perlukan',
                'id.exists' => 'ID Tidak Di Temukan',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0],
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $data = Signer::where('id', $request->id)->first();

        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
        return response()->json([
            'error' => false,
            'message' => 'Data Ditampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => [$data],

        ], status: HttpStatusCodes::HTTP_OK);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:signers,id',
                'name' => 'required|',
                'position' => 'required|',
                'identity_number' => 'required|',
                'identity_type' => 'required|',
            ],
            messages: [
                'id.required' => 'ID Di Perlukan',
                'id.exists' => 'ID Tidak Di Temukan',
                'name.required' => 'Nama Penandatangan Di Perlukan',
                'position.required' => 'Posisi Penandatangan Di Perlukan',
                'identity_number.required' => 'Nomor Identitas Di Perlukan',
                'identity_type.required' => 'Tipe Identitas Di Perlukan',
            ]
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0],
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $data = Signer::find($request->id);

        $existingActiveSk = Signer::where('is_active', 1)
            ->first();

        if ($existingActiveSk) {
            $data->is_active = 0;
        } else {
            $data->is_active = 1;
        }

        $data->name = $request->input('name');
        $data->position = $request->input('position');
        $data->identity_number = $request->input('identity_number');
        $data->identity_type = $request->input('identity_type');
        $data->save();

        $statusdata = Signer::where('id', '!=', $data->id)->get();
        foreach ($statusdata as $updatedata) {
            if ($request->is_active == 1) {
                $updatedata->is_active = 0;
                $updatedata->save();
            }
        }

        if ($data) {
            return response()->json([
                'error' => false,
                'message' => 'Data Berhasil Di Ubah',
                'status_code' => HttpStatusCodes::HTTP_OK,
                'data' => $data,
            ], status: HttpStatusCodes::HTTP_OK);
        } else {
            return response()->json([
                'errors' => true,
                'message' => 'Data Gagal Disimpan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:signers,id',
            ],
            messages: [
                'id.required' => 'ID Di Perlukan',
                'id.exists' => 'ID Tidak Di Temukan',
            ]
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0],
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $data = Signer::where('id', $request->id);
        $penandatangan = $data->delete();
        if ($penandatangan) {
            return response()->json([
                'error' => false,
                'message' => 'Data Berhasil Di Hapus',
                'status_code' => HttpStatusCodes::HTTP_OK,
                'data' => $penandatangan,
            ], status: HttpStatusCodes::HTTP_OK);
        } else {
            return response()->json([
                'errors' => true,
                'message' => 'Data Gagal Disimpan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
    }

    public function filterUserDipilih(Request $request)
    {
        $dataFilter = Dirjen::select('id', 'user_id', 'is_active')->get();
        $userIds = $dataFilter->pluck('user_id')->toArray();
        // dd($userIds);
        $query = User::select('id', 'name')
            ->where('is_active', 1)
            ->whereNotIn('id', $userIds);

        // Jika ada parameter 'search', lakukan pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower(trim($request->search));

            // Tambahkan kondisi pencarian pada query
            $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]);
        }

        // Eksekusi query dan ambil hasilnya
        $dataUser = $query->get();

        // dd($data);

        if (!$dataUser) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $dataUser,
        ], status: HttpStatusCodes::HTTP_OK);
    }

    public function filterUser(Request $request)
    {
        // Cari data Dirjen berdasarkan ID
        $datakurangi = Dirjen::where('id', $request->id)->first();

        // Pastikan data Dirjen ditemukan sebelum melanjutkan
        if (!$datakurangi) {
            return response()->json([
                'error' => true,
                'message' => 'Data Dirjen tidak ditemukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND); // Perbaikan sintaks status
        }

        // Ambil semua user_id dari Dirjen, kecuali yang sama dengan id dari datakurangi
        $dataFilter = Dirjen::select('user_id')
            ->where('id', '!=', $datakurangi->id) // Menghindari ID Dirjen saat ini
            ->pluck('user_id')
            ->toArray();

        // Query untuk mengambil data pengguna yang aktif dan tidak dalam daftar user_id di $dataFilter
        $query = User::select('id', 'name')
            ->where('is_active', 1)
            ->whereNotIn('id', $dataFilter);

        // Jika ada parameter pencarian, tambahkan kondisi pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = strtolower(trim($request->search));
            $query->whereRaw("LOWER(name) LIKE ?", ["%$search%"]); // Pencarian berdasarkan nama (case insensitive)
        }

        // Eksekusi query dan ambil hasilnya
        $data = $query->get();

        // Jika tidak ada data pengguna ditemukan
        if ($data->isEmpty()) {
            return response()->json([
                'error' => true,
                'message' => 'Data tidak ditemukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        // Berhasil, kirimkan data pengguna
        return response()->json([
            'error' => false,
            'message' => 'Berhasil',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data,
        ], HttpStatusCodes::HTTP_OK);
    }

    public function disable(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:signers,id',
            ],
            messages: [
                'id.required' => 'ID Di Perlukan',
                'id.exists' => 'ID Tidak Di Temukan',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->all()[0],
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $data = Signer::where('id', $request->id)->first();
        $data->is_active = 0;
        $data->save();

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil di Nonaktifkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data,
        ], status: HttpStatusCodes::HTTP_OK);
    }
    public function enable(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:signers,id',
            ],
            [
                'id.required' => 'ID Diperlukan',
                'id.exists' => 'ID Tidak Ditemukan',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $data = Signer::find($request->id);

        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'Signer tidak ditemukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        $data->is_active = 1;
        $data->save();

        Signer::where('id', '!=', $request->id)->update(['is_active' => 0]);

        return response()->json([
            'error' => false,
            'message' => 'Data berhasil diaktifkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);
    }
}
