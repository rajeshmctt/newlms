@extends('layouts.participant')

@section('content')

<div class="resources-main">
<h3>{{ $title }}</h3>


<form action="{{ route(config('app.p_slug').'.resources.index')}}" method="get" style="display:inline;">
  <div class="row">
      <div class="col-md-3">
          <div class="ui search focus mt-15">																
            {{ Form::select('program_id', $programs, old('program_id', $programId), ['class' => 'ui hj145 dropdown cntry152 mt-15 prompt srch_explore', 'id' => 'program_id', 'placeholder' => 'Select Program']) }}
          </div>
      </div>  
      <div class="col-md-3">
          <div class="ui search focus mt-15">
              <div class="ui left icon input swdh11 swdh19">
              <input class="prompt srch_explore" name="search" type="text" placeholder="Resource Name" value="{{ $search }}">															
              </div>
          </div>
      </div>  
      <div class="col-md-2 d-none">
          <div class="ui search focus mt-15">
              <div class="ui left icon input swdh11 swdh19">
                  <input class="prompt srch_explore" type="text" placeholder="Start Date">															
              </div>
          </div>
      </div>
      <div class="col-md-2 d-none">
          <div class="ui search focus mt-15">
              <div class="ui left icon input swdh11 swdh19">
                  <input class="prompt srch_explore" type="text" placeholder="End Date">															
              </div>
          </div>
      </div>
      <div class="col-md-3">
          <div class="ui search focus mt-15">																
            {{ Form::select('format', ['document' => 'Document', 'video' => 'Video', 'audio' => 'Audio', 'other' => 'Other'], old('format', $format), ['class' => 'ui hj145 dropdown cntry152 mt-15 prompt srch_explore', 'id' => 'format', 'placeholder' => 'Select Resource Format']) }}
          </div>
      </div>  
      <div class="col-md-2">
          <div class="mt-15">																
              <button class="btn_adcart">Search</button>
          </div>
      </div>  
  </div>  
</form>

  <div class="row">
      @if(count($resources))
      @foreach($resources as $resourceKey => $resource)
      <div class="col-lg-4 col-md-4">
        @if($resource->type == 'link')
          <a href="#" data-toggle="modal" data-target="#videoModal-{{ $resourceKey }}" class="fcrse_1 mt-30 res_tile_cust">
        @else
          <a href="{{ $resource->type == 'link' ? $resource->link : asset('storage/resources/'.$resource->file) }}" class="fcrse_1 mt-30 res_tile_cust">
        @endif
              <div class="fcrse_img">
                @if($resource->format == 'document')
                  <i class="far fa-file-alt"></i>
                @elseif($resource->format == 'video')
                  <i class="fas fa-video"></i>
                @elseif($resource->format == 'audio')
                  <i class="fas fa-volume-up"></i>
                @else
                  <i class="fas fa-file-alt"></i>
                @endif
              </div>
              <div class="fcrse_content">
                 
              <div class="crse14s">{{ $resource->name }}</div>
                  <div class="crse-cate">{!! $resource->description !!}</div>
              </div>
          </a>
      </div>
      @endforeach
      @endif
</div>

<div class="row">
  <div class="col-md-12 mt-5">

    {{ $resources->withQueryString()->links('vendor.pagination.bootstrap-4') }}

  </div>
  </div>
  </div>


  @if(count($resources))
  @foreach($resources as $resourceKey => $resource)

  <div class="modal fade" id="videoModal-{{ $resourceKey }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h3 class="modal-title" id="uploadModalLabel">View Resource</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          {!! $resource->link !!}
        </div>
        <div class="modal-footer bg-secondary">
          <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  @endforeach
  @endif

@endsection