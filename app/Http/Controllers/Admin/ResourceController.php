<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\Resource; 

class ResourceController extends Controller
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

        $resources = Resource::where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%')->orWhere('description', 'like', '%'.$search.'%');
        })->sortable()->paginate(15);
        $title = "Resources";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.resources.index', compact('title', 'breadcrumb', 'resources', 'search', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Resource";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.resources.index'), 'text' => "Resources"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.resources.create', compact('title', 'breadcrumb'));
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
            'name' => 'required|max:255',
            'description' => 'required',
            'visibility' => 'required|in:private,public',
            'format' => 'required|in:document,video,audio,other',
            'type' => 'required|in:file,link',
            'file' => 'nullable|required_if:type,file|file',
            'link' => 'nullable|required_if:type,link|url',
        ]);

        $fileName = null;
        $fileNewName = null;
        if ($request->hasFile('file')) {
            $fileName = $request->file->getClientOriginalName();
            $fileNewName = uniqid('resource_', true).'.'.$request->file->extension();
            $request->file->move(public_path('storage/resources'), $fileNewName);
        }
        
        $resource = new Resource($request->all());
        if($fileName && $fileNewName){
            $resource->file_name = $fileName;
            $resource->file = $fileNewName;
        }
        $resource->status = 'active';
        $resource->save();

        return redirect()->route(config('app.a_slug').'.resources.index')->with('success', __('strings.store_success'));
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
        $resource = Resource::find($id);

        $title = "Edit Resource";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.resources.index'), 'text' => "Resources"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.resources.edit', compact('title', 'breadcrumb', 'resource')); 
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
            'name' => 'required|max:255',
            'description' => 'required',
            'visibility' => 'required|in:private,public',
            'format' => 'required|in:document,video,audio,other',
            'status' => 'required|in:active,inactive',
        ]);

        $resource = Resource::find($id);
        $resource->fill($request->only(['name', 'description', 'visibility', 'format', 'status']));
        $resource->update();
        
        return redirect()->route(config('app.a_slug').'.resources.index')->with('success', __('strings.update_success'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource = Resource::find($id);
        if (
            $resource->programs()->count()
            || $resource->userResources()->count()
        ) {
            return back()->with('error', __('strings.destroy_failed'));
        }
        $resource->delete();

        return back()->with('success', __('strings.destroy_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function link($id)
    {
        $resource = Resource::find($id);
        $title = "View Resource";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.resources.index'), 'text' => "Resources"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.resources.link', compact('title', 'breadcrumb', 'resource'));
    }
}
