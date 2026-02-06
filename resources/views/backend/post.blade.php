@extends('layouts.backend')

@section('title', 'Post')

@section('content')
<div class="container">
    <button id="btnTambahPost" class="btn btn-primary mb-3">
        + Tambah Berita
    </button>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 class="font-weight-bold mb-3">Data Berita</h3>
                <div class="table-responsive">
                    <table class="table table-hover" id="postTable">
                        <thead class="text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Gambar</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal Publish</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="post-table">
                            {{-- <tr>
                                <td colspan="6" class="text-center">Loading...</td>
                            </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalPost" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <form id="formPost" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="post_id" name="post_id">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Post</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-header"><strong>Konten</strong></div>
                                <div class="card-body">
                                    <textarea name="konten" id="kontenEditor" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label>Judul</label>
                                        <input type="text" name="judul" id="judul" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label>Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label>Kategori</label>
                                        <select name="kategori_id" id="kategori_id" class="form-control">
                                            <option value="">Pilih Kategori</option>
                                        </select>
                                    </div>


                                    <div class="mb-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Tanggal Publish</label>
                                        <input type="datetime-local" name="tanggal_publish" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label>Gambar</label>

                                        <div class="mb-2">
                                            <img id="previewGambar" src="" style="max-height:120px; display:none;">
                                        </div>

                                        <input type="hidden" name="gambar" id="gambar">

                                        <button type="button" class="btn btn-secondary btn-sm" onclick="openFileManager()">
                                            Pilih dari File Manager
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
    let postTable;

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        postTable = $('#postTable').DataTable({
            pageLength: 10,
            ordering: true,
            lengthChange: true,
            searching: true,
            autoWidth: false,
            language: {
                search: "Cari",
                lengthMenu: "Tampilkan _MENU_",
                info: "_START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "‹",
                    next: "›"
                }
            },
            columnDefs: [
                { targets: [0,1,6], className: 'text-center' },
                { targets: [6], orderable: false }
            ]
        });

        loadPost();
    });


    let mode = 'tambah';

    function initEditor(content = '') {
        tinymce.remove('#kontenEditor');
        tinymce.init({
            selector: '#kontenEditor',
            height: 400,
            menubar: false,
            plugins: 'link image lists code',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code',
            setup: function (editor) {
                editor.on('init', function () {
                    editor.setContent(content);
                });
            }
        });
    }

    function loadKategori(selectedId = null) {
        $.get("{{ route('category.list') }}", function (data) {
            let html = '<option value="">Pilih Kategori</option>';
            data.forEach(item => {
                let selected = selectedId == item.id ? 'selected' : '';
                html += `<option value="${item.id}" ${selected}>${item.nama}</option>`;
            });
            $('#kategori_id').html(html);
        });
    }

    $('#btnTambahPost').click(function () {
        mode = 'tambah';
        $('#formPost')[0].reset();
        $('#post_id').val('');
        $('#previewGambar').hide();
        loadKategori();
        initEditor('');
        $('#modalPost').modal('show');
    });

    $(document).on('click', '.edit-post', function () {
        mode = 'edit';
        let id = $(this).data('id');

        $.get(`/post/${id}/edit`, function (data) {
            $('#post_id').val(data.id);
            $('#judul').val(data.judul);
            $('#slug').val(data.slug);
            $('select[name="status"]').val(data.status);
            $('input[name="tanggal_publish"]').val(data.tanggal_publish);
            $('#gambar').val(data.gambar);

            if (data.gambar) {
                $('#previewGambar').attr('src', '/storage/' + data.gambar).show();
            }

            loadKategori(data.kategori_id);
            initEditor(data.konten);

            $('#modalPost').modal('show');
        });
    });

    $('#judul').on('keyup', function () {
        $('#slug').val(
            this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '')
        );
    });
    $('#formPost').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        formData.set('konten', tinymce.get('kontenEditor').getContent());

        let id = $('#post_id').val();

        let url = mode === 'edit'
            ? `/post/${id}`
            : "{{ route('post.tambah') }}";

        $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: res.message ?? 'Post berhasil disimpan',
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#modalPost').modal('hide');
                loadPost();
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Gagal menyimpan data'
                });
            }

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
                        onclick="pilihGambar    ('${file.gambar}')">
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
function loadPost() {

    $.get("{{ route('post.data') }}", function (data) {

        postTable.clear();

        if (data.length === 0) {
            postTable.row.add([
                '',
                'Data kosong',
                '',
                '',
                '',
                '',
                ''
            ]).draw();
            return;
        }

        $.each(data, function (i, post) {

            let gambar = post.gambar
                ? `<img src="/storage/${post.gambar}"
                        style="width:50px;height:50px;object-fit:cover;border-radius:6px;">`
                : `<span class="text-muted">No Image</span>`;


            let statusBadge =
                `<span class="badge badge-${post.status === 'published' ? 'success' : 'secondary'}">
                    ${post.status}
                </span>`;

            postTable.row.add([
                i + 1,
                gambar,
                post.judul,
                post.kategori ? post.kategori.nama : '-',
                statusBadge,
                post.tanggal_publish ?? '-',

                `
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary edit-post" data-id="${post.id}">
                        <i class="mdi mdi-pencil"></i>
                    </button>

                    <button class="btn btn-outline-danger delete-post" data-id="${post.id}">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </div>
                `
            ]);
        });

        postTable.draw();
    });
}



</script>
<script>


$(document).on('click', '.delete-post', function () {

    let id = $(this).data('id');

    Swal.fire({
        title: 'Yakin?',
        text: 'Post ini akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: `/post/${id}`,
                type: 'POST',
                data: {
                    _method: 'DELETE'
                },
                success: function () {

                    Swal.fire({
                        icon: 'success',
                        title: 'Terhapus',
                        text: 'Post berhasil dihapus',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    loadPost();
                }
            });

        }
    });
});

</script>
@endpush
@push('styles')
<style>
#postTable.dataTable thead th,
#postTable.dataTable tbody td {
    text-align: center !important;
    vertical-align: middle !important;
}
</style>
@endpush

