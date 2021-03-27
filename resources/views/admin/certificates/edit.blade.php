@extends('layouts.admin')

@section('script')
<script type="text/javascript">
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
              {{ Form::open(array('route' => [config('app.a_slug').'.participants.update', $pUser->id], 'method' => 'put', 'files' => true)) }}
                <div class="card-body">
                
                <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="first_name">First Name <span class="text-danger">*</span></label>
                        <input name="first_name" type="text" class="form-control" id="first_name" placeholder="First Name" value="{{ old('first_name', $pUser->first_name) }}">
                        @error('first_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="last_name">Last Name <span class="text-danger">*</span></label>
                        <input name="last_name" type="text" class="form-control" id="last_name" placeholder="Last Name" value="{{ old('last_name', $pUser->last_name) }}">
                        @error('last_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="country_id">Country <span class="text-danger">*</span></label>
                        {{ Form::select('country_id', $countries, old('country_id', $pUser->country_id), ['class' => 'form-control', 'id' => 'country_id', 'placeholder' => 'Select Country', 'onChange'=>'getLocations()']) }}
                        @error('country_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label for="location_id">Location <span class="text-danger">*</span></label>
                        {{ Form::select('location_id', $locations, old('location_id', $pUser->location_id), ['class' => 'form-control', 'id' => 'location_id', 'placeholder' => 'Select Location']) }}
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
                        <input name="email" type="text" class="form-control" id="email" placeholder="Email" value="{{ old('email', $pUser->email) }}" readonly>
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
                        <label for="phone">Phone <span class="text-danger">*</span></label>
                        <input name="phone" type="text" class="form-control" id="phone" placeholder="Phone" value="{{ old('phone', $pUser->phone) }}">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                    </div>
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
                  </div>

                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        {{ Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], old('status', $pUser->status), ['class' => 'form-control', 'id' => 'status', 'placeholder' => 'Select Status']) }}
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