@extends('layouts.admin')

@section('content')
<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <!-- Info boxes -->
    <div class="row justify-content-center">
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route(config('app.a_slug').'.programs.index') }}">
        <div class="info-box bg-light">
          <span class="info-box-icon bg-success elevation-2"><i class="fas fa-graduation-cap"></i></span>
          <div class="info-box-content">
            <span class="info-box-text text-dark">Programs</span>
            <span class="info-box-number text-dark">
                {{ $counts['programs'] }}
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route(config('app.a_slug').'.batches.index') }}">
        <div class="info-box mb-3 bg-light">
          <span class="info-box-icon bg-danger elevation-2"><i class="fas fa-user-friends"></i></span>

          <div class="info-box-content">
            <span class="info-box-text text-dark">Batches</span>
            <span class="info-box-number text-dark">
              {{ $counts['batches'] }}
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route(config('app.a_slug').'.participants.index') }}">
        <div class="info-box mb-3 bg-light">
          <span class="info-box-icon bg-warning elevation-2"><i class="fas fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text text-dark">Participants</span>
            <span class="info-box-number text-dark">
              {{ $counts['users'] }}
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route(config('app.a_slug').'.faculties.index') }}">
        <div class="info-box mb-3 bg-light">
          <span class="info-box-icon bg-info elevation-2"><i class="fas fa-chalkboard-teacher"></i></span>

          <div class="info-box-content">
            <span class="info-box-text text-dark">Faculty</span>
            <span class="info-box-number text-dark">
              {{ $counts['faculties'] }}
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
        </a>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
    
  </div><!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection
          