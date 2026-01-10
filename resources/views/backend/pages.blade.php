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

        <div class="col-md-3">
            <div class="dropdown w-100">
                <button class="btn btn-outline-info dropdown-toggle w-100" data-toggle="dropdown">
                    <span>-- Active? --</span>
                </button>
                <div class="dropdown-menu w-100">
                    <a class="dropdown-item dropdown-select" href="#" data-value="1" data-target="filter_active">Yes</a>
                    <a class="dropdown-item dropdown-select" href="#" data-value="0" data-target="filter_active">No</a>
                </div>
            </div>
            <input type="hidden" id="filter_active">
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
                <tbody>
                    @forelse ($pages as $index => $page)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->type }}</td>
                        <td>{{ $page->parent ?? '-' }}</td>
                        <td>
                            @if($page->active)
                            <span class="badge badge-success">Active</span>
                            @else
                            <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $page->order }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning">Edit</button>
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            📭 Belum ada data pages yang tersimpan
                        </td>
                    </tr>
                    @endforelse
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
                                        <button class="btn btn-outline-info dropdown-toggle w-100" data-toggle="dropdown">
                                            <span id="typeText">-- Pilih Parent --</span>
                                        </button>
                                        <div class="dropdown-menu w-100">
                                            @foreach($pages->where('type','Pages') as $p)
                                            <a class="dropdown-item type-select" href="#"
                                                data-value="{{ $p->id }}">{{ $p->title }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="fw-semibold">Active</label>
                                    <button class="btn btn-outline-info dropdown-toggle w-100" data-toggle="dropdown">
                                        <span id="typeText">-- Active --</span>
                                    </button>
                                    <div class="dropdown-menu w-100">
                                        <a class="dropdown-item dropdown-select" href="#" data-value="1" data-target="filter_active">Yes</a>
                                        <a class="dropdown-item dropdown-select" href="#" data-value="0" data-target="filter_active">No</a>
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
    $(document).on('click', '.dropdown-select', function (e) {
        e.preventDefault();

        let value = $(this).data('value');
        let target = $(this).data('target');

        $('#' + target).val(value);
        $(this).closest('.dropdown').find('button span').text($(this).text());
    });

    $(document).on('click', '.type-select', function () {
        if ($(this).data('value') === 'Pages') {
            $('#parent_id').val('');
        }
    });

    $('#formPage').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('backend.pages.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function () {
                $('#modalPage').modal('hide');
                $('#formPage')[0].reset();
                alert('Data berhasil disimpan');
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                alert('Gagal menyimpan data');
            }
        });
    });

    $(document).on('click', '.type-select', function (e) {
        e.preventDefault();

        let value = $(this).data('value');

        // set text dropdown
        $('#typeText').text(value);

        // set hidden input
        $('#type').val(value);

        if (value === 'Sub Pages') {
            $('#parentWrapper').slideDown();
        } else {
            $('#parentWrapper').slideUp();
            $('#parentSelect').val('');
            $('#parent_id').val('');
        }
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
