@extends('layouts.backend')

@section('title', 'Data Category')

@section('content')

<div class="container">
    <button id="btnAddCategory" class="btn btn-primary mb-3">
        + Tambah Category
    </button>

    <div class="card">
        <div class="card-body">
            <h3 class="font-weight-bold mb-3">Data Category</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="category-table">
                        <tr>
                            <td colspan="4" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalCategory">
    <div class="modal-dialog">
        <form id="formCategory">
            @csrf
            <input type="hidden" id="category_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah Category</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Category</label>
                        <input type="text" id="nama" name="nama" class="form-control" required>
                        <small class="text-danger error-nama"></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" id="btnSave">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@push('scripts')
<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    loadCategory();

    function loadCategory() {
        $.get("{{ route('category.data') }}", function (data) {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="4" class="text-center">Data kosong</td></tr>`;
            } else {
                $.each(data, function (i, item) {
                    html += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${item.nama}</td>
                        <td>${item.slug}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit" data-id="${item.id}">Edit</button>
                            <button class="btn btn-sm btn-danger delete" data-id="${item.id}">Hapus</button>
                        </td>
                    </tr>`;
                });
            }
            $('#category-table').html(html);
        });
    }

    // buka modal tambah
    $('#btnAddCategory').click(function () {
        $('#formCategory')[0].reset();
        $('#category_id').val('');
        $('.text-danger').text('');
        $('#modalTitle').text('Tambah Category');
        $('#modalCategory').modal('show');
    });

    // simpan / update
    $('#formCategory').submit(function (e) {
        e.preventDefault();
        let id = $('#category_id').val();
        let url = id ? `/categories/${id}` : "{{ route('category.store') }}";
        let data = { nama: $('#nama').val() };

        if (id) data._method = 'PUT';

        $.post(url, data)
        .done(function () {
            $('#modalCategory').modal('hide');
            loadCategory();
        })
        .fail(function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.error-nama').text(errors.nama ? errors.nama[0] : '');
            }
        });
    });

    // edit
    $(document).on('click', '.edit', function () {
        let id = $(this).data('id');
        $.get(`/categories/${id}/edit`, function (data) {
            $('#category_id').val(data.id);
            $('#nama').val(data.nama);
            $('#modalTitle').text('Edit Category');
            $('.text-danger').text('');
            $('#modalCategory').modal('show');
        });
    });

    // hapus
    $(document).on('click', '.delete', function () {
        let id = $(this).data('id');
        if (confirm('Hapus category ini?')) {
            $.ajax({
                url: `/categories/${id}`,
                type: 'DELETE',
                success: function () {
                    loadCategory();
                }
            });
        }
    });

});
</script>
@endpush
