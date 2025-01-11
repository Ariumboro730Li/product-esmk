<?php

namespace App\Http\Controllers\MasterData;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\DecreeNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SkNumberController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input request
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|max:50',
            'ascending' => 'required|boolean',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }


        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit;

        $query = DecreeNumber::with('workUnit')->orderBy('created_at', $meta['orderBy']);


        if ($request->search !== null) {
            $query->where(function ($query) use ($request) {
                $columns = ['decree_number'];
                foreach ($columns as $column) {
                    $query->orWhereRaw("LOWER({$column}) LIKE ?", ["%" . strtolower(trim($request->search)) . "%"]);
                }
            });
        }

        $data = $query->paginate($meta['limit']);

        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ],
        ], HttpStatusCodes::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sk_number' => 'required|unique:decree_numbers,decree_number', // Add unique validation rule
        ], [
            'sk_number.required' => 'Nomor SK wajib diisi.',
            'sk_number.unique' => 'Nomor SK sudah terdaftar, harap gunakan nomor yang berbeda.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        DecreeNumber::where('is_active', 1)
            ->update(['is_active' => 0]);

        // Buat SK baru dan set sebagai aktif
        $newData = new DecreeNumber();
        $newData->decree_number = $request->sk_number;
        $newData->is_active = 1;
        $newData->save();

        return response()->json([
            'message' => 'Sukses menyimpan data SK baru',
            'status' => true,
        ], HttpStatusCodes::HTTP_OK);
    }


    public function destroy(Request $request)
    {
        $data = DecreeNumber::findOrFail($request->id);
        if (!$data) {
            return response()->json([
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
                'error' => true,
                'message' => 'Data Tidak Ditmukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }
        $data->delete();

        return response()->json([
            'error' => false,
            'message' => 'Nomor SK berhasil dihapus',
            'status_code' => HttpStatusCodes::HTTP_OK,
        ], HttpStatusCodes::HTTP_OK);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:decree_numbers,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $newData = DecreeNumber::find($request->id);

        $existingActiveSk = DecreeNumber::where('is_active', 1)
            ->first();

        if ($existingActiveSk) {
            $newData->is_active = 0;
        } else {
            $newData->is_active = 1;
        }

        $newData->decree_number = $request->sk_number;
        $newData->save();

        return response()->json([
            'message' => 'Sukses mengubah data',
            'status' => true,
        ], HttpStatusCodes::HTTP_OK);
    }



    public function status(Request $request)
    {
        // Validasi input
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:decree_numbers,id',
            ],
            [
                'id.required' => 'ID Diperlukan',
                'id.exists' => 'ID Tidak Ditemukan',
            ]
        );

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(), // Mengambil pesan error pertama
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Ambil data berdasarkan ID
        $data = DecreeNumber::find($request->id);
        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'Data tidak ditemukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        // Toggle status is_active
        if ($data->is_active == 0) {
            $data->is_active = 1;
            $data->save();

            // Update semua elemen lain agar non-aktif
            DecreeNumber::where('id', '!=', $data->id)->update(['is_active' => 0]);

            return response()->json([
                'error' => false,
                'message' => 'Status berhasil diubah',
                'status_code' => HttpStatusCodes::HTTP_OK,
                'data' => [
                    'id' => $data->id,
                    'title' => $data->title,
                    'is_active' => $data->is_active,
                ],
            ], HttpStatusCodes::HTTP_OK);
        } else {
            // Set to inactive
            $data->is_active = 0;
            $data->save();

            return response()->json([
                'error' => false,
                'message' => 'Status berhasil diubah',
                'status_code' => HttpStatusCodes::HTTP_OK,
                'data' => [
                    'id' => $data->id,
                    'title' => $data->title,
                    'is_active' => $data->is_active,
                ],
            ], HttpStatusCodes::HTTP_OK);
        }
    }
}
