<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\BatchUser; 
use App\Models\CertificationLevel; 

use App\Exports\ListOfParticipantsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function list_of_participants(Request $request)
    {
        $search = (string)$request->input('search', null);
        $currentPage = (int)$request->input('page', 0);
        $prevRecords = $currentPage > 0 ? (($currentPage-1) * 15) : 0;

        $pUsers = BatchUser::where(function($query) use ($search)  {
            if($search != null) $query->whereHas('user', function($query) use($search){
                $query->where('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%');
            });
        })->with([
            'user' => function($q){
                $q->with([
                    'country',
                    'location',
                    'currentRole',
                    'currentFunction',
                ]);
            },
            'batch' => function($q){
                $q->with([
                    'program'
                ]);
            }
        ])->whereNull('parent_batch_id')->sortable()->paginate(15);

        $title = "List of Participants";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.reports.list_of_participants', compact('title', 'breadcrumb', 'search', 'pUsers', 'prevRecords'));
    }


    public function list_of_participants_export(Request $request)
    {
        return Excel::download(new ListOfParticipantsExport, 'ListOfParticipants.xlsx');
    }
}
