@extends('layouts.participant')

@section('script')
<script type="text/javascript">
$(function(){
  $('.feedback-icon').click(function(){
    if($(this).hasClass('selected')){
      $(this).removeClass('selected');
      $('input[name="emoticon"]').val('');
    } else {
      $('.feedback-icon').removeClass('selected');
      $(this).addClass('selected');
      $('input[name="emoticon"]').val($(this).data('icon'));
    }
  });
});
</script>
@endsection

@section('content') 


<div class="_215b01">
  <div class="container-fluid">			
    <div class="row">
      <div class="col-lg-12">

        <div class="_215b03">
          <h2>Program: {{ $batch->program->name }} </h2>
          <span class="_215b04"><a href="{{ route(config('app.p_slug').'.my_programs.batches.show', [$batch->program->id, $batch->id, 'tab' => 'electives']) }}"><button class="btn_buy"><i class="fa fa-arrow-left"></i> Back to My Program</button></a></span>

          @if($batch->zero_cost_electives - $optedElectivesCount > 0)
            <span class="_215b04 ml-3">
              You are yet to select '{{ $batch->zero_cost_electives - $optedElectivesCount }}' elective(s) as part of this program structure.
            </span>
          @endif
          </div>
          
        <hr>
        
        <div class="section3125">							
          <div class="row justify-content-center">						
            <div class="col-xl-4 col-lg-5 col-md-6">						
              <div class="preview_video">						
                <a href="#" class="fcrse_img" data-toggle="modal" data-target="#videoModal">
                  <img src="{{ asset('storage/programs/'.$electiveBatch->program->image) }}" alt="">
                  <div class="course-overlay">
                    @if($electiveBatch->program->label)
                    <div class="badge_seller">{{ $electiveBatch->program->label->name }}</div>
                    @endif
                  </div>
                </a>
              </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-6">
              <div class="_215b03">
                <h2>{{ $electiveBatch->program->name }}</h2>
                <span class="_215b04">{!! Str::limit($electiveBatch->program->description, 150) !!}</span>
              </div>
              
              @if($electiveBatch->faculties)
              <div class="_215b06">
              @foreach($electiveBatch->faculties as $facultyKey => $faculty)
              <div class="_215b07">										
                <span><i class='uil uil-user'></i></span>
                {{ $faculty->first_name.' '.$faculty->last_name }}
              </div>
              @endforeach
              </div>
              @endif
              
              <div class="_215b05">										
                On  {{ $electiveBatch->start_date->format('d M, Y') }}, @if($electiveBatch->start_time && $electiveBatch->end_time) {{ $electiveBatch->start_time.' to '.$electiveBatch->end_time.' IST' }} @endif
              </div>
              <ul class="_215b31">																			
                @if($batch->batchUser->certificate)
                <li><a href="{{ asset('storage/certificates/'.$batch->batchUser->certificate) }}" target="_blank"><button class="btn_adcart">View Certificate</button></a></li>
                @endif
                <li><a href="#"><button class="btn_buy">Enrolled In {{ $electiveBatch->batchUser->parentBatch->program->name }}</button></a></li>
              </ul>
            </div>							
          </div>							
        </div>							
      </div>															
    </div>
  </div>
</div>

@include(config('app.p_slug').'.parts.my_elective_details')

@endsection