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

        @if($message = Session::get('error'))
        <div class="alert alert-danger">
        {{ $message }}
        </div>
        @endif

        <h2>Reset Password</h2>
           
        <form method="POST" action="{{ route('do.reset_password') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" readonly class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email', $email) }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="new_password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <div class="col-md-6">
                    <input id="new_password" type="password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password" required>

                    @if ($errors->has('new_password'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('new_password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="new_password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <div class="col-md-6">
                    <input id="new_password-confirm" type="password" class="form-control" name="new_password_confirmation" required>
                </div>
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