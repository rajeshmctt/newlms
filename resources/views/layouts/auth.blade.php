<!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, shrink-to-fit=9" />
      <meta name="description" content="" />
      <meta name="author" content="" />

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title }} | {{ config('app.name') }}</title>

  <!-- Favicon Icon -->
  <link rel="icon" type="image/png" href="{{ asset('assets/images/fav.png') }}" />

  <!-- Stylesheets -->
  <link
    href="http://fonts.googleapis.com/css?family=Roboto:400,700,500"
    rel="stylesheet"
  />
  <link href="{{ asset('assets/vendor/unicons-2.0.1/css/unicons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/vertical-responsive-menu.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/responsive.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/night-mode.css') }}" rel="stylesheet" />

  <!-- Vendor Stylesheets -->
  <link href="{{ asset('assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/vendor/OwlCarousel/assets/owl.carousel.css') }}" rel="stylesheet" />
  <link
    href="{{ asset('assets/vendor/OwlCarousel/assets/owl.theme.default.min.css') }}"
    rel="stylesheet"
  />
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link
    rel="stylesheet"
    type="text/css"
    href="{{ asset('assets/vendor/semantic/semantic.min.css') }}"
  />

  <style>
    .text-theme{
      color: #073042 !important;
    }
    .text-theme2{
      color: #447B98 !important;
    }
    .bg-theme{
      background-color: #073042 !important;
    }
    .bg-theme2{
      background-color: #e4e4e4 !important;
      color: #000 !important;
    }
    .crse-cate_list{
      height: 40px !important;
    }
    </style>
  @yield('style')

</head>

<body>
  
  <div class="sign_in_up_bg">
    <div class="container">
      <div class="row justify-content-lg-center justify-content-md-center">

      @yield('content')

      </div>
    </div>
  </div>

<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/OwlCarousel/owl.carousel.js') }}"></script>
<script src="{{ asset('assets/vendor/semantic/semantic.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('assets/js/night-mode.js') }}"></script>

@yield('script')

</body>
</html>
