<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\Location; 
use App\Models\Country; 

class LocationController extends Controller
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

        $locations = Location::with([
            'country'
        ])->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->paginate(15);
        $title = "Locations";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.locations.index', compact('title', 'breadcrumb', 'locations', 'search', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::select('id', 'name')->orderBy('name')->pluck('name', 'id');

        $title = "Create Location";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.locations.index'), 'text' => "Locations"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.locations.create', compact('title', 'breadcrumb', 'countries'));
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
            'country_id' => 'required|exists:App\Models\Country,id',
            'name' => 'required|max:64|unique:App\Models\Location,name,NULL,id,deleted_at,NULL',
        ], [], [
            'country_id' => 'country',
        ]);

        $location = new Location($request->all());
        $location->status = 'active';
        $location->save();

        return redirect()->route(config('app.a_slug').'.locations.index')->with('success', __('strings.store_success'));
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
        $location = Location::find($id);

        $countries = Country::select('id', 'name')->orderBy('name')->pluck('name', 'id');

        $title = "Edit Location";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.locations.index'), 'text' => "Locations"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.locations.edit', compact('title', 'breadcrumb', 'location', 'countries')); 
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
            'country_id' => 'required|exists:App\Models\Country,id',
            'name' => 'required|max:64|unique:App\Models\Location,name,'.$id.',id,deleted_at,NULL',
            'status' => 'required|in:active,inactive',
        ], [], [
            'country_id' => 'country',
        ]);

        $location = Location::find($id);
        $location->fill($request->only(['country_id', 'name', 'status']));
        $location->update();

        return redirect()->route(config('app.a_slug').'.locations.index')->with('success', __('strings.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = Location::find($id);
        if (
            $location->batches()->count()
            || $location->admins()->count()
            || $location->faculties()->count()
            || $location->users()->count()
        ) {
            return back()->with('error', __('strings.destroy_failed'));
        }
        $location->delete();

        return back()->with('success', __('strings.destroy_success'));
    }
}
