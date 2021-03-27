<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;
use Carbon\Carbon;

use App\Models\Program; 
use App\Models\Batch;

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
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $user = Auth::guard('faculty')->user();

        $programs = Program::withCount([
            'batches' => function($q) use($user){
                $q->whereHas('faculties', function($q) use($user){
                    $q->where('faculty_id', $user->id);
                });
            }
        ])->whereHas('batches.faculties', function($q) use($user){
            $q->where('faculty_id', $user->id);
        })->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->latest()->paginate(15);

        $title = "Programs";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.f_slug').'.programs.index', compact('title', 'breadcrumb', 'programs', 'search', 'prevRecords'));
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
    public function show($id, $batchId)
    {
        $user = Auth::guard('faculty')->user();

        $batch = Batch::with([
            'faculties',
            'program' => function($q) use($user) {
                $q->with([
                    'label',
                    'programFeedbacks' => function($q) {
                        $q->where('status', 'active');
                    },
                ]);
            },
        ])->where('status', 'active')->whereDate('start_date', '>', Carbon::now())->where(function($query) { 
            $query->whereHas('program', function ($query) {
                $query->where('status', 'active');
            });
        })->where(function($query) use($user) { 
            // $query->whereDoesntHave('users', function ($query) use($user) {
            //     $query->where('user_id', $user->id);
            // });
        })
        ->find($batchId);
        
        $title = "Program Details";
        return view(config('app.f_slug').'.programs.show', compact('title', 'batch'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
