<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Password;
// use Illuminate\Support\Facades\Password;

class UserForgotPasswordController extends Controller
{
    // use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest:web');
    }

    /**
     * Show the reset email form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm(){
        return view('forgot_password',[
            'title' => 'Forgot Password',
            'userType' => 'user',
            'passwordEmailRoute' => 'do.forgot_password'
        ]);
    }


    /**
     * Send Reset link
     * 
     * @return \Illuminate\Http\Response
     */
    public function sendResetLink(Request $request){

        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    /**
     * password broker for admin guard.
     * 
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker(){
        return Password::broker('users');
    }

    /**
     * Get the guard to be used during authentication
     * after password reset.
     * 
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard(){
        return Auth::guard('web');
    }
}
