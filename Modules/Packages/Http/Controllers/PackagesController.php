<?php

namespace Modules\Packages\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Hotels;
use App\Models\Itinerarys;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Custom_packages;
use Modules\Package\Entities\Itinerary;
use App\Models\Activities;
use Modules\SightSeeing\Entities\Sightseeing;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:destination-list|packages-create|packages-edit|packages-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:packages-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:packages-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:packages-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Custom_packages::orderBy('id', 'DESC')->with('Package_booking_details')->get();
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('custom_packages.date_of_journey', 'LIKE', "%$search%");
        }

        $users_dropdown = User::orderBy('id', 'DESC')->where('status', 0)->where('delete', 0)->get();
       // $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());

        // echo "<pre>";
        // print_r($users_dropdown->toArray());
        // die();
        return view('packages::index', compact('data', 'users_dropdown'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('packages::create');
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
        return view('packages::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $data = Custom_packages::with('custom_package_activity', 'custom_package_hotel', 'custom_package_sighseeing', 'car' )->where('id', $id)->first()->toArray();

        $packageItinerary = Itinerarys::where(['package_id' => $data['package_id'], 'status' => 0])->orderBy('itinerary_day', 'ASC')->get()->toArray();

        $packageIti = array();

        // dd($data);
       
        foreach($data['custom_package_activity'] as $value){
            $packageIti[$value['itinerary_day']]['activity'][] = Activities::find($value['activity_id']);
        }

        foreach($data['custom_package_sighseeing'] as $value){
            $packageIti[$value['itinerary_day']]['sightseeing'] = Sightseeing::find($value['sightseeing_id']);
        }

        foreach($data['custom_package_hotel'] as $value){
            $packageIti[$value['itinerary_day']]['hotel']['hotel_id'] = Hotels::find($value['hotel_id']);
            $packageIti[$value['itinerary_day']]['hotel']['meal'] = $value['meal'];
            $packageIti[$value['itinerary_day']]['hotel']['flower_bed_decoration'] = $value['flower_bed_decoration'];
            $packageIti[$value['itinerary_day']]['hotel']['candle_light_dinner'] = $value['candle_light_dinner'];
            $packageIti[$value['itinerary_day']]['hotel']['extra_person_with_mattres'] = $value['extra_person_with_mattres'];
            $packageIti[$value['itinerary_day']]['hotel']['extra_person_without_mattres'] = $value['extra_person_without_mattres'];
        }

        // echo "<pre>";
        // print_r($packageIti);
        // die();

        return view('packages::itinerary_view', compact('packageIti','data'));
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
        Custom_packages::find($id)->update(array('delete' => '1'));
       
        return redirect()->route('packages.index')
            ->with('success', 'Custom Packages deleted successfully');
    }
    public function logout($id)
    {
        Custom_packages::find($id)->update(array('delete' => '1'));
       
        return redirect()->route('packages.index')
            ->with('success', 'Custom Packages deleted successfully');
    }
}
