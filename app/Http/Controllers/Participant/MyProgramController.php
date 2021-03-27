<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

use App\Models\Program;
use App\Models\Batch;
use App\Models\Assignment;
use App\Models\UserAssignment;
use App\Models\Faculty; 
use App\Models\MentorCoachSession;
use App\Models\ProgramFeedback;
use App\Models\BatchJourney;

class MyProgramController extends Controller
{
    public function index(Request $request)
    {
        $search = (string)$request->input('search', null);
        $month = (string)$request->input('month', date("Y-m"));

        $user = Auth::guard('web')->user();

        $batches = Batch::with([
            'program' => function($q) use($user) {
                $q->with([
                    'label',
                    'programFeedbacks' => function($q) {
                        $q->where('status', 'active');
                    },
                ]);
            },
            'users' => function($q){
                $q->select('users.id', 'first_name', 'last_name', 'email', 'parent_batch_id');
            },
            'faculties',
            'batchUser' => function($query) use($user) {
                $query->where('user_id', $user->id);
            },
        ])->where('status', 'active')->where(function($query) use($user) { 
            $query->whereHas('users', function ($query) use($user) {
                $query->where('user_id', $user->id)->whereNull('parent_batch_id');
            });
        })->where(function($query) use($search) { 
            $query->whereHas('program', function ($query) use($search) {
                $query->where('status', 'active')->where(function($query) use ($search)  {
                    if($search != null) $query->where('name', 'like', '%'.$search.'%');
                });
            });
        })->orderBy('start_date')->paginate(8);

        $title = "My Programs";
        return view(config('app.p_slug').'.my_programs.index', compact('title', 'batches', 'search', 'month'));
    }

    public function show(Request $request, $id, $batchId)
    {
        $activeTab = (string)$request->input('tab', 'journey');
        $user = Auth::guard('web')->user();

        $batch = Batch::with([
            'program' => function($q) use($user, $id) {
                $q->with([
                    'label',
                    'programFeedbacks' => function($q) {
                        $q->where('status', 'active');
                    },
                    'agreement',
                    'certificationLevel',
                    'resources',
                ]);
            },
            'sessions' => function($q) use($user) {
                $q->with([
                    'recordings',
                ]);
            },
            'courseJourneys' => function($q) use($user) {
                $q->where('user_id', $user->id);
            },
            'batchUser' => function($q) use($user) {
                $q->where('user_id', $user->id);
            },
            'users',
            'faculties',
            'assignments' => function($q) use($user) {
                $q->with([
                    'assignmentDocuments',
                    'userAssignment' => function($q) use($user) {
                        $q->where('user_id', $user->id);
                    },
                ]);
            },
            'mentorCoachSessions' => function($q) use($user) {
                $q->where('user_id', $user->id);
            },
        ])->where('status', 'active')->whereHas('users', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->find($batchId);
        
        // $electiveBatches = ElectiveBatch::with([
        //     'elective' => function($q) use($user) {
        //         $q->with([
        //             'faculties',
        //         ]);
        //     },
        // ])->where('status', 'active')->where(function($query) { 
        //     $query->whereHas('elective', function ($query) {
        //         $query->where('status', 'active');
        //     });
        // })->whereDate('date', '>', Carbon::now())
        // ->where(function($query) use($user) { 
        //     $query->whereDoesntHave('userElectives', function ($query) use($user) {
        //         $query->where('user_id', $user->id);
        //     });
        // })->where(function($query) use($id) { 
        //     $query->whereHas('elective.programs', function ($query) use($id) {
        //         $query->where('program_id', $id);
        //     });
        // })->orderBy('date')->get();

        $myElectiveBatches = Batch::with([
            'program' => function($q) use($user) {
                $q->with([
                    'label',
                ]);
            },
            'faculties',
        ])->where('status', 'active')->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })
        ->where(function($query) use($user, $batchId) { 
            $query->whereHas('users', function ($query) use($user, $batchId) {
                $query->where(['parent_batch_id' => $batchId, 'user_id' => $user->id]);
            });
        })->orderBy('start_date')->get();

        $userResources = $user->resources()->where(['user_resources.status' => 'active'])->whereHas('userResources.batch', function ($query) use($batch) {
            $query->where('program_id', $batch->program->id);
        })->get();
        
        $optedElectivesCount = $user->batches()->where(['parent_batch_id' => $batch->id, 'batch_users.status' => 'active'])->count();
        
        $mentorCoaches = $batch->mentorCoaches()->select('faculties.id', 'first_name')->pluck('first_name', 'id');

        $feedbacksCount = $user->programFeedbacks()->where('program_id', $id)->count();

        $title = "My Program Details";
        return view(config('app.p_slug').'.my_programs.show', compact('title', 'batch', 'myElectiveBatches', 'userResources', 'optedElectivesCount', 'mentorCoaches', 'activeTab', 'feedbacksCount'));
    }

    public function submit_assignment(Request $request, $programId, $batchId, $id)
    {
        $request->validate([
            'remarks' => 'required',
            'document' => 'nullable|file',
        ]);

        $user = Auth::guard('web')->user();

        $batch = Batch::with([
            'program',
            'faculties',
        ])->where('status', 'active')->whereHas('users', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->find($batchId);
        
        $assignment = $batch->assignments()->where('status', 'active')->find($id);

        $fileName = null;
        if ($request->hasFile('document')) {
            $fileName = uniqid('assignment_', true).'.'.$request->document->extension();
            $request->document->move(public_path('storage/users/assignments'), $fileName);
        }
        
        $userAssignment = $user->userAssignments()->where(['assignment_id' => $assignment->id])->latest()->first();

        if(!$userAssignment)
            $userAssignment = new UserAssignment(['assignment_id' => $assignment->id]);

        if($fileName) $userAssignment->document = $fileName;
        $userAssignment->remarks = $request->input("remarks");
        $userAssignment->status = "submitted";
        
        if($user->userAssignments()->save($userAssignment)){

            if($assignment->type == 'assignment'){
                $user->batchJourneys()->save(new BatchJourney([
                    'batch_id' => $batch->id, 
                    'title' => 'Assignment Completion',
                    'message' => 'Assignment: '.$assignment->name.' has been completed',
                ]));
            } else if($assignment->type == 'blog') {
                $user->batchJourneys()->save(new BatchJourney([
                    'batch_id' => $batch->id, 
                    'title' => 'Blog Completion',
                    'message' => 'Assignment: '.$assignment->name.' has been completed',
                ]));
            } else if($assignment->type == 'peer-coaching') {
                $peerCoachingCount = $user->userAssignments()->whereHas('assignment',  function($q){
                    $q->where('batch_id', $batch->id)->where('type', 'peer-coaching');
                })->count();
                $user->batchJourneys()->save(new BatchJourney([
                    'batch_id' => $batch->id, 
                    'title' => 'Peer Coaching Completion',
                    'message' => 'Peer Coaching '.$peerCoachingCount.' has been completed',
                ]));
            }

            if($batch->faculties) foreach($batch->faculties as $faculty){
                $faculty->sendUserAssignmentSubmissionNotification($batch, $user, $userAssignment);
            }

            return redirect()->route(config('app.p_slug').'.my_programs.batches.show', [$batch->program->id, $batch->id, 'tab' => 'assignments'])->with('success', __('strings.successfully_submitted'));
        }
        return redirect()->route(config('app.p_slug').'.my_programs.batches.show', [$batch->program->id, $batch->id, 'tab' => 'assignments'])->with('error', __('strings.something_wrong'));
    }

    public function accept_agreement(Request $request, $id, $batchId)
    {
        $user = Auth::guard('web')->user();

        $batch = Batch::with([
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
        
        if(!$batch->batchUser->accept_agreement){
            $batchUser = $batch->batchUser;
            $batchUser->accept_agreement = true;
            if($batchUser->update()){

                // $user->batchJourneys()->save(new BatchJourney(['batch_id' => $batchId, 'message' => 'Agreement Accepted']));

                return redirect()->route(config('app.p_slug').'.my_programs.batches.show', [$batch->program->id, $batch->id])->with('success', __('strings.successfully_accepted'));
            }
        }
        return redirect()->route(config('app.p_slug').'.my_programs.batches.show', [$batch->program->id, $batch->id])->with('error', __('strings.something_wrong'));
    }

    public function feedback_store(Request $request, $programId, $batchId)
    {
        $request->validate([
            'feedback' => 'required',
            'emoticon' => 'nullable|in:like,insightful,curious,favourite',
        ]);

        $user = Auth::guard('web')->user();

        $batch = Batch::with([
            'program',
        ])->where('status', 'active')->whereHas('users', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->find($batchId);
        
        $programFeedback = new ProgramFeedback($request->all());
        $programFeedback->program_id = $programId;
        
        if($user->programFeedbacks()->save($programFeedback)){
            return redirect()->route(config('app.p_slug').'.my_programs.batches.show', [$batch->program->id, $batch->id, 'tab' => 'feedback'])->with('success', __('strings.successfully_submitted'));
        }
        return redirect()->route(config('app.p_slug').'.my_programs.batches.show', [$batch->program->id, $batch->id, 'tab' => 'feedback'])->with('error', __('strings.something_wrong'));
    }

    public function mentor_coach_session_feedback_store(Request $request, $programId, $batchId)
    {
        $request->validate([
            'faculty_id' => 'required|exists:App\Models\Faculty,id',
            'date' => 'required|date_format:Y-m-d',
            'feedback' => 'required',
        ]);

        $user = Auth::guard('web')->user();

        $batch = Batch::with([
            'program',
        ])->withCount([
            'mentorCoachSessions' => function($q) use($user) {
                $q->where('user_id', $user->id);
            },
        ])->where('status', 'active')->whereHas('users', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->find($batchId);
        
        $mentorCoachSession = new MentorCoachSession($request->all());
        $mentorCoachSession->batch_id = $batchId;
        $mentorCoachSession->session_no = $batch->mentor_coach_sessions_count + 1;

        if($user->mentorCoachSessions()->save($mentorCoachSession)){
            $user->batchJourneys()->save(new BatchJourney([
                'batch_id' => $batch->id, 
                'title' => 'Mentor Coaching Completion',
                'message' => 'Feedback for Mentor Coaching Session '.($batch->mentor_coach_sessions_count + 1).' has been submitted by you',
            ]));
            return redirect()->route(config('app.p_slug').'.my_programs.batches.show', [$batch->program->id, $batch->id, 'tab' => 'mentor-coach'])->with('success', __('strings.successfully_submitted'));
        }
        return redirect()->route(config('app.p_slug').'.my_programs.batches.show', [$batch->program->id, $batch->id, 'tab' => 'mentor-coach'])->with('error', __('strings.something_wrong'));
    }
}
