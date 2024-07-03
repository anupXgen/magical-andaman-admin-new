<?php

namespace Modules\Achievement\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Achievement\Entities\Achievement;
use File;
use DB;

class achievementController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:achievement-list|achievement-create|achievement-edit|achievement-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:achievement-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:achievement-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:achievement-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Achievement::orderBy('id', 'DESC')->where('delete', 0)->where('status', 0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('achievements.title', 'LIKE', "%$search%");
            $data->orwhere('achievements.subtitle', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('achievement::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        return view('achievement::create');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'achievement_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        if (!empty($request->input('achievement_img'))) {
            $path2 = public_path('uploads\achievement');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            foreach ($request->input('achievement_img', []) as $file) {
                $old_path = public_path('uploads\tmp') . '\\' . $file;
                $new_path = public_path('uploads\achievement') . '\\' . $file;
                $move = File::move($old_path, $new_path);
                $insertarray['path'] = 'uploads/achievement/' . $file;
                $insertarray['size'] = filesize($new_path);
            }
        }
        $result = Achievement::create($insertarray);
        $inserted_id = $result->id;
        if (!empty($request->input('remove_achievement_img', []))) {
            foreach ($request->input('remove_achievement_img', []) as $deletefile) {
                $image_path = public_path('uploads\achievement') . '\\' . $deletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('achievement.index')
            ->with('success', 'achievement created successfully');
    }
    public function show($id)
    {
        $achievement = Achievement::find($id)->toArray();
        return view('achievement::show', compact('achievement'));
    }
    public function edit($id)
    {
        $achievement = Achievement::find($id)->toArray();
        return view('achievement::edit', compact('achievement'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            //'achievement_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        if (!empty($request->input('achievement_img'))) {
            $path2 = public_path('uploads\achievement');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            foreach ($request->input('achievement_img', []) as $file) {
                $old_path = public_path('uploads\tmp') . '\\' . $file;
                $new_path = public_path('uploads\achievement') . '\\' . $file;
                $move = File::move($old_path, $new_path);
                $insertarray['path'] = 'uploads/achievement/' . $file;
                $insertarray['size'] = filesize($new_path);
            }
        }
        $result = Achievement::find($id)->update($insertarray);
        if (!empty($request->input('remove_achievement_img', []))) {
            foreach ($request->input('remove_achievement_img', []) as $deletefile) {
                $image_path = public_path('uploads\achievement') . '\\' . $deletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        if (!empty($request->input('exists_remove_achievement_img', []))) {
            foreach ($request->input('exists_remove_achievement_img', []) as $key => $existsdeletefile) {
                $image_path = public_path('uploads\achievement') . '\\' . $existsdeletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('achievement.index')
            ->with('success', 'achievement created successfully');
    }
    public function destroy($id)
    {
        //DB::enableQueryLog();
        $insertarray['delete'] = 1;
        Achievement::where('id', $id)->update($insertarray);
        // if (!empty($bannerimg)) {
        //     foreach ($bannerimg as $key => $val) {
        //         $image_path = public_path('\\') . $val['path'];
        //         if (File::exists($image_path)) {
        //             File::delete($image_path);
        //         }
        //     }
        // }
        //dd(DB::getQueryLog());
        return redirect()->route('achievement.index')
            ->with('success', 'achievement deleted successfully');
    }
    public function achievementlist_api(Request $request, $id = '')
    {
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $achievement = Achievement::where('delete', 0)->where('status', 0);
        if (!empty($id)) {
            $achievement = $achievement->where('id', $id);
        }
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            //$activity->where('activitys.title', 'LIKE', "%$search%");
            //$activity->orwhere('activitys.subtitle', 'LIKE', "%$search%");
            $achievement = $achievement->where(function ($q1) use ($search) {
                $q1->where(function ($q2) use ($search) {
                    $q2->where('achievements.title', 'LIKE', "%$search%");
                })
                    ->orWhere(function ($q2) use ($search) {
                        $q2->where('achievements.subtitle', 'LIKE', "%$search%");
                    });
            });
        }
        if (empty($id)) {
            if (!empty($request->input('per_page')) && !empty($request->input('page_no')) && $request->input('page_no') > 0) {
                $per_page = $request->input('per_page');
                $page_no = $request->input('page_no');
                $offset = ($page_no - 1) * $per_page;
                $achievement = $achievement->orderBy('id', 'DESC')->limit($per_page)->offset($offset)->get();
            } else {
                $achievement = $achievement->orderBy('id', 'DESC')->get();
            }
        } else {
            $achievement = $achievement->get();
        }
        if (!$achievement->isEmpty()) {
            $success = 1;
            $msg = 'Activity are listed successfully';
        } else {
            $success = 0;
            $msg = 'No data found.';
        }
        $response = ['success' => $success, 'message' => $msg, 'data' => $achievement];
        return response($response, 200);
    }
}
