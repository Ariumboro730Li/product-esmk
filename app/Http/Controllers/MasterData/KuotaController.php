<?php

namespace App\Http\Controllers\MasterData;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Kuota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KuotaController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|array',
            'city_id.*' => 'exists:cities,id',
        ], [
            'province_id.required' => 'Provinsi wajib diisi.',
            'province_id.exists' => 'Provinsi tidak ditemukan.',
            'city_id.required' => 'Kota wajib diisi.',
            'city_id.array' => 'Format kota harus array.',
            'city_id.*.exists' => 'Kota tidak ditemukan.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $existingQuota = Kuota::where('province_id', $request->province_id)->first();

        if ($existingQuota) {
            $existingCities = json_decode($existingQuota->city_id, true) ?? [];

            // Cari kota yang harus dihapus dan ditambahkan
            $toDelete = array_diff($existingCities, $request->city_id);
            $toInsert = array_diff($request->city_id, $existingCities);

            // Hapus kota yang nggak ada di request
            if (!empty($toDelete)) {
                $existingCities = array_values(array_diff($existingCities, $toDelete));
            }

            // Tambah kota baru
            if (!empty($toInsert)) {
                $existingCities = array_values(array_merge($existingCities, $toInsert));
            }

            $existingQuota->city_id = json_encode($existingCities);
            $existingQuota->updated_at = now();
            $existingQuota->save();

            return response()->json([
                'message' => 'Kuota kota berhasil diperbarui',
                'status' => true
            ], HttpStatusCodes::HTTP_OK);
        } else {
            $newData = new Kuota();
            $newData->province_id = $request->province_id;
            $newData->city_id = json_encode(array_values($request->city_id));
            $newData->save();

            return response()->json([
                'message' => 'Sukses menyimpan kuota baru',
                'status' => true,
            ], HttpStatusCodes::HTTP_OK);
        }
    }


    public function list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|max:50',
            'ascending' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $meta['orderBy'] = $request->ascending ? 'asc' : 'desc';
        $meta['limit'] = $request['limit'];

        // Ambil data dengan paginasi
        $query = Kuota::leftJoin('provinces', 'provinces.id', 'kuota.province_id')
            ->select('kuota.*', 'provinces.name as province_name')
            ->orderBy('kuota.created_at', $meta['orderBy'])
            ->paginate($meta['limit']);

        // Kumpulkan semua city_id dulu
        $allCityIds = $query->pluck('city_id')
            ->filter()
            ->flatMap(function ($cityId) {
                return json_decode($cityId, true) ?? [];
            })
            ->unique()
            ->values();

        // Ambil semua nama kota dalam satu query
        $cityNames = City::whereIn('id', $allCityIds)->pluck('name', 'id');

        // Transformasi data
        $query->getCollection()->transform(function ($item) use ($cityNames) {
            $cityIds = json_decode($item->city_id, true);

            if (is_array($cityIds)) {
                $item->city_list = collect($cityIds)->map(function ($id) use ($cityNames) {
                    return $cityNames[$id] ?? null;
                })->filter()->values();
            } else {
                $item->city_list = [];
            }

            return $item;
        });

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Ditampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $query->items(),
            'paginate' => [
                'total' => $query->total(),
                'count' => $query->count(),
                'per_page' => $query->perPage(),
                'current_page' => $query->currentPage(),
                'total_pages' => $query->lastPage(),
            ],
        ], HttpStatusCodes::HTTP_OK);
    }

    public function detail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:kuota,id',
        ], [
            'id.required' => 'ID Kuota tidak boleh kosong',
            'id.exists' => 'ID Kuota tidak ditemukan'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $query = Kuota::leftJoin('provinces', 'provinces.id', 'kuota.province_id')
            ->select('kuota.*', 'provinces.name as province_name')
            ->where('kuota.id', $request->id);

        // Kumpulkan semua city_id dulu
        $allCityIds = $query->pluck('city_id')
            ->filter()
            ->flatMap(function ($cityId) {
                return json_decode($cityId, true) ?? [];
            })
            ->unique()
            ->values();

        // Ambil semua nama kota dalam satu query
        $cityNames = City::whereIn('id', $allCityIds)->pluck('name', 'id');

        // Ambil hasil query sebagai collection
        $result = $query->get()->transform(function ($item) use ($cityNames) {
            $cityIds = json_decode($item->city_id, true);

            if (is_array($cityIds)) {
                $item->city_list = collect($cityIds)->map(function ($id) use ($cityNames) {
                    return $cityNames[$id] ?? null;
                })->filter()->values();
            } else {
                $item->city_list = [];
            }

            return $item;
        });

        return response()->json([
            'error' => false,
            'message' => 'Data Berhasil Ditampilkan',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' => $result,
        ], HttpStatusCodes::HTTP_OK);
    }
}
