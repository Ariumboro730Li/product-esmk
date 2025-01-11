<?php

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\MasterData\CityController;
use App\Http\Controllers\MasterData\ProvinceController;
use App\Http\Controllers\OssController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UploadFileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::fallback(function () {
    return response()->json([
        'status_code'  => HttpStatusCodes::HTTP_NOT_FOUND,
        'error'   => true,
        'message' => 'URL Not Found'
    ], HttpStatusCodes::HTTP_NOT_FOUND);
});

Route::get('/healthz', function () {
    return 1;
});

Route::post('auth/login', [AuthController::class, 'login']);
Route::post('auth/register', [RegisterController::class, 'register']);
Route::post('auth/reset-password', [ForgotPasswordController::class, 'reset']);
Route::post('auth/forgot-password', [ForgotPasswordController::class, 'forgot']);

Route::controller(AuthController::class)->group(function () {
    Route::group(['prefix' => 'service-type'], function () {
        Route::get('/list', 'serviceType');
    });
});

Route::controller(ProvinceController::class)->group(function () {
    Route::group(['prefix' => 'provinsi'], function () {
        Route::get('/list', 'index');
    });
});

//citiees
Route::controller(CityController::class)->group(function () {
    Route::group(['prefix' => 'kota'], function () {
        Route::get('/list', 'index');
    });
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('test', function () {
        return response()->json([
            'status_code'  => HttpStatusCodes::HTTP_OK,
            'error'   => false,
            'message' => 'Welcome to ESMK API'
        ], HttpStatusCodes::HTTP_OK);
    });

    Route::post('file/upload', [FileController::class, 'uploadFile']);
});
Route::get('oss/inquery-nib', [OssController::class, 'inqueryNib']);
Route::get('setting/find', [SettingController::class, 'get']);

