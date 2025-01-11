<?php

namespace App\Http\Controllers\MasterData;

use App\Models\City;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct() {}
    public function index(Request $request) : JsonResponse
    {
        // Validasi input request
        $validator = Validator::make($request->all(), [
            'province_id' => 'nullable|exists:provinces,id',
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

        $query = City::with('province')->orderBy('created_at', $meta['orderBy']);
        if ($request->keyword !== null) {
            $query->where(function($query) use ($request) {
                $columns = ['name', 'administrative_code','province_id'];
                foreach ($columns as $column) {
                    $query->orWhereRaw("LOWER({$column}) LIKE ?", ["%" . strtolower(trim($request->keyword)) . "%"]);
                }
            });
        }

        if ($request->province_id !== null) {
            $query->where('province_id', $request->province_id);
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
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'administrative_code' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $province = Province::find($request->province_id);

        if (!$province) {
            return response()->json([
                'status' => false,
                'message' => 'Province tidak ditemukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        // Cek apakah ada kota lain dengan kode administratif belakang titik yang sama
        $existingCity = City::whereRaw("SUBSTRING_INDEX(administrative_code, '.', -1) = ?", [$request->administrative_code])
                            ->first();

        if ($existingCity) {
            return response()->json([
                'status' => false,
                'message' => 'Kode administratif sudah ada di kota lain'
            ], HttpStatusCodes::HTTP_CONFLICT);
        }

        // Kombinasi kode provinsi dengan kode administratif baru
        $combinedCode = $province->administrative_code . '.' . $request->administrative_code;

        // Simpan data baru
        $newData = new City();
        $newData->name = $request->name;
        $newData->province_id = $request->province_id;
        $newData->administrative_code = $combinedCode;
        $newData->save();

        // Berikan respons sukses
        return response()->json([
            'message' => 'Sukses Membuat Data Kota',
            'status' => true,
            'data' => $newData
        ], HttpStatusCodes::HTTP_CREATED);
    }




    /**
     * Display the specified resource.
     */
    public function show(Request $request): JsonResponse
    {
        $data = City::with('province')->where('id', $request->id)->first();
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
        $data = City::with('province')->where('id', $request->id)->first();
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
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'administrative_code' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $city = City::find($request->id);

        if (!$city) {
            return response()->json([
                'status' => false,
                'message' => 'City tidak ditemukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        $province = Province::find($request->province_id);

        if (!$province) {
            return response()->json([
                'status' => false,
                'message' => 'Province tidak ditemukan'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        // Cek apakah ada kota lain dengan kode administratif belakang titik yang sama, kecuali kota yang sedang diupdate
        $existingCity = City::whereRaw("SUBSTRING_INDEX(administrative_code, '.', -1) = ?", [$request->administrative_code])
                            ->where('id', '!=', $city->id)
                            ->first();

        if ($existingCity) {
            return response()->json([
                'status' => false,
                'message' => 'Kode administratif sudah ada di kota lain'
            ], HttpStatusCodes::HTTP_CONFLICT);
        }

        // Kombinasi kode provinsi dengan kode administratif baru
        $combinedCode = $province->administrative_code . '.' . $request->administrative_code;

        // Simpan perubahan data kota
        $city->name = $request->name;
        $city->province_id = $request->province_id;

        // Cek apakah kode administratif belakang titik (setelah ".") berubah
        $adminCodeSuffix = explode('.', $city->administrative_code)[1] ?? null;

        if ($adminCodeSuffix !== $request->administrative_code) {
            $city->administrative_code = $combinedCode;
        }

        $city->save();

        // Berikan respons sukses
        return response()->json([
            'message' => 'Sukses Memperbarui Data Kota',
            'status' => true,
            'data' => $city
        ], HttpStatusCodes::HTTP_OK);
    }







    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        $data = City::findOrFail($request->id);
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
            'message' => 'Data Kota Berhasil Dihapus',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $data
        ], HttpStatusCodes::HTTP_OK);

    }

    public function select2(Request $request){
        $query = $request->term['term'] ??'';
        $data = Province::where('name', 'LIKE', "%$query%")->get();

        return response()->json($data);
    }

}
