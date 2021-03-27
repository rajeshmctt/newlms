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

<script type="text/javascript">

$('.opt_for_free').click(function(){
  $.ajax({
    type: "POST",
    url: "{{ route(config('app.p_slug').'.my_programs.batches.electives.batches.opt', [$batch->program->id, $batch->id, $electiveBatch->elective->id, $electiveBatch->id]) }}",
    data: {"_token": "{{ csrf_token() }}"},
    dataType: "json",
    success: function(response){
      if(response.status == true){
        alert(response.message);
        location.href = "{{ route(config('app.p_slug').'.my_programs.batches.my_electives.batches.show', [$batch->program->id, $batch->id, $electiveBatch->elective->id, $electiveBatch->id]) }}";
      } else {
        alert(response.message);
        location.reload();
      }
    },
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
                  <img src="{{ asset('storage/electives/'.$electiveBatch->elective->image) }}" alt="">
                  <div class="course-overlay">
                    @if($electiveBatch->elective->label)
                    <div class="badge_seller">{{ $electiveBatch->elective->label->name }}</div>
                    @endif
                  </div>
                </a>
              </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-6">
              <div class="_215b03">
                <h2>{{ $electiveBatch->elective->name }}</h2>
                <span class="_215b04">{!! Str::limit($electiveBatch->elective->description, 150) !!}</span>
              </div>
              
              @if($electiveBatch->elective->faculties)
              <div class="_215b06">
              @foreach($electiveBatch->elective->faculties as $facultyKey => $faculty)
              <div class="_215b07">										
                <span><i class='uil uil-user'></i></span>
                {{ $faculty->first_name.' '.$faculty->last_name }}
              </div>
              @endforeach
              </div>
              @endif
              
              <div class="_215b05">										
                On  {{ $electiveBatch->date->format('d M, Y') }}, @if($electiveBatch->start_time && $electiveBatch->end_time) {{ $electiveBatch->start_time.' to '.$electiveBatch->end_time.' IST' }} @endif
              </div>
              <ul class="_215b31">										
              <li><a href="#"><button class="btn_buy"><i class="fa fa-rupee-sign"></i> {{ $electiveBatch->elective->amount }}</button></a></li>
              <li><a href="#"><button class="btn_adcart" data-toggle="modal" data-target="#optModal">Enroll for Free</button></a></li>
              </ul>
            </div>							
          </div>							
        </div>							
      </div>															
    </div>
  </div>
</div>

@include(config('app.p_slug').'.parts.elective_details')

<div class="modal fade" id="optModal" tabindex="-1" role="dialog" aria-labelledby="optModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="optModalLabel">{{ $electiveBatch->elective->name }}</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="mt-5 mb-5 text-center">Are you sure you want to Enroll this Elective?</h3>
      </div>
      <div class="modal-footer bg-secondary">
        <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
        <button type="button" class="btn_adcart opt_for_free">Enroll for Free</button>
      </div>
    </div>
  </div>
</div>


@endsection