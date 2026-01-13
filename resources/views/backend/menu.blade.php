@extends('layouts.backend')

@section('title', 'Menu')

@section('content')

<div class="container">
    <div class="row mb-3 align-items-center g-3">

        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari Title...">
            </div>

            <div class="col-md-3">
                <select id="typeSelect" class="form-control">
                    <option value="">All Type</option>
                    <option value="Main">Main</option>
                    <option value="Sub">Sub</option>
                </select>
            </div>

            <div class="col-md-2">
                <button id="btnFilter" class="btn btn-primary w-100">
                    <i class="mdi mdi-magnify"></i>
                </button>
            </div>
        </div>

        <div class="col-md-4 text-end mb-3">
            <button class="btn btn-success" data-toggle="modal" data-target="#modalMenu">
                <i class="mdi mdi-plus"></i>
            </button>
        </div>

    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="fw-bold mb-3">Data Menu</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Icon</th>
                        <th>Route</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="menu-table">
                    <tr>
                        <td colspan="6" class="text-center">Loading...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalMenu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form id="formMenu" class="w-100">
            @csrf
            <input type="hidden" name="id" id="menu_id">

            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Menu</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div class="vstack gap-3">

                                <!-- Title -->
                                <div>
                                    <label class="fw-semibold">Title</label>
                                    <input type="text" name="title" id="title" class="form-control"
                                        placeholder="Judul menu">
                                </div>

                                <!-- Type -->
                                <div>
                                    <label class="fw-semibold">Type</label>
                                    <select class="form-control" id="type" name="type">
                                        <option value="">-- Select --</option>
                                        <option value="Main">Main</option>
                                        <option value="Sub">Sub</option>
                                    </select>
                                </div>

                                <!-- Parent Menu (MUNCUL JIKA TYPE = SUB) -->
                                <div id="parentMenuWrapper" style="display:none;">
                                    <label class="fw-semibold">Parent Menu</label>
                                    <select class="form-select" name="parent_id" id="parent_id">
                                        <option value="">-- Pilih Main Menu --</option>
                                        {{-- contoh data --}}
                                        {{-- @foreach($mainMenus as $menu) --}}
                                        {{-- <option value="{{ $menu->id }}">{{ $menu->title }}</option> --}}
                                        {{-- @endforeach --}}
                                    </select>
                                </div>

                                <!-- Pakai Sub Menu -->
                                <div id="useSubMenuWrapper" style="display:none;">
                                    <label class="fw-semibold">Pakai Sub Menu?</label>
                                    <select class="form-select" name="use_sub_menu" id="use_sub_menu">
                                        <option value="0">Tidak</option>
                                        <option value="1">Ya</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="fw-semibold">Icon</label>
                                    <select class="form-select" name="icon" id="iconSelect">
                                        <option value="">-- Select Icon --</option>
                                        <option value="mdi mdi-view-dashboard" data-icon="mdi-view-dashboard">Dashboard
                                        </option>
                                        <option value="mdi mdi-view-grid" data-icon="mdi-view-grid">Grid</option>
                                        <option value="mdi mdi-layers" data-icon="mdi-layers">Stack</option>
                                        <option value="mdi mdi-account-group" data-icon="mdi-account-group">People
                                        </option>
                                        <option value="mdi mdi-book-open-page-variant"
                                            data-icon="mdi-book-open-page-variant">Book</option>
                                        <option value="mdi mdi-cog" data-icon="mdi-cog">Settings</option>
                                        <option value="mdi mdi-account-circle" data-icon="mdi-account-circle">Profile
                                        </option>
                                        <option value="mdi mdi-calendar-month" data-icon="mdi-calendar-month">Calendar
                                        </option>
                                        <option value="mdi mdi-email" data-icon="mdi-email">Mail</option>
                                        <option value="mdi mdi-chat" data-icon="mdi mdi-chat">Chat</option>
                                        <option value="mdi mdi-bell" data-icon="mdi-bell">Notification</option>
                                    </select>
                                </div>

                                <!-- Route -->
                                <div>
                                    <label class="fw-semibold">Route</label>
                                    <input type="text" name="route" id="route" class="form-control"
                                        placeholder="Contoh: backend.dashboard">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" id="btnSave" class="btn btn-primary px-4">
                        Save
                    </button>
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
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        loadMenus();

        function loadMenus() {
            $.get("{{ route('backend.menu.data') }}", function (data) {
                let html = '';

                if (data.length === 0) {
                    html = `<tr><td colspan="6" class="text-center">Data kosong</td></tr>`;
                } else {
                    $.each(data, function (i, menu) {
                        html += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${menu.title}</td>
                        <td>${menu.type}</td>
                        <td><i class="${menu.icon}"></i> ${menu.icon}</td>
                        <td>${menu.route}</td>
                        <td>
                            <button class="btn btn-sm btn-warning btn-edit" data-id="${menu.id}">Edit</button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${menu.id}">Hapus</button>
                        </td>
                    </tr>`;
                    });
                }

                $('#menu-table').html(html);
            });
        }

        // FILTER / SEARCH
        $('#btnFilter').on('click', function () {
            let search = $('#searchInput').val().toLowerCase();
            let type = $('#typeSelect').val();

            $('#menu-table tr').each(function () {
                let tdTitle = $(this).find('td:eq(1)').text().toLowerCase();
                let tdType = $(this).find('td:eq(2)').text();

                let show = true;

                if (search && !tdTitle.includes(search)) show = false;
                if (type && tdType !== type) show = false;

                $(this).toggle(show);
            });
        });

        $('#searchInput').on('input', function () {
            $('#btnFilter').click();
        });

        // OPEN MODAL UNTUK TAMBAH MENU
        $('[data-target="#modalMenu"]').click(function () {
            $('#formMenu')[0].reset();
            $('#menu_id').val('');
            $('#modalMenu .modal-title').text('Tambah Menu');
        });

        // EDIT MENU
        $(document).on('click', '.btn-edit', function () {
            let id = $(this).data('id');

            $.get(`/backend/menu/${id}`, function (data) {
                $('#modalMenu .modal-title').text('Edit Menu');
                $('#btnSave').text('Update');

                $('#menu_id').val(data.id);
                $('#title').val(data.title);
                $('#type').val(data.type);
                $('#icon').val(data.icon);
                $('#route').val(data.route);

                $('#modalMenu').modal('show');
            });
        });

        // DELETE MENU
        $(document).on('click', '.btn-delete', function () {
            let id = $(this).data('id');
            if (!confirm('Yakin ingin menghapus menu ini?')) return;

            $.ajax({
                url: `/backend/menu/${id}`,
                type: 'DELETE',
                success: function () {
                    loadMenus();
                },
                error: function () {
                    alert('Gagal menghapus data');
                }
            });
        });

        $(document).ready(function () {

            function formatIcon(option) {
                if (!option.id) return option.text;

                const icon = $(option.element).data('icon');
                if (!icon) return option.text;

                return $(`
        <span class="d-flex align-items-center gap-2">
            <i class="mdi ${icon}" style="font-size:18px"></i>
            <span>${option.text}</span>
        </span>
    `);
            }

            $('#iconSelect').select2({
                dropdownParent: $('#modalPage'), // ganti sesuai ID modal kamu
                width: '100%',
                templateResult: formatIcon,
                templateSelection: formatIcon
            });

        });

        // SUBMIT FORM
        $('#formMenu').submit(function (e) {
            e.preventDefault();

            let menuId = $('#menu_id').val();
            let url = menuId ? `/backend/menu/${menuId}` : "{{ route('backend.menu.store') }}";
            let formData = $(this).serialize();

            if (menuId) formData += '&_method=PUT';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function (res) {
                    $('#modalMenu').modal('hide');
                    $('#formMenu')[0].reset();
                    loadMenus();
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    alert('Gagal menyimpan data');
                }
            });
        });

    });

</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const useSubMenuWrapper = document.getElementById('useSubMenuWrapper');
        const useSubMenuSelect = document.getElementById('use_sub_menu');
        const routeInput = document.getElementById('route');

        function handleTypeChange() {
            if (typeSelect.value === 'Main') {
                useSubMenuWrapper.style.display = 'block';
                handleSubMenuChange();
            } else {
                useSubMenuWrapper.style.display = 'none';
                routeInput.disabled = false;
            }
        }

        function handleSubMenuChange() {
            if (useSubMenuSelect.value === '1') {
                routeInput.value = '';
                routeInput.disabled = true;
            } else {
                routeInput.disabled = false;
            }
        }

        typeSelect.addEventListener('change', handleTypeChange);
        useSubMenuSelect.addEventListener('change', handleSubMenuChange);
    });

</script>
<script>
    $('#modalMenu').on('shown.bs.modal', function () {

        $('#iconSelect').select2({
            dropdownParent: $('#modalMenu'),
            width: '100%',
            placeholder: '-- Select Icon --',
            allowClear: true,
            templateResult: formatIcon,
            templateSelection: formatIcon
        });

    });

    function formatIcon(option) {
        if (!option.id) return option.text;

        const icon = $(option.element).data('icon');
        if (!icon) return option.text;

        return $(`
            <span class="d-flex align-items-center gap-2">
                <i class="mdi ${icon}" style="font-size:18px"></i>
                <span>${option.text}</span>
            </span>
        `);
    }

</script>

<script>
    $(document).ready(function () {

        const type = $('#type');
        const useSubMenuWrapper = $('#useSubMenuWrapper');
        const useSubMenu = $('#use_sub_menu');
        const route = $('#route');
        const parentMenuWrapper = $('#parentMenuWrapper');

        function resetFields() {
            route.prop('disabled', false);
            useSubMenu.val('0');
        }

        type.on('change', function () {
            const val = $(this).val();

            if (val === 'Main') {
                useSubMenuWrapper.show();
                parentMenuWrapper.hide();
                resetFields();
                handleSubMenu();
            }

            if (val === 'Sub') {
                useSubMenuWrapper.hide();
                parentMenuWrapper.show();
                route.prop('disabled', false);
            }

            if (val === '') {
                useSubMenuWrapper.hide();
                parentMenuWrapper.hide();
                route.prop('disabled', false);
            }
        });

        function handleSubMenu() {
            if (useSubMenu.val() === '1') {
                route.val('').prop('disabled', true);
            } else {
                route.prop('disabled', false);
            }
        }

        useSubMenu.on('change', handleSubMenu);

    });

</script>

@endpush
