<?php

namespace App\Http\Controllers;

use App\Constants\HttpStatusCodes;
use App\Models\Setting;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{

    protected $service;
    public function __construct(FileService $service)
    {
        $this->service = $service;
    }

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

        if($request->is_active){
            $ossController = new OssController();
            $response = $ossController->loginOss($request);
            if($response->status() !== 200){
                return $response;
            }

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

        if(isset($response)){
            return $response;
        }



        $message = $request->is_active ? 'Pengaturan OSS berhasil diaktifkan.' : 'Pengaturan OSS berhasil dinonaktifkan.';
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => $message
        ], HttpStatusCodes::HTTP_OK);

    }

    public function aplikasi(Request $request){
        $settingName = "aplikasi";
        $validator = Validator::make($request->all(), [
            "nama" => "required|string|min:5|max:20",
            "nama_instansi" => "required|string|min:5|max:100",
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
            // "logo_favicon" => "string",
            // "logo_aplikasi" => "string",
        ], [
            'nama.min' => 'Nama aplikasi minimal 5 karakter.', //
            'nama.max' => 'Nama aplikasi maksimal 20 karakter.', //
            'nama_instansi.min' => 'Nama instansi minimal 5 karakter.', //
            'nama_instansi.max' => 'Nama instansi maksimal 100 karakter.', //
            'whatsapp.regex' => 'Nomor WhatsApp harus diawali dengan 62 | 0 dan hanya terdiri dari angka.', //
        ]);

        if($validator->fails()){
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $setting = Setting::where('name', $settingName)->first();

        $logo_favicon = $request->logo_favicon ?? $setting->value['logo_favicon'];
        $logo_aplikasi = $request->logo_aplikasi ?? $setting->value['logo_favicon'];

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
                'logo_favicon' => strip_tags($logo_favicon),
                'logo_aplikasi' => strip_tags($logo_aplikasi),
            ]
        ]);

        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => 'Setting berhasil disimpan.'
        ], HttpStatusCodes::HTTP_OK);
    }

    public function uploadFile(Request $request)
    {
        // Validasi file
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        if($request->hasFile('file')){
            $fileURL = $this->service->upload($request->file('file'));
        } else {
            $fileURL = null;
        }
        $setting = Setting::where('name', 'aplikasi')->first();
        $value = $setting->value;

        if($request->name == "logo_favicon"){
            $value['logo_favicon'] = $fileURL;
        } else {
            $value['logo_aplikasi'] = $fileURL;
        }

        $setting->update([
            'value' => $value
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengunggah data',
            'file_url' => $fileURL,
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
