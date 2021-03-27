<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\CertificationLevel; 

class CertificationLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = (string)$request->input('search', null);
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $certificationLevels = CertificationLevel::where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->paginate(15);
        $title = "Certification Levels";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.certification_levels.index', compact('title', 'breadcrumb', 'certificationLevels', 'search', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Certification Level";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.certification-levels.index'), 'text' => "Certification Levels"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.certification_levels.create', compact('title', 'breadcrumb'));
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
            'name' => 'required|max:64|unique:App\Models\CertificationLevel,name,NULL,id,deleted_at,NULL',
        ]);

        $certificationLevel = new CertificationLevel($request->all());
        $certificationLevel->status = 'active';
        $certificationLevel->save();

        return redirect()->route(config('app.a_slug').'.certification-levels.index')->with('success', __('strings.store_success'));
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
        $certificationLevel = CertificationLevel::find($id);

        $title = "Edit Certification Level";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.certification-levels.index'), 'text' => "Certification Levels"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.certification_levels.edit', compact('title', 'breadcrumb', 'certificationLevel')); 
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
            'name' => 'required|max:64|unique:App\Models\CertificationLevel,name,'.$id.',id,deleted_at,NULL',
            'status' => 'required|in:active,inactive',
        ]);

        $certificationLevel = CertificationLevel::find($id);
        $certificationLevel->fill($request->only(['name', 'status']));
        $certificationLevel->update();

        return redirect()->route(config('app.a_slug').'.certification-levels.index')->with('success', __('strings.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $certificationLevel = CertificationLevel::find($id);
        if (
            $certificationLevel->programs()->count()
        ) {
            return back()->with('error', __('strings.destroy_failed'));
        }
        $certificationLevel->delete();

        return back()->with('success', __('strings.destroy_success'));
    }
}
