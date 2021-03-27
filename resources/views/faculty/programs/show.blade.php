@extends('layouts.faculty')

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
                <li><a href="#"><button class="btn_buy"><i class="fa fa-rupee-sign"></i> {{ $batch->program->amount > 0 ? $batch->program->amount : 0 }}</button></a></li>
              </ul>
            </div>							
          </div>							
        </div>							
      </div>															
    </div>
  </div>
</div>
<div class="_215b15 _byt1458">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="course_tabs">
          <nav>
            <div class="nav nav-tabs tab_crse justify-content-center" id="nav-tab" role="tablist">
              <a class="nav-item nav-link active" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-selected="true">Course Outline</a>
              <a class="nav-item nav-link" id="nav-faculty-information-tab" data-toggle="tab" href="#nav-faculty-information" role="tab" aria-selected="false">Faculty</a>
                <a class="nav-item nav-link" id="nav-comments-feedback-tab" data-toggle="tab" href="#nav-comments-feedback" role="tab" aria-selected="false">View Feedback</a>
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
            <div class="tab-pane fade show active" id="nav-about" role="tabpanel">

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
            
            <div class="tab-pane fade" id="nav-faculty-information" role="tabpanel">

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
                  <p>{!! $faculty->description !!}</p>
                </div>					
              </div>	
              @endforeach
              @endif
              
            </div>
              <div class="tab-pane fade" id="nav-comments-feedback" role="tabpanel">
                <div class="_14d25">
                  <h3>View Feedback</h3>

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
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


{{ Form::open(array('route' => [Config::get('app.p_slug').'.payment'], 'method' => 'post')) }}

<input type="hidden" name="program_id" value="{{ $batch->program->id }}">
<input type="hidden" name="program_batch_id" value="{{ $batch->id }}">

<div class="modal fade" id="optModal" tabindex="-1" role="dialog" aria-labelledby="optModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="optModalLabel">{{ $batch->program->name }}</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="mt-5 mb-5 text-center">Are you sure you want to Enrol this Program?<br><br>The Payment amount is INR {{ $batch->program->amount }}.</h3>
      </div>
      <div class="modal-footer bg-secondary">
        <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
        <button type="submit" class="btn_adcart">Pay now</button>
      </div>
    </div>
  </div>
</div>

{!! Form::close() !!}

@endsection