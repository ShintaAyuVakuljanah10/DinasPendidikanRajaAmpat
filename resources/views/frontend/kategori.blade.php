@extends('layouts.frontend.frontend')

@section('title', 'Kategori')

@section('content')
<!-- Page Title -->
<div class="page-title" data-aos="fade">
    <div class="heading">
        <div class="container text-center">
            <h1>Kategori</h1>
            <p>Daftar berita berdasarkan kategori</p>
        </div>
    </div>
</div>

<section id="courses" class="courses section">
    <div class="container">

        {{-- Header Kategori --}}
        <div class="d-flex align-items-center mb-4">
            <i class="bi {{ $kategori->icon ?? 'bi-folder' }}"
               style="font-size:32px; color:#0d6efd; margin-right:12px;"></i>
            <h2 class="mb-0">{{ $kategori->nama }}</h2>
        </div>

        {{-- Grid Berita --}}
        <div class="row">
            @forelse ($beritas as $b)
            <div class="col-xl-3 col-lg-4 col-md-6 d-flex align-items-stretch mb-4" data-aos="zoom-in">

                <div class="course-item position-relative h-100">

                    {{-- LINK OVERLAY --}}
                    <a href="{{ route('berita.detail', $b->slug) }}"
                       class="stretched-link"
                       aria-label="{{ $b->judul }}"></a>

                    <img src="{{ asset('storage/'.$b->gambar) }}"
                         class="img-fluid"
                         style="height:180px; width:100%; object-fit:cover;"
                         alt="{{ $b->judul }}">

                    <div class="course-content">
                        <h3 class="mb-2">
                            {{ $b->judul }}
                        </h3>

                        <p class="description">
                            {{ Str::limit(strip_tags($b->konten), 120) }}
                        </p>
                    </div>

                    {{-- Views --}}
                    <div class="position-absolute"
                         style="right:12px; bottom:10px; font-size:13px; color:#6c757d;">
                        <i class="bi bi-eye"></i> {{ $b->views ?? 0 }} views
                    </div>

                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-light text-center">
                    Belum ada berita di kategori ini.
                </div>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $beritas->links() }}
        </div>

    </div>
</section>
@endsection
