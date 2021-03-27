<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Hash;

use App\Models\User; 
use App\Models\Batch; 
use App\Models\BatchUser; 
use App\Models\Session; 

class BatchUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $batchId)
    {
        $search = (string)$request->input('search', null);
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $batch = Batch::find($batchId);
        
        $pUsers = $batch->users()->where(function($query) use ($search)  {
            if($search != null) $query->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%');
        })->sortable()->paginate(15);

        $title = "Participants".($batch ? ' of Batch: '.$batch->name : '');

        if($batch) $breadcrumb[] = ['link' => route(config('app.a_slug').'.batches.index', $batch ? ['program_id' => $batch->program->id] : []), 'text' => "Participants".($batch ? ' for Program: '.$batch->program->name : '')];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.batch_users.index', compact('title', 'breadcrumb', 'pUsers', 'batch', 'search', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $batchId)
    {
        $search = (string)$request->input('search', null);
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $batch = Batch::find($batchId);

        $pUsers = User::where(function($query) use ($search)  {
            $query->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%');
        })->paginate(15);
        
        $title = "Add Participant to ".($batch ? ' Batch: '.$batch->name : '');
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.batches.participants', $batchId), 'text' => "Batch Participants"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.batch_users.create', compact('title', 'breadcrumb', 'pUsers', 'batch', 'search', 'prevRecords'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $batchId, $pUserId)
    {
        $batch = Batch::find($batchId);

        $pUserStatus = $batch->users()->where('user_id', $pUserId)->count();
        if(!$pUserStatus){
            $batchUser = new BatchUser([
                'user_id' => $pUserId,
                'status' => 'active',
            ]);
            $batch->batchUsers()->save($batchUser);
            return redirect()->back()->with('success', __('strings.user_added_to_batch_success'));
        } else {
            return redirect()->back()->with('error', __('strings.user_already_added_to_batch'));
        }
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
    public function destroy($batchId, $id)
    {
        $batchUser = BatchUser::find($id);
        $batchUser->delete();

        return back()->with('success', __('strings.destroy_success'));
    }
}
