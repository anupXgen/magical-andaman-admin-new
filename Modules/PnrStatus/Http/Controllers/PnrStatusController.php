<?php

namespace Modules\PnrStatus\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pnr_status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PnrStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        $data = Pnr_status::orderBy('id', 'DESC')-> where('status',0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('pnr_status.pnr_id', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        return view('pnrstatus::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pnrstatus::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('pnrstatus::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('pnrstatus::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
