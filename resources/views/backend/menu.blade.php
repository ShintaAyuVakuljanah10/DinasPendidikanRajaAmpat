@extends('layouts.backend')

@section('title', 'Menu')

@section('content')
<div class="container">
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h3 class="fw-bold">Menu Management</h3>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-success" data-toggle="modal" data-target="#modalMenu">
                <i class="mdi mdi-plus"></i>
            </button>
        </div>
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
                        <th>Active</th>
                        <th>Order</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="menu-table">
                    <tr>
                        <td colspan="7" class="text-center">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


<div class="modal fade" id="modalMenu" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="formMenu">
            @csrf
            <input type="hidden" id="menu_id">

            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Menu</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="fw-semibold">Nama Menu</label>
                            <input type="text" id="name" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold">Icon</label>
                            <select id="icon" class="form-control">
                                <option value="">-- Select Icon --</option>
                        
                                <option value="bi bi-grid">🟦 Grid</option>
                                <option value="bi bi-stack">📚 Stack</option>
                                <option value="bi bi-grid-1x2-fill">🧩 Grid 1x2 Fill</option>
                                <option value="bi bi-people-fill">👥 People</option>
                                <option value="bi bi-book">📖 Book</option>
                                <option value="bi bi-gear">⚙️ Settings</option>
                                <option value="bi bi-person">👤 Profile</option>
                                <option value="bi bi-calendar">📅 Calendar</option>
                                <option value="bi bi-envelope">✉️ Mail</option>
                                <option value="bi bi-chat-dots">💬 Chat</option>
                                <option value="bi bi-bell">🔔 Notification</option>
                            </select>
                        </div>                        

                        <div class="col-md-6">
                            <label class="fw-semibold">Route</label>
                            <input type="text" id="route" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="fw-semibold">Active?</label><br>
                            <input type="checkbox" id="active" checked>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>


@push('scripts')
<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        loadMenu();

        function loadMenu() {
            $.get("{{ route('backend.menu.data') }}", function (data) {
                let html = '';

                if (data.length === 0) {
                    html = `<tr><td colspan="7" class="text-center">Data kosong</td></tr>`;
                } else {
                    $.each(data, function (i, menu) {
                        html += `
                <tr>
                    <td>${i + 1}</td>
                    <td>${menu.name}</td>
                    <td><span class="badge badge-info">${menu.icon}</span></td>
                    <td>${menu.route ?? '-'}</td>
                    <td>
                        ${menu.active 
                            ? '<span class="badge badge-success">Yes</span>' 
                            : '<span class="badge badge-secondary">No</span>'}
                    </td>
                    <td>${menu.sort_order}</td>
                    <td>
                        <button class="btn btn-sm btn-primary btn-edit" data-id="${menu.id}">
                            <i class="mdi mdi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="${menu.id}">
                            <i class="mdi mdi-delete"></i>
                        </button>
                    </td>
                </tr>`;
                    });
                }

                $('#menu-table').html(html);
            });
        }

        $(document).ready(function () {
            loadMenu();
        });

        $(document).on('click', '.btn-edit', function () {
            let id = $(this).data('id');

            $.get(`/backend/menu/${id}`, function (data) {
                $('#menu_id').val(data.id);
                $('#name').val(data.name);
                $('#icon').val(data.icon);
                $('#route').val(data.route);
                $('#active').prop('checked', data.active == 1);

                $('.modal-title').text('Edit Menu');
                $('#modalMenu').modal('show');
            });
        });

        $(document).on('click', '.btn-delete', function () {
            let id = $(this).data('id');

            if (!confirm('Yakin ingin menghapus menu ini?')) return;

            $.ajax({
                url: `/backend/menu/${id}`,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    loadMenu();
                }
            });
        });

        $('#formMenu').submit(function (e) {
            e.preventDefault();

            let id = $('#menu_id').val();
            let url = id ? `/backend/menu/${id}` : `/backend/menu`;

            let data = {
                name: $('#name').val(),
                icon: $('#icon').val(),
                route: $('#route').val(),
                active: $('#active').is(':checked') ? 1 : 0,
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            if (id) data._method = 'PUT';

            $.post(url, data, function () {
                $('#modalMenu').modal('hide');
                $('#formMenu')[0].reset();
                loadMenu();
            });
        });
    });

</script>
@endpush
