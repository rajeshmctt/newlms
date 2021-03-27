<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\Country; 
use App\Models\Location; 

class CountryController extends Controller
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

        $countries = Country::where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->paginate(15);
        $title = "Countries";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.countries.index', compact('title', 'breadcrumb', 'countries', 'search', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Country";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.countries.index'), 'text' => "Countries"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.countries.create', compact('title', 'breadcrumb'));
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
            'name' => 'required|max:64|unique:App\Models\Country,name,NULL,id,deleted_at,NULL',
        ]);

        $country = new Country($request->all());
        $country->status = 'active';
        $country->save();

        return redirect()->route(config('app.a_slug').'.countries.index')->with('success', __('strings.store_success'));
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
        $country = Country::find($id);

        $title = "Edit Country";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.countries.index'), 'text' => "Countries"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.countries.edit', compact('title', 'breadcrumb', 'country')); 
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
            'name' => 'required|max:64|unique:App\Models\Country,name,'.$id.',id,deleted_at,NULL',
            'status' => 'required|in:active,inactive',
        ]);

        $country = Country::find($id);
        $country->fill($request->only(['name', 'status']));
        $country->update();

        return redirect()->route(config('app.a_slug').'.countries.index')->with('success', __('strings.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::find($id);
        if (
            $country->locations()->count()
            || $country->batches()->count()
            || $country->admins()->count()
            || $country->faculties()->count()
            || $country->users()->count()
        ) {
            return back()->with('error', __('strings.destroy_failed'));
        }
        $country->delete();

        return back()->with('success', __('strings.destroy_success'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function locations(Request $request, $countryId)
    {
        $where = ['status' => 'active'];
        $locations = Location::where('country_id', $countryId)->where($where)->orderBy('name')->get();
        
        $this->response["status"] = true;
        $this->response["message"] = __('strings.get_all_success');
        $this->response["data"] = $locations;
        return response()->json($this->response);
    }
}
