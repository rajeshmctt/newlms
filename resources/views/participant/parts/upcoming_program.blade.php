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
</style>

@if(Request::get('view') == 'list')
        <div class="col-lg-6 col-md-6 mb-3">
        <div class="fcrse_1 mb-3">
            <div class="m-1">
                <h3 style="margin-bottom:0;">{{ $upcomingProgramBatch->program->name }}</h3>
                
                <div class="text-muted mt-2">
                    
                    <b>Starting: {{ $upcomingProgramBatch->start_date->format('d M, Y') }}</b>
                    &nbsp;
                    &nbsp;
                    By 
                    @if($upcomingProgramBatch->faculties)
                    @foreach($upcomingProgramBatch->faculties as $facultyKey => $faculty)
                    {{ ($facultyKey > 0 ? ', ' : '') }}{{ $faculty->first_name.' '.$faculty->last_name }}
                    @endforeach
                    @endif
                
                </div>

            </div>
            <div class="view_elective_wrap">
            <a href="{{ route(config('app.p_slug').'.programs.batches.show', [$upcomingProgramBatch->program->id, $upcomingProgramBatch->id]) }}"><button class="btn btn-info ml-3 rounded-pill"><i class="fa fa-eye"></i> View</button></a></div>
        </div>
        </div>
@else

<style type="text/css">
.crse-cate{
  height: 100px;
}
</style>
        <div class="col-lg-3 col-md-3 mb-3">
            <div class="fcrse_1">
            <a href="{{ route(config('app.p_slug').'.programs.batches.show', [$upcomingProgramBatch->program->id, $upcomingProgramBatch->id]) }}" class="fcrse_img">
                <img src="{{ asset('storage/programs/'.$upcomingProgramBatch->program->image) }}" alt="{{ $upcomingProgramBatch->program->name }}" style="height:200px;" />
                <div class="course-overlay">
                    @if($upcomingProgramBatch->program->label)
                    <div class="badge_seller">{{ $upcomingProgramBatch->program->label->name }}</div>
                    @endif
                </div>
            </a>
            <div class="fcrse_content">
                <div class="vdtodt">
                <span class="vdt14">Starting: {{ $upcomingProgramBatch->start_date->format('d M, Y') }}</span>

                    <div class="float-right">
                        @if($upcomingProgramBatch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'like')->count() > 0)
                        <a class="feedback-icon-top" title="Like" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/like.png') }}" /><span class="badge badge-warning count">{{ $upcomingProgramBatch->program->programFeedbacks->where('emoticon', 'like')->count() }}</span></a>
                        @endif
                        @if($upcomingProgramBatch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'insightful')->count() > 0)
                        <a class="feedback-icon-top" title="Enlightened" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/insightful.png') }}" /><span class="badge badge-warning count">{{ $upcomingProgramBatch->program->programFeedbacks->where('emoticon', 'insightful')->count() }}</span></a>
                        @endif
                        @if($upcomingProgramBatch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'curious')->count() > 0)
                        <a class="feedback-icon-top" title="Curious" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/curious.png') }}" /><span class="badge badge-warning count">{{ $upcomingProgramBatch->program->programFeedbacks->where('emoticon', 'curious')->count() }}</span></a>
                        @endif
                        @if($upcomingProgramBatch->program->programFeedbacks->where('status', 'active')->where('emoticon', 'favourite')->count() > 0)
                        <a class="feedback-icon-top" title="Love" data-toggle="tooltip" data-placement="bottom"><img src="{{ asset('img/feedback-icons/favourite.png') }}" /><span class="badge badge-warning count">{{ $upcomingProgramBatch->program->programFeedbacks->where('emoticon', 'favourite')->count() }}</span></a>
                        @endif
                    </div>

                </div>
                <a href="{{ route(config('app.p_slug').'.programs.batches.show', [$upcomingProgramBatch->program->id, $upcomingProgramBatch->id]) }}" class="crse14s"
                >{{ $upcomingProgramBatch->program->name }}
                </a>
                <a href="{{ route(config('app.p_slug').'.programs.batches.show', [$upcomingProgramBatch->program->id, $upcomingProgramBatch->id]) }}" class="crse-cate">
                {!! Str::limit($upcomingProgramBatch->program->description, 150) !!}</a>
                <div class="auth1lnkprce">
                <p class="cr1fot">By 
                    
                    @if($upcomingProgramBatch->faculties)
                    @foreach($upcomingProgramBatch->faculties as $facultyKey => $faculty)
                    {{ ($facultyKey > 0 ? ', ' : '') }}<a href="#">{{ $faculty->first_name.' '.$faculty->last_name }}</a>
                    @endforeach
                    @endif
                
                </p><br>
                <div class="prce142">
                    <a href="{{ route(config('app.p_slug').'.programs.batches.show', [$upcomingProgramBatch->program->id, $upcomingProgramBatch->id]) }}">
                    <button class="btn btn-info ml-3 rounded-pill">
                    <i class="fa fa-eye"></i> </i>View
                    </button>
                    </a>
                </div>
                </div>
            </div>
            </div>
        </div>
@endif