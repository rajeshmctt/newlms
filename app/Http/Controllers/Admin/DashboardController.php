<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

use App\Models\Program;
use App\Models\Batch;
use App\Models\Faculty;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('admin')->user();

        $counts = [];

        $user = Auth::user();

        $counts['programs'] = Program::count();
        $counts['batches'] = Batch::count();
        $counts['users'] = User::count();
        $counts['faculties'] = Faculty::count();

        $title = "Dashboard";
        return view(config('app.a_slug').'.dashboard', compact('title', 'counts'));
    }
}
