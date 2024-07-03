<?php

namespace Modules\Contactus\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Contactus\Entities\Contactus;
use App\Models\Cars;
use File;

class ContactusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Contactus::orderBy('id', 'DESC')->where('status', 0);

        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('contactus.name', 'LIKE', "%$search%");
            
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('contactus::index', compact('data',))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contactus::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('contactus::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('contactus::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
    public function contactusstore_api(Request $request)
    {
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $data = array();
        $input = $request->all();
        echo "<pre>";
        print_r($input);
        die;
        if (!empty($input['name']) && !empty($input['email']) && !empty($input['mobile'])) {
            $insertarray['name'] = $input['name'];
            $insertarray['email'] = $input['email'];
            $insertarray['mobile'] = $input['mobile'];
            $insertarray['message'] = $input['message'];
            $result = Contactus::create($insertarray);
            if ($result) {
                $success = 1;
                $msg = 'Your request send to Pristine Andaman Team.';
                $data['id'] = $result->id;
            }
        } else {
            $success = 0;
            $msg = 'Please enter all data.';
        }
        $response = ['success' => $success, 'message' => $msg, 'data' => $data];
        return response($response, 200);
    }
    public function contactsave_api(Request $request)
    {
        $success = 0;
        $msg = 'Something went wrong! Please try again..';
        $data = array();
        if (!empty($request->input('name')) && !empty($request->input('email')) && !empty($request->input('mobile'))) {
            $insertarray['name'] = $request->input('name');
            $insertarray['email'] = $request->input('email');
            $insertarray['mobile'] = $request->input('mobile');
            $insertarray['message'] = $request->input('message');
            $result = Contactus::create($insertarray);
            if ($result) {
                $success = 1;
                $msg = 'Your request send to Pristine Andaman Team.';
                $data['id'] = $result->id;
            }
        } else {
            $success = 0;
            $msg = 'Please enter all data.';
        }
        $response = ['success' => $success, 'message' => $msg, 'data' => $data];
        return response($response, 200);
    }
}
