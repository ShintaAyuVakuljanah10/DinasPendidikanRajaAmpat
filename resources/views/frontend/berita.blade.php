@extends('layouts.frontend.frontend')

@section('title', 'Berita')

@section('content')
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
            <div class="container text-center">
            <h1>Berita</h1>
            <p>Informasi & berita terbaru</p>
            </div>
        </div>
    </div>

    <!-- Berita Section -->
    <section id="courses" class="courses section">
        <div class="container">

            <div class="row">
            @foreach ($posts as $post)
                <div class="col-xl-3 col-lg-4 col-md-6 d-flex align-items-stretch mb-4" data-aos="zoom-in">

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

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
            </div>

        </div>
    </section>
@endsection