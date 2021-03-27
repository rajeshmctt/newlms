@extends('layouts.faculty')

@section('script')
<script type="text/javascript">

  function getLocations() {
    var countryId = $("#country_id").val();
    $("#location_id").find('option').not(':first').remove();
    if(countryId){
      $.ajax({
          type:'GET',
          url:"{{ url('/participant/countries') }}/"+countryId+"/locations",
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
      <h2 class="st_title"><i class='uil uil-user'></i> {{ $title }}</h2>
      
      <div class="basic_form">
          <div class="row">
              <div class="col-lg-8">
                  <div class="row">
                      <div class="col-lg-6">
                          <div class="ui search focus mt-20">
                              <div class="ui left icon input swdh11 swdh19">
                                  <input name="first_name" type="text" class="prompt srch_explore" id="first_name" placeholder="First Name *" value="{{ old('first_name', $pUser->first_name) }}" readonly>														
                              </div>
                          </div>						
                          @error('first_name')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="col-lg-6">
                          <div class="ui search focus mt-20">
                              <div class="ui left icon input swdh11 swdh19">
                                  <input name="last_name" type="text" class="prompt srch_explore" id="last_name" placeholder="Last Name *" value="{{ old('last_name', $pUser->last_name) }}" readonly>														
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
                                  <input name="country_code" type="text" class="prompt srch_explore" id="country_code" placeholder="Country Code *" value="{{ old('country_code', $pUser->country_code) }}" readonly>														
                              </div>
                          </div>							
                          @error('country_code')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="col-lg-4">
                          <div class="ui search focus mt-20">
                              <div class="ui left icon input swdh11 swdh19">	
                                  <input name="phone" type="number" class="prompt srch_explore" id="phone" placeholder="Phone *" value="{{ old('phone', $pUser->phone) }}" readonly>				
                              </div>
                          </div>							
                          @error('phone')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                      <div class="col-lg-5">
                          <div class="ui search focus mt-20">
                              <div class="ui left icon input swdh11 swdh19">
                                  <input name="email" type="text" class="prompt srch_explore" id="email" placeholder="Email *" value="{{ old('email', $pUser->email) }}" readonly>		
                              </div>
                          </div>										
                          @error('email')
                              <span class="text-danger">{{ $message }}</span>
                          @enderror
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6 mt-2">
                        <div class="ui search focus mt-20">
                            <div class="ui left icon input swdh11 swdh19">
                              <input name="country" type="text" class="prompt srch_explore" id="email" placeholder="Country *" value="{{ old('email', $pUser->country ? $pUser->country->name : '') }}" readonly>				
                            </div>
                        </div>										
                          @error('country_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="col-lg-6 mt-2">
                        <div class="ui search focus mt-20">
                            <div class="ui left icon input swdh11 swdh19">
                              <input name="location" type="text" class="prompt srch_explore" id="email" placeholder="Location *" value="{{ old('email', $pUser->location ? $pUser->location->name : '') }}" readonly>			
                            </div>
                        </div>	
                          @error('location_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="ui search focus mt-20">
                          <div class="ui left icon input swdh11 swdh19">
                            <input name="location" type="text" class="prompt srch_explore" id="email" placeholder="Location *" value="{{ old('email', $pUser->currentCredential ? $pUser->currentCredential->name : '') }}" readonly>			
                          </div>
                      </div>	
                        @error('current_credential_ids')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-6">
                        <div class="ui search focus mt-20">
                            <div class="ui left icon input swdh11 swdh19">
                              <input name="location" type="text" class="prompt srch_explore" id="email" placeholder="Location *" value="{{ old('email', $pUser->currentRole ? $pUser->currentRole->name : '') }}" readonly>			
                            </div>
                        </div>	
                          @error('current_role_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                      <div class="col-lg-6">
                        <div class="ui search focus mt-20">
                            <div class="ui left icon input swdh11 swdh19">
                              <input name="location" type="text" class="prompt srch_explore" id="email" placeholder="Location *" value="{{ old('email', $pUser->currentFunction ? $pUser->currentFunction->name : '') }}" readonly>			
                            </div>
                        </div>	
                          @error('current_function_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                      </div>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                        <div class="ui search focus mt-20">
                            <div class="ui left icon input swdh11 swdh19">
                            <input name="current_organisation_name" type="text" class="prompt srch_explore" id="current_organisation_name" placeholder="Current Organisation's Name *" value="{{ old('current_organisation_name', $pUser->current_organisation_name) }}" readonly>
                          </div>
                        </div>
                        @error('current_organisation_name')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                    <div class="col-lg-6">
                        <div class="ui search focus mt-20">
                            <div class="ui left icon input swdh11 swdh19">
                            <input name="current_organisation_website" type="text" class="prompt srch_explore" id="current_organisation_website" placeholder="Current Organisation's Website" value="{{ old('current_organisation_website', $pUser->current_organisation_website) }}" readonly>
                          </div>
                        </div>
                        @error('current_organisation_website')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-lg-12">
                          <div class="ui form focus mt-15 ">
                            <label>Facebook Profile</label>
                              <div class="ui left icon input swdh11 swdh19">
                        <input name="facebook_profile_url" type="text" class="prompt srch_explore" id="facebook_profile_url" placeholder="Facebook Profile" value="{{ old('facebook_profile_url', $pUser->facebook_profile_url) }}" readonly>
                              </div>
                              @error('facebook_profile_url')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                          <div class="ui form focus mt-15 ">
                            <label>Linkedin Profile</label>
                              <div class="ui left icon input swdh11 swdh19">
                        <input name="linkedin_profile_url" type="text" class="prompt srch_explore" id="linkedin_profile_url" placeholder="Linkedin Profile" value="{{ old('linkedin_profile_url', $pUser->linkedin_profile_url) }}" readonly>
                              </div>
                              @error('linkedin_profile_url')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                          <div class="ui form focus mt-15 ">
                            <label>Instagram Profile</label>
                              <div class="ui left icon input swdh11 swdh19">
                        <input name="instagram_profile_url" type="text" class="prompt srch_explore" id="instagram_profile_url" placeholder="Instagram Profile" value="{{ old('instagram_profile_url', $pUser->instagram_profile_url) }}" readonly>
                              </div>
                              @error('instagram_profile_url')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                          <div class="ui form focus mt-15 ">
                            <label>Twitter Profile</label>
                              <div class="ui left icon input swdh11 swdh19">
                        <input name="twitter_profile_url" type="text" class="prompt srch_explore" id="twitter_profile_url" placeholder="Twitter Profile" value="{{ old('twitter_profile_url', $pUser->twitter_profile_url) }}" readonly>
                              </div>
                              @error('twitter_profile_url')
                                  <span class="text-danger">{{ $message }}</span>
                              @enderror
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      
  </div>	
</div>

@endsection