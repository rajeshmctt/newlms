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

$('.opt_it_now').click(function(){
    $.ajax({
      type: "POST",
      url: "{{ route(config('app.p_slug').'.electives.batches.opt', [$electiveBatch->program->id, $electiveBatch->id]) }}",
      data: {"_token": "{{ csrf_token() }}", "batch_id": $('input[name="batch_id"]:checked').val()},
      dataType: "json",
      success: function(response){
        if(response.status == true){
          alert(response.message);
          location.href = "{{ route(config('app.p_slug').'.my_electives.batches.show', [$electiveBatch->program->id, $electiveBatch->id]) }}";
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

<div class="row justify-content-center">
  <div class="col-md-12">
              
  @if(session()->get('success'))
        <div class="alert alert-success">
        {{ session()->get('success') }}  
        </div>
    @endif

    @if(session()->get('error'))
        <div class="alert alert-danger">
        {{ session()->get('error') }}  
        </div>
    @endif
  </div>
</div>
<!-- /.row -->


<div class="_215b01">
  <div class="container-fluid">			
    <div class="row">
      <div class="col-lg-12">
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
                <h2>{{ $electiveBatch->program->name }}

                  <span class="">
                    @if($electiveBatch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'like')->count() > 0)
                    <a class="feedback-icon-top" title="Like" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/like.png') }}" /><span class="badge badge-warning count">{{ $electiveBatch->program->programFeedbacks->where('emoticon', 'like')->count() }}</span></a>
                    @endif
                    @if($electiveBatch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'insightful')->count() > 0)
                    <a class="feedback-icon-top" title="Enlightened" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/insightful.png') }}" /><span class="badge badge-warning count">{{ $electiveBatch->program->programFeedbacks->where('emoticon', 'insightful')->count() }}</span></a>
                    @endif
                    @if($electiveBatch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'curious')->count() > 0)
                    <a class="feedback-icon-top" title="Curious" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/curious.png') }}" /><span class="badge badge-warning count">{{ $electiveBatch->program->programFeedbacks->where('emoticon', 'curious')->count() }}</span></a>
                    @endif
                    @if($electiveBatch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'favourite')->count() > 0)
                    <a class="feedback-icon-top" title="Love" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/favourite.png') }}" /><span class="badge badge-warning count">{{ $electiveBatch->program->programFeedbacks->where('emoticon', 'favourite')->count() }}</span></a>
                    @endif
                  </span>
          
                </h2>
                <span class="_215b04">{!! $electiveBatch->program->description !!}</span>
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
                On  {{ $electiveBatch->start_date->format('d M, Y') }}, @if($electiveBatch->start_time && $electiveBatch->end_time) {{ $electiveBatch->start_time->format('H:i').' to '.$electiveBatch->end_time->format('H:i').' IST' }} @endif
              </div>
              <ul class="_215b31">
              @if(!$electiveBatch->batchUser)										
                @if($optItNow)
                <li><a href="#" data-toggle="modal" data-target="#optModal"><button class="btn_adcart">Enroll Now</button></a></li>
                @endif
              @endif
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
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="optModalLabel">{{ $electiveBatch->program->name }}</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="mt-5 mb-5 text-center">Choose a Program to Enroll this Elective</h3>
        <table class="table table-hover ucp-table">
          <thead>
            <tr>
              <th>Select</th>
              <th>Program</th>
            </tr>
          </thead>
          <tbody>
          @if($programBatches)
          @php($firstOpt = true)
          @foreach($programBatches as $programBatchKey => $programBatch)
          @if($programBatch->zero_cost_electives > $programBatch->elective_users_count)
            <tr>
              <td><input type="radio" name="batch_id" value="{{ $programBatch->id }}" {{ $firstOpt ? 'checked' : '' }} /></td>
              <td>{{ $programBatch->program->name }}</td>
            </tr>
          @php($firstOpt = false)
          @endif
          @endforeach
          @endif
          </tbody>
        </table>
      </div>
      <div class="modal-footer bg-secondary">
        <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
        <button type="button" class="btn_adcart opt_it_now">Enroll for Free</button>
      </div>
    </div>
  </div>
</div>

@endsection