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
            <div class="row align-items-center">

                <div class="col-lg-12  content"
                    data-aos="fade-up"
                    data-aos-delay="200">

                    {{-- <h3>
                        {{ $appSetting->judul_aplikasi ?? 'Tentang Kami' }}
                    </h3>

                    <p class="fst-italic">
                        {{ $appSetting->deskripsi ?? '' }}
                    </p> --}}

                    <div class="about-content">
                        {!! $appSetting->salam ?? '' !!}
                    </div>

                </div>

            </div>
        </div>

    </section>
<!-- /About Section -->

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
    <section id="kategori" class="features section" style="scroll-margin-top: 90px;">
        <div class="container section-title" data-aos="fade-up">
            <h2>Kategori</h2>
            <p>Jelajahi Topik Pilihan</p>
        </div>


        <div class="container">

            <div class="row gy-4">

                @foreach ($categories as $index => $kategori)
                    <div class="col-lg-3 col-md-4"
                        data-aos="fade-up"
                        data-aos-delay="{{ ($index + 1) * 100 }}">

                        <div class="features-item position-relative">

                            <i class="bi {{ $kategori->icon ?? 'bi-folder' }}" 
                                style="color:#0d6efd; font-size:24px;"></i>

                            <h3>
                                <a href="{{ route('berita.kategori', $kategori->slug) }}"
                                class="stretched-link">
                                    {{ $kategori->nama }}
                                </a>
                            </h3>

                        </div>
                    </div>
                @endforeach

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

                        <div class="course-item position-relative h-100">

                        {{-- LINK OVERLAY --}}
                        <a href="{{ route('berita.detail', $post->slug) }}"
                        class="stretched-link"
                        aria-label="{{ $post->judul }}"></a>

                        <img src="{{ asset('storage/'.$post->gambar) }}"
                            class="img-fluid"
                            style="height:180px; width:100%; object-fit:cover;"
                            alt="{{ $post->judul }}">

                        <div class="course-content">
                            <h3 class="mb-2">
                                {{ $post->judul }}
                            </h3>

                            <p class="description">
                                {{ Str::limit(strip_tags($post->konten), 120) }}
                            </p>
                        </div>

                        {{-- Views pojok kanan bawah --}}
                        <div class="position-absolute"
                            style="right:12px; bottom:10px; font-size:13px; color:#6c757d;">
                            <i class="bi bi-eye"></i> {{ $post->views }} views
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
