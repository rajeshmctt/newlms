<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {        
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }     
        if (Auth::guard('faculty')->check()) {
            return redirect()->route('faculty.dashboard');
        }   
        if (Auth::guard('web')->check()) {
            return redirect()->route('participant.dashboard');
        }

        Auth::logout();
        return response('Unauthorized.', 401);
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
