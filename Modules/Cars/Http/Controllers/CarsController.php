<?php

namespace Modules\Cars\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cars;
use App\Models\Car_category;
use File;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Cars::orderBy('id', 'DESC')->where('status', 0);

        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('cars.title', 'LIKE', "%$search%");
            
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('cars::index', compact('data',))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }
    public function create()
    {
        $car_categories = Car_category::where('status', 0)->get();

        return view('cars::create', compact('car_categories'));
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'car_category' => 'required',
            'price_per_hour' => 'required',
            'subtitle' => 'required',
            'car_images' => 'required'
        ]);
        $input = $request->all();
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['car_category'] = $input['car_category'];
        $insertarray['seater'] = $input['seater'];
        $insertarray['ac'] = $input['ac'];
        $insertarray['price_per_hour'] = $input['price_per_hour'];

        if (!empty($request->input('car_images', []))) {
            foreach ($request->input('car_images', []) as $file) {
                $old_path = public_path('uploads\tmp') . '\\' . $file;
                $new_path = public_path('uploads\cars') . '\\' . $file;
                $move = File::move($old_path, $new_path);
                $insertimage['path'] = 'uploads/cars/' . $file;

                $insertarray['car_image'] = $insertimage['path'];
            }
        }
                        

        $result = Cars::create($insertarray);
 
        return redirect()->route('cars.index')
            ->with('success', 'Car created successfully');
    }
    public function show($id)
    {
        $cars = Cars::find($id)->toArray();
        return view('cars::show', compact('cars'));
    }
    public function edit($id)
    {
        $cars = Cars::find($id)->toArray();
        $car_categories = car_category::where('status', 0)->get();

        return view('cars::edit', compact('cars', 'car_categories'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            
            'car_category' => 'required',
            'price_per_hour' => 'required',
            'car_image' => 'required'
        ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['car_category'] = $input['car_category'];
        $insertarray['seater'] = $input['seater'];
        $insertarray['ac'] = $input['ac'];
        $insertarray['price_per_hour'] = $input['price_per_hour'];

        if (!empty($request->input('car_image', []))) {
            foreach ($request->input('car_image', []) as $file) {
                $old_path = public_path('uploads\tmp') . '\\' . $file;
                $new_path = public_path('uploads\cars') . '\\' . $file;
                $move = File::move($old_path, $new_path);
               
                $insertimage['path'] = 'uploads/cars/' . $file;
                $insertarray['car_image'] =  $insertimage['path'] ;
            }
        }

        $result = Cars::find($id)->update($insertarray);
               
        return redirect()->route('cars.index')
            ->with('success', 'Cars created successfully');
    }
    public function destroy($id)
    {
        $insertarray['delete'] = 1;
        Cars::where('id', $id)->update($insertarray);
     
        // Activityimage::where('parent_id', $id)->delete();
        return redirect()->route('cars.index')
            ->with('success', 'Car deleted successfully');
    }
}
