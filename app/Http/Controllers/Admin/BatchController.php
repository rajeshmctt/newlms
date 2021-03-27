<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\Batch; 
use App\Models\Program; 
use App\Models\Country; 
use App\Models\Location; 
use App\Models\Faculty;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = (string)$request->input('search', null);
        $startDate = (string)$request->input('start_date', null);
        $endDate = (string)$request->input('end_date', null);
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $request->validate([
            'program_id' => 'nullable|exists:App\Models\Program,id',
        ]);
        $programId = $request->input('program_id');

        $program = Program::find($programId);
        
        $batches = Batch::with([
            'program',
            'faculties',
            'mentorCoaches',
        ])->withCount(['sessions', 'users'])->where(function($query) use ($startDate)  {
            if($startDate != null) $query->where('start_date', '>=', $startDate);
        })->where(function($query) use ($endDate)  {
            if($endDate != null) $query->where('end_date', '<=', $endDate);
        })->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->where(function($query) use ($programId)  {
            if($programId != null) $query->whereHas('program', function($query) use ($programId){
                $query->where('id', $programId);
            });
        })->latest()->sortable()->paginate(15);
        $title = "Batches".($program ? ' for Program: '.$program->name : '');

        if($program) $breadcrumb[] = ['link' => route(config('app.a_slug').'.programs.index'), 'text' => "Programs"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.batches.index', compact('title', 'breadcrumb', 'batches', 'search', 'program', 'prevRecords', 'startDate', 'endDate'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $programId = $request->input('program_id', null);

        $program = Program::find($programId);
        
        $programs = Program::select('id', 'name')->pluck('name', 'id');
        $countries = Country::select('id', 'name')->orderBy('name')->pluck('name', 'id');
        $locations = old('country_id', $program->country_id) ? Location::select('id', 'name')->where('country_id', old('country_id', $program->country_id))->orderBy('name')->pluck('name', 'id') : [];
        $faculties = Faculty::select('id', DB::raw('CONCAT(first_name, " ", last_name) as name'))->whereHas('coachTypes', function($q){
            $q->whereIn('code', ['faculty']);
        })->where('status', 'active')->pluck('name', 'id');
        $mentorCoaches = Faculty::select('id', DB::raw('CONCAT(first_name, " ", last_name) as name'))->whereHas('coachTypes', function($q){
            $q->whereIn('code', ['mentor-coach']);
        })->where('status', 'active')->pluck('name', 'id');

        $programFacultyIds = $program->faculties()->pluck('faculty_id')->toArray();
        $programMentorCoachIds = $program->mentorCoaches()->pluck('faculty_id')->toArray();

        $title = "Create Batch".($program ? ' for Program: '.$program->name : '');
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.batches.index'), 'text' => "Batches"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.batches.create', compact('title', 'breadcrumb', 'programs', 'countries', 'locations', 'faculties', 'mentorCoaches', 'program', 'programFacultyIds', 'programMentorCoachIds'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type_2' => 'required',
            'name' => 'required|max:255|unique:App\Models\Batch,name,NULL,id,deleted_at,NULL',
            'program_id' => 'required|exists:App\Models\Program,id',
            'country_id' => 'required|exists:App\Models\Country,id',
            'location_id' => 'required|exists:App\Models\Location,id',
            'faculty_ids' => 'required|array|exists:App\Models\Faculty,id',
            'mentor_coach_ids' => 'nullable|array|exists:App\Models\Faculty,id',
            'start_date' => 'required|date|date_format:Y-m-d|before_or_equal:end_date',
            'end_date' => 'required|date|date_format:Y-m-d',
            'duration_hr' => 'required|numeric|min:0',
            'duration_min' => 'required|numeric|min:0|max:59',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|different:start_time',
            'reg_start_date' => 'required|date|date_format:Y-m-d|before_or_equal:reg_end_date',
            'reg_end_date' => 'required|date|date_format:Y-m-d',
            'zero_cost_electives' => 'nullable|numeric',
            'mentor_coach_meetings' => 'nullable|numeric',
        ], [], [
            'type_2' => 'Online or Face to Face',
            'country_id' => 'country',
            'location_id' => 'location',
            'faculty_ids' => 'faculty',
            'mentor_coach_ids' => 'mentor coachs',
            'program_id' => 'program',
        ]);

        if($request->input('duration_hr') == 0 && $request->input('duration_min') == 0){
            return back()->withErrors(['duration_hr' => "Invalid duration."])->withInput($request->all());
        }

        $batch = new Batch($request->all());
        $batch->type = 'self';
        $batch->status = 'active';
        $batch->save();

        $batch->faculties()->sync($request->input('faculty_ids'));
        $batch->mentorCoaches()->sync($request->input('mentor_coach_ids'));

        return redirect()->route(config('app.a_slug').'.batches.sessions', $batch->id)->with('success', __('strings.store_success'));
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
        $batch = Batch::find($id);

        $programs = Program::select('id', 'name')->pluck('name', 'id');
        $countries = Country::select('id', 'name')->orderBy('name')->pluck('name', 'id');
        $locations = old('country_id', $batch->country_id) ? Location::select('id', 'name')->where('country_id', old('country_id', $batch->country_id))->orderBy('name')->pluck('name', 'id') : [];
        $faculties = Faculty::select('id', DB::raw('CONCAT(first_name, " ", last_name) as name'))->whereHas('coachTypes', function($q){
            $q->whereIn('code', ['faculty']);
        })->where('status', 'active')->pluck('name', 'id');
        $mentorCoaches = Faculty::select('id', DB::raw('CONCAT(first_name, " ", last_name) as name'))->whereHas('coachTypes', function($q){
            $q->whereIn('code', ['mentor-coach']);
        })->where('status', 'active')->pluck('name', 'id');

        $batchFacultyIds = $batch->faculties()->pluck('faculty_id')->toArray();
        $batchMentorCoachIds = $batch->mentorCoaches()->pluck('faculty_id')->toArray();

        $title = "Edit Batch";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.batches.index'), 'text' => "Batches"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.batches.edit', compact('title', 'breadcrumb', 'batch', 'programs', 'countries', 'locations', 'faculties', 'mentorCoaches', 'batchFacultyIds', 'batchMentorCoachIds')); 
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
        $request->validate([
            'type_2' => 'required',
            'name' => 'required|max:255|unique:App\Models\Batch,name,'.$id.',id,deleted_at,NULL',
            'country_id' => 'required|exists:App\Models\Country,id',
            'location_id' => 'required|exists:App\Models\Location,id',
            'faculty_ids' => 'required|array|exists:App\Models\Faculty,id',
            'mentor_coach_ids' => 'nullable|array|exists:App\Models\Faculty,id',
            'start_date' => 'required|date|date_format:Y-m-d|before_or_equal:end_date',
            'end_date' => 'required|date|date_format:Y-m-d',
            'duration_hr' => 'required|numeric|min:0',
            'duration_min' => 'required|numeric|min:0|max:59',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|different:start_time',
            'reg_start_date' => 'required|date|date_format:Y-m-d|before_or_equal:reg_end_date',
            'reg_end_date' => 'required|date|date_format:Y-m-d',
            'zero_cost_electives' => 'nullable|numeric',
            'mentor_coach_meetings' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
        ], [], [
            'type_2' => 'Online or Face to Face',
            'country_id' => 'country',
            'location_id' => 'location',
            'faculty_ids' => 'faculty',
            'mentor_coach_ids' => 'mentor coaches',
        ]);

        if($request->input('duration_hr') == 0 && $request->input('duration_min') == 0){
            return back()->withErrors(['duration_hr' => "Invalid duration."])->withInput($request->all());
        }

        $batch = Batch::find($id);
        $batch->fill($request->only(['type_2', 'name', 'country_id', 'location_id', 'start_date', 'end_date', 'duration_hr', 'duration_min', 'start_time', 'end_time', 'reg_start_date', 'reg_end_date', 'zero_cost_electives', 'mentor_coach_meetings', 'status']));
        $batch->update();

        $batch->faculties()->sync($request->input('faculty_ids'));
        $batch->mentorCoaches()->sync($request->input('mentor_coach_ids'));

        return redirect()->route(config('app.a_slug').'.batches.index', ['program_id' => $batch->program->id])->with('success', __('strings.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $batch = Batch::find($id);
        if (
            $batch->sessions()->count()
        ) {
            return back()->with('error', __('strings.destroy_failed'));
        }
        $batch->delete();

        return back()->with('success', __('strings.destroy_success'));
    }
}
