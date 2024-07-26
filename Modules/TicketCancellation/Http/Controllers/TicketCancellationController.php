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
        // $dates = $request->query('date');
        // $Date = \Carbon\Carbon::parse($dates);

        $query = DB::table('booking as b')
         ->leftJoin('booking_passenger_details as b_p_d', 'b.id', '=', 'b_p_d.booking_id')
        ->select('b.id', 'b.order_id', 'b.type', 'b.c_name', 'b.c_mobile', 'b.departure_time', 'b.arrival_time', 'b.ship_name', 'b.date_of_jurney','b.from_location','b.to_location') 
        ->where('b_p_d.request_for_cancel', 'Y') 
       // ->where('b.request_for_cancel', 'Y') 
        ->where('b.payment_status', 'success'); 
       
        if(!empty($type)){
            $query->where('b.type', '=', $type);
        }

        $query->groupBy(['b.id']);

        // if(!empty($dates)){
        //     $query->whereDate('b.request_for_cancel_date', '=', $Date);
        // }

        // $query->where('b.request_for_cancel', 'Y');

        $data['all_datas'] =  $query->get();
      

    //print_r($data['all_datas']->toArray());die;
  
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
       
        
        // $querys = DB::table('booking_passenger_details as b_p_d')
        // ->where('b_p_d.request_for_cancel','Y')
        // ->where('b_p_d.is_canceled', Null)
        // ->where('b_p_d.booking_id',$id)
        // ->get();

        // $bookings = DB::table('booking')
        // ->where('id',$id)
        // ->first();

        // $data = compact('querys','bookings');
        // return view('ticketcancellation::show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
         
        $querys = DB::table('booking_passenger_details as b_p_d')
        ->where('b_p_d.request_for_cancel','Y')
        ->where('b_p_d.is_canceled', 'N')
        ->where('b_p_d.booking_id',$id)
        ->get();

        $bookings = DB::table('booking')
        ->where('id',$id)
        ->first();

        $data = compact('querys','bookings');

        return view('ticketcancellation::edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
  
        $updateData = DB::table('booking_passenger_details as b_p_d')
        ->where('b_p_d.booking_id', $id) 
        ->update(['b_p_d.is_canceled' => 'Y']);

        return redirect()->route('ticketcancellation.index')->with('success', 'Your Request is Successfully Canceled');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

    
    }
}
