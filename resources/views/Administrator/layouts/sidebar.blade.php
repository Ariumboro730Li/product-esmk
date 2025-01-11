<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header text-center">
            <a href="" class="b-brand text-primary">
                <div class="logo_aplikasi"></div>
            </a>
            <h5 class="fw-bold nama_aplikasi" style="padding-left:10px;"></h5>
            </a>
        </div>
        <div class="navbar-content">
            @php
                $permissions = collect(request()->permission)
                    ->pluck('name')
                    ->toArray();
            @endphp

            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="/admin/dashboard" class="pc-link">
                        <span class="pc-micon">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>
                {{-- MASTER DATA --}}
                @if (in_array('Lihat provinsi', $permissions) || in_array('Lihat kota', $permissions))
                    <li class="pc-item pc-caption">
                        <label>Master Data</label>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="fa-regular fa-map"></i>
                            </span>
                            <span class="pc-mtext">Wilayah</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/admin/provinsi">Provinsi</a></li>
                            <li class="pc-item"><a class="pc-link" href="/admin/kota">Kota</a></li>
                        </ul>
                    </li>
                    <li class="pc-item">
                        <a href="/admin/kbli" class="pc-link">
                            <span class="pc-micon">
                                <i class="fas fa-list"></i>
                            </span>
                            <span class="pc-mtext">KBLI</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="/admin/nomor-sk" class="pc-link">
                            <span class="pc-micon">
                                <i class="fa-solid fa-file-invoice"></i>
                            </span>
                            <span class="pc-mtext">No. Berita Acara</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="/admin/penandatangan" class="pc-link">
                            <span class="pc-micon">
                                <i class="fa-solid fa-signature"></i>
                            </span>
                            <span class="pc-mtext">Penandatangan</span>
                        </a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="fas fa-book"></i>
                            </span>
                            <span class="pc-mtext">Element</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="/admin/element-smk/list">Element SMK</a></li>
                            <li class="pc-item"><a class="pc-link" href="/admin/element-pemantauan/list">Element
                                    Pemantauan</a></li>
                        </ul>
                    </li>
                @endif

                {{-- HAK AKSES DAN USER MANAGEMENG --}}
                @if (in_array('Lihat user', $permissions) || in_array('Lihat role', $permissions))
                    <li class="pc-item pc-caption">
                        <label>Administrasi</label>
                        <svg class="pc-icon">
                            <use xlink:href="#custom-presentation-chart"></use>
                        </svg>
                    </li>
                    @if (in_array('Lihat user', $permissions))
                        <li class="pc-item">
                            <a href="/admin/user-manajemen" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fa fa-users"></i>
                                </span>
                                <span class="pc-mtext">User Manajemen</span>
                            </a>
                        </li>
                    @endif

                    @if (in_array('Lihat role', $permissions))
                        <li class="pc-item">
                            <a href="/admin/hak-akses" class="pc-link">
                                <span class="pc-micon">
                                    <i class="fa fa-key"></i>
                                </span>
                                <span class="pc-mtext">Hak Akses</span>
                            </a>
                        </li>
                    @endif
                @endif

                {{-- PENGAJUAN SERTIFIKAT --}}
                @if (in_array('Lihat pengajuan', $permissions))
                    <li class="pc-item pc-caption">
                        <label>Permohonan</label>
                        <svg class="pc-icon">
                            <use xlink:href="#custom-presentation-chart"></use>
                        </svg>
                    </li>
                    <li class="pc-item">
                        <a href="/admin/sertifikat/list" class="pc-link">
                            <span class="pc-micon">
                                <i class="fa-solid fa-certificate"></i>
                            </span>
                            <span class="pc-mtext">Sertifikat SMK</span>
                        </a>
                    </li>
                @endif

                {{-- LAPORAN TAHUNAN --}}
                @if (in_array('Lihat laporan', $permissions))
                    <li class="pc-item pc-caption">
                        <label>Laporan</label>
                        <svg class="pc-icon">
                            <use xlink:href="#custom-presentation-chart"></use>
                        </svg>
                    </li>
                    <li class="pc-item">
                        <a href="/admin/laporan-tahunan/list" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-chart-bar"></i>
                            </span>
                            <span class="pc-mtext">Laporan Tahunan</span>
                        </a>
                    </li>
                @endif

                {{-- PERUSAHAAN --}}
                @if (in_array('Lihat perusahaan', $permissions))
                    <li class="pc-item pc-caption">
                        <label>Perusahaan</label>
                        <svg class="pc-icon">
                            <use xlink:href="#custom-presentation-chart"></use>
                        </svg>
                    </li>
                    <li class="pc-item">
                        <a href="/admin/perusahaan" class="pc-link">
                            <span class="pc-micon">
                                <i class="ph-duotone ph-buildings"></i>
                            </span>
                            <span class="pc-mtext">Perusahaan</span>
                        </a>
                    </li>
                @endif

                {{-- PENGATURAN --}}
                <li class="pc-item pc-caption">
                    <label>Pengaturan</label>
                    <svg class="pc-icon">
                        <use xlink:href="#custom-presentation-chart"></use>
                    </svg>
                </li>
                @if (request()->payload['internal_role'] === 'Super Admin')
                    <li class="pc-item">
                        <a href="/admin/pengaturan" class="pc-link">
                            <span class="pc-micon">
                                <i class="fa fa-cogs"></i>
                            </span>
                            <span class="pc-mtext">Pengaturan Aplikasi</span>
                        </a>
                    </li>
                @endif
                <li class="pc-item">
                    <a href="/admin/pengaturan-akun" class="pc-link">
                        <span class="pc-micon">
                            <i class="fa-solid fa-user-gear"></i>
                        </span>
                        <span class="pc-mtext">Pengaturan Akun</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
