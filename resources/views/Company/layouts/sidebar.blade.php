
<nav class="pc-sidebar">
    <div class="navbar-wrapper">
        <div class="m-header text-center">
            <a href="javascript:void(0)" class="b-brand text-primary">
                <img src="{{ asset(request()->app_setting->value->logo_aplikasi) }}" alt="Logo Aplikasi" style="width: 3rem;  border-radius: 50%; height: 3rem; object-fit: cover;">
            </a>
            <h5 class="fw-bold" style="margin-left: 0.5rem;">{{ request()->app_setting->value->nama }}</h5>
        </div>
        <div class="navbar-content">
            <ul class="pc-navbar">
                <li class="pc-item">
                    <a href="/company/dashboard-company" class="pc-link">
                        <span class="pc-micon">
                            <i class="fa fa-home"></i>
                        </span>
                        <span class="pc-mtext">Dashboard</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Permohonan</label>
                    <svg class="pc-icon">
                        <use xlink:href="#custom-presentation-chart"></use>
                    </svg>
                </li>
                <li class="pc-item">
                    <a href="{{ route('company.certificate.list') }}" class="pc-link">
                        <span class="pc-micon">
                            <i class="fa-solid fa-certificate"></i>
                        </span>
                        <span class="pc-mtext">Sertifikat SMK</span>
                    </a>
                </li>

                <li class="pc-item pc-caption">
                    <label>Laporan</label>
                    <svg class="pc-icon">
                        <use xlink:href="#custom-presentation-chart"></use>
                    </svg>
                </li>
                <li class="pc-item">
                    <a href="/company/yearly-report/list" class="pc-link">
                        <span class="pc-micon">
                            <i class="ph-duotone ph-chart-bar"></i>
                        </span>
                        <span class="pc-mtext">Laporan Tahunan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

