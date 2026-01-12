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
                <label class="fw-semibold">Active</label>
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
                                        <div class="dropdown">
                                            <button class="btn btn-outline-info dropdown-toggle w-100"
                                                data-toggle="dropdown">
                                                <span id="typeText">-- Select --</span>
                                            </button>
                                            <div class="dropdown-menu w-100">
                                                <a class="dropdown-item type-select" href="#" data-value="Pages">Pages</a>
                                                <a class="dropdown-item type-select" href="#" data-value="Sub Pages">Sub
                                                    Pages</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="parentWrapper" style="display:none">
                                        <label class="fw-semibold">Parent Page</label>
                                        <div class="dropdown">
                                            <button class="btn btn-outline-info dropdown-toggle w-100"
                                                data-toggle="dropdown">
                                                <span id="parentText">-- Pilih Parent --</span>
                                            </button>
                                            {{-- <div class="dropdown-menu w-100">
                                                @foreach($pages->where('type','Pages') as $p)
                                                <a class="dropdown-item parent-select" href="#" data-id="{{ $p->id }}">
                                                    {{ $p->title }}
                                                </a>
                                                @endforeach
                                            </div> --}}
                                        </div>
                                    </div>

                                    <div>
                                        <label class="fw-semibold">Active</label>
                                        <button class="btn btn-outline-info dropdown-toggle w-100" data-toggle="dropdown">
                                            <span id="typeText">-- Active --</span>
                                        </button>
                                        <div class="dropdown-menu w-100">
                                            <a class="dropdown-item dropdown-select" href="#" data-value="1"
                                                data-target="filter_active">Yes</a>
                                            <a class="dropdown-item dropdown-select" href="#" data-value="0"
                                                data-target="filter_active">No</a>
                                        </div>
                                    </div>
                                </div>
                                <hr>

                                <div>
                                    <label class="fw-semibold">Meta Title (SEO)</label>
                                    <input type="text" name="meta_title" class="form-control"
                                        placeholder="Judul untuk SEO (opsional)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary px-4">
                            Save
                        </button>
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
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
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
                                <button class="btn btn-sm btn-warning">Edit</button>
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </td>
                        </tr>`;
                    });
                }

                $('#pages-table').html(html);
            });
        }

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

        // SUBMIT FORM (SAMA KAYA USER)
        $('#formPage').submit(function (e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('backend.pages.store') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function () {
                    $('#modalPage').modal('hide');
                    $('#formPage')[0].reset();
                    loadPages();
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
    tinymce.init({
        selector: '#contentEditor',
        height: 300,
        menubar: 'file edit view insert format table',
        plugins: 'table lists link code',
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | table | code'
    });
    </script>
    @endpush

