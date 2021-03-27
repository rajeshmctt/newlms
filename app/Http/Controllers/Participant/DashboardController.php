<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

use App\Models\Batch;
use App\Models\Resource;
use App\Models\Announcement;
use App\Models\GlobalAnnouncement;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        $counts['certificates'] = $user->batchUsers()->whereNotNull('certificate')->count();
        
        $counts['resources'] = Resource::where('status', 'active')
        ->where(function($subQuery) use($user) {  
            $subQuery->whereHas('userResources', function ($query) use($user) {
                $query->where('status', 'active')->where('user_id', $user->id);
            });
        })->count();

        // $announcements = Announcement::where('status', 'active')->latest()->get();
        $announcements = GlobalAnnouncement::where('status', 'active')->latest()->get();

        $upcomingProgramBatches = Batch::with([
            'program',
            'faculties'
        ])->where('status', 'active')->whereDate('start_date', '>', Carbon::now())
        ->where(function($query) use($user) { 
            $query->whereDoesntHave('users', function ($query) use($user) {
                $query->where('user_id', $user->id);
            });
        })->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->orderBy('start_date')->paginate(8);
        
        $programBatches = Batch::with([
            'program',
        ])->withCount([
            'electiveUsers' => function($query) use($user) {
                $query->where('user_id', $user->id);
            },
        ])->where('status', 'active')->whereNotNull('zero_cost_electives')->where('zero_cost_electives', '>', 0)->where(function($query) use($user) { 
            $query->whereHas('users', function ($query) use($user) {
                $query->where('user_id', $user->id)->whereNull('parent_batch_id');
            });
        })->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->get();
        
        $optItNow = false;
        $needToOptProgram = null;
        if($programBatches){
            foreach($programBatches as $programBatch){
                if($programBatch->zero_cost_electives > $programBatch->elective_users_count){
                    $optItNow = true;
                    $needToOptProgram = $programBatch;
                }
            }
        }

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
        return view(config('app.p_slug').'.dashboard', compact('title', 'counts', 'announcements', 'user', 'upcomingProgramBatches', 'optItNow', 'needToOptProgram', 'blogPosts'));
    }
}
