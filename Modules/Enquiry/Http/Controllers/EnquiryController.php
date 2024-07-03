<?php

namespace Modules\Enquiry\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Enquiry;
use App\Models\Cars;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Enquiry::orderBy('id', 'DESC')->where('status', 0);

        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('enquiries.name', 'LIKE', "%$search%");  
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('enquiry::index', compact('data',))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('enquiry::create');
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
        return view('enquiry::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    { 
        return view('enquiry::edit');
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
