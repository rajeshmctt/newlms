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

<div class="col-lg-3 col-md-4">
  <div class="fcrse_1 mt-30">
    <a href="{{ route(config('app.p_slug').'.'.($electiveBatch->batchUser ? 'my_electives' : 'electives').'.batches.show', [$electiveBatch->program->id, $electiveBatch->id]) }}" class="fcrse_img">
      <img src="{{ asset('storage/programs/'.$electiveBatch->program->image) }}" alt="{{ $electiveBatch->program->name }}" style="height:200px;" />
      <div class="course-overlay">
        @if($electiveBatch->batchUser)
        <div class="crse_timer">Enrolled</div>
        @endif
        @if($electiveBatch->program->label)
        <div class="badge_seller">{{ $electiveBatch->program->label->name }}</div>
        @endif
      </div>
    </a>
    <div class="fcrse_content">
      <div class="vdtodt">
        <span class="vdt14">On {{ $electiveBatch->start_date->format('d M, Y') }}, @if($electiveBatch->start_time && $electiveBatch->end_time) {{ $electiveBatch->start_time->format('H:i').' to '.$electiveBatch->end_time->format('H:i').' IST' }} @endif</span>

        <div class="float-right">
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
        </div>

      </div>
      <a href="{{ route(config('app.p_slug').'.'.($electiveBatch->batchUser ? 'my_electives' : 'electives').'.batches.show', [$electiveBatch->program->id, $electiveBatch->id]) }}" class="crse14s"
        >{{ $electiveBatch->program->name }}
        </a
      >
      <a href="{{ route(config('app.p_slug').'.'.($electiveBatch->batchUser ? 'my_electives' : 'electives').'.batches.show', [$electiveBatch->program->id, $electiveBatch->id]) }}" class="crse-cate">
          {!! Str::limit($electiveBatch->program->description, 150) !!}</a>
      <div class="auth1lnkprce">
        <p class="cr1fot">By 
          
          @if($electiveBatch->faculties)
          @foreach($electiveBatch->faculties as $facultyKey => $faculty)
          {{ ($facultyKey > 0 ? ', ' : '') }}<a href="#">{{ $faculty->first_name.' '.$faculty->last_name }}</a>
          @endforeach
          @endif
        
        </p>
        <div class="prce142">
          <a href="{{ route(config('app.p_slug').'.'.($electiveBatch->batchUser ? 'my_electives' : 'electives').'.batches.show', [$electiveBatch->program->id, $electiveBatch->id]) }}">
            <button class="btn btn-info ml-3 rounded-pill">
              <i class="fa fa-eye"></i> </i>View
            </button>
        </a>
        </div>
      </div>
    </div>
  </div>
</div>