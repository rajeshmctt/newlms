@extends('layouts.admin')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script type="text/javascript">
  $(function(){
    $(document).ready(function() {
        $('.js-multiple-select').select2();
    });
    $('.datepicker-new').datepicker({'format': 'yyyy-mm-dd', 'orientation': 'bottom', 'autoclose': true});
    $('.timepicker').timepicker({
        timeFormat: 'HH:mm',
        interval: 30,
        minTime: '00',
        dynamic: false,
        dropdown: true,
        scrollbar: true,
        change: function(time) {
          let hours = $('input[name="duration_hr"]').val();
          let minutes = $('input[name="duration_min"]').val();
          hours = hours > 0 ? parseInt(hours) : 0;
          minutes = minutes > 0 ? parseInt(minutes) : 0;

          var d = new Date(time);
          d.setHours(d.getHours() + hours);
          d.setMinutes(d.getMinutes() + minutes);

          $('input[name="end_time"]').val( ("0" + d.getHours()).slice(-2) + ':' + ("0" + d.getMinutes()).slice(-2) );
        }
    });


    $('input[name="duration_hr"], input[name="duration_min"]').change(function(){
          let hours = $('input[name="duration_hr"]').val();
          let minutes = $('input[name="duration_min"]').val();
          hours = hours > 0 ? parseInt(hours) : 0;
          minutes = minutes > 0 ? parseInt(minutes) : 0;

          let time = $('input[name="start_time"]').val();
          if(time){
            var d = new Date("2020-01-01 "+time);
            d.setHours(d.getHours() + hours);
            d.setMinutes(d.getMinutes() + minutes);

            $('input[name="end_time"]').val( ("0" + d.getHours()).slice(-2) + ':' + ("0" + d.getMinutes()).slice(-2) );
          }
    });

  });

  function getLocations() {
    var countryId = $("#country_id").val();
    $("#location_id").find('option').not(':first').remove();
    if(countryId){
      $.ajax({
          type:'GET',
          url:"{{ url('/admin/countries') }}/"+countryId+"/locations",
          success:function(response) {
            if(response.status == true){
              $.each(response.data,function(key,value){
                  $("#location_id").append('<option value="'+value.id+'">'+value.name+'</option>');
              });
            }
          }
      });
    }
  }

</script>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-md-10">
          
          <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Create Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{ route(config('app.a_slug').'.batches.store') }}" enctype="multipart/form-data">
                @csrf
                @if($program)
                <input type="hidden" name="program_id" value="{{ $program->id }}" /> 
                @endif
                <div class="card-body">
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                          <label for="name">Batch Name <span class="text-danger">*</span></label>
                          <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name') }}">
                          @error('name')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="program_id">Program <span class="text-danger">*</span></label>
                        {{ Form::select('', $programs, old('program_id', $program ? $program->id : null), ['class' => 'form-control', 'id' => 'program_id', 'placeholder' => 'Select Program', 'disabled']) }}
                        @error('program_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="type">Online or Face to Face <span class="text-danger">*</span></label>
                        {{ Form::select('type_2', ['Online' => 'Online', 'Face to Face' => 'Face to Face', 'Online & Face to Face' => 'Online & Face to Face'], old('type_2'), ['class' => 'form-control', 'id' => 'type_2', 'placeholder' => 'Select Option']) }}
                        @error('type_2')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-2">
                      <div class="form-group">
                        <label for="start_date">Start Date <span class="text-danger">*</span></label>
                        <input name="start_date" type="text" class="form-control datepicker-new" id="start_date" placeholder="yyyy-mm-dd" value="{{ old('start_date') }}" autocomplete="off">
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-2">
                      <div class="form-group">
                        <label for="end_date">End Date <span class="text-danger">*</span></label>
                        <input name="end_date" type="text" class="form-control datepicker-new" id="end_date" placeholder="yyyy-mm-dd" value="{{ old('end_date') }}" autocomplete="off">
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-1">&nbsp;</div>
                    <div class="col-2">
                      <div class="form-group">
                        <label for="duration">Duration <span class="text-danger">*</span></label>
                        <div class="row">
                          <div class="col-6">
                            <div class="input-group">
                              <input name="duration_hr" type="number" class="form-control" id="duration_hr" placeholder="HH" value="{{ old('duration_hr') }}" min="0">
                              <div class="input-group-append">
                                <span class="input-group-text">hr</span>
                              </div>
                            </div>
                            @error('duration_hr')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="col-6">
                            <div class="input-group">
                              <input name="duration_min" type="number" class="form-control" id="duration_min" placeholder="MM" value="{{ old('duration_min') }}" min="0" max="59">
                              <div class="input-group-append">
                                <span class="input-group-text">min</span>
                              </div>
                            </div>
                            @error('duration_min')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                          </div>
                        </div>
                          @error('duration')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                    <div class="col-1">&nbsp;</div>
                    <div class="col-2">
                      <div class="form-group">
                        <label for="start_time">Start Time <span class="text-danger">*</span></label>
                        <input name="start_time" type="text" class="form-control timepicker" id="start_time" placeholder="00:00" value="{{ old('start_time') }}" autocomplete="off">
                        @error('start_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-2">
                      <div class="form-group">
                        <label for="end_time">End Time <span class="text-danger">*</span></label>
                        <input name="end_time" type="text" class="form-control" id="end_time" placeholder="00:00" value="{{ old('end_time') }}" autocomplete="off" readonly>
                        @error('end_time')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-2">
                      <div class="form-group">
                        <label for="reg_start_date">Reg Start Date <span class="text-danger">*</span></label>
                        <input name="reg_start_date" type="text" class="form-control datepicker-new" id="reg_start_date" placeholder="yyyy-mm-dd" value="{{ old('reg_start_date') }}" autocomplete="off">
                        @error('reg_start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-2">
                      <div class="form-group">
                        <label for="reg_end_date">Reg End Date <span class="text-danger">*</span></label>
                        <input name="reg_end_date" type="text" class="form-control datepicker-new" id="reg_end_date" placeholder="yyyy-mm-dd" value="{{ old('reg_end_date') }}" autocomplete="off">
                        @error('reg_end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="faculty_ids">Faculty <span class="text-danger">*</span></label>
                        {{ Form::select('faculty_ids[]', $faculties, old('faculty_ids', $programFacultyIds), ['class' => 'form-control js-multiple-select', 'id' => 'faculty_ids', 'multiple' => 'multiple']) }}
                        @error('faculty_ids')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="mentor_coach_ids">Mentor Coaches <span class="text-danger">*</span></label>
                        {{ Form::select('mentor_coach_ids[]', $mentorCoaches, old('mentor_coach_ids', $programMentorCoachIds), ['class' => 'form-control js-multiple-select', 'id' => 'mentor_coach_ids', 'multiple' => 'multiple']) }}
                        @error('mentor_coach_ids')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3">
                      <div class="form-group">
                        <label for="country_id">Country <span class="text-danger">*</span></label>
                        {{ Form::select('country_id', $countries, old('country_id'), ['class' => 'form-control', 'id' => 'country_id', 'placeholder' => 'Select Country', 'onChange'=>'getLocations()']) }}
                        @error('country_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="location_id">Location <span class="text-danger">*</span></label>
                        {{ Form::select('location_id', $locations, old('location_id'), ['class' => 'form-control', 'id' => 'location_id', 'placeholder' => 'Select Location']) }}
                        @error('location_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                          <label for="mentor_coach_meetings">Mentor Coach Sessions</label>
                          <input name="mentor_coach_meetings" type="text" class="form-control" id="mentor_coach_meetings" placeholder="Mentor Coach Sessions" value="{{ old('mentor_coach_meetings', $program->mentor_coach_meetings) }}">
                          @error('mentor_coach_meetings')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                    @if($program->type == 'program')
                    <div class="col-3">
                      <div class="form-group">
                          <label for="zero_cost_electives">Zero Cost Electives</label>
                          <input name="zero_cost_electives" type="text" class="form-control" id="zero_cost_electives" placeholder="Zero Cost Electives" value="{{ old('zero_cost_electives', $program->zero_cost_electives) }}">
                          @error('zero_cost_electives')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                    @endif
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection