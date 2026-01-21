<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'Berita')</title>

  <!-- CSS sama seperti template -->
  <link href="{{ asset('assets/Mentor/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/Mentor/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/Mentor/assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/Mentor/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/Mentor/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/Mentor/assets/css/main.css') }}" rel="stylesheet">
</head>

<body class="courses-page">

{{-- @include('frontend.partials.header') --}}



<main class="main">
    @yield('content')
</main>
{{--    
@include('frontend.partials.footer') --}}

<script src="{{ asset('assets/Mentor/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/Mentor/assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/Mentor/assets/js/main.js') }}"></script>
</body>
</html>
