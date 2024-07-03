<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = User::orderBy('id', 'DESC')->where('status',0)->where('delete',0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('users.name', 'LIKE', "%$search%");
            $data->orwhere('users.email', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('user::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('user::create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        //echo "<pre>";print_r($input['permission']);die;
        if (!empty($input['permission'])) {
            foreach ($input['permission'] as $key => $val) {
                DB::table('user_has_permission')->insert(array('user_id' => $user->id, 'permission_id' => $val));
            }
        }

        return redirect()->route('user.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user::show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('user::edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));
        DB::table('user_has_permission')->where('user_id', $id)->delete();
        if (!empty($input['permission'])) {
            foreach ($input['permission'] as $key => $val) {
                DB::table('user_has_permission')->insert(array('user_id' => $id, 'permission_id' => $val));
            }
        }

        return redirect()->route('user.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->update(array('delete'=>'1'));
        return redirect()->route('user.index')
            ->with('success', 'User deleted successfully');
    }

    public function get_role_permission_page(Request $request)
    {
        $input = $request->all();
        $html = '';
        $user_permission_array = array();
        if (!empty($input['roles'])) {
            $get_role = Role::select('permissions.*')->whereIn('roles.name', $input['roles'])->join('role_has_permissions', function ($join) {
                $join->on('roles.id', '=', 'role_has_permissions.role_id');
            })->join('permissions', function ($join) {
                $join->on('role_has_permissions.permission_id', '=', 'permissions.id');
            })->orderBy('permissions.id', 'ASC')->groupBy('permissions.id')->get()->toArray();
            if (!empty($input['user_id'])) {
                $get_user_permission = DB::table('user_has_permission')->select('permission_id')->where('user_id', $input['user_id'])->get();
                if (!empty($get_user_permission)) {
                    foreach ($get_user_permission as $key => $val) {
                        $user_permission_array[] = $val->permission_id;
                    }
                }
            }
            // echo "<pre>";
            // print_r($get_user_permission);
            // die;
            if (!empty($get_role)) {
                foreach ($get_role as $key => $val) {
                    $is_checked = (count($user_permission_array) > 0) ? (in_array($val['id'], $user_permission_array) ? 'checked' : '') : 'checked';
                    $html = $html . '<input class="form-check-input form-checked-outline form-checked-secondary" name="permission[]" type="checkbox" value="' . $val['id'] . '" ' . $is_checked . '><label>' . $val['name'] . '</label><br/>';
                }
            }
        }
        return $html;
    }
}
