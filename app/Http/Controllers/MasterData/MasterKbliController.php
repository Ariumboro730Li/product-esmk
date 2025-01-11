<?php

namespace App\Http\Controllers\MasterData;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\MasterKBLI;
use App\Models\StandardIndustrialClassification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterKbliController extends Controller
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


        $query = StandardIndustrialClassification::orderBy('created_at', $meta['orderBy']);


        if ($request->search !== null) {
            $query->where(function ($query) use ($request) {
                $columns = ['kbli'];
                foreach ($columns as $column) {
                    $query->orWhereRaw("LOWER({$column}) LIKE ?", ["%" . strtolower(trim($request->search)) . "%"]);
                }
            });
        }

        $data = $query->paginate($meta['limit']);

        return response()->json([
            'error' => false,
            'message' => 'Data ditemukan',
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
            'kbli' => 'required|unique:standard_industrial_classifications,kbli', // Add unique validation rule
            'name' => 'required',
            'description' => 'required'
        ], [
            'kbli.required' => 'Kode KBLI wajib diisi.',
            'kbli.unique' => 'Kode KBLI sudah terdaftar, harap gunakan nomor yang berbeda.',
            'name.required' => 'Nama KBLI wajib diisi.',
            'description.required' => 'Deskripsi KBLI wajib diisi.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Buat SK baru dan set sebagai aktif
        $newData = new StandardIndustrialClassification();
        $newData->kbli = $request->kbli;
        $newData->name = $request->name;
        $newData->description = $request->description;
        $newData->save();

        return response()->json([
            'message' => 'Sukses menyimpan Master KBLI baru',
            'status' => true,
        ], HttpStatusCodes::HTTP_OK);
    }

    public function destroy(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:standard_industrial_classifications,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }


        $data = StandardIndustrialClassification::find($request->id);
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
            'message' => 'KBLI berhasil dihapus',
            'status_code' => HttpStatusCodes::HTTP_OK,
        ], HttpStatusCodes::HTTP_OK);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:standard_industrial_classifications,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $newData = StandardIndustrialClassification::find($request->id);
        $newData->kbli = $request->kbli;
        $newData->name = $request->name;
        $newData->description = $request->description;
        $newData->update();

        return response()->json([
            'message' => 'Sukses mengubah data KBLI',
            'status' => true,
        ], HttpStatusCodes::HTTP_OK);
    }
}
