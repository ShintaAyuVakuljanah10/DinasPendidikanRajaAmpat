    @extends('layouts.backend')

    @section('title', 'Pages')

    @section('content')

    <div class="container">
        <div class="row mb-3 align-items-center g-3">
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="searchInput" class="form-control" placeholder="Cari Title...">
                </div>

                <div class="col-md-3">
                    <select id="typeSelect" class="form-control">
                        <option value=""> All Type </option>
                        <option value="Pages">Pages</option>
                        <option value="Sub Pages">Sub Pages</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select id="activeSelect" class="form-control">
                        <option value=""> All Active </option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button id="btnFilter" class="btn btn-primary w-100">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-4 text-end mb-3">
                <button class="btn btn-success" data-toggle="modal" data-target="#modalPage">
                    <i class="mdi mdi-plus"></i>
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
                {{-- <input type="hidden" name="type" id="type"> --}}
                {{-- <input type="hidden" name="parent_id" id="parent_id"> --}}

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
                                    <button type="submit" id="btnSave" class="btn btn-primary px-4">
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
            // DELETE PAGE
            $(document).on('click', '.btn-delete', function () {
                let id = $(this).data('id');

                Swal.fire({
                    title: 'Yakin?',
                    text: 'Page yang dihapus tidak bisa dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/backend/pages/${id}`,
                            type: 'DELETE',
                            success: function () {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Terhapus',
                                    text: 'Page berhasil dihapus',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                loadPages();
                            },
                            error: function () {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Page gagal dihapus'
                                });
                            }
                        });
                    }
                });
            });

            function loadParentPages(selectedId = null) {
                $.get("{{ route('backend.pages.data') }}", function (data) {
                    let html = '<option value="">-- Pilih Parent --</option>';

                    data.forEach(function (page) {
                        // tandai parent yang sudah dipilih saat edit
                        let selected = selectedId == page.id ? 'selected' : '';
                        html += `<option value="${page.id}" ${selected}>${page.title}</option>`;
                    });

                    $('#parent_id').html(html);
                });
            }


            // Ketika Type berubah
            $(document).on('change', '#type', function () {
                const value = $(this).val();

                if (value === 'Sub Pages') {
                    $('#parentWrapper').slideDown();
                    // Jika ada parent_id yang sudah tersimpan (edit), kirim sebagai selectedId
                    let selectedId = $('#parent_id').val() || null;
                    loadParentPages(selectedId);
                } else {
                    $('#parentWrapper').slideUp();
                    $('#parent_id').val(''); // reset parent
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

                    $.get("{{ route('backend.pages.data') }}", function (data) {
                        let html = '<option value="">-- Pilih Parent --</option>';

                        data.forEach(function (page) {
                            if (page.type === 'Pages') {
                                html +=
                                    `<option value="${page.id}">${page.title}</option>`;
                            }
                        });

                        $('#parent_id').html(html);
                    });

                } else {
                    $('#parentWrapper').slideUp();
                    $('#parent_id').val(''); // reset hanya saat bukan Sub Pages
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

            $(document).on('change', '#type', function () {
                if ($(this).val() === 'Sub Pages') {
                    $('#parentWrapper').slideDown();

                    $.get("{{ route('backend.pages.parents') }}", function (data) {
                        let html = '<option value="">-- Pilih Parent --</option>';

                        data.forEach(page => {
                            html += `<option value="${page.id}">${page.title}</option>`;
                        });

                        $('#parent_id').html(html);
                    });

                } else {
                    $('#parentWrapper').slideUp();
                    $('#parent_id').val('');
                }
            });

            // PARENT SELECT
            $(document).on('click', '.parent-select', function (e) {
                e.preventDefault();

                let id = $(this).data('id');

                $('#parent_id').val(id); // INI PENTING
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

            // RESET MODAL SAAT TOMBOL "TAMBAH PAGE" DIKLIK
            $('[data-target="#modalPage"]').click(function () {
                // reset form
                $('#formPage')[0].reset();
                $('#page_id').val(''); // kosongkan id
                $('#type').val(''); // reset type
                $('#active').val('1'); // default active
                $('#parent_id').val(''); // reset parent
                $('#parentWrapper').hide(); // sembunyikan parent
                $('#modalPage .modal-title').text('Tambah Page'); // judul modal
                $('#slug').val(''); // reset slug
                tinymce.get('contentEditor').setContent(''); // reset editor
            });

            // SUBMIT FORM (SAMA KAYA USER)
            // SUBMIT FORM PAGE
            $('#formPage').submit(function (e) {
                e.preventDefault();

                let pageId = $('#page_id').val();
                let url = pageId ?
                    `/backend/pages/${pageId}` :
                    "{{ route('backend.pages.store') }}";

                let formData = new FormData(this);

                // pastikan TinyMCE ikut terkirim
                formData.set('content', tinymce.get('contentEditor').getContent());

                if (pageId) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,

                    success: function () {
                        $('#modalPage').modal('hide');
                        $('#formPage')[0].reset();
                        tinymce.get('contentEditor').setContent('');
                        loadPages();

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: pageId ?
                                'Page berhasil diperbarui' :
                                'Page berhasil ditambahkan',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },

                    error: function (xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let message = '';

                            Object.keys(errors).forEach(function (key) {
                                message += errors[key][0] + '\n';
                            });

                            Swal.fire({
                                icon: 'warning',
                                title: 'Validasi gagal',
                                text: message
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'Terjadi kesalahan pada server'
                            });
                        }
                    }
                });
            });
        });

        document.getElementById('searchInput').addEventListener('input', function () {
            document.getElementById('btnFilter').click();
        });

        document.getElementById('btnFilter').addEventListener('click', function () {
            let search = document.getElementById('searchInput').value.toLowerCase();
            let type = document.getElementById('typeSelect').value;
            let active = document.getElementById('activeSelect').value;

            let tableBody = document.getElementById('pages-table');
            let rows = tableBody.getElementsByTagName('tr');

            for (let row of rows) {
                // Ambil text dari kolom Title (1), Type (2), Active (4)
                let tdTitle = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
                let tdType = row.cells[2] ? row.cells[2].textContent : '';
                let tdActive = row.cells[4] ? row.cells[4].textContent : '';

                let show = true;

                // Filter search text di Title
                if (search && !tdTitle.includes(search)) {
                    show = false;
                }

                // Filter Type
                if (type && tdType !== type) {
                    show = false;
                }

                // Filter Active
                if (active && tdActive !== active) {
                    show = false;
                }

                row.style.display = show ? '' : 'none';
            }
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
