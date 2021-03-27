<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Hash;

use App\Models\User; 
use App\Models\Batch; 
use App\Models\BatchUser; 
use App\Models\Session; 

class CertificateController extends Controller
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

        $bUsers = BatchUser::with([
            'user',
            'batch' => function($q){
                $q->with([
                    'program'
                ])->withCount('assignments');
            }
        ])->where(function($query) use ($search)  {
            if($search != null) $query->whereHas('user', function($q) use($search){
                $q->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%');
            });
        })->latest()->paginate(15);

        $title = "Certificates";

        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.certificates.index', compact('title', 'breadcrumb', 'bUsers', 'search', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'certificate' => 'file|max:2048',
            'status' => 'required|in:active,completed',
        ]);

        $fileName = null;
        if ($request->hasFile('certificate')) {
            $fileName = uniqid('certificate_', true).'.'.$request->certificate->extension();
            $request->certificate->move(public_path('storage/certificates'), $fileName);
        }

        $batchUser = BatchUser::find($id);
        if($fileName) $batchUser->certificate = $fileName;
        $batchUser->status = $request->input('status');
        $batchUser->update();

        return redirect()->route(config('app.a_slug').'.certificates.index')->with('success', __('strings.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $batchUser = BatchUser::find($id);
        $batchUser->certificate = null;
        $batchUser->update();

        return back()->with('success', __('strings.destroy_success'));
    }
}
