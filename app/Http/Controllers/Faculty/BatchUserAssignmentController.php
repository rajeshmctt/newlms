<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;

use App\Models\User; 
use App\Models\Batch; 
use App\Models\Assignment; 
use App\Models\UserAssignment; 
use App\Models\AssignmentDocument; 

class BatchUserAssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function assignments(Request $request, $batchId, $userId)
    {
        $user = Auth::guard('faculty')->user();
        $pUser = User::find($userId);

        // $userAssignments = UserAssignment::with([
        //     'assignment'
        // ])->whereHas('assignment', function($q) use($batchId){
        //     $q->where('batch_id', $batchId);
        // })->where('user_id', $userId)->latest()->get();

        $batch = Batch::with([
            'program',
            'batchUser' => function($q) use($pUser) {
                $q->where('user_id', $pUser->id);
            },
            'assignments' => function($q) use($pUser) {
                $q->with([
                    'assignmentDocuments',
                    'userAssignment' => function($q) use($pUser) {
                        $q->where('user_id', $pUser->id);
                    },
                ]);
            },
        ])->whereHas('users', function ($query) use($pUser) {
            $query->where('user_id', $pUser->id);
        })->find($batchId);
        
        $title = "Assignments for User: ".$pUser->first_name;
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.f_slug').'.batch_user_assignments.index', compact('title', 'breadcrumb', 'batch'));
    }
}
