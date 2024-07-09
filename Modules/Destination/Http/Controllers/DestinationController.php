<?php

namespace Modules\Destination\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Destination\Entities\Destination;
use File;
use DB;

class DestinationController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:destination-list|destination-create|destination-edit|destination-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:destination-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:destination-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:destination-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Destination::orderBy('id', 'DESC')->where('status', 0)->where('delete', 0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('locations.name', 'LIKE', "%$search%");
            $data->orwhere('locations.subtitle', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('destination::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        return view('destination::create');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'destination_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['name'] = $input['name'];
        $insertarray['subtitle'] = $input['subtitle'];
        if (!empty($request->input('destination_img'))) {
            $path2 = public_path('uploads/destination');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            foreach ($request->input('destination_img', []) as $file) {
                $old_path = public_path('uploads/tmp') . '/' . $file;
                $new_path = public_path('uploads/destination') . '/' . $file;
                $move = File::move($old_path, $new_path);
                $insertarray['path'] = 'uploads/destination/' . $file;
                $insertarray['size'] = filesize($new_path);
            }
        }
        $result = Destination::create($insertarray);
        $inserted_id = $result->id;
        if (!empty($request->input('remove_destination_img', []))) {
            foreach ($request->input('remove_destination_img', []) as $deletefile) {
                $image_path = public_path('uploads/destination') . '/' . $deletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('destination.index')
            ->with('success', 'Destination created successfully');
    }
    public function show($id)
    {
        $destination = Destination::find($id)->toArray();
        return view('destination::show', compact('destination'));
    }
    public function edit($id)
    {
        $destination = Destination::find($id)->toArray();
        return view('destination::edit', compact('destination'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            //'destination_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['name'] = $input['name'];
        $insertarray['subtitle'] = $input['subtitle'];
        if (!empty($request->input('destination_img'))) {
            $path2 = public_path('uploads/destination');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            foreach ($request->input('destination_img', []) as $file) {
                $old_path = public_path('uploads/tmp') . '/' . $file;
                $new_path = public_path('uploads/destination') . '/' . $file;
                $move = File::move($old_path, $new_path);
                $insertarray['path'] = 'uploads/destination/' . $file;
                $insertarray['size'] = filesize($new_path);
            }
        }
        $result = Destination::find($id)->update($insertarray);
        if (!empty($request->input('remove_destination_img', []))) {
            foreach ($request->input('remove_destination_img', []) as $deletefile) {
                $image_path = public_path('uploads/destination') . '/' . $deletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        if (!empty($request->input('exists_remove_destination_img', []))) {
            foreach ($request->input('exists_remove_destination_img', []) as $key => $existsdeletefile) {
                $image_path = public_path('uploads/destination') . '/' . $existsdeletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('destination.index')
            ->with('success', 'Destination created successfully');
    }
    public function destroy($id)
    {
        Destination::find($id)->update(array('delete' => '1'));
        //DB::enableQueryLog();
        // $insertarray['delete']=1;
        // Destination::where('id',$id)->update($insertarray);
        // if (!empty($bannerimg)) {
        //     foreach ($bannerimg as $key => $val) {
        //         $image_path = public_path('\\') . $val['path'];
        //         if (File::exists($image_path)) {
        //             File::delete($image_path);
        //         }
        //     }
        // }
        //dd(DB::getQueryLog());
        return redirect()->route('destination.index')
            ->with('success', 'Destination deleted successfully');
    }
    public function destinationlist_api(Request $request, $id = '')
    {
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $destination = Destination::where('locations.delete', 0)->where('locations.status', 0);
        if (!empty($id)) {
            $destination = $destination->where('id', $id);
        }
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            // $destination->where('locations.name', 'LIKE', "%$search%");
            // $destination->orwhere('locations.subtitle', 'LIKE', "%$search%");
            $destination = $destination->where(function ($q1) use ($search) {
                $q1->where(function ($q2) use ($search) {
                    $q2->where('locations.title', 'LIKE', "%$search%");
                })
                    ->orWhere(function ($q2) use ($search) {
                        $q2->where('locations.subtitle', 'LIKE', "%$search%");
                    });
            });
        }
        if (empty($id)) {
            if (!empty($request->input('per_page')) && !empty($request->input('page_no')) && $request->input('page_no') > 0) {
                $per_page = $request->input('per_page');
                $page_no = $request->input('page_no');
                $offset = ($page_no - 1) * $per_page;
                $destination = $destination->orderBy('id', 'DESC')->limit($per_page)->offset($offset)->get();
            } else {
                $destination = $destination->orderBy('id', 'DESC')->get();
            }
        } else {
            $destination = $destination->get();
        }
        if (!$destination->isEmpty()) {
            $success = 1;
            $msg = 'Destination are listed successfully';
        } else {
            $success = 0;
            $msg = 'No data found.';
        }
        $response = ['success' => $success, 'message' => $msg, 'data' => $destination];
        return response($response, 200);
    }
}
