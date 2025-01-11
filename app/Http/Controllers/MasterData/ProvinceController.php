<?php

namespace App\Http\Controllers\MasterData;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct() {}
    public function index(Request $request) : JsonResponse
    {
        // Validasi input request
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|max:50',
            'ascending' => 'required|boolean',
            'keyword' => 'nullable|string',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }


        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request->limit;

        $query = Province::orderBy('created_at', $meta['orderBy']);


        if ($request->keyword !== null) {
            $query->where(function($query) use ($request) {
                $columns = ['name', 'administrative_code'];
                foreach ($columns as $column) {
                    $query->orWhereRaw("LOWER({$column}) LIKE ?", ["%" . strtolower(trim($request->keyword)) . "%"]);
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


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'administrative_code' => 'required|string|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $existingProvince = Province::where('administrative_code', $request->administrative_code)->first();
        if ($existingProvince) {
            return response()->json([
                'status' => false,
                'message' => 'Kode administratif sudah ada dalam database'
            ], HttpStatusCodes::HTTP_CONFLICT);
        }


        $newData = new Province();
        $newData->name = $request->name;
        $newData->administrative_code = $request->administrative_code;
        $newData->save();

        return response()->json([
            'message' => 'Sukses Membuat Data Provinsi',
            'status' => true,
            'data' => $newData
        ], HttpStatusCodes::HTTP_OK);
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        $data = Province::where('id', $request->id)->first();
        if(!$data) {
            return response()->json([
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
                'error' => true,
                'message' => 'Data Tidak Ditmukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        return response()->json([
            'error' => false,
            'message' => 'Succesfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $data = Province::where('id', $request->id)->first();
        if(!$data) {
            return response()->json([
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
                'error' => true,
                'message' => 'Data Tidak Ditmukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        return response()->json([
            'error' => false,
            'message' => 'Succesfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'administrative_code' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $province = Province::find($request->id);

        if (!$province) {
            return response()->json([
                'status' => false,
                'message' => 'Province not found'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        $existingProvince = Province::where('administrative_code', $request->administrative_code)
                                    ->where('id', '!=', $province->id)
                                    ->first();

        if ($existingProvince) {
            return response()->json([
                'status' => false,
                'message' => 'Administrative Code Ini sudah ada'
            ], HttpStatusCodes::HTTP_CONFLICT);
        }

        $province->name = $request->input('name');
        $province->administrative_code = $request->input('administrative_code');
        $province->save();

        return response()->json([
            'message' => 'Data Provinsi Berhasil Diubah',
            'status' => true,
            'data' => $province
        ], HttpStatusCodes::HTTP_OK);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        $data = Province::findOrFail($request->id);
        if(!$data) {
            return response()->json([
                'status_code' => HttpStatusCodes::HTTP_NOT_FOUND,
                'error' => true,
                'message' => 'Data Tidak Ditmukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }
        $data->delete();

        return response()->json([
            'error' => false,
            'message' => 'Berhasil Menghapus Data',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);

    }

}
