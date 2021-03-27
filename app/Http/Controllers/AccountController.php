<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use Hash;
use Carbon\Carbon;
use Password;
// use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use App\Models\User; 
use App\Models\Faculty; 
use App\Models\Admin; 

class AccountController extends Controller
{
    // use SendsPasswordResetEmails;

    public function login()
    {
        $title = "Login";
        return view('login', compact('title'));
    }
    
    public function do_login(Request $request){ 

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->only('email'));
        }

        // $user = User::where($request->only('email'))->first();
        // if(!$user){
        //     return back()->with('error', __('strings.login_failed'))->withInput($request->only('email'));
        // }

        $credentials = $request->only('email', 'password');
        $credentials = array_merge($credentials, ['status' => 'active']);

        if(Auth::guard('web')->attempt($credentials)){ 

            $user = Auth::guard('web')->user();
            $user->last_logged_in_at = $user->logged_in_at ? $user->logged_in_at : Carbon::now();
            $user->logged_in_at = Carbon::now();
            $user->update();

            return redirect()->route('dashboard');
        } elseif(Auth::guard('faculty')->attempt($credentials)){ 

            $faculty = Auth::guard('faculty')->user();
            $faculty->last_logged_in_at = $faculty->logged_in_at ? $faculty->logged_in_at : Carbon::now();
            $faculty->logged_in_at = Carbon::now();
            $faculty->update();

            return redirect()->route('dashboard');
        } elseif(Auth::guard('admin')->attempt($credentials)){ 

            // $admin = Auth::guard('admin')->user();
            // $faculty->last_logged_in_at = $faculty->logged_in_at ? $faculty->logged_in_at : Carbon::now();
            // $faculty->logged_in_at = Carbon::now();
            // $faculty->update();

            return redirect()->route('dashboard');
        } else { 
            return back()->with('error', __('strings.login_failed'))->withInput($request->only('email'));
        } 
    }

    public function showLinkRequestForm(Request $request)
    {
        $title = "Forgot Password";
        $userType = $request->input('user_type') ?? "user";
        switch($userType){
            case 'user':
                $passwordEmailRoute = "do.forgot_password";
            break;
            case 'faculty':
                $passwordEmailRoute = "do.forgot_password.faculty";
            break;
            case 'admin':
                $passwordEmailRoute = "do.forgot_password.admin";
            break;
        }
        return view('forgot_password', compact('title', 'passwordEmailRoute', 'userType'));
    }

    public function _do_forgot_password(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        dd($status);
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }
    

    public function forgot_password(Request $request)
    {
        $title = "Forgot Password";
        return view('forgot_password', compact('title'));
    }
    
    public function do_forgot_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->only('email'));
        }

        $email = $request->input('email');
        
        $user = User::where('email', $email)->first();
        if(!$user){
            $user = Faculty::where('email', $email)->first();
            if(!$user){
                $user = Admin::where('email', $email)->first();
                if(!$user){
                    return back()->withErrors(['email' => 'Email not exists!'])->withInput($request->only('email'));
                }
            }
        }

        $user->sendPasswordResetNotification(Hash::make($email));
        
        return redirect()->route('forgot_password')->with(['success' => 'We have emailed your password reset link!']);
    }

    public function reset_password(Request $request)
    {
        $token = $request->input('token');
        $email = $request->input('email');
        
        if($email && !Hash::check($email, $token)) {
            return redirect()->route('reset_password')->with(['error' => 'Invalid password reset link!']);
        }

        $title = "Reset Password";
        return view('reset_password', compact('title', 'token', 'email'));
    }
    
    public function do_reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
            'new_password' => 'required|confirmed|string|min:8|max:15|regex:/^(?=.*?[a-z])(?=.*?[A-Z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/',
        ], [
            'new_password.min' => 'Minimum 8 characters, at least one Upper case and one Lower case, one Number and one Special character (#?!@$%^&*-)',
            'new_password.regex' => 'Minimum 8 characters, at least one Upper case and one Lower case, one Number and one Special character (#?!@$%^&*-)'
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->only(['email', 'token']));
        }

        $email = $request->input('email');
        
        $user = User::where('email', $email)->first();
        if(!$user){
            $user = Faculty::where('email', $email)->first();
            if(!$user){
                $user = Admin::where('email', $email)->first();
                if(!$user){
                    return back()->withErrors(['email' => 'Email not exists!'])->withInput($request->only('email'));
                }
            }
        }

        $user->password = Hash::make($request['new_password']);
        if($user->update()){
            return redirect()->route('reset_password')->with(['success' => 'Your password has been reset successfully!']);
        } else {
            return back()->with('error', __('strings.update_failed'));
        }
        
    }

}
