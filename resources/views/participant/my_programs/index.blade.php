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
      <a href="{{ route(config('app.p_slug').'.my_programs.index', ['view' => 'grid']) }}" class="mr-2"><i class="fas fa-lg fa-th-large {{ !Request::get('view') || Request::get('view') == 'grid' ? 'text-theme2' : 'text-theme' }}"></i></a>
      <a href="{{ route(config('app.p_slug').'.my_programs.index', ['view' => 'list']) }}" class="mr-2"><i class="fas fa-lg fa-th-list {{ Request::get('view') == 'list' ? 'text-theme2' : 'text-theme' }}"></i></a>
  </span>
</h3>

<form action="{{ route(config('app.p_slug').'.my_programs.index')}}" method="get" style="display:inline;">
  <ul class="more_options_tt">
    <li>
      <div class="explore_search">
        <div class="ui search focus">
          <div class="ui left icon input swdh11 swdh15">
          <input class="prompt srch_explore" type="text" name="search" placeholder="Search" value="{{ $search }}">
            <i class="uil uil-search-alt icon icon8"></i>
          </div>
        </div>
      </div>
    </li>
    <li><button type="submit" class="more_items_14"><i class="fas fa-search"></i></button></li>
  </ul>
  </form>
  
<div class="_14d25">
  <div class="row">

  
    @if (count($batches))
    @foreach ($batches as $batch)
      @include(config('app.p_slug').'.parts.single_my_program')
    @endforeach
    @else
    <p class="text-center mt-5">No Programs found</p>
    @endif

    <div class="col-md-12 mt-5">
      
      {{ $batches->withQueryString()->links('vendor.pagination.bootstrap-4') }}

    </div>
  </div>
</div>

@endsection