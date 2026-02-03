@extends('layouts.frontend.frontend')

@section('title', $page->title ?? 'Data Sekolah')

@section('content')

<div class="page-title mb-5" data-aos="fade">
    <div class="heading">
        <div class="container text-center">
            <h1 class="mb-4">
                {{ $page->title ?? 'Data Sekolah ' . strtoupper($jenjang) }}
            </h1>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row g-4">

        @php
        $totalSekolah = $sekolah->count();
        @endphp

        <div class="container mb-4">
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">

                <!-- Kiri: Judul -->
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-list-ul fs-4 text-primary"></i>
                    <h5 class="mb-0 fw-bold">Daftar Sekolah</h5>
                </div>

                <!-- Kanan: Filter -->
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm filter-kecamatan">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-funnel text-primary"></i>
                        </span>

                        <select id="filterKecamatan" class="form-select border-start-0">
                            <option value="">Semua Kecamatan</option>
                        </select>
                    </div>

                    <span id="totalBadge" class="badge rounded-pill bg-primary px-3 py-2">
                        {{ $sekolah->count() }} Sekolah
                    </span>
                </div>

            </div>
        </div>


        @foreach ($sekolah as $s)
        <div class="col-md-6 col-lg-4 sekolah-item" data-kecamatan="{{ strtolower($s->kecamatan) }}">
            <div class="card sekolah-card h-100 border-0 shadow-sm">

                <div class="card-body d-flex flex-column">

                    <div class="d-flex mb-2">
                        <h6 class="fw-bold text-uppercase mb-0 flex-grow-1 pe-2">
                            {{ $s->nama_sekolah }}
                        </h6>

                        <span class="badge bg-primary rounded-pill align-self-start">
                            {{ strtoupper($jenjang) }}
                        </span>
                    </div>

                    <small class="text-muted mb-2">
                        NPSN: {{ $s->npsn }}
                    </small>

                    <div class="small text-secondary mb-3">
                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-geo-alt-fill text-danger"></i>
                            <span>{{ $s->kecamatan }}</span>
                        </div>

                        <div class="d-flex align-items-center gap-1">
                            <i class="bi bi-house-door-fill text-primary"></i>
                            <span>{{ $s->desa }}</span>
                        </div>
                    </div>

                    <button class="btn btn-primary btn-sm mt-auto btn-detail" data-id="{{ $s->id }}" data-nama="{{ $s->nama_sekolah }}" data-bs-toggle="modal" data-bs-target="#detailModal">
                        Detail
                    </button>

                </div>
            </div>
        </div>
        @endforeach

        @if ($sekolah->isEmpty())
        <div class="col-12 text-center text-muted">
            Tidak ada data sekolah
        </div>
        @endif

    </div>
</div>

{{-- MODAL --}}
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h6 class="modal-title" id="modalTitle">Detail Sekolah</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="modalContent">
                {{-- langsung diganti via AJAX --}}
            </div>

        </div>
    </div>
</div>

<style>
    :root {
        --green-main: #16a34a;
        --green-light: #22c55e;
        --green-soft: rgba(34, 197, 94, 0.15);
    }

    .bg-primary {
        background-color: var(--green-main) !important;
    }

    .btn-primary {
        background-color: var(--green-main);
        border-color: var(--green-main);
    }

    .btn-primary:hover,
    .btn-primary:focus {
        background: linear-gradient(135deg, var(--green-main), var(--green-light));
        border-color: transparent;
    }

    .badge.bg-primary {
        background-color: var(--green-main) !important;
    }

    .sekolah-card {
        background: #fff;
        border-radius: 14px;
        border: 2px solid transparent;
        transition: all .25s ease;
        position: relative;
        overflow: hidden;
    }

    .sekolah-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(180deg, var(--green-main), var(--green-light));
        transition: width .25s ease;
    }

    .sekolah-card:hover {
        transform: translateY(-6px) scale(1.02);
        border-color: var(--green-main);
        box-shadow:
            0 15px 35px rgba(34, 197, 94, 0.25),
            0 0 0 3px var(--green-soft);
    }

    .sekolah-card:hover::before {
        width: 6px;
    }

    .sekolah-card .badge {
        font-size: 11px;
        padding: 6px 10px;
        border-radius: 20px;
    }

    .sekolah-card h6 {
        font-size: 14px;
        line-height: 1.4;
    }

    .sekolah-card .btn-detail {
        border-radius: 10px;
        transition: all .2s ease;
    }

    .sekolah-card:hover .btn-detail {
        background: linear-gradient(135deg, var(--green-main), var(--green-light));
        border-color: transparent;
    }

    .card-body {
        padding: 1.25rem;
        flex-grow: 1;
    }

    .modal-header {
        background: linear-gradient(135deg, var(--green-main), var(--green-light));
        color: #fff;
    }

    .sekolah-item {
        opacity: 0;
        transform: translateY(20px);
    }

</style>

{{-- JS --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {

        // animasi masuk card
        document.querySelectorAll('.sekolah-item').forEach((el, i) => {
            setTimeout(() => {
                el.style.transition = 'all .4s ease';
                el.style.opacity = 1;
                el.style.transform = 'translateY(0)';
            }, i * 80);
        });

        // AJAX modal tanpa loading
        document.querySelectorAll('.btn-detail').forEach(btn => {
            btn.addEventListener('click', function () {
                
                document.getElementById('modalTitle').innerHTML = `
                    <span style="font-weight:700; font-size:1.1rem; color:#fff;">
                        ${this.dataset.nama}
                    </span>
                `;

                fetch(`/sekolah/detail/${this.dataset.id}`)
                    .then(res => res.json())
                    .then(d => {
                    document.getElementById('modalContent').innerHTML = `
                        <div class="container-fluid px-2">

                            <!-- INFORMASI UTAMA -->
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <small class="text-muted">NPSN</small>
                                    <div class="fw-semibold">${d.npsn}</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Jenjang</small>
                                    <div class="fw-semibold">${d.jenjang}</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Status</small>
                                    <div class="fw-semibold">${d.status}</div>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Kecamatan</small>
                                    <div class="fw-semibold">${d.kecamatan}</div>
                                </div>
                                <div class="col-12">
                                    <small class="text-muted">Desa</small>
                                    <div class="fw-semibold">${d.desa}</div>
                                </div>
                            </div>

                            <hr class="my-2">

                            <!-- ALAMAT -->
                            <div class="mb-3">
                                <small class="text-muted">Alamat Lengkap</small>
                                <div class="fw-semibold">${d.alamat}</div>
                            </div>

                            <div class="col-12">
                                <small class="text-muted">Koordinat</small>
                                <div class="fw-semibold">
                                    ${d.latitude && d.longitude ? `${d.latitude}, ${d.longitude}` : '-'}
                                </div>
                            </div>

                            <hr class="my-2">

                            <!-- STATISTIK -->
                            <div class="row text-center g-2">
                                <div class="col-4">
                                    <div class="border rounded py-2">
                                        <div class="fs-5 fw-bold text-primary">${d.jumlah_guru}</div>
                                        <small class="text-muted">Guru</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border rounded py-2">
                                        <div class="fs-5 fw-bold text-primary">${d.jumlah_siswa}</div>
                                        <small class="text-muted">Siswa</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border rounded py-2">
                                        <div class="fs-5 fw-bold text-primary">${d.jumlah_fasilitas}</div>
                                        <small class="text-muted">Fasilitas</small>
                                    </div>
                                </div>
                            </div>

                        </div>
                    `;
                });
            });
        });

        const kecamatanSelect = document.getElementById('filterKecamatan');
        const cards = document.querySelectorAll('.sekolah-item');
        const badge = document.getElementById('totalBadge');

        // isi dropdown kecamatan (urut A-Z)
        Object.keys(wilayahPapuaBarat)
            .sort()
            .forEach(kec => {
                const opt = document.createElement('option');
                opt.value = kec.toLowerCase();
                opt.textContent = kec;
                kecamatanSelect.appendChild(opt);
            });

        // filter realtime
        kecamatanSelect.addEventListener('change', function () {
            const selected = this.value;
            let visibleCount = 0;

            cards.forEach(card => {
                const kec = card.dataset.kecamatan;

                if (!selected || kec === selected) {
                    card.style.display = '';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            // update badge
            badge.textContent = visibleCount + ' Sekolah';
        });
    });

    const wilayahPapuaBarat = {
        "Ayau": ["Boiseran", "Dornaslos", "Runi", "Yenwaupnor"],
        "Batanta Selatan": ["Amdui", "Yenanas", "Yesner"],
        "Batanta Utara": ["Arefi", "Warmaker", "Yensawai"],
        "Kepulauan Ayau": ["Abidon", "Meos Bekwan", "Yenbekaki"],
        "Kepulauan Sembilan": ["Tikus", "Pulau Sembilan"],
        "Kofiau": ["Balal", "Deer", "Dibalal", "Mikiran", "Tolobi"],
        "Kota Waisai": [
            "Kelurahan Sapordanco",
            "Kelurahan Warmasen",
            "Kelurahan Waisai Kota",
            "Kelurahan Bonkawir"
        ],
        "Meos Mansar": ["Arborek", "Kurkapa", "Sawinggrai", "Yenbuba"],
        "Misool Utara": ["Aduwei", "Atkari", "Salafen", "Solal"],
        "Misool Barat": ["Biga", "Gamta", "Lilinta", "Magey"],
        "Misool Selatan": ["Dabatan", "Fafanlap", "Usaha Jaya", "Yellu"],
        "Misool Timur": ["Audam", "Folley", "Tomolol"],
        "Salawati Barat": ["Kalobo", "Samate", "Solol"],
        "Salawati Tengah": ["Sakabu", "Waibeem", "Wailen"],
        "Salawati Utara": ["Kalwal", "Samate"],
        "Supnin": ["Kapadiri", "Rauki", "Supnin"],
        "Teluk Mayalibit": ["Beo", "Mumes", "Warsambin"],
        "Tiplol Mayalibit": ["Go", "Kabilol", "Lapintal", "Lupintal"],
        "Waigeo Barat": ["Bianci", "Mutus", "Selpele", "Waisilip"],
        "Waigeo Barat Kepulauan": ["Gag", "Magey", "Pam"],
        "Waigeo Selatan": ["Saonek", "Saporkren", "Yenbeser"],
        "Waigeo Timur": ["Yensner", "Urbinasopen"],
        "Waigeo Utara": ["Kabare", "Kapadiri", "Rauki"],
        "Warwarbomi": ["Warwarbomi"]
    };

</script>

@endsection
