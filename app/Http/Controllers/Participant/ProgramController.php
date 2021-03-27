<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

use App\Models\Program;
use App\Models\Batch;
use App\Models\ProgramFeedback;
use App\Models\BatchJourney;
use App\Models\Option; 

use App\Mail\ProgramEnquiry;

class ProgramController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('web')->user();

        $search = (string)$request->input('search', null);
        $month = (string)$request->input('month', 'all');

        $months = null;
        if($month && $month != 'all'){
            $months = explode('--', $month);
        }
        
        $batches = Batch::with([
            'program' => function($q) use($user) {
                $q->with([
                    'label',
                    'programFeedbacks' => function($q) {
                        $q->where('status', 'active');
                    },
                ]);
            },
            'faculties',
            'batchUser' => function($query) use($user) {
                $query->where('user_id', $user->id);
            },
        ])->where(function($query) use ($months)  {
            if($months != null) $query->where('start_date', '>=', $months[0])->where('start_date', '<=', $months[1]);
        })->where('status', 'active')
        ->where(function($query) use($user) { 
            $query->whereDoesntHave('users', function ($query) use($user) {
                $query->where('user_id', $user->id)->whereNotNull('parent_batch_id');
            });
        })->whereDate('start_date', '>', Carbon::now())
        ->whereDate('reg_start_date', '<=', Carbon::now())
        ->whereDate('reg_end_date', '>=', Carbon::now())
        ->where(function($query) use($search) { 
            $query->whereHas('program', function ($query) use($search) {
                $query->where('status', 'active')->where(function($query) use ($search)  {
                    if($search != null) $query->where('name', 'like', '%'.$search.'%');
                });
            });
        })->orderBy('start_date')->paginate(8);

        $monthFilters = [];
        for ($i = 5; $i >= 0; $i--){
            $monthFilters[date('Y-m-01--Y-m-t', strtotime("+$i months"))] = date('F \'y', strtotime("+$i months"));
        }
        $monthFilters['all'] = 'All';

        $title = "All Programs";
        return view(config('app.p_slug').'.programs.index', compact('title', 'batches', 'search', 'month', 'monthFilters'));
    }

    public function show(Request $request, $id, $batchId)
    {
        $activeTab = (string)$request->input('tab', 'outline');
        $user = Auth::guard('web')->user();

        $batch = Batch::with([
            'faculties',
            'program' => function($q) use($user) {
                $q->with([
                    'label',
                    'programFeedbacks' => function($q) {
                        $q->where('status', 'active');
                    },
                ]);
            },
            'batchUser' => function($query) use($user) {
                $query->where('user_id', $user->id);
            },
        ])->where('status', 'active')->whereDate('start_date', '>', Carbon::now())->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->where(function($query) use($user) { 
            // $query->whereDoesntHave('users', function ($query) use($user) {
            //     $query->where('user_id', $user->id);
            // });
        })
        ->find($batchId);
        
        $title = "Program Details";
        return view(config('app.p_slug').'.programs.show', compact('title', 'batch', 'activeTab'));
    }

    public function feedback_store(Request $request, $programId, $batchId)
    {
        $request->validate([
            'feedback' => 'required',
            'emoticon' => 'nullable|in:like,insightful,curious,favourite',
        ]);

        $user = Auth::guard('web')->user();

        $programFeedback = new ProgramFeedback($request->all());
        $programFeedback->program_id = $programId;
        
        if($user->programFeedbacks()->save($programFeedback)){
            return redirect()->route(config('app.p_slug').'.programs.batches.show', [$programId, $batchId, 'tab' => 'feedback'])->with('success', __('strings.successfully_submitted'));
        }
        return redirect()->route(config('app.p_slug').'.programs.batches.show', [$programId, $batchId, 'tab' => 'feedback'])->with('error', __('strings.something_wrong'));
    }

    public function enquiry(Request $request, $programId, $batchId)
    {
        $user = Auth::guard('web')->user();

        $batch = Batch::find($batchId);
        
        if($batch){  
            // admin_emails
            $adminEmails = Option::where('key', 'admin_emails')->first();  
            $adminEmails = $adminEmails ? explode(',', $adminEmails->value) : [];
            
            Mail::to($adminEmails)->send(new ProgramEnquiry($user, $batch));
            
            return redirect()->route(config('app.p_slug').'.programs.batches.show', [$programId, $batchId])->with('success', __('strings.successfully_submitted'));
        }
        return redirect()->route(config('app.p_slug').'.programs.batches.show', [$programId, $batchId])->with('error', __('strings.something_wrong'));
    }

}
