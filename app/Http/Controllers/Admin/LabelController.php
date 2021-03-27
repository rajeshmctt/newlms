<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\Label; 

class LabelController extends Controller
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

        $labels = Label::where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->paginate(15);
        $title = "Labels";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.labels.index', compact('title', 'breadcrumb', 'labels', 'search', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Label";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.labels.index'), 'text' => "Labels"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.labels.create', compact('title', 'breadcrumb'));
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
            'name' => 'required|max:64|unique:App\Models\Label,name,NULL,id,deleted_at,NULL',
        ]);

        $label = new Label($request->all());
        $label->status = 'active';
        $label->save();

        return redirect()->route(config('app.a_slug').'.labels.index')->with('success', __('strings.store_success'));
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
        $label = Label::find($id);

        $title = "Edit Label";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.labels.index'), 'text' => "Labels"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.labels.edit', compact('title', 'breadcrumb', 'label')); 
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
            'name' => 'required|max:64|unique:App\Models\Label,name,'.$id.',id,deleted_at,NULL',
            'status' => 'required|in:active,inactive',
        ]);

        $label = Label::find($id);
        $label->fill($request->only(['name', 'status']));
        $label->update();

        return redirect()->route(config('app.a_slug').'.labels.index')->with('success', __('strings.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $label = Label::find($id);
        if (
            $label->programs()->count()
        ) {
            return back()->with('error', __('strings.destroy_failed'));
        }
        $label->delete();

        return back()->with('success', __('strings.destroy_success'));
    }
}
