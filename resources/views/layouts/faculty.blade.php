<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, shrink-to-fit=9" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ $title }} | {{ config('app.name') }}</title>

    <!-- Favicon Icon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/fav.png') }}" />

    <!-- Stylesheets -->
    <link
      href="http://fonts.googleapis.com/css?family=Roboto:400,700,500"
      rel="stylesheet"
    />
    <link href="{{ asset('assets/vendor/unicons-2.0.1/css/unicons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/vertical-responsive-menu1.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/instructor-dashboard.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/instructor-responsive.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/select2.min.css') }}">	
    <link href="{{ asset('assets/css/night-mode.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
      background-color: #447B98 !important;
    }
    .crse-cate_list{
      height: 40px !important;
    }
    </style>
    @yield('style')

  </head>
    
<body>

  @include('layouts.faculty_header')
  @include('layouts.faculty_sidebar')

  <!-- Body Start -->
  <div class="wrapper">
    <div class="sa4d25">
      <div class="container-fluid clearfix" style="min-height:600px; margin-bottom: 100px;">

        @yield('content')

      </div>

      @include('layouts.faculty_footer')
      
    </div>
  </div>

  <script src="{{ asset('assets/js/vertical-responsive-menu.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/OwlCarousel/owl.carousel.js') }}"></script>
  <script src="{{ asset('assets/vendor/semantic/semantic.min.js') }}"></script>
  <script src="{{ asset('assets/js/custom1.js') }}"></script>
  <script src="{{ asset('assets/js/night-mode.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    $(document).ready(function() {
      $('.selectpicker').select2();
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>

  @yield('script')

</body>
</html>
