<?php

namespace Modules\Hotel\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Hotel_category;
use App\Models\Hotel_facility;
use App\Models\Hotel_price;
use App\Models\Hotels;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Hotel\Entities\Hotelimage;
use Modules\Hotel\Entities\Room;
use Modules\Hotel\Entities\Roomimage;
use Modules\Destination\Entities\Destination;
use File;
use DB;
use Auth;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        //DB::enableQueryLog();
        $data = Hotels::orderBy('id', 'DESC')->where('delete', 0)->where('status', 0);
        if (!empty($request->input('search_txt'))) {
            $search = $request->input('search_txt');
            $data->where('hotel.title', 'LIKE', "%$search%");
            $data->orwhere('hotel.subtitle', 'LIKE', "%$search%");
        }
        $data = $data->paginate(config('app.pagination_count'));
        //dd(DB::getQueryLog());
        return view('hotel::index', compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * config('app.pagination_count'));
    }
    public function create()
    {
        $location = Destination::where('status', 0)->where('delete', 0)->get()->toArray();
        $hotel_categories = Hotel_category::where('status', 0)->where('delete', 0)->get();
        //print_r($location);die;
        return view('hotel::create', compact('location', 'hotel_categories'));
    }
    public function store(Request $request): RedirectResponse
    {
         
        $request->validate([
            'title' => 'required',
            'location' => 'required',
            'hotel_img' => 'required',
            'city_limit' => 'required',
            'category_id' => 'required',
            'meal_price' => 'required',
            'flower_bed_price' => 'required',
            'candle_light_dinner_price' => 'required',
            'extra_person_with_mattres' => 'required',
            'extra_person_without_mattres' => 'required',
            'cp' => 'required',
            'map' => 'required',
            'ap' => 'required',
            'ep' => 'required',
        ]);

        $user_id = Auth::user()->id;

        $input = $request->all();
       // echo "<pre>";print_r ($input );die;
      
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['location_id'] = $input['location'];
        $insertarray['city_limit'] = $input['city_limit'];
        $insertarray['created_by'] =  $user_id;
        $result = Hotels::create($insertarray);
        $inserted_id = $result->id;

        if ($result) {
            $path2 = public_path('uploads\hotel');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            if (!empty($request->input('hotel_img', []))) {
                foreach ($request->input('hotel_img', []) as $file) {
                    $old_path = public_path('uploads\tmp') . '\\' . $file;
                    $new_path = public_path('uploads\hotel') . '\\' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $inserted_id;
                    $insertimage['path'] = 'uploads/hotel/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    Hotelimage::create($insertimage);
                }
            }
            if (!empty($request->input('remove_hotel_img', []))) {
                foreach ($request->input('remove_hotel_img', []) as $deletefile) {
                    $image_path = public_path('uploads\hotel') . '\\' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
            if (!empty($input['room_title'])) {
                foreach ($input['room_title'] as $key => $val) {
                    $roomarray['title'] = $val;
                    $roomarray['subtitle'] = $input['room_subtitle'][$key];
                    $roomarray['hotel_id'] = $inserted_id;
                    $roomarray['max_pax'] = $input['room_pax'][$key];
                    $roomarray['room_count'] = $input['room_total'][$key];
                    $roomarray['price_per_day'] = $input['price_perday'][$key];
                    $resultroom = Room::create($roomarray);
                    $room_id = $resultroom->id;

                    $pathroom2 = public_path('uploads\hotel\room');
                    if (!file_exists($pathroom2)) {
                        mkdir($pathroom2, 0777, true);
                    }
                    if (!empty($request->input('roomimage' . $key . '_img', []))) {
                        foreach ($request->input('roomimage' . $key . '_img', []) as $file) {
                            $old_path = public_path('uploads\tmp') . '\\' . $file;
                            $new_path = public_path('uploads\hotel\room') . '\\' . $file;
                            $move = File::move($old_path, $new_path);
                            $insertimage['parent_id'] = $room_id;
                            $insertimage['path'] = 'uploads/hotel/room/' . $file;
                            $insertimage['size'] = filesize($new_path);
                            Roomimage::create($insertimage);
                        }
                    }
                    if (!empty($request->input('remove_roomimage' . $key . '_img', []))) {
                        foreach ($request->input('remove_roomimage' . $key . '_img', []) as $deletefile) {
                            $image_path = public_path('uploads\hotel\room') . '\\' . $deletefile;
                            if (File::exists($image_path)) {
                                File::delete($image_path);
                            }
                        }
                    }
                }
            }
        }

        // hotel_facility
       
        $insert_hotel_facility['hotel_id'] = $inserted_id;
        $insert_hotel_facility['meal_price'] = $input['meal_price'];
        $insert_hotel_facility['flower_bed_price'] = $input['flower_bed_price'];
        $insert_hotel_facility['candle_light_dinner_price'] = $input['candle_light_dinner_price'];
        $insert_hotel_facility['extra_person_with_mattres'] = $input['extra_person_with_mattres'];
        $insert_hotel_facility['extra_person_without_mattres'] = $input['extra_person_without_mattres'];
        $insert_hotel_facility['created_by'] = $user_id ;

       
        $Hotel_facility_result = Hotel_facility::create($insert_hotel_facility);

        // hotel price
        foreach ($input['category_id'] as $key => $val) {
            $insert_hotel_price['hotel_id'] = $inserted_id;
            $insert_hotel_price['category_id'] = $val;
            $insert_hotel_price['cp'] = $input['cp'][$key];
            $insert_hotel_price['map'] = $input['map'][$key];
            $insert_hotel_price['ap'] = $input['ap'][$key];
            $insert_hotel_price['ep'] = $input['ep'][$key];
            $insert_hotel_price['created_by'] = $user_id ;

            $Hotel_facility_result = Hotel_price::create($insert_hotel_price);
        }

        return redirect()->route('hotel.index')
            ->with('success', 'Hotel created successfully');
    }
    public function show($id)
    {
        $hotel = Hotels::with(['hotelimage', 'hotel_facility', 'hotel_price'])->with('location')->with('room', function ($query) {
            $query->with('roomimage');
        })->find($id)->toArray();

       foreach ($hotel['hotel_price'] as $key => $value) {
        $hotel['hotel_price'][$key]['category'] = Hotel_category::find( $value['category_id'])->toArray();
       }

        //echo "<pre>";print_r($hotel['hotel_price']);die;
        return view('hotel::show',compact('hotel'));
    }
    public function edit($id)
    {
        $hotel = Hotels::with(['hotelimage','hotel_facility', 'hotel_price'])->with('room', function ($query) {
            $query->with('roomimage');
        })->find($id)->toArray();
        $hotel_categories = Hotel_category::where('status', 0)->where('delete', 0)->get();
        foreach ($hotel['hotel_price'] as $key => $value) {
            $hotel['hotel_price'][$key]['category'] = Hotel_category::find( $value['category_id'])->toArray();
           }
           
        $location = Destination::where('status', 0)->where('delete', 0)->get()->toArray();
       //echo "<pre>";print_r($hotel['hotel_price'][0] ['category_id']);die;
        return view('hotel::edit', compact('hotel', 'location', 'hotel_categories'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
            'location' => 'required',
            //'hotel_img' => 'required',
            'city_limit' => 'required',
            'category_id' => 'required',
            'meal_price' => 'required',
            'flower_bed_price' => 'required',
            'candle_light_dinner_price' => 'required',
            'extra_person_with_mattres' => 'required',
            'extra_person_without_mattres' => 'required',
            'cp' => 'required',
            'map' => 'required',
            'ap' => 'required',
            'ep' => 'required',
        ]);
        $input = $request->all();
        //echo "<pre>";print_r($input);die;
        $insertarray['title'] = $input['title'];
        $insertarray['subtitle'] = $input['subtitle'];
        $insertarray['location_id'] = $input['location'];
        $insertarray['city_limit'] = $input['city_limit'];
        $result = Hotels::find($id)->update($insertarray);

        if ($result) {
            $path2 = public_path('uploads\hotel');
            if (!file_exists($path2)) {
                mkdir($path2, 0777, true);
            }
            if (!empty($request->input('hotel_img', []))) {
                foreach ($request->input('hotel_img', []) as $file) {
                    $old_path = public_path('uploads\tmp') . '\\' . $file;
                    $new_path = public_path('uploads\hotel') . '\\' . $file;
                    $move = File::move($old_path, $new_path);
                    $insertimage['parent_id'] = $id;
                    $insertimage['path'] = 'uploads/hotel/' . $file;
                    $insertimage['size'] = filesize($new_path);
                    Hotelimage::create($insertimage);
                }
            }
            if (!empty($request->input('exists_remove_hotel_img', []))) {
                foreach ($request->input('exists_remove_hotel_img', []) as $key => $existsdeletefile) {
                    $image_path = public_path('uploads\hotel') . '\\' . $existsdeletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                        Hotelimage::where('id', $key)->where('parent_id', $id)->delete();
                    }
                }
            }
            if (!empty($request->input('remove_hotel_img', []))) {
                foreach ($request->input('remove_hotel_img', []) as $deletefile) {
                    $image_path = public_path('uploads\hotel') . '\\' . $deletefile;
                    if (File::exists($image_path)) {
                        File::delete($image_path);
                    }
                }
            }
            if (!empty($input['room_title'])) {
                foreach ($input['room_title'] as $key => $val) {
                    $roomarray['title'] = $val;
                    $roomarray['subtitle'] = $input['room_subtitle'][$key];
                    $roomarray['max_pax'] = $input['room_pax'][$key];
                    $roomarray['room_count'] = $input['room_total'][$key];
                    $roomarray['price_per_day'] = $input['price_perday'][$key];
                    if (!empty($input['room_id'][$key]) && $input['room_id'][$key] != 0) {
                        $result = Room::where('id', $input['room_id'][$key])->where('hotel_id', $id)->update($roomarray);
                        $room_id = $input['room_id'][$key];
                    } else {
                        $roomarray['hotel_id'] = $id;
                        $resultroom = Room::create($roomarray);
                        $room_id = $resultroom->id;
                    }
                    $pathroom2 = public_path('uploads\hotel\room');
                    if (!file_exists($pathroom2)) {
                        mkdir($pathroom2, 0777, true);
                    }
                    if (!empty($request->input('roomimage' . $key . '_img', []))) {
                        foreach ($request->input('roomimage' . $key . '_img', []) as $file) {
                            $old_path = public_path('uploads\tmp') . '\\' . $file;
                            $new_path = public_path('uploads\hotel\room') . '\\' . $file;
                            $move = File::move($old_path, $new_path);
                            $insertimage['parent_id'] = $room_id;
                            $insertimage['path'] = 'uploads/hotel/room/' . $file;
                            $insertimage['size'] = filesize($new_path);
                            Roomimage::create($insertimage);
                        }
                    }
                    if (!empty($request->input('exists_remove_roomimage' . $key . '_img', []))) {
                        foreach ($request->input('exists_remove_roomimage' . $key . '_img', []) as $key => $existsdeletefile) {
                            $image_path = public_path('uploads\hotel\room') . '\\' . $existsdeletefile;
                            if (File::exists($image_path)) {
                                File::delete($image_path);
                                Roomimage::where('id', $key)->where('parent_id', $room_id)->delete();
                            }
                        }
                    }
                    if (!empty($request->input('remove_roomimage' . $key . '_img', []))) {
                        foreach ($request->input('remove_roomimage' . $key . '_img', []) as $deletefile) {
                            $image_path = public_path('uploads\hotel\room') . '\\' . $deletefile;
                            if (File::exists($image_path)) {
                                File::delete($image_path);
                            }
                        }
                    }
                }
            }
        }

        $insert_hotel_facility['meal_price'] = $input['meal_price'];
        $insert_hotel_facility['flower_bed_price'] = $input['flower_bed_price'];
        $insert_hotel_facility['candle_light_dinner_price'] = $input['candle_light_dinner_price'];
        $insert_hotel_facility['extra_person_with_mattres'] = $input['extra_person_with_mattres'];
        $insert_hotel_facility['extra_person_without_mattres'] = $input['extra_person_without_mattres'];
       
        $Hotel_facility_result = Hotel_facility::where('hotel_id', $id)->update($insert_hotel_facility);
  

        // hotel price
        // echo"<pre>";
        // print_r($input['category_id'] );
        // print_r($id);

        foreach ($input['category_id'] as $key => $val) {
            $insert_hotel_price = [
                'cp' => $input['cp'][$key],
                'map' => $input['map'][$key],
                'ap' => $input['ap'][$key],
                'ep' => $input['ep'][$key]
            ];
                   
        Hotel_price::where('hotel_id', $id)
                   ->where('category_id', $val)
                   ->update($insert_hotel_price);
       
        }

        return redirect()->route('hotel.index')
            ->with('success', 'Hotel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $insertarray['delete'] = 1;
        Hotels::where('id', $id)->update($insertarray);
        return redirect()->route('hotel.index')
            ->with('success', 'Hotel updated successfully');
    }
}
