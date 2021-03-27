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
         
        @if($message = Session::get('success'))
        <div class="alert alert-success">
        {{ $message }}
        </div>
        @endif

        <h2>Request a Password Reset</h2>
        <form method="POST" action="{{ route('do.forgot_password') }}">
            @csrf
            <div class="ui search focus mt-50">
                <div class="ui left icon input swdh95">
                    <input class="prompt srch_explore" type="email" name="email" value="" id="id_email" required="" maxlength="64" placeholder="Email Address">															
                    <i class="uil uil-envelope icon icon2"></i>
                </div>
                @if ($errors->has('email'))
                    <span class="" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <button class="login-btn" type="submit">Reset Password</button>
        </form>
    <p class="mb-0 mt-30">Go Back <a href="{{ route('login') }}">Sign In</a></p>
    </div>

  <div class="sign_footer">
    <img src="{{ asset('assets/images/footer-logo-icon.png') }}" alt="" />© 2020
    <strong>{{ config('app.name') }}</strong>. All Rights Reserved.
  </div>
</div>	




@endsection