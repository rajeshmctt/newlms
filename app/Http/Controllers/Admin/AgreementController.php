<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\Agreement; 

class AgreementController extends Controller
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

        $agreements = Agreement::where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->paginate(15);
        $title = "Agreements";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.agreements.index', compact('title', 'breadcrumb', 'agreements', 'search', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Agreement";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.agreements.index'), 'text' => "Agreements"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.agreements.create', compact('title', 'breadcrumb'));
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
            'name' => 'required|max:64|unique:App\Models\Agreement,name,NULL,id,deleted_at,NULL',
            'content' => 'required',
        ]);

        $agreement = new Agreement($request->all());
        $agreement->status = 'active';
        $agreement->save();

        return redirect()->route(config('app.a_slug').'.agreements.index')->with('success', __('strings.store_success'));
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
        $agreement = Agreement::find($id);

        $title = "Edit Agreement";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.agreements.index'), 'text' => "Agreements"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.agreements.edit', compact('title', 'breadcrumb', 'agreement')); 
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
            'name' => 'required|max:64|unique:App\Models\Agreement,name,'.$id.',id,deleted_at,NULL',
            'content' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        $agreement = Agreement::find($id);
        $agreement->fill($request->only(['name', 'content', 'status']));
        $agreement->update();

        return redirect()->route(config('app.a_slug').'.agreements.index')->with('success', __('strings.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agreement = Agreement::find($id);
        if (
            $agreement->programs()->count()
        ) {
            return back()->with('error', __('strings.destroy_failed'));
        }
        $agreement->delete();

        return back()->with('success', __('strings.destroy_success'));
    }
}
