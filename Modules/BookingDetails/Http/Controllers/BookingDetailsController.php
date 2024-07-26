<?php

namespace Modules\BookingDetails\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\BookingDetails\Entities\BookingDetails;
use Illuminate\Support\Facades\DB;
class BookingDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     $search_text = $request->input('search_txt');
   
    //     $perPage = 10;
    //     if($search_text){
    //         $booking_details = BookingDetails::
    //         where('payment_status','success')
    //         ->where('c_name',$search_text)
    //         ->where('c_mobile', $search_text)
    //         ->paginate($perPage);

    //     }
    //     else{
    //         $booking_details = BookingDetails::orderBy('id', 'DESC')
    //         ->where('payment_status','success')
    //         ->paginate($perPage);
    //     }
    

    //     return view('bookingdetails::index',compact('booking_details'))
    //     ->with('i', ($request->input('page', 1) - 1) * $perPage);
    // }
    public function index(Request $request)
{
    $type = $request->input('type');
    $order_id  = $request->input('order_id');
    $date = $request->input('fromDate');
    $pnr = $request->input('pnr_number');
    $perPage = 10;
    
    $booking_details = DB::table('booking')
        ->leftJoin('booking_passenger_details', 'booking.id', '=', 'booking_passenger_details.booking_id')
        ->leftJoin('pnr_status','booking.id','pnr_status.booking_id')
        ->select('booking.*','pnr_status.pnr_id', DB::raw('COUNT(booking_passenger_details.id) as total_passenger_count'), DB::raw("SUM(CASE WHEN booking_passenger_details.request_for_cancel = 'N' THEN 1 ELSE 0 END) as valid_passenger_count"))
        ->where('booking.payment_status', 'success')
        ->groupBy('booking.id')
        ->orderBy('booking.id', 'desc') 
        ->when(!empty($type), function ($query) use ($type) {
            return $query->where('booking.type', $type);
        })
        ->when(!empty($order_id), function ($query) use ($order_id) {
            return $query->where('booking.order_id', $order_id);
        })
        ->when(!empty($pnr), function ($query) use ($pnr) {
            return $query->where('pnr_status.pnr_id', $pnr);
        })
        ->when(!empty($date), function ($query) use ($date) {
            return $query->whereDate('booking.created_at', $date);
        })
        ->paginate($perPage);
    
    return view('bookingdetails::index', compact('booking_details'))
        ->with('i', ($request->input('page', 1) - 1) * $perPage);
    
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
     
        return view('bookingdetails::create');
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
        $booking = DB::table('booking')->where('id',$id)->first();
        $detail  = DB::table('booking_passenger_details')
        ->leftJoin('booking','booking_passenger_details.booking_id','booking.id')
        ->where('booking.id',$id)->get();
        $data = compact('detail','booking');
//dd($detail);
        return view('bookingdetails::show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('bookingdetails::edit');
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
