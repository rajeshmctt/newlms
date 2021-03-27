<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;

use App\Models\Batch; 
use App\Models\Program; 
use App\Models\Assignment; 
use App\Models\AssignmentDocument; 
use App\Models\Resource; 

class MentorCoachResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = (string)$request->input('status', 'active');
        $search = (string)$request->input('search', null);
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $user = Auth::guard('faculty')->user();

        $batches = Batch::with([
            'program' => function($q){
                $q->withCount(['resources']);
            }
        ])->withCount(['users'])->whereHas('mentorCoaches', function($q) use($user){
            $q->where('faculty_id', $user->id);
        })->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->where('status', $status)->latest()->paginate(15);

        $activeBatchesCount = Batch::with([
            'program' => function($q){
                $q->withCount(['resources']);
            }
        ])->withCount(['users'])->whereHas('mentorCoaches', function($q) use($user){
            $q->where('faculty_id', $user->id);
        })->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->where('status', 'active')->count();

        $completedBatchesCount = Batch::with([
            'program' => function($q){
                $q->withCount(['resources']);
            }
        ])->withCount(['users'])->whereHas('mentorCoaches', function($q) use($user){
            $q->where('faculty_id', $user->id);
        })->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->where('status', 'completed')->count();

        $title = "As Mentor Coach";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.f_slug').'.mentor_coach_resources.index', compact('title', 'breadcrumb', 'batches', 'activeBatchesCount', 'completedBatchesCount', 'search', 'status', 'prevRecords'));
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
    public function show(Request $request, $id)
    {
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $user = Auth::guard('faculty')->user();
        $batch = Batch::find($id);

        $resources = Resource::whereHas('programs.batches', function($q) use($id){
            $q->where('batches.id', $id);
        })->latest()->paginate(15);

        $title = "Resources for Batch: ".$batch->name;
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.f_slug').'.batch_resources.index', compact('title', 'breadcrumb', 'resources', 'batch', 'prevRecords'));
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
}
