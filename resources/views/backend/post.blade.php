@extends('layouts.backend')

@section('title', 'Post')

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
@endsection
