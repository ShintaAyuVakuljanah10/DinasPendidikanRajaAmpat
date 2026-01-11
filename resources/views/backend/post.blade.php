@extends('layouts.backend')

@section('title', 'Post')

@section('content')
<div class="container">
    <div class="card">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <h5 class="mb-0 me-3">Filter: </h5>
                            <select class="form-control ml-2" id="filter_status" style="width:200px">
                                <option value="">-- Semua Status --</option>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                            <button class="btn btn-primary ml-3" id="btnFilter">
                                <i class="fas fa-eye"></i> Tampilkan
                            </button>
                        </div>

                        <button id="btnTambahPost" class="btn btn-success btn-icon">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>
                </div>


                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th>Tanggal Publish</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="post-table">
                                <tr>
                                    <td colspan="6" class="text-center">Loading...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalPost" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <form id="formPost" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Post</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>


                <div class="modal-body">
                    <div class="row">

                        <!-- KONTEN -->
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-header"><strong>Konten</strong></div>
                                <div class="card-body">
                                    <textarea name="konten" id="kontenEditor" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- META -->
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

                                        <!-- preview -->
                                        <div class="mb-2">
                                            <img id="previewGambar" src="" style="max-height:120px; display:none;">
                                        </div>

                                        <!-- input hidden -->
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
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>

<script>
$(document).ready(function () {

    function loadKategori(selectedId = null) {
        $.get("{{ route('category.list') }}", function (data) {
            let html = '<option value="">Pilih Kategori</option>';
            $.each(data, function (i, item) {
                let selected = selectedId == item.id ? 'selected' : '';
                html += `<option value="${item.id}" ${selected}>${item.nama}</option>`;
            });
            $('#kategori_id').html(html);
        });
    }
    $('#btnTambahPost').click(function () {
        $('#formPost')[0].reset();
        loadKategori(); 
        $('#modalPost').modal('show');
    });
    $('#modalPost').on('shown.bs.modal', function () {
        tinymce.remove('#kontenEditor');

        tinymce.init({
            selector: '#kontenEditor',
            height: 400,
            menubar: false,
            plugins: 'link image lists code',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | link image | code'
        });
    });

    $('#modalPost').on('hidden.bs.modal', function () {
        tinymce.remove('#kontenEditor');
        $('#formPost')[0].reset();
    });
    $('#judul').on('keyup', function () {
        $('#slug').val(
            this.value.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '')
        );
    });
    $(document).on('click', '.edit-post', function () {
        let id = $(this).data('id');

        $.get(`/posts/${id}/edit`, function (data) {
            $('#judul').val(data.judul);
            $('#slug').val(data.slug);
            $('select[name="status"]').val(data.status);
            $('input[name="tanggal_publish"]').val(data.tanggal_publish);

            loadKategori(data.kategori_id);

            $('#modalPost').modal('show');
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
