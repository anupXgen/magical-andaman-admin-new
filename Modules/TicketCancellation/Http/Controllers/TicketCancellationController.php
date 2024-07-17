<?php

namespace Modules\TicketCancellation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class TicketCancellationController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $type = $request->query('type');
        $dates = $request->query('date');
        $Date = \Carbon\Carbon::parse($dates);

        $query = DB::table('booking as b')
        ->leftJoin('booking_passenger_details as b_p_d', 'b.id', '=', 'b_p_d.booking_id')
        ->where('b_p_d.request_for_cancel','Y');

        if(!empty($type)){
            $query->where('b.type', '=', $type);
        }

        if(!empty($dates)){
            $query->whereDate('b.request_for_cancel_date', '=', $Date);
        }

        $query->where('b.request_for_cancel', 'Y');

        $data['all_datas'] =  $query->get();
  
       // dd($data);

       return view('ticketcancellation::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ticketcancellation::create');
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
        return view('ticketcancellation::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('ticketcancellation::edit');
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
