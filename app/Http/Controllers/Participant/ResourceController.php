<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Models\Program;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function index(Request $request)
    {

        $search = (string)$request->input('search', null);
        $programId = (string)$request->input('program_id');
        $format = (string)$request->input('format');

        $user = Auth::guard('web')->user();

        $resources = Resource::where('status', 'active')
        ->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })
        ->where(function($query) use ($format)  {
            if($format != null) $query->where('format', $format);
        })
        ->where(function($query) use ($programId)  {
            if($programId != null) $query->whereHas('programs', function ($query) use($programId) {
                $query->where('programs.id', $programId);
            });
        })
        ->where(function($query) use ($user)  {
            $query->where('visibility', 'public')
            ->orWhere(function($subQuery) use($user) {  
                $subQuery->whereHas('programs', function ($query) use($user) {
                    $query->where('status', 'active')->where(function($subQuery) use($user) {  
                        $subQuery->whereHas('batches.users', function ($query) use($user) {
                            $query->where('batches.status', 'active')->where('batch_users.status', 'active')->where('users.id', $user->id);
                        });
                    });
                });
            });
        })
        ->paginate(9);

        $programs = Program::where('status', 'active')->where(function($query) use($user) { 
            $query->whereHas('batches.users', function ($query) use($user) {
                $query->where('user_id', $user->id);
            });
        })->select('id', 'name')->orderBy('name', 'asc')->pluck('name', 'id');

        $title = "All Resources";
        return view(config('app.p_slug').'.resources.all', compact('title', 'resources', 'programs', 'search', 'programId', 'format'));
    }

    public function my(Request $request)
    {
        $search = (string)$request->input('search', null);
        $programId = (string)$request->input('program_id');
        $format = (string)$request->input('format');

        $user = Auth::guard('web')->user();

        $resources = Resource::where('status', 'active')
        ->where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })
        ->where(function($query) use ($format)  {
            if($format != null) $query->where('format', $format);
        })
        ->where(function($query) use ($programId)  {
            if($programId != null) $query->whereHas('programs', function ($query) use($programId) {
                $query->where('programs.id', $programId);
            });
        })
        ->where(function($subQuery) use($user) {  
            $subQuery->whereHas('userResources', function ($query) use($user) {
                $query->where('status', 'active')->where('user_id', $user->id);
            });
        })
        ->paginate(9);

        $programs = Program::where('status', 'active')->where(function($query) use($user) { 
            $query->whereHas('batches.users', function ($query) use($user) {
                $query->where('user_id', $user->id);
            });
        })->select('id', 'name')->orderBy('name', 'asc')->pluck('name', 'id');

        $title = "My Resources";
        return view(config('app.p_slug').'.resources.my', compact('title', 'resources', 'programs', 'search', 'programId', 'format'));
    }
}
