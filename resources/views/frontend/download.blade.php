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

<section class="download-page">
    <div class="container">

        {{-- konten dari editor --}}
        <div class="page-content">
            {!! $page->content !!}
        </div>

        <div class="download-box mt-5">
            <h5>File Laporan {{ $jenjang }}</h5>

            @if($downloads->count())
            <div class="row g-3 mt-3">
                @foreach ($downloads as $file)
                @php
                $ext = pathinfo($file->file, PATHINFO_EXTENSION);
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex align-items-center gap-3">

                            {{-- ICON FILE --}}
                            <div class="file-icon fs-1 text-primary">
                                @if(in_array($ext, ['pdf']))
                                <i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                @elseif(in_array($ext, ['doc','docx']))
                                <i class="bi bi-file-earmark-word-fill text-primary"></i>
                                @elseif(in_array($ext, ['xls','xlsx']))
                                <i class="bi bi-file-earmark-excel-fill text-success"></i>
                                @elseif(in_array($ext, ['ppt','pptx']))
                                <i class="bi bi-file-earmark-ppt-fill text-warning"></i>
                                @else
                                <i class="bi bi-file-earmark-fill"></i>
                                @endif
                            </div>

                            {{-- INFO FILE --}}
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $file->title }}</h6>
                                <small class="text-muted">
                                    {{ strtoupper($ext) }} •
                                    {{ number_format(Storage::disk('public')->size($file->file) / 1024, 1) }} KB
                                </small>
                            </div>

                            {{-- BUTTON --}}
                            <a href="{{ route('download.file', $file->id) }}"
                                class="btn btn-sm btn-outline-primary">
                                 <i class="bi bi-download"></i> Unduh
                             </a>                                                         

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="alert alert-warning mt-3">
                Belum ada file untuk jenjang ini.
            </div>
            @endif
        </div>

    </div>
</section>
@endsection
