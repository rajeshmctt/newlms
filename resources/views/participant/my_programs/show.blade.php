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
<script>
$(document).ready(function() {

  // $(".datepicker-new").datepicker($.datepicker.setLocale('en'));
  $('.datepicker-new').datepicker({ dateFormat: "yy-mm-dd" });

  $('input[type="checkbox"][name="completed"]').click(function(){
    if($(this).prop("checked") == true){
      $(this).parents('.panel-collapse').find('input[name="date"]').prop('disabled', false);
      $(this).parents('.panel-collapse').find('select[name="faculty_id"]').prop('disabled', false);
      $('.ui.dropdown').dropdown('clear');
      $(this).parents('.panel-collapse').find('textarea[name="feedback"]').prop('disabled', false);
      $(this).parents('.panel-collapse').find('button[name="submit"]').prop('disabled', false);
    }
    else if($(this).prop("checked") == false){
      $(this).parents('.panel-collapse').find('input[name="date"]').prop('disabled', true);
      $(this).parents('.panel-collapse').find('select[name="faculty_id"]').prop('disabled', true);
      $('.ui.dropdown').dropdown('clear');
      $(this).parents('.panel-collapse').find('textarea[name="feedback"]').prop('disabled', true);
      $(this).parents('.panel-collapse').find('button[name="submit"]').prop('disabled', true);
    }
  });
});
</script>
@endsection

@section('style')
<style type="text/css">

.feedback-icon-top img{
  height:25px;
  line-height:25px;
}
.feedback-icon-top .count {
  z-index: 1;
  position: relative;
  top: 6px;
  right: 6px;
  font-size:12px;
}
.feedback-icon img{
  height:25px;
  line-height:30px;
  opacity:0.3;
}
.feedback-icon.selected img{
  opacity:1!important;
  margin:5px;
  height:30px;
}

/* CodePend */

.text-right p {
  text-align:right;
}
.blue-bg {
  color: #ED8D8D;
  height: 100%;
}

.circle {
  font-weight: bold;
  padding: 15px 20px;
  border-radius: 50%;
  background-color: #447B98 !important;
  color: #FFF;
  max-height: 50px;
  z-index: 2;
}

.how-it-works h5 {
  color: #447B98 !important;
} 
.how-it-works.row {
  display: flex;
}
.how-it-works.row .col-2 {
  display: inline-flex;
  align-self: stretch;
  align-items: center;
  justify-content: center;
}
.how-it-works.row .col-2::after {
  content: "";
  position: absolute;
  border-left: 3px solid #a8dadc;
  z-index: 1;
}
.how-it-works.row .col-2.bottom::after {
  height: 50%;
  left: 50%;
  top: 50%;
}
.how-it-works.row .col-2.left-full::after {
  height: 100%;
  right: calc(50% - 3px);
}
.how-it-works.row .col-2.full::after {
  height: 100%;
  left: calc(50% - 3px);
}
.how-it-works.row .col-2.top::after {
  height: 50%;
  left: 50%;
  top: 0;
}

.timeline div {
  padding: 0;
  height: 40px;
}
.timeline hr {
  border-top: 3px solid #a8dadc;
  margin: 0;
  top: 17px;
  position: relative;
}
.timeline .col-2 {
  display: flex;
  overflow: hidden;
}
.timeline .corner {
  border: 3px solid #a8dadc;
  width: 100%;
  position: relative;
  border-radius: 15px;
}
.timeline .top-right {
  left: 50%;
  top: -50%;
}
.timeline .left-bottom {
  left: -50%;
  top: calc(50% - 3px);
}
.timeline .top-left {
  left: -50%;
  top: -50%;
}
.timeline .right-bottom {
  left: 50%;
  top: calc(50% - 3px);
}


/* CodePend */



</style>
@endsection

@section('content') 


<div class="_215b01">
  <div class="container-fluid">			
    <div class="row">
      <div class="col-lg-12">
        <div class="section3125">							
          <div class="row justify-content-center">						
            <div class="col-xl-4 col-lg-5 col-md-6">						
              <div class="preview_video">						
                <a href="#" class="fcrse_img" data-toggle="modal" data-target="#videoModal">
                  <img src="{{ asset('storage/programs/'.$batch->program->image) }}" alt="">
                  <div class="course-overlay">
                    @if($batch->program->label)
                    <div class="badge_seller">{{ $batch->program->label->name }}</div>
                    @endif
                  </div>
                </a>
              </div>
            </div>
            <div class="col-xl-8 col-lg-7 col-md-6">
              <div class="_215b03">
                <h2>{{ $batch->program->name }}
                
                    <span class="">
                      @if($batch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'like')->count() > 0)
                      <a class="feedback-icon-top" title="Like" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/like.png') }}" /><span class="badge badge-warning count">{{ $batch->program->programFeedbacks->where('emoticon', 'like')->count() }}</span></a>
                      @endif
                      @if($batch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'insightful')->count() > 0)
                      <a class="feedback-icon-top" title="Enlightened" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/insightful.png') }}" /><span class="badge badge-warning count">{{ $batch->program->programFeedbacks->where('emoticon', 'insightful')->count() }}</span></a>
                      @endif
                      @if($batch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'curious')->count() > 0)
                      <a class="feedback-icon-top" title="Curious" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/curious.png') }}" /><span class="badge badge-warning count">{{ $batch->program->programFeedbacks->where('emoticon', 'curious')->count() }}</span></a>
                      @endif
                      @if($batch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'favourite')->count() > 0)
                      <a class="feedback-icon-top" title="Love" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/favourite.png') }}" /><span class="badge badge-warning count">{{ $batch->program->programFeedbacks->where('emoticon', 'favourite')->count() }}</span></a>
                      @endif
                    </span>
              
                </h2>
                <span class="_215b04">{!! $batch->program->description !!}</span>
              </div>
              
              <div class="_215b05">										
                {{ $batch->users->count() }} participants
              </div>
              
              @if($batch->faculties)
              <div class="_215b06">
              @foreach($batch->faculties as $facultyKey => $faculty)
              <div class="_215b07">										
                <span><i class='uil uil-user'></i></span>
                {{ $faculty->first_name.' '.$faculty->last_name }}
              </div>
              @endforeach
              </div>
              @endif
              
              <div class="_215b05">										
                Starts on  {{ $batch->start_date->format('d M, Y') }}
              </div>
              @if($batch->program->certificationLevel)
              <div class="_215b05">										
                Recommended for <b>{{ $batch->program->certificationLevel->name }}</b> certification
              </div>
              @endif
              <ul class="_215b31">										
                @if($batch->batchUser->certificate)
                <li><a href="{{ asset('storage/certificates/'.$batch->batchUser->certificate) }}" target="_blank"><button class="btn_adcart">View Certificate</button></a></li>
                @endif
                <li><button class="btn_buy">{{ $batch->batchUser->status == 'completed' ? 'Completed' : 'Enrolled' }}</button></li>
              </ul>
            </div>							
          </div>							
        </div>							
      </div>															
    </div>
  </div>
</div>

@if($batch->program->agreement && !$batch->batchUser->accept_agreement)

<div class="row">
  <div class="col-12 mt-5">
    <div class="card p-5">
      {!! $batch->program->agreement->content !!}
      <div class="text-center">
        <button type="submit" class="btn_adcart" data-toggle="modal" data-target="#acceptModal">I Agree & Accept</button>
      </div>
    </div>
  </div>
</div>

{{ Form::open(array('route' => [Config::get('app.p_slug').'.my_programs.batches.accept_agreement', [$batch->program->id, $batch->id]], 'method' => 'post')) }}
<div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="acceptModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="acceptModalLabel">Accept Agreement</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <h3 class="mt-5 mb-5">Are you sure do you want to Accept the Agreement?</h3>
      </div>
      <div class="modal-footer bg-secondary">
        <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
        <button type="submit" class="btn_adcart">Accept</button>
      </div>
    </div>
  </div>
</div>
{{ Form::close() }}

@else

<div class="_215b15 _byt1458">
  <div class="container-fluid">

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

    <div class="row">
      <div class="col-lg-12">

        @if($batch->zero_cost_electives - $optedElectivesCount > 0)
        <p class="text-center text-info">
          <!-- <a onclick="document.getElementById('nav-electives-tab').click();" style="cursor: pointer;"> -->
          <a href="{{ route(config('app.p_slug').'.electives.index') }}" style="cursor: pointer;">
            You are yet to select '{{ $batch->zero_cost_electives - $optedElectivesCount }}' elective(s) as part of this program structure. Kindly click here to view the list of upcoming electives and make your selection. 
          </a> 
        </p>
        @endif

        <div class="course_tabs">
          <nav>
            <div class="nav nav-tabs tab_crse justify-content-center" id="nav-tab" role="tablist">
              <a class="nav-item nav-link {{ $activeTab == 'journey' ? 'active' : '' }}" id="nav-journey-tab" data-toggle="tab" href="#nav-journey" role="tab" aria-selected="true">Course Journey</a>
              <a class="nav-item nav-link {{ $activeTab == 'outline' ? 'active' : '' }}" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-selected="true">Course Outline</a>
              @if($batch->zero_cost_electives > 0)
              <a class="nav-item nav-link {{ $activeTab == 'electives' ? 'active' : '' }}" id="nav-electives-tab" data-toggle="tab" href="#nav-electives" role="tab" aria-selected="false">Electives</a>
              @endif
              <a class="nav-item nav-link {{ $activeTab == 'resources' ? 'active' : '' }}" id="nav-courses-tab" data-toggle="tab" href="#nav-courses" role="tab" aria-selected="false">Resources</a>
              <a class="nav-item nav-link {{ $activeTab == 'recordings' ? 'active' : '' }}" id="nav-recordings-tab" data-toggle="tab" href="#nav-recordings" role="tab" aria-selected="false">Recordings</a>
              <a class="nav-item nav-link {{ $activeTab == 'assignments' ? 'active' : '' }}" id="nav-assignments-tab" data-toggle="tab" href="#nav-assignments" role="tab" aria-selected="false">Assignments</a>
              <a class="nav-item nav-link {{ $activeTab == 'batchmates' ? 'active' : '' }}" id="nav-batchmates-tab" data-toggle="tab" href="#nav-batchmates" role="tab" aria-selected="false">Batchmates</a>
              @if($batch->mentor_coach_meetings > 0)
              <a class="nav-item nav-link {{ $activeTab == 'mentor-coach' ? 'active' : '' }}" id="nav-mentor-coach-tab" data-toggle="tab" href="#nav-mentor-coach" role="tab" aria-selected="false">Mentor Coach</a>
              @endif
              <a class="nav-item nav-link {{ $activeTab == 'faculty' ? 'active' : '' }}" id="nav-faculty-information-tab" data-toggle="tab" href="#nav-faculty-information" role="tab" aria-selected="false">Faculty</a>
              <a class="nav-item nav-link {{ $activeTab == 'feedback' ? 'active' : '' }}" id="nav-comments-feedback-tab" data-toggle="tab" href="#nav-comments-feedback" role="tab" aria-selected="false">@if($feedbacksCount < 3 && $batch->end_date < Carbon\Carbon::today()) Share Your Feedback @else View Feedback @endif</a>
            </div>
          </nav>						
        </div>
      </div>
    </div>
  </div>
</div>
<div class="_215b17">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="course_tab_content">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade {{ $activeTab == 'journey' ? 'show active' : '' }}" id="nav-journey" role="tabpanel">
              <div class="_htg451">
                <div class="_htg452 mt-35">
                <h3>Course Journey</h3>


                @if(count($batch->courseJourneys) > 0)
                <div class="container-fluid blue-bg">
                  <div class="container">


                  @foreach($batch->courseJourneys as $courseJourneyKey => $courseJourney)

                    @php($tail = 'full')

                    @if($courseJourneyKey == 0)
                      @php($tail = 'bottom')
                    @elseif(count($batch->courseJourneys) == $courseJourneyKey + 1)
                      @php($tail = 'top')
                    @else

                    @endif

                    @if($courseJourneyKey%2 == 0)
                    <!--dot-->
                    <div class="row align-items-center how-it-works">
                      <div class="col-2 text-center left-{{ $tail }}">
                        <div class="circle">{{ $courseJourneyKey+1 }}</div>
                      </div>
                      <div class="col-6 @if($courseJourneyKey%2 != 0) text-right @endif">
                        <h5>{{ $courseJourney->title }}</h5>
                        <p>{{ $courseJourney->message }}<br>{{ $courseJourney->created_at->format('M d, Y') }}</p>
                      </div>
                    </div>
                    @else
                    <!--dot-->
                    <div class="row align-items-center justify-content-end how-it-works">
                      <div class="col-6 text-right">
                        <h5>{{ $courseJourney->title }}</h5>
                        <p>{{ $courseJourney->message }}<br>{{ $courseJourney->created_at->format('M d, Y') }}</p>
                      </div>
                      <div class="col-2 text-center {{ $tail }}">
                        <div class="circle">{{ $courseJourneyKey+1 }}</div>
                      </div>
                    </div>
                    @endif

                    @if(count($batch->courseJourneys) != $courseJourneyKey + 1)
                    <!--line-->
                    <div class="row timeline">
                      <div class="col-2">
                        <div class="corner @if($courseJourneyKey%2 == 0) top-right @else right-bottom @endif "></div>
                      </div>
                      <div class="col-8">
                        <hr/>
                      </div>
                      <div class="col-2">
                        <div class="corner @if($courseJourneyKey%2 == 0) left-bottom @else top-left @endif"></div>
                      </div>
                    </div>
                    @endif


                  @endforeach
                  
                  </div>
                </div>
                  @endif
                  
                </div>
              </div>							
            </div>
            <div class="tab-pane fade {{ $activeTab == 'outline' ? 'show active' : '' }}" id="nav-about" role="tabpanel">

            @if($batch->program->long_description)
            <div class="_htg451">
              <div class="_htg452 mt-35">
                <h3>Description</h3>
                <p>{!! $batch->program->long_description !!}</p>
              </div>
            </div>
          @endif

            @if($batch->program->who_is_it_for)
              <div class="_htg451">
                <div class="_htg452 mt-35">
                  <h3>Who is it for</h3>
                  <p>{!! $batch->program->who_is_it_for !!}</p>
                </div>
              </div>
            @endif
            @if($batch->program->what_you_will_gain)
              <div class="_htg451">
                <div class="_htg452 mt-35">
                  <h3>What you will gain</h3>
                  <p>{!! $batch->program->what_you_will_gain !!}</p>
                </div>
              </div>	
            @endif						
              <div class="_htg451">
                <div class="_htg452 mt-35">
                  <h3>Session-wise Information</h3>
                  
                  <table class="table table-bordered ucp-table">
                    <thead>
                      <tr>
                        <th>Session No.</th>
                        <th>Time in Hrs</th>
                        <th>Topics for the Session</th>
                        <th>Date</th>
                        <th>Time</th>
                      </tr>
                    </thead>
                    <tbody>
                    @if(count($batch->sessions))
                    @foreach($batch->sessions as $sessionKey => $session)
                    @php( $mins = $session->end_time->diffInMinutes($session->start_time) )
                      <tr>
                        <td>{{ $session->session_no }}</td>
                        <td>{{ $mins/60 }}</td>
                        <td>{{ $session->description }}</td>
                        <td>{{ $session->date ? $session->date->format('d/m/Y') : '-' }}</td>
                        <td>{{ $session->start_time->format('h:i A').' - '.$session->end_time->format('h:i A') }}</td>
                      </tr>
                    @endforeach
                    @else
                      <tr>
                        <td colspan="5" class="text-center">No sessions found</td>
                      </tr>
                    @endif
                    </tbody>
                  </table>
                  
                </div>
              </div>							
            </div>
            <div class="tab-pane fade {{ $activeTab == 'resources' ? 'show active' : '' }}" id="nav-courses" role="tabpanel">
              <div class="crse_content">
                <div class="ui-accordion ui-widget ui-helper-reset">
                  <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                    
                    @php($rCount = 0)

                    @if(count($batch->program->resources))
                    @foreach($batch->program->resources as $resource)
                        @php($rCount++)
                    <div class="lecture-container">
                      <div class="left-content">
                        @if($resource->format == 'document')
                          <i class='uil uil-file icon_142'></i>
                        @elseif($resource->format == 'video')
                          <i class="uil uil-play-circle icon_142"></i>
                        @elseif($resource->format == 'audio')
                          <i class="uil uil-play-circle icon_142"></i>
                        @else
                          <i class="uil uil-file-download-alt icon_142"></i>
                        @endif
                        <div class="top">
                        <div class="title">{{ $resource->name }}</div>
                        </div>
                      </div>
                      <div class="details">
                        <a href="{{ $resource->type == 'link' ? $resource->link : asset('storage/resources/'.$resource->file) }}" target="_blank" class=" text-success">View <i class="fas fa-eye text-success"></i></a>
                        @if($resource->type == 'file')
                        <a href="{{ route('download', ['file' => 'resources/'.$resource->file]) }}" target="_blank" class=" text-danger ml-3">Download <i class="fas fa-download text-danger"></i></a>
                        @endif
                      </div>
                    </div>
                    @endforeach
                    @endif

                    @if(count($userResources))
                    @foreach($userResources as $userResource)
                        @php($rCount++)
                    <div class="lecture-container">
                      <div class="left-content">
                        @if($userResource->format == 'document')
                          <i class='uil uil-file icon_142'></i>
                        @elseif($userResource->format == 'video')
                          <i class="uil uil-play-circle icon_142"></i>
                        @elseif($userResource->format == 'audio')
                          <i class="uil uil-play-circle icon_142"></i>
                        @else
                          <i class="uil uil-file-download-alt icon_142"></i>
                        @endif
                        <div class="top">
                        <div class="title">{{ $userResource->name }}</div>
                        </div>
                      </div>
                      <div class="details">
                        <a href="{{ $userResource->type == 'link' ? $userResource->link : asset('storage/resources/'.$userResource->file) }}" target="_blank" class=" text-success">View <i class="fas fa-eye text-success"></i></a>
                        @if($userResource->type == 'file')
                        <a href="{{ route('download', ['file' => 'resources/'.$userResource->file]) }}" target="_blank" class=" text-danger ml-3">Download <i class="fas fa-download text-danger"></i></a>
                        @endif
                      </div>
                    </div>
                    @endforeach
                    @endif

                    
                    @if($rCount == 0)
                    <p class="text-center">No Resources found</p>
                    @endif
                    

                  </div>
              
                                
                </div>
              </div>
            </div>
            <div class="tab-pane fade {{ $activeTab == 'electives' ? 'show active' : '' }}" id="nav-electives" role="tabpanel">
              <div class="_14d25 mb-20 mt-5">						
                <div class="row">

                @if($batch->zero_cost_electives - $optedElectivesCount > 0 && $optedElectivesCount == 0)
                <div class="col-12">
                <p class="text-center text-info">
                  <!-- <a onclick="document.getElementById('nav-electives-tab').click();" style="cursor: pointer;"> -->
                  <a href="{{ route(config('app.p_slug').'.electives.index') }}" style="cursor: pointer;">
                    You are yet to select '{{ $batch->zero_cost_electives - $optedElectivesCount }}' elective(s) as part of this program structure. Kindly click here to view the list of upcoming electives and make your selection. 
                  </a> 
                </p>
                </div>
                @endif
                
                  @if ($myElectiveBatches)
                  @foreach ($myElectiveBatches as $myElectiveBatch)
                  @include(config('app.p_slug').'.parts.single_my_program_my_elective')
                  @endforeach
                  @else

                    @if($batch->zero_cost_electives - $optedElectivesCount > 0)
                    <p class="text-center text-info">
                      <!-- <a onclick="document.getElementById('nav-electives-tab').click();" style="cursor: pointer;"> -->
                      <a href="{{ route(config('app.p_slug').'.electives.index') }}" style="cursor: pointer;">
                        You are yet to select '{{ $batch->zero_cost_electives - $optedElectivesCount }}' elective(s) as part of this program structure. Kindly click here to view the list of upcoming electives and make your selection. 
                      </a> 
                    </p>
                    @endif
                    
                  @endif


                  {{-- 
                  @if ($electiveBatches)
                  @foreach ($electiveBatches as $electiveBatch)
                  @include(config('app.p_slug').'.parts.single_my_program_elective')
                  @endforeach
                  @endif --}}

                </div>																		
              </div>	
            </div>
            <div class="tab-pane fade {{ $activeTab == 'batchmates' ? 'show active' : '' }}" id="nav-batchmates" role="tabpanel">
              <div class="_14d25">
                <div class="row">

                  @if($batch->users)
                  @foreach($batch->users as $batchUser)
                  <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="fcrse_1 mt-30">
                      <div class="tutor_img">
                      <a href="#"><img src="{{ asset('storage/users/'.$batchUser->photo) }}" alt=""></a>												
                      </div>
                      <div class="tutor_content_dt">
                        <div class="tutor150">
                        <a href="#" class="tutor_name">{{ $batchUser->first_name.' '.$batchUser->last_name }}</a>
                        </div>
                        <div class="tutor_cate">{{ $batchUser->email }}</div>
                        <ul class="tutor_social_links">
                          @if($batchUser->facebook_profile_url)
                          <li><a href="{{ $batchUser->facebook_profile_url }}" class="fb"><i class="fab fa-facebook-f"></i></a></li>
                          @endif
                          @if($batchUser->twitter_profile_url)
                          <li><a href="{{ $batchUser->twitter_profile_url }}" class="tw"><i class="fab fa-twitter"></i></a></li>
                          @endif
                          @if($batchUser->linkedin_profile_url)
                          <li><a href="{{ $batchUser->linkedin_profile_url }}" class="ln"><i class="fab fa-linkedin-in"></i></a></li>
                          @endif
                          @if($batchUser->instagram_profile_url)
                          <li><a href="{{ $batchUser->instagram_profile_url }}" class="yu"><i class="fab fa-instagram"></i></a></li>
                          @endif
                        </ul>
                        <div class="tut1250">
                          <span class="vdt15">{{ $batchUser->activeProgramsCount() }} Programs</span>
                          <span class="vdt15">{{ $batchUser->activeElectivesCount() }} Electives</span>
                        </div>
                      </div>
                    </div>										
                  </div>
                  @endforeach
                  @endif
                  
                </div>				
              </div>		
            </div>
            <div class="tab-pane fade {{ $activeTab == 'mentor-coach' ? 'show active' : '' }}" id="nav-mentor-coach" role="tabpanel">
              <div class="_14d25">
                <h3>Mentor Coach</h3>

                @if($batch->mentor_coach_meetings > 0)

                <h3>Please submit the feedback shared by your mentor coach during your session.</h3>

                <div class="accordion" id="accordionExample">
                       
                  @php($i = 1)
                  @if(count($batch->mentorCoachSessions) > 0)
                  @foreach($batch->mentorCoachSessions as $mentorCoachSession)

                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="address{{ $i }}">
                      <div class="panel-title bg-theme2">
                        <a class="collapsed" style="color:white !important;" data-toggle="collapse" data-parent="#accordion" href="#collapseaddress{{ $i }}" aria-expanded="false" aria-controls="collapseaddress{{ $i }}">
                          Session {{ $i }}
                          <span class="float-right">Completed <i class="fa fa-check-circle text-white mr-3"></i></span>
                        </a>
                      </div>
                    </div>
                    <div id="collapseaddress{{ $i }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="address{{ $i }}" style="">
                      <div class="panel-body">
                          <div class="row">
                            <div class="col-lg-6">
                              <div class="ui search focus mt-30 lbel25">
															<label>Date*</label>
                                <div class="ui left icon input swdh11 swdh19">
                                  <input class="prompt srch_explore" type="text" disabled value="{{ $mentorCoachSession->date }}" required="" placeholder="Select Date">															
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="mt-30">										
															<label>Mentor Coach*</label>				
                              {{ Form::select('', $mentorCoaches, old('faculty_id', $mentorCoachSession->faculty_id), ['class' => 'ui hj145 dropdown cntry152 prompt srch_explore ', 'id' => 'faculty_id', 'placeholder' => 'Select Mentor Coach', 'disabled' => 'disabled', 'required' => 'required']) }}
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="ui search focus mt-30 lbel25">		
															<label>Feedback*</label>		
                                <div class="ui left icon input swdh11 swdh19">
                                  <textarea class="_cmnt001 ml-0" placeholder="Feedback" disabled required style="height:auto;">{{ $mentorCoachSession->feedback }}</textarea>													
                                </div>
                              </div>
                            </div>											
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                    
                  @php( $i++ )
                  @endforeach
                  @endif
                         
                  @if($batch->mentor_coach_meetings > 0)
                  @php( $isFirst = true )
                  @for(; $i <= $batch->mentor_coach_meetings; $i++)

                  <form method="post" action="{{ route(config('app.p_slug').'.my_programs.batches.mentor_coach_sessions.feedback.store', [$batch->program->id, $batch->id]) }}">
                  @csrf
                     
                  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                  <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="address{{ $i }}">
                      <div class="panel-title bg-theme2">
                        <a class="{{ $isFirst ? '' : 'collapsed' }}" style="color:white !important;" data-toggle="collapse" data-parent="#accordion" href="#collapseaddress{{ $i }}" aria-expanded="false" aria-controls="collapseaddress{{ $i }}">
                          Session {{ $i }}
                        </a>
                      </div>
                    </div>
                    <div id="collapseaddress{{ $i }}" class="panel-collapse collapse {{ $isFirst ? 'show' : '' }}" role="tabpanel" aria-labelledby="address{{ $i }}" style="">
                      <div class="panel-body">
                          <div class="row">
                            <div class="col-lg-12 pt-5">
                              <label><input type="checkbox" {{ $isFirst ? 'name=completed' : '' }} {{ !$isFirst ? 'disabled' : '' }} /> Completed</label>
                            </div>
                            <div class="col-lg-6">
                              <div class="ui search focus mt-30 lbel25">
															<label>Date*</label>
                                <div class="ui left icon input swdh11 swdh19">
                                  <input {{ $isFirst ? 'name=date' : '' }} class="prompt srch_explore datepicker-new" type="text" disabled value="" required="" placeholder="Select Date" autocomplete="off">															
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <div class="mt-30">										
															<label>Mentor Coach*</label>				
                              {{ Form::select($isFirst ? 'faculty_id' : '', $mentorCoaches, old('faculty_id'), ['class' => 'ui hj145 dropdown cntry152 prompt srch_explore ', 'id' => 'faculty_id', 'placeholder' => 'Select Mentor Coach', 'required' => 'required']) }}
                              </div>
                            </div>
                            <div class="col-lg-12">
                              <div class="ui search focus mt-30 lbel25">		
															<label>Feedback*</label>		
                                <div class="ui left icon input swdh11 swdh19">
                                  <textarea {{ $isFirst ? 'name=feedback' : '' }} class="_cmnt001 ml-0" placeholder="Write your Feedback" disabled required style="height:auto; background:#fff;" maxlength="500"></textarea>													
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-6">
                              <button {{ $isFirst ? 'name=submit' : '' }} class="save_address_btn" type="submit" disabled>Save Changes</button>
                            </div>												
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                </form>
                  
                  @php( $isFirst = false )
                  @endfor
                  @endif
                    
                </div>

                @endif
              </div>			
            </div>
            <div class="tab-pane fade {{ $activeTab == 'assignments' ? 'show active' : '' }}" id="nav-assignments" role="tabpanel">
              <div class="_14d25">
                <h3>Assignments</h3>

                <table class="table table-bordered ucp-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Assignment</th>
                      <th>Program</th>
                      <th>Due Date</th>
                      <th>File(s)</th>
                      <th>Status</th>
                      <th>Upload / Download / Remove</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($batch->assignments) > 0)
                  @foreach($batch->assignments as $assignmentKey => $assignment)
                    <tr>
                      <td>{{ $assignmentKey+1 }}</td>
                      <td>{{ $assignment->name }}</td>
                      <td>{{ $batch->program->name }}</td>
                      <td>{{ $assignment->due_date->format('M d, Y') }}</td>
                      <td>
                        @if(count($assignment->assignmentDocuments) > 0)
                        @foreach($assignment->assignmentDocuments as $assignmentDocument)
                          <a href="{{ asset('storage/assignments/'.$assignmentDocument->document) }}" target="_blank" class="badge badge-success">{{ $assignmentDocument->name }}</a>
                        @endforeach
                        @endif
                      </td>
                      <td>{{ $assignment->userAssignment ? ucwords($assignment->userAssignment->status) : 'Pending' }}</td>
                      <td>
                      <a href="#" class="ml-3" data-toggle="modal" data-target="#uploadModal-{{ $assignmentKey }}"><i class="fa fa-lg fa-upload text-success"></i></a>
                        @if($assignment->userAssignment)
                        @if($assignment->userAssignment->document)
                        <a href="{{ asset('storage/users/assignments/'.$assignment->userAssignment->document) }}" class="ml-3" target="_blank"><i class="fa fa-lg fa-download text-success"></i></a>
                        @endif
                        <!-- <a href="#" class="ml-3"><i class="fa fa-lg fa-times-circle text-danger"></i></a> -->
                        @endif
                      </td>
                    </tr>
                  @endforeach
                  @else
                    <tr>
                      <td colspan="7" class="text-center">No assignments found</td>
                    </tr>
                  @endif
                  </tbody>
                </table>

              </div>			
            </div>
            <div class="tab-pane fade {{ $activeTab == 'faculty' ? 'show active' : '' }}" id="nav-faculty-information" role="tabpanel">

              @if($batch->faculties)
              @foreach($batch->faculties as $facultyKey => $faculty)
              <div class="section3125 rpt145 mt-5">							
                <div class="row">						
                  <div class="col-lg-7">
                    <a href="#" class="_216b22">										
                      <span><i class="uil uil-windsock"></i></span>Report Profile
                    </a>
                    <div class="dp_dt150">						
                      <div class="img148">
                      <img src="{{ asset('storage/faculties/'.$faculty->photo) }}" alt="">										
                      </div>
                      <div class="prfledt1">
                        <h2>{{ $faculty->first_name.' '.$faculty->last_name }}</h2>
                        <span class="d-block">{{ $faculty->email }}</span>
                      </div>										
                    </div>
                  </div>
                </div>		
                <div class="mt-4">
                  <p>{!! $faculty->long_description !!}</p>
                </div>					
              </div>	
              @endforeach
              @endif
              
            </div>
              <div class="tab-pane fade {{ $activeTab == 'feedback' ? 'show active' : '' }}" id="nav-comments-feedback" role="tabpanel">
                <div class="_14d25">

                @if($feedbacksCount < 3 && $batch->end_date < Carbon\Carbon::today())
                  <h3>Share Your Feedback</h3>

                  <form method="post" action="{{ route(config('app.p_slug').'.my_programs.batches.feedback.store', [$batch->program->id, $batch->id]) }}">
                  @csrf
                  
                    <textarea name="feedback" class="form-control" placeholder="Feedback" rows="3" required maxlength="1000"></textarea>
                    <input type="hidden" name="emoticon" value="" />
                    <div class="col-12 mt-2">
                      <a href="javascript:void(0);" class="feedback-icon" data-icon="like" title="Like" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/like.png') }}" /></a>
                      <a href="javascript:void(0);" class="feedback-icon" data-icon="insightful" title="Enlightened" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/insightful.png') }}" /></a>
                      <a href="javascript:void(0);" class="feedback-icon" data-icon="curious" title="Curious" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/curious.png') }}" /></a>
                      <a href="javascript:void(0);" class="feedback-icon" data-icon="favourite" title="Love" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/favourite.png') }}" /></a>
                    </div>
                    <button class="btn btn-primary bg-theme mt-3" style="border-color:#457b97;">Submit</button>
                    
                  </form>
                @else
                  <h3>View Feedback</h3>
                @endif
                  
                  @if(count($batch->program->programFeedbacks) > 0)
                  @foreach($batch->program->programFeedbacks as $programFeedback)

                  <div class="review_all120 mt-30">
										<div class="review_item">
											<div class="review_usr_dt">
												<img src="{{ asset('storage/users/'.$programFeedback->user->photo) }}" alt="">
												<div class="rv1458">
													<h4 class="tutor_name1">{{ $programFeedback->user->first_name.' '.$programFeedback->user->last_name }}</h4>
													<span class="time_145">{{ $programFeedback->created_at->diffForHumans() }}</span>
												</div>
											</div>
											<p class="rvds10">{{ $programFeedback->feedback }}</p>
                      @if($programFeedback->emoticon)
                      <img src="{{ asset('img/feedback-icons/'.$programFeedback->emoticon.'.png') }}" title="{{ $programFeedback->emoticon }}" style="height:25px;" />
                      @endif
										</div>
									</div>

                  @endforeach
                  @endif
                    
                </div>			
              </div>
            <div class="tab-pane fade {{ $activeTab == 'recordings' ? 'show active' : '' }}" id="nav-recordings" role="tabpanel">
              <div class="crse_content">
                <div class="ui-accordion ui-widget ui-helper-reset">
                  <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                    
                  @php($rCount = 0)

                  @if(count($batch->sessions))
                    @foreach($batch->sessions as $session)
                    @if(count($session->recordings))
                      <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="address_rec_{{ $session->session_no }}">
                          <div class="panel-title bg-theme2">
                            <a class="collapsed" style="color:white !important;" data-toggle="collapse" data-parent="#accordion" href="#collapseaddress_rec_{{ $session->session_no }}" aria-expanded="false" aria-controls="collapseaddress_rec_{{ $session->session_no }}">
                              Session {{ $session->session_no }}
                            </a>
                          </div>
                        </div>
                        <div id="collapseaddress_rec_{{ $session->session_no }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="address_rec_{{ $session->session_no }}" style="">
                          <div class="panel-body">
                              
                            @foreach($session->recordings as $recording)
                            @php($rCount++)
                            <div class="lecture-container">
                              <div class="left-content">
                                <i class="uil uil-play-circle icon_142"></i>
                                <div class="top">
                                <div class="title">{{ $recording->name }}</div>
                                </div>
                              </div>
                              <div class="details">
                                <a href="{{ $recording->type == 'link' ? $recording->link : asset('storage/recordings/'.$recording->file) }}" target="_blank" class=" text-success">View <i class="fas fa-eye text-success"></i></a>
                                @if($recording->type == 'file')
                                <a href="{{ route('download', ['file' => 'recordings/'.$recording->file]) }}" target="_blank" class=" text-danger ml-3">Download <i class="fas fa-download text-danger"></i></a>
                                @endif
                              </div>
                            </div>
                            @endforeach

                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                    @endforeach
                    @endif


                    @if($rCount == 0)
                    <p class="text-center">No Recordings found</p>
                    @endif
                    
                    
                  </div>
              
                                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


@if(count($batch->assignments) > 0)
@foreach($batch->assignments as $assignmentKey => $assignment)

{{ Form::open(array('route' => [Config::get('app.p_slug').'.my_programs.batches.submit_assignment', [$batch->program->id, $batch->id, $assignment->id]], 'method' => 'post', 'files' => true)) }}

<div class="modal fade" id="uploadModal-{{ $assignmentKey }}" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="uploadModalLabel">Submit Assignment</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered ucp-table">
          <tbody>
            <tr>
              <td><b>Assignment:</b><br>{{ $assignment->name }}</td>
              <td><b>Program:</b><br>{{ $batch->program->name }}</td>
              <td><b>Due Date:</b><br>{{ $assignment->due_date->format('M d, Y') }}</td>
            </tr>
            <tr>
              <td colspan="2">
                <b>File:</b><br>
                <input type="file" name="document" />
              </td>
              <td colspan="2">
                @if($assignment->userAssignment)
                @if($assignment->userAssignment->document)
                <a href="{{ asset('storage/users/assignments/'.$assignment->userAssignment->document) }}" target="_blank"><i class="fa fa-2x fa-download text-success"></i></a>
                @endif
                @endif
              </td>
            </tr>
            <tr>
            <td colspan="3"><b>Remarks:</b><br><textarea name="remarks" class="form-control" rows="5" required>{{ $assignment->userAssignment ? $assignment->userAssignment->remarks : '' }}</textarea></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer bg-secondary">
        <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
        <button type="submit" class="btn_adcart">Submit</button>
      </div>
    </div>
  </div>
</div>

{{ Form::close() }}
@endforeach
@endif


@endif

@endsection