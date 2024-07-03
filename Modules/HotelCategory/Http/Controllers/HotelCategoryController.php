<?php
namespace Modules\HotelCategory\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Hotel_category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use File;

class HotelCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct()
    {
        $this->middleware('permission:hotel_category-list|hotel_category-create|hotel_category-edit|hotel_category-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:hotel_category-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:hotel_category-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:hotel_category-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Hotel_category::orderBy('id', 'DESC')->where('status', 0)->where('delete', 0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('hotel_category.category_title', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('hotelcategory::index', compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }
  
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('hotelcategory::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
            $request->validate([
                'category_title' => 'required',
                'subtitle' => 'required',
            ]);
            $input = $request->all();
            $insertarray['category_title'] = $input['category_title'];
            $insertarray['subtitle'] = $input['subtitle'];
           
            $result = Hotel_category::create($insertarray);
            $inserted_id = $result->id;
           
            return redirect()->route('hotel_category.index')
                ->with('success', 'Hotel Category created successfully');
        
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $hotel_category = Hotel_category::find($id)->toArray();
        //echo "<pre>";print_r($input);die;
        return view('hotelcategory::show', compact('hotel_category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $hotel_category = Hotel_category::find($id)->toArray();
        return view('hotelcategory::edit', compact('hotel_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'category_title' => 'required',
            'subtitle' => 'required',
            //'destination_img' => 'required'
        ]);
        $input = $request->all();
        $insertarray['category_title'] = $input['category_title'];
        $insertarray['subtitle'] = $input['subtitle'];
       
        $result = Hotel_category::find($id)->update($insertarray);
       
        
        return redirect()->route('hotel_category.index')
            ->with('success', 'Hotel category created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
        Hotel_category::find($id)->update(array('delete' => '1'));
        return redirect()->route('hotel_category.index')
            ->with('success', 'Hotel Category deleted successfully');
    }
}
