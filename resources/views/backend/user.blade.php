@extends('layouts.backend')

@section('title', 'Data User')

@section('content')

<div class="container">
    <button id="btnAddUser" class="btn btn-primary mb-3">
        + Tambah User
    </button>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h3 class="font-weight-bold mb-3">Data User</h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Foto</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="user-table">
                            <tr>
                                <td colspan="6" class="text-center">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Create/Edit User -->
<div class="modal fade" id="modalUser" tabindex="-1">
    <div class="modal-dialog">
        <form id="formUser" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="user_id"> <!-- untuk edit -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Masukan Nama" required>
                        <small class="text-danger error-name"></small>
                    </div>

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukan Username" required>
                        <small class="text-danger error-username"></small>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password Min 6 Karakter">
                        <small class="text-danger error-password"></small>
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah password</small>
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin">Admin</option>
                            <option value="writer">Writer</option>
                            <option value="super_user">Super User</option>
                        </select>
                        <small class="text-danger error-role"></small>
                    </div>

                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                        <small class="text-danger error-foto"></small>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
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

    loadUsers();

    function loadUsers() {
        $.get("{{ route('user.data') }}", function (data) {
            let html = '';
            if (data.length === 0) {
                html = `<tr><td colspan="6" class="text-center">Data kosong</td></tr>`;
            } else {
                $.each(data, function (i, user) {
                    let foto = user.foto
                        ? `<img src="/storage/${user.foto}" width="50">`
                        : `<span class="text-muted">No Image</span>`;

                    html += `
                    <tr>
                        <td>${i+1}</td>
                        <td>${user.name}</td>
                        <td>${user.username}</td>
                        <td>${user.role}</td>
                        <td>${foto}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-user" data-id="${user.id}">Edit</button>
                            <button class="btn btn-sm btn-danger delete-user" data-id="${user.id}">Hapus</button>
                        </td>
                    </tr>`;
                });
            }
            $('#user-table').html(html);
        });
    }

    // Buka modal tambah
    $('#btnAddUser').click(function () {
        $('#formUser')[0].reset();
        $('.text-danger').text('');
        $('#modalTitle').text('Tambah User');
        $('#btnSave').text('Simpan');
        $('#user_id').val('');
        $('#modalUser').modal('show');
    });

    // Submit tambah / edit
    $('#formUser').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);
        $('.text-danger').text('');
        let userId = $('#user_id').val();
        let url = userId ? `/users/${userId}` : "{{ route('user.tambah') }}";
        let type = 'POST';

        if(userId){
            formData.append('_method','PUT'); // untuk update di Laravel
        }

        $.ajax({
            url: url,
            type: type,
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                $('#modalUser').modal('hide');
                $('#formUser')[0].reset();
                loadUsers();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $('.error-' + key).text(value[0]);
                    });
                } else {
                    console.log(xhr.status);
                    console.log(xhr.responseText);
                    alert('Terjadi kesalahan: ' + xhr.status + ' ' + xhr.statusText);
                }
            }
        });
    });

    // Edit user
    $(document).on('click', '.edit-user', function () {
        let userId = $(this).data('id');
        $.get(`/users/${userId}/edit`, function (data) {
            $('#modalTitle').text('Edit User');
            $('#btnSave').text('Update');
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#username').val(data.username);
            $('#role').val(data.role);
            $('#password').val('');
            $('.text-danger').text('');
            $('#modalUser').modal('show');
        });
    });

    // Delete user
    $(document).on('click', '.delete-user', function () {
        let userId = $(this).data('id');
        if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
            $.ajax({
                url: `/users/${userId}`,
                type: 'DELETE',
                success: function () {
                    alert('User berhasil dihapus');
                    loadUsers();
                },
                error: function (xhr) {
                    console.log(xhr.status);
                    console.log(xhr.responseText);
                    alert('Terjadi kesalahan saat menghapus user');
                }
            });
        }
    });

});

</script>
@endpush

