<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;

use App\Models\MentorCoachSession; 

class MentorCoachApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = (string)$request->input('status', 'pending');
        $search = (string)$request->input('search', null);
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $user = Auth::guard('faculty')->user();

        $mentorCoachSessions = MentorCoachSession::with([
            'user',
            'batch',
        ])->where('faculty_id', $user->id)->where(function($query) use ($search)  {
            if($search != null) $query->whereHas('user', function($q) use($search){
                $q->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%');
            }); 
        })->where('status', $status)->latest()->paginate(15);

        $pendingMentorCoachSessionsCount = MentorCoachSession::with([
            'user',
            'batch',
        ])->where('faculty_id', $user->id)->where(function($query) use ($search)  {
            if($search != null) $query->whereHas('user', function($q) use($search){
                $q->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%');
            }); 
        })->where('status', 'pending')->count();

        $completedMentorCoachSessionsCount = MentorCoachSession::with([
            'user',
            'batch',
        ])->where('faculty_id', $user->id)->where(function($query) use ($search)  {
            if($search != null) $query->whereHas('user', function($q) use($search){
                $q->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%');
            }); 
        })->where('status', 'completed')->count();

        $title = "As Mentor Coach";
        return view(config('app.f_slug').'.mentor_coach_approvals.index', compact('title', 'mentorCoachSessions', 'pendingMentorCoachSessionsCount', 'completedMentorCoachSessionsCount', 'search', 'status', 'prevRecords'));
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
        $request->validate([
            'approve_ids' => 'required|array|exists:App\Models\MentorCoachSession,id',
        ]);

        $user = Auth::guard('faculty')->user();

        $mentorCoachSessions = MentorCoachSession::where('faculty_id', $user->id)->where('status', 'pending')->whereIn('id', $request->input('approve_ids'))->update(['status' => 'active']);

        if($mentorCoachSessions){
            $this->response["status"] = true;
            $this->response["message"] = __('strings.successfully_submitted');
        }

        return response()->json($this->response);
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
