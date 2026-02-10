<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>DISDIK RAJA AMPAT</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/skydash/images/logoRajaAmpat.ico') }}" rel="icon">
    <link href="{{ asset('assets/Mentor/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/Mentor/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/Mentor/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/Mentor/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/Mentor/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/Mentor/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('assets/Mentor/assets/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: Mentor
  * Template URL: https://bootstrapmade.com/mentor-free-education-bootstrap-theme/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="index.html" class="logo d-flex align-items-center me-auto">
                <img src="{{ asset('assets/skydash/images/logorajaampat.ico') }}" alt="">
                <h5 class="sitename">Disdik Raja Ampat</h5>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    @foreach ($pages as $page)

                    @if ($page->children->isEmpty())
                    <li>
                        <a href="{{ url($page->slug) }}">
                            {{ $page->title }}
                        </a>
                    </li>
                    @else
                    <li class="dropdown">
                        <a href="#">
                            <span>{{ $page->title }}</span>
                            <i class="bi bi-chevron-down toggle-dropdown"></i>
                        </a>
                        <ul>
                            @foreach ($page->children as $child)
                            <li>
                                <a href="{{ url($child->slug) }}">
                                    {{ $child->title }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endif

                    @endforeach
                </ul>

                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->

        @if(isset($banners) && $banners->count())
          <section id="hero" class="d-flex align-items-center">

              <div id="heroCarousel"
                  class="carousel slide carousel-fade w-100"
                  data-bs-ride="carousel"
                  data-bs-interval="4000">

                  <div class="carousel-inner">

                      @foreach ($banners as $key => $banner)
                      <div class="carousel-item {{ $loop->first ? 'active' : '' }}"
                            style="background-image: url('{{ asset('storage/'.$banner->gambar) }}');">
                      </div>
                      @endforeach

                  </div>

                  <button class="carousel-control-prev"
                          type="button"
                          data-bs-target="#heroCarousel"
                          data-bs-slide="prev">
                      <span class="carousel-control-prev-icon"></span>
                  </button>

                  <button class="carousel-control-next"
                          type="button"
                          data-bs-target="#heroCarousel"
                          data-bs-slide="next">
                      <span class="carousel-control-next-icon"></span>
                  </button>

              </div>

          </section>
          @endif



       <!-- /Hero Section -->

        <!-- Courses Section -->
        <section id="courses" class="courses section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Berita</h2>
                <p>Berita Terbaru</p>
            </div>

            <div class="container">
                <div class="row">
                    @if (isset($posts))
                        @foreach ($posts as $post)
                            <div class="col-xl-3 col-lg-4 col-md-6 mb-4" data-aos="zoom-in">
                                <!-- 4 kolom di desktop, 3 di laptop, 2 di tablet -->

                                <div class="course-item h-100">

                                    <img src="{{ asset('storage/' . $post->gambar) }}"
                                        alt="{{ $post->judul }}"
                                        class="img-fluid news-img">

                                    <div class="course-content">
                                        <h3 class="mt-2">
                                            <a href="{{ url('berita/' . $post->slug) }}">
                                                {{ $post->judul }}
                                            </a>
                                        </h3>

                                        <p class="description">
                                            {{ Str::limit(strip_tags($post->konten), 120) }}
                                        </p>
                                    </div>
                                    <div class="card-footer-news">
                                        <span class="views">
                                            <i class="fas fa-eye"></i> {{ number_format($post->views) }} views
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
            @if (isset($posts) && $posts->count() >= 12)
                @foreach ($posts as $post)
                    <div class="text-center mt-4">
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-primary">
                            Baca Lainnya
                        </a>
                    </div>
                @endforeach
            @endif



        </section><!-- /Courses Section -->
    </main>

    <footer id="footer" class="footer position-relative light-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">Mentor</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>A108 Adam Street</p>
                        <p>New York, NY 535022</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>+1 5589 55488 55</span></p>
                        <p><strong>Email:</strong> <span>info@example.com</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter-x"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Terms of service</a></li>
                        <li><a href="#">Privacy policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Our Services</h4>
                    <ul>
                        <li><a href="#">Web Design</a></li>
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Product Management</a></li>
                        <li><a href="#">Marketing</a></li>
                        <li><a href="#">Graphic Design</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12 footer-newsletter">
                    <h4>Our Newsletter</h4>
                    <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
                    <form action="forms/newsletter.php" method="post" class="php-email-form">
                        <div class="newsletter-form"><input type="email" name="email"><input type="submit"
                                value="Subscribe"></div>
                        <div class="loading">Loading</div>
                        <div class="error-message"></div>
                        <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                    </form>
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
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a
                    href=“https://themewagon.com>ThemeWagon </div> </div> </footer> <!-- Scroll Top -->
                    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
                            class="bi bi-arrow-up-short"></i></a>

                    <!-- Preloader -->
                    <div id="preloader"></div>

                    <!-- Vendor JS Files -->
                    <script src="{{ asset('assets/Mentor/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}">
                    </script>
                    <script src="{{ asset('assets/Mentor/assets/vendor/php-email-form/validate.js') }}"></script>
                    <script src="{{ asset('assets/Mentor/assets/vendor/aos/aos.js') }}"></script>
                    <script src="{{ asset('assets/Mentor/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
                    <script src="{{ asset('assets/Mentor/assets/vendor/purecounter/purecounter_vanilla.js') }}">
                    </script>
                    <script src="{{ asset('assets/Mentor/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

                    <!-- Main JS File -->
                    <script src="{{ asset('assets/Mentor/assets/js/main.js') }}"></script>
    

</body>

</html>
