<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

use App\Models\Program;
use App\Models\Batch;
use App\Models\Elective;
use App\Models\ElectiveBatch;
use App\Models\UserElective;

class MyProgramElectiveController extends Controller
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
        
        $electiveBatch = ElectiveBatch::with([
            'elective' => function($q) use($user) {
                $q->with([
                    'faculties',
                ]);
            },
        ])->where('status', 'active')->where(function($query) { 
            $query->whereHas('elective', function ($query) {
                $query->where('status', 'active');
            });
        })->where(function($query) use($user) { 
            $query->whereDoesntHave('userElectives', function ($query) use($user) {
                $query->where('user_id', $user->id);
            });
        })->whereDate('date', '>', Carbon::now())->find($electiveBatchId);
        
        $optedElectivesCount = $user->userElectives()->where(['program_id' => $batch->program->id, 'batch_id' => $batch->id, 'status' => 'active'])->count();
        
        $title = "My Program Elective Details";
        return view(config('app.p_slug').'.my_programs.electives.show', compact('title', 'electiveBatch', 'batch', 'optedElectivesCount'));
    }

    public function opt($programId, $programBatchId, $electiveId, $electiveBatchId)
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
        
        $electiveBatch = ElectiveBatch::with([
            'elective',
        ])->where('status', 'active')->where(function($query) { 
            $query->whereHas('elective', function ($query) {
                $query->where('status', 'active');
            });
        })->where(function($query) use($user) { 
            $query->whereDoesntHave('userElectives', function ($query) use($user) {
                $query->where('user_id', $user->id);
            });
        })->whereDate('date', '>', Carbon::now())->find($electiveBatchId);
        
        $optedElectivesCount = $user->userElectives()->where(['program_id' => $batch->program->id, 'batch_id' => $batch->id, 'status' => 'active'])->count();

        if($batch->zero_cost_electives - $optedElectivesCount <= 0){
            $this->response["message"] = __('strings.selected_free_electives_limit');
            return response()->json($this->response);
        }

        if($user->userElectives()->where(['elective_id' => $electiveBatch->elective->id, 'status' => 'active'])->count() > 0){
            $this->response["message"] = __('strings.already_opted_the_elective');
            return response()->json($this->response);
        }

        $userElective = new UserElective();
        $userElective->type = "free";
        $userElective->program_id = $batch->program->id;
        $userElective->batch_id = $batch->id;
        $userElective->elective_id = $electiveBatch->elective->id;
        $userElective->elective_batch_id = $electiveBatch->id;
        $userElective->status = "active";
        
        if($user->userElectives()->save($userElective)){
            $this->response["status"] = true;
            $this->response["message"] = __('strings.successfully_opted_the_elective');
        }
        return response()->json($this->response);
    }
}
