@extends('layouts.backend')

@section('title', 'File Manager')

@section('content')
<div class="container">

    <button class="btn btn-primary mb-3" id="btnUpload">
        + Upload File
    </button>
</div>

<div class="modal fade" id="modalFile">
    <div class="modal-dialog">
        <form id="formFile" action="{{ route('backend.download.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label>Judul File</label>
                        <input type="text" name="title" class="form-control" required>
                        <small class="text-danger error-title"></small>
                    </div>

                    <div class="mb-3">
                        <label>Jenjang</label>
                        <select name="jenjang" class="form-control" required>
                            <option value="">-- Pilih Jenjang --</option>
                            <option value="SD/MI">SD / MI</option>
                            <option value="SMP/MTS">SMP / MTS</option>
                            <option value="PAUD/DIKMAS">PAUD / DIKMAS</option>
                            <option value="SMA/SMK">SMA / SMK</option>
                        </select>
                        <small class="text-danger error-jenjang"></small>
                    </div>                    

                    <div class="mb-3">
                        <label>File</label>
                        <input type="file" name="file" class="form-control" required>

                        <small class="text-muted">
                            Format: PDF, DOC, DOCX, XLS, XLSX<br>
                            Ukuran maksimal: 10 MB
                        </small>

                        <small class="text-danger error-file"></small>
                    </div>

                    @isset($page)
                    <input type="hidden" name="page_id" value="{{ $page->id }}">
                    @endisset

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        Upload
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<section class="download-page">
    <div class="container">
        {{-- FILE MANAGER --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">File Download</h5>

                <div class="btn-group">
                    <button class="btn btn-outline-secondary btn-sm" id="btnGrid">
                        <i class="mdi mdi-view-grid"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" id="btnList">
                        <i class="mdi mdi-format-list-bulleted"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">

                {{-- GRID VIEW --}}
                <div class="row" id="gridView">
                    @forelse ($downloads as $file)
                    @php
                    $ext = pathinfo($file->file, PATHINFO_EXTENSION);
                    $size = round(Storage::disk('public')->size($file->file) / 1024, 2);
                    @endphp

                    <div class="col-md-3 mb-4">
                        <div class="border rounded p-3 h-100 text-center">
                            <i class="mdi mdi-file-document-outline text-danger" style="font-size:48px"></i>

                            <div class="fw-bold text-truncate mt-2">
                                {{ $file->title }}
                            </div>

                            <small class="text-muted d-block">
                                {{ $file->jenjang }}
                            </small>

                            <small class="text-muted d-block">
                                {{ strtoupper($ext) }} • {{ $size }} KB
                            </small>

                            <small class="text-muted d-block">
                                {{ $file->created_at->format('d M Y') }}
                            </small>

                            <a href="{{ asset('storage/'.$file->file) }}" class="btn btn-sm btn-primary mt-2" download>
                                Download
                            </a>

                            <button class="btn btn-sm btn-danger btn-delete mt-2"
                                    data-id="{{ $file->id }}">
                                Hapus
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted">
                        Belum ada file
                    </div>
                    @endforelse
                </div>

                {{-- LIST VIEW --}}
                <div class="table-responsive d-none" id="listView">
                    <table class="table table-hover align-middle" id="downloadTable">
                        <thead class="table-light text-center">
                            <tr>
                                <th>Judul</th>
                                <th>Jenjang</th>
                                <th>Jenis</th>
                                <th>Ukuran</th>
                                <th>Tanggal</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($downloads as $file)
                            @php
                            $ext = pathinfo($file->file, PATHINFO_EXTENSION);
                            $size = round(Storage::disk('public')->size($file->file) / 1024, 2);
                            @endphp
                            <tr>
                                <td>{{ $file->title }}</td>
                                <td>{{ $file->jenjang }}</td>
                                <td>{{ strtoupper($ext) }}</td>
                                <td>{{ $size }} KB</td>
                                <td>{{ $file->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ asset('storage/'.$file->file) }}"
                                           class="btn btn-outline-primary"
                                           title="Download"
                                           download>
                                            <i class="mdi mdi-download"></i>
                                        </a>
                                
                                        <button class="btn btn-outline-danger btn-delete"
                                                data-id="{{ $file->id }}"
                                                title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </td>                                                           
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- INFO --}}
            <div class="card-footer small text-muted">
                <strong>Ketentuan:</strong>
                PDF, DOC, DOCX, XLS, XLSX • Min 1 KB • Maks 10 MB
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script>
    $('#btnUpload').click(function () {
        $('#modalFile').modal('show');
    });

    $('#formFile').submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        $('.text-danger').text('');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                $('#modalFile').modal('hide');
                location.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $('.error-title').text(errors.title ?? '');
                    $('.error-file').text(errors.file ?? '');
                }
            }
        });
    });

    $(document).ready(function () {
        $('#downloadTable').DataTable({
            pageLength: 10,
            lengthChange: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    next: "Berikutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    });

    $(document).on('click', '.btn-delete', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Yakin?',
            text: 'File ini akan dihapus permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('backend/download') }}/" + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus',
                            text: res.message ?? 'File berhasil dihapus',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        location.reload();
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'File gagal dihapus'
                        });
                    }
                });
            }
        });
    });


    document.getElementById('btnGrid').onclick = function () {
        document.getElementById('gridView').classList.remove('d-none');
        document.getElementById('listView').classList.add('d-none');
    };

    document.getElementById('btnList').onclick = function () {
        document.getElementById('listView').classList.remove('d-none');
        document.getElementById('gridView').classList.add('d-none');

        $('#downloadTable').DataTable().columns.adjust().draw();
    };

</script>
@endpush
