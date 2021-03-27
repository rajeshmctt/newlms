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

class MyProgramMyElectiveController extends Controller
{

    public function show($programId, $programBatchId, $electiveId, $electiveBatchId)
    {
        $user = Auth::guard('web')->user();

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
            'program' => function($q) use($user) {
                $q->with([
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
        ])->where('status', 'active')->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->whereHas('users', function ($query) use($user) {
            $query->where('user_id', $user->id);
        })->find($electiveBatchId);
        
        $optedElectivesCount = $user->batches()->where(['parent_batch_id' => $batch->id, 'batch_users.status' => 'active'])->count();
        
        $title = "My Program My Elective Details";
        return view(config('app.p_slug').'.my_programs.my_electives.show', compact('title', 'electiveBatch', 'batch', 'optedElectivesCount'));
    }
}
