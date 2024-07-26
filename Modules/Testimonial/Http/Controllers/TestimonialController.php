<?php

namespace Modules\Testimonial\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Testimonial\Entities\Testimonial;
use File;
use DB;

class testimonialController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:testimonial-list|testimonial-create|testimonial-edit|testimonial-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:testimonial-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:testimonial-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:testimonial-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = 'Modules\Testimonial\Entities\Testimonial'::orderBy('id', 'DESC')->where('status',0)->where('delete',0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('testimonials.title', 'LIKE', "%$search%");
            $data->orwhere('testimonials.subtitle', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('testimonial::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        return view('testimonial::create');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'testimonial_img' => 'required'
        ]);
       // dd($request);
        $input = $request->all();
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['designation'] = $input['designation'];
        if (!empty($request->input('testimonial_img'))) {
            $path2 = public_path('uploads/testimonial');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            foreach ($request->input('testimonial_img', []) as $file) {
                $old_path = public_path('uploads/tmp') . '/' . $file;
                $new_path = public_path('uploads/testimonial') . '/' . $file;
                $move = File::move($old_path, $new_path);
                $insertarray['path'] = 'uploads/testimonial/' . $file;
                $insertarray['size'] = filesize($new_path);
            }
        }
        $result = Testimonial::create($insertarray);
        $inserted_id = $result->id;
        if (!empty($request->input('remove_testimonial_img', []))) {
            foreach ($request->input('remove_testimonial_img', []) as $deletefile) {
                $image_path = public_path('uploads/testimonial') . '/' . $deletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('testimonial.index')
            ->with('success', 'testimonial created successfully');
    }
    public function show($id)
    {
        $testimonial = Testimonial::find($id)->toArray();
        return view('testimonial::show', compact('testimonial'));
    }
    public function edit($id)
    {
        $testimonial = Testimonial::find($id)->toArray();
        //dd($testimonial);
        return view('testimonial::edit', compact('testimonial'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            //'testimonial_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['designation'] = $input['designation'];
        if (!empty($request->input('testimonial_img'))) {
            $path2 = public_path('uploads/testimonial');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            foreach ($request->input('testimonial_img', []) as $file) {
                $old_path = public_path('uploads/tmp') . '/' . $file;
                $new_path = public_path('uploads/testimonial') . '/' . $file;
                $move = File::move($old_path, $new_path);
                $insertarray['path'] = 'uploads/testimonial/' . $file;
                $insertarray['size'] = filesize($new_path);
            }
        }
        $result = Testimonial::find($id)->update($insertarray);
        if (!empty($request->input('remove_testimonial_img', []))) {
            foreach ($request->input('remove_testimonial_img', []) as $deletefile) {
                $image_path = public_path('uploads/testimonial') . '/' . $deletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        if (!empty($request->input('exists_remove_testimonial_img', []))) {
            foreach ($request->input('exists_remove_testimonial_img', []) as $key => $existsdeletefile) {
                $image_path = public_path('uploads/testimonial') . '/' . $existsdeletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('testimonial.index')
            ->with('success', 'testimonial created successfully');
    }
    public function destroy($id)
    {
        //DB::enableQueryLog();
        $insertarray['delete']=1;
        Testimonial::where('id',$id)->update($insertarray);
        // if (!empty($bannerimg)) {
        //     foreach ($bannerimg as $key => $val) {
        //         $image_path = public_path('\\') . $val['path'];
        //         if (File::exists($image_path)) {
        //             File::delete($image_path);
        //         }
        //     }
        // }
        //dd(DB::getQueryLog());
        return redirect()->route('testimonial.index')
            ->with('success', 'testimonial deleted successfully');
    }
    public function testimoniallist_api(Request $request, $id = '')
    {
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $testimonial = Testimonial::where('testimonials.delete', 0)->where('testimonials.status', 0);
        if (!empty($id)) {
            $testimonial = $testimonial->where('id', $id);
        }
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $testimonial->where('testimonials.title', 'LIKE', "%$search%");
            $testimonial->orwhere('testimonials.subtitle', 'LIKE', "%$search%");
        }
        // $package =$package->where('delete', 0)->where('status', 0);
        // $package = $package->paginate(config('app.pagination_count'));
        if (empty($id)) {
            if (!empty($request->input('per_page')) && !empty($request->input('page_no')) && $request->input('page_no') > 0) {
                $per_page = $request->input('per_page');
                $page_no = $request->input('page_no');
                $offset = ($page_no - 1) * $per_page;
                $testimonial = $testimonial->orderBy('id', 'DESC')->limit($per_page)->offset($offset)->get();
            } else {
                $testimonial = $testimonial->orderBy('id', 'DESC')->get();
            }
        } else {
            $testimonial = $testimonial->get();
        }
        if (!$testimonial->isEmpty()) {
            $success = 1;
            $msg = 'Testimonials are listed successfully';
        } else {
            $success = 0;
            $msg = 'No data found.';
        }
        $response = ['success' => $success, 'message' => $msg, 'data' => $testimonial];
        return response($response, 200);
    }
}
