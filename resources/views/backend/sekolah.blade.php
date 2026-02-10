@extends('layouts.backend')

@section('title', 'Sekolah')

@section('content')

<div class="container">
    <div class="row mb-3 align-items-center g-3">
        <div class="col-md-8">
            <div class="row g-2">

                <div class="col-md-5">
                    <select id="jenjangSelect" class="form-control">
                        <option value="">All Jenjang</option>
                        <option value="KB">KB</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                    </select>
                </div>

                <div class="col-md-5">
                    <select id="statusSelect" class="form-control">
                        <option value="">All Status</option>
                        <option value="Negeri">Negeri</option>
                        <option value="Swasta">Swasta</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button id="btnFilter" class="btn btn-primary w-100">
                        <i class="mdi mdi-magnify"></i>
                    </button>
                </div>

            </div>
        </div>

        <div class="col-md-4 text-end">
            <button class="btn btn-success px-4" data-toggle="modal" data-target="#modalSekolah">
                <i class="mdi mdi-plus"></i>
            </button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="fw-bold mb-3">Data Sekolah</h3>

            <table class="table table-hover align-middle" id="sekolahTable">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>NPSN</th>
                        <th>Nama Sekolah</th>
                        <th>Jenjang</th>
                        <th>Status</th>
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>Alamat</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Jml Guru</th>
                        <th>Jml Siswa</th>
                        <th>Jml Fasilitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

        </div>
    </div>
</div>
<div class="modal fade" id="modalSekolah" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <form id="formSekolah">
            @csrf
            <input type="hidden" id="id">

            <div class="modal-content rounded-4">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Sekolah</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">

                    <div class="card mb-3">
                        <div class="card-header fw-bold">Informasi Sekolah</div>
                        <div class="card-body row g-3">

                            <div class="col-md-6">
                                <label>NPSN</label>
                                <input type="text" id="npsn" name="npsn" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Nama Sekolah</label>
                                <input type="text" id="nama_sekolah" name="nama_sekolah" class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label>Jenjang</label>
                                <select id="jenjang" name="jenjang" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option>TK/KB/PKBM</option>
                                    <option>SD/MI</option>
                                    <option>SMP/MTS</option>
                                    <option>SMA/SMK</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Status</label>
                                <select id="status" name="status" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    <option>Negeri</option>
                                    <option>Swasta</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Kecamatan</label>
                                <select id="kecamatan" name="kecamatan" class="form-control">
                                    <option value="">-- Pilih Kecamatan --</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Desa</label>
                                <select id="desa" name="desa"   class="form-control">
                                    <option value="">-- Pilih Desa --</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Alamat</label>
                                <textarea id="alamat" name="alamat" class="form-control" rows="2"></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header fw-bold">Koordinat Lokasi</div>
                        <div class="card-body row g-3">
                            <div class="col-md-6">
                                <label>Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label>Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header fw-bold">Data Statistik</div>
                        <div class="card-body row g-3">

                            <div class="col-md-4">
                                <label>Jumlah Guru</label>
                                <input type="number" id="jumlah_guru" name="jumlah_guru" class="form-control" value="0">
                            </div>

                            <div class="col-md-4">
                                <label>Jumlah Siswa</label>
                                <input type="number" id="jumlah_siswa" name="jumlah_siswa" class="form-control" value="0">
                            </div>

                            <div class="col-md-4">
                                <label>Jumlah Fasilitas</label>
                                <input type="number" id="jumlah_fasilitas" name="jumlah_fasilitas" class="form-control" value="0">
                            </div>

                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        Simpan
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let table;

    $(document).ready(function () {

        table = $('#sekolahTable').DataTable({
            scrollX: true,
            scrollCollapse: true,
            autoWidth: false,

            ordering: true,
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
                    targets: [0, 13],
                    className: 'text-center'
                },
                {
                    targets: [13],
                    orderable: false
                }
            ]
        });

        $.fn.dataTable.ext.search.push(function (settings, data) {
            let jenjang = $('#jenjangSelect').val();
            let status = $('#statusSelect').val();

            if (jenjang && data[3] !== jenjang) return false;
            if (status && data[4] !== status) return false;

            return true;
        });

        $('#btnFilter, #jenjangSelect, #statusSelect').on('change click', function () {
            table.draw();
        });

        loadData();
    });

    function loadData() {
        $.get("{{ route('backend.sekolah.data') }}", function (res) {

            table.clear();

            res.forEach((r, i) => {
                table.row.add([
                    i + 1,
                    r.npsn ?? '-',
                    r.nama_sekolah,
                    r.jenjang,
                    r.status,
                    r.kecamatan,
                    r.desa,
                    r.alamat ?? '-',
                    r.latitude ?? '-',
                    r.longitude ?? '-',
                    r.jumlah_guru,
                    r.jumlah_siswa,
                    r.jumlah_fasilitas,
                    `
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-outline-primary edit" data-id="${r.id}">
                        <i class="mdi mdi-pencil"></i>
                    </button>
                    <button class="btn btn-outline-danger delete" data-id="${r.id}">
                        <i class="mdi mdi-delete"></i>
                    </button>
                </div>
                `
                ]);
            });

            table.draw();
        });
    }

    const wilayahPapuaBarat = {
        "Ayau": [
            "Boiseran",
            "Dornaslos",
            "Runi",
            "Yenwaupnor"
        ],

        "Batanta Selatan": [
            "Amdui",
            "Yenanas",
            "Yesner"
        ],

        "Batanta Utara": [
            "Arefi",
            "Warmaker",
            "Yensawai"
        ],

        "Kepulauan Ayau": [
            "Abidon",
            "Meos Bekwan",
            "Yenbekaki"
        ],

        "Kepulauan Sembilan": [
            "Tikus",
            "Pulau Sembilan"
        ],

        "Kofiau": [
            "Balal",
            "Deer",
            "Dibalal",
            "Mikiran",
            "Tolobi"
        ],

        "Kota Waisai": [
            "Kelurahan Sapordanco",
            "Kelurahan Warmasen",
            "Kelurahan Waisai Kota",
            "Kelurahan Bonkawir"
        ],

        "Meos Mansar": [
            "Arborek",
            "Kurkapa",
            "Sawinggrai",
            "Yenbuba"
        ],

        "Misool Utara": [
            "Aduwei",
            "Atkari",
            "Salafen",
            "Solal"
        ],

        "Misool Barat": [
            "Biga",
            "Gamta",
            "Lilinta",
            "Magey"
        ],

        "Misool Selatan": [
            "Dabatan",
            "Fafanlap",
            "Usaha Jaya",
            "Yellu"
        ],

        "Misool Timur": [
            "Audam",
            "Folley",
            "Tomolol"
        ],

        "Salawati Barat": [
            "Kalobo",
            "Samate",
            "Solol"
        ],

        "Salawati Tengah": [
            "Sakabu",
            "Waibeem",
            "Wailen"
        ],

        "Salawati Utara": [
            "Kalwal",
            "Samate"
        ],

        "Supnin": [
            "Kapadiri",
            "Rauki",
            "Supnin"
        ],

        "Teluk Mayalibit": [
            "Beo",
            "Mumes",
            "Warsambin"
        ],

        "Tiplol Mayalibit": [
            "Go",
            "Kabilol",
            "Lapintal",
            "Lupintal"
        ],

        "Waigeo Barat": [
            "Bianci",
            "Mutus",
            "Selpele",
            "Waisilip"
        ],

        "Waigeo Barat Kepulauan": [
            "Gag",
            "Magey",
            "Pam"
        ],

        "Waigeo Selatan": [
            "Saonek",
            "Saporkren",
            "Yenbeser"
        ],

        "Waigeo Timur": [
            "Yensner",
            "Urbinasopen"
        ],

        "Waigeo Utara": [
            "Kabare",
            "Kapadiri",
            "Rauki"
        ],

        "Warwarbomi": [
            "Warwarbomi"
        ]
    };



    $(document).ready(function () {

        Object.keys(wilayahPapuaBarat).forEach(function (kecamatan) {
            $('#kecamatan').append(
                `<option value="${kecamatan}">${kecamatan}</option>`
            );
        });
        $('#kecamatan').on('change', function () {
            let kecamatan = $(this).val();
            let desaSelect = $('#desa');

            desaSelect.empty();
            desaSelect.append('<option value="">-- Pilih Desa --</option>');

            if (kecamatan && wilayahPapuaBarat[kecamatan]) {
                wilayahPapuaBarat[kecamatan].forEach(function (desa) {
                    desaSelect.append(
                        `<option value="${desa}">${desa}</option>`
                    );
                });
            }
        });

    });

    $(document).on('submit', '#formSekolah', function (e) {
        e.preventDefault();

        let id = $('#id').val();
        let formData = new FormData(this);

        let url = id ?
            `/backend/sekolah/${id}` :
            `/backend/sekolah`;

        if (id) {
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            success: function () {
                $('#modalSekolah').modal('hide');
                $('#formSekolah')[0].reset();
                $('#id').val('');

                loadData();

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: id ?
                        'Data sekolah berhasil diperbarui' :
                        'Data sekolah berhasil ditambahkan',
                    timer: 2000,
                    showConfirmButton: false
                });
            },

            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $('.text-danger').text('');

                    $.each(errors, function (key, value) {
                        $('.error-' + key).text(value[0]);
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

    $('.btn-success').on('click', function () {
        $('#formSekolah')[0].reset();
        $('#id').val('');
        $('.modal-title').text('Tambah Sekolah');
    });

    $(document).on('click', '.edit', function () {
        let id = $(this).data('id');

        $('#formSekolah')[0].reset();
        $('.text-danger').text('');

        $.get(`/backend/sekolah/${id}/edit`, function (r) {

            $('#id').val(r.id);
            $('#npsn').val(r.npsn);
            $('#nama_sekolah').val(r.nama_sekolah);
            $('#jenjang').val(r.jenjang);
            $('#status').val(r.status);

            $('#kecamatan').val(r.kecamatan).trigger('change');

            setTimeout(() => {
                $('#desa').val(r.desa);
            }, 200);

            $('#alamat').val(r.alamat);
            $('#latitude').val(r.latitude);
            $('#longitude').val(r.longitude);
            $('#jumlah_guru').val(r.jumlah_guru);
            $('#jumlah_siswa').val(r.jumlah_siswa);
            $('#jumlah_fasilitas').val(r.jumlah_fasilitas);

            $('.modal-title').text('Edit Sekolah');
            $('#modalSekolah').modal('show');
        });
    });

    $(document).on('click', '.delete', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Yakin?',
            text: 'Data sekolah akan dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Hapus'
        }).then(res => {
            if (res.isConfirmed) {
                $.ajax({
                    url: `/backend/sekolah/${id}`,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: loadData
                });
            }
        });
    });

</script>
@endpush
