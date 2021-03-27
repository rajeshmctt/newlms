@extends('layouts.admin')

@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
<script src="https://cdn.tiny.cloud/1/70tcyjckojbg1tq8fl9xaolxupy5dksuu3u0z2hebshcpu1j/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script src="https://cdn.tiny.cloud/1/70tcyjckojbg1tq8fl9xaolxupy5dksuu3u0z2hebshcpu1j/tinymce/5/jquery.tinymce.min.js" referrerpolicy="origin"></script>
<script>
  $('textarea.tiny').tinymce({
   height: 300
   });
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
  // $('.datepicker').datepicker({'format': 'yyyy-mm-dd'});

  $(function(){
    $(document).ready(function() {
        $('.js-multiple-select').select2();
    });
  });
</script>

<script>
  $(function(){
    $('#image').on('change',function(){
        var fileName = $(this).val();
        $(this).next('.custom-file-label').html(fileName);
    })

    $('#type').on('change',function(){
      if($(this).val() == 'program'){
        $('#payment_mode_star').removeClass('d-none');
      } else {
        $('#payment_mode_star').addClass('d-none');
      }
    })
    $('#payment_mode').on('change',function(){
      if($(this).val() == 'online'){
        $('#currency_id_star').removeClass('d-none');
        $('#amount_star').removeClass('d-none');
      } else {
        $('#currency_id_star').addClass('d-none');
        $('#amount_star').addClass('d-none');
      }
    })

    $('#select_all').click(function(){
      if($(this).is(':checked')){
        $("#resource_ids > option").prop("selected", "selected");// Select All Options
        $("#resource_ids").trigger("change");// Trigger change to select 2
      } else {
        $("#resource_ids > option").prop('selected', false);
        $("#resource_ids").trigger("change");// Trigger change to select 2
      }
    });
  });
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
                <h3 class="card-title">Edit Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {{ Form::open(array('route' => [config('app.a_slug').'.programs.update', $program->id], 'method' => 'put', 'files' => true)) }}
                <div class="card-body">
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                          <label for="name">Program Name <span class="text-danger">*</span></label>
                          <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name', $program->name) }}">
                          @error('name')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="type">Type <span class="text-danger">*</span></label>
                        {{ Form::select('type', ['program' => 'Program', 'elective' => 'Elective'], old('type', $program->type), ['class' => 'form-control', 'id' => 'type', 'placeholder' => 'Select Type']) }}
                        @error('type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-3">
                      <div class="form-group">
                        <label for="type">Label</label>
                        {{ Form::select('label_id', $labels, old('label_id', $program->label_id), ['class' => 'form-control', 'id' => 'label_id', 'placeholder' => 'Select Label']) }}
                        @error('label_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                        <label for="type">Agreement</label>
                        {{ Form::select('agreement_id', $agreements, old('agreement_id', $program->agreement_id), ['class' => 'form-control', 'id' => 'agreement_id', 'placeholder' => 'Select Agreement']) }}
                        @error('agreement_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="type">Certification Level <span class="text-danger">*</span></label>
                        {{ Form::select('certification_level_id', $certificationLevels, old('certification_level_id', $program->certification_level_id), ['class' => 'form-control', 'id' => 'certification_level_id', 'placeholder' => 'Select Certification Level']) }}
                        @error('certification_level_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="type">Inhouse or Open <span class="text-danger">*</span></label>
                        {{ Form::select('type_2', ['Inhouse' => 'Inhouse', 'Open' => 'Open'], old('type_2', $program->type_2), ['class' => 'form-control', 'id' => 'type_2', 'placeholder' => 'Select Option']) }}
                        @error('type_2')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" id="description" placeholder="Description" rows="5" >{{ old('description', $program->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="long_description">Long Description <span class="text-danger">*</span></label>
                        <textarea name="long_description" class="form-control tiny" id="long_description" placeholder="Long Description" rows="5" >{{ old('long_description', $program->long_description) }}</textarea>
                        @error('long_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="who_is_it_for">Who is it for</label>
                        <textarea name="who_is_it_for" class="form-control tiny" id="who_is_it_for" placeholder="Who is it for" rows="5" >{{ old('who_is_it_for', $program->who_is_it_for) }}</textarea>
                        @error('who_is_it_for')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="what_you_will_gain">What you will gain</label>
                        <textarea name="what_you_will_gain" class="form-control tiny" id="what_you_will_gain" placeholder="What you will gain" rows="5" >{{ old('what_you_will_gain', $program->what_you_will_gain) }}</textarea>
                        @error('what_you_will_gain')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="faculty_ids">Faculty <span class="text-danger">*</span></label>
                        {{ Form::select('faculty_ids[]', $faculties, old('faculty_ids', $facultyIds), ['class' => 'form-control js-multiple-select', 'id' => 'faculty_ids', 'multiple' => 'multiple']) }}
                        @error('faculty_ids')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="mentor_coach_ids">Mentor Coaches</label>
                        {{ Form::select('mentor_coach_ids[]', $mentorCoaches, old('mentor_coach_ids', $mentorCoacheIds), ['class' => 'form-control js-multiple-select', 'id' => 'mentor_coach_ids', 'multiple' => 'multiple']) }}
                        @error('mentor_coach_ids')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="resource_ids">Resources <span class="text-danger">*</span></label>
                        {{ Form::select('resource_ids[]', $resources, old('resource_ids', $resourceIds), ['class' => 'form-control js-multiple-select', 'id' => 'resource_ids', 'multiple' => 'multiple']) }}
                        <label><input type="checkbox" name="select_all" id="select_all" value="1" @if($selectAll) checked @endif /> Select All</label>
                        @error('resource_ids')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="image">Change Image</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input name="image" type="file" class="custom-file-input" id="image" accept="image/*">
                            <label class="custom-file-label" for="image">Choose image</label>
                          </div>
                        </div>
                        @error('image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                          <label for="mentor_coach_meetings">Mentor Coach Sessions</label>
                          <input name="mentor_coach_meetings" type="text" class="form-control" id="mentor_coach_meetings" placeholder="Mentor Coach Sessions" value="{{ old('mentor_coach_meetings', $program->mentor_coach_meetings) }}">
                          @error('mentor_coach_meetings')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                          <label for="name">Payment Mode <span class="text-danger {{ old('type', $program->type) != 'program' ? 'd-none' : '' }}" id="payment_mode_star">*</span></label>
                        {{ Form::select('payment_mode', ['offline' => 'Offline', 'online' => 'Online'], old('payment_mode', $program->payment_mode), ['class' => 'form-control', 'id' => 'payment_mode', 'placeholder' => 'Select Payment Mode']) }}
                        @error('payment_mode')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="currency_id">Currency <span class="text-danger {{ old('payment_mode', $program->payment_mode) != 'online' ? 'd-none' : '' }}" id="currency_id_star">*</span></label>
                        {{ Form::select('currency_id', $currencies, old('currency_id', $program->currency_id), ['class' => 'form-control', 'id' => 'currency_id', 'placeholder' => 'Select Currency']) }}
                        @error('currency_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="amount">Amount <span class="text-danger {{ old('payment_mode', $program->payment_mode) != 'online' ? 'd-none' : '' }}" id="amount_star">*</span></label>
                          <input name="amount" type="text" class="form-control" id="amount" placeholder="Amount" value="{{ old('amount', $program->amount) }}">
                          @error('amount')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-4">
                      <div class="form-group">
                          <label for="zero_cost_electives">Zero Cost Electives</label>
                          <input name="zero_cost_electives" type="text" class="form-control" id="zero_cost_electives" placeholder="Zero Cost Electives" value="{{ old('zero_cost_electives', $program->zero_cost_electives) }}">
                          @error('zero_cost_electives')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                    <div class="col-4">
                      <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        {{ Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], old('status', $program->status), ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Select Status']) }}
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
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