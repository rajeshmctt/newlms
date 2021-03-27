<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;

use App\Models\Batch; 
use App\Models\User; 
use App\Models\BatchUser; 

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = (string)$request->input('status', 'active');
        $search = (string)$request->input('search', null);
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $user = Auth::guard('faculty')->user();

        $batchUsers = BatchUser::with([
            'user',
            'batch' => function($q){
                $q->withCount([
                    'assignments'
                ]);
            }
        ])->whereHas('batch.faculties', function($q) use($user){
            $q->where('faculty_id', $user->id);
        })->where(function($query) use ($search)  {
            if($search != null) $query->whereHas('user', function($q) use($search){
                $q->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%');
            }); 
        })->where(function($query) use ($status)  {
            $query->whereHas('batch', function($query) use ($status){
                $query->where('status', $status);
            });
        })->latest()->paginate(15);

        $activeBatchUsersCount = BatchUser::with([
            'user',
            'batch' => function($q){
                $q->withCount([
                    'assignments'
                ]);
            }
        ])->whereHas('batch.faculties', function($q) use($user){
            $q->where('faculty_id', $user->id);
        })->where(function($query) use ($search)  {
            if($search != null) $query->whereHas('user', function($q) use($search){
                $q->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%');
            }); 
        })->where(function($query) use ($status)  {
            $query->whereHas('batch', function($query) use ($status){
                $query->where('status', 'active');
            });
        })->count();

        $completedBatchUsersCount = BatchUser::with([
            'user',
            'batch' => function($q){
                $q->withCount([
                    'assignments'
                ]);
            }
        ])->whereHas('batch.faculties', function($q) use($user){
            $q->where('faculty_id', $user->id);
        })->where(function($query) use ($search)  {
            if($search != null) $query->whereHas('user', function($q) use($search){
                $q->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%');
            }); 
        })->where(function($query) use ($status)  {
            $query->whereHas('batch', function($query) use ($status){
                $query->where('status', 'completed');
            });
        })->count();

        $title = "As Faculty";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.f_slug').'.users.index', compact('title', 'breadcrumb', 'batchUsers', 'activeBatchUsersCount', 'completedBatchUsersCount', 'search', 'status', 'prevRecords'));
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
    public function show(Request $request, $id)
    {
        $user = Auth::guard('faculty')->user();

        $pUser = User::find($id);
        
        $title = "Participant Details";
        return view(config('app.f_slug').'.users.show', compact('title', 'pUser'));
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
