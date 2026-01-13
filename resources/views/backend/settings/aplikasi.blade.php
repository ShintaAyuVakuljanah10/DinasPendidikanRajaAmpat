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

                    <div class="mb-3">
                        <label>Gambar</label>
                        <div class="mb-2">
                            <img id="previewGambar"
                                src="{{ $setting->logo ? asset('storage/'.$setting->logo) : '' }}"
                                style="max-height:120px; {{ empty($setting->logo) ? 'display:none;' : '' }}">
                        </div>
                        <input type="hidden" name="logo" id="gambar" value="{{ old('logo', $setting->logo ?? '') }}">
                        <button type="button" class="btn btn-secondary btn-sm" onclick="openFileManager()">
                            Pilih dari File Manager
                        </button>
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
                    <textarea
                        name="salam"
                        id="salamEditor"
                        class="form-control"
                        rows="10">{!! old('salam', $setting->salam ?? '') !!}
                    </textarea>
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
<div class="modal fade" id="fileManagerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih Gambar</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <div class="row" id="fileManagerList">
                    <!-- ajax -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')

<script>
    tinymce.init({
        selector: '#salamEditor',
        height: 300,
        menubar: true,
        plugins: 'lists link image table code',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code'
    });
</script>

<script>
    function openFileManager() {
        $('#fileManagerModal').modal('show');

        $.get("{{ route('fileManager.data') }}", function (data) {
            let html = '';

            data.forEach(file => {
                html += `
                    <div class="col-md-3 mb-3 text-center">
                        <img src="/storage/${file.gambar}"
                            class="img-thumbnail"
                            style="cursor:pointer"
                            onclick="pilihGambar('${file.gambar}')">
                    </div>
                `;
            });

            $('#fileManagerList').html(html);
        });
    }

    function pilihGambar(gambar) {
        $('#gambar').val(gambar);
        $('#previewGambar').attr('src', '/storage/' + gambar).show();
        $('#fileManagerModal').modal('hide');
    }
</script>
@endpush
