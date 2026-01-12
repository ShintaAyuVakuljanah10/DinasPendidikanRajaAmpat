@extends('layouts.backend')

@section('title', 'Pengaturan Aplikasi')

@section('content')
<div class="container-fluid">
    <div class="card">
        <form action="{{ route('settings.aplikasi.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="card-body">

                {{-- ROW 1 --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Aplikasi</label>
                        <input type="text"
                               name="nama_aplikasi"
                               class="form-control"
                               value="{{ old('nama_aplikasi', $setting->nama_aplikasi ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Judul Aplikasi</label>
                        <input type="text"
                               name="judul_aplikasi"
                               class="form-control"
                               value="{{ old('judul_aplikasi', $setting->judul_aplikasi ?? '') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Logo Aplikasi</label>
                        <div class="input-group">
                            <input type="file" name="logo" class="form-control">

                            @if(!empty($setting->logo))
                                <span class="input-group-text text-muted">
                                    {{ asset('storage/'.$setting->logo) }}
                                </span>
                            @endif
                        </div>

                        @if(!empty($setting->logo))
                            <img src="{{ asset('storage/'.$setting->logo) }}"
                                 class="mt-2"
                                 height="60">
                        @endif
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi Judul</label>
                    <textarea name="deskripsi"
                              class="form-control"
                              rows="3">{{ old('deskripsi', $setting->deskripsi ?? '') }}</textarea>
                </div>

                {{-- ROW 2 --}}
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">E-mail</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $setting->email ?? '') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nomor HP</label>
                        <input type="text"
                               name="hp"
                               class="form-control"
                               value="{{ old('hp', $setting->hp ?? '') }}">
                    </div>
                </div>

                {{-- ALAMAT --}}
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat"
                              class="form-control"
                              rows="3">{{ old('alamat', $setting->alamat ?? '') }}</textarea>
                </div>

                {{-- SALAM SAMBUTAN --}}
                <div class="mb-3">
                    <label class="form-label">Salam Sambutan</label>
                    <textarea name="salam"
                              id="salamEditor"
                              class="form-control"
                              rows="10">{!! old('salam', $setting->salam ?? '') !!}</textarea>
                </div>

            </div>

            <div class="card-footer text-end">
                <button class="btn btn-primary">
                    <i class="mdi mdi-content-save"></i> Save
                </button>
            </div>

        </form>
    </div>
</div>
@endsection


@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>

<script>
tinymce.init({
    selector: '#salamEditor',
    height: 300,
    menubar: true,
    plugins: 'lists link image table code',
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | image | code'
});
</script>
@endpush
