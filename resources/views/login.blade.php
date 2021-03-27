@extends('layouts.auth')

@section('content')


<div class="col-lg-12">
  <div class="main_logo25" id="logo">
    <a href="#"><img src="{{ asset('assets/images/logo-us.png') }}" alt="" /></a>
    <a href="#"
      ><img class="logo-inverse" src="{{ asset('assets/images/logo-us.png') }}" alt=""
    /></a>
  </div>
</div>

<div class="col-lg-6 col-md-8">
  <div class="sign_form">
    <h2>Learning Management System</h2>
    <p>Log In to {{ config('app.name') }}</p>
  
    @if($message = Session::get('error'))
    <div class="alert alert-danger">
      {{ $message }}
    </div>
    @endif

    @if(count($errors) > 0)
      <div class="alert alert-danger">
        <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
        </ul>
      </div>
    @endif


    <form action="{{ route('do.login') }}" method="post">
      @csrf
      
      <div class="ui search focus mt-15">
        <div class="ui left icon input swdh95">
          <input
            class="prompt srch_explore"
            type="email"
            name="email"
            id="email"
            required=""
            maxlength="64"
            placeholder="Email Address"
            value="{{ old('email') }}"
          />
          <i class="uil uil-envelope icon icon2"></i>
        </div>
      </div>
      <div class="ui search focus mt-15">
        <div class="ui left icon input swdh95">
          <input
            class="prompt srch_explore"
            type="password"
            name="password"
            value=""
            id="password"
            required=""
            maxlength="64"
            placeholder="Password"
          />
          <i class="uil uil-key-skeleton-alt icon icon2"></i>
        </div>
      </div>
      <div class="ui form mt-30 checkbox_sign">
        <div class="inline field">
          <div class="ui checkbox mncheck">
            <input type="checkbox" tabindex="0" class="hidden" />
            <label>Remember Me</label>
          </div>
        </div>
      </div>
      <button class="login-btn" type="submit">Sign In</button>
    </form>
    <p class="sgntrm145" style="border-bottom: 0px">
      <a href="{{ route('forgot_password') }}">Forgot Password?</a>
    </p>
  </div>
  <div class="sign_footer">
    <img src="{{ asset('assets/images/footer-logo-icon.png') }}" alt="" />© 2020
    <strong>{{ config('app.name') }}</strong>. All Rights Reserved.
  </div>
</div>


@endsection