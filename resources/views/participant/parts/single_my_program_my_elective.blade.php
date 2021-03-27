<div class="col-lg-3 col-md-4">
  <div class="fcrse_1 mt-30">
    <a href="{{ route(config('app.p_slug').'.my_programs.batches.my_electives.batches.show', [$batch->program->id, $batch->id, $myElectiveBatch->program->id, $myElectiveBatch->id]) }}" class="fcrse_img">
      <img src="{{ asset('storage/programs/'.$myElectiveBatch->program->image) }}" alt="{{ $myElectiveBatch->program->name }}" style="height:200px;" />
      <div class="course-overlay">
        <div class="crse_timer">Enrolled</div>
        @if($myElectiveBatch->program->label)
        <div class="badge_seller">{{ $myElectiveBatch->program->label->name }}</div>
        @endif
      </div>
    </a>
    <div class="fcrse_content">
      <div class="vdtodt">
        <span class="vdt14">On  {{ $myElectiveBatch->start_date->format('d M, Y') }}, @if($myElectiveBatch->start_time && $myElectiveBatch->end_time) {{ $myElectiveBatch->start_time->format('H:i').' to '.$myElectiveBatch->end_time->format('H:i').' IST' }} @endif</span>
      </div>
      <a href="{{ route(config('app.p_slug').'.my_programs.batches.my_electives.batches.show', [$batch->program->id, $batch->id, $myElectiveBatch->program->id, $myElectiveBatch->id]) }}" class="crse14s"
        >{{ $myElectiveBatch->program->name }}
        </a
      >
      <a href="{{ route(config('app.p_slug').'.my_programs.batches.my_electives.batches.show', [$batch->program->id, $batch->id, $myElectiveBatch->program->id, $myElectiveBatch->id]) }}" class="crse-cate">
          {!! Str::limit($myElectiveBatch->program->description, 150) !!}</a>
      <div class="auth1lnkprce">
        <p class="cr1fot">By 
          
          @if($myElectiveBatch->program->faculties)
          @foreach($myElectiveBatch->faculties as $facultyKey => $faculty)
          {{ ($facultyKey > 0 ? ', ' : '') }}<a href="#">{{ $faculty->first_name.' '.$faculty->last_name }}</a>
          @endforeach
          @endif
        
        </p>
        <div class="prce142">
          <a href="{{ route(config('app.p_slug').'.my_programs.batches.my_electives.batches.show', [$batch->program->id, $batch->id, $myElectiveBatch->program->id, $myElectiveBatch->id]) }}">
            <button class="btn btn-info ml-3 rounded-pill">
              <i class="fa fa-eye"></i> </i>View
            </button>
        </a>
        </div>
      </div>
    </div>
  </div>
</div>