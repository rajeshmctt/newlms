<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\Program; 
use App\Models\Agreement; 
use App\Models\Faculty; 
use App\Models\Resource; 
use App\Models\CertificationLevel; 
use App\Models\Label; 
use App\Models\Currency; 

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = (string)$request->input('search', null);
        $type = (string)$request->input('type');
        $certificationLevel = (string)$request->input('certification_level');
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $programs = Program::withCount(['batches'])->with([
            'faculties',
            'mentorCoaches',
        ])->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->where(function($query) use ($type)  {
            if($type != null) $query->where('type', $type);
        })->where(function($query) use ($certificationLevel)  {
            if($certificationLevel != null) $query->where('certification_level_id', $certificationLevel);
        })->latest()->sortable()->paginate(15);

        $certificationLevels = CertificationLevel::select('id', 'name')->pluck('name', 'id');

        $title = "Programs";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.programs.index', compact('title', 'breadcrumb', 'programs', 'search', 'type', 'certificationLevel', 'certificationLevels', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agreements = Agreement::select('id', 'name')->pluck('name', 'id');
        $faculties = Faculty::select('id', DB::raw('CONCAT(first_name, " ", last_name) as name'))->whereHas('coachTypes', function($q){
            $q->whereIn('code', ['faculty']);
        })->where('status', 'active')->pluck('name', 'id');
        $mentorCoaches = Faculty::select('id', DB::raw('CONCAT(first_name, " ", last_name) as name'))->whereHas('coachTypes', function($q){
            $q->whereIn('code', ['mentor-coach']);
        })->where('status', 'active')->pluck('name', 'id');
        $resources = Resource::select('id', 'name')->pluck('name', 'id');
        $certificationLevels = CertificationLevel::select('id', 'name')->pluck('name', 'id');
        $labels = Label::select('id', 'name')->pluck('name', 'id');
        $currencies = Currency::select('id', 'name')->pluck('name', 'id');
        
        $title = "Create Program";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.programs.index'), 'text' => "Programs"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.programs.create', compact('title', 'breadcrumb', 'agreements', 'faculties', 'mentorCoaches', 'resources', 'certificationLevels', 'labels', 'currencies'));
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
            'type' => 'required|in:program,elective',
            'type_2' => 'required',
            'label_id' => 'nullable|exists:App\Models\Label,id',
            'name' => 'required|max:255|unique:App\Models\Program,name,NULL,id,deleted_at,NULL',
            'agreement_id' => 'nullable|exists:App\Models\Agreement,id',
            'certification_level_id' => 'required|exists:App\Models\CertificationLevel,id',
            'faculty_ids' => 'required|array|exists:App\Models\Faculty,id',
            'mentor_coach_ids' => 'nullable|array|exists:App\Models\Faculty,id',
            'resource_ids' => 'required|array|exists:App\Models\Resource,id',
            'description' => 'required',
            'long_description' => 'required',
            'who_is_it_for' => 'nullable',
            'what_you_will_gain' => 'nullable',
            'zero_cost_electives' => 'nullable|numeric',
            'mentor_coach_meetings' => 'nullable|numeric',
            'image' => 'required|image|max:2048',
            'payment_mode' => 'nullable|required_if:type,program|in:offline,online',
            'currency_id' => 'nullable|required_if:payment_mode,online|exists:App\Models\Currency,id',
            'amount' => 'nullable|required_if:payment_mode,online|numeric',
        ], [], [
            'type_2' => 'Inhouse or Open',
            'label_id' => 'label',
            'agreement_id' => 'agreement',
            'certification_level_id' => 'certification level',
            'faculty_ids' => 'faculty',
            'mentor_coach_ids' => 'mentor coaches',
            'resource_ids' => 'resources',
            'currency_id' => 'currency',
        ]);

        $fileName = null;
        if ($request->hasFile('image')) {
            $fileName = uniqid('program_', true).'.'.$request->image->extension();
            $request->image->move(public_path('storage/programs'), $fileName);
        }

        $program = new Program($request->all());
        $program->image = $fileName ? $fileName : "default.png";
        $program->status = 'active';
        $program->save();

        $program->faculties()->sync($request->input('faculty_ids'));
        $program->mentorCoaches()->sync($request->input('mentor_coach_ids'));
        $program->resources()->sync($request->input('resource_ids'));

        return redirect()->route(config('app.a_slug').'.programs.index')->with('success', __('strings.store_success'));
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
        $program = Program::find($id);

        $agreements = Agreement::select('id', 'name')->pluck('name', 'id');
        $faculties = Faculty::select('id', DB::raw('CONCAT(first_name, " ", last_name) as name'))->whereHas('coachTypes', function($q){
            $q->whereIn('code', ['faculty']);
        })->where('status', 'active')->pluck('name', 'id');
        $mentorCoaches = Faculty::select('id', DB::raw('CONCAT(first_name, " ", last_name) as name'))->whereHas('coachTypes', function($q){
            $q->whereIn('code', ['mentor-coach']);
        })->where('status', 'active')->pluck('name', 'id');
        $resources = Resource::select('id', 'name')->pluck('name', 'id');
        $certificationLevels = CertificationLevel::select('id', 'name')->pluck('name', 'id');
        $labels = Label::select('id', 'name')->pluck('name', 'id');
        $currencies = Currency::select('id', 'name')->pluck('name', 'id');
        
        $facultyIds = $program->faculties()->pluck('faculty_id')->toArray();
        $mentorCoacheIds = $program->mentorCoaches()->pluck('faculty_id')->toArray();
        $resourceIds = $program->resources()->pluck('resource_id')->toArray();

        $selectAll = true;
        if(count($resources) > 0) foreach($resources as $resourceKey => $resource){
            if(!in_array($resourceKey, $resourceIds)) $selectAll = false;
        }

        $title = "Edit Program";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.programs.index'), 'text' => "Programs"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.programs.edit', compact('title', 'breadcrumb', 'program', 'agreements', 'faculties', 'mentorCoaches', 'resources', 'certificationLevels', 'labels', 'currencies', 'facultyIds', 'mentorCoacheIds', 'resourceIds', 'selectAll')); 
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
            'type' => 'required|in:program,elective',
            'type_2' => 'required',
            'label_id' => 'nullable|exists:App\Models\Label,id',
            'name' => 'required|max:255|unique:App\Models\Program,name,'.$id.',id,deleted_at,NULL',
            'agreement_id' => 'nullable|exists:App\Models\Agreement,id',
            'certification_level_id' => 'required|exists:App\Models\CertificationLevel,id',
            'faculty_ids' => 'required|array|exists:App\Models\Faculty,id',
            'mentor_coach_ids' => 'nullable|array|exists:App\Models\Faculty,id',
            'resource_ids' => 'required|array|exists:App\Models\Resource,id',
            'description' => 'required',
            'long_description' => 'required',
            'who_is_it_for' => 'nullable',
            'what_you_will_gain' => 'nullable',
            'zero_cost_electives' => 'nullable|numeric',
            'mentor_coach_meetings' => 'nullable|numeric',
            'image' => 'nullable|image|max:2048',
            'payment_mode' => 'nullable|required_if:type,program|in:offline,online',
            'currency_id' => 'nullable|required_if:payment_mode,online|exists:App\Models\Currency,id',
            'amount' => 'nullable|required_if:payment_mode,online|numeric',
            'status' => 'required|in:active,inactive',
        ], [], [
            'type_2' => 'Inhouse or Open',
            'label_id' => 'label',
            'agreement_id' => 'agreement',
            'certification_level_id' => 'certification level',
            'faculty_ids' => 'faculty',
            'mentor_coach_ids' => 'mentor coaches',
            'resource_ids' => 'resources',
            'currency_id' => 'currency',
        ]);

        $fileName = null;
        if ($request->hasFile('image')) {
            $fileName = uniqid('program_', true).'.'.$request->image->extension();
            $request->image->move(public_path('storage/programs'), $fileName);
        }

        $program = Program::find($id);
        $program->fill($request->only(['type', 'type_2', 'label_id', 'name', 'agreement_id', 'certification_level_id', 'description', 'long_description', 'who_is_it_for', 'what_you_will_gain', 'zero_cost_electives', 'mentor_coach_meetings', 'payment_mode', 'currency_id', 'amount', 'status']));
        if($fileName) $program->image = $fileName;
        $program->update();

        $program->faculties()->sync($request->input('faculty_ids'));
        $program->mentorCoaches()->sync($request->input('mentor_coach_ids'));
        $program->resources()->sync($request->input('resource_ids'));

        return redirect()->route(config('app.a_slug').'.programs.index')->with('success', __('strings.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $program = Program::find($id);
        if (
            $program->batches()->count()
        ) {
            return back()->with('error', __('strings.destroy_failed'));
        }
        $program->delete();

        return back()->with('success', __('strings.destroy_success'));
    }
}
