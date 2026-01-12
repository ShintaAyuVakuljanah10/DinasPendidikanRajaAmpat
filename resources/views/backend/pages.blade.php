    @extends('layouts.backend')

    @section('title', 'Pages')

    @section('content')

    <div class="container">
        <div class="row mb-3 align-items-center g-3">
            <div class="col-md-3">
                <div class="dropdown w-100">
                    <button class="btn btn-outline-info dropdown-toggle w-100" data-toggle="dropdown">
                        <span>-- Pilih Tipe --</span>
                    </button>
                    <div class="dropdown-menu w-100">
                        <a class="dropdown-item dropdown-select" href="#" data-value="Pages"
                            data-target="filter_type">Pages</a>
                        <a class="dropdown-item dropdown-select" href="#" data-value="Sub Pages"
                            data-target="filter_type">Sub Pages</a>
                    </div>
                </div>
                <input type="hidden" id="filter_type">
            </div>

            <div>
                <div class="dropdown">
                    <button class="btn btn-outline-info dropdown-toggle w-100" data-toggle="dropdown">
                        <span id="activeText">Yes</span>
                    </button>
                    <div class="dropdown-menu w-100">
                        <a class="dropdown-item dropdown-select" href="#" data-value="1" data-target="active">Yes</a>
                        <a class="dropdown-item dropdown-select" href="#" data-value="0" data-target="active">No</a>
                    </div>
                </div>
            </div>


            <div class="col-md-2">
                <button class="btn btn-primary w-100">Tampilkan</button>
            </div>

            <div class="col-md-4 text-end">
                <button class="btn btn-success" data-toggle="modal" data-target="#modalPage">
                    Tambah Page
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-3">Data Pages</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Parent</th>
                            <th>Active</th>
                            <th>Order</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pages-table">
                        <tr>
                            <td colspan="7" class="text-center">Loading...</td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="modalPage" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <form id="formPage" class="w-100">
                @csrf

                <input type="hidden" name="id" id="page_id">
                <input type="hidden" name="active" id="active" value="1">
                <input type="hidden" name="type" id="type">
                <input type="hidden" name="parent_id" id="parent_id">

                <div class="modal-content rounded-4">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold">Tambah Page</h5>
                        <button type="button" class="close text-dark" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row g-4">

                            <!-- CONTENT -->
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-header fw-bold">Content</div>
                                    <div class="card-body">
                                        <textarea name="content" id="contentEditor" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- SETTINGS -->
                            <div class="col-lg-4">
                                <div class="vstack gap-3">

                                    <div>
                                        <label class="fw-semibold">Title</label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="Judul halaman">
                                    </div>

                                    <div>
                                        <label class="fw-semibold">Slug</label>
                                        <input type="text" name="slug" id="slug" class="form-control"
                                            placeholder="contoh-halaman">
                                    </div>

                                    <div>
                                        <label class="fw-semibold">Type</label>
                                        <select class="form-control" id="type" name="type">
                                            <option value="">-- Select --</option>
                                            <option value="Pages">Pages</option>
                                            <option value="Sub Pages">Sub Pages</option>
                                        </select>
                                    </div>

                                    <div id="parentWrapper" style="display:none">
                                        <label class="fw-semibold">Parent Page</label>
                                        <select class="form-control" name="parent_id" id="parent_id">
                                            <option value="">-- Pilih Parent --</option>
                                            <!-- DIISI VIA AJAX -->
                                        </select>
                                    </div>

                                </div>
                                <hr>
                                <div>
                                    <label class="fw-semibold">Meta Title (SEO)</label>
                                    <input type="text" name="meta_title" class="form-control"
                                        placeholder="Judul untuk SEO (opsional)">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary px-4">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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

            loadPages();

            function loadPages() {
                $.get("{{ route('backend.pages.data') }}", function (data) {
                    let html = '';

                    if (data.length === 0) {
                        html = `<tr><td colspan="7" class="text-center">Data kosong</td></tr>`;
                    } else {
                        $.each(data, function (i, page) {
                            html += `
                        <tr>
                            <td>${i+1}</td>
                            <td>${page.title}</td>
                            <td>${page.type}</td>
                            <td>${page.parent ?? '-'}</td>
                            <td>
                                ${page.active == 1 
                                    ? '<span class="badge badge-success">Active</span>' 
                                    : '<span class="badge badge-secondary">Inactive</span>'}
                            </td>
                            <td>${page.sort_order ?? 0}</td>
                            <td>
                                <button class="btn btn-sm btn-warning btn-edit" data-id="${page.id}">Edit</button>
                                <button class="btn btn-sm btn-danger btn-delete" data-id="${page.id}">Hapus
                                </button>
                            </td>
                        </tr>`;
                        });
                    }

                    $('#pages-table').html(html);
                });
            }

            $(document).on('click', '.btn-edit', function () {
                let id = $(this).data('id');

                $.get(`/backend/pages/${id}`, function (data) {
                    $('#modalTitle').text('Edit Page');
                    $('#btnSave').text('Update');

                    $('#page_id').val(data.id);
                    $('#title').val(data.title);
                    $('#slug').val(data.slug);
                    $('#type').val(data.type);
                    $('#parent_id').val(data.parent_id);
                    $('#active').val(data.active);
                    $('#meta_title').val(data.meta_title);

                    if (data.type === 'Sub Pages') {
                        $('#parentWrapper').show();
                        loadParentPages();
                    } else {
                        $('#parentWrapper').hide();
                    }

                    $('#modalPage').modal('show');
                });
            });

            // ================= DELETE PAGE =================
            $(document).on('click', '.btn-delete', function () {
                let id = $(this).data('id');

                if (!confirm('Yakin ingin menghapus page ini?')) return;

                $.ajax({
                    url: `/backend/pages/${id}`,
                    type: 'DELETE',
                    success: function () {
                        loadPages();
                    },
                    error: function () {
                        alert('Gagal menghapus data');
                    }
                });
            });

            function loadParentPages(selectedId = null) {
                $.get("{{ route('backend.pages.data') }}", function (data) {
                    let html = '<option value="">-- Pilih Parent --</option>';

                    data.forEach(function (page) {
                        let selected = selectedId == page.id ? 'selected' : '';
                        html += `<option value="${page.id}" ${selected}>${page.title}</option>`;
                    });

                    $('#parent_id').html(html); // isi select dengan data
                });
            }

            // Ketika Type berubah
            $(document).on('change', '#type', function () {
                const value = $(this).val();
                if (value === 'Sub Pages') {
                    $('#parentWrapper').slideDown();
                    loadParentPages();
                } else {
                    $('#parentWrapper').slideUp();
                    $('#parent_id').val('');
                }
            });

            $(document).on('change', '#type', function () {
                const value = $(this).val();

                if (value === 'Sub Pages') {
                    $('#parentWrapper').slideDown();
                    loadParentPages(); // load parent pages
                } else {
                    $('#parentWrapper').slideUp();
                    $('#parent_id').val('');
                }
            });


            $(document).on('change', '#type', function () {
                const value = $(this).val();

                if (value === 'Sub Pages') {
                    $('#parentWrapper').slideDown();
                    loadParentPages(); // ⬅️ PENTING
                } else {
                    $('#parentWrapper').slideUp();
                    $('#parent_id').val('');
                    $('#parentText').text('-- Pilih Parent --');
                }
            });

            // TYPE SELECT
            $(document).on('click', '.type-select', function (e) {
                e.preventDefault();

                let value = $(this).data('value');

                $('#type').val(value);
                $('#typeText').text(value);

                if (value === 'Sub Pages') {
                    $('#parentWrapper').slideDown();
                } else {
                    $('#parentWrapper').slideUp();
                    $('#parent_id').val('');
                    $('#parentText').text('-- Pilih Parent --');
                }
            });

            // PARENT SELECT
            $(document).on('click', '.parent-select', function (e) {
                e.preventDefault();

                $('#parent_id').val($(this).data('id'));
                $('#parentText').text($(this).text());
            });

            // DROPDOWN SELECT (ACTIVE)
            $(document).on('click', '.dropdown-select', function (e) {
                e.preventDefault();

                let value = $(this).data('value');
                let target = $(this).data('target');

                $('#' + target).val(value);
                $('#' + target + 'Text').text($(this).text());
            });

            // OPEN / CLOSE DROPDOWN
            $('.dropdown-btn').on('click', function (e) {
                e.stopPropagation();

                $('.manual-dropdown').not($(this).closest('.manual-dropdown')).removeClass('show');
                $(this).closest('.manual-dropdown').toggleClass('show');
            });

            // SELECT ITEM
            $(document).on('click', '.dropdown-select', function (e) {
                e.preventDefault();

                let value = $(this).data('value');
                let target = $(this).data('target');
                let text = $(this).text();

                $('#' + target).val(value);
                $('#' + target + 'Text').text(text);

                $(this).closest('.manual-dropdown').removeClass('show');
            });

            // SEARCH
            $(document).on('keyup', '.dropdown-search', function () {
                let keyword = $(this).val().toLowerCase();

                $(this).siblings('.dropdown-item').each(function () {
                    $(this).toggle($(this).text().toLowerCase().includes(keyword));
                });
            });

            // CLICK OUTSIDE → CLOSE
            $(document).on('click', function () {
                $('.manual-dropdown').removeClass('show');
            });

            // SUBMIT FORM (SAMA KAYA USER)
            $('#formPage').submit(function (e) {
                e.preventDefault();

                let pageId = $('#page_id').val(); // cek apakah ada id → artinya edit
                let url = pageId ?
                    `/backend/pages/${pageId}` // route update
                    :
                    "{{ route('backend.pages.store') }}"; // route tambah
                let type = pageId ? 'POST' : 'POST'; // tetap POST, tapi tambahkan _method untuk edit

                let formData = new FormData(this);

                if (pageId) {
                    formData.append('_method', 'PUT'); // Laravel akan menganggap ini update
                }

                $.ajax({
                    url: url,
                    type: type,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function () {
                        $('#modalPage').modal('hide');
                        $('#formPage')[0].reset();
                        loadPages(); // refresh tabel
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
        $(document).ready(function () {

            function generateSlug(text) {
                return text
                    .toString()
                    .toLowerCase()
                    .trim()
                    .replace(/[^\w\s]+/g, '');
            }

            $('#title').on('keyup change', function () {
                let title = $(this).val();
                $('#slug').val(generateSlug(title));
            });

        });

    </script>


    <script>
        tinymce.init({
            selector: '#contentEditor',
            height: 300,
            menubar: 'file edit view insert format table',
            plugins: 'table lists link code',
            toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | table | code'
        });

    </script>
    @endpush
