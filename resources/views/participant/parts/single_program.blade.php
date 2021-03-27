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
        <div class="fcrse_1 mb-3 mt-5">
            <a href="{{ route(config('app.p_slug').'.programs.batches.show', [$batch->program->id, $batch->id]) }}" class="hf_img">
                <img src="{{ asset('storage/programs/'.$batch->program->image) }}" alt="" style="height:200px;">
                <div class="course-overlay">
                    @if($batch->program->label)
                    <div class="badge_seller">{{ $batch->program->label->name }}</div>
                    @endif
                    
                </div>
            </a>
            <div class="hs_content">
                <a href="{{ route(config('app.p_slug').'.programs.batches.show', [$batch->program->id, $batch->id]) }}" class="crse14s title900">{{ $batch->program->name }}</a>
                <a class="crse-cate crse-cate_list">{!! Str::limit($batch->program->description, 150) !!}</a>

                <div class="cr1fot"><b>Starts on {{ $batch->start_date->format('d M, Y') }}</b></div>

                <div class="auth1lnkprce">
                    <p class="cr1fot">By 
                    
                    @if($batch->faculties)
                    @foreach($batch->faculties as $facultyKey => $faculty)
                    {{ ($facultyKey > 0 ? ', ' : '') }}<a href="#">{{ $faculty->first_name.' '.$faculty->last_name }}</a>
                    @endforeach
                    @endif
                
                    </p>
                    
                </div>
            </div>
            <div class="view_elective_wrap">
            <a href="{{ route(config('app.p_slug').'.programs.batches.show', [$batch->program->id, $batch->id]) }}"><button class="btn btn-info ml-3 rounded-pill">View Details</button></a></div>
        </div>
@else
  <div class="col-lg-3 col-md-4">
    <div class="fcrse_1 mt-30">
      <a href="{{ route(config('app.p_slug').'.'.($batch->batchUser ? ($batch->batchUser->parent_batch_id ? 'my_electives' : 'my_programs') : 'programs').'.batches.show', [$batch->program->id, $batch->id]) }}" class="fcrse_img">
        <img src="{{ asset('storage/programs/'.$batch->program->image) }}" alt="{{ $batch->program->name }}" style="height:200px;" />
        <div class="course-overlay">
          @if($batch->batchUser)
          <div class="crse_timer">Enrolled</div>
          @endif
          @if($batch->program->label)
          <div class="badge_seller">{{ $batch->program->label->name }}</div>
          @endif
        </div>
      </a>
      <div class="fcrse_content">
        <div class="vdtodt">
        <span class="vdt14">Starting: {{ $batch->start_date->format('d M, Y') }}</span>

          <div class="float-right">
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
          </div>

        </div>
        <a href="{{ route(config('app.p_slug').'.'.($batch->batchUser ? ($batch->batchUser->parent_batch_id ? 'my_electives' : 'my_programs') : 'programs').'.batches.show', [$batch->program->id, $batch->id]) }}" class="crse14s"
          >{{ $batch->program->name }}
        </a>
        <a href="{{ route(config('app.p_slug').'.'.($batch->batchUser ? ($batch->batchUser->parent_batch_id ? 'my_electives' : 'my_programs') : 'programs').'.batches.show', [$batch->program->id, $batch->id]) }}" class="crse-cate">
          {!! Str::limit($batch->program->description, 150) !!}</a>
        <div class="auth1lnkprce">
          <p class="cr1fot">By 
            
            @if($batch->faculties)
            @foreach($batch->faculties as $facultyKey => $faculty)
            {{ ($facultyKey > 0 ? ', ' : '') }}<a href="#">{{ $faculty->first_name.' '.$faculty->last_name }}</a>
            @endforeach
            @endif
          
          </p>
          <div class="prce142">
            <a href="{{ route(config('app.p_slug').'.'.($batch->batchUser ? ($batch->batchUser->parent_batch_id ? 'my_electives' : 'my_programs') : 'programs').'.batches.show', [$batch->program->id, $batch->id]) }}">
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