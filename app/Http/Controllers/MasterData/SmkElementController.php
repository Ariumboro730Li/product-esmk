<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Controllers\Controller;
use App\Models\SmkElement;
use App\Constants\HttpStatusCodes;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;

class SmkElementController extends Controller
{

    public function __construct() {}
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|max:50',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit;
        $query = SmkElement::select('id', 'title', 'is_active', 'created_at')->orderBy('created_at', $meta['orderBy']);

        if ($request->search !== null) {
            $search = strtolower(trim($request->search));
            $query->whereRaw("LOWER(title) LIKE ?", ["%$search%"])
                ->whereRaw("LOWER(created_at) LIKE ?", ["%$search%"]);
        }
        $data = $query->paginate($meta['limit']);
        if (!$data) {
            return response()->json([
                'error' => true,
                'message' => 'data tidak di temukan',
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
            ], status: HttpStatusCodes::HTTP_NOT_FOUND);
        }
        return response()->json([
            'error' => false,
            'message' => 'Berhasil Di Tampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data->toArray()['data'],
            'paginate' => [
                'total' => $data->total(),
                'count' => $data->count(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'total_pages' => $data->lastPage(),
            ],
        ], status: HttpStatusCodes::HTTP_OK);
    }
    public function detail(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            rules: [
                'id' => 'required|exists:smk_elements,id',
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

        $data = SmkElement::where('id', $request->id)->first();

        if (!$data) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_NOT_FOUND,
                'error'         => true,
                'message'       => 'Data tidak ditemukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }
        $responseData = [
            'title' => $data->title,
            'element_properties' => json_decode($data->element_properties)
        ];

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil di Tampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $responseData
        ], HttpStatusCodes::HTTP_OK);
    }

    public function store(Request $request)
    {
        // Validasi dasar untuk 'title' dan 'element_properties'
        $validator = Validator::make($request->all(), [
            'title' => 'required|unique:smk_elements',
            'element_properties' => 'required|array',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Ambil data dari element_properties
        $elementProperties = $request->element_properties;

        // Proses recursive untuk membersihkan data
        $processedProperties = $this->processElementProperties($elementProperties);

        // Set semua elemen aktif sebelumnya menjadi tidak aktif
        SmkElement::where('is_active', 1)->update(['is_active' => 0]);

        // Buat entri baru
        $newData = new SmkElement();
        $newData->title = $request->title;
        $newData->is_active = 1; // Set entri baru sebagai aktif
        $newData->element_properties = json_encode($processedProperties); // Simpan data yang sudah diproses
        $newData->save();

        return response()->json([
            'status' => true,
            'message' => 'Data Berhasil Ditambahkan',
            'data' => $newData
        ], HttpStatusCodes::HTTP_CREATED);
    }

    private function processElementProperties(array $data)
    {
        foreach ($data as $key => $value) {
            // Jika key adalah 'title', abaikan proses pembersihan
            if ($key === 'title') {
                continue;
            }

            // Jika value adalah array, proses rekursif
            if (is_array($value)) {
                $data[$key] = $this->processElementProperties($value);
            } elseif (is_string($value)) {
                // Jika key adalah 'max_assessment', tetap gunakan nilai asli
                if ($key === 'max_assessment') {
                    $data[$key] = preg_replace('/[^0-9.]/', '', $value); // Hanya izinkan angka dan titik
                } else {
                    // Bersihkan simbol dari string
                    $data[$key] = preg_replace('/[^a-zA-Z0-9\s]/', '', $value);
                }
            } elseif (is_numeric($value)) {
                // Jika key adalah 'max_assessment', tetap gunakan nilai asli
                if ($key === 'max_assessment') {
                    $data[$key] = str_replace(',', '.', (string)$value); // Pastikan format desimal dengan titik
                } else {
                    // Tetap simpan angka tanpa perubahan
                    $data[$key] = $value;
                }
            }
        }
        return $data;
    }


    public function status(Request $request)
    {
        // Validasi input
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:smk_elements,id',
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
        $data = SmkElement::find($request->id);
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
            SmkElement::where('id', '!=', $data->id)->update(['is_active' => 0]);

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

    public function destroy(Request $request)
    {
        $data = SmkElement::findOrFail($request->id);
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

    public function smkElement()
    {
        $data = smkElement::where('is_active', 1)->first();

        if (!$data) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_NOT_FOUND,
                'error'         => true,
                'message'       => 'Data tidak ditemukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }
        $responseData = [
            'title' => $data->title,
            'element_properties' => json_decode($data->element_properties)
        ];

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil di Tampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $responseData
        ], HttpStatusCodes::HTTP_OK);
    }
}
