
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

<div class="_215b15 _byt1458">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="course_tabs">
          <nav>
            <div class="nav nav-tabs tab_crse justify-content-center" id="nav-tab" role="tablist">
              <a class="nav-item nav-link {{ $activeTab == 'outline' ? 'active' : '' }}" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab" aria-selected="true">Description</a>
              <a class="nav-item nav-link {{ $activeTab == 'faculty' ? 'active' : '' }}" id="nav-faculty-information-tab" data-toggle="tab" href="#nav-faculty-information" role="tab" aria-selected="false">Faculty</a>
              <a class="nav-item nav-link {{ $activeTab == 'feedback' ? 'active' : '' }}" id="nav-comments-feedback-tab" data-toggle="tab" href="#nav-comments-feedback" role="tab" aria-selected="false">View Feedback</a>
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
            <div class="tab-pane fade {{ $activeTab == 'outline' ? 'show active' : '' }}" id="nav-about" role="tabpanel">
              <div class="_htg452 mt-35">
                <h3>Description</h3>
                <p>{!! $electiveBatch->program->long_description !!}</p>
              </div>						
            </div>
            
            <div class="tab-pane fade {{ $activeTab == 'faculty' ? 'show active' : '' }}" id="nav-faculty-information" role="tabpanel">

              @if($electiveBatch->faculties)
              @foreach($electiveBatch->faculties as $facultyKey => $faculty)
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
                  <p>{!! $faculty->long_description !!}</p>
                </div>					
              </div>	
              @endforeach
              @endif
              
            </div>
            <div class="tab-pane fade {{ $activeTab == 'feedback' ? 'show active' : '' }}" id="nav-comments-feedback" role="tabpanel">
              <div class="_14d25">
                <h3>View Feedback</h3>

                @if(count($electiveBatch->program->programFeedbacks) > 0)
                @foreach($electiveBatch->program->programFeedbacks as $electiveFeedback)

                <div class="review_all120 mt-30">
                  <div class="review_item">
                    <div class="review_usr_dt">
                      <img src="{{ asset('storage/users/'.$electiveFeedback->user->photo) }}" alt="">
                      <div class="rv1458">
                        <h4 class="tutor_name1">{{ $electiveFeedback->user->first_name.' '.$electiveFeedback->user->last_name }}</h4>
                        <span class="time_145">{{ $electiveFeedback->created_at->diffForHumans() }}</span>
                      </div>
                    </div>
                    <p class="rvds10">{{ $electiveFeedback->feedback }}</p>
                      @if($electiveFeedback->emoticon)
                      <img src="{{ asset('img/feedback-icons/'.$electiveFeedback->emoticon.'.png') }}" title="{{ $electiveFeedback->emoticon }}" style="height:25px;" />
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
