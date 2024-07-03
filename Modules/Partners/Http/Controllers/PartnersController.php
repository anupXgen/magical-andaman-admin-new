<?php

namespace Modules\Partners\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response; 
use App\Models\partners;
use File;
use DB;

class PartnersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
     {
        $data = Partners::orderBy('id', 'DESC')-> where('is_deleted','No');
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('partners.comapny_name', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('partners::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
     }
     

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partners::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // 'title' => 'required',
            // 'author' => 'required',
            // 'blog_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['company_name'] = $input['company_name'];
        $insertarray['address'] = $input['address'];
        if (!empty($request->input('company_logo'))) {
            $path2 = public_path('uploads\partners');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            foreach ($request->input('company_logo', []) as $file) {
                $old_path = public_path('uploads\tmp') . '\\' . $file;
                $new_path = public_path('uploads\partners') . '\\' . $file;
                $move = File::move($old_path, $new_path);
                $insertarray['company_logo'] = 'uploads/partners/' . $file;
            }
        }
        $result = Partners::create($insertarray);
        $inserted_id = $result->id;
        if (!empty($request->input('remove_partner_img', []))) {
            foreach ($request->input('remove_partner_img', []) as $deletefile) {
                $image_path = public_path('uploads\partners') . '\\' . $deletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('partners.index')
            ->with('success', 'Partner created successfully');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $partner = Partners::find($id)->toArray();
        return view('partners::show', compact('partner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $partner = partners::find($id);

        return view('partners::edit', compact('partner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            // 'title' => 'required',
            // 'author' => 'required',
            // //'destination_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['company_name'] = $input['company_name'];
        $insertarray['address'] = $input['address'];
        if (!empty($request->input('company_logo'))) {
            $path2 = public_path('uploads\partners');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            foreach ($request->input('company_logo', []) as $file) {
                $old_path = public_path('uploads\tmp') . '\\' . $file;
                $new_path = public_path('uploads\partners') . '\\' . $file;
                $move = File::move($old_path, $new_path);
                $insertarray['company_logo'] = 'uploads/partners/' . $file;
            }
        }
        $result = Partners::find($id)->update($insertarray);
        if (!empty($request->input('remove_blog_img', []))) {
            foreach ($request->input('remove_blog_img', []) as $deletefile) {
                $image_path = public_path('uploads\partners') . '\\' . $deletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        if (!empty($request->input('exists_remove_blog_img', []))) {
            foreach ($request->input('exists_remove_blog_img', []) as $key => $existsdeletefile) {
                $image_path = public_path('uploads\partners') . '\\' . $existsdeletefile;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
        }
        return redirect()->route('partners.index')
            ->with('success', 'Partner Updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Partners::find($id)->update(array('is_deleted'=>'Yes'));
        return redirect()->route('partners.index')
            ->with('success', 'Partner deleted successfully');
    }
}
