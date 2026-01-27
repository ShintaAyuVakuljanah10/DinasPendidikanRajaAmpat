@extends('layouts.frontend')

@section('title', $page->meta_title ?? $page->title)

@section('content')
<section class="download-page">
    <div class="container">
        <h1 class="mb-4">{{ $page->title }}</h1>

        {{-- konten dari editor --}}
        <div class="page-content">
            {!! $page->content !!}
        </div>

        {{-- contoh area download --}}
        <div class="download-box mt-5">
            <h5>File Download</h5>

            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Contoh File PDF
                    <a href="#" class="btn btn-sm btn-primary">
                        Download
                    </a>
                </li>
            </ul>
        </div>
    </div>
</section>
@endsection
