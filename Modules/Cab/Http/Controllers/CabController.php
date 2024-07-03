<?php

namespace Modules\Cab\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Cab\Entities\Cab;
use Modules\Cab\Entities\Cabimage;
use Modules\Destination\Entities\Destination;
use File;
use DB;

class CabController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:cab-list|cab-create|cab-edit|cab-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:cab-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:cab-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:cab-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Cab::orderBy('id', 'DESC')->where('delete', 0)->where('status', 0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('cabs.title', 'LIKE', "%$search%");
            $data->orwhere('cabs.subtitle', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('cab::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }
    public function create()
    {
        $location = Destination::where('status', 0)->where('delete', 0)->get()->toArray();
        return view('cab::create', compact('location'));
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'from_location' => 'required',
            'to_location' => 'required',
            'price' => 'required',
            'cab_img' => 'required'
        ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['from_location'] = $input['from_location'];
        $insertarray['to_location'] = $input['to_location'];
        $insertarray['price'] = $input['price'];
        $insertarray['seat_count'] = $input['seat_count'];
        $insertarray['luggage_count'] = $input['luggage_count'];
        $insertarray['ac'] = $input['is_ac'];
        $insertarray['first_aid'] = $input['is_firstaid'];
        $result = Cab::create($insertarray);
        $inserted_id = $result->id;
        if ($result) {
            $path2 = public_path('uploads\cab');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            if (!empty($request->input('cab_img', []))) {
                foreach ($request->input('cab_img', []) as $file) {
                    $old_path = public_path('uploads\tmp') . '\\' . $file;
                    $new_path = public_path('uploads\cab') . '\\' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $inserted_id;
                    $insertimage['path'] = 'uploads/cab/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    Cabimage::create($insertimage);
                }
            }
            if (!empty($request->input('remove_cab_img', []))) {
                foreach ($request->input('remove_cab_img', []) as $deletefile) {
                    $image_path = public_path('uploads\cab') . '\\' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
        }
        return redirect()->route('cab.index')
            ->with('success', 'Cab created successfully');
    }
    public function show($id)
    {
        $cab = Cab::with(['cabimage', 'fromlocation', 'tolocation'])->find($id)->toArray();
        return view('cab::show', compact('cab'));
    }
    public function edit($id)
    {
        $cab = Cab::with(['cabimage', 'fromlocation', 'tolocation'])->find($id)->toArray();
        $location = Destination::where('status', 0)->where('delete', 0)->get()->toArray();
        return view('cab::edit', compact('cab', 'location'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'from_location' => 'required',
            'to_location' => 'required',
        ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['from_location'] = $input['from_location'];
        $insertarray['to_location'] = $input['to_location'];
        $insertarray['price'] = $input['price'];
        $insertarray['seat_count'] = $input['seat_count'];
        $insertarray['luggage_count'] = $input['luggage_count'];
        $insertarray['ac'] = $input['is_ac'];
        $insertarray['first_aid'] = $input['is_firstaid'];
        $result = Cab::find($id)->update($insertarray);
        if ($result) {
            $path2 = public_path('uploads\cab');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            if (!empty($request->input('cab_img', []))) {
                foreach ($request->input('cab_img', []) as $file) {
                    $old_path = public_path('uploads\tmp') . '\\' . $file;
                    $new_path = public_path('uploads\cab') . '\\' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $id;
                    $insertimage['path'] = 'uploads/cab/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    Cabimage::create($insertimage);
                }
            }
            if (!empty($request->input('exists_remove_cab_img', []))) {
                foreach ($request->input('exists_remove_cab_img', []) as $key => $existsdeletefile) {
                    $image_path = public_path('uploads\cab') . '\\' . $existsdeletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                        cabimage::where('id', $key)->where('parent_id', $id)->delete();
                    }
                }
            }
            if (!empty($request->input('remove_cab_img', []))) {
                foreach ($request->input('remove_cab_img', []) as $deletefile) {
                    $image_path = public_path('uploads\cab') . '\\' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
        }
        return redirect()->route('cab.index')
            ->with('success', 'Cab created successfully');
    }
    public function destroy($id)
    {
        $insertarray['delete'] = 1;
        Cab::where('id', $id)->update($insertarray);
        return redirect()->route('cab.index')
            ->with('success', 'Cab updated successfully');
        // Cab::find($id)->delete();
        // $cabrimg = Cabimage::where('parent_id', $id)->get()->toArray();
        // if (!empty($cabimg)) {
        //     foreach ($cabimg as $key => $val) {
        //         $image_path = public_path('\\') . $val['path'];
        //         if (File::exists($image_path)) {
        //             File::delete($image_path);
        //         }
        //     }
        // }
        // Cabimage::where('parent_id', $id)->delete();
        // return redirect()->route('cab.index')
        //     ->with('success', 'Cab deleted successfully');
    }
    public function cablist_api(Request $request, $id = '')
    {
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $cab = Cab::with(['cabimage', 'fromlocation', 'tolocation'])->where('delete', 0)->where('status', 0);
        if (!empty($id)) {
            $cab = $cab->where('id', $id);
        }
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $cab->where('cabs.title', 'LIKE', "%$search%");
            $cab->orwhere('cabs.subtitle', 'LIKE', "%$search%");
        }
        if (empty($id)) {
            if (!empty($request->input('per_page')) && !empty($request->input('page_no')) && $request->input('page_no') > 0) {
                $per_page = $request->input('per_page');
                $page_no = $request->input('page_no');
                $offset = ($page_no - 1) * $per_page;
                $cab = $cab->orderBy('id', 'DESC')->limit($per_page)->offset($offset)->get();
            } else {
                $cab = $cab->orderBy('id', 'DESC')->get();
            }
        } else {
            $cab = $cab->get();
        }
        if (!$cab->isEmpty()) {
            $success = 1;
            $msg = 'Cabs are listed successfully';
        } else {
            $success = 0;
            $msg = 'No data found.';
        }
        $response = ['success' => $success, 'message' => $msg, 'data' => $cab];
        return response($response, 200);
    }
}
