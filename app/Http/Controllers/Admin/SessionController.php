<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Hash;

use App\Models\Batch; 
use App\Models\Session; 

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $batchId)
    {
        $batch = Batch::find($batchId);
        
        $sessions = $batch->sessions()->orderBy('session_no')->get();
        $title = "Sessions".($batch ? ' for Batch: '.$batch->name : '');

        if($batch) $breadcrumb[] = ['link' => route(config('app.a_slug').'.batches.index', $batch ? ['program_id' => $batch->program->id] : []), 'text' => "Batches".($batch ? ' for Program: '.$batch->program->name : '')];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.sessions.manage', compact('title', 'breadcrumb', 'sessions', 'batch'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
            // 'batch_id' => 'required|exists:App\Models\Batch,id',
            // 'session_no' => 'required|array',
            // 'session_no.*' => 'required|integer|gt:0',
            // 'type' => 'required|array',
            // 'type.*' => 'required|in:in-person,online',
            // 'description' => 'required|array',
            // 'description.*' => 'required',
            // 'date' => 'required|array',
            // 'date.*' => 'required|date_format:Y-m-d',
            // 'start_time' => 'required|date_format:H:i',
            // 'end_time' => 'required|date_format:H:i',
        ]);

        $batch = Batch::find($batchId);

        $sessionsCount = $batch->sessions->count();

        $session = new Session();
        $session->session_no = $sessionsCount+1;
        $session->start_time = $batch->start_time;
        $session->end_time = $batch->end_time;
        $session->status = 'active';
        $batch->sessions()->save($session);

        $this->response["status"] = true;
        $this->response["message"] = __('strings.store_success');
        return response()->json($this->response);
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
    public function update(Request $request, $batchId)
    {
        // dd($request->all());
        $request->validate([
            // 'session_no' => 'required|array',
            // 'session_no.*' => 'required|integer|gt:0',
            'type' => 'required|array',
            'type.*' => 'required|in:in-person,online',
            'date' => 'required|array',
            'date.*' => 'required|date_format:Y-m-d',
            'start_time' => 'required|array',
            'start_time.*' => 'required|date_format:H:i',
            'end_time' => 'required|array',
            'end_time.*' => 'required|date_format:H:i',
            'description' => 'nullable|array',
            'description.*' => 'nullable',
        ], [], [
            'type.*' => 'Type',
            'date.*' => 'Date',
            'start_time.*' => 'Start Time',
            'end_time.*' => 'End Time',
            'description.*' => 'Description',
        ]);

        $type = $request->input('type');
        $date = $request->input('date');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $description = $request->input('description');

        if(count($date) > 0){
            foreach($date as $dKey => $d){

                foreach($date as $cdKey => $cd) if($cdKey < $dKey){
                    if($d == $cd && $startTime[$dKey] == $startTime[$cdKey]) return redirect()->back()->withErrors(['date.'.$dKey => 'Duplicate Session']);
                }
            }
        }

        $batch = Batch::find($batchId);

        $sessions = $batch->sessions()->get();
        if($sessions) foreach($sessions as $session){
            $session->type = $type[$session->session_no];
            $session->date = $date[$session->session_no];
            $session->start_time = $startTime[$session->session_no];
            $session->end_time = $endTime[$session->session_no];
            $session->description = $description[$session->session_no];
            $session->update();
        }

        return redirect()->route(config('app.a_slug').'.batches.sessions', $batchId)->with('success', __('strings.changes_saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($batchId)
    {
        $batch = Batch::find($batchId);

        $session = $batch->sessions()->orderByDesc('session_no')->first();
        if (
            $session->recordings()->count()
        ) {
            return back()->with('error', __('strings.destroy_failed'));
        }
        $session->delete();

        return back()->with('success', __('strings.destroy_success'));
    }
}
