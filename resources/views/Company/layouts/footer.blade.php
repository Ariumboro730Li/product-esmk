<footer class="pc-footer">
    <div class="border-top footer-center mt-5">
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-12 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="d-flex flex-column flex-sm-row align-items-start ms-3">
                        <div class="d-flex justify-content-start mb-0 mb-sm-0 me-3">
                            <img src="{{ asset(request()->app_setting->value->logo_aplikasi) }}" alt="Logo Aplikasi" style="width: 2.5rem;  border-radius: 50%; height: 2.5rem; object-fit: cover;">
                        </div>
                        <div class="flex-g row-1 text-left text-sm-start">
                            <h4 class="mb-0 nama_aplikasi"></h4>
                            <h6 class="mb-0" id="nama_instansi"></h6>
                            <p class="mb-0">
                                <a href="" target="_blank" id="kredit_by">PT. Zyco Invitas Teknologi</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-6 col-12">
                    <div class="row">
                        <div class="col-12 wow fadeInUp" data-wow-delay="1s">
                            <ul class="ms-3 mt-4 mt-md-0 list-unstyled footer-link">
                                <li>
                                    <p id="alamat_app" class="mb-0">
                                        <i class="fa-solid fa-location-dot me-2"></i>
                                    </p>
                                </li>
                                <li>
                                    <p id="no_telepon_app" class="mb-0">
                                        <span class="contact-icon">
                                            <i class="fa fa-phone me-2"></i>
                                        </span>
                                    </p>
                                </li>
                                <li>
                                    <p id="email_app" class="mb-0">
                                        <span class="contact-icon">
                                            <i class="fa fa-envelope me-2"></i>
                                        </span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>



{{-- <footer class="pc-footer">
    <div class="border-top border-bottom footer-center mt-5">
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="d-flex flex-column flex-sm-row align-items-start ms-3">
                        <div class="flex-g row-1 text-left text-sm-start">
                            <h4 id="namaAplikasi" class="mb-0">SMK-TD</h4>
                            <h6 class="mb-0">Dishub <span id="provinsi">Jawa Barat</span></h6>
                            <p class="">
                                © <a href="" target="_blank">2025 Dishub <span id="provinsi">Jawa Barat</span></a>
                            </p>
                            <ul class="list-unstyled mt-3 mt-md-0 mb-0">
                                <li class="d-sm-inline-block d-block mt-1 me-3" id="alamat">
                                    <i class="fa-solid fa-location-dot me-2"></i>Jl. Sukabumi No.1, Kacapiring, Kec.
                                    Batununggal, Kota Bandung, Jawa Barat 40271
                                </li>
                            </ul>
                            <ul class="list-unstyled mt-3 mt-md-0 mb-4">
                                <li class="d-sm-inline-block d-block mt-1 me-4" id="noWaHelpdesk">
                                    <i class="fa fa-phone me-2"></i>(022) 7272258
                                </li>
                                <li class="d-sm-inline-block d-block mt-1 me-3" id="email" >
                                    <i class="fa fa-envelope me-2"></i>dishub@jabarprov.go.id
                                </li>
                            </ul>
                            <p class="my-3">
                                © <a href="" target="_blank">2025 Dishub <span id="provinsi">Jawa Barat</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container text-center">
        <div class="row align-items-center">
          <div class="col my-1 wow fadeInUp" data-wow-delay="0.4s">
            <p class="my-3">
                © <a href="" target="_blank">2025 Dishub <span id="provinsi">Jawa Barat</span></a>
            </p>
          </div>
        </div>
    </div>
</footer> --}}
