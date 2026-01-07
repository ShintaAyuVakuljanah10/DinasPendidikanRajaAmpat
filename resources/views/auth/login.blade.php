<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/skydash/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('assets/skydash/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('assets/skydash/images/favicon.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo d-flex align-items-center">
                    <img src="{{ asset('assets/skydash/images/logorajaampat.ico') }}"
                        alt="logo"
                        style="width:35px;height:auto;margin-right:8px;">
                    <h4 class="ms-3 mb-0">Silahkan Login Terlebih Dahulu</h4>
                </div>
                <form class="pt-3" method="POST" action="{{ route('login.process') }}">
                    @csrf                    
                    <div class="form-group">
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control form-control-lg" placeholder="Password">
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif
                    <div class="mt-3">
                        <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                            SIGN IN
                        </button>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('assets/skydash/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('assets/skydash/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/skydash/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/skydash/js/template.js') }}"></script>
  <script src="{{ asset('assets/skydash/js/settings.js') }}"></script>
  <script src="{{ asset('assets/skydash/js/todolist.js') }}"></script>
  <!-- endinject -->
</body>

</html>
