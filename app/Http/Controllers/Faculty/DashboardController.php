<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

use App\Models\Program;
use App\Models\Batch;
use App\Models\User;
use App\Models\Resource;
use App\Models\Announcement;
use App\Models\GlobalAnnouncement;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('faculty')->user();

        // $announcements = Announcement::where('status', 'active')->latest()->get();
        $announcements = GlobalAnnouncement::where('status', 'active')->latest()->get();

        $counts = [];

        $counts['facultyBatches'] = $user->activeFacultyBatchesCount();
        $counts['mentorCoachBatches'] = $user->activeMentorCoachBatchesCount();
        
        $counts['users'] = User::whereHas('batches.faculties', function($q) use($user){
            $q->where('faculty_id', $user->id)->where(['batches.status' => 'active']);
        })->count();

        $counts['resources'] = Resource::whereHas('programs.batches.faculties', function($q) use($user){
            $q->where('faculty_id', $user->id)->where(['batches.status' => 'active']);
        })->count();

        $upcomingProgramBatches = Batch::with([
            'program',
            'faculties'
        ])->where('status', 'active')->whereDate('start_date', '>', Carbon::now())
        ->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->orderBy('start_date')->paginate(8);

        $blogPosts = [];
        // $blogs = Http::get('https://coach-to-transformation.com/wp-json/wl/v1/posts', ['per_page' => 4]);
        // if($blogs->json()) foreach($blogs->json() as $blog){

        //     $blogPosts[] = [
        //         'id' => $blog['id'],
        //         'link' => $blog['link'],
        //         'title' => $blog['title'],
        //         'excerpt' => $blog['description'],
        //         'image' => $blog['image'] ? $blog['image'] : asset('img/default-blog.png'),
        //         'author' => $blog['author'],
        //         'date' => Carbon::parse($blog['date'])->format('M d, Y'),
        //         'new' => Carbon::parse($blog['date'])->addDays(14) >= Carbon::now() ? true : false,
        //     ];
        // }

        
        $title = "Dashboard";
        return view(config('app.f_slug').'.dashboard', compact('title', 'counts', 'announcements', 'upcomingProgramBatches', 'blogPosts'));
    }
}
