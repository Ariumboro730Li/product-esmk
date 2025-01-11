<?php

namespace App\Http\Controllers;

use App\Constants\HttpStatusCodes;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{

    public function list(Request $request){
        $validator = Validator::make($request->all(), [
            'page' => 'required|integer',
            'limit' => 'required|integer|max:50',
            'ascending' => 'nullable|boolean',
        ]);

        if($validator->fails()){
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $query = Setting::query();

        $query->when($request->search, function($q) use ($request){
            $q->where('name', 'like', "%$request->search%");
        });

        $query->orderBy('created_at', $request->ascending ? 'asc' : 'desc');
        $data = $query->paginate($request->limit);
        $meta = [
            'total'        => $data->total(),
            'count'        => $data->count(),
            'per_page'     => $data->perPage(),
            'current_page' => $data->currentPage(),
            'total_pages'  => $data->lastPage()
        ];

        return response()->json([
            'error' => false,
            'message' => 'Successfully',
            'status_code' => HttpStatusCodes::HTTP_OK,
            'data' =>  $data->toArray()['data'],
            'pagination' => $meta
        ], HttpStatusCodes::HTTP_OK);
    }

    public function oss(Request $request){
        $settingName = "oss";
        $validator = Validator::make($request->all(), [
            "username" => "required|string",
            "password" => "required|string",
            "url" => "required|string",
            "is_active" => "required|boolean",
        ]);

        if($validator->fails()){
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        Setting::where('name', $settingName)->updateOrCreate([
            'name' => $settingName,
        ], [
            'value' => [
                'username' => strip_tags($request->username),
                'password' => strip_tags($request->password),
                'url' => strip_tags($request->url),
                'is_active' => $request->is_active,
            ]
        ]);

        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => 'Setting berhasil disimpan.'
        ], HttpStatusCodes::HTTP_OK);

    }

    public function aplikasi(Request $request){
        $settingName = "aplikasi";
        $validator = Validator::make($request->all(), [
            "nama" => "required|string",
            "nama_instansi" => "required|string",
            "deskripsi" => "required|string",
            "email" => "required|string",
            // "no_wa" => "required|string",
            "whatsapp" => [
                'required',
                'regex:/^(62|0)[0-9]{6,13}$/'
            ],
            "alamat" => "required|string",
            "provinsi" => "required|string",
            "kota" => "required|string",
            "logo_favicon" => "required|string",
            "logo_aplikasi" => "required|string",
        ], [
            'whatsapp.regex' => 'Nomor WhatsApp harus diawali dengan 62 | 0 dan hanya terdiri dari angka.', // Pesan error kustom
        ]);

        if($validator->fails()){
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        Setting::where('name', $settingName)->updateOrCreate([
            'name' => $settingName,
        ], [
            'value' => [
                'nama' => strip_tags($request->nama),
                'nama_instansi' => strip_tags($request->nama_instansi),
                'deskripsi' => strip_tags($request->deskripsi),
                'email' => strip_tags($request->email),
                'whatsapp' => strip_tags($request->whatsapp),
                'alamat' => strip_tags($request->alamat),
                'provinsi' => strip_tags($request->provinsi),
                'kota' => strip_tags($request->kota),
                'logo_favicon' => strip_tags($request->logo_favicon),
                'logo_aplikasi' => strip_tags($request->logo_aplikasi),
            ]
        ]);

        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => 'Setting berhasil disimpan.'
        ], HttpStatusCodes::HTTP_OK);
    }

    public function get(Request $request){
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
        ]);

        if($validator->fails()){
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $setting = Setting::where('name', $request->name)->first();
        if(!$setting){
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_NOT_FOUND,
                'error'         => true,
                'message'       => 'Setting tidak ditemukan.'
            ], HttpStatusCodes::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => 'Setting berhasil diambil.',
            'data'          => $setting->value
        ], HttpStatusCodes::HTTP_OK);
    }
}
