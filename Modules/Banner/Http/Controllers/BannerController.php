<?php

namespace Modules\Banner\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Banner\Entities\Banner;
use Modules\Banner\Entities\Bannerimage;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;
use File;

class BannerController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:banner-list|banner-create|banner-edit|banner-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:banner-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:banner-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:banner-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Banner::orderBy('id', 'DESC')->where('status', 0)->where('delete', 0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('banners.title', 'LIKE', "%$search%");
            $data->orwhere('banners.subtitle', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('banner::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }
    public function create()
    {
        return view('banner::create');
    }
    public function uploadImage_s3(Request $request)
    {
        // try {

        //     // Instantiate the S3 client with your AWS credentials
        //     $s3Client = S3Client::factory(array(
        //         'credentials' => array(
        //             'key'    => 'AKIA5SBADLN5NKYAX6ZT',
        //             'secret' => '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',
        //         ),
        //         'region'=> "us-east-1"
        //     ));

        //     $buckets = $s3Client->listBuckets();
        //     print_r($buckets);

        //     }
        //     catch(Exception $e) {

        //        exit($e->getMessage());
        //     } 

        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg|max:20048',
        ]);
        if ($request->file('file')) {
            $file = $request->file('file');
            //$name = uniqid() . '_' . trim($file->getClientOriginalName());
            //$file->move($path, $name);
            //echo "<pre>";print_r($request->file('file'));die;
            $imageName = uniqid() . '_' . trim($request->file->getClientOriginalName());
            $imagePath = 'home_banner/' . $imageName;
            // //echo file_get_contents($request->file);die;
            $path = Storage::disk('s3')->put($imageName, file_get_contents($file), 'public');
            $path = Storage::disk('s3')->url($path);

            // $filePath = $file->store('/', ['disk' => 's3', 'visibility' => 'public']);
            // $fileName = basename($filePath);
            // echo "<pre>";print_r($filePath);die;
            // if ($request->hasFile('file')) {
            //     $file = $request->file('file');
            //     $name = time() . $file->getClientOriginalName();
            //     $filePath = 'images/' . $name;
            //     $path = Storage::disk('s3');
            //     echo "<pre>";print_r($files);die;
            // }
            // $extension  = request()->file('file')->getClientOriginalExtension(); 
            // //This is to get the extension of the image file just uploaded
            // $image_name = time() . '_' . $extension;
            // $path = $request->file('file')->storeAs('images',$image_name,'s3');
            //     echo $path;die;
            return response()->json([
                'success'       => 1,
                'name'          => $imageName,
                'original_name' => $request->file->getClientOriginalName(),
            ]);
        } else {
            return response()->json([
                'success'       => 0,
                'name'          => '',
                'original_name' => '',
            ]);
        }
    }
    public function uploadImage(Request $request)
    {
        // $allFile = $request->file('banner');
        // echo "<pre>";print_r($allFile);die;
        $path = public_path('uploads/tmp');
        //$path2 = public_path('uploads\home_banner');
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        // if (!file_exists($path2)) {
        //     mkdir($path2, 0777, true);
        // }
        if ($request->file('file')) {
            $file = $request->file('file');
            $name = uniqid() . '_' . trim($file->getClientOriginalName());
            $file->move($path, $name);
            return response()->json([
                'success'       => 1,
                'name'          => $name,
                'original_name' => $file->getClientOriginalName(),
            ]);
        } else {
            return response()->json([
                'success'       => 0,
                'name'          => '',
                'original_name' => '',
            ]);
        }
    }
    public function store(Request $request)
    {
        // $input = $request->all();
        // echo "<pre>";
        // print_r($input);
        // die;
        $request->validate([
            'title' => 'required',
            'banner_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $result = Banner::create($insertarray);
        $inserted_id = $result->id;
        if ($result) {
            $path2 = public_path('uploads/home_banner');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            if (!empty($request->input('banner_img', []))) {
                foreach ($request->input('banner_img', []) as $file) {
                    $old_path = public_path('uploads/tmp') . '/' . $file;
                    $new_path = public_path('uploads/home_banner') . '/' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $inserted_id;
                    $insertimage['path'] = 'uploads/home_banner/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    Bannerimage::create($insertimage);
                }
            }
            if (!empty($request->input('remove_banner_img', []))) {
                foreach ($request->input('remove_banner_img', []) as $deletefile) {
                    $image_path = public_path('uploads/home_banner') . '/' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
            //$flights = Banner::has('bannerimage')->get()->toArray();
            // echo "<pre>";
            // print_r($flights);
            // die;
        }
        return redirect()->route('banner.index')
            ->with('success', 'Banner created successfully');
    }
    public function show($id)
    {
        $banner = Banner::with(['bannerimage'])->find($id)->toArray();
        // echo "<pre>";
        //     print_r($banner);
        //     die;
        return view('banner::show', compact('banner'));
    }
    public function edit($id)
    {
        $banner = Banner::with(['bannerimage'])->find($id)->toArray();

        return view('banner::edit', compact('banner'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            //'banner_img' => 'required'
        ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $result = Banner::find($id)->update($insertarray);
        if ($result) {
            if (!empty($request->input('banner_img', []))) {
                foreach ($request->input('banner_img', []) as $file) {
                    $old_path = public_path('uploads/tmp') . '/' . $file;
                    $new_path = public_path('uploads/home_banner') . '/' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $id;
                    $insertimage['path'] = 'uploads/home_banner/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    Bannerimage::create($insertimage);
                }
            }
            if (!empty($request->input('exists_remove_banner_img', []))) {
                foreach ($request->input('exists_remove_banner_img', []) as $key => $existsdeletefile) {
                    $image_path = public_path('uploads/home_banner') . '/' . $existsdeletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                        Bannerimage::where('id', $key)->where('parent_id', $id)->delete();
                    }
                }
            }
            if (!empty($request->input('remove_banner_img', []))) {
                foreach ($request->input('remove_banner_img', []) as $deletefile) {
                    $image_path = public_path('uploads/home_banner') . '/' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
            //$flights = Banner::has('bannerimage')->get()->toArray();
            // echo "<pre>";
            // print_r($flights);
            // die;
        }
        return redirect()->route('banner.index')
            ->with('success', 'Banner created successfully');
    }
    public function destroy($id)
    {
        Banner::find($id)->update(array('delete' => '1'));
        // Banner::find($id)->delete();
        // $bannerimg = Bannerimage::where('parent_id', $id)->get()->toArray();
        // if (!empty($bannerimg)) {
        //     foreach ($bannerimg as $key => $val) {
        //         $image_path = public_path('\\') . $val['path'];
        //         if (File::exists($image_path)) {
        //             File::delete($image_path);
        //         }
        //     }
        // }
        // Bannerimage::where('parent_id', $id)->delete();
        return redirect()->route('banner.index')
            ->with('success', 'Banner deleted successfully');
    }
    public function bannerlist_api(Request $request)
    {
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $banners = Banner::with(['bannerimage'])->where('banners.delete', 0)->where('banners.status', 0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $banners = $banners->where(function ($q1) use ($search) {
                $q1->where(function ($q2) use ($search) {
                    $q2->where('banners.title', 'LIKE', "%$search%");
                })
                    ->orWhere(function ($q2) use ($search) {
                        $q2->where('banners.subtitle', 'LIKE', "%$search%");
                    });
            });
        }
        if (!empty($request->input('per_page')) && !empty($request->input('page_no')) && $request->input('page_no') > 0) {
            $per_page = $request->input('per_page');
            $page_no = $request->input('page_no');
            $offset = ($page_no - 1) * $per_page;
            $banners = $banners->orderBy('id', 'DESC')->limit($per_page)->offset($offset)->get();
        } else {
            $banners = $banners->orderBy('id', 'DESC')->get();
        }

        if (!$banners->isEmpty()) {
            $success = 1;
            $msg = 'Banners are listed successfully';
        } else {
            $success = 0;
            $msg = 'No data found.';
        }
        $response = ['success' => $success, 'message' => $msg, 'data' => $banners];
        return response($response, 200);
    }
}
