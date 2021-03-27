<div class="col-lg-3 col-md-4">
  <div class="fcrse_1 mt-30">
    <a href="{{ route(config('app.p_slug').'.my_programs.batches.electives.batches.show', [$batch->program->id, $batch->id, $electiveBatch->elective->id, $electiveBatch->id]) }}" class="fcrse_img">
      <img src="{{ asset('storage/electives/'.$electiveBatch->elective->image) }}" alt="{{ $electiveBatch->elective->name }}" style="height:200px;" />
      <div class="course-overlay">
        @if($electiveBatch->elective->label)
        <div class="badge_seller">{{ $electiveBatch->elective->label->name }}</div>
        @endif
      </div>
    </a>
    <div class="fcrse_content">
      <div class="vdtodt">
        <span class="vdt14">On  {{ $electiveBatch->date->format('d M, Y') }}, @if($electiveBatch->start_time && $electiveBatch->end_time) {{ $electiveBatch->start_time->format('H:i').' to '.$electiveBatch->end_time->format('H:i').' IST' }} @endif</span>
      </div>
      <a href="{{ route(config('app.p_slug').'.my_programs.batches.electives.batches.show', [$batch->program->id, $batch->id, $electiveBatch->elective->id, $electiveBatch->id]) }}" class="crse14s"
        >{{ $electiveBatch->elective->name }}
        </a
      >
      <a href="{{ route(config('app.p_slug').'.my_programs.batches.electives.batches.show', [$batch->program->id, $batch->id, $electiveBatch->elective->id, $electiveBatch->id]) }}" class="crse-cate">
          {!! Str::limit($electiveBatch->elective->description, 150) !!}</a>
      <div class="auth1lnkprce">
        <p class="cr1fot">By 
          
          @if($electiveBatch->elective->faculties)
          @foreach($electiveBatch->elective->faculties as $facultyKey => $faculty)
          {{ ($facultyKey > 0 ? ', ' : '') }}<a href="#">{{ $faculty->first_name.' '.$faculty->last_name }}</a>
          @endforeach
          @endif
        
        </p>
        <div class="prce142">
          <a href="{{ route(config('app.p_slug').'.my_programs.batches.electives.batches.show', [$batch->program->id, $batch->id, $electiveBatch->elective->id, $electiveBatch->id]) }}">
            <button class="btn btn-info ml-3 rounded-pill">
              <i class="fa fa-eye"></i> </i>View
            </button>
        </a>
        </div>
      </div>
    </div>
  </div>
</div>