<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Models\Currency; 

class CurrencyController extends Controller
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

        $currencies = Currency::where(function($query) use ($search)  {
            if($search != null) $query->where('name', 'like', '%'.$search.'%');
        })->paginate(15);
        $title = "Currencies";
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.currencies.index', compact('title', 'breadcrumb', 'currencies', 'search', 'prevRecords'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Currency";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.currencies.index'), 'text' => "Currencies"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.currencies.create', compact('title', 'breadcrumb'));
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
            'name' => 'required|max:64|unique:App\Models\Currency,name,NULL,id,deleted_at,NULL',
            'code' => 'required|max:16|unique:App\Models\Currency,code,NULL,id,deleted_at,NULL',
        ]);

        $currency = new Currency($request->all());
        $currency->status = 'active';
        $currency->save();

        return redirect()->route(config('app.a_slug').'.currencies.index')->with('success', __('strings.store_success'));
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
        $currency = Currency::find($id);

        $title = "Edit Currency";
        $breadcrumb[] = ['link' => route(config('app.a_slug').'.currencies.index'), 'text' => "Currencies"];
        $breadcrumb[] = ['link' => null, 'text' => $title];
        return view(config('app.a_slug').'.currencies.edit', compact('title', 'breadcrumb', 'currency')); 
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
            'name' => 'required|max:64|unique:App\Models\Currency,name,'.$id.',id,deleted_at,NULL',
            'code' => 'required|max:64|unique:App\Models\Currency,code,'.$id.',id,deleted_at,NULL',
            'status' => 'required|in:active,inactive',
        ]);

        $currency = Currency::find($id);
        $currency->fill($request->only(['name', 'code', 'status']));
        $currency->update();

        return redirect()->route(config('app.a_slug').'.currencies.index')->with('success', __('strings.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currency = Currency::find($id);
        if (
            $currency->programs()->count()
            || $currency->payments()->count()
            || $currency->invoices()->count()
        ) {
            return back()->with('error', __('strings.destroy_failed'));
        }
        $currency->delete();

        return back()->with('success', __('strings.destroy_success'));
    }
}
