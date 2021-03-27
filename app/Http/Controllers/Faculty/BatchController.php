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
use App\Models\Recording; 

class BatchController extends Controller
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

        $batches = Batch::with(['program'])->withCount(['users'])->whereHas('faculties', function($q) use($user){
            $q->where('faculty_id', $user->id);
        })->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->where('status', $status)->latest()->paginate(15);

        $activeBatchesCount = Batch::with(['program'])->withCount(['users'])->whereHas('faculties', function($q) use($user){
            $q->where('faculty_id', $user->id);
        })->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->where('status', 'active')->count();

        $completedBatchesCount = Batch::with(['program'])->withCount(['users'])->whereHas('faculties', function($q) use($user){
            $q->where('faculty_id', $user->id);
        })->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->where('status', 'completed')->count();

        $title = "Faculty Batches";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.f_slug').'.batches.index', compact('title', 'breadcrumb', 'batches', 'activeBatchesCount', 'completedBatchesCount', 'search', 'status', 'prevRecords'));
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
        $activeTab = (string)$request->input('tab', 'sessions');

        $user = Auth::guard('faculty')->user();

        $batch = Batch::with([
            'program' => function($q) {
                $q->with([
                    'label',
                    'certificationLevel',
                    'resources',
                ]);
            },
            'sessions' => function($q) {
                $q->with([
                    'recordings',
                ]);
            },
            'users',
            'assignments' => function($q) {
                $q->with([
                    'assignmentDocuments',
                ])->latest();
            },
        ])->find($id);
        
        $batchSessions = $batch->sessions()->select('id', 'session_no')->pluck('session_no', 'id');

        $title = "Faculty Batch Details";
        return view(config('app.f_slug').'.batches.show', compact('title', 'batch', 'activeTab', 'batchSessions'));
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
    public function update(Request $request, $batchId)
    {
        $batch = Batch::find($batchId);
        $batch->status = 'completed';
        if($batch->update()){
            return back()->with('success', __('strings.update_success'));
        } else {
            return back()->with('error', __('strings.update_failed'));
        }
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



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_assignment(Request $request, $batchId)
    {
        $batch = Batch::with([
            'program', 
            'users', 
            'faculties', 
        ])->find($batchId);
        
        $request->validate([
            'type' => 'required|in:assignment,blog,peer-coaching',
            'name' => 'required|max:255',
            'due_date' => 'required|date|date_format:Y-m-d',
            'file' => 'nullable|file',
        ]);

        $fileName = null;
        $fileNewName = null;
        if ($request->hasFile('file')) {
            $fileName = $request->file->getClientOriginalName();
            $fileNewName = uniqid('assignment_', true).'.'.$request->file->extension();
            $request->file->move(public_path('storage/assignments'), $fileNewName);
        }

        $assignment = new Assignment($request->all());
        $assignment->status = 'active';
        $batch->assignments()->save($assignment);

        if($fileName && $fileNewName){
            $assignmentDocument = new AssignmentDocument(['name' => $fileName, 'document' => $fileNewName, 'status' => 'active']);
            $assignment->assignmentDocuments()->save($assignmentDocument);
        }

        // Email Notification
        if(count($batch->users)) foreach($batch->users as $pUser){
            $pUser->sendProgramNewAssignmentNotification($batch);
        }
        
        return redirect()->route(config('app.f_slug').'.faculty-batches.show', [$batch->id, 'tab' => 'assignments'])->with('success', __('strings.store_success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_recording(Request $request, $batchId)
    {
        $batch = Batch::find($batchId);
        
        $request->validate([
            'name' => 'required|max:255',
            'session_id' => 'required|exists:App\Models\Session,id',
            'type' => 'required|in:file,link',
            'file' => 'nullable|required_if:type,file|file',
            'link' => 'nullable|required_if:type,link|url',
        ]);

        $fileName = null;
        $fileNewName = null;
        if ($request->hasFile('file')) {
            $fileName = $request->file->getClientOriginalName();
            $fileNewName = uniqid('recording_', true).'.'.$request->file->extension();
            $request->file->move(public_path('storage/recordings'), $fileNewName);
        }

        $recording = new Recording($request->all());
        // $recording->type = 'file';
        if($fileName && $fileNewName){
            $recording->file_name = $fileName;
            $recording->file = $fileNewName;
        }
        $recording->status = 'active';
        $recording->save();

        $recording->sessions()->sync($request->input('session_id'));

        return redirect()->route(config('app.f_slug').'.faculty-batches.show', [$batch->id, 'tab' => 'recordings'])->with('success', __('strings.store_success'));
    }
    
    public function update_recording(Request $request, $batchId, $sId, $rId)
    {
        $batch = Batch::find($batchId);
        
        $request->validate([
            'name' => 'required|max:255',
            'session_id' => 'required|exists:App\Models\Session,id',
            'type' => 'required|in:file,link',
            'file' => 'nullable|required_if:type,file|file',
            'link' => 'nullable|required_if:type,link|url',
        ]);

        $fileName = null;
        $fileNewName = null;
        if ($request->hasFile('file')) {
            $fileName = $request->file->getClientOriginalName();
            $fileNewName = uniqid('recording_', true).'.'.$request->file->extension();
            $request->file->move(public_path('storage/recordings'), $fileNewName);
        }

        $recording = Recording::find($rId);
        $recording->fill($request->only(['name', 'session_id', 'type', 'link']));
        // $recording->type = 'file';
        if($fileName && $fileNewName){
            $recording->file_name = $fileName;
            $recording->file = $fileNewName;
        }
        $recording->update();

        return redirect()->route(config('app.f_slug').'.faculty-batches.show', [$batch->id, 'tab' => 'recordings'])->with('success', __('strings.update_success'));
    }

    public function delete_recording($id, $sId, $rId)
    {
        $batch = Batch::find($id);
        $session = $batch->sessions()->find($sId);

        $session->recordings()->detach($rId);

        return redirect()->route(config('app.f_slug').'.faculty-batches.show', [$batch->id, 'tab' => 'recordings'])->with('success', __('strings.destroy_success'));
    }

    public function update_assignment(Request $request, $batchId, $aId)
    {
        $batch = Batch::find($batchId);
        
        $request->validate([
            'type' => 'required|in:assignment,blog,peer-coaching',
            'name' => 'required|max:255',
            'due_date' => 'required|date|date_format:Y-m-d',
            'file' => 'nullable|file',
        ]);

        $fileName = null;
        $fileNewName = null;
        if ($request->hasFile('file')) {
            $fileName = $request->file->getClientOriginalName();
            $fileNewName = uniqid('assignment_', true).'.'.$request->file->extension();
            $request->file->move(public_path('storage/assignments'), $fileNewName);
        }

        $assignment = $batch->assignments()->find($aId);
        $assignment->fill($request->only(['type', 'name', 'due_date']));
        if($fileName && $fileNewName){
            $assignment->assignmentDocuments()->delete();
            $assignmentDocument = new AssignmentDocument(['name' => $fileName, 'document' => $fileNewName, 'status' => 'active']);
            $assignment->assignmentDocuments()->save($assignmentDocument);
        }
        $assignment->update();

        return redirect()->route(config('app.f_slug').'.faculty-batches.show', [$batch->id, 'tab' => 'assignments'])->with('success', __('strings.update_success'));
    }

    public function delete_assignment($id, $aId)
    {
        $batch = Batch::find($id);
        $assignment = $batch->assignments()->find($aId);

        $assignment->delete();

        return redirect()->route(config('app.f_slug').'.faculty-batches.show', [$batch->id, 'tab' => 'assignments'])->with('success', __('strings.destroy_success'));
    }
}
