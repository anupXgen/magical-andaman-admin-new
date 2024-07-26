<?php

namespace Modules\FerrySchedule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Session;
use Auth;

class FerryScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTxt = $request->input('search_txt');
        $perPage = 5; 

        $query = DB::table('ferry_schedule as fs')
        ->leftJoin('ferry_locations as fl_from', 'fl_from.id', '=', 'fs.from_location')
        ->leftJoin('ferry_locations as fl_to', 'fl_to.id', '=', 'fs.to_location')
        ->leftJoin('ship_master as sm', 'sm.id', '=', 'fs.ship_id')
        ->where('fs.status','=','Y')
        ->orderBy('id','desc')
        ->select(
            'fs.*',
            'fl_from.title as from_location_title',
            'fl_to.title as to_location_title',
            'sm.title as ship_master_title'
        );
        if ($searchTxt) {
            $query->where(function ($q) use ($searchTxt) {
                $q->where('fl_from.title', 'LIKE', "%{$searchTxt}%")
                    ->orWhere('fl_to.title', 'LIKE', "%{$searchTxt}%")
                    ->orWhere('sm.title', 'LIKE', "%{$searchTxt}%");
            });
        }

        $ferry_schedules = $query->paginate($perPage);
        
        return view('ferryschedule::index', compact('ferry_schedules'))
        ->with('i', ($request->input('page', 1) - 1) * $perPage);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ferry_locations = DB::table('ferry_locations')->get();
        $ship_master = DB::table('ship_master')->get();
        $ship_classes = DB::table('ship_classes')->get();
        $data = compact('ferry_locations','ship_master','ship_classes');
        return view('ferryschedule::create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
       
        $validatedData = $request->validate([
            'from_date' => 'required|date_format:d-m-Y',
            'to_date' => 'required|date_format:d-m-Y',
            'form_location' => 'required',
            'to_location' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required',
            'ship_master' =>'required',
            'class_id.*' =>'required',
            'price.*' =>'required|numeric',
            

        ]);
        $from_date = trim($request->from_date);
        $to_date = trim($request->to_date);
    
        try {
            $from_date_parsed = Carbon::createFromFormat('d-m-Y', $from_date)->format('Y-m-d');
            $to_date_parsed = Carbon::createFromFormat('d-m-Y', $to_date)->format('Y-m-d');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Invalid date format. Please use dd-mm-yy format.']);
        }
        $ferrySchedule = DB::table('ferry_schedule')->insertGetId([
            'from_location' => $request->form_location,
            'to_location' => $request->to_location,
            'from_date' => $from_date_parsed,
            'to_date' => $to_date_parsed,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'ship_id' => $request->ship_master,
        ]);

        $prices = [];
        foreach ($request->price as $key => $price) {
            $prices[] = [
                'schedule_id' => $ferrySchedule,
                'class_id' => $request->class_id[$key],
                'price' => $price,
            ];
        }
        DB::table('ferry_schedule_price')->insert($prices);


        return redirect()->route('ferryschedule.index')
        ->with('success', 'ferryschedule created successfully');
      
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $ferry_schedule = DB::table('ferry_schedule as fs')
        ->leftJoin('ferry_locations as fl_from', 'fl_from.id', '=', 'fs.from_location')
        ->leftJoin('ferry_locations as fl_to', 'fl_to.id', '=', 'fs.to_location')
        ->leftJoin('ship_master as sm', 'sm.id', '=', 'fs.ship_id')
        ->select('fs.*', 'fl_from.title as from_location_title', 'fl_to.title as to_location_title', 'sm.title as ship_master_title')
        ->where('fs.id', $id)
        ->first();
        $data = compact('ferry_schedule');
        return view('ferryschedule::show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    $ferry_schedule = DB::table('ferry_schedule')->where('id', $id)->first();

    $ferry_locations = DB::table('ferry_locations')->get();

    $ferry_schedule_price = DB::table('ferry_schedule_price')->where('schedule_id', $id)->get();

    $ship_masters = DB::table('ship_master')->get();
    $ship_classes =DB::table('ship_classes')->get();

    $data = compact('ferry_schedule','ferry_locations','ship_masters','ship_classes', 'ferry_schedule_price');
   
        
        return view('ferryschedule::edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $ferry_schedule = DB::table('ferry_schedule')
        ->where('id', $id)
        ->first();

        if (!$ferry_schedule) {
            return redirect()->back()->with('error', 'Ferry Schedule not found.');
        }
        DB::table('ferry_schedule')
        ->where('id', $id)
        ->update([
            'from_location' => $request->form_location,
            'to_location' => $request->to_location,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'ship_id' => $request->ship_master,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->arrival_time,
            'status'       =>$request->status
            
        ]);
        
        $existingPrices = DB::table('ferry_schedule_price')
        ->where('schedule_id', $ferry_schedule->id)
        ->pluck('id');

    DB::table('ferry_schedule_price')->whereIn('id', $existingPrices)->delete();

    $newPrices = [];
    foreach ($request->price as $key => $price) {
        $newPrices[] = [
            'schedule_id' => $ferry_schedule->id,
            'class_id' => $request->class_id[$key],
            'price' => $price,
        ];
    }
    DB::table('ferry_schedule_price')->insert($newPrices);

        return redirect()->route('ferryschedule.index')->with('success', 'Ferry Schedule updated successfully.');
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
      
    $ferry_schedule = DB::table('ferry_schedule')->where('id', $id)->first();


    if (!$ferry_schedule) {
        return redirect()->route('ferryschedule.index')->with('error', 'Ferry Schedule not found.');
    }


    DB::table('ferry_schedule')->where('id', $id)->update(['status' => 'D']);


    return redirect()->route('ferryschedule.index')->with('success', 'Ferry Schedule deleted successfully.');
    }
}
