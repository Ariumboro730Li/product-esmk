<?php

namespace App\Http\Controllers\MasterData;

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\Controller;
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
            $duplicateCities = array_intersect($existingCities, $request->city_id);
            if (!empty($duplicateCities)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Beberapa kota sudah ada dalam kuota: ' . implode(', ', $duplicateCities),
                ], HttpStatusCodes::HTTP_CONFLICT);
            }
            $mergedCities = array_unique(array_merge($existingCities, $request->city_id));

            $existingQuota->city_id = json_encode(array_values($mergedCities));
            $existingQuota->save();

            return response()->json([
                'message' => 'Kuota kota berhasil diperbarui',
                'status' => true,
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
}
