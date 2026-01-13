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
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('assets/skydash/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="shortcut icon" href="{{ asset('assets/skydash/images/logoRajaAmpat.ico') }}" />
    <script src="https://cdn.tiny.cloud/1/e2kzbf6ud3uhuc9nqgzvsagy9crvxasztgheaapn2rayyfvf/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>  
    <script>
      tinymce.init({
        selector: '#mytextarea'
      });
    </script>
    <style>
        .tox-tinymce,
        .tox-editor-container,
        .tox-toolbar {
            z-index: 2000 !important;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand d-flex align-items-center" href="#">
                    <img src="{{ asset('assets/skydash/images/logoRajaAmpat.ico') }}"
                        alt="logo"
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
                            <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
                                <span class="input-group-text" id="search">
                                    <i class="icon-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now"
                                aria-label="search" aria-describedby="search">
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
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backend.pages') }}"                        >
                            <i class="mdi mdi-view-dashboard menu-icon"></i>
                            <span class="menu-title">Pages</span>
                        </a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user') }}">
                            <i class="icon-head menu-icon"></i>
                            <span class="menu-title">Data User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('category') }}">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Kategori</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('post') }}">
                            <i class="icon-head menu-icon"></i>
                            <span class="menu-title">Post</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('backend.menu') }}">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Menu</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#menu-setting"
                            aria-expanded="false" aria-controls="menu-setting">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Menu</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="menu-setting">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Menu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Submenu</a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}

                    <li class="nav-item {{ request()->is('settings/*') ? 'active' : '' }}">
                        <a class="nav-link" data-toggle="collapse" href="#settings"
                            aria-expanded="{{ request()->is('settings/*') ? 'true' : 'false' }}"
                            aria-controls="settings">

                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Settings</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse {{ request()->is('settings/*') ? 'show' : '' }}" id="settings">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('settings/aplikasi') ? 'active' : '' }}"
                                    href="{{ url('settings/aplikasi') }}">
                                        Aplikasi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('settings/banner') ? 'active' : '' }}"
                                    href="{{ url('settings/banner') }}">
                                        Banner
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('fileManager') }}">
                            <i class="icon-paper menu-icon"></i>
                            <span class="menu-title">File Manager</span>
                        </a>
                    </li>
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
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
