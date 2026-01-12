@extends('layouts.backend')

@section('title', 'Data Banner')

@section('content')

<div class="container">
    <button id="btnAddBanner" class="btn btn-primary mb-3">
        + Tambah Banner
    </button>

    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold mb-3">Data Banner</h3>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Gambar</th>
                            <th width="10%">Urutan</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="banner-table">
                        <tr>
                            <td colspan="5" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalBanner">
    <div class="modal-dialog">
        <form id="formBanner" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="banner_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Banner</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="mb-2">
                        <label>Nama Banner</label>
                        <input type="text" id="nama" name="nama" class="form-control" required>
                        <small class="text-danger error-nama"></small>
                    </div>

                    <div class="mb-2">
                        <label>Gambar</label>

                        <!-- preview -->
                        <div class="mb-2">
                            <img id="previewGambar" src="" style="max-height:120px; display:none;">
                        </div>
                        <input type="hidden" name="gambar" id="gambar">

                        <button type="button" class="btn btn-secondary btn-sm" onclick="openFileManager()">
                            Pilih dari File Manager
                        </button>

                        <img id="preview-gambar" class="mt-2" style="max-width:200px; display:none">
                        <small class="text-danger error-gambar"></small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
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
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    loadBanner();

    function loadBanner() {
        $.get("{{ route('banner.data') }}", function (data) {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="5" class="text-center">Data kosong</td></tr>`;
            } else {
                $.each(data, function (i, item) {
                    html += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${item.nama}</td>
                        <td>
                            <img src="/storage/${item.gambar}" width="500" height="220" class="img-thumbnail">
                        </td>
                        <td class="text-center">${item.urutan}</td>
                        <td>
                            <button class="btn btn-sm btn-primary up" data-id="${item.id}">⬆</button>
                            <button class="btn btn-sm btn-primary down" data-id="${item.id}">⬇</button>
                            <button class="btn btn-sm btn-warning edit" data-id="${item.id}">Edit</button>
                            <button class="btn btn-sm btn-danger delete" data-id="${item.id}">Hapus</button>
                        </td>
                    </tr>`;
                });
            }
            $('#banner-table').html(html);
        });
    }

    // tambah
    $('#btnAddBanner').click(function () {
        $('#formBanner')[0].reset();
        $('#banner_id').val('');
        $('.text-danger').text('');
        $('#modalTitle').text('Tambah Banner');
        $('#modalBanner').modal('show');
    });

    // simpan / update
    $('#formBanner').submit(function (e) {
        e.preventDefault();
        let id = $('#banner_id').val();
        let url = id ? `/settings/banners/${id}` : "{{ route('banner.store') }}";

        let formData = new FormData(this);
        if (id) formData.append('_method', 'PUT');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function () {
                $('#modalBanner').modal('hide');
                loadBanner();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let e = xhr.responseJSON.errors;
                    $('.error-nama').text(e.nama ? e.nama[0] : '');
                    $('.error-gambar').text(e.gambar ? e.gambar[0] : '');
                }
            }
        });
    });

    // edit
    $(document).on('click', '.edit', function () {
        let id = $(this).data('id');
        $.get(`/settings/banners/${id}/edit`, function (data) {
            $('#banner_id').val(data.id);
            $('#nama').val(data.nama);
            $('#modalTitle').text('Edit Banner');
            $('.text-danger').text('');
            $('#modalBanner').modal('show');
        });
    });

    // hapus
    $(document).on('click', '.delete', function () {
        let id = $(this).data('id');
        if (confirm('Hapus banner ini?')) {
            $.ajax({
                url: `/settings/banners/${id}`,
                type: 'DELETE',
                success: function () {
                    loadBanner();
                }
            });
        }
    });

    // naik urutan
    $(document).on('click', '.up', function () {
        let id = $(this).data('id');
        $.post(`/settings/banners/${id}/up`, function () {
            loadBanner();
        });
    });

    // turun urutan
    $(document).on('click', '.down', function () {
        let id = $(this).data('id');
        $.post(`/settings/banners/${id}/down`, function () {
            loadBanner();
        });
    });
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
