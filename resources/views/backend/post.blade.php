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
                            <select class="form-select ml-2" name="status" id="status" style="width:200px">
                                <option value="">-- Pilih Status --</option>
                                <option value="Published">Published</option>
                                <option value="Unpublished">Unpublished</option>
                                <option value="Draft">Draft</option>
                            </select>
                            <button class="btn btn-primary ml-3" id="btnTampil">
                                <i class="fas fa-eye"></i> Tampilkan
                            </button>
                        </div>
                        <button id="btnTambahPost" class="btn btn-success btn-icon">
                            <i class="mdi mdi-plus"></i>
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <h4 class="font-weight-bold mb-3">POST</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="user-table">
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
<div class="modal fade" id="modalPost" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <form id="formPost" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="post_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <!-- CONTENT -->
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-header"><strong>Content</strong></div>
                                <div class="card-body">
                                    <textarea name="content" id="contentEditor" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- META -->
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">

                                    <div class="mb-3">
                                        <label>Title</label>
                                        <input type="text" name="title" id="title" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label>Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label>Author</label>
                                        <input type="text" name="author" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <label>Intro</label>
                                        <textarea name="intro" class="form-control" rows="3"></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BOTTOM -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-3 mb-3">
                                    <label>Thumbnail</label>
                                    <input type="file" name="image" class="form-control">
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Category</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">Pilih Category</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="draft">Draft</option>
                                        <option value="published">Published</option>
                                        <option value="published">Unpublished</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label>Published At</label>
                                    <input type="datetime-local" name="published_at" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label>Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>


@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const modalEl = document.getElementById('modalPost');
    const modal = new bootstrap.Modal(modalEl);

    document.getElementById('btnTambahPost').addEventListener('click', function () {
        modal.show();
    });

    modalEl.addEventListener('shown.bs.modal', function () {
        if (!tinymce.get('contentEditor')) {
            tinymce.init({
                selector: '#contentEditor',
                height: 400,
                menubar: true,
                plugins: 'image media table lists link code',
                toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | image media | code'
            });
        }
    });

    modalEl.addEventListener('hidden.bs.modal', function () {
        tinymce.remove('#contentEditor');
        document.getElementById('formPost').reset();
    });

});
</script>

@endpush
