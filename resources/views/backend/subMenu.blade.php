@extends('layouts.backend')

@section('title', 'Sub Menu')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Sub Menu Management</h4>

        <button class="btn btn-success" data-toggle="modal" data-target="#modalSubMenu">
            <i class="mdi mdi-plus"></i>
        </button>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Icon</th>
                        <th>Route</th>
                        <th>Parent</th>
                        <th>Active</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="submenu-table">
                    <tr>
                        <td colspan="7" class="text-center">Loading...</td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>

</div>

<div class="modal fade" id="modalSubMenu" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="formSubMenu" class="w-100">
            @csrf
            <input type="hidden" id="submenu_id">

            <div class="modal-content rounded-4">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold row mb-0">Tambah Data</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="fw-semibold">Nama Sub Menu</label>
                            <input type="text" id="name" class="form-control" placeholder="Masukkan Nama Sub Menu">
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold">Icon</label>
                            <input type="text" id="icon" class="form-control" value="-" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold">Route</label>
                            <input type="text" id="route" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="fw-semibold">Parent</label>
                            <select id="parent_id" class="form-control">
                                <option value="">Pilih Parent Menu</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="fw-semibold">Active ?</label><br>
                            <input type="checkbox" id="active" checked>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary px-4">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function () {

        loadSubMenu();
        loadParentMenu();

        function loadSubMenu() {
            $.get("{{ route('backend.submenu.data') }}", function (data) {
                let html = '';
                let no = 1;

                data.forEach(item => {
                    html += `
                <tr>
                    <td>${no++}</td>
                    <td>${item.name}</td>
                    <td>${item.icon ?? '-'}</td>
                    <td>${item.route}</td>
                    <td>${item.parent_name}</td>
                    <td>
                        ${item.active
                            ? '<span class="badge bg-success">Yes</span>'
                            : '<span class="badge bg-secondary">No</span>'}
                    </td>
                    <td>
                        <button class="btn btn-sm btn-primary btn-edit" data-id="${item.id}">
                            <i class="mdi mdi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="${item.id}">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </td>
                </tr>`;
                });

                $('#submenu-table').html(html);
            });
        }

        function loadParentMenu() {
            $.get("{{ route('backend.menu.parent') }}", function (data) {
                let html = '<option value="">Pilih Parent Menu</option>';

                data.forEach(menu => {
                    html += `<option value="${menu.id}">${menu.name}</option>`;
                });

                $('#parent_id').html(html);
            });
        }

        // SUBMIT
        $('#formSubMenu').submit(function (e) {
            e.preventDefault();

            let id = $('#submenu_id').val();
            let url = id ? `/backend/submenu/${id}` : "{{ route('backend.submenu.store') }}";

            let data = {
                name: $('#name').val(),
                icon: $('#icon').val(),
                route: $('#route').val(),
                parent_id: $('#parent_id').val(),
                active: $('#active').is(':checked') ? 1 : 0,
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            if (id) data._method = 'PUT';

            $.post(url, data, function () {
                $('#modalSubMenu').modal('hide');
                $('#formSubMenu')[0].reset();
                $('#active').prop('checked', true);
                loadSubMenu();
            });
        });

        // EDIT
        $(document).on('click', '.btn-edit', function () {
            let id = $(this).data('id');

            $.get(`/backend/submenu/${id}`, function (data) {
                $('#submenu_id').val(data.id);
                $('#name').val(data.name);
                $('#icon').val(data.icon);
                $('#route').val(data.route);
                $('#parent_id').val(data.parent_id);
                $('#active').prop('checked', data.active);

                $('.modal-title').text('Edit Data');
                $('#modalSubMenu').modal('show');
            });
        });

        // DELETE
        $(document).on('click', '.btn-delete', function () {
            if (!confirm('Yakin hapus submenu ini?')) return;

            let id = $(this).data('id');

            $.ajax({
                url: `/backend/submenu/${id}`,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: loadSubMenu
            });
        });

    });

</script>
@endpush
