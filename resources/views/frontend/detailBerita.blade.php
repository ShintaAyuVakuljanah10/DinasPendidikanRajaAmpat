<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->judul }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        article img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

{{-- ===== HEADER SIMPLE ===== --}}
<nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ url('/') }}">
            Portal Berita
        </a>
    </div>
</nav>

{{-- ===== KONTEN ===== --}}
<section class="container my-5">
    <div class="row">

        {{-- ===== KONTEN BERITA ===== --}}
        <div class="col-lg-8">

            {{-- Judul --}}
            <h1 class="fw-bold mb-3">
                {{ $post->judul }}
            </h1>

            {{-- Meta --}}
            <div class="text-muted mb-4">
                <i class="bi bi-calendar-event"></i>
                {{ $post->created_at->format('d M Y') }}
                &nbsp;•&nbsp;
                <i class="bi bi-eye"></i>
                {{ $post->views }} views
            </div>

            {{-- Gambar Utama --}}
            @if ($post->gambar)
                <div class="mb-4">
                    <img
                        src="{{ asset('storage/' . $post->gambar) }}"
                        class="img-fluid rounded shadow-sm w-100"
                        style="max-height: 420px; object-fit: cover;"
                        alt="{{ $post->judul }}">
                </div>
            @endif

            {{-- Isi Berita --}}
            <article class="fs-6 lh-lg text-dark">
                {!! $post->konten !!}
            </article>

            {{-- Kategori --}}
            @if ($post->kategori)
                <div class="mt-4">
                    <span class="badge bg-primary">
                        {{ $post->kategori->nama }}
                    </span>
                </div>
            @endif
        </div>

        {{-- ===== SIDEBAR KATEGORI ===== --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">
                        Kategori Berita
                    </h5>

                    <ul class="list-group list-group-flush">
                        @foreach ($categories as $kategori)
                            <li class="list-group-item px-0">
                                <a href="{{ route('berita.kategori', $kategori->slug) }}"
                                   class="text-decoration-none d-flex justify-content-between align-items-center">
                                    <span>{{ $kategori->nama }}</span>
                                    <span class="badge bg-secondary">
                                        {{ $kategori->posts_count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>

    </div>
</section>

{{-- ===== FOOTER ===== --}}
<footer class="bg-white border-top py-4 mt-5">
    <div class="container text-center text-muted small">
        © {{ date('Y') }} Portal Berita. All rights reserved.
    </div>
</footer>

{{-- Bootstrap JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
