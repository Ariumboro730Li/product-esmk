<?php

namespace App\Http\Controllers\UserManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Constants\HttpStatusCodes;
use App\Constants\Applications;
use Illuminate\Support\Str;
use Validator;
use Carbon\Carbon;
// model
use App\Models\MasterApplications as TblMasterApplications;
use App\Models\UserAccountApplications as TblUserAccountApplications;
use App\Models\UserAccountAccessApplication as TblUserAccountAccessApplication;
// helper
use App\Helpers\MDApplication;
// jobs
use App\Jobs\Esmk\NotificationEmail as JobNotificationEmail;

class EsmkController extends Controller
{

    protected $_companyType = [
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
    ];

    public function externalList(Request $term) {
        $validator = Validator::make($term->all(), [
            'page'      => 'required|numeric',
            'limit'     => 'required|numeric|max:50',
            'ascending' => 'required|boolean',
            'search'    => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $query = DB::connection('mysql_esmk')->table('companies')
        ->join('provinces', 'companies.province_id', '=', 'provinces.id')
        ->join('cities', 'companies.city_id', '=', 'cities.id')
        ->select(
            'companies.id',
            'companies.nib',
            'companies.name',
            'companies.username',
            'companies.email',
            'cities.name as city_name',
            'provinces.name as province_name',
            'companies.phone_number',
            'companies.address',
            'companies.pic_name',
            'companies.created_at'
        );

        $query->when($term->search != null, function ($query) use ($term) {
            return $query->where(
                function($query) use($term) {
                  return $query->where('companies.name','like','%'.$term->search.'%')
                  ->orWhere('companies.nib','like','%'.$term->search.'%')
                  ->orWhere('companies.username','like','%'.$term->search.'%')
                  ->orWhere('companies.email','like','%'.$term->search.'%');
            });
        });

        $result = $query->orderBy('companies.created_at','desc')->paginate($term->limit);
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Successfully",
            'data'          => $result->toArray()['data'],
            'pagination'    => [
                'total'        => $result->total(),
                'count'        => $result->count(),
                'per_page'     => $result->perPage(),
                'current_page' => $result->currentPage(),
                'total_pages'  => $result->lastPage()
            ]
        ]);

    }

    public function registerKota(Request $term) {
        $validator = Validator::make($term->all(), [
            'keyword'      => 'nullable|string',
            'province_id'  => 'required|exists:mysql_esmk.provinces,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $query = DB::connection('mysql_esmk')->table('cities')->where('province_id','=',$term->province_id);
        if($term->keyword != null) {
            $query->where('name', 'like', '%'. $term->keyword .'%');
        }
        $result = $query->orderBy('name','asc')->limit(10)->get();
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Successfully",
            'data'          => $result
        ], HttpStatusCodes::HTTP_OK);
    }

    public function registerProvinsi(Request $term) {
        $validator = Validator::make($term->all(), [
            'keyword'      => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $query = DB::connection('mysql_esmk')->table('provinces');
        if($term->keyword != null) {
            $query->where('name', 'like', '%'. $term->keyword .'%');
        }
        $result = $query->orderBy('name','asc')->limit(10)->get();
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Successfully",
            'data'          => $result
        ], HttpStatusCodes::HTTP_OK);
    }

    public function registerJenisPelayanan(Request $term) {
        $validator = Validator::make($term->all(), [
            'keyword'      => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $query = DB::connection('mysql_esmk')->table('service_types');
        if($term->keyword != null) {
            $query->where('name', 'like', '%'. $term->keyword .'%');
        }
        $result = $query->orderBy('name','asc')->get();
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Successfully",
            'data'          => $result
        ], HttpStatusCodes::HTTP_OK);

    }

    public function registerCreate(Request $term) {
        $validator = Validator::make($term->all(), [
            'nib'               => 'required|unique:mysql_esmk.companies,nib,NULL,id,deleted_at,NULL',
            'province_id'       => 'required|exists:mysql_esmk.provinces,id',
            'city_id'           => 'required|exists:mysql_esmk.cities,id',
            'service_types.*'   => 'required',
            'username'          => 'required|unique:mysql_esmk.companies,username,NULL,id,deleted_at,NULL',
            'phone_number'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $findNib            = Http::acceptJson()
            ->withHeaders([
                'Authorization' => "Bearer ".env('DATA_INTEGRATION_SERVICE_TOKEN')
            ])->get((string) env('DATA_INTEGRATION_SERVICE_BASE_URL')."/oss/find?nib=".$term->nib)
            ->json();
        if(!isset($findNib['status_code'])) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR,
                'error'         => true,
                'message'       => HttpStatusCodes::getMessageForCode(HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR)
            ], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
        if($findNib['status_code'] != HttpStatusCodes::HTTP_OK) {
            return response()->json($findNib, $findNib['status_code']);
        }

        $defaultPassword    = str_replace("-","",(string) Str::uuid());

        $companyType        = $this->_companyType;
        $companyTypeName    = '';
        if ($companyType[$findNib['data']['jenis_perseroan']]) {
            $companyTypeName = $companyType[$findNib['data']['jenis_perseroan']];
        }
        $companyName    = $companyTypeName .' '. $findNib['data']['nama_perseroan'];

        $token          = (string) Str::uuid();
        DB::connection('mysql_esmk')->table('password_resets')->insert([
            'email'			=> $findNib['data']['email_perusahaan'],
			'token'			=> $token,
			'created_at'	=> Carbon::now()->addHour(1)
        ]);

        $getForgotPassword = DB::connection('mysql_esmk')->table('password_resets')->where('email','=',$findNib['data']['email_perusahaan'])->first();

        $createCompany = DB::connection('mysql_esmk')->table('companies')->insertGetId([
            'name'                  => $companyName,
            'username'              => $term->username,
            'phone_number'          => $term->phone_number,
            'email'                 => $findNib['data']['email_perusahaan'],
            'nib'                   => $term->nib,
            'nib_file'              => '-',
            'province_id'           => $term->province_id,
            'city_id'               => $term->city_id,
            'address'               => $findNib['data']['alamat_perseroan'],
            'company_phone_number'  => $findNib['data']['nomor_telpon_perseroan'],
            'pic_name'              => $findNib['data']['penanggung_jwb'][0]['nama_penanggung_jwb'],
            'pic_phone'             => $findNib['data']['penanggung_jwb'][0]['no_hp_penanggung_jwb'],
            'password'              => bcrypt($defaultPassword),
            'request_date'          => Carbon::now(),
            'established'           => $term->established ?? null
        ]);

        foreach ($term->service_types as $val) {
            DB::connection('mysql_esmk')->table('company_service_types')->insert([
                'company_id'        => $createCompany,
                'service_type_id'   => $val,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);
        }

        MDApplication::required_change_password(
            $term->auth_data->user->id,
            $createCompany,
            'companies',
            Applications::E_SMK
        );

        dispatch(new JobNotificationEmail($findNib['data']['email_perusahaan'], array(
            'name'                  => $companyName,
            'pic_name'              => $findNib['data']['penanggung_jwb'][0]['nama_penanggung_jwb'],
            'nib'                   => $term->nib,
            'address'               => $findNib['data']['alamat_perseroan'],
            'company_phone_number'  => $findNib['data']['nomor_telpon_perseroan'],
            'username'              => $term->username,
            'phone_number'          => $term->phone_number,
            'default_password'      => $defaultPassword,
            'token'                 => $token
        )))->delay(Carbon::now()->addSeconds(3));

        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Permintaan akun perusahaan berhasil dibuat, silahkan cek email anda untuk aktifasi akun."
        ], HttpStatusCodes::HTTP_OK);

    }

    public function registerNibFind(Request $term) {
        $validator = Validator::make($term->all(), [
            'nib'           => 'required|string'
        ],[
            'nib.required'  => 'NIB dibutuhkan.'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $checkNIBExist = DB::connection('mysql_esmk')->table('companies')->where('nib','=',$term->nib)->first();
        if($checkNIBExist) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => "Perusahaan telah terdaftar e-SMK"
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $getNIB = Http::acceptJson()
            ->withHeaders([
                'Authorization' => "Bearer ".env('DATA_INTEGRATION_SERVICE_TOKEN')
            ])->get((string) env('DATA_INTEGRATION_SERVICE_BASE_URL')."/oss/find?nib=".$term->nib)
            ->json();
        if(!isset($getNIB['status_code'])) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR,
                'error'         => true,
                'message'       => HttpStatusCodes::getMessageForCode(HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR)
            ], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
        if($getNIB['status_code'] != HttpStatusCodes::HTTP_OK) {
            return response()->json($getNIB, $getNIB['status_code']);
        }
        $companyHasKbli = $getNIB['data']['data_proyek'];
        $allowedKbli    = DB::connection('mysql_esmk')->table('standard_industrial_classifications')->get()->pluck('kbli')->toArray();
        $isValidKbli    = false;
        for ($i = 0; $i < count($companyHasKbli); $i++) {
            if (in_array($companyHasKbli[$i]['kbli'], $allowedKbli)) {
                $isValidKbli = true;
                break;
            }
        }
        if (!$isValidKbli) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => 'NIB tidak memiliki KBLI yang wajib mempunyai e-SMK'
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        return response()->json($getNIB, $getNIB['status_code']);

    }

    public function active(Request $term) {
        $validator = Validator::make($term->all(), [
            'id_user'           => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $find = DB::connection('mysql_esmk')->table('users')->where('id','=',$term->id_user)->first();
        if($find) {
            DB::connection('mysql_esmk')->table('users')->where('id','=',$term->id_user)->update([
                'is_active' => true
            ]);
            $check = TblUserAccountApplications::where('code_name_application','=',Applications::E_SMK)->where('table_relation_application','=','users')
            ->where('id_user_relation_application','=',$term->id_user)->first();
            if($check) {
                $find_account = (array) DB::connection('mysql_esmk')->table('users')->where('id','=',$term->id_user)->first();
                unset($find_account['password']);
                TblUserAccountApplications::where('code_name_application','=',Applications::E_SMK)->where('table_relation_application','=','users')->where('id_user_relation_application','=',$term->id_user)
                ->update([
                    'data_user'     => $find_account,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            }
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_OK,
                'error'         => false,
                'message'       => "Berhasil aktifkan user."
            ], HttpStatusCodes::HTTP_OK);
        }
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
            'error'         => true,
            'message'       => "Data tidak ditemukan."
        ], HttpStatusCodes::HTTP_BAD_REQUEST);
    }

    public function inactive(Request $term) {
        $validator = Validator::make($term->all(), [
            'id_user'           => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $find = DB::connection('mysql_esmk')->table('users')->where('id','=',$term->id_user)->first();
        if($find) {
            DB::connection('mysql_esmk')->table('users')->where('id','=',$term->id_user)->update([
                'is_active' => false
            ]);
            $check = TblUserAccountApplications::where('code_name_application','=',Applications::E_SMK)->where('table_relation_application','=','users')
            ->where('id_user_relation_application','=',$term->id_user)->first();
            if($check) {
                $find_account = (array) DB::connection('mysql_esmk')->table('users')->where('id','=',$term->id_user)->first();
                unset($find_account['password']);
                TblUserAccountApplications::where('code_name_application','=',Applications::E_SMK)->where('table_relation_application','=','users')->where('id_user_relation_application','=',$term->id_user)
                ->update([
                    'data_user'     => $find_account,
                    'updated_at'    => date('Y-m-d H:i:s')
                ]);
            }
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_OK,
                'error'         => false,
                'message'       => "Berhasil nonaktifkan user."
            ], HttpStatusCodes::HTTP_OK);
        }
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
            'error'         => true,
            'message'       => "Data tidak ditemukan."
        ], HttpStatusCodes::HTTP_BAD_REQUEST);
    }

    public function workUnit(Request $term) {
        $data = DB::connection('mysql_esmk')->table('work_units')
        ->select('id','name')
        ->orderBy('id','asc')
        ->get();
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Successfully",
            'data'          => $data
        ], HttpStatusCodes::HTTP_OK);
    }

    public function roleList(Request $term) {
        $data = DB::connection('mysql_esmk')->table('roles')
        ->select('id','name as role')
        ->orderBy('id','asc')
        ->get();
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Successfully",
            'data'          => $data
        ], HttpStatusCodes::HTTP_OK);
    }

    public function update(Request $term) {
        $validator = Validator::make($term->all(), [
            'id_user'           => 'required|exists:mysql_esmk.users,id',
            'id_role'           => 'required|exists:mysql_esmk.roles,id',
            'name'              => 'required|string',
            'username'          => 'required|string|unique:mysql_esmk.users,username,'.$term->id_user,
            'email'             => 'required|string|email|unique:mysql_esmk.users,email,'.$term->id_user,
            'nip'               => 'required|string|unique:mysql_esmk.users,nip,'.$term->id_user,
            // 'work_unit_id'      => 'required|exists:mysql_esmk.work_units,id',
            'password'          => 'nullable|string|max:150'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $timeNow = date('Y-m-d H:i:s');
        if($term->password == null) {
            DB::connection('mysql_esmk')->table('users')->where('id','=',$term->id_user)->update([
                'name'              => $term->name,
                'nip'               => $term->nip,
                'username'          => $term->username,
                'email'             => $term->email,
                'work_unit_id'      => 1,
                'updated_at'        => $timeNow
            ]);

        } else {
            DB::connection('mysql_esmk')->table('users')->where('id','=',$term->id_user)->update([
                'name'              => $term->name,
                'nip'               => $term->nip,
                'username'          => $term->username,
                'email'             => $term->email,
                'password'          => bcrypt($term->password),
                'work_unit_id'      => 1,
                'updated_at'        => $timeNow
            ]);
        }

        $hasRole = DB::connection('mysql_esmk')->table('model_has_roles')->where('model_id','=',$term->id_user)->first();
        if($hasRole) {
            DB::connection('mysql_esmk')->table('model_has_roles')->where('model_id','=',$term->id_user)->delete();
        }

        DB::connection('mysql_esmk')->table('model_has_roles')->insert([
            'role_id'          => $term->id_role,
            'model_type'       => "App\Models\User",
            'model_id'         => $term->id_user
        ]);

        $check = TblUserAccountApplications::where('code_name_application','=',Applications::E_SMK)->where('table_relation_application','=','users')
        ->where('id_user_relation_application','=',$term->id_user)->first();
        if($check) {
            $find_account = (array) DB::connection('mysql_esmk')->table('users')->where('id','=',$term->id_user)->first();
            unset($find_account['password']);
            TblUserAccountApplications::where('code_name_application','=',Applications::E_SMK)->where('table_relation_application','=','users')->where('id_user_relation_application','=',$term->id_user)
            ->update([
                'data_user'     => $find_account,
                'updated_at'    => date('Y-m-d H:i:s')
            ]);
        }
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => 'Berhasil memperbaharui akun.'
        ], HttpStatusCodes::HTTP_OK);

    }

    public function add(Request $term) {
        $validator = Validator::make($term->all(), [
            'id_role'           => 'required|exists:mysql_esmk.roles,id',
            'name'              => 'required|string',
            'username'          => 'required|string|unique:mysql_esmk.users,username',
            'email'             => 'required|string|email|unique:mysql_esmk.users,email',
            'nip'               => 'required|string|unique:mysql_esmk.users,nip',
            // 'work_unit_id'      => 'required|exists:mysql_esmk.work_units,id',
            'password'          => 'required|string|max:150'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $timeNow = date('Y-m-d H:i:s');
        $create = DB::connection('mysql_esmk')->table('users')->insertGetId([
            'name'              => $term->name,
            'nip'               => $term->nip,
            'username'          => $term->username,
            'email'             => $term->email,
            'email_verified_at' => $timeNow,
            'password'          => bcrypt($term->password),
            'is_ministry'       => true,
            'is_active'         => true,
            'work_unit_id'      => 1,
            'created_at'        => $timeNow,
            'updated_at'        => $timeNow
        ]);

        DB::connection('mysql_esmk')->table('model_has_roles')->insert([
            'role_id'          => $term->id_role,
            'model_type'       => "App\Models\User",
            'model_id'         => $create
        ]);

        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Berhasil menambahkan akun baru."
        ], HttpStatusCodes::HTTP_OK);
    }

    public function list(Request $term) {
        $validator = Validator::make($term->all(), [
            'page'      => 'required|numeric',
            'limit'     => 'required|numeric|max:50',
            'ascending' => 'required|boolean',
            'search'    => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $query = DB::connection('mysql_esmk')->table('users')->select(
            'users.id',
            'users.name',
            'users.email',
            'users.username',
            'users.is_active',
            'users.nip',
            'roles.id as role_id',
            'roles.name as role_name',
            'work_units.id as work_unit_id',
            'work_units.name as work_unit_name',
            'work_units.province_id as province_id',
            'work_units.city_id as city_id',
            'users.created_at'
        )
        ->join('model_has_roles','users.id', '=', 'model_has_roles.model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->join('work_units', 'work_units.id', 'work_unit_id');

        $query->when($term->id_role != null, function($query) use($term) {
            return $query->where('roles.id','=',$term->id_role);
        });
        $query->when($term->search != null, function ($query) use ($term) {
            return $query->where(
                function($query) use($term) {
                  return $query->where('users.email','like','%'.$term->search.'%')
                  ->orWhere('users.name','like','%'.$term->search.'%')
                  ->orWhere('users.username','like','%'.$term->search.'%');
            });
        });

        $result = $query->orderBy('users.created_at','desc')->paginate($term->limit);
        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Successfully",
            'data'          => $result->toArray()['data'],
            'pagination'    => [
                'total'        => $result->total(),
                'count'        => $result->count(),
                'per_page'     => $result->perPage(),
                'current_page' => $result->currentPage(),
                'total_pages'  => $result->lastPage()
            ]
        ]);
    }

}
