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

<script>
  $('#photo').on('change',function(){
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
          <div class="col-md-6">
          
          <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">Edit Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              {{ Form::open(array('route' => [config('app.a_slug').'.faculties.update', $faculty->id], 'method' => 'put', 'files' => true)) }}
                <div class="card-body">
                
                <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                        <input name="first_name" type="text" class="form-control" id="first_name" placeholder="First Name" value="{{ old('first_name', $faculty->first_name) }}">
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input name="last_name" type="text" class="form-control" id="last_name" placeholder="Last Name" value="{{ old('last_name', $faculty->last_name) }}">
                        @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label for="coach_type_ids">Coach Types <span class="text-danger">*</span></label>
                        {{ Form::select('coach_type_ids[]', $coachTypes, old('coach_type_ids', $coachTypeIds), ['class' => 'form-control js-multiple-select', 'id' => 'coach_type_ids', 'multiple']) }}
                        @error('coach_type_ids')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" id="description" placeholder="Description" rows="5" >{{ old('description', $faculty->description) }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="long_description">Long Description <span class="text-danger">*</span></label>
                        <textarea name="long_description" class="form-control tiny" id="long_description" placeholder="Long Description" rows="5" >{{ old('long_description', $faculty->long_description) }}</textarea>
                        @error('long_description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="country_id">Country <span class="text-danger">*</span></label>
                        {{ Form::select('country_id', $countries, old('country_id', $faculty->country_id), ['class' => 'form-control', 'id' => 'country_id', 'placeholder' => 'Select Country', 'onChange'=>'getLocations()']) }}
                        @error('country_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="location_id">Location <span class="text-danger">*</span></label>
                        {{ Form::select('location_id', $locations, old('location_id', $faculty->location_id), ['class' => 'form-control', 'id' => 'location_id', 'placeholder' => 'Select Location']) }}
                        @error('location_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input name="email" type="text" class="form-control" id="email" placeholder="Email" value="{{ old('email', $faculty->email) }}" readonly>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="password">Change Password</label>
                        <input name="password" type="password" class="form-control" id="password" placeholder="Password" value="{{ old('password') }}">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="country_code">Country Code <span class="text-danger">*</span></label>
                        {{ Form::select('country_code', $countryCodes, old('country_code', $faculty->country_code), ['class' => 'form-control', 'id' => 'country_code', 'placeholder' => 'Country Code']) }}
                        @error('country_code')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="phone">Phone <span class="text-danger">*</span></label>
                        <input name="phone" type="text" class="form-control" id="phone" placeholder="Phone" value="{{ old('phone', $faculty->phone) }}">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="photo">Change Photo</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input name="photo" type="file" class="custom-file-input" id="photo" accept="image/*">
                            <label class="custom-file-label" for="photo">Choose photo</label>
                          </div>
                        </div>
                        @error('photo')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        {{ Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], old('status', $faculty->status), ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Select Status']) }}
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