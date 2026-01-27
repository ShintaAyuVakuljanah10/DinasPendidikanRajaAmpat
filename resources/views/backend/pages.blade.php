    @extends('layouts.backend')

    @section('title', 'Pages')

    @section('content')

    <div class="container">
        <div class="row mb-3 align-items-center g-3">
            <div class="col-md-8">
                <div class="row g-2 align-items-center">
            
                    <div class="col-md-5">
                        <select id="typeSelect" class="form-control">
                            <option value="">All Type</option>
                            <option value="Pages">Pages</option>
                            <option value="Sub Pages">Sub Pages</option>
                        </select>
                    </div>
            
                    <div class="col-md-5">
                        <select id="activeSelect" class="form-control">
                            <option value="">All Active</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
            
                    <div class="col-md-1 d-flex align-items-end">
                        <button id="btnFilter" class="btn btn-primary px-4 py-3">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </div>
            
                </div>
            </div>            
        
            <div class="col-md-2 text-end">
                <button class="btn btn-success px-4 py-3" data-toggle="modal" data-target="#modalPage">
                    <i class="mdi mdi-plus"></i>
                </button>
            </div>          
        </div>
        
        <div class="card">
            <div class="card-body">
                <h3 class="fw-bold mb-3">Data Pages</h3>
                <table class="table table-hover align-middle" id="pagesTable">
                    <thead class="text-center">
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
                    <tbody>
                        {{-- <tr>
                            <td colspan="7" class="text-center">Loading...</td>
                        </tr> --}}
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
                                        <textarea  id="contentEditor" name="content"> </textarea>
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

                                    <div>
                                        <label class="fw-semibold">Template Halaman</label>
                                        <select name="handler" id="handler" class="form-control">
                                            <option value="page">Page Biasa</option>
                                            <option value="download">Download</option>
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
        let pagesTable;

        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            pagesTable = $('#pagesTable').DataTable({
                pageLength: 10,
                ordering: true,
                lengthChange: true,
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
                columnDefs: [{
                        targets: [0, 4, 5, 6],
                        className: 'text-center'
                    },
                    {
                        targets: [6],
                        orderable: false
                    }
                ]
            });

            $.fn.dataTable.ext.search.push(function (settings, data) {

                let type = $('#typeSelect').val();
                let active = $('#activeSelect').val();

                let colType = data[2]; // kolom Type
                let colActive = $('<div>').html(data[4]).text().trim(); // Yes / No

                if (type && colType !== type) {
                    return false;
                }

                if (active && colActive !== active) {
                    return false;
                }

                return true;
            });

            $('#btnFilter, #typeSelect, #activeSelect').on('change click', function () {
                pagesTable.draw();
            });

            loadPages();
        });

        function loadPages() {
            $.get("{{ route('backend.pages.data') }}", function (data) {

                pagesTable.clear();

                data.forEach((page, i) => {
                    pagesTable.row.add([
                        i + 1,
                        page.title,
                        page.type,
                        page.parent ?? '-',
                        page.active == 1
                            ? '<span class="badge badge-success">Yes</span>'
                            : '<span class="badge badge-secondary">No</span>',
                        page.sort_order ?? 0,
                        `
                        <div class="btn-group btn-group-sm" role="group">
                            <button class="btn btn-outline-secondary up" data-id="${page.id}">
                                <i class="mdi mdi-arrow-up"></i>
                            </button>
                            <button class="btn btn-outline-secondary down" data-id="${page.id}">
                                <i class="mdi mdi-arrow-down"></i>
                            </button>
                            <button class="btn btn-outline-primary btn-edit" data-id="${page.id}">
                                <i class="mdi mdi-pencil"></i>
                            </button>
                            <button class="btn btn-outline-danger btn-delete" data-id="${page.id}">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </div>
                        `
                    ]);
                });

                pagesTable.draw();
            });
        }

        $(document).ready(function () {
            if ($.fn.modal) {
                $.fn.modal.Constructor.prototype._enforceFocus = function () {};
            }
        });

        $(document).on('click', '.btn-edit', function () {
            let id = $(this).data('id');

            $.get(`/backend/pages/${id}`, function (data) {

                // Judul & tombol
                $('#modalPage .modal-title').text('Edit Page');
                $('#btnSave').text('Update');

                // Isi field basic
                $('#page_id').val(data.id);
                $('#title').val(data.title);
                $('#slug').val(data.slug);
                $('#type').val(data.type);
                $('#handler').val(data.handler ?? 'page');
                $('#active').val(data.active);
                $('#meta_title').val(data.meta_title);

                if (window.tinymce && tinymce.get('contentEditor')) {
                    tinymce.get('contentEditor').setContent(data.content ?? '');
                }

                // ✅ TYPE & PARENT
                if (data.type === 'Sub Pages') {
                    $('#parentWrapper').show();

                    // load parent + select parent_id yg tersimpan
                    loadParentPages(data.parent_id);
                } else {
                    $('#parentWrapper').hide();
                    $('#parent_id').val('');
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

        // PAGE UP
        $(document).on('click', '.up', function (e) {
            e.preventDefault();

            let id = $(this).data('id');

            $.post(`/backend/pages/${id}/up`, {
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function () {
                loadPages();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Urutan page berhasil dinaikkan',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });


        // PAGE DOWN
        $(document).on('click', '.down', function (e) {
            e.preventDefault();

            let id = $(this).data('id');

            $.post(`/backend/pages/${id}/down`, {
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function () {
                loadPages();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Urutan page berhasil diturunkan',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        });

        function loadParentPages(selectedId = null) {
            $.get("{{ route('backend.pages.parents') }}", function (data) {
                let html = '<option value="">-- Pilih Parent --</option>';

                data.forEach(page => {
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
            if (window.tinymce && tinymce.get('contentEditor')) {
                tinymce.get('contentEditor').setContent('');
            }
            // reset editor
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
            if (window.tinymce && tinymce.get('contentEditor')) {
                formData.set('content', tinymce.get('contentEditor').getContent());
            } else {
                formData.set('content', $('#contentEditor').val());
            }

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
                            'Page berhasil diperbarui' : 'Page berhasil ditambahkan',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(function () {
                        location.reload();
                    }, 100);
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
        selector: 'textarea#default-editor',
        plugins: [
            "advlist", "anchor", "autolink", "charmap", "code", "fullscreen",
            "help", "image", "insertdatetime", "link", "lists", "media",
            "preview", "searchreplace", "table", "visualblocks",
        ],
        toolbar: "undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        });
    </script>
        

    @endpush
