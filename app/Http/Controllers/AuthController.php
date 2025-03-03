<?php

namespace App\Http\Controllers;

use App\Constants\HttpStatusCodes;
use App\Models\Company;
use App\Models\ServiceType;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email'                 => 'required|string',
            'password'              => 'required|string',
            'remember_me'           => 'boolean'
        ],[
            'email.required'        => 'Email atau Username harus diisi.',
            'password.required'     => 'Kata sandi harus diisi.'
        ]);

        if($validator->fails()){
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => $validator->errors()->all()[0]
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        $user = User::where('email', $request->email)->first();
        if(!$user){
            $request->merge([
                'username' => $request->email
            ]);
            $user = User::where('username', $request->email)->first();
        }

        if (!$user) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_BAD_REQUEST,
                'error'         => true,
                'message'       => 'Username tidak terdaftar.'
            ], HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        if (!\Hash::check($request->password, $user->password)) {
            return response()->json([
                'status_code'  => HttpStatusCodes::HTTP_UNAUTHORIZED,
                'error' => true,
                'message' => 'Kata sandi salah.'
            ], HttpStatusCodes::HTTP_UNAUTHORIZED);
        }

        if($request->username){
            $credentials = $request->only('username', 'password');
        } else {
            $credentials = $request->only('email', 'password');
        }

        $remember = $request->remember_me ? true : false;
        Auth::attempt($credentials, $remember);

        if (!auth()->attempt($credentials)) {
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR,
                'error'         => true,
                'message'       => 'Terjadi kesalahan saat mencoba login.'
            ], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR); // 500 untuk error server
        }

        if(!$user->is_active){
            Auth::logout();
            return response()->json([
                'status_code'   => HttpStatusCodes::HTTP_UNAUTHORIZED,
                'error'         => true,
                'message'       => 'Akun anda dinonaktifkan, silahkan hubungi admin.'
            ], HttpStatusCodes::HTTP_UNAUTHORIZED); // 401 untuk unauthorized
        }

        // // Buat payload untuk token
        return response()->json([
            'error'     => false,
            'message'   => 'Login berhasil.',
            'user'      => $user,
        ], 200);

    }
    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'status_code' => 200,
            'error' => false,
            'message' => 'Logout berhasil. Token telah dihapus.',
        ], 200);
    }

    public function serviceType(Request $request) : JsonResponse
    {
        // Validasi input request
        $validator = Validator::make($request->all(), [
            'limit' => 'required|numeric|max:50',
            'ascending' => 'required|boolean',
            'search' => 'nullable|string',
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

        $query = ServiceType::orderBy('created_at', $meta['orderBy']);


        if ($request->search !== null) {
            $query->where(function($query) use ($request) {
                $columns = ['name'];
                foreach ($columns as $column) {
                    $query->orWhereRaw("LOWER({$column}) LIKE ?", ["%" . strtolower(trim($request->search)) . "%"]);
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
}
