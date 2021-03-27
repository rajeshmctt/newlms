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

@section('script')
<script>
function completionConfirm(e)
{
    if(!confirm('Are you sure do you want to Complete?')) {
        e.preventDefault();
    }
}
$(document).ready(function() {

  // $(".datepicker-new").datepicker($.datepicker.setLocale('en'));
  $('.datepicker-new').datepicker({ dateFormat: "yy-mm-dd" });

  $('button[type=submit]').click(function() {
      $(this).attr('disabled', 'disabled');
      $(this).parents('form').submit();
  });
});
</script>

<script>
  $('#file').on('change',function(){
      var fileName = $(this).val();
      $(this).next('.custom-file-label').html(fileName);
  })
  $('#file2').on('change',function(){
      var fileName = $(this).val();
      $(this).next('.custom-file-label').html(fileName);
  })

    
  $(function(){
    $('.rec_type').change(function(){
      var $this = $(this);
      var $form = $this.parents('form');
      $form.find('.file_div, .link_div').removeClass('d-none').addClass('d-none');
      if($this.find(":selected").val() == 'file') $form.find('.file_div').removeClass('d-none');
      if($this.find(":selected").val() == 'link') $form.find('.link_div').removeClass('d-none');
    });
  });
    
</script>
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
              <div class="_215b05 d-none">
                <div class="crse_reviews mr-2">
                  <i class="uil uil-star"></i>4.5
                </div>
                (81,665 ratings)
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
                @if($batch->status == 'completed')
                  <li><button class="btn_buy">Completed</button></li>
                @else
                  <li>
                    {{ Form::open(array('route' => [Config::get('app.f_slug').'.faculty-batches.update', [$batch->id]], 'method' => 'put')) }}
                    <button class="btn_adcart" type="submit" onclick="completionConfirm(event)">Mark It as Completed</button>
                    {{ Form::close() }}
                  </li>
                @endif
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

        <div class="course_tabs">
          <nav>
            <div class="nav nav-tabs tab_crse justify-content-center" id="nav-tab" role="tablist">
              <a class="nav-item nav-link {{ $activeTab == 'sessions' ? 'active' : '' }}" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-selected="true">Session Information</a>
              <a class="nav-item nav-link {{ $activeTab == 'assignments' ? 'active' : '' }}" id="nav-assignments-tab" data-toggle="tab" href="#nav-assignments" role="tab" aria-selected="false">Assignments</a>
              <a class="nav-item nav-link {{ $activeTab == 'resources' ? 'active' : '' }}" id="nav-courses-tab" data-toggle="tab" href="#nav-courses" role="tab" aria-selected="false">Resources</a>
              <a class="nav-item nav-link {{ $activeTab == 'recordings' ? 'active' : '' }}" id="nav-recordings-tab" data-toggle="tab" href="#nav-recordings" role="tab" aria-selected="false">Recordings</a>
              <a class="nav-item nav-link {{ $activeTab == 'participants' ? 'active' : '' }}" id="nav-batchmates-tab" data-toggle="tab" href="#nav-batchmates" role="tab" aria-selected="false">Participants</a>
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
            <div class="tab-pane fade {{ $activeTab == 'sessions' ? 'show active' : '' }}" id="nav-about" role="tabpanel">					
              <div class="_htg451">
                <div class="_htg452 mt-35">
                  <h3>Session Information</h3>
                  
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
                <h3>Resources</h3>
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
                    
                    @if($rCount == 0)
                    <p class="text-center">No Resources found</p>
                    @endif
                    

                  </div>
              
                                
                </div>
              </div>
            </div>
            <div class="tab-pane fade {{ $activeTab == 'participants' ? 'show active' : '' }}" id="nav-batchmates" role="tabpanel">
              <div class="_14d25">
                <div class="row">

                  @if($batch->users)
                  @foreach($batch->users as $batchUser)
                  <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="fcrse_1 mt-30">
                      <div class="tutor_img">
                      <a href="{{ route(config('app.f_slug').'.faculty-participants.show', $batchUser->id) }}"><img src="{{ asset('storage/users/'.$batchUser->photo) }}" alt=""></a>												
                      </div>
                      <div class="tutor_content_dt">
                        <div class="tutor150">
                        <a href="{{ route(config('app.f_slug').'.faculty-participants.show', $batchUser->id) }}" class="tutor_name">{{ $batchUser->first_name.' '.$batchUser->last_name }}</a>
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
            <div class="tab-pane fade {{ $activeTab == 'assignments' ? 'show active' : '' }}" id="nav-assignments" role="tabpanel">
              <div class="_14d25">
                <h3>Assignments
                  <button class="btn btn-primary bg-theme border-0 float-right" data-toggle="modal" data-target="#newModal">Create New</button>
                </h3>

                <table class="table table-bordered ucp-table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Type</th>
                      <th>Assignment</th>
                      <th>Program</th>
                      <th>Due Date</th>
                      <th>File(s)</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  @if(count($batch->assignments) > 0)
                  @foreach($batch->assignments as $assignmentKey => $assignment)
                    <tr>
                      <td>{{ $assignmentKey+1 }}</td>
                      <td>{{ ucwords($assignment->type) }}</td>
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
                      <td>
                        
                        {{ Form::open(array('route' => [Config::get('app.f_slug').'.faculty-batches.delete_assignment', [$batch->id, $assignment->id]], 'method' => 'delete')) }}
                        &nbsp;
                        <a href="#" data-toggle="modal" data-target="#editAssignmentModal-{{ $assignment->id }}" class=" text-success"><i class="fas fa-edit text-success"></i> Edit</a>
                        &nbsp;
                        <button type="submit" onclick="return confirm('Are you sure do you want to delete Assignment?');" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>
                        {{ Form::close() }}
                        
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
            <div class="tab-pane fade {{ $activeTab == 'recordings' ? 'show active' : '' }}" id="nav-recordings" role="tabpanel">
                <h3>Recordings
                  <button class="btn btn-primary bg-theme border-0 float-right" data-toggle="modal" data-target="#newRecordingModal">Create New</button>
                </h3>
              <div class="crse_content">
                <div class="ui-accordion ui-widget ui-helper-reset">
                  <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom">
                    
                    
                  @php($rCount = 0)

                  @if(count($batch->sessions))
                    @foreach($batch->sessions as $session)
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
                          

                        <table class="table table-bordered ucp-table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Type</th>
                              <th>Name</th>
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                        @if(count($session->recordings))
                        @foreach($session->recordings as $recordingKey => $recording)
                        @php($rCount++)
                            <tr>
                              <td>{{ $recordingKey+1 }}</td>
                              <td>{{ ucwords($recording->type) }}</td>
                              <td>{{ $recording->name }}</td>
                              <td>

                                {{ Form::open(array('route' => [Config::get('app.f_slug').'.faculty-batches.delete_recording', [$batch->id, $session->id, $recording->id]], 'method' => 'delete')) }}
                                <a href="{{ $recording->type == 'link' ? $recording->link : asset('storage/recordings/'.$recording->file) }}" target="_blank" class=" text-success"><i class="fas fa-eye text-success"></i> View</a>
                                &nbsp;
                                <a href="#" data-toggle="modal" data-target="#editRecordingModal-{{ $recording->id }}" class=" text-success"><i class="fas fa-edit text-success"></i> Edit</a>
                                &nbsp;
                                <button type="submit" onclick="return confirm('Are you sure do you want to delete Recording?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Delete</a>

                                {{ Form::close() }}
                                
                              </td>
                            </tr>
                          @endforeach
                          @else
                            <tr>
                              <td colspan="4" class="text-center">No recordings found</td>
                            </tr>
                          @endif
                          </tbody>
                        </table>

                      </div>
                    </div>
                  </div>
                </div>
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



{{ Form::open(array('route' => [Config::get('app.f_slug').'.faculty-batches.create_assignment', [$batch->id]], 'method' => 'post', 'files' => true)) }}


<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="newModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="newModalLabel">New Assignment</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <div class="row p-3">
          <div class="col-lg-12">
              <div class="ui search focus mt-20">
                  <label>Assignment Name <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">
                      <input name="name" type="text" class="prompt srch_explore" id="name" placeholder="Assignment Name *" value="{{ old('name') }}" required>														
                  </div>
              </div>						
              @error('name')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>        
      
        <div class="row p-3">
          <div class="col-lg-6">
              <div class="ui search focus mt-20">
                  <label>Type <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">		
                      {{ Form::select('type', ['assignment' => 'Assignment', 'blog' => 'Blog', 'peer-coaching' => 'Peer Coaching'], old('type'), ['class' => 'ui hj145 dropdown cntry152 prompt srch_explore', 'id' => 'type', 'placeholder' => 'Select Type *', 'required']) }}								
                  </div>
              </div>						
              @error('type')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
          <div class="col-lg-6">
              <div class="ui search focus mt-20">
                  <label>Due Date <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">
                      <input name="due_date" type="text" class="prompt srch_explore datepicker-new" id="due_date" placeholder="Due Date *" value="{{ old('due_date') }}" required>														
                  </div>
              </div>						
              @error('due_date')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>
        <div class="row p-3">
          <div class="col-lg-6">
              <div class="ui search focus mt-20">
                  <label>Upload</label>
                  <div class="ui left icon input swdh11 swdh19">
              <div class="input-group">
                <div class="custom-file">
                  <input name="file" type="file" class="custom-file-input1" id="file">
                </div>
              </div>						
                  </div>
              </div>						
              @error('file')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>
        
      </div>
      <div class="modal-footer bg-secondary">
        <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
        <button type="submit" class="btn_adcart">Create</button>
      </div>
    </div>
  </div>
</div>


{{ Form::close() }}

@if(count($batch->assignments) > 0)
@foreach($batch->assignments as $assignmentKey => $assignment)

{{ Form::open(array('route' => [Config::get('app.f_slug').'.faculty-batches.update_assignment', [$batch->id, $assignment->id]], 'method' => 'put', 'files' => true)) }}


<div class="modal fade" id="editAssignmentModal-{{ $assignment->id }}" tabindex="-1" role="dialog" aria-labelledby="editAssignmentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="editAssignmentModalLabel">Edit Assignment</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <div class="row p-3">
          <div class="col-lg-12">
              <div class="ui search focus mt-20">
                  <label>Assignment Name <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">
                      <input name="name" type="text" class="prompt srch_explore" id="name" placeholder="Assignment Name *" value="{{ old('name', $assignment->name) }}" required>														
                  </div>
              </div>						
              @error('name')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>        
      
        <div class="row p-3">
          <div class="col-lg-6">
              <div class="ui search focus mt-20">
                  <label>Type <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">		
                      {{ Form::select('type', ['assignment' => 'Assignment', 'blog' => 'Blog', 'peer-coaching' => 'Peer Coaching'], old('type', $assignment->type), ['class' => 'ui hj145 dropdown cntry152 prompt srch_explore', 'id' => 'type', 'placeholder' => 'Select Type *', 'required']) }}								
                  </div>
              </div>						
              @error('type')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
          <div class="col-lg-6">
              <div class="ui search focus mt-20">
                  <label>Due Date <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">
                      <input name="due_date" type="text" class="prompt srch_explore datepicker-new" id="due_date" placeholder="Due Date *" value="{{ old('due_date', $assignment->due_date->format('Y-m-d')) }}" required>														
                  </div>
              </div>						
              @error('due_date')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>
        <div class="row p-3">
          <div class="col-lg-6">
              <div class="ui search focus mt-20">
                  <label>Upload</label>
                  <div class="ui left icon input swdh11 swdh19">
              <div class="input-group">
                <div class="custom-file">
                  <input name="file" type="file" class="custom-file-input1" id="file">
                </div>
              </div>						
                  </div>
              </div>						
              @error('file')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>
        
      </div>
      <div class="modal-footer bg-secondary">
        <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
        <button type="submit" class="btn_adcart">Update</button>
      </div>
    </div>
  </div>
</div>


{{ Form::close() }}

@endforeach
@endif


{{ Form::open(array('route' => [Config::get('app.f_slug').'.faculty-batches.create_recording', [$batch->id]], 'method' => 'post', 'files' => true)) }}


<div class="modal fade" id="newRecordingModal" tabindex="-1" role="dialog" aria-labelledby="newRecordingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="newRecordingModalLabel">New Recording</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <div class="row p-3">
          <div class="col-lg-12">
              <div class="ui search focus mt-20">
                  <label>Recording Name <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">
                      <input name="name" type="text" class="prompt srch_explore" id="name" placeholder="Recording Name *" value="{{ old('name') }}" required>														
                  </div>
              </div>						
              @error('name')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>        
      
        <div class="row p-3">
          <div class="col-lg-6">
              <div class="ui search focus mt-20">
                  <label>Session <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">		
                      {{ Form::select('session_id', $batchSessions, old('session_id'), ['class' => 'ui hj145 dropdown cntry152 prompt srch_explore', 'id' => 'session_id', 'placeholder' => 'Select Session *', 'required']) }}								
                  </div>
              </div>						
              @error('session_id')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
          <div class="col-lg-6">
              <div class="ui search focus mt-20">
                  <label>Type <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">		
                      {{ Form::select('type', ['file' => 'File', 'link' => 'Link'], old('type'), ['class' => 'ui hj145 dropdown cntry152 prompt srch_explore rec_type', 'id' => 'rec_type', 'placeholder' => 'Select Type *', 'required']) }}								
                  </div>
              </div>						
              @error('type')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>
        
        <div class="row p-3">
          <div class="col-lg-6 file_div @if(old('type') != 'file') d-none @endif">
              <div class="ui search focus mt-20">
                  <label>File <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">
              <div class="input-group">
                <div class="custom-file">
                  <input name="file" type="file" class="custom-file-input1" id="file2" >
                </div>
              </div>						
                  </div>
              </div>						
              @error('file')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
          <div class="col-lg-12 link_div @if(old('type') != 'link') d-none @endif">
              <div class="ui search focus mt-20">
                  <label>Link <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">
                      <input name="link" type="text" class="prompt srch_explore" id="link" placeholder="Link *" value="{{ old('link') }}">														
                  </div>
              </div>						
              @error('link')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>
        
      </div>
      <div class="modal-footer bg-secondary">
        <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
        <button type="submit" class="btn_adcart">Create</button>
      </div>
    </div>
  </div>
</div>


{{ Form::close() }}


@if(count($batch->sessions))
@foreach($batch->sessions as $session)

@if(count($session->recordings))
@foreach($session->recordings as $recordingKey => $recording)

{{ Form::open(array('route' => [Config::get('app.f_slug').'.faculty-batches.update_recording', [$batch->id, $session->id, $recording->id]], 'method' => 'put', 'files' => true)) }}

<div class="modal fade" id="editRecordingModal-{{ $recording->id }}" tabindex="-1" role="dialog" aria-labelledby="editRecordingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h3 class="modal-title" id="editRecordingModalLabel">Edit Recording</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <div class="row p-3">
          <div class="col-lg-12">
              <div class="ui search focus mt-20">
                  <label>Recording Name <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">
                      <input name="name" type="text" class="prompt srch_explore" id="name" placeholder="Recording Name *" value="{{ old('name', $recording->name) }}" required>														
                  </div>
              </div>						
              @error('name')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>        
      
        <div class="row p-3">
          <div class="col-lg-6">
              <div class="ui search focus mt-20">
                  <label>Session <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">		
                      {{ Form::select('session_id', $batchSessions, old('session_id', $recording->pivot->session_id), ['class' => 'ui hj145 dropdown cntry152 prompt srch_explore', 'id' => 'session_id', 'placeholder' => 'Select Session *', 'required']) }}								
                  </div>
              </div>						
              @error('session_id')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
          <div class="col-lg-6">
              <div class="ui search focus mt-20">
                  <label>Type <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">		
                      {{ Form::select('type', ['file' => 'File', 'link' => 'Link'], old('type', $recording->type), ['class' => 'ui hj145 dropdown cntry152 prompt srch_explore rec_type', 'id' => 'rec_type', 'placeholder' => 'Select Type *', 'required']) }}								
                  </div>
              </div>						
              @error('type')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>
        
        <div class="row p-3">
          <div class="col-lg-6 file_div @if($recording->type != 'file') d-none @endif">
              <div class="ui search focus mt-20">
                  <label>File <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">
              <div class="input-group">
                <div class="custom-file">
                  <input name="file" type="file" class="custom-file-input1" id="file2" required>
                </div>
              </div>						
                  </div>
              </div>						
              @error('file')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
          <div class="col-lg-12 link_div @if($recording->type != 'link') d-none @endif">
              <div class="ui search focus mt-20">
                  <label>Link <span class="text-danger">*</span></label>
                  <div class="ui left icon input swdh11 swdh19">
                      <input name="link" type="text" class="prompt srch_explore" id="link" placeholder="Link *" value="{{ old('link', $recording->link) }}" required>														
                  </div>
              </div>						
              @error('link')
                  <span class="text-danger">{{ $message }}</span>
              @enderror
          </div>
        </div>
        
      </div>
      <div class="modal-footer bg-secondary">
        <button type="button" class="btn_buy" data-dismiss="modal">Close</button>
        <button type="submit" class="btn_adcart">Update</button>
      </div>
    </div>
  </div>
</div>

{{ Form::close() }}

@endforeach
@endif

@endforeach
@endif


@endsection