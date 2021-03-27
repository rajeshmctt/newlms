<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\GlobalAnnouncement; 

class GlobalAnnouncementController extends Controller
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

        $globalAnnouncements = GlobalAnnouncement::where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->paginate(15);
        $title = "Global Announcements";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.global_announcements.index', compact('title', 'breadcrumb', 'globalAnnouncements', 'search', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Global Announcement";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.global-announcements.index'), 'text' => "Global Announcements"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.global_announcements.create', compact('title', 'breadcrumb'));
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
            // 'start_date' => 'required|date|date_format:Y-m-d',
            // 'end_date' => 'required|date|date_format:Y-m-d',
        ]);

        $agreement = new GlobalAnnouncement($request->all());
        $agreement->status = 'active';
        $agreement->save();

        return redirect()->route(config('app.a_slug').'.global-announcements.index')->with('success', __('strings.store_success'));
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
        $globalAnnouncement = GlobalAnnouncement::find($id);

        $title = "Edit Global Announcement";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.global-announcements.index'), 'text' => "Global Announcements"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.global_announcements.edit', compact('title', 'breadcrumb', 'globalAnnouncement')); 
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
            // 'start_date' => 'required|date|date_format:Y-m-d',
            // 'end_date' => 'required|date|date_format:Y-m-d',
            'status' => 'required|in:active,inactive',
        ]);

        $globalAnnouncement = GlobalAnnouncement::find($id);
        $globalAnnouncement->fill($request->only(['name', 'description', 'status']));
        $globalAnnouncement->update();

        return redirect()->route(config('app.a_slug').'.global-announcements.index')->with('success', __('strings.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $globalAnnouncement = GlobalAnnouncement::find($id);
        // if (
        //     $globalAnnouncement->programs()->count()
        // ) {
        //     return back()->with('error', __('strings.destroy_failed'));
        // }
        $globalAnnouncement->delete();

        return back()->with('success', __('strings.destroy_success'));
    }
}
