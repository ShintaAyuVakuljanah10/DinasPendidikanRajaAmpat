@extends('layouts.frontend.frontend')

@section('title', 'Dokumen Publik')

@section('content')

<div class="page-title" data-aos="fade">
    <div class="heading">
        <div class="container text-center">
            <h1>Dokumen Publik</h1>
            <p>Koleksi gambar & dokumentasi</p>
        </div>
    </div>
</div>

<section id="courses" class="courses section py-5">
    <div class="container">
        <div class="row">
            @foreach ($files as $file)
            <div class="col-xl-3 col-lg-4 col-md-6 d-flex align-items-stretch mb-4" data-aos="zoom-in">

                <div class="course-item position-relative h-100 w-100">

                    <a href="{{ asset('storage/'.$file->gambar) }}" target="_blank" class="stretched-link"
                        aria-label="{{ $file->judul }}"></a>

                    <img src="{{ asset('storage/'.$file->gambar) }}" class="img-fluid"
                        style="height:140px; width:100%; object-fit:contain; background:#f8f9fa;"
                        alt="{{ $file->judul }}">

                    <div class="course-content py-2 px-3 text-center">
                        <h3 class="mb-1" style="font-size:15px;">
                            {{ Str::limit($file->judul, 45) }}
                        </h3>

                        {{-- TANGGAL UPLOAD --}}
                        <p class="mb-0 text-muted" style="font-size:12px;">
                            <i class="bi bi-calendar-event"></i>
                            {{ $file->created_at->format('d M Y') }}
                        </p>

                        <p class="description mb-0" style="font-size:12px;">
                            Klik untuk melihat dokumen
                        </p>
                    </div>

                </div>

            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
