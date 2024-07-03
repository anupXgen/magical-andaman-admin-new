<?php

namespace Modules\Tourlocation\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TourlocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = DB::table('locations')->get();
        $data = compact('locations');
        return view('tourlocation::index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tourlocation::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
    
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]); 
        if ($request->has('image')) {
            $file = $request->file('image');
            $extension =  $file->getClientOriginalExtension();
            $imageName = time().'.'.$extension;
            $path = 'uploads/location/';
            $file->move($path,$imageName);

        
        }
        DB::table('locations')->insert([
            'name' => $request->title,
            'description' => $request->description,
            'path' => $imageName,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('tourlocation.index')->with('success', 'Location Insert successfully.');
    }

  
    public function show($id)
    {
        $location = DB::table('locations')->find($id);
        return view('tourlocation::show', compact('location'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $location = DB::table('locations')->find($id);
        return view('tourlocation::edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $location = DB::table('locations')->find($id);
        
        if ($request->has('image')) {
            if(File::exists($location->path)){
              $data =  File::delete($location->path);
            }
            $file = $request->file('image');
            $extension =  $file->getClientOriginalExtension();
            $imageName = time().'.'.$extension;
            $path = 'uploads/location/';
            $file->move($path,$imageName);
                       
        }
  
       DB::table('locations')->where('id', $id)->update([
            'name' => $request->title,
            'description' => $request->description,
            'path' => $imageName,
            'status' => 1,
            'updated_at' => now(),
        ]);
        return redirect()->route('tourlocation.index')->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $location = DB::table('locations')->find($id);
        if ($location->path) {
           File::delete($location->path);
        }
        DB::table('locations')->delete($id);
        return redirect()->route('tourlocation.index')->with('success', 'Location deleted successfully.');
    }
}
