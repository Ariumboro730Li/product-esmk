<?php

namespace App\Http\Controllers;

use App\Models\CompanyServiceType;
use App\Models\NibOss;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Constants\HttpStatusCodes;
use Illuminate\Support\Facades\Validator;
use App\Jobs\Esmk\NotificationEmail;
use Str;

class RegisterController extends Controller
{
    protected $companyType = [
        '01' => 'PT',
        '02' => 'CV',
        '04' => 'Badan Usaha pemerintah',
        '05' => 'Firma (Fa)',
        '06' => 'Persekutuan Perdata',
        '07' => 'Koperasi',
        '10' => 'Yayasan',
        '16' => 'Bentuk Usaha Tetap (BUT)',
        '17' => 'Perseorangan',
        '18' => 'Badan Layanan Umum (BLU)',
        '19' => 'Badan Hukum',
        '20' => 'Badan Usaha Lainnya', // Badan Usaha Lainnya (Khusus STPW Luar Negeri)
        '21' => 'Perum', // Perusahaan Umum (PERUM)
        '22' => 'Perumda', // Perusahaan Umum Daerah (PERUMDA)
        '23' => 'Perusda', // Perusahaan Daerah (PERUSDA)
        '24' => 'BOB' , // Badan Operasi Bersama (BOB)
        '25' => 'Badan Usaha Perwakilan',
        '26' => 'PT Peorangan' , // PT Perorangan
        '27' => 'PBA', // Pedagang Berjangka Asing (PBA)
        '28' => 'BUM Desa', // Badan Usaha Milik Desa (BUM Desa)
        '29' => 'BUM Desa Bersama'
    ];

    public function registerManual(Request $request){
        $validator = Validator::make($request->all(), [
            "nib" => "required|unique:companies,nib,NULL,id,deleted_at,NULL",
            "name" => "required|string",
            "username" => 'required|unique:users,username,NULL,id',
            'password' => [
                'required',
                'string',
                'min:8', // Minimal 8 karakter
                'max:150', // Maksimal 150 karakter
                'regex:/[A-Z]/', // Harus mengandung huruf besar
                'regex:/[a-z]/', // Harus mengandung huruf kecil
                'regex:/[0-9]/', // Harus mengandung angka
                'regex:/[\W]/',  // Harus mengandung simbol
            ],
            "address" => "required|string",
            "phone_number" =>  [
                'required',
                'regex:/^(628|08)[0-9]{6,13}$/'
            ],
            "email" => "required|email",
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            "service_types" => "required|array",
            "pic_name" => "required|string",
            "pic_phone" => [
                'nullable',
                'regex:/^(628|08)[0-9]{6,13}$/'
            ],
            "company_phone_number" =>  [
                'required',
                'regex:/^(628|08)[0-9]{6,13}$/'
            ],

        ], [
            'password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            'phone_number.regex' => 'Nomor Telepon harus diawali dengan 628 | 08  dan hanya terdiri dari angka.',
            'pic_phone.regex' => 'Nomor Telepon PIC harus diawali dengan 628 | 08  dan hanya terdiri dari angka.',
            'company_phone_number.regex' => 'Nomor Telepon Perusahaan harus diawali dengan 628 | 08 dan hanya terdiri dari angka.',
        ]);

        if($validator->fails()){
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $defaultPassword  = $request->password;
        $username = strtoloweR(str_replace(' ', '', $request->username));

        $company = new Company();
        $company->nib = strip_tags($request->nib);
        $company->address = strip_tags($request->address);
        $company->company_phone_number = strip_tags($request->company_phone_number);
        $company->phone_number = strip_tags($request->phone_number);
        $company->province_id = strip_tags($request->province_id);
        $company->city_id = strip_tags($request->city_id);
        $company->name = strip_tags($request->name);
        $company->pic_name = strip_tags($request->pic_name);
        $company->pic_phone = strip_tags($request->pic_phone ?? "-");
        $company->established = $request->established ?? null;

        $user = new User();
        $user->username = $username;
        $user->password = Hash::make($defaultPassword);
        $user->name = strip_tags($request->name);
        $user->email = strip_tags($request->email);
        $user->is_company = true;
        $user->info_company = $company;
        $user->save();

        $company->user_id = $user->id;
        $company->save();


        foreach ($request->service_types as $val) {
                CompanyServiceType::create([
                    'company_id'     => $company->id,
                    'service_type_id'   => $val,
                ]);
        }

        $token = (string) Str::uuid();
        dispatch(new NotificationEmail($request->email, array(
            'name'                  => strip_tags($request->name),
            'pic_name'              => strip_tags($request->pic_name),
            'nib'                   => strip_tags($request->nib),
            'address'               => strip_tags($request->address),
            'company_phone_number'  => strip_tags($request->company_phone_number),
            'username'              => strip_tags($username),
            'phone_number'          => strip_tags($request->phone_number),
            'default_password'      => strip_tags($defaultPassword),
            'token'                 => $token
        )))->delay(Carbon::now()->addSeconds(3));


        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => 'Berhasil mendaftar.',
            'data'          => $user
        ], HttpStatusCodes::HTTP_OK);
    }

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'nib'               => 'required|unique:companies,nib,NULL,id,deleted_at,NULL',
            'province_id'       => 'required|exists:provinces,id',
            'city_id'           => 'required|exists:cities,id',
            'service_types'     => 'required|array',
            'username'          => 'required|unique:users,username,NULL,id',
            'phone_number'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $settingOss = Setting::where('name', 'oss')->first();

        if(!$settingOss){
            return $this->registerManual($request);
        }

        if($settingOss->value['is_active'] == false){
            return $this->registerManual($request);
        }

        $nibOss = NibOss::where('nib', $request->nib)->first();
        if ($nibOss) {
            $dataNib = $nibOss->data_nib;
        } else {
            $ossController = new OssController();
            $dataNib = $ossController->inqueryNib($request);
            if($dataNib->status() == 200){
                $dataNib = $dataNib->getData()->data;
            } else {
                return $dataNib;
            }
        }
        $companyType = $this->companyType;
        if ($companyType[$dataNib['jenis_perseroan']]) {
            $companyTypeName = $companyType[$dataNib['jenis_perseroan']];
        }
        $companyName    = $companyTypeName .' '. $dataNib['nama_perseroan'];

        $request->merge([
            'name' => $companyName,
            'email' => $dataNib['email_perusahaan'],
            'address' => $dataNib['alamat_perseroan'],
            'company_phone_number'  => $dataNib['nomor_telpon_perseroan'],
            'pic_name'   => $dataNib['penanggung_jwb'][0]['nama_penanggung_jwb'],
            'pic_phone'  => $dataNib['penanggung_jwb'][0]['no_hp_penanggung_jwb'] == "-" ? null : $dataNib['penanggung_jwb'][0]['no_hp_penanggung_jwb'],
        ]);

        return $this->registerManual($request);
    }
}
