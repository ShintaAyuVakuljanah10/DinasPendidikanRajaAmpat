<footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
        <div class="row gy-4">

            <div class="col-lg-4 col-md-6 footer-about">
            <a href="{{ url('/') }}" class="logo d-flex align-items-center mb-2">
                <span class="sitename">
                {{ $appSetting->judul_aplikasi ?? 'Judul Aplikasi' }}
                </span>
            </a>

            <div class="footer-contact">
                @if(!empty($appSetting->alamat))
                <p class="mb-2">{{ $appSetting->alamat }}</p>
                @endif

                @if(!empty($appSetting->hp))
                <p class="mb-1"><strong>Phone:</strong> {{ $appSetting->hp }}</p>
                @endif

                @if(!empty($appSetting->email))
                <p class="mb-0"><strong>Email:</strong> {{ $appSetting->email }}</p>
                @endif
            </div>

            <div class="social-links d-flex mt-3">
                <a href="#"><i class="bi bi-twitter-x"></i></a>
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-linkedin"></i></a>
            </div>
            </div>

            <div class="col-lg-3 col-md-3 footer-links">
            <h4>Useful Links</h4>
            <ul>
                @foreach ($footerPages as $page)
                <li><a href="{{ url($page->slug) }}">{{ $page->title }}</a></li>
                @endforeach
            </ul>
            </div>

            <div class="col-lg-3 col-md-3 footer-links">
            <h4>Layanan</h4>
            <ul>
                <li><a href="#">Informasi Publik</a></li>
                <li><a href="#">Pengumuman</a></li>
                <li><a href="#">Kontak</a></li>
            </ul>
            </div>

            <div class="col-lg-2 col-md-12 footer-links">
            <h4>Bantuan</h4>
            <ul>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Syarat & Ketentuan</a></li>
            </ul>
            </div>

        </div>
    </div>


    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Mentor</strong> <span>All Rights Reserved</span>
        </p>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you've purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
            Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> 
            Distributed by <a
                href=“https://themewagon.com>ThemeWagon 
            </div> 
        </div> 
    </footer> 
    <!-- Scroll Top -->
        <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
            <i
                class="bi bi-arrow-up-short"></i>
            </a>

        <!-- Preloader -->
        <div id="preloader">

        </div>

        <!-- Vendor JS Files -->
        <script src="{{ asset('assets/Mentor/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
        </script>
        <script src="{{ asset('assets/Mentor/assets/vendor/php-email-form/validate.js') }}"></script>
        <script src="{{ asset('assets/Mentor/assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('assets/Mentor/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('assets/Mentor/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
        <script src="{{ asset('assets/Mentor/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

        <!-- Main JS File -->
        <script src="{{ asset('assets/Mentor/assets/js/main.js') }}"></script>


