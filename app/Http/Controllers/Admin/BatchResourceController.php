<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Hash;

use App\Models\Batch; 
use App\Models\Session; 
use App\Models\Resource; 
use App\Models\UserResource; 


class BatchResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $batchId)
    {
        $batch = Batch::find($batchId);
        
        $resources = $batch->userResources()->select('resource_id', DB::raw('GROUP_CONCAT(user_id) as userIds'))->with([
            'resource'
        ])->groupBy('resource_id')->get();
        $title = "Participant Resources".($batch ? ' for Batch: '.$batch->name : '');
        
        $resourceIds = $batch->program->resources()->pluck('resources.id');
        $allResources = Resource::select('id', 'name')->whereDoesntHave('userResources', function($q) use($batch){
            $q->where('batch_id', $batch->id);
        })->whereNotIn('id', $resourceIds)->pluck('name', 'id');

        $title = "Participant Resources".($batch ? ' for Batch: '.$batch->name : '');

        $users = $batch->users()->select('users.id', 'first_name')->pluck('first_name', 'id');

        if($batch) $breadcrumb[] = ['link' => route(config('app.a_slug').'.batches.index', $batch ? ['program_id' => $batch->program->id] : []), 'text' => "Batches".($batch ? ' for Program: '.$batch->program->name : '')];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.batches.resources.manage', compact('title', 'breadcrumb', 'resources', 'allResources', 'batch', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $batchId)
    {
        $request->validate([
            'resource_id' => 'required',
            'user_ids' => 'required|array',
            'user_ids.*' => 'required',
        ]);

        $resId = $request->get('resource_id');
        $userIds = $request->get('user_ids');

        // dd($userIds);
        $batch = Batch::find($batchId);
        $resource = Resource::find($resId);

        $resource->userResources()->where('batch_id', $batch->id)->whereNotIn('user_id', $userIds)->delete();

        if(count($userIds) > 0){
            foreach($userIds as $userId){
                $userResource = $resource->userResources()->where(['batch_id' => $batch->id, 'user_id' => $userId])->first();
                if($userResource){
                    $userResource->status = 'active';
                    $userResource->update();
                } else {
                    $userResource = new UserResource(['user_id' => $userId, 'batch_id' => $batchId, 'status' => 'active']);
                    $resource->userResources()->save($userResource);
                }
            }
        }

        return redirect()->route(config('app.a_slug').'.batches.resources', $batchId)->with('success', __('strings.changes_saved'));
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
    public function update(Request $request, $batchId, $resId)
    {
        $request->validate([
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'nullable',
        ]);

        $userIds = $request->get('user_ids');

        // dd($userIds);
        $batch = Batch::find($batchId);
        $resource = Resource::find($resId);

        $resource->userResources()->where('batch_id', $batch->id)->whereNotIn('user_id', $userIds)->delete();

        if(count($userIds) > 0){
            foreach($userIds as $userId){
                $userResource = $resource->userResources()->where(['batch_id' => $batch->id, 'user_id' => $userId])->first();
                if($userResource){
                    $userResource->status = 'active';
                    $userResource->update();
                } else {
                    $userResource = new UserResource(['user_id' => $userId, 'batch_id' => $batchId, 'status' => 'active']);
                    $resource->userResources()->save($userResource);
                }
            }
        }

        return redirect()->route(config('app.a_slug').'.batches.resources', $batchId)->with('success', __('strings.changes_saved'));
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
}
