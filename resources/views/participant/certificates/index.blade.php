@extends('layouts.participant')

@section('style')
<style type="text/css">
.crse-cate{
  height: 100px;
}
</style>
@endsection

@section('content')

<h3>
  {{ $title }}
  <span class="float-right d-none">
      <a href="{{ route(config('app.p_slug').'.certificates.index', ['view' => 'grid']) }}" class="mr-2"><i class="fas fa-lg fa-th-large {{ !Request::get('view') || Request::get('view') == 'grid' ? 'text-theme2' : 'text-theme' }}"></i></a>
      <a href="{{ route(config('app.p_slug').'.certificates.index', ['view' => 'list']) }}" class="mr-2"><i class="fas fa-lg fa-th-list {{ Request::get('view') == 'list' ? 'text-theme2' : 'text-theme' }}"></i></a>
  </span>
</h3>

<div class="_14d25">
  <div class="row">

    <div class="table-responsive mt-5">
      <table class="table ucp-table">
        <thead class="thead-s">
          <tr>
            <th>Program</th>
            <th>Batch</th>
            <th>Certificate</th>
          </tr>
        </thead>
        <tbody>
          @if (count($certificates))
          @foreach ($certificates as $certificate)
          <tr>
            <td>{{ $certificate->batch->program->name }}</td>
            <td>{{ $certificate->batch->name }}</td>
            <td>
              <a href="{{ asset('storage/certificates/'.$certificate->certificate) }}" class="ml-3" target="_blank"><i class="fa fa-lg fa-eye text-secondary"></i></a>
              <a href="{{ route('download', ['file' => 'certificates/'.$certificate->certificate]) }}" class="ml-3" target="_blank"><i class="fa fa-lg fa-download text-secondary"></i></a>
            </td>
          </tr>
          @endforeach
          @else
          <tr>
            <td colspan="3" class="text-center">No records found</td>
          </tr>
          @endif
        </tbody>
      </table>

    </div>

    <div class="col-md-12 mt-5">
      
      {{ $certificates->withQueryString()->links('vendor.pagination.bootstrap-4') }}

    </div>
  </div>
</div>

@endsection