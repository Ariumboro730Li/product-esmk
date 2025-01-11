<?php

use App\Constants\HttpStatusCodes;
use App\Http\Controllers\OssController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MasterData\CityController;
use App\Http\Controllers\MasterData\DirJenController;
use App\Http\Controllers\Internal\PerusahaanController;
use App\Http\Controllers\MasterData\ProvinceController;
use App\Http\Controllers\MasterData\WorkUnitController;
use App\Http\Controllers\Internal\YearlyReportController;
use App\Http\Controllers\MasterData\SmkElementController;
use App\Http\Controllers\Internal\LaporanTahunanController;
use App\Http\Controllers\Internal\JadwalInterviewController;
use App\Http\Controllers\Internal\HistoryPengajuanController;
use App\Http\Controllers\Internal\PengesahanDokumenController;
use App\Http\Controllers\Internal\DisposisiPengajuanController;
use App\Http\Controllers\Internal\PenilaianPengajuanController;
use App\Http\Controllers\MasterData\MonitoringElementController;
use App\Http\Controllers\Internal\PengajuanSMKPerusahaanController;
use App\Http\Controllers\Company\DashboardController as CompanyDashboardController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Internal\BeritaAcaraController;
use App\Http\Controllers\Internal\RoleController;
use App\Http\Controllers\Internal\SignerController;
use App\Http\Controllers\MasterData\AssessorController;
use App\Http\Controllers\MasterData\MasterKbliController;
use App\Http\Controllers\MasterData\SkNumberController;
use App\Jobs\YearlyReportEmail;

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


Route::get('admin-panel/smk-element/list', [SmkElementController::class, 'index']);
Route::get('admin-panel/smk-element/status', [SmkElementController::class, 'status']);
Route::get('admin-panel/smk-element/detail', [SmkElementController::class, 'detail']);
Route::post('admin-panel/smk-element/create', [SmkElementController::class, 'store']);
Route::post('admin-panel/smk-element/destroy', [SmkElementController::class, 'destroy']);
Route::get('admin-panel/smk-element/get-smk-element', [SmkElementController::class, 'smkElement']);

Route::get('admin-panel/monitoring-element/list', [MonitoringElementController::class, 'index']);
Route::get('admin-panel/monitoring-element/detail', [MonitoringElementController::class, 'show']);
Route::post('admin-panel/monitoring-element/create', [MonitoringElementController::class, 'store']);
Route::post('admin-panel/monitoring-element/destroy', [MonitoringElementController::class, 'destroy']);
Route::get('admin-panel/monitoring-element/status', [MonitoringElementController::class, 'status']);

Route::get('admin-panel/provinsi/list', [ProvinceController::class, 'index']);
Route::post('admin-panel/provinsi/store', [ProvinceController::class, 'store']);
Route::post('admin-panel/provinsi/update', [ProvinceController::class, 'update']);
Route::post('admin-panel/provinsi/edit', [ProvinceController::class, 'edit']);
Route::post('admin-panel/provinsi/destroy', [ProvinceController::class, 'destroy']);

Route::get('admin-panel/kota/list', [CityController::class, 'index']);
Route::post('admin-panel/kota/store', [CityController::class, 'store']);
Route::post('admin-panel/kota/update', [CityController::class, 'update']);
Route::post('admin-panel/kota/edit', [CityController::class, 'edit']);
Route::post('admin-panel/kota/destroy', [CityController::class, 'destroy']);
Route::get('admin-panel/kota/select2', [CityController::class, 'select2']);

Route::get('admin-panel/direktur-jendral/list', [DirJenController::class, 'index']);
Route::get('admin-panel/direktur-jendral/edit', [DirJenController::class, 'edit']);
Route::get('admin-panel/direktur-jendral/detail', [DirJenController::class, 'show']);
Route::post('admin-panel/direktur-jendral/create', [DirJenController::class, 'create']);
Route::get('admin-panel/direktur-jendral/filterUser', [DirJenController::class, 'filterUserDipilih']);
Route::get('admin-panel/direktur-jendral/filterUserEdit', [DirJenController::class, 'filterUser']);
Route::post('admin-panel/direktur-jendral/store', [DirJenController::class, 'store']);
Route::post('admin-panel/direktur-jendral/update', [DirJenController::class, 'update']);
Route::post('admin-panel/direktur-jendral/destroy', [DirJenController::class, 'destroy']);
Route::get('admin-panel/direktur-jendral/listUser', [DirJenController::class, 'listUser']);
Route::get('admin-panel/direktur-jendral/inactive', [DirJenController::class, 'disable']);
Route::get('admin-panel/direktur-jendral/active', [DirJenController::class, 'enable']);

// Route::get('admin-panel/satuan-kerja/list', [WorkUnitController::class, 'index']);
// Route::get('admin-panel/satuan-kerja/inactive', [WorkUnitController::class, 'disable']);
// Route::get('admin-panel/satuan-kerja/active', [WorkUnitController::class, 'enable']);
// Route::get('admin-panel/satuan-kerja/province', [WorkUnitController::class, 'province']);
// Route::get('admin-panel/satuan-kerja/service', [WorkUnitController::class, 'service']);
// Route::get('admin-panel/satuan-kerja/city', [WorkUnitController::class, 'city']);
// Route::post('admin-panel/satuan-kerja/store', [WorkUnitController::class, 'store']);
// Route::get('admin-panel/satuan-kerja/edit', [WorkUnitController::class, 'edit']);
// Route::post('admin-panel/satuan-kerja/update', [WorkUnitController::class, 'update']);
// Route::post('admin-panel/satuan-kerja/destroy', [WorkUnitController::class, 'destroy']);

Route::get('admin-panel/sk-number/list', [SkNumberController::class, 'index']);
Route::post('admin-panel/sk-number/store', [SkNumberController::class, 'store']);
Route::post('admin-panel/sk-number/destroy', [SkNumberController::class, 'destroy']);
Route::post('admin-panel/sk-number/update', [SkNumberController::class, 'update']);
Route::get('admin-panel/sk-number/status', [SkNumberController::class, 'status']);

Route::get('admin-panel/master-kbli/list', [MasterKbliController::class, 'index']);
Route::post('admin-panel/master-kbli/store', [MasterKbliController::class, 'store']);
Route::post('admin-panel/master-kbli/destroy', [MasterKbliController::class, 'destroy']);
Route::post('admin-panel/master-kbli/update', [MasterKbliController::class, 'update']);

Route::get('admin-panel/dashboard/listCompany', [DashboardController::class, 'getListCompany']);
Route::get('admin-panel/dashboard/listCertificat', [DashboardController::class, 'getCertifikatRequest']);
Route::get('admin-panel/dashboard/listServiceTypes', [DashboardController::class, 'getServiceTypes']);
Route::get('admin-panel/dashboard/ListYearlyReport', [DashboardController::class, 'getYearlyReport']);
Route::get('admin-panel/dashboard/ListYearlyReports', [DashboardController::class, 'getYearly']);
Route::get('admin-panel/dashboard/ListAllCompany', [DashboardController::class, 'getAllListCompany']);
Route::get('admin-panel/dashboard/dataDashboard', [DashboardController::class, 'getDataDashboard']);
Route::get('admin-panel/dashboard/userDetail', [DashboardController::class, 'getUserDetails']);
Route::get('admin-panel/dashboard/listAsesor', [DashboardController::class, 'getListAssesor']);
Route::get('admin-panel/dashboard/listYearly', [DashboardController::class, 'yearlyReport']);
Route::get('admin-panel/dashboard/totalPenilaian', [DashboardController::class, 'totalPenilaian']);
Route::get('admin-panel/dashboard/data', [DashboardController::class, 'data']);

Route::get('admin-panel/perusahaan/list', [PerusahaanController::class, 'index']);
Route::get('admin-panel/perusahaan/detail', [PerusahaanController::class, 'show']);
Route::get('admin-panel/perusahaan/province', [PerusahaanController::class, 'province']);
Route::get('admin-panel/perusahaan/service', [PerusahaanController::class, 'service']);
Route::get('admin-panel/perusahaan/pengajuan', [PerusahaanController::class, 'getPengajuan']);
Route::get('admin-panel/perusahaan/laporan', [PerusahaanController::class, 'getLaporanTahunan']);
Route::get('admin-panel/perusahaan/kbli', [PerusahaanController::class, 'getCompanyKBLI']);
Route::get('admin-panel/perusahaan/countService', [PerusahaanController::class, 'countServiceType']);
Route::get('admin-panel/perusahaan/countPerusahaan', [PerusahaanController::class, 'countPerusahaan']);

Route::get('admin-panel/laporan-tahunan/list', [YearlyReportController::class, 'index']);
Route::post('admin-panel/laporan-tahunan/store', [YearlyReportController::class, 'store']);
Route::get('admin-panel/laporan-tahunan/detail', [YearlyReportController::class, 'show']);
Route::get('admin-panel/laporan-tahunan/getView', [YearlyReportController::class, 'getFileUrlToBase64']);
Route::post('admin-panel/laporan-tahunan/update', [YearlyReportController::class, 'update']);
Route::get('admin-panel/laporan-tahunan/countData', [YearlyReportController::class, 'countData']);

Route::get('admin-panel/signer', [SignerController::class, 'index']);
Route::get('admin-panel/assessor-list', [AssessorController::class, 'index']);
Route::post('admin-panel/upload-file', [FileController::class, 'uploadFile']);


Route::get('admin-panel/pengajuan-sertifikat/countSubmission', [PengajuanSMKPerusahaanController::class, 'totalPenilaian']);
Route::get('admin-panel/pengajuan-sertifikat/list', [PengajuanSMKPerusahaanController::class, 'index']);
Route::get('admin-panel/pengajuan-sertifikat/detail', [PengajuanSMKPerusahaanController::class, 'detail']);
Route::post('admin-panel/pengajuan-sertifikat/update', [PengajuanSMKPerusahaanController::class, 'update']);
Route::get('admin-panel/pengajuan-sertifikat/serviceType', [PengajuanSMKPerusahaanController::class, 'serviceType']);
Route::get('admin-panel/pengajuan-sertifikat/history', [HistoryPengajuanController::class, 'getRequestHistoryByRequestID']);
Route::post('admin-panel/pengajuan-sertifikat/store-assesment', [PenilaianPengajuanController::class, 'store']);
Route::post('admin-panel/pengajuan-sertifikat/record-of-verification', [BeritaAcaraController::class, 'create']);
Route::get('admin-panel/pengajuan-sertifikat/show-record-of-vertification', [BeritaAcaraController::class, 'showRecordOfVerification']);
Route::post('admin-panel/pengesahan-sertifikat/certificate-release', [PengesahanDokumenController::class, 'createCertificateRelease']);
Route::get('admin-panel/pengesahan-sertifikat/generate-sk', [PengesahanDokumenController::class, 'getGenerateSK']);
Route::get('admin-panel/pengesahan-sertifikat/generate-official-report', [PengesahanDokumenController::class, 'print']);
Route::post('admin-panel/jadwal/updateJadwal', [JadwalInterviewController::class, 'update']);
Route::get('admin-panel/jadwal/getJadwal', [JadwalInterviewController::class, 'getJadwalInterview']);
Route::post('admin-panel/jadwal/storeJadwal', [JadwalInterviewController::class, 'storeAssessmentInterview']);


Route::get('admin-panel/permission', [RoleController::class, 'getRoleById']);
Route::get('admin-panel/role-options', [RoleController::class, 'list']);
Route::put('admin-panel/sync-permission', [RoleController::class,  'syncPermissions']);
Route::get('admin-panel/group-permission', [RoleController::class, 'getAndGroupAllPermissions']);
Route::post('admin-panel/role/create', [RoleController::class, 'create']);

Route::get('admin-panel/setting/list', [SettingController::class, 'list']);
Route::get('admin-panel/setting/find', [SettingController::class, 'get']);
Route::get('admin-panel/setting/detail', [SettingController::class, 'get']);
Route::post('admin-panel/setting/oss', [SettingController::class, 'oss']);
Route::post('admin-panel/setting/aplikasi', [SettingController::class, 'aplikasi']);

Route::get('admin-panel/syncOss', [OssController::class, 'syncOssInternal']);

Route::get('admin-panel/user-management/list', [UserManagementController::class, 'list']);
Route::get('admin-panel/user-management/detail', [UserManagementController::class, 'detail']);
Route::post('admin-panel/user-management/add', [UserManagementController::class, 'store']);
Route::get('admin-panel/user-management/active', [UserManagementController::class, 'active']);
Route::get('admin-panel/user-management/inactive', [UserManagementController::class, 'inactive']);
Route::post('admin-panel/user-management/active', [UserManagementController::class, 'active']);
Route::post('admin-panel/user-management/inactive', [UserManagementController::class, 'inactive']);
Route::post('admin-panel/user-management/update', [UserManagementController::class, 'update']);
Route::post('admin-panel/user-management/destroy', [UserManagementController::class, 'destroy']);

Route::put('pengaturan-akun/update', [UserManagementController::class, 'updateAkunInternal']);

