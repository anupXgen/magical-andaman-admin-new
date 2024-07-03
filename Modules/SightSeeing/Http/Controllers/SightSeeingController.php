<?php

namespace Modules\SightSeeing\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Destination\Entities\Destination;
use Modules\SightSeeing\Entities\Sightseeing;
use Modules\SightSeeing\Entities\Sightseeingimage;
use App\Models\Sightseeing_location;
use File;
use DB;

class SightSeeingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:sightseeing-list|sightseeing-create|sightseeing-edit|sightseeing-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:sightseeing-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sightseeing-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sightseeing-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    { 
       
        //DB::enableQueryLog();
        $data = Sightseeing::where('status', 0)->where('delete', 0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('sight_seeings.title', 'LIKE', "%$search%");
            $data->orwhere('sight_seeings.subtitle', 'LIKE', "%$search%");
            //$data->orwhere('locations.name', 'LIKE', "%$search%");
        }
        
        // Project::with(['clients', 'tasks', 'status' => function($q) use($value) {
        //     // Query the name field in status table
        //     $q->where('name', '=', $value); // '=' is optional
        // }])
        $data = $data->orderBy('id', 'DESC')->paginate(config('app.pagination_count'));
        
        
        return view('sightseeing::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }
    public function create()
    {
       
        $locations = Destination::where('status', 0)->where('delete', 0)->get();
        return view('sightseeing::create', compact('locations'));
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'location_id' => 'required',
            'sightseeing_img' => 'required',
            'location_title.*' => 'required',
            'location_subtitle.*' => 'required',
            'duration.*' => 'required',
            'entry_fees.*' => 'required',
            'xuv_price.*' => 'required',
            'sedan_price.*' => 'required',
            'hatchback_price.*' => 'required',
            'parking_fees.*' => 'required',
        ]);
        $input = $request->all();

        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['location_id'] = $input['location_id'];
      
        $result = Sightseeing::create($insertarray);
        $inserted_id = $result->id;

        if ($result) {
            $path2 = public_path('uploads\sightseeing');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            if (!empty($request->input('sightseeing_img', []))) {
                foreach ($request->input('sightseeing_img', []) as $file) {
                    $old_path = public_path('uploads\tmp') . '\\' . $file;
                    $new_path = public_path('uploads\sightseeing') . '\\' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $inserted_id;
                    $insertimage['path'] = 'uploads/sightseeing/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    Sightseeingimage::create($insertimage);
                }
            }
            if (!empty($request->input('remove_sightseeing_img', []))) {
                foreach ($request->input('remove_sightseeing_img', []) as $deletefile) {
                    $image_path = public_path('uploads\sightseeing') . '\\' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
        }

        //sightseeing_location insert
        foreach ($input['location_title'] as $key => $val) {
        $sight_location = [];

        $sight_location['sightseeing_id'] = $inserted_id;
        $sight_location['title'] = $input['location_title'][$key];
        $sight_location['subtitle'] = $input['location_subtitle'][$key];
        $sight_location['xuv_price'] = $input['xuv_price'][$key];
        $sight_location['sedan_price'] = $input['sedan_price'][$key];
        $sight_location['hatchback_price'] = $input['hatchback_price'][$key];
        $sight_location['duration'] = $input['duration'][$key];
        $sight_location['entry_fees'] = $input['entry_fees'][$key];
        $sight_location['parking_fees'] = $input['parking_fees'][$key];

        $result2 = Sightseeing_location::create($sight_location);
        }

        return redirect()->route('sightseeing.index')
            ->with('success', 'Sight Seeing created successfully');
    }
    public function show($id)
    {
        $sightseeing = Sightseeing::with(['sightseeingimage', 'sight_location'])->find($id)->toArray();
         echo "<pre>";print_r($sightseeing);die;
        return view('sightseeing::show', compact('sightseeing'));
    }
    public function edit($id)
    {
        $sightseeing = Sightseeing::with(['sightseeingimage', 'sight_location'])->find($id)->toArray();
        $locations = Destination::where('status', 0)->where('delete', 0)->get();
       
        return view('sightseeing::edit', compact('sightseeing',  'locations'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'location_id' => 'required',
            //'sightseeing_img' => 'required',
            'location_title.*' => 'required',
            'location_subtitle.*' => 'required',
            'duration.*' => 'required',
            'entry_fees.*' => 'required',
            'xuv_price.*' => 'required',
            'sedan_price.*' => 'required',
            'hatchback_price.*' => 'required',
            'parking_fees.*' => 'required',
            //'banner_img' => 'required'
        ]);
        $input = $request->all();
       
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['location_id'] = $input['location_id'];
      

        $result = Sightseeing::find($id)->update($insertarray);
        if ($result) {
            if (!empty($request->input('sightseeing_img', []))) {
                foreach ($request->input('sightseeing_img', []) as $file) {
                    $old_path = public_path('uploads\tmp') . '\\' . $file;
                    $new_path = public_path('uploads\sightseeing') . '\\' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $id;
                    $insertimage['path'] = 'uploads/sightseeing/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    sightseeingimage::create($insertimage);
                }
            }
            if (!empty($request->input('exists_remove_sightseeing_img', []))) {
                foreach ($request->input('exists_remove_sightseeing_img', []) as $key => $existsdeletefile) {
                    $image_path = public_path('uploads\home_sightseeing') . '\\' . $existsdeletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                        sightseeingimage::where('id', $key)->where('parent_id', $id)->delete();
                    }
                }
            }
            if (!empty($request->input('remove_sightseeing_img', []))) {
                foreach ($request->input('remove_sightseeing_img', []) as $deletefile) {
                    $image_path = public_path('uploads\home_sightseeing') . '\\' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
        }
           
                //sightseeing_location update
                foreach ($input['location_title'] as $key => $val) {
                    $sight_location = [];

                    $sight_loc_id= $input['sight_loc_id'][$key];
            
                    $sight_location['title'] = $input['location_title'][$key];
                    $sight_location['subtitle'] = $input['location_subtitle'][$key];
                    $sight_location['xuv_price'] = $input['xuv_price'][$key];
                    $sight_location['sedan_price'] = $input['sedan_price'][$key];
                    $sight_location['hatchback_price'] = $input['hatchback_price'][$key];
                    $sight_location['duration'] = $input['duration'][$key];
                    $sight_location['entry_fees'] = $input['entry_fees'][$key];
                    $sight_location['parking_fees'] = $input['parking_fees'][$key];
                    
                   
                    $result2 = Sightseeing_location::where('sightseeing_id', $id)->where('id', $sight_loc_id)->update($sight_location);
                    
                    }
                   
                    
                   
        return redirect()->route('sightseeing.index')
            ->with('success', 'Sight Seeing created successfully');
    }
    public function destroy($id)
    {
        Sightseeing::find($id)->update(array('delete' => '1'));
        // Sightseeing::find($id)->delete();
        // $sightseeingrimg = sightseeingimage::where('parent_id', $id)->get()->toArray();
        // if (!empty($sightseeingimg)) {
        //     foreach ($sightseeingimg as $key => $val) {
        //         $image_path = public_path('\\') . $val['path'];
        //         if (File::exists($image_path)) {
        //             File::delete($image_path);
        //         }
        //     }
        // }
        // Sightseeingimage::where('parent_id', $id)->delete();
        return redirect()->route('sightseeing.index')
            ->with('success', 'Sightseeing deleted successfully');
    }
    public function sightseeinglist_api(Request $request, $id = '')
    {
   
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $sightseeing = Sightseeing::with(['sightseeingimage', 'location'])->where('sight_seeings.delete', 0)->where('sight_seeings.status', 0);
        if (!empty($id)) {
            $sightseeing = $sightseeing->where('id', $id);
        }
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $sightseeing->where('sight_seeings.title', 'LIKE', "%$search%");
            $sightseeing->orwhere('sight_seeings.subtitle', 'LIKE', "%$search%");
        }

        if (!empty($request->input('location_id'))) {
            $sightseeing = $sightseeing->where('location_id', $request->input('location_id'));
           
        }

  
        
        // $package =$package->where('delete', 0)->where('status', 0);
        // $package = $package->paginate(config('app.pagination_count'));
        if (empty($id)) {
            if (!empty($request->input('per_page')) && !empty($request->input('page_no')) && $request->input('page_no') > 0) {
                $per_page = $request->input('per_page');
                $page_no = $request->input('page_no');
                $offset = ($page_no - 1) * $per_page;
                $sightseeing = $sightseeing->orderBy('id', 'DESC')->limit($per_page)->offset($offset)->get();
            } else {
                $sightseeing = $sightseeing->orderBy('id', 'DESC')->get();
            }
        } else {
            $sightseeing = $sightseeing->get();
        }
        if (!$sightseeing->isEmpty()) {
            $success = 1;
            $msg = 'Sightseeing are listed successfully';
        } else {
            $success = 0;
            $msg = 'No data found.';
        }

        $response = ['success' => $success, 'message' => $msg, 'data' => $sightseeing];
        return response($response, 200);
    }
}
