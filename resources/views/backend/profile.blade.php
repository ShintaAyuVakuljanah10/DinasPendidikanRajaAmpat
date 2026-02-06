@extends('layouts.backend')

@section('title', 'User Profile')

@section('content')
<div class="row">

    <!-- FOTO BESAR (KIRI) -->
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">

                <img src="{{ $user->foto
                        ? asset('storage/'.$user->foto)
                        : asset('assets/images/default-user.png') }}"
                     class="rounded-circle mb-3"
                     style="width:180px;height:180px;object-fit:cover">

                <h4 class="fw-bold">{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->username }}</p>

            </div>
        </div>
    </div>

    <!-- FORM (KANAN) -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">

                <h5 class="mb-4 fw-bold">Edit Profile</h5>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name"
                               value="{{ old('name', $user->name) }}"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username"
                               value="{{ old('username', $user->username) }}"
                               class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Password <small class="text-muted">(kosongkan jika tidak diubah)</small>
                        </label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Foto<small class="text-muted"> (Pakai format jpg,jpeg,png,webp)</small>
                        </label>
                        <input type="file" name="foto" class="form-control">
                    </div>

                    <button class="btn btn-primary">
                        <i class="ti-save"></i> Save Changes
                    </button>

                </form>

            </div>
        </div>
    </div>

</div>
@endsection
