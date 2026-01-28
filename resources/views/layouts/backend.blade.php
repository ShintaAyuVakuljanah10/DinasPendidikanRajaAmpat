<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/skydash/js/select.dataTables.min.css') }}">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.materialdesignicons.com/6.6.96/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.materialdesignicons.com/7.4.47/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/skydash/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/skydash/images/logoRajaAmpat.ico') }}" />

    <script>
        tinymce.init({
            selector: '#contentEditor'
        });

    </script>
    <style>
        .tox-tinymce,
        .tox-editor-container,
        .tox-toolbar,
        .tox-dialog,
        .tox-dialog-wrap {
            z-index: 99999 !important;
        }

    </style>
    @vite(['resources/js/app.js'])

</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('assets/skydash/images/logoRajaAmpat.ico') }}" alt="logo"
                        style="width:30px;height:auto;margin-right:6px;">
                    <span style="color:#000;font-size:14px;font-weight:500;">
                        CMS DISDIK
                    </span>
                </a>

            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav mr-lg-2">
                    <li class="nav-item nav-search d-none d-lg-block">
                        <div class="input-group">
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="{{ asset('assets/skydash/images/faces/face28.jpg') }}" alt="profile" />
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item">
                                <i class="ti-power-off text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->

            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                @php
                $user = auth()->user();
                $menus = $user && $user->role
                ? $user->role->menus()
                ->with(['submenus' => function ($q) {
                $q->orderBy('sort_order');
                }])
                ->orderBy('sort_order')
                ->get()
                : collect();
                @endphp


                <ul class="nav">

                    @foreach ($menus as $menu)

                    {{-- CEK: menu punya sub yang diizinkan --}}
                    @php
                    $allowedSubs = $menu->submenus ?? collect();

                    $isOpen = $allowedSubs->pluck('route')
                    ->contains(fn ($r) => request()->routeIs($r));
                    @endphp

                    {{-- MENU TANPA SUB --}}
                    @if ($allowedSubs->isEmpty())
                    <li class="nav-item {{ request()->routeIs($menu->route) ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route($menu->route) }}">
                            <i class="{{ $menu->icon }} menu-icon"></i>
                            <span class="menu-title">{{ $menu->name }}</span>
                        </a>
                    </li>

                    {{-- MENU DENGAN SUB --}}
                    @else
                    <li class="nav-item {{ $isOpen ? 'active' : '' }}">
                        <a class="nav-link" data-toggle="collapse" href="#menu-{{ $menu->id }}"
                            aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                            <i class="{{ $menu->icon }} menu-icon"></i>
                            <span class="menu-title">{{ $menu->name }}</span>
                            <i class="menu-arrow"></i>
                        </a>

                        <div class="collapse {{ $isOpen ? 'show' : '' }}" id="menu-{{ $menu->id }}">
                            <ul class="nav flex-column sub-menu">
                                @foreach ($allowedSubs as $sub)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs($sub->route) ? 'active' : '' }}"
                                        href="{{ route($sub->route) }}">
                                        {{ $sub->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                    @endif

                    @endforeach

                </ul>

            </nav>

            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="">
                                <div class="">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content-wrapper ends -->
                    <!-- partial:partials/_footer.html -->

                    <!-- partial -->
                </div>
                <!-- main-panel ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->

        <!-- plugins:js -->
        <!-- jQuery (WAJIB PALING ATAS) -->
        <script src="{{ asset('assets/skydash/vendors/js/vendor.bundle.base.js') }}"></script>

        <!-- Plugin -->
        <script src="{{ asset('assets/skydash/vendors/datatables.net/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('assets/skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>

        <!-- Skydash Core -->
        <script src="{{ asset('assets/skydash/js/off-canvas.js') }}"></script>
        <script src="{{ asset('assets/skydash/js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('assets/skydash/js/template.js') }}"></script>
        <script src="{{ asset('assets/skydash/js/settings.js') }}"></script>

        <!-- Dashboard -->
        <script src="{{ asset('assets/skydash/js/dashboard.js') }}"></script>
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        
        <script src="https://cdn.tiny.cloud/1/9mvhx4krgp9y3cvg8gpjtmzvef4ohg1s3d7htwbujtpqxul7/tinymce/6/tinymce.min.js"
            referrerpolicy="origin"></script>

        <script>
            let tinyInitialized = false;
            
            function initTiny() {
                if (tinyInitialized) return;

                tinymce.init({
                    selector: '#contentEditor',
                    height: 300,
                    menubar: 'file edit view insert format table',
                    plugins: 'table lists link code',
                    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright | bullist numlist | table | code',
                    branding: false,
                    promotion: false,
                    setup: function (editor) {
                        editor.on('init', function () {
                            tinyInitialized = true;
                        });
                    }
                });
            }

            function setTinyContent(html = '') {
                if (tinymce.get('contentEditor')) {
                    tinymce.get('contentEditor').setContent(html);
                }
            }

            function getTinyContent() {
                return tinymce.get('contentEditor') ?
                    tinymce.get('contentEditor').getContent() :
                    '';
            }

            /* INIT SAAT MODAL TERBUKA */
            $('#modalPage').on('shown.bs.modal', function () {
                initTiny();
            });

            /* JANGAN DESTROY (API LEBIH STABIL) */
            $('#modalPage').on('hidden.bs.modal', function () {
                // cukup clear content kalau perlu
            });

            /* ================= SAFE USAGE ================= */

        </script>
        <script>
            $(document).ready(function () {
                if ($.fn.modal) {
                    $.fn.modal.Constructor.prototype._enforceFocus = function () {};
                }
            });

        </script>

        @stack('scripts')
</body>

</html>
