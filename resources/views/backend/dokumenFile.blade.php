@extends('layouts.backend')

@section('title','Dokumen File')

@section('content')
<div class="container">

    <button class="btn btn-primary mb-3" id="btnAdd">
        + Upload File
    </button>

    <div class="row" id="file-grid">
        <div class="col-12 text-center">Loading...</div>
    </div>

</div>

<!-- MODAL -->
<div class="modal fade" id="modalFile">
    <div class="modal-dialog">
        <form id="formFile" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="id">

            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama File</label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Pilih File</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){

    loadFiles();
    console.log('SCRIPT JALAN');

    function loadFiles(){
        $.get("{{ route('backend.public.data') }}", function(data){

            let html = '';

            if(data.length === 0){
                html = `<div class="col-12 text-center">Belum ada file</div>`;
            }

            data.forEach(item => {
                html += `
                <div class="col-md-3 mb-4">
                    <div class="card file-card shadow-sm p-3 text-center file-open"
                        data-file="${item.file}"
                        style="cursor:pointer">


                        <div class="mb-2">
                            <i class="fas fa-file-alt fa-4x text-primary"></i>
                        </div>

                        <h6 class="text-truncate">${item.nama}</h6>

                        <div class="mt-2">

                            <button class="btn btn-warning btn-sm edit"
                                data-id="${item.id}">
                                Edit
                            </button>

                            <button class="btn btn-danger btn-sm delete"
                                data-id="${item.id}">
                                Hapus
                            </button>

                        </div>

                    </div>
                </div>`;
            });


            $('#file-grid').html(html);

        });
    }
    $(document).on('click','.file-open', function(e){

        if($(e.target).closest('button').length) return;

        let file = $(this).data('file');
        window.open('/storage/' + file, '_blank');

    });

    $('#btnAdd').click(function(){
        $('#formFile')[0].reset();
        $('#id').val('');
        $('#modalFile').modal('show');
    });

    $('#formFile').submit(function(e){
        e.preventDefault();

        let id = $('#id').val();
        let formData = new FormData(this);

        let url = id
            ? "{{ url('backend/public') }}/" + id
            : `{{ route('backend.public.store') }}`;

        if(id){
            formData.append('_method','PUT');
        }

        $.ajax({
            url:url,
            method:'POST',
            data:formData,
            processData:false,
            contentType:false,
            success:function(){

                $('#modalFile').modal('hide');
                loadFiles();

                Swal.fire({
                    toast:true,
                    position:'top-end',
                    icon:'success',
                    title:'Berhasil disimpan',
                    showConfirmButton:false,
                    timer:2000
                });

            }
        });
    });

    $(document).on('click','.edit', function(){

        let id = $(this).data('id');

        $.get("{{ url('backend/public') }}/" + id + "/edit", function(data){

            $('#id').val(data.id);
            $('#nama').val(data.nama);

            $('#modalFile').modal('show');
        });
    });



    $(document).on('click','.delete', function(e){

        e.stopPropagation();
        let id = $(this).data('id');

        Swal.fire({
            title:'Yakin?',
            icon:'warning',
            showCancelButton:true
        }).then((result)=>{

            if(result.isConfirmed){

                $.ajax({
                    url: "{{ url('backend/public') }}/" + id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(){
                        loadFiles();
                    }
                });

            }
        });
    });
    




});
</script>
@endpush
