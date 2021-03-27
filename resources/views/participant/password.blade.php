@extends('layouts.participant')

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
      
      @include(Config::get('app.p_slug').'.account_menu')
      
      {{ Form::open(array('route' => [Config::get('app.p_slug').'.account.update.password'], 'method' => 'put')) }}

      <div class="basic_ptitle">
          <h3>Change Password</h3>
      </div>
      <div class="basic_form">
        
        <div class="row">
          <div class="col-lg-8">
              <div class="row">
                  <div class="col-lg-6">
                      <div class="ui search focus mt-20">
                          <div class="ui left icon input swdh11 swdh19">
                              <input name="current_password" type="password" class="prompt srch_explore" id="current_password" placeholder="Current Password" value="">									
                          </div>
                      </div>
                      @error('current_password')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror				
                  </div>
              </div>
              <div class="row">
                  <div class="col-lg-6">
                      <div class="ui search focus mt-20">
                          <div class="ui left icon input swdh11 swdh19">
                              <input name="new_password" type="password" class="prompt srch_explore" id="new_password" placeholder="New Password" value="">												
                          </div>
                      </div>
                      @error('new_password')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>
                  <div class="col-lg-6">
                      <div class="ui search focus mt-20">
                          <div class="ui left icon input swdh11 swdh19">
                              <input name="new_password_confirmation" type="password" class="prompt srch_explore" id="new_password_confirmation" placeholder="Confirm Password" value="">												
                          </div>
                      </div>
                      @error('new_password_confirmation')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                  </div>
              </div>
              <br>
              <div class="help-block" style="font-size:14px;">Note: Password should be minimum 8 characters, at least one Upper case and one Lower case, one Number and one Special character (#?!@$%^&*-)</div>
          </div>
        </div>

      </div>
      
      <button class="save_btn" type="submit">Update</button>

    </form>
  </div>	
</div>

@endsection