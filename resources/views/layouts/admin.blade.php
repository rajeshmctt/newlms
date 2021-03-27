<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title }} | {{ config('app.name') }}</title>

  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <style type="text/css">
  .select2-container--default span.select2-selection--multiple li.select2-selection__choice {
    background-color: #928d8d !important;
  }
  .select2-container--default span.select2-selection--multiple li.select2-selection__choice button {
    color: #fff !important;
  }
  .brand-link {
    font-size: 16px;
    line-height: 28px;
  }
  </style>
  @yield('style')

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

  @include('layouts.header')
  @include('layouts.sidebar_admin')
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $title }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              @if(isset($breadcrumb) && $breadcrumb != null)
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt"></i></a></li>
                @foreach($breadcrumb as $bc)
                  @if($bc['link'] != null)
                  <li class="breadcrumb-item"><a href="{{ $bc['link'] }}">{{ $bc['text'] }}</a></li>
                  @else
                  <li class="breadcrumb-item active">{{ $bc['text'] }}</li>
                  @endif
                @endforeach
              @endif
            </ol>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  @include('layouts.footer')
</div>
<!-- ./wrapper -->

<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

@yield('script')

</body>
</html>
