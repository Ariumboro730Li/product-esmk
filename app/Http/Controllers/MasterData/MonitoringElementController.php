<?php

namespace App\Http\Controllers\MasterData;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\MonitoringElement;
use App\Models\SmkElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MonitoringElementController extends Controller
{
    public function __construct() {}

    public function index(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|max:50',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Set order dan limit
        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit;

        // Query dasar
        $query = MonitoringElement::select('id', 'title', 'is_active', 'created_at')
            ->orderBy('created_at', $meta['orderBy']);

        // Pencarian berdasarkan title atau created_at
        if ($request->search !== null) {
            $search = strtolower(trim($request->search));

            // Pencarian berdasarkan title
            $query->where(function ($q) use ($search) {
                $q->whereRaw("LOWER(title) LIKE ?", ["%$search%"]);
            });

            // Jika yang dicari berupa tanggal, tambahkan pencarian pada created_at
            if (strtotime($search)) {
                $query->orWhereRaw("DATE_FORMAT(created_at, '%Y-%m-%d') LIKE ?", ["%$search%"]);
            }
        }

        // Pagination
        $data = $query->paginate($meta['limit']);

        // Berhasil menampilkan data
        return response()->json([
            'error' => false,
            'message' => 'Berhasil ditampilkan',
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
                'id' => 'required|exists:monitoring_elements,id',
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

        $data = MonitoringElement::select()->where('id', $request->id)->first();

        if (!$data) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_NOT_FOUND,
                'error'         => true,
                'message'       => 'Data tidak ditemukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        $response = [
            'title' => $data->title,
            'element_properties' => json_decode($data->element_properties),
            'additional_questions' => json_decode($data->additional_questions),
            'monitoring_elements' => json_decode($data->monitoring_elements)
        ];
        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $response
        ], HttpStatusCodes::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'element_properties' => 'required|array',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        MonitoringElement::where('is_active', 1)->update(['is_active' => 0]);

        // Menyimpan data baru
        $newData = new MonitoringElement();
        $newData->title = $request->title;
        $newData->is_active = 1;
        $newData->element_properties = json_encode($request->element_properties, true);
        $newData->monitoring_elements = json_encode($request->monitoring_elements, true);
        $newData->additional_questions = json_encode($request->additional_questions, true);

        $newData->save();

        return response()->json([
            'status' => true,
            'message' => 'Data successfully created',
            'data' => $newData
        ], HttpStatusCodes::HTTP_CREATED);
    }

    public function destroy(Request $request)
    {
        $data = MonitoringElement::findOrFail($request->id);
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

    public function status(Request $request)
    {
        // Validasi input
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:monitoring_elements,id',
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
        $data = MonitoringElement::find($request->id);
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
            MonitoringElement::where('id', '!=', $data->id)->update(['is_active' => 0]);

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
