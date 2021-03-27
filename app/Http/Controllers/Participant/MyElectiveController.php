<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

use App\Models\Program;
use App\Models\Batch;
use App\Models\ProgramFeedback;
use App\Models\BatchJourney;
use App\Models\Assignment;
use App\Models\UserAssignment;

class MyElectiveController extends Controller
{
    public function index(Request $request)
    {
        $search = (string)$request->input('search', null);
        $month = (string)$request->input('month', date("Y-m"));

        $user = Auth::guard('web')->user();

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
        ])->where('status', 'active')->where(function($query) use($user) { 
            $query->whereHas('users', function ($query) use($user) {
                $query->where('user_id', $user->id)->whereNotNull('parent_batch_id');
            });
        })->where(function($query) use($search) { 
            $query->whereHas('program', function ($query) use($search) {
                $query->where('status', 'active')->where(function($query) use ($search)  {
                    if($search != null) $query->where('name', 'like', '%'.$search.'%');
                });
            });
        })->orderBy('start_date')->paginate(8);

        $title = "My Electives";
        return view(config('app.p_slug').'.my_electives.index', compact('title', 'electiveBatches', 'search', 'month'));
    }

    public function show(Request $request, $id, $batchId)
    {
        $activeTab = (string)$request->input('tab', 'journey');
        $user = Auth::guard('web')->user();

        $electiveBatch = Batch::with([
            'program' => function($q) use($user) {
                $q->with([
                    'label',
                    'agreement',
                    'resources',
                    'programFeedbacks' => function($q) {
                        $q->where('status', 'active');
                    },
                ]);
            },
            'faculties',
            'sessions' => function($q) use($user) {
                $q->with([
                    'recordings',
                ]);
            },
            'courseJourneys' => function($q) use($user) {
                $q->where('user_id', $user->id);
            },
            'users',
            'batchUser' => function($q) use($user) {
                $q->where('user_id', $user->id);
            },
            'assignments' => function($q) use($user) {
                $q->with([
                    'assignmentDocuments',
                    'userAssignment' => function($q) use($user) {
                        $q->where('user_id', $user->id);
                    },
                ]);
            },
            
        ])->where('status', 'active')->whereHas('users', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->find($batchId);
        
        $feedbacksCount = $user->programFeedbacks()->where('program_id', $id)->count();

        $title = "My Elective Details";
        return view(config('app.p_slug').'.my_electives.show', compact('title', 'electiveBatch', 'activeTab', 'feedbacksCount'));
    }

    public function submit_assignment(Request $request, $electiveId, $batchId, $id)
    {
        $request->validate([
            'remarks' => 'required',
            'document' => 'nullable|file',
        ]);

        $user = Auth::guard('web')->user();

        $electiveBatch = Batch::with([
            'program',
        ])->where('status', 'active')->whereHas('batchUsers', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->find($batchId);
        
        $electiveAssignment = $electiveBatch->programAssignments()->where('status', 'active')->find($id);

        $fileName = null;
        if ($request->hasFile('document')) {
            $fileName = uniqid('assignment_', true).'.'.$request->document->extension();
            $request->document->move(public_path('storage/users/assignments'), $fileName);
        }
        
        $userElectiveAssignment = $user->userAssignments()->where(['assignment_id' => $electiveAssignment->id])->latest()->first();

        if(!$userElectiveAssignment)
            $userElectiveAssignment = new UserAssignment(['assignment_id' => $electiveAssignment->id]);

        if($fileName) $userElectiveAssignment->document = $fileName;
        $userElectiveAssignment->remarks = $request->input("remarks");
        $userElectiveAssignment->status = "submitted";
        
        if($user->userAssignments()->save($userElectiveAssignment)){
            return redirect()->route(config('app.p_slug').'.my_electives.batches.show', [$electiveBatch->program->id, $electiveBatch->id, 'tab' => 'assignments'])->with('success', __('strings.successfully_submitted'));
        }
        return redirect()->route(config('app.p_slug').'.my_electives.batches.show', [$electiveBatch->program->id, $electiveBatch->id, 'tab' => 'assignments'])->with('error', __('strings.something_wrong'));
    }

    public function accept_agreement(Request $request, $id, $batchId)
    {
        $user = Auth::guard('web')->user();

        $electiveBatch = Batch::with([
            'program',
            'batchUser' => function($q) use($user) {
                $q->where('user_id', $user->id);
            },            
        ])->where('status', 'active')->whereHas('users', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->find($batchId);
        
        if(!$electiveBatch->batchUser->accept_agreement){
            $userElective = $electiveBatch->batchUser;
            $userElective->accept_agreement = true;
            if($userElective->update()){

                $user->batchJourneys()->save(new BatchJourney(['batch_id' => $electiveBatch->id, 'message' => 'Agreement Accepted']));

                return redirect()->route(config('app.p_slug').'.my_electives.batches.show', [$electiveBatch->program->id, $electiveBatch->id])->with('success', __('strings.successfully_accepted'));
            }
        }
        return redirect()->route(config('app.p_slug').'.my_electives.batches.show', [$electiveBatch->program->id, $electiveBatch->id])->with('error', __('strings.something_wrong'));
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
            return redirect()->route(config('app.p_slug').'.my_electives.batches.show', [$electiveId, $batchId, 'tab' => 'feedback'])->with('success', __('strings.successfully_submitted'));
        }
        return redirect()->route(config('app.p_slug').'.my_electives.batches.show', [$electiveId, $batchId, 'tab' => 'feedback'])->with('error', __('strings.something_wrong'));
    }
}
