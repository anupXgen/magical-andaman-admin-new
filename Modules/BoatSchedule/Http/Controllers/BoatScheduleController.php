<?php

namespace Modules\BoatSchedule\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\BoatSchedule\Entities\BoatSchedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class BoatScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchText = $request->input('search_txt');

        $boat_schedules = DB::table('boat_schedule')
        ->leftJoin('boat_schedule_price', function ($join) {
            $join->on('boat_schedule.id', '=', 'boat_schedule_price.boat_schedule_id')
                 ->whereRaw('boat_schedule_price.id = (select min(id) from boat_schedule_price as bsp where bsp.boat_schedule_id = boat_schedule.id)');
        })
        ->select('boat_schedule.*', 'boat_schedule_price.per_passenger_price');
        if ($searchText) {
            $boat_schedules->where('boat_schedule.title', 'like', '%' . $searchText . '%');
        }
    
        $boat_schedules = $boat_schedules->get();
      
          
             $data = compact('boat_schedules');    
        return view('boatschedule::index')->with($data);
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('boatschedule::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        'from_date' => 'required|date_format:d-m-Y',
        'to_date' => 'required|date_format:d-m-Y',
    ]);

    $checkboxChecked = $request->input('chek_box') === 'Y';

    if ($checkboxChecked) {
        $request->validate([
            'passenger.*' => 'required|numeric|min:1',
        ]);
    }

    $from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
    $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');

    if ($request->has('image')) {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $imageName = time() . '.' . $extension;
        $path = 'uploads/boat/';
        $file->move($path, $imageName);
    }
    $is_chartered_boat = $checkboxChecked ? 'Y' : 'N';

        $boatSchedule = BoatSchedule::create([
            'title' => $request->title,
            'status' => $request->status,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'price' => $request->price,
            'image' => $imageName,
            'is_chartered_boat' => $is_chartered_boat
        ]);
        $lastInsertedId = $boatSchedule->id;

        if ($checkboxChecked) {
            foreach ($request->input('passenger') as $index => $value) {
                DB::table('boat_schedule_price')->insert([
                    'boat_schedule_id' => $lastInsertedId,
                    'no_of_passenger' => $index,
                    'per_passenger_price' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
  

    return redirect()->route('boatschedule.index')->with('success', 'Boat created successfully.');
}


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $boatschedules = DB::table('boat_schedule')->find($id);

        return view('boatschedule::show', compact('boatschedules'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $boatschedules = DB::table('boat_schedule')->find($id);

        $boat_schedule_prices  = DB::table('boat_schedule_price')->where('boat_schedule_id',$id)->get()->toArray();
        if(!empty($boat_schedule_prices) && count($boat_schedule_prices) > 0){
            $charterBoat = '';
        } else {
            $charterBoat = 'd-none';
        }

        return view('boatschedule::edit',compact('boatschedules','boat_schedule_prices', 'charterBoat'));
    }

// public function update(Request $request, $id): RedirectResponse
// {
//     $request->validate([
//         'title' => 'required|string|max:255',
//         'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
//         'from_date' => 'required|date_format:d-m-Y',
//         'to_date' => 'required|date_format:d-m-Y',
//         'price' => [
//             'required',
//             'not_in:0', 
//         ],
//     ]);

//     try {
//         $from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
//         $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
//     } catch (\Exception $e) {
//         return back()->withErrors(['message' => 'Invalid date format. Please ensure the dates are in the format DD-MM-YYYY.']);
//     }

//     $boatSchedule = BoatSchedule::find($id);

//     if (!$boatSchedule) {
//         return back()->withErrors(['message' => 'Boat schedule not found.']);
//     }

//     $boatSchedule->title = $request->title;
//     $boatSchedule->from_date = $from_date;
//     $boatSchedule->to_date = $to_date;
//     $boatSchedule->price = $request->price;

//     // Handle image upload
//     if ($request->hasFile('image')) {
//         // Check if the boat schedule currently has an image
//         if ($boatSchedule->image) {
//             // Construct the path to the current image
//             $oldImagePath = public_path('uploads/boat/' . $boatSchedule->image);
//             // Delete the old image file
//             if (File::exists($oldImagePath)) {
//                 File::delete($oldImagePath);
//             }
//         }

//         // Process the new image upload
//         $file = $request->file('image');
//         $extension = $file->getClientOriginalExtension();
//         $imageName = time() . '.' . $extension;
//         $path = public_path('uploads/boat/');
//         $file->move($path, $imageName);

//         $boatSchedule->image = $imageName;
//     }

//     if ($boatSchedule->save()) {
//         return redirect()->route('boatschedule.index')->with('success', 'Boat updated successfully.');
//     }

//     // Return back with errors if save fails
//     return back()->withErrors(['message' => 'There were some problems with your input. Please try again.']);
// }





    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'from_date' => 'required|date_format:d-m-Y',
            'to_date' => 'required|date_format:d-m-Y',
        ]);

        // Convert dates to Y-m-d format
        try {
            $from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Invalid date format. Please ensure the dates are in the format DD-MM-YYYY.']);
        }
        $boatSchedule = BoatSchedule::find($id);
        if (!$boatSchedule) {
            return back()->withErrors(['message' => 'Boat schedule not found.']);
        }
    
        $boatSchedule->title = $request->title;
        $boatSchedule->from_date = $from_date;
        $boatSchedule->to_date = $to_date;
        $boatSchedule->price = $request->price;
        $boatSchedule->is_chartered_boat = !empty($request->chek_box) ?  'Y' : 'N';

        if ($request->hasFile('image')) {
            if ($boatSchedule->image) {
                $oldImagePath = public_path('uploads/boat/'. $boatSchedule->image);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $imageName = time(). '.'. $extension;
            $path = public_path('uploads/boat/');
            $file->move($path, $imageName);

            $boatSchedule->image = $imageName;
        }

        if ($boatSchedule->save()) {

            DB::table('boat_schedule_price')->where('boat_schedule_id', $id)->delete();

            if($boatSchedule->is_chartered_boat == 'Y'){
                foreach ($request->passenger as $index => $passenger) {
                    DB::table('boat_schedule_price')->insert([
                        'boat_schedule_id' => $id,
                        'no_of_passenger' => $index,
                        'per_passenger_price' => $passenger,
                    ]);
                }
            }
            
            return redirect()->route('boatschedule.index')->with('success', 'Boat updated successfully.');
        } else {
            return back()->withErrors(['success' => 'There were some problems with your input. Please try again.']);
        }
    }








    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $boat_schedule = BoatSchedule::find($id);
    
        if (!is_null($boat_schedule->image)) {
        
            $imagePathInStorage = public_path('uploads/boat/'.$boat_schedule->image);  
            if (file_exists($imagePathInStorage)) {
                unlink($imagePathInStorage);
            }
        }

        $boat_schedule->delete();
    
        return redirect()->route('boatschedule.index')->with('success', 'Boat deleted successfully.');
    }
    
}
