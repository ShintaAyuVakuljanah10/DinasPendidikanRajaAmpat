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
                <table class="table table-hover align-middle" id="bannerTable">
                    <thead class="text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Gambar</th>
                            <th width="10%">Urutan</th>
                            <th width="25%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- <tr>
                            <td colspan="5" class="text-center">Loading...</td>
                        </tr> --}}
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
    let bannerTable;
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    bannerTable = $('#bannerTable').DataTable({
        ordering: false,
        searching: true,
        pageLength: 10,
        autoWidth: false,
        columnDefs: [
            { targets: [0,4], className: 'text-center' }
        ],
        language: {
            search: "Cari",
            lengthMenu: "Tampilkan _MENU_",
            info: "_START_ - _END_ dari _TOTAL_ data",
            paginate: {
                previous: "‹",
                next: "›"
            }
        }
    });

    loadBanner();

    function loadBanner() {
    $.get("{{ route('banner.data') }}", function (data) {

        bannerTable.clear();

        if (data.length === 0) {
            bannerTable.row.add([
                '',
                'Data kosong',
                '',
                '',
                ''
            ]).draw();
            return;
        }

        $.each(data, function (i, item) {
            bannerTable.row.add([
                i + 1,
                item.nama,
                `<img src="/storage/${item.gambar}" style="width:120px; height:60px; object-fit:cover; border-radius:0;">`,
                item.urutan,
                `
                <div class="btn-group btn-group-sm" role="group">
                    <button class="btn btn-outline-secondary up" data-id="${item.id}">
                        <i class="mdi mdi-arrow-up"></i>
                    </button>
                    <button class="btn btn-outline-secondary down" data-id="${item.id}">
                        <i class="mdi mdi-arrow-down"></i>
                    </button>
                    <button class="btn btn-outline-primary btn-edit" data-id="${item.id}">
                        <i class="mdi mdi-pencil"></i>
                    </button>
                    <button class="btn btn-outline-danger btn-delete" data-id="${item.id}">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </div>
                `
            ]);
        });

        bannerTable.draw();
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
        let url = id ? `/settings/banner/${id}` : "{{ route('banner.store') }}";

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

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: $('#banner_id').val()
                        ? 'Banner berhasil diperbarui'
                        : 'Banner berhasil ditambahkan',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    let e = xhr.responseJSON.errors;
                    $('.error-nama').text(e.nama ? e.nama[0] : '');
                    $('.error-gambar').text(e.gambar ? e.gambar[0] : '');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan pada server'
                    });
                }
            }

        });
    });

    // edit
    $(document).on('click', '.btn-edit', function () {
        let id = $(this).data('id');

        $.get(`/settings/banner/${id}/edit`, function (data) {
            $('#banner_id').val(data.id);
            $('#nama').val(data.nama);
            $('#previewGambar').attr('src', '/storage/' + data.gambar).show();
            $('#modalTitle').text('Edit Banner');
            $('#modalBanner').modal('show');
        });
    });


    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Yakin?',
            text: 'Banner ini akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/settings/banner/${id}`,
                    type: 'DELETE',
                    success: function () {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Banner berhasil dihapus',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        loadBanner();
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Banner gagal dihapus'
                        });
                    }
                });
            }
        });

    });


    $(document).on('click', '.up', function () {
        let id = $(this).data('id');

        $.post(`/settings/banner/${id}/up`, function () {
            loadBanner();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Urutan banner diperbarui',
                showConfirmButton: false,
                timer: 1500
            });
        });
    });



    $(document).on('click', '.down', function () {
        let id = $(this).data('id');

        $.post(`/settings/banner/${id}/down`, function () {
            loadBanner();
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Urutan banner diperbarui',
                showConfirmButton: false,
                timer: 1500
            });
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
@push('styles')
<style>
#bannerTable.dataTable thead th,
#bannerTable.dataTable tbody td {
    vertical-align: middle !important;
    text-align: center;
}

#bannerTable td:nth-child(2),
#bannerTable th:nth-child(2) {
    text-align: left !important;
}

#bannerTable td img {
    display: block;
    margin: auto;
}
</style>
@endpush

