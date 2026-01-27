@extends('layouts.frontend.frontend')

@section('title', $page->meta_title ?? $page->title)

@section('content')
<div class="page-title" data-aos="fade">
    <div class="heading">
        <div class="container text-center">
            <h1 class="mb-4">{{ $page->title }}</h1>
        </div>
    </div>
</div>

<section class="page-content py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="card shadow-sm border-0">
                    <div class="card-body">

                        {{-- Tanggal --}}
                        <div class="d-flex justify-content-end mb-3">
                            <small class="text-muted">
                                {{ $page->created_at->format('d/m/Y H:i') }}
                            </small>
                        </div>

                        {{-- Konten --}}
                        <div class="lh-lg">
                            {!! $page->content !!}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
