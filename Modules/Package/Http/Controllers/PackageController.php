<?php

namespace Modules\Package\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Hotel_category;
use App\Models\Hotels;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Package\Entities\Package;
use Modules\Package\Entities\Packageimage;
use Modules\Package\Entities\Packagestyle;
use Modules\Package\Entities\Itinerary;
use Modules\Package\Entities\Itineraryimage;
use Modules\Package\Entities\Packagefeature;
use Modules\Package\Entities\Policy;
use Modules\Package\Entities\Typeprice;
use Modules\Package\Entities\Typepriceimage;
use Modules\Package\Entities\Packagetype;
use Modules\Package\Entities\Packagehotel;
use Modules\Hotel\Entities\Hotel;
use Modules\Package\Entities\Packagesightseeing;
use Modules\Package\Entities\Packageactivity;
//use Modules\Hotel\Entities\Hotelimage;
//use Modules\Hotel\Entities\Room;
//use Modules\Hotel\Entities\Roomimage;
use Modules\Activity\Entities\Activity;
use Modules\SightSeeing\Entities\Sightseeing;

use Modules\Destination\Entities\Destination;
use File;
use DB;

class PackageController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:package-list|package-create|package-edit|package-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:package-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:package-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:package-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Package::orderBy('id', 'DESC')->where('delete', 0)->where('status', 0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('packages.title', 'LIKE', "%$search%");
            $data->orwhere('packages.subtitle', 'LIKE', "%$search%");
        }
      
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('package::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }
    public function create()
    {
        $data['packageStyle'] = DB::table('package_styles_master')->where('status', 0)->get();
        return view('package::create', $data);
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'days' => 'required',
            'nights' => 'required',
            'package_img' => 'required',
            'package_style' => 'required'
        ]);
        $input = $request->all();


        // print_r($request->package_style);die;

        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['day'] = $input['days'];
        $insertarray['night'] = $input['nights'];
        //echo "<pre>";print_r($input);print_r($insertarray);die;
        $result = Package::create($insertarray);
        $inserted_id = $result->id;
        if ($result) {

            $featurearray['parent_id'] = $inserted_id;
            $featurearray['night_stay'] = !empty($input['feature_night_stay']) ? $input['feature_night_stay'] : 0;
            $featurearray['transport'] = !empty($input['feature_transport']) ? $input['feature_transport'] : 0;
            $featurearray['activity'] = !empty($input['feature_activity']) ? $input['feature_activity'] : 0;
            $featurearray['ferry'] = !empty($input['feature_ferry']) ? $input['feature_ferry'] : 0;
            Packagefeature::create($featurearray);


            foreach ($request->package_style as $styleId) {
                $stylearray = [
                    'package_id' => $inserted_id,
                    'package_style_id' => $styleId,
                ];
            
                Packagestyle::create($stylearray);
            }
            

            $path2 = public_path('uploads\package');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            if (!empty($request->input('package_img', []))) {
                foreach ($request->input('package_img', []) as $file) {
                    $old_path = public_path('uploads\tmp') . '\\' . $file;
                    $new_path = public_path('uploads\package') . '\\' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $inserted_id;
                    $insertimage['path'] = 'uploads/package/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    packageimage::create($insertimage);
                }
            }
            if (!empty($request->input('remove_package_img', []))) {
                foreach ($request->input('remove_package_img', []) as $deletefile) {
                    $image_path = public_path('uploads\package') . '\\' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
        }
        if ($input['redirectTo'] == 'itinerary') {
            return redirect('package/itinerary/' . $inserted_id)
                ->with('success', 'package created successfully');
        } else if ($input['redirectTo'] == 'policy') {
            return redirect('package/policy/' . $inserted_id)
                ->with('success', 'package created successfully');
        } else if ($input['redirectTo'] == 'typeprice') {
            return redirect('package/typeprice/' . $inserted_id)
                ->with('success', 'package created successfully');
        } else if ($input['redirectTo'] == 'hotel') {
            return redirect('package/hotel/' . $inserted_id)
                ->with('success', 'package created successfully');
        } else if ($input['redirectTo'] == 'sightseeinge') {
            return redirect('package/sightseeinge/' . $inserted_id)
                ->with('success', 'package created successfully');
        } else if ($input['redirectTo'] == 'activity') {
            return redirect('package/activity/' . $inserted_id)
                ->with('success', 'package created successfully');
        } else {
            return redirect('package/itinerary/' . $inserted_id)
                ->with('success', 'package created successfully');
            // return redirect()->route('package.index')
            //     ->with('success', 'package created successfully');
        }
    }
    public function show($id)
    {
        $package = Package::with(['packageimage', 'packagestyle', 'packagefeature', 'policy'])->with('itinerary', function ($query) {
            $query->with('itineraryimage');
        })->with('typeprice', function ($query) {
            $query->with('packagetype');
            $query->with('typepriceimage');
        })->with('packagehotel', function ($query) {
            $query->with('hotel', function ($query) {
                $query->with('location');
            });
        })->with('packagesightseeing', function ($query) {
            $query->with('sightseeing_pkg', function ($query) {
                $query->with('location');
            });
        })->with('packageactivity', function ($query) {
            $query->with('activity');
        })->find($id)->toArray();
        // echo "<pre>";
        // print_r($package);
        // die;
        foreach($package['packagestyle'] as $row){
            $packageStyleId[] = $row['package_style_id'];
        }
        
        $packageStyle = DB::table('package_styles_master')->where('status', 0)->get();
        return view('package::show', compact('package', 'packageStyle', 'packageStyleId'));
    }
    public function edit($id)
    {
        $package = Package::with(['packageimage', 'packagestyle', 'packagefeature', 'policy'])->with('itinerary', function ($query) {
            $query->with('itineraryimage');
        })->with('typeprice', function ($query) {
            $query->with('packagetype');
            $query->with('typepriceimage');
        })->with('packagehotel', function ($query) {
            $query->with('hotel', function ($query) {
                $query->with('location');
            });
        })->with('packagesightseeing', function ($query) {
            $query->with('sightseeing_pkg', function ($query) {
                $query->with('location');
            });
        })->with('packageactivity', function ($query) {
            $query->with('activity');
        })->find($id)->toArray();
        // echo "<pre>";print_r($package);die;

        
        foreach($package['packagestyle'] as $row){
            $packageStyleId[] = $row['package_style_id'];
        }
        

        $packageStyle = DB::table('package_styles_master')->where('status', 0)->get();
        return view('package::edit', compact('package' ,'packageStyle', 'packageStyleId'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'days' => 'required',
            'nights' => 'required',
        ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['day'] = $input['days'];
        $insertarray['night'] = $input['nights'];
        $result = Package::find($id)->update($insertarray);
        if ($result) {

            $featurearray['parent_id'] = $id;
            $featurearray['night_stay'] = !empty($input['feature_night_stay']) ? $input['feature_night_stay'] : 0;
            $featurearray['transport'] = !empty($input['feature_transport']) ? $input['feature_transport'] : 0;
            $featurearray['activity'] = !empty($input['feature_activity']) ? $input['feature_activity'] : 0;
            $featurearray['ferry'] = !empty($input['feature_ferry']) ? $input['feature_ferry'] : 0;
            Packagefeature::where('parent_id', $id)->update($featurearray);

            Packagestyle::where('package_id', $id)->delete();

            foreach ($request->package_style as $styleId) {
                $stylearray = [
                    'package_id' => $id,
                    'package_style_id' => $styleId,
                ];
            
                Packagestyle::create($stylearray);
            }
          
            // $stylearray['package_style_id'] = !empty($input['package_style_id']) ? $input['package_style_id'] : 0;
            // Packagestyle::where('package_id', $id)->update($stylearray);

            $path2 = public_path('uploads\package');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            if (!empty($request->input('package_img', []))) {
                foreach ($request->input('package_img', []) as $file) {
                    $old_path = public_path('uploads\tmp') . '\\' . $file;
                    $new_path = public_path('uploads\package') . '\\' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $id;
                    $insertimage['path'] = 'uploads/package/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    packageimage::create($insertimage);
                }
            }
            if (!empty($request->input('exists_remove_package_img', []))) {
                foreach ($request->input('exists_remove_package_img', []) as $key => $existsdeletefile) {
                    $image_path = public_path('uploads\package') . '\\' . $existsdeletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                        packageimage::where('id', $key)->where('parent_id', $id)->delete();
                    }
                }
            }
            if (!empty($request->input('remove_package_img', []))) {
                foreach ($request->input('remove_package_img', []) as $deletefile) {
                    $image_path = public_path('uploads\package') . '\\' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
        }
        return redirect()->route('package.index')
            ->with('success', 'Package created successfully');
    }

    public function addItinerary($id)
    {
        // $package = Package::with('itinerary', function ($query) {$query->with('itineraryimage'); })->find($id);
        $package = Package::with(['packageimage', 'packagestyle', 'packagefeature'])->with('itinerary', function ($query) {
            $query->with('itineraryimage');
        })->find($id);

        if ($package) {

            foreach($package['packagestyle'] as $row){
                $packageStyleId[] = $row['package_style_id'];
            }
            $sightseeeing_id= Sightseeing::where('status', 0)->get();
            $hotel_id= Hotels::where('status', 0)->get();
            $hotel_category= Hotel_category::where('status', 0)->where('delete', 0)->get();
            $activity_id= Activity::where('status', 0)->get();
            $packageStyle = DB::table('package_styles_master')->where('status', 0)->get();
            $locations = Destination::where('status', 0)->where('delete', 0)->get();
            $package = $package->toArray();
            //echo "<pre>";print_r($package);die;
            return view('package::itinerary', compact('package', 'packageStyle', 'packageStyleId','sightseeeing_id', 'hotel_id', 'activity_id', 'locations', 'hotel_category'));
        } else {
            return redirect()->route('package.index')
                ->with('error', 'Something went wrong');
        }
    }
    
    public function storeItinerary(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'itinerary_day.*' => 'required',
            'package_id' => 'required',
            'location_id.*' => 'required',
            'sightseeing_id.*' => 'required',
            'hotel_id.*' => 'required',
            'hotel_category.*' => 'required',
            'activity_id.*' => 'required',
            'itinerary_title.*' => 'required',
            'itinerary_subtitle.*' => 'required'
        ]);
        $input = $request->all();
      
       
        foreach ($input['itinerary_id'] as $key => $val) {

            $insert_itinerary = [];

            $itinery_day= $input['itinerary_day'][$key];
            $itinery_day_replace=str_replace('Day ', '',  $itinery_day);

            $insert_itinerary['package_id'] = $input['package_id'];
            $insert_itinerary['location_id'] = $input['location_id'][$key];
            $insert_itinerary['sightseeing_id'] = $input['sightseeing_id'][$key];
            $insert_itinerary['hotel_id'] = $input['hotel_id'][$key];
            $insert_itinerary['hotel_category'] = $input['hotel_category'][$key];
            $insert_itinerary['activity_id'] = $input['activity_id'][$key];
            $insert_itinerary['itinerary_day'] =  $itinery_day_replace;
            $insert_itinerary['title'] = $input['itinerary_title'][$key];
            $insert_itinerary['subtitle'] = $input['itinerary_subtitle'][$key];

            $insert_itinerary = Itinerary::create($insert_itinerary);
        }

        return redirect()->route('package.edit', $id)
            ->with('success', 'Package created successfully');
    
    }
    
    public function addPolicy($id)
    {
        $package = Package::with(['packageimage', 'packagestyle', 'packagefeature', 'policy'])->find($id);
        if ($package) {
            $package = $package->toArray();
            //echo "<pre>";print_r($package);die;
            return view('package::policy', compact('package'));
        } else {
            return redirect()->route('package.index')
                ->with('error', 'Something went wrong');
        }
    }
    public function storePolicy(Request $request, $id)
    {
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        if (!empty($input['policy_title'])) {
            foreach ($input['policy_title'] as $key => $val) {
                $insertarray['title'] = $val;
                $insertarray['subtitle'] = $input['policy_subtitle'][$key];
                if (!empty($input['policy_id'][$key]) && $input['policy_id'][$key] != 0) {
                    $resultpolicy = Policy::where('id', $input['policy_id'][$key])->where('package_id', $id)->update($insertarray);
                } else {
                    $insertarray['package_id'] = $id;
                    $resultpolicy = Policy::create($insertarray);
                }
            }
        }
        return redirect()->route('package.edit', $id)
            ->with('success', 'Package created successfully');
    }

    public function addTypeprice($id)
    {
        $package = Package::with(['packageimage', 'packagestyle', 'packagefeature'])->with('typeprice', function ($query) {
            $query->with('typepriceimage');
        })->find($id);
        if ($package) {
            $package = $package->toArray();
            $packagetypes = Packagetype::where('status', 0)->where('delete', 0)->get()->toArray();
            $hotels = Hotel::orderBy('id', 'DESC')->where('delete', 0)->where('status', 0)->get()->toArray();
            //echo "<pre>";print_r($packagetypes);die;
            return view('package::typeprice', compact('package', 'packagetypes'));
        } else {
            return redirect()->route('package.index')
                ->with('error', 'Something went wrong');
        }
    }
    public function storeTypeprice(Request $request, $id)
    {
        // $request->validate([
        //     'title' => 'required',
        // ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        if (!empty($input['typeprice_type'])) {
            foreach ($input['typeprice_type'] as $key => $val) {
                $insertarray['type_id'] = $val;
                $insertarray['subtitle'] = $input['typeprice_subtitle'][$key];
                $insertarray['cp_plan'] = $input['typeprice_cpplan'][$key];
                $insertarray['map_with_dinner'] = $input['typeprice_mapdinner'][$key];
                $insertarray['actual_price'] = $input['typeprice_actualprice'][$key];
                if (!empty($input['typeprice_id'][$key]) && $input['typeprice_id'][$key] != 0) {
                    $resulttypeprice = Typeprice::where('id', $input['typeprice_id'][$key])->where('package_id', $id)->update($insertarray);
                    $typeprice_id = $input['typeprice_id'][$key];
                } else {
                    $insertarray['package_id'] = $id;
                    $resulttypeprice = Typeprice::create($insertarray);
                    $typeprice_id = $resulttypeprice->id;
                }
                if ($typeprice_id) {
                    $pathtypeprice2 = public_path('uploads\package\typeprice');
                    if (!file_exists($pathtypeprice2)) {
                        mkdir($pathtypeprice2, 0777, true);
                    }
                    if (!empty($request->input('typepriceimage' . $key . '_img', []))) {
                        //echo 12;die;
                        foreach ($request->input('typepriceimage' . $key . '_img', []) as $file) {
                            $old_path = public_path('uploads\tmp') . '\\' . $file;
                            $new_path = public_path('uploads\package\typeprice') . '\\' . $file;
                            $move = File::move($old_path, $new_path);
                            $insertimage['parent_id'] = $typeprice_id;
                            $insertimage['path'] = 'uploads/package/typeprice/' . $file;
                            $insertimage['size'] = filesize($new_path);
                            Typepriceimage::create($insertimage);
                        }
                    }
                    if (!empty($request->input('exists_remove_typepriceimage' . $key . '_img', []))) {
                        foreach ($request->input('exists_remove_typepriceimage' . $key . '_img', []) as $key => $existsdeletefile) {
                            $image_path = public_path('uploads\package\typeprice') . '\\' . $existsdeletefile;
                            if (File::exists($image_path)) {
                                File::delete($image_path);
                                Typepriceimage::where('id', $key)->where('parent_id', $typeprice_id)->delete();
                            }
                        }
                    }
                    if (!empty($request->input('remove_typepriceimage' . $key . '_img', []))) {
                        foreach ($request->input('remove_typepriceimage' . $key . '_img', []) as $deletefile) {
                            $image_path = public_path('uploads\package\typeprice') . '\\' . $deletefile;
                            if (File::exists($image_path)) {
                                File::delete($image_path);
                            }
                        }
                    }
                }
            }
        }
        return redirect()->route('package.edit', $id)
            ->with('success', 'Type & Price added to package successfully');
    }
    public function addHotel($id)
    {
        $package = Package::with(['packageimage', 'packagestyle', 'packagefeature', 'packagehotel'])->with('typeprice', function ($query) {
            $query->with('typepriceimage');
        })->find($id);
        if ($package) {
            $package = $package->toArray();
            //echo "<pre>";print_r($package);die;
            // $hotel = Hotel::with(['hotelimage'])->with('location')->with('room', function ($query) {
            //     $query->with('roomimage');
            // })->get()->toArray();
            $location = Destination::with(['packagehotellocation'])->where('status', 0)->where('delete', 0)->get()->toArray();
            //echo "<pre>";print_r($location);die;
            return view('package::hotel', compact('package', 'location'));
        } else {
            return redirect()->route('package.index')
                ->with('error', 'Something went wrong');
        }
    }
    public function storeHotel(Request $request, $id)
    {
        // $request->validate([
        //     'title' => 'required',
        // ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        if (!empty($input['location'])) {
            foreach ($input['location'] as $key => $val) {
                $insertarray['location_id'] = $val;
                $insertarray['hotel_id'] = $input['hotel'][$key];
                if (!empty($input['hotel_id'][$key]) && $input['hotel_id'][$key] != 0) {
                    $resulttypeprice = Packagehotel::where('id', $input['hotel_id'][$key])->where('package_id', $id)->update($insertarray);
                    $typeprice_id = $input['hotel_id'][$key];
                } else {
                    $insertarray['package_id'] = $id;
                    $resulttypeprice = Packagehotel::create($insertarray);
                    $typeprice_id = $resulttypeprice->id;
                }
            }
        }
        return redirect()->route('package.edit', $id)
            ->with('success', 'Type & Price added to package successfully');
    }
    public function hotelByLocation($id)
    {
        $hotel = Hotel::with(['hotelimage'])->with('location')->with('room', function ($query) {
            $query->with('roomimage');
        })->where('location_id', $id)->get()->toArray();
        if (!empty($hotel)) {
            $html = '<option value="0">Select Hotel</option>';
            foreach ($hotel as $key => $val) {
                $html = $html . '<option value="' . $val['id'] . '">' . $val['title'] . '</option>';
            }
        } else {
            $html = '<option value="0">No Hotel Found</option>';
        }
        echo $html;
    }
    public function sightseeingByLocation($id)
    {
        $sightseeing = Sightseeing::with(['sightseeingimage'])->with('location')->where('location_id', $id)->get()->toArray();
        if (!empty($sightseeing)) {
            $html = '<option value="0">Select Sight Seeing</option>';
            foreach ($sightseeing as $key => $val) {
                $html = $html . '<option value="' . $val['id'] . '">' . $val['title'] . '</option>';
            }
        } else {
            $html = '<option value="0">No Sight Seeing Found</option>';
        }
        echo $html;
    }
    public function activityByLocation($id)
    {

        $activities = Activity::with(['activityimage'])->with('location')->where('location_id', $id)->get()->toArray();
       
        if (!empty($activities)) {
            $html = '<option value="0">Select Activity</option>';
            foreach ($activities as $key => $val) {
                $html = $html . '<option value="' . $val['id'] . '">' . $val['title'] . '</option>';

            }
        } else {
            $html = '<option value="0">No Activity Found</option>';
        }
        echo $html;
    }
    public function addSightseeing($id)
    {
        $package = Package::with(['packageimage', 'packagestyle', 'packagefeature', 'packagehotel', 'packagesightseeing'])->with('typeprice', function ($query) {
            $query->with('typepriceimage');
        })->find($id);

              //echo "<pre>";print_r($package->toArray());die;
        if ($package) {
            $package = $package->toArray();
            //echo "<pre>";print_r($package);die;
            // $hotel = Hotel::with(['hotelimage'])->with('location')->with('room', function ($query) {
            //     $query->with('roomimage');
            // })->get()->toArray();
            $location = Destination::with(['packagesightseeinglocation'])->where('status', 0)->where('delete', 0)->get()->toArray();
            
            return view('package::sightseeing', compact('package', 'location'));
        } else {
            return redirect()->route('package.index')
                ->with('error', 'Something went wrong');
        }
    }
    public function storeSightseeing(Request $request, $id)
    {
        // $request->validate([
        //     'title' => 'required',
        // ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        if (!empty($input['location'])) {
            foreach ($input['location'] as $key => $val) {
                $insertarray['location_id'] = $val;
                $insertarray['sightseeing_id'] = $input['sightseeing'][$key];
                if (!empty($input['sightseeing_id'][$key]) && $input['sightseeing_id'][$key] != 0) {
                    $resulttypeprice = Packagesightseeing::where('id', $input['sightseeing_id'][$key])->where('package_id', $id)->update($insertarray);
                    $typeprice_id = $input['sightseeing_id'][$key];
                } else {
                    $insertarray['package_id'] = $id;
                    $resulttypeprice = Packagesightseeing::create($insertarray);
                    $typeprice_id = $resulttypeprice->id;
                }
            }
        }
        return redirect()->route('package.edit', $id)
            ->with('success', 'Type & Price added to package successfully');
    }
    public function addActivity($id)
    {
        $package = Package::with(['packageimage', 'packagestyle', 'packagefeature', 'packagehotel', 'packagesightseeing', 'packageactivity'])->with('typeprice', function ($query) {
            $query->with('typepriceimage');
        })->find($id);
        if ($package) {
            $package = $package->toArray();
            $activityall = Activity::orderBy('id', 'DESC')->where('delete', 0)->where('status', 0)->get()->toArray();
            //echo "<pre>";print_r($activity);die;
            return view('package::activity', compact('package', 'activityall'));
        } else {
            return redirect()->route('package.index')
                ->with('error', 'Something went wrong');
        }
    }
    public function storeActivity(Request $request, $id)
    {
        // $request->validate([
        //     'title' => 'required',
        // ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        if (!empty($input['activity'])) {
            foreach ($input['activity'] as $key => $val) {
                $insertarray['activity_id'] = $input['activity'][$key];
                if (!empty($input['activity_id'][$key]) && $input['activity_id'][$key] != 0) {
                    $resulttypeprice = Packageactivity::where('id', $input['activity_id'][$key])->where('package_id', $id)->update($insertarray);
                    $typeprice_id = $input['activity_id'][$key];
                } else {
                    $insertarray['package_id'] = $id;
                    $resulttypeprice = Packageactivity::create($insertarray);
                    $typeprice_id = $resulttypeprice->id;
                }
            }
        }
        return redirect()->route('package.edit', $id)
            ->with('success', 'Activity added to package successfully');
    }
    public function destroy($id)
    {
        Package::find($id)->update(array('delete' => 1));
        //Package::find($id)->delete();
        // $cabrimg = Cabimage::where('parent_id', $id)->get()->toArray();
        // if (!empty($cabimg)) {
        //     foreach ($cabimg as $key => $val) {
        //         $image_path = public_path('\\') . $val['path'];
        //         if (File::exists($image_path)) {
        //             File::delete($image_path);
        //         }
        //     }
        // }
        //Cabimage::where('parent_id', $id)->delete();
        return redirect()->route('package.index')
            ->with('success', 'Package deleted successfully');
    }
    public function packagelist_api(Request $request, $id = '')
    {
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $package = Package::with(['packageimage', 'packagestyle', 'packagestyle.style_details', 'packagefeature', 'policy'])

        ->with('itinerary', function ($query) {
            $query->with('itineraryimage');
            
        })->with('typeprice', function ($query) { 
            $query->with('packagetype');
            $query->with('typepriceimage');

        })->with('packagehotel', function ($query) {
            $query->with('hotel', function ($query) {
                $query->with('location');
            });

        })->with('packagesightseeing', function ($query) {
            $query->with('sightseeing_pkg', function ($query) {
               
            });

        })->with('packageactivity', function ($query) {
            $query->with('activity');

        })->where('delete', 0)->where('status', 0);

        if (!empty($id)) {
            $package = $package->where('id', $id);
        }
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $package->where('packages.title', 'LIKE', "%$search%");
            $package->orwhere('packages.subtitle', 'LIKE', "%$search%");
        }

        if (!empty($request->input('style_type'))) {
            
            $style_type = $request->input('style_type');
            
            $getPackageIds = Packagestyle::whereIn('package_style_id', $style_type )->get();
            $getPackageId = [];
            if(!empty($getPackageIds)){
                foreach($getPackageIds as $row){
                    $getPackageId[] = $row->package_id;
                }
          
                
                $package =$package->whereIn('id', $getPackageId);
                
            }

        }
        // $package =$package->where('delete', 0)->where('status', 0);
        // $package = $package->paginate(config('app.pagination_count'));
        if (empty($id)) {
            if (!empty($request->input('per_page')) && !empty($request->input('page_no')) && $request->input('page_no') > 0) {
                $per_page = $request->input('per_page');
                $page_no = $request->input('page_no');
                $offset = ($page_no - 1) * $per_page;
                $package = $package->orderBy('id', 'DESC')->limit($per_page)->offset($offset)->get();
            } else {
                $package = $package->orderBy('id', 'DESC')->get();
            }
        } else {
            $package = $package->get();
        }
        if (!$package->isEmpty()) {
            $success = 1;
            $msg = 'Packages are listed successfully';
        } else {
            $success = 0;
            $msg = 'No data found.';
        }

        $response = ['success' => $success, 'message' => $msg, 'data' => $package,  ];
        return response($response, 200);
    }

    public function imageinfo_api(Request $request)
    {
        if (!empty($request->input('url'))) {
            $url = $request->input('url');
            $type = pathinfo($url, PATHINFO_EXTENSION);
            $contents = file_get_contents($url);
            $base64 = 'data:face_image/' . $type . ';base64,' . base64_encode($contents);
            $response = ['success' => 1, 'message' => "Success", 'data' => $base64];
            return response($response, 200);
        }
    }
}
