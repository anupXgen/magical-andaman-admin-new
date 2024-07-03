<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Blog\Entities\Blog;
use File;
use DB;

   
class BlogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:blog-list|blog-create|blog-edit|blog-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:blog-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:blog-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:blog-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Blog::orderBy('id', 'DESC')->where('delete', 0)->where('status', 0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('blogs.title', 'LIKE', "%$search%");
            $data->orwhere('blogs.subtitle', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('blog::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }
    public function create()
    {
        return view('blog::create');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'blog_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['author_name'] = $input['author'];
        if (!empty($request->input('blog_img'))) {
            $path2 = public_path('uploads\blog');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            foreach ($request->input('blog_img', []) as $file) {
                $old_path = public_path('uploads\tmp') . '\\' . $file;
                $new_path = public_path('uploads\blog') . '\\' . $file;
                $move = File::move($old_path, $new_path);
                $insertarray['path'] = 'uploads/blog/' . $file;
                $insertarray['size'] = filesize($new_path);
            }
        }
        $result = Blog::create($insertarray);
        $inserted_id = $result->id;
        if (!empty($request->input('remove_blog_img', []))) {
            foreach ($request->input('remove_blog_img', []) as $deletefile) {
                $image_path = public_path('uploads\blog') . '\\' . $deletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('blog.index')
            ->with('success', 'Blog created successfully');
    }
    public function show($id)
    {
        $blog = Blog::find($id)->toArray();
        return view('blog::show', compact('blog'));
    }
    public function edit($id)
    {
        $blog = Blog::find($id)->toArray();
        return view('blog::edit', compact('blog'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            //'destination_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['title'] = $input['title'];
        $insertarray['author_name'] = $input['author'];
        $insertarray['subtitle'] = $input['subtitle'];
        if (!empty($request->input('blog_img'))) {
            $path2 = public_path('uploads\blog');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            foreach ($request->input('blog_img', []) as $file) {
                $old_path = public_path('uploads\tmp') . '\\' . $file;
                $new_path = public_path('uploads\blog') . '\\' . $file;
                $move = File::move($old_path, $new_path);
                $insertarray['path'] = 'uploads/blog/' . $file;
                $insertarray['size'] = filesize($new_path);
            }
        }
        $result = Blog::find($id)->update($insertarray);
        if (!empty($request->input('remove_blog_img', []))) {
            foreach ($request->input('remove_blog_img', []) as $deletefile) {
                $image_path = public_path('uploads\blog') . '\\' . $deletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        if (!empty($request->input('exists_remove_blog_img', []))) {
            foreach ($request->input('exists_remove_blog_img', []) as $key => $existsdeletefile) {
                $image_path = public_path('uploads\blog') . '\\' . $existsdeletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('blog.index')
            ->with('success', 'Blog created successfully');
    }
    public function destroy($id)
    {
        Blog::find($id)->update(array('delete' => '1'));
        return redirect()->route('blog.index')
            ->with('success', 'Blog deleted successfully');
    }
    public function bloglist_api(Request $request, $id = '')
    {
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $blog = Blog::where('delete', 0)->where('status', 0);
        // $latest_blogs = Blog::orderBy('id', 'DESC')->limit(4)->get();

        if (!empty($id)) {
            $blog = $blog->where('id', $id);
        }
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            // $blog->where('blogs.title', 'LIKE', "%$search%");
            // $blog->orwhere('blogs.subtitle', 'LIKE', "%$search%");
            $blog = $blog->where(function ($q1) use ($search) {
                $q1->where(function ($q2) use ($search) {
                    $q2->where('blogs.title', 'LIKE', "%$search%");
                })
                    ->orWhere(function ($q2) use ($search) {
                        $q2->where('blogs.subtitle', 'LIKE', "%$search%");
                    });
            });
        }
        if (empty($id)) {
            if (!empty($request->input('per_page')) && !empty($request->input('page_no')) && $request->input('page_no') > 0) {
                $per_page = $request->input('per_page', 10);
                $page_no = $request->input('page_no',1);
                $offset = ($page_no - 1) * $per_page;
                $blog = $blog->orderBy('id', 'DESC')->limit($per_page)->offset($offset)->get();
            } else {
                 $blog = $blog->orderBy('id', 'DESC')->get();

            }
           
        } else {
           
            $blog = $blog->get();
        }
        if (!$blog->isEmpty()) {
            $success = 1;
            $msg = 'Blog are listed successfully';
        } else {
            $success = 0;
            $msg = 'No data found.';
        }
        $response = ['success' => $success, 'message' => $msg, 'data' => $blog];
        return response($response, 200);
    }
}
