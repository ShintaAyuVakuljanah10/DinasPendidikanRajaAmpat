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
                            style="
                                background-image: url('{{ asset('storage/'.$banner->gambar) }}');
                                background-size: contain;
                                background-position: center;
                                background-repeat: no-repeat;
                            ">
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
    
                <!-- SISWA -->
                <div class="col-lg-4 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span
                            data-purecounter-start="0"
                            data-purecounter-end="{{ $totalSiswa }}"
                            data-purecounter-duration="1"
                            class="purecounter">
                        </span>
                        <p>Total Siswa</p>
                    </div>
                </div>
    
                <!-- GURU -->
                <div class="col-lg-4 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span
                            data-purecounter-start="0"
                            data-purecounter-end="{{ $totalGuru }}"
                            data-purecounter-duration="1"
                            class="purecounter">
                        </span>
                        <p>Total Guru</p>
                    </div>
                </div>
    
                <!-- SEKOLAH -->
                <div class="col-lg-4 col-md-6">
                    <div class="stats-item text-center w-100 h-100">
                        <span
                            data-purecounter-start="0"
                            data-purecounter-end="{{ $totalSekolah }}"
                            data-purecounter-duration="1"
                            class="purecounter">
                        </span>
                        <p>Total Sekolah</p>
                    </div>
                </div>
    
            </div>
        </div>
    </section>
    <!-- /Counts Section -->

    <!-- Why Us Section -->
    <section id="why-us" class="section why-us">

        

    </section>
    <!-- /Why Us Section -->

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
                            style="height:180px; width:100%; object-fit:contain;"
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
