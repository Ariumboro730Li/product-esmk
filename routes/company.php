<?php

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\OssController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\SertifikatSMKController;
use App\Http\Controllers\Company\LaporanTahunanController;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\PengajuanSertifikatController;
use App\Http\Controllers\Company\HistoryPengajuanController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserManagementController;

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


Route::get('documents/submission/detail', [PengajuanSertifikatController::class, 'detail']);
Route::get('documents/submission/index', [PengajuanSertifikatController::class, 'index']);
Route::post('documents/submission/update', [PengajuanSertifikatController::class, 'update']);
Route::post('documents/submission/store', [PengajuanSertifikatController::class, 'store']);
Route::get('documents/submission/active-submmision', [PengajuanSertifikatController::class, 'getCertifiateActive']);
Route::get('documents/submission/history', [HistoryPengajuanController::class, 'getRequestHistoryByRequestID']);
Route::get('documents/certificate', [SertifikatSMKController::class, 'getSmkCertificate']);
Route::get('documents/smk-element', [SertifikatSMKController::class, 'getSmkElement']);
Route::post('documents/upload-file', [FileController::class, 'uploadFile']);

Route::get('dashboard/company/getuser', [DashboardController::class, 'getUserDetails']);
Route::get('dashboard/company/perusahaan', [DashboardController::class, 'perusahaan']);
Route::get('dashboard/company/getsmk', [DashboardController::class, 'getsmk']);
Route::get('dashboard/certificate', [SertifikatSMKController::class, 'getSmkCertificate']);

Route::get('laporan-tahunan/monitoring-element', [LaporanTahunanController::class, 'index']);
Route::get('laporan-tahunan/detail', [LaporanTahunanController::class, 'show']);
Route::post('laporan-tahunan/store', [LaporanTahunanController::class, 'store']);
Route::post('laporan-tahunan/update', [LaporanTahunanController::class, 'update']);
Route::get('laporan-tahunan/get-monitoring-element', [LaporanTahunanController::class, 'getMonitoringElements']);
Route::get('laporan-tahunan/latest', [LaporanTahunanController::class, 'getLatestReport']);
Route::post('laporan-tahunan/upload-file', [LaporanTahunanController::class, 'uploadFile']);
Route::get('laporan-tahunan/getView', [LaporanTahunanController::class, 'getFileUrlToBase64']);

Route::get('/setting/find', [SettingController::class, 'get']);
Route::get('/syncOss', [OssController::class, 'syncOss']);

Route::put('pengaturan-akun/update', [UserManagementController::class, 'updateAkunCompany']);
