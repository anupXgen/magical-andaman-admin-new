<?php

namespace Modules\Activity\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Activity\Entities\Activity;
use Modules\Activity\Entities\Activityimage;
use App\Models\Activity_category;
use Modules\Destination\Entities\Destination;
use Modules\package\Entities\Packageactivity;
use File;
use DB;

class ActivityController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:activity-list|activity-create|activity-edit|activity-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:activity-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:activity-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:activity-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Activity::orderBy('id', 'DESC')->with('location','activity_cat')->where('delete', 0)->where('status', 0);
    
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('activity.title', 'LIKE', "%$search%"); 
            $data->orwhere('activity.subtitle', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('activity::index', compact('data',))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }
    public function create()
    {
        $activity_categories = Activity_category::where('delete', 0)->where('status', 0)->get();
        $locations = Destination::where('status', 0)->where('delete', 0)->get();

        return view('activity::create', compact('activity_categories', 'locations'));
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'activity_category' => 'required',
            'location_id' => 'required',
            'price' => 'required',
            'activity_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['activity_category'] = $input['activity_category'];
        $insertarray['location_id'] = $input['location_id'];
        $insertarray['price'] = $input['price'];
        $result = Activity::create($insertarray);
        $inserted_id = $result->id;
        if ($result) {
            $path2 = public_path('uploads\activity');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            if (!empty($request->input('activity_img', []))) {
                foreach ($request->input('activity_img', []) as $file) {
                    $old_path = public_path('uploads\tmp') . '\\' . $file;
                    $new_path = public_path('uploads\activity') . '\\' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $inserted_id;
                    $insertimage['path'] = 'uploads/activity/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    Activityimage::create($insertimage);
                }
            }
            if (!empty($request->input('remove_activity_img', []))) {
                foreach ($request->input('remove_activity_img', []) as $deletefile) {
                    $image_path = public_path('uploads\activity') . '\\' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
        }
        return redirect()->route('activity.index')
            ->with('success', 'Activity created successfully');
    }
    public function show($id)
    {
        $activity = Activity::with(['activityimage'])->find($id)->toArray();
        return view('activity::show', compact('activity'));
    }
    public function edit($id)
    {
        $activity = Activity::with(['activityimage'])->find($id)->toArray();
        $activity_categories = Activity_category::where('delete', 0)->where('status', 0)->get();
        $locations = Destination::where('status', 0)->where('delete', 0)->get();

        return view('activity::edit', compact('activity', 'activity_categories', 'locations'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'activity_category' => 'required',
            'location_id' => 'required',
            'price' => 'required',
            //'banner_img' => 'required'
        ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['activity_category'] = $input['activity_category'];
        $insertarray['location_id'] = $input['location_id'];
        $insertarray['price'] = $input['price'];
        $result = Activity::find($id)->update($insertarray);
        if ($result) {
            if (!empty($request->input('activity_img', []))) {
                foreach ($request->input('activity_img', []) as $file) {
                    $old_path = public_path('uploads\tmp') . '\\' . $file;
                    $new_path = public_path('uploads\activity') . '\\' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $id;
                    $insertimage['path'] = 'uploads/activity/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    Activityimage::create($insertimage);
                }
            }
            if (!empty($request->input('exists_remove_activity_img', []))) {
                foreach ($request->input('exists_remove_activity_img', []) as $key => $existsdeletefile) {
                    $image_path = public_path('uploads\home_activity') . '\\' . $existsdeletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                        Activityimage::where('id', $key)->where('parent_id', $id)->delete();
                    }
                }
            }
            if (!empty($request->input('remove_activity_img', []))) {
                foreach ($request->input('remove_activity_img', []) as $deletefile) {
                    $image_path = public_path('uploads\home_activity') . '\\' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
        }
        return redirect()->route('activity.index')
            ->with('success', 'Activity created successfully');
    }
    public function destroy($id)
    {
        $insertarray['delete'] = 1;
        Activity::where('id', $id)->update($insertarray);
     
        // Activityimage::where('parent_id', $id)->delete();
        return redirect()->route('activity.index')
            ->with('success', 'Activity deleted successfully');
    }
    public function activitylist_api(Request $request, $id = '')
    {
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $activity = Activity::with(['activityimage'])->where('delete', 0)->where('status', 0);
        $activity_categories = Activity_category::where('delete', 0)->where('status', 0)->get();
        if (!empty($id)) {
            $activity = $activity->where('id', $id);
        }
        if (!empty($request->input('category_id'))) {
            $catgory_id = $request->input('category_id');
            $activity = $activity->where('activity_category', $catgory_id);
        }
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            //$activity->where('activitys.title', 'LIKE', "%$search%");
            //$activity->orwhere('activitys.subtitle', 'LIKE', "%$search%");
            $activity = $activity->where(function ($q1) use ($search) {
                $q1->where(function ($q2) use ($search) {
                    $q2->where('activitys.title', 'LIKE', "%$search%");
                })
                    ->orWhere(function ($q2) use ($search) {
                        $q2->where('activitys.subtitle', 'LIKE', "%$search%");
                    });
            });
        }

        if (!empty($request->input('activity_type'))) {

            $activity_type = $request->input('activity_type');
            $get_activity = Activity::whereIn('activity_category', $activity_type )->get();
          
            $getActivityId = [];
            if(!empty($get_activity)){
                foreach($get_activity as $row){
                    $getActivityId[] = $row->id;
                }
                
                $activity =$activity->whereIn('id', $getActivityId);
                          

            }
        }

        if (empty($id)) {
            if (!empty($request->input('per_page')) && !empty($request->input('page_no')) && $request->input('page_no') > 0) {
                $per_page = $request->input('per_page');
                $page_no = $request->input('page_no');
                $offset = ($page_no - 1) * $per_page;
                $activity = $activity->orderBy('id', 'DESC')->limit($per_page)->offset($offset)->get();
            } else {
                $activity = $activity->orderBy('id', 'DESC')->get();
            }
        } else {
            $activity = $activity->get();
        }
        if (!$activity->isEmpty()) {
            $success = 1;
            $msg = 'Activity are listed successfully';
        } else {
            $success = 0;
            $msg = 'No data found.';
        }
        $response = ['success' => $success, 'message' => $msg, 'data' => $activity, 'activity_category' => $activity_categories,];
        return response($response, 200);
    }
}
