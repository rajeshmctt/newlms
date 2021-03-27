@extends('layouts.admin')

@section('script')
<script type="text/javascript">
  $('.datepicker').datepicker({'format': 'yyyy-mm-dd'});
</script>

<script>
  $('#image').on('change',function(){
      var fileName = $(this).val();
      $(this).next('.custom-file-label').html(fileName);
  })
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
              <form method="post" action="{{ route(config('app.a_slug').'.programs.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                          <label for="name">Program Name <span class="text-danger">*</span></label>
                          <input name="name" type="text" class="form-control" id="name" placeholder="Name" value="{{ old('name') }}">
                          @error('name')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="type">Agreement</label>
                        {{ Form::select('agreement_id', $agreements, old('agreement_id'), ['class' => 'form-control', 'id' => 'agreement_id', 'placeholder' => 'Select Agreement']) }}
                        @error('agreement_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="type">Certification Level <span class="text-danger">*</span></label>
                        {{ Form::select('certification_level_id', $certificationLevels, old('certification_level_id'), ['class' => 'form-control', 'id' => 'certification_level_id', 'placeholder' => 'Select Certification Level']) }}
                        @error('certification_level_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" id="description" placeholder="Description" rows="5" >{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="long_description">Long Description <span class="text-danger">*</span></label>
                        <textarea name="long_description" class="form-control" id="long_description" placeholder="Long Description" rows="5" >{{ old('long_description') }}</textarea>
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
                        <textarea name="who_is_it_for" class="form-control" id="who_is_it_for" placeholder="Who is it for" rows="5" >{{ old('who_is_it_for') }}</textarea>
                        @error('who_is_it_for')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="what_you_will_gain">What you will gain</label>
                        <textarea name="what_you_will_gain" class="form-control" id="what_you_will_gain" placeholder="What you will gain" rows="5" >{{ old('what_you_will_gain') }}</textarea>
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
                        {{ Form::select('faculty_ids[]', $faculties, old('faculty_ids'), ['class' => 'form-control', 'id' => 'faculty_ids', 'placeholder' => 'Select Faculty', 'multiple' => 'multiple']) }}
                        @error('faculty_ids')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="resource_ids">Resource <span class="text-danger">*</span></label>
                        {{ Form::select('resource_ids[]', $resources, old('resource_ids'), ['class' => 'form-control', 'id' => 'resource_ids', 'placeholder' => 'Select Resource', 'multiple' => 'multiple']) }}
                        @error('resource_ids')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="image">Image <span class="text-danger">*</span></label>
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
                          <label for="zero_cost_electives">Zero Cost Electives <span class="text-danger">*</span></label>
                          <input name="zero_cost_electives" type="text" class="form-control" id="zero_cost_electives" placeholder="Zero Cost Electives" value="{{ old('zero_cost_electives') }}">
                          @error('zero_cost_electives')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                    </div>
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