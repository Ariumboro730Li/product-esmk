<?php

use App\Http\Controllers\DashbController;
use App\Http\Middleware\Application;
use App\Http\Middleware\IsLoginMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('auth.login');
});

Route::get('/login', function () {
    return view('login')->with('title', 'Masuk');
})->name('auth.login');

// Route::get('/login', [AuthController::class, 'login'])->middleware('is_guest')->name('auth.login');


Route::get('/register', function () {
    return view('register');
});

Route::get('/forgot-password', function () {
    return view('forgotPassword');
});

Route::get('/change-password', function () {
    return view('change-password');
})->name('forgot.change');

Route::middleware('auth')->group(function () {

    // Route::controller(DashbController::class)->group(function () {
    //     Route::get('/dashboard', 'index')->name('dashboard');
    // });

    Route::middleware('check_role:internal')->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('/dashboard', function () {
                return view('Administrator.dashboard');
            })->name('admin.dashboard');

            Route::get('/provinsi', function () {
                return view('Administrator.MasterData.Wilayah.provinsi');
            });
            Route::get('/kota', function () {
                return view('Administrator.MasterData.Wilayah.kota');
            });

            //kbli
            Route::get('/kbli', function () {
                return view('Administrator.MasterData.KBLI.kbli');
            });
            Route::get('/penandatangan', function () {
                return view('Administrator.MasterData.Penandatangan.direkturJendral');
            });
            Route::get('/nomor-sk', function () {
                return view('Administrator.MasterData.NoBeritaAcara.noSk');
            });

            //satuanKerja
            // Route::get('/satuan-kerja', function () {
            //     return view('Administrator.MasterData.SatuanKerja.satuanKerja');
            // });

            //element
            Route::get('/element-pemantauan/list', function () {
                return view('Administrator.MasterData.Element.ElementPemantauan.list');
            });
            Route::get('/element-pemantauan/create', function () {
                return view('Administrator.MasterData.Element.ElementPemantauan.create');
            });
            Route::get('/element-pemantauan/detail', function () {
                return view('Administrator.MasterData.Element.ElementPemantauan.detail');
            });
            Route::get('/element-smk/list', function () {
                return view('Administrator.MasterData.Element.ElementSmk.list');
            });
            Route::get('/element-smk/create', function () {
                return view('Administrator.MasterData.Element.ElementSmk.create');
            });
            Route::get('/element-smk/detail', function () {
                return view('Administrator.MasterData.Element.ElementSmk.detail');
            });

            //perusahaan
            Route::get('/perusahaan', function () {
                return view('Administrator.Administrasi.Perusahaan.list');
            });
            Route::get('/perusahaan/detail', function () {
                return view('Administrator.Administrasi.Perusahaan.detail');
            });

            // permohonan
            Route::get('/sertifikat/list', function () {
                return view('Administrator.SertifikatSmk.list');
            });
            Route::get('/sertifikat/detail', function () {
                return view('Administrator.SertifikatSmk.detail');
            });

            Route::get('/laporan-tahunan/list', function () {
                return view('Administrator.LaporanTahunan.list');
            });
            Route::get('/laporan-tahunan/detail', function () {
                return view('Administrator.LaporanTahunan.detail');
            });

            //administrasi
            Route::get('/hak-akses', function () {
                return view('Administrator.Administrasi.HakAkses.list');
            });
            Route::get('/user-manajemen', function () {
                return view('Administrator.Administrasi.UserManagement.list');
            });

            //pengaturan
            Route::get('/pengaturan', function () {
                return view('Administrator.Pengaturan.index');
            });
            Route::get('/pengaturan-akun', function () {
                return view('Administrator.Pengaturan.PengaturanAkun.index');
            });
            Route::get('/profil-akun', function () {
                return view('Administrator.ProfilAkun.index');
            });
        });

        Route::prefix('internal')->group(function () {
            Route::get('/dashboard-internal', function () {
                return view('Internal.dashboard');
            });

            Route::get('/perusahaan-internal/list', function () {
                return view('Internal.Perusahaan.list');
            });
            Route::get('/perusahaan-internal/detail', function () {
                return view('Internal.Perusahaan.detail');
            });

            Route::get('/sertifikat/list', function () {
                return view('Internal.SertifikatSmk.list');
            });
            Route::get('/sertifikat/detail', function () {
                return view('Internal.SertifikatSmk.detail');
            });

            Route::get('/laporan-tahunan/list', function () {
                return view('Internal.LaporanTahunan.list');
            });
            Route::get('/laporan-tahunan/detail', function () {
                return view('Internal.LaporanTahunan.detail');
            });

            Route::get('/pengaturan-akun/index', function () {
                return view('Internal.Pengaturan.PengaturanAkun.index');
            });
        });
    });
    Route::middleware(['check_role:company'])->group(function () {
        Route::prefix('company')->group(function () {
            Route::get('/dashboard-company', function () {
                return view('Company.dashboard');
            })->name('company.dashboard');

            // Route::prefix('certificate')->group(function () {
            //     Route::get('/list', function () {
            //         return view('Company.sertifikat-smk.list');
            //     })->name('company.certificate.list');
            // });
            Route::prefix('yearly-report')->group(function () {
                Route::get('/list', function () {
                    return view('Company.yearly-report.list');
                });
                Route::get('/create', function () {
                    return view('Company.yearly-report.create');
                });

                Route::get('/detail', function () {
                    return view('Company.yearly-report.detail');
                });
            });

            Route::get('/pengajuan-sertifikat/list', function () {
                return view('Company.Pengajuan.list');
            })->name('company.certificate.list');

            Route::get('/pengajuan-sertifikat/create', function () {
                return view('Company.Pengajuan.create');
            })->name('company.certificate.create');
            Route::get('/pengajuan-sertifikat/detail', function () {
                return view('Company.Pengajuan.detail');
            });

            Route::get('/pengaturan-akun/index', function () {
                return view('Company.PengaturanAkun.index');
            });
        });
    });
});
