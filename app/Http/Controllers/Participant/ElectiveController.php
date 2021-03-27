<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Carbon\Carbon;

use App\Models\Program;
use App\Models\Batch;
use App\Models\BatchUser;
use App\Models\ProgramFeedback;
use App\Models\BatchJourney;

class ElectiveController extends Controller
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

        $electiveBatches = Batch::with([
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
                $query->where('user_id', $user->id)->whereNull('parent_batch_id');
            });
        })->whereDate('start_date', '>', Carbon::now())
        ->whereDate('reg_start_date', '<=', Carbon::now())
        ->whereDate('reg_end_date', '>=', Carbon::now())
        ->where(function($query) use($search) { 
            $query->whereHas('program', function ($query) use($search) {
                $query->where('status', 'active')->where('type', 'elective')->where(function($query) use ($search)  {
                    if($search != null) $query->where('name', 'like', '%'.$search.'%');
                });
            });
        })->orderBy('start_date')->paginate(8);

        $monthFilters = [];
        for ($i = 5; $i >= 0; $i--){
            $monthFilters[date('Y-m-01--Y-m-t', strtotime("+$i months"))] = date('F \'y', strtotime("+$i months"));
        }
        $monthFilters['all'] = 'All';

        $title = "All Electives";
        return view(config('app.p_slug').'.electives.index', compact('title', 'electiveBatches', 'search', 'month', 'monthFilters'));
    }

    public function show(Request $request, $id, $batchId)
    {
        $activeTab = (string)$request->input('tab', 'outline');
        $user = Auth::guard('web')->user();

        $electiveBatch = Batch::with([
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
        ])->where('status', 'active')->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->where(function($query) use($user) { 
            // $query->whereDoesntHave('userElectives', function ($query) use($user) {
            //     $query->where('user_id', $user->id);
            // });
        })->whereDate('start_date', '>', Carbon::now())->find($batchId);
        
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
        if($programBatches){
            foreach($programBatches as $programBatch){
                if($programBatch->zero_cost_electives > $programBatch->elective_users_count){
                    $optItNow = true;
                }
            }
        }

        $title = "Elective Details";
        return view(config('app.p_slug').'.electives.show', compact('title', 'electiveBatch', 'programBatches', 'optItNow', 'activeTab'));
    }

    public function opt(Request $request, $id, $batchId)
    {
        $user = Auth::guard('web')->user();

        $validator = Validator::make($request->all(), [
            // 'program_id' => 'required|exists:App\Models\Program,id',
            'batch_id' => 'required|exists:App\Models\Batch,id',
        ]);
        if($validator->fails()) {
            $this->response["message"] = $validator->errors()->first();
            return response()->json($this->response);
        }

        // $programId = $request->input('program_id');
        $programBatchId = $request->input('batch_id');

        $batch = Batch::with([
            'program',
        ])->where('status', 'active')->whereHas('users', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->find($programBatchId);
        
        $electiveBatch = Batch::with([
            'program',
        ])->where('status', 'active')->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->where(function($query) use($user) { 
            $query->whereDoesntHave('users', function ($query) use($user) {
                $query->where('user_id', $user->id);
            });
        })->whereDate('start_date', '>', Carbon::now())->find($batchId);
        
        if($user->electiveBatchUsers()->where(['batch_id' => $electiveBatch->id, 'status' => 'active'])->count() > 0){
            $this->response["message"] = __('strings.already_opted_the_elective');
            return response()->json($this->response);
        }

        $optedElectivesCount = $user->electiveBatchUsers()->where(['parent_batch_id' => $batch->id, 'status' => 'active'])->count();

        if($batch->zero_cost_electives - $optedElectivesCount <= 0){
            $this->response["message"] = __('strings.selected_free_electives_limit');
            return response()->json($this->response);
        }

        $userElective = new BatchUser();
        $userElective->parent_batch_id = $batch->id;
        $userElective->batch_id = $electiveBatch->id;
        $userElective->status = "active";
        
        if($user->electiveBatchUsers()->save($userElective)){

            $user->batchJourneys()->save(new BatchJourney([
                'batch_id' => $batch->id, 
                'title' => 'Elective Selection Completion',
                'message' => 'You have opted for the elective: '.$electiveBatch->program->name,
            ]));

            $this->response["status"] = true;
            $this->response["message"] = __('strings.successfully_opted_the_elective');
        }
        return response()->json($this->response);
    }

    public function feedback_store(Request $request, $electiveId, $batchId)
    {
        $request->validate([
            'feedback' => 'required',
            'emoticon' => 'nullable|in:like,insightful,curious,favourite',
        ]);

        $user = Auth::guard('web')->user();

        $electiveFeedback = new ProgramFeedback($request->all());
        $electiveFeedback->program_id = $electiveId;
        
        if($user->programFeedbacks()->save($electiveFeedback)){
            return redirect()->route(config('app.p_slug').'.electives.batches.show', [$electiveId, $batchId, 'tab' => 'feedback'])->with('success', __('strings.successfully_submitted'));
        }
        return redirect()->route(config('app.p_slug').'.electives.batches.show', [$electiveId, $batchId, 'tab' => 'feedback'])->with('error', __('strings.something_wrong'));
    }
}
