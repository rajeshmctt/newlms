@extends('layouts.faculty')

@section('script')
<script type="text/javascript">

  function getLocations() {
    var countryId = $("#country_id").val();
    $("#location_id").find('option').not(':first').remove();
    if(countryId){
      $.ajax({
          type:'GET',
          url:"{{ url('/faculty/countries') }}/"+countryId+"/locations",
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

<div class="row justify-content-center">
  <div class="col-md-12">
              
  @if(session()->get('success'))
        <div class="alert alert-success">
        {{ session()->get('success') }}  
        </div>
    @endif

    @if(session()->get('error'))
        <div class="alert alert-danger">
        {{ session()->get('error') }}  
        </div>
    @endif
  </div>
</div>
<!-- /.row -->


<div class="row">
  <div class="col-lg-12">
      <h2 class="st_title"><i class='uil uil-cog'></i> Settings</h2>
      
      @include(Config::get('app.f_slug').'.account_menu')
      
      {{ Form::open(array('route' => [Config::get('app.f_slug').'.account.update.profile'], 'method' => 'put')) }}

      <div class="basic_ptitle">
          <h3>Basic Info</h3>
      </div>
      <div class="basic_form">
          <div class="row">
              <div class="col-lg-8">
                  <div class="row">
                      <div class="col-lg-6">
                          <div class="ui search focus mt-20">
                              <div class="ui left icon input swdh11 swdh19">
                                  <input name="first_name" type="text" class="prompt srch_explore" id="first_name" placeholder="First Name *" value="{{ old('first_name', $user->first_name) }}">														
                              </div>
                          </div>						
                          @error('first_name')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="col-lg-6">
                          <div class="ui search focus mt-20">
                              <div class="ui left icon input swdh11 swdh19">
                                  <input name="last_name" type="text" class="prompt srch_explore" id="last_name" placeholder="Last Name *" value="{{ old('last_name', $user->last_name) }}">														
                              </div>
                          </div>						
                          @error('last_name')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
                  <div class="row">
                        <div class="col-lg-3 mt-2">
                            <div class="ui search focus">
                                <div class="ui left icon input swdh11 swdh19">	
                                {{ Form::select('country_code', $countryCodes, old('country_code', $user->country_code), ['class' => 'ui hj145 dropdown cntry152 mt-15 prompt srch_explore', 'id' => 'country_code', 'placeholder' => 'CountryCode *']) }}
                                </div>
                            </div>							
                            @error('country_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                      <div class="col-lg-4">
                          <div class="ui search focus mt-20">
                              <div class="ui left icon input swdh11 swdh19">	
                                  <input name="phone" type="number" class="prompt srch_explore" id="phone" placeholder="Phone *" value="{{ old('phone', $user->phone) }}">				
                              </div>
                          </div>							
                          @error('phone')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="col-lg-5">
                          <div class="ui search focus mt-20">
                              <div class="ui left icon input swdh11 swdh19">
                                  <input name="email" type="text" class="prompt srch_explore" id="email" placeholder="Email *" value="{{ old('email', $user->email) }}" disabled>		
                              </div>
                          </div>										
                          @error('email')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6 mt-2">
                          {{ Form::select('country_id', $countries, old('country_id', $user->country_id), ['class' => 'ui hj145 dropdown cntry152 mt-15 prompt srch_explore', 'id' => 'country_id', 'placeholder' => 'Select Country *', 'onChange'=>'getLocations()']) }}
                          @error('country_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="col-lg-6 mt-2">
                          {{ Form::select('location_id', $locations, old('location_id', $user->location_id), ['class' => 'ui hj145 dropdown cntry152 mt-15 prompt srch_explore', 'id' => 'location_id', 'placeholder' => 'Select Location *']) }}
                          @error('location_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                  </div>
              </div>
          </div>
          <div class="row mt-4">
              <div class="col-lg-8">

                <p><input type="checkbox" required /> I Agree to the <a href="https://coach-to-transformation.com/privacy-policy/" target="_blank">Privacy Policy</a> of {{ config('app.name') }}</p>

              </div>
          </div>
      </div>
      
      <button class="save_btn" type="submit">Save Changes</button>

    </form>
  </div>	
</div>

@endsection