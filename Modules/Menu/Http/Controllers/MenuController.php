<?php

namespace Modules\Menu\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Menu\Entities\Menu;
use DB;
use Hash;
use Illuminate\Support\Arr;

class MenuController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:menu-list|menu-create|menu-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:menu-create', ['only' => ['create', 'store']]);
        // $this->middleware('permission:menu-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:menu-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $menus = Menu::latest();
        if (!empty($request->input('search'))) {
            $search = $request->input('search');
            $menus->where('title', 'LIKE', "%$search%");
        }
        $menus = $menus->orderBy('id', 'DESC')->paginate(10);
        return view('menu::index', compact('menus'))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('menu::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|regex:/^[a-z A-Z]+$/u|max:255',
                'base_path' => 'required',
                'permission_path' => 'required',
            ],
            [
                'title.required' => 'Title can’t be empty',
                'title.regex' => 'Invalid title format',
                'base_path.required' => 'Base path can’t be empty',
                'permission_path.required' => 'Permission path can’t be empty',
            ]
        );
        $menu = new Menu;
        $menu->parent_id = 0;
        $menu->title = $request->title;
        $menu->base_path = $request->base_path;
        $menu->base_url = $request->permission_path;
        if (empty($request->menu_id)) {
            if ($menu->save()) {
                $urls = explode(',', $request->permission_path);
                $data = array();
                foreach ($urls as $url) {
                    $node = array(
                        'menu_id' => $menu->id,
                        'name' => $url,
                        'guard_name' => 'web',
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                    array_push($data, $node);
                }
                DB::table('permissions')->insert($data);
            }
            $msg = "created";
        } else {
            $insert_array['updated_at'] = current_datetime();
            $insert_array['updated_by'] = loggedin_admin('id');
            $insert_array['title'] = $menu->menu_title;
            $insert_array['base_url'] = $menu->urls;
            $insert_array['parent_id'] = 0;
            // $menu = Menu::find($request->menu_id);
            // $menu->update(array($insert_array));
            DB::table('menus')->where('id', $request->menu_id)->update($insert_array);
            $msg = "updated";
        }
        return redirect()->route('menu.index')->with('success', 'Menu ' . $msg . ' successfully.');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $menu = Menu::find($id);
        return view('menu::show', compact('menu'));
    }
    public function destroy($id)
    {
        //
    }
}
