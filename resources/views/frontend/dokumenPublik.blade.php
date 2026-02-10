@extends('layouts.frontend.frontend')

@section('title', 'Dokumen Publik')

@section('content')

<div class="page-title" data-aos="fade">
    <div class="heading">
        <div class="container text-center">
            <h1 class="fw-bold">Dokumen Publik</h1>
            <p class="text-muted mb-0">Unduh dan lihat dokumen resmi yang tersedia</p>
        </div>
    </div>
</div>

<section id="dokumen" class="section py-5">
    <div class="container">
        <div class="row g-4">

            @forelse ($files as $file)
            <div class="col-xl-3 col-lg-4 col-md-6" data-aos="zoom-in">

                <div class="dokumen-card h-100 position-relative">

                    <!-- Link -->
                    <a href="{{ asset('storage/'.$file->file) }}" target="_blank"
                       class="stretched-link"
                       aria-label="{{ $file->nama }}"></a>

                    <!-- Icon -->
                    <div class="dokumen-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                    <!-- Content -->
                    <div class="dokumen-body text-center">
                        <h6 class="dokumen-title">
                            {{ Str::limit($file->nama, 45) }}
                        </h6>

                        <span class="dokumen-date">
                            <i class="bi bi-calendar-event"></i>
                            {{ $file->created_at->format('d M Y') }}
                        </span>

                        <div class="dokumen-badge mt-2">
                            <i class="bi bi-download"></i> Lihat Dokumen
                        </div>
                    </div>

                </div>

            </div>
            @empty
            <div class="col-12 text-center text-muted">
                <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                Tidak ada dokumen tersedia
            </div>
            @endforelse

        </div>
    </div>
</section>

@endsection
