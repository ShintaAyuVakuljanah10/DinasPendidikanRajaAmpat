@extends('layouts.backend')

@section('title', 'Pages')

@section('content')

<div class="container">
    <div class="row mb-3 align-items-center g-3">

        <div class="col-md-3">
            <div class="dropdown w-100">
                <button class="btn btn-outline-info dropdown-toggle w-100" data-bs-toggle="dropdown">
                    <span>-- Pilih Tipe --</span>
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a class="dropdown-item dropdown-select" href="#" data-value="Pages" data-target="filter_type">Pages</a></li>
                    <li><a class="dropdown-item dropdown-select" href="#" data-value="Sub Pages" data-target="filter_type">Sub Pages</a></li>
                </ul>
            </div>
            <input type="hidden" id="filter_type">
        </div>

        <div class="col-md-3">
            <div class="dropdown w-100">
                <button class="btn btn-outline-info dropdown-toggle w-100" data-bs-toggle="dropdown">
                    <span>-- Active? --</span>
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a class="dropdown-item dropdown-select" href="#" data-value="1" data-target="filter_active">Yes</a></li>
                    <li><a class="dropdown-item dropdown-select" href="#" data-value="0" data-target="filter_active">No</a></li>
                </ul>
            </div>
            <input type="hidden" id="filter_active">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">Tampilkan</button>
        </div>

        <div class="col-md-4 text-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalPage">
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
                    <tr><td colspan="7" class="text-center">Loading...</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalPage" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <form id="formPage">
            @csrf

            <input type="hidden" name="id" id="page_id">
            <input type="hidden" name="with_content" id="with_content">
            <input type="hidden" name="active" id="active">
            <input type="hidden" name="type" id="type">
            <input type="hidden" name="with_direct_link" id="with_direct_link">
            <input type="hidden" name="parent_id" id="parent_id">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Page</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-4">
                        <div class="col-lg-8">
                            <textarea name="content" class="form-control" rows="18"></textarea>
                        </div>

                        <div class="col-lg-4 vstack gap-3">

                            <div>
                                <label>With Content?</label>
                                <div class="dropdown">
                                    <button class="btn btn-outline-info dropdown-toggle w-100" data-bs-toggle="dropdown">
                                        <span>-- Select --</span>
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li><a class="dropdown-item dropdown-select" href="#" data-value="1" data-target="with_content">Yes</a></li>
                                        <li><a class="dropdown-item dropdown-select" href="#" data-value="0" data-target="with_content">No</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div>
                                <label>Active</label>
                                <div class="dropdown">
                                    <button class="btn btn-outline-info dropdown-toggle w-100" data-bs-toggle="dropdown">
                                        <span>-- Select --</span>
                                    </button>
                                    <ul class="dropdown-menu w-100">
                                        <li><a class="dropdown-item dropdown-select" href="#" data-value="1" data-target="active">Yes</a></li>
                                        <li><a class="dropdown-item dropdown-select" href="#" data-value="0" data-target="active">No</a></li>
                                    </ul>
                                </div>
                            </div>

                            <input type="text" name="title" class="form-control" placeholder="Title">
                            <input type="text" name="slug" class="form-control" placeholder="Slug">

                            <div class="row g-2">
                                <div class="col-6">
                                    <label>Type</label>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-info dropdown-toggle w-100" data-bs-toggle="dropdown">
                                            <span>-- Select --</span>
                                        </button>
                                        <ul class="dropdown-menu w-100">
                                            <li><a class="dropdown-item dropdown-select type-select" href="#" data-value="Pages" data-target="type">Pages</a></li>
                                            <li><a class="dropdown-item dropdown-select type-select" href="#" data-value="Sub Pages" data-target="type">Sub Pages</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <label>With Direct Link?</label>
                                    <div class="dropdown">
                                        <button class="btn btn-outline-info dropdown-toggle w-100" data-bs-toggle="dropdown">
                                            <span>-- Select --</span>
                                        </button>
                                        <ul class="dropdown-menu w-100">
                                            <li><a class="dropdown-item dropdown-select" href="#" data-value="1" data-target="with_direct_link">Yes</a></li>
                                            <li><a class="dropdown-item dropdown-select" href="#" data-value="0" data-target="with_direct_link">No</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label>Parent</label>
                                <div class="dropdown">
                                    <button id="parentButton" class="btn btn-outline-info dropdown-toggle w-100" data-bs-toggle="dropdown" disabled>
                                        <span id="parentText">-- Not Required --</span>
                                    </button>
                                    <ul class="dropdown-menu w-100" id="parentDropdown">
                                        {{-- isi parent --}}
                                    </ul>
                                </div>
                            </div>

                            <input type="text" name="meta_title" class="form-control" placeholder="Meta Title">
                            <input type="text" name="meta_keywords" class="form-control" placeholder="Meta Keywords">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('assets/BackEnd/extensions/jquery/jquery.min.js') }}"></script>

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
        $('#parentButton').prop('disabled', true);
        $('#parentText').text('-- Not Required --');
        $('#parent_id').val('');
    } else {
        $('#parentButton').prop('disabled', false);
        $('#parentText').text('-- Select Parent Page --');
    }
});

$('#formPage').off('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('backend.pages.store') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function () {
            bootstrap.Modal.getInstance(document.getElementById('modalPage')).hide();
            $('#formPage')[0].reset();
            alert('Data berhasil disimpan');
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            alert('Gagal menyimpan data');
        }
    });
});
</script>
@endpush
