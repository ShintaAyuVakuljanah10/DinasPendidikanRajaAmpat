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
                <table class="table table-hover" id="categoryTable">
                    <thead class="text-center">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="category-table">
                        {{-- <tr>
                            <td colspan="4" class="text-center">Loading...</td>
                        </tr> --}}
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
let categoryTable;
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    categoryTable = $('#categoryTable').DataTable({
        ordering: true,
        searching: true,
        pageLength: 10,
        autoWidth: false,
        columnDefs: [
            { targets: [0,3], orderable: false }
        ]
    });

    loadCategory();

    function loadCategory() {
        $.get("{{ route('category.data') }}", function (data) {

            categoryTable.clear();

            if (data.length === 0) {
                categoryTable.row.add([
                    '',
                    'Data kosong',
                    '',
                    ''
                ]).draw();
                return;
            }

            $.each(data, function (i, item) {
                categoryTable.row.add([
                    i + 1,
                    item.nama,
                    item.slug,
                    `
                    <div class="btn-group btn-group-sm" role="group">
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

            categoryTable.draw();
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

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: $('#category_id').val()
                    ? 'Category berhasil diperbarui'
                    : 'Category berhasil ditambahkan',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        })

        .fail(function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                $('.error-nama').text(errors.nama ? errors.nama[0] : '');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan pada server'
                });
            }
        });

    });

    // edit
    $(document).on('click', '.btn-edit', function () {
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
    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Yakin?',
            text: 'Category ini akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/categories/${id}`,
                    type: 'DELETE',
                    success: function () {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Category berhasil dihapus',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        loadCategory();
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Category gagal dihapus'
                        });
                    }
                });
            }
        });

    });

});
</script>
@endpush
