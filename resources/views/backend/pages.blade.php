@extends('layouts.backend')

@section('title', 'Pages')

@section('content')

<div class="container">
    <div class="row mb-3 align-items-center g-3">

        <!-- FILTER TYPE -->
        <div class="col-md-3">
            <div class="dropdown w-100">
                <button
                    class="btn btn-outline-info dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" data-bs-toggle="dropdown">
                    <span>-- Pilih Tipe --</span>
                </button>
                <ul class="dropdown-menu w-100">
                    <li class="dropdown-header">Tipe Page</li>
                    <li><a class="dropdown-item dropdown-select" href="#" data-value="Pages"
                            data-target="filter_type">Pages</a></li>
                    <li><a class="dropdown-item dropdown-select" href="#" data-value="Sub Pages"
                            data-target="filter_type">Sub Pages</a></li>
                </ul>
            </div>
            <input type="hidden" id="filter_type">
        </div>

        <!-- FILTER ACTIVE -->
        <div class="col-md-3">
            <div class="dropdown w-100">
                <button
                    class="btn btn-outline-info dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                    type="button" data-bs-toggle="dropdown">
                    <span>-- Active? --</span>
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a class="dropdown-item dropdown-select" href="#" data-value="1"
                            data-target="filter_active">Yes</a></li>
                    <li><a class="dropdown-item dropdown-select" href="#" data-value="0"
                            data-target="filter_active">No</a></li>
                </ul>
            </div>
            <input type="hidden" id="filter_active">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <i class="fas fa-eye me-1"></i> Tampilkan
            </button>
        </div>

        <div class="col-md-4 text-end">
            <button class="btn btn-success px-4" data-bs-toggle="modal" data-bs-target="#modalPage">
                <i class="fas fa-plus me-1"></i> Tambah Page
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3 fw-bold">Data Pages</h3>
            <div class="table-responsive">
                <table class="table" id="pages-table">
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
                        <tr>
                            <td colspan="7" class="text-center">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div class="modal fade" id="modalPage" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <form action="{{ route('backend.pages.store') }}" method="POST" id="formPage" class="w-100">
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
                            <label class="fw-bold mb-2">Content</label>
                            <textarea class="form-control" name="content" rows="18"></textarea>
                        </div>

                        <div class="col-lg-4">
                            <div class="vstack gap-3">

                                <!-- WITH CONTENT -->
                                <div>
                                    <label>With Content?</label>
                                    <div class="dropdown">
                                        <button
                                            class="btn btn-outline-info dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                            type="button" data-bs-toggle="dropdown">
                                            <span>-- Select --</span>
                                        </button>
                                        <ul class="dropdown-menu w-100">
                                            <li><a class="dropdown-item dropdown-select" href="#" data-value="1"
                                                    data-target="with_content">Yes</a></li>
                                            <li><a class="dropdown-item dropdown-select" href="#" data-value="0"
                                                    data-target="with_content">No</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- ACTIVE -->
                                <div>
                                    <label>Active</label>
                                    <input type="hidden" name="active" id="active">
                                    <div class="dropdown">
                                        <button id="activeBtn"
                                            class="btn btn-outline-info dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                            type="button" data-bs-toggle="dropdown">
                                            <span id="activeText">-- Select --</span>
                                        </button>
                                        <ul class="dropdown-menu w-100">
                                            <li>
                                                <a class="dropdown-item dropdown-select" href="#" data-value="1"
                                                    data-target="active" data-text="Yes">Yes</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item dropdown-select" href="#" data-value="0"
                                                    data-target="active" data-text="No">No</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div>
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control">
                                </div>

                                <div>
                                    <label>Slug</label>
                                    <input type="text" name="slug" class="form-control">
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <label>Type</label>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-outline-info dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                                type="button" data-bs-toggle="dropdown">
                                                <span>-- Select --</span>
                                            </button>
                                            <ul class="dropdown-menu w-100">
                                                <li><a class="dropdown-item dropdown-select" href="#" data-value="Pages"
                                                        data-target="type">Pages</a></li>
                                                <li><a class="dropdown-item dropdown-select" href="#"
                                                        data-value="Sub Pages" data-target="type">Sub Pages</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label>With Direct Link?</label>
                                        <div class="dropdown">
                                            <button
                                                class="btn btn-outline-info dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                                type="button" data-bs-toggle="dropdown">
                                                <span>-- Select --</span>
                                            </button>
                                            <ul class="dropdown-menu w-100">
                                                <li><a class="dropdown-item dropdown-select" href="#" data-value="1"
                                                        data-target="with_direct_link">Yes</a></li>
                                                <li><a class="dropdown-item dropdown-select" href="#" data-value="0"
                                                        data-target="with_direct_link">No</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Parent</label>
                                    <input type="hidden" name="parent_id" id="parent_id">

                                    <div class="dropdown">
                                        <button id="parentButton"
                                            class="btn btn-outline-info dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                            type="button" data-bs-toggle="dropdown" disabled>
                                            <span id="parentText">-- Select --</span>
                                        </button>

                                        <ul class="dropdown-menu w-100" id="parentDropdown">
                                            {{-- nanti diisi via blade --}}
                                        </ul>
                                    </div>
                                </div>


                                <div>
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" class="form-control">
                                </div>

                                <div>
                                    <label>Meta Keywords</label>
                                    <input type="text" name="meta_keywords" class="form-control">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save
                    </button>
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
    
        const value  = $(this).data('value');
        const target = $(this).data('target');
        const text   = $(this).data('text');
    
        // set value ke hidden input
        $('#' + target).val(value);
    
        // ubah text button
        $('#' + target + 'Text').text(text);
    });
    </script>
    

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeSelect = document.getElementById('type');
        const parentButton = document.getElementById('parentButton');
        const parentText = document.getElementById('parentText');
        const parentInput = document.getElementById('parent_id');

        // Saat type berubah
        typeSelect.addEventListener('change', function () {
            if (this.value === 'page') {
                // Pages → parent disable
                parentButton.disabled = true;
                parentText.innerText = '-- Not Required --';
                parentInput.value = '';
            } else if (this.value === 'sub_page') {
                // Sub Pages → parent aktif
                parentButton.disabled = false;
                parentText.innerText = '-- Select Parent Page --';
            }
        });

        // Saat pilih parent
        document.querySelectorAll('.parent-item').forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                parentText.innerText = this.dataset.name;
                parentInput.value = this.dataset.id;
            });
        });
    });

</script>


<script>
    $(document).on('click', '.dropdown-select', function (e) {
        e.preventDefault();

        let value = $(this).data('value');
        let target = $(this).data('target');

        $('#' + target).val(value);
        $(this).closest('.dropdown').find('button span').text($(this).text());
    });

    $('#formPage').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('backend.pages.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function () {
                $('#modalPage').modal('hide');
                $('#formPage')[0].reset();
                alert('Data berhasil disimpan');
            },
            error: function () {
                alert('Gagal menyimpan data');
            }
        });
    });

</script>
@endpush
