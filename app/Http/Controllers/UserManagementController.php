<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Constants\HttpStatusCodes;
use App\Models\Company;

class UserManagementController extends Controller
{
    public function list(Request $term)
    {
        $validator = Validator::make($term->all(), [
            'page'      => 'required|numeric',
            'limit'     => 'required|numeric|max:50',
            'ascending' => 'required|boolean',
            'search'    => 'nullable|string',
            'id_role'   => 'nullable|exists:roles,id'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // $query = User::select(
        //     'users.id',
        //     'users.name as name',
        //     'users.email',
        //     'users.username',
        //     'users.is_active',
        //     'users.nip',
        //     'roles.id as role_id',
        //     // 'roles.name as role_name',
        //     DB::raw('case when roles.name is null then "Perusahaan" else roles.name end as role_name'),
        //     'users.created_at'
        // )
        //     ->leftjoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        //     ->leftjoin('roles', 'model_has_roles.role_id', '=', 'roles.id');
        //     $query->where('roles.name', '!=', 'Perusahaan');

        $query = User::select(
            'users.id',
            'users.name as name',
            'users.email',
            'users.username',
            'users.is_active',
            'users.nip',
            'roles.id as role_id',
            DB::raw('case when roles.name is null then "Perusahaan" else roles.name end as role_name'),
        )
            ->leftjoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftjoin('roles', 'model_has_roles.role_id', '=', 'roles.id');
        $query->when($term->id_role != null, function ($query) use ($term) {
            return $query->where('roles.id', '=', $term->id_role);
        });
        $query->when($term->search != null, function ($query) use ($term) {
            return $query->where(
                function ($query) use ($term) {
                    return $query->where('users.email', 'like', '%' . $term->search . '%')
                        ->orWhere('users.name', 'like', '%' . $term->search . '%')
                        ->orWhere('users.username', 'like', '%' . $term->search . '%');
                }
            );
        });

        $result = $query->orderBy('users.created_at', 'desc')->paginate($term->limit);
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

    public function store(Request $term)
    {
        $validator = Validator::make($term->all(), [
            'id_role'           => 'required|exists:roles,id',
            'name'              => 'required|string',
            'username'          => 'required|string|unique:users,username',
            'email'             => 'required|string|email|unique:users,email',
            'nip'               => 'required|string|unique:users,nip',
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
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $timeNow = date('Y-m-d H:i:s');
        $username = strtolower(str_replace(' ', '', $term->username));
        $create = User::create([
            'name'        => strip_tags($term->name),
            'nip'               => strip_tags($term->nip),
            'username'          => strip_tags($username),
            'email'             => strip_tags($term->email),
            'email_verified_at' => $timeNow,
            'password'          => bcrypt($term->password),
            'is_active'         => true,
            'created_at'        => $timeNow,
            'updated_at'        => $timeNow
        ]);

        DB::table('model_has_roles')->insert([
            'role_id'          => $term->id_role,
            'model_type'       => 'App\Models\User',
            'model_id'         => $create->id
        ]);

        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => "Berhasil menambahkan akun baru."
        ], HttpStatusCodes::HTTP_OK);
    }

    public function active(Request $term)
    {
        $validator = Validator::make($term->all(), [
            'id_user' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'       => true,
                'message'     => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Cari user berdasarkan id
        $user = User::where('id', $term->id_user)->first();
        // Cari company berdasarkan user_id
        $company = Company::where('user_id', $term->id_user)->first();

        if ($user) {
            // Update `is_active` di tabel users
            $user->update(['is_active' => true]);

            // Update `is_active` di tabel companies jika ditemukan
            if ($company) {
                $company->update(['is_active' => true]);
            }

            return response()->json([
                'status_code' => HttpStatusCodes::HTTP_OK,
                'error'       => false,
                'message'     => "Berhasil mengaktifkan user dan perusahaan."
            ], HttpStatusCodes::HTTP_OK);
        }

        return response()->json([
            'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            'error'       => true,
            'message'     => "Data user tidak ditemukan."
        ], HttpStatusCodes::HTTP_BAD_REQUEST);
    }

    public function inactive(Request $term)
    {
        $validator = Validator::make($term->all(), [
            'id_user' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'       => true,
                'message'     => $validator->errors()->first()
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        // Cari user berdasarkan id
        $user = User::where('id', $term->id_user)->first();
        // Cari company berdasarkan user_id
        $company = Company::where('user_id', $term->id_user)->first();

        if ($user) {
            // Update `is_active` di tabel users
            $user->update(['is_active' => false]);

            // Update `is_active` di tabel companies jika ditemukan
            if ($company) {
                $company->update(['is_active' => false]);
            }

            return response()->json([
                'status_code' => HttpStatusCodes::HTTP_OK,
                'error'       => false,
                'message'     => "Berhasil mengaktifkan user dan perusahaan."
            ], HttpStatusCodes::HTTP_OK);
        }

        return response()->json([
            'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            'error'       => true,
            'message'     => "Data user tidak ditemukan."
        ], HttpStatusCodes::HTTP_BAD_REQUEST);
    }

    // public function inactive(Request $term)
    // {
    //     $validator = Validator::make($term->all(), [
    //         'id_user' => 'required'
    //     ]);
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
    //             'error'         => true,
    //             'message'       => $validator->errors()->all()[0]
    //         ], HttpStatusCodes::HTTP_BAD_REQUEST);
    //     }
    //     $find = User::where('id', '=', $term->id_user)->first();
    //     if ($find) {
    //         User::where('id', '=', $term->id_user)->update([
    //             'is_active' => false
    //         ]);
    //         return response()->json([
    //             'status_code'   => HttpStatusCodes::HTTP_OK,
    //             'error'         => false,
    //             'message'       => "Berhasil nonaktifkan user."
    //         ], HttpStatusCodes::HTTP_OK);
    //     }

    //     return response()->json([
    //         'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
    //         'error'         => true,
    //         'message'       => "Data tidak ditemukan."
    //     ], HttpStatusCodes::HTTP_BAD_REQUEST);
    // }

    public function update(Request $term)
    {
        $validator = Validator::make($term->all(), [
            'id_user'           => 'required|exists:users,id',
            'id_role'           => 'nullable|exists:roles,id',
            'name'              => 'required|string',
            'username'          => 'required|string|unique:users,username,' . $term->id_user,
            'email'             => 'required|string|email|unique:users,email,' . $term->id_user,
            'nip'               => 'nullable|string|unique:users,nip,' . $term->id_user,
            'password' => [
                'nullable', // Password tidak wajib diisi
                'string',
                'min:8', // Minimal 8 karakter
                'max:150', // Maksimal 150 karakter
                'regex:/[A-Z]/', // Harus mengandung huruf besar
                'regex:/[a-z]/', // Harus mengandung huruf kecil
                'regex:/[0-9]/', // Harus mengandung angka
                'regex:/[\W]/',  // Harus mengandung simbol
            ],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $timeNow = date('Y-m-d H:i:s');
        if ($term->password == null) {
            User::where('id', '=', $term->id_user)->update([
                'name'              => $term->name,
                'nip'               => $term->nip,
                'username'          => $term->username,
                'email'             => $term->email,
                'updated_at'        => $timeNow
            ]);
        } else {
            User::where('id', '=', $term->id_user)->update([
                'name'              => $term->name,
                'nip'               => $term->nip,
                'username'          => $term->username,
                'email'             => $term->email,
                'password'          => bcrypt($term->password),
                'updated_at'        => $timeNow
            ]);
        }

        $hasRole = DB::table('model_has_roles')->where('model_id', '=', $term->id_user)->first();
        if ($hasRole) {
            DB::table('model_has_roles')->where('model_id', '=', $term->id_user)->delete();
        }

        DB::table('model_has_roles')->insert([
            'role_id'          => $term->id_role,
            'model_type'       => 'App\Models\User',
            'model_id'         => $term->id_user
        ]);

        return response()->json([
            'status_code'   => HttpStatusCodes::HTTP_OK,
            'error'         => false,
            'message'       => 'Berhasil memperbaharui akun.'
        ], HttpStatusCodes::HTTP_OK);
    }

    public function updateAkunInternal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|exists:users,email",
            "old_password" => "required",
            'password' => [
                'required',
                'string',
                'min:8', // Minimal 8 karakter
                'max:150', // Maksimal 150 karakter
                'regex:/[A-Z]/', // Harus mengandung huruf besar
                'regex:/[a-z]/', // Harus mengandung huruf kecil
                'regex:/[0-9]/', // Harus mengandung angka
                'regex:/[\W]/',  // Harus mengandung simbol
            ]
        ], [
            'email.required' => 'Email pengguna dibutuhkan',
            'email.exists' => 'Email Pengguna tidak ditemukan',
            'old_password.required' => "Kata sandi lama tidak boleh kososng",
            'password.required' => 'Kata sandi baru tidak boleh kosong',
            'password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan simbol.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email)->first();
        if (!\Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status_code'  => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error' => true,
                'message' => 'Password tidak sesuai.'
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $defaultPassword = $request->password;
        $user->password = Hash::make(value: $defaultPassword);
        $user->save();

        return response()->json([
            'status_code'  => HttpStatusCodes::HTTP_OK,
            'error' => false,
            'message' => 'Berhasil mengubah data.'
        ], HttpStatusCodes::HTTP_OK);
    }


    public function updateAkunCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|exists:users,email",
            "old_password" => "required",
            'password' => [
                'required',
                'string',
                'min:8',
                'max:150',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[\W]/',
            ]
        ], [
            'email.required' => 'Email pengguna dibutuhkan',
            'email.exists' => 'Email Pengguna tidak ditemukan',
            'old_password.required' => "Kata sandi lama tidak boleh kososng",
            'password.required' => 'Kata sandi baru tidak boleh kosong',
            'password.min' => 'Kata sandi harus memiliki minimal 8 karakter.',
            'password.regex' => 'Kata sandi harus mengandung huruf besar, huruf kecil, angka, dan simbol.'
        ]);



        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'message' => $validator->errors()->first(),
                'status_code' => HttpStatusCodes::HTTP_BAD_REQUEST,
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email)->first();
        if (!\Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status_code'  => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error' => true,
                'message' => 'Password tidak sesuai.'
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }
        $defaultPassword = $request->password;
        $user->password = Hash::make(value: $defaultPassword);
        $user->save();

        return response()->json([
            'status_code'  => HttpStatusCodes::HTTP_OK,
            'error' => false,
            'message' => 'Berhasil mengubah data.'
        ], HttpStatusCodes::HTTP_OK);
    }
}
