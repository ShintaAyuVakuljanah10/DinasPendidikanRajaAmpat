@extends('layouts.frontend.frontend')

@section('title', 'Dashboard')

@section('content')
    
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

              <!-- Tombol Prev -->
              <button class="carousel-control-prev"
                      type="button"
                      data-bs-target="#heroCarousel"
                      data-bs-slide="prev">
                  <span class="carousel-control-prev-icon"></span>
              </button>

              <!-- Tombol Next -->
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

    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <img src="{{ asset('assets/Mentor/assets/img/about.jpg') }}" class="img-fluid" alt="">
                </div>

                <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
                    <h3>Voluptatem dignissimos provident quasi corporis</h3>
                    <p class="fst-italic">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore
                        magna aliqua.
                    </p>
                    <ul>
                        <li><i class="bi bi-check-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                                consequat.</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>Duis aute irure dolor in reprehenderit in
                                voluptate velit.</span></li>
                        <li><i class="bi bi-check-circle"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                                consequat. Duis aute irure dolor in reprehenderit in voluptate trideta
                                storacalaperda mastiro dolore eu fugiat nulla pariatur.</span></li>
                    </ul>
                    <a href="#" class="read-more"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
                </div>

            </div>

        </div>

    </section><!-- /About Section -->

    <!-- Counts Section -->
    <section id="counts" class="section counts light-background">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="1232" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>Students</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="64" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>Courses</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="42" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>Events</p>
                    </div>
                </div><!-- End Stats Item -->

                <div class="col-lg-3 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span data-purecounter-start="0" data-purecounter-end="24" data-purecounter-duration="1"
                            class="purecounter"></span>
                        <p>Trainers</p>
                    </div>
                </div><!-- End Stats Item -->

            </div>

        </div>

    </section><!-- /Counts Section -->

    <!-- Why Us Section -->
    <section id="why-us" class="section why-us">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="why-box">
                        <h3>Why Choose Our Products?</h3>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                            incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
                            Asperiores dolores sed et. Tenetur quia eos. Autem tempore quibusdam vel necessitatibus
                            optio ad corporis.
                        </p>
                        <div class="text-center">
                            <a href="#" class="more-btn"><span>Learn More</span> <i
                                    class="bi bi-chevron-right"></i></a>
                        </div>
                    </div>
                </div><!-- End Why Box -->

                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="row gy-4" data-aos="fade-up" data-aos-delay="200">

                        <div class="col-xl-4">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-clipboard-data"></i>
                                <h4>Corporis voluptates officia eiusmod</h4>
                                <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut
                                    aliquip</p>
                            </div>
                        </div><!-- End Icon Box -->

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-gem"></i>
                                <h4>Ullamco laboris ladore pan</h4>
                                <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                                    deserunt</p>
                            </div>
                        </div><!-- End Icon Box -->

                        <div class="col-xl-4" data-aos="fade-up" data-aos-delay="400">
                            <div class="icon-box d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-inboxes"></i>
                                <h4>Labore consequatur incidid dolore</h4>
                                <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere
                                </p>
                            </div>
                        </div><!-- End Icon Box -->

                    </div>
                </div>

            </div>

        </div>

    </section><!-- /Why Us Section -->

    <!-- Features Section -->
    <section id="features" class="features section">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="features-item">
                        <i class="bi bi-eye" style="color: #ffbb2c;"></i>
                        <h3><a href="" class="stretched-link">Lorem Ipsum</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="features-item">
                        <i class="bi bi-infinity" style="color: #5578ff;"></i>
                        <h3><a href="" class="stretched-link">Dolor Sitema</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="features-item">
                        <i class="bi bi-mortarboard" style="color: #e80368;"></i>
                        <h3><a href="" class="stretched-link">Sed perspiciatis</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="features-item">
                        <i class="bi bi-nut" style="color: #e361ff;"></i>
                        <h3><a href="" class="stretched-link">Magni Dolores</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="features-item">
                        <i class="bi bi-shuffle" style="color: #47aeff;"></i>
                        <h3><a href="" class="stretched-link">Nemo Enim</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="features-item">
                        <i class="bi bi-star" style="color: #ffa76e;"></i>
                        <h3><a href="" class="stretched-link">Eiusmod Tempor</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="700">
                    <div class="features-item">
                        <i class="bi bi-x-diamond" style="color: #11dbcf;"></i>
                        <h3><a href="" class="stretched-link">Midela Teren</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="800">
                    <div class="features-item">
                        <i class="bi bi-camera-video" style="color: #4233ff;"></i>
                        <h3><a href="" class="stretched-link">Pira Neve</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="900">
                    <div class="features-item">
                        <i class="bi bi-command" style="color: #b2904f;"></i>
                        <h3><a href="" class="stretched-link">Dirada Pack</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1000">
                    <div class="features-item">
                        <i class="bi bi-dribbble" style="color: #b20969;"></i>
                        <h3><a href="" class="stretched-link">Moton Ideal</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1100">
                    <div class="features-item">
                        <i class="bi bi-activity" style="color: #ff5828;"></i>
                        <h3><a href="" class="stretched-link">Verdo Park</a></h3>
                    </div>
                </div><!-- End Feature Item -->

                <div class="col-lg-3 col-md-4" data-aos="fade-up" data-aos-delay="1200">
                    <div class="features-item">
                        <i class="bi bi-brightness-high" style="color: #29cc61;"></i>
                        <h3><a href="" class="stretched-link">Flavor Nivelanda</a></h3>
                    </div>
                </div><!-- End Feature Item -->

            </div>

        </div>

    </section><!-- /Features Section -->

    <!-- Courses Section -->
    <section id="courses" class="courses section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Berita</h2>
            <p>Berita Terbaru</p>
        </div>

        <div class="container">
            <div class="row">

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

            </div>
        </div>
        @if ($posts->count() >= 12)
            <div class="text-center mt-4">
                <a href="{{ route('berita.index') }}" class="btn btn-outline-primary">
                    Baca Lainnya
                </a>
            </div>
        @endif



    </section><!-- /Courses Section -->
</main>

@endsection
