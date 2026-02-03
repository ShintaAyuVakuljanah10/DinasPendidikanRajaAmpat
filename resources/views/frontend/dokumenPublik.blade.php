@extends('layouts.frontend.frontend')

@section('title', 'Dokumen Publik')

@section('content')
    <!-- Page Title -->
    <div class="page-title" data-aos="fade">
        <div class="heading">
            <div class="container text-center">
                <h1>Dokumen Publik</h1>
                <p>Koleksi gambar & dokumentasi</p>
            </div>
        </div>
    </div>

    <!-- Galeri Section -->
    <section id="courses" class="courses section py-5">
        <div class="container">
    
            <div class="row g-4">
            @foreach ($files as $file)
                <div class="col-xl-3 col-lg-4 col-md-6" data-aos="zoom-in">
    
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden zoom-wrapper">

    
                        {{-- Link overlay (klik gambar langsung) --}}
                        <a href="{{ asset('storage/'.$file->gambar) }}"
                           target="_blank"
                           class="stretched-link"
                           aria-label="{{ $file->judul }}"></a>
    
                        {{-- Image --}}
                        <img src="{{ asset('storage/'.$file->gambar) }}"
                             class="img-fluid w-100 zoom-target"
                             style="height:200px; object-fit:cover;"
                             alt="{{ $file->judul }}">
    
                        {{-- Content --}}
                        <div class="card-body text-center">
                            <h6 class="fw-semibold mb-1 text-truncate">
                                {{ $file->judul }}
                            </h6>
                            <small class="text-muted">
                                Klik gambar untuk melihat ukuran penuh
                            </small>
                        </div>
    
                    </div>
    
                </div>

                <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl"
                         data-aos="zoom-in">
                        <div class="modal-content border-0 rounded-4 overflow-hidden">
                
                            <div class="modal-header border-0">
                                <h5 class="modal-title" id="imageModalTitle"></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                
                            <div class="modal-body p-0 text-center">
                                <img id="imageModalSrc"
                                     class="img-fluid w-100"
                                     style="max-height:80vh; object-fit:contain;">
                            </div>
                
                        </div>
                    </div>
                </div>
                
            @endforeach
            </div>
    
        </div>
    </section>      
    
@endsection
<script>
    
    document.querySelectorAll('.zoom-wrapper').forEach(wrapper => {
        const img = wrapper.querySelector('.zoom-img');

        wrapper.addEventListener('mouseenter', () => {
            img.style.transform = 'scale(1.1)';
            img.style.transition = 'transform 0.3s ease';
        });

        wrapper.addEventListener('mouseleave', () => {
            img.style.transform = 'scale(1)';
        });
    });
    
    const style = document.createElement('style');
    style.innerHTML = `
    .scale-up {
        transform: scale(1.08);
        transition: transform .3s ease;
    }
    `;
    document.head.appendChild(style);

</script>
    