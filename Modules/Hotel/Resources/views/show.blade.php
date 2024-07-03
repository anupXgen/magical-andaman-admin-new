@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('hotel.index') }}">hotels</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-block">
                    <div class="d-sm-flex d-block align-items-center justify-content-between">
                        <div class="h5 fw-semibold mb-0">hotel</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('hotel.index') }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12 row">
                        <div class="col-md-6">
                            <label class="form-label">Title :</label>
                            <p class="text-muted fs-16">
                                {{ ($hotel['title'])?$hotel['title']:'' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subtitle :</label>
                            <p class="text-muted fs-16">
                                {{ ($hotel['subtitle'])?$hotel['subtitle']:'' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Location :</label>
                            <p class="text-muted fs-16">
                                {{ ($hotel['location']['name'])?$hotel['location']['name']:'' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">City Limit :</label>
                            <p class="text-muted fs-16">
                               @if(($hotel['city_limit'])==1)
                               {{'In-City'}}
                                @else
                                {{"Out Of City"}}
                                @endif
                            </p>
                        </div>
                        <div class="col-12 mr-2 ">
                            <div class="row">
                                    @if(isset($hotel['hotelimage']) && $hotel['hotelimage'])
                                    @foreach($hotel['hotelimage'] as $key=>$val)
                                    <div class="col-3 px-1" style="height: 200px; overflow: hidden;">
                                        <label class="form-label"></label>
                                        <img src="{{ url('/') .'/'.  $val['path']}}" width="100%" height="100%" alt="">
                                    </div>
                                    @endforeach
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card custom-card"> 
                <div class="card-body">
                    <div class="col-xl-12">
                        @if(!empty($hotel['location']))
                        <div class="card-header d-block mt-4" style="background-color: #c8d8f4!important;">
                            <div class="d-sm-flex d-block align-items-center justify-content-between">
                                <div class="h5 fw-semibold mb-0">Hotel Price</div>
                            </div>
                        </div>
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>CP Price</th>
                                    <th>MAP price</th>
                                    <th>AP Price</th>
                                    <th>EP Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(($hotel['hotel_price']) as $val)
                                <tr>
                                    <td>{{ $val['category']['category_title'] }}</td>
                                    <td>{{ $val['cp'] }}</td>
                                    <td>{{ $val['map'] }}</td>
                                    <td>{{ $val['ep'] }}</td>
                                    <td>{{ $val['ap'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>

                    <div class="col-xl-12">
                        @if(!empty($hotel['location']))
                        <div class="card-header d-block mt-4" style="background-color: #c8d8f4!important;">
                            <div class="d-sm-flex d-block align-items-center justify-content-between">
                                <div class="h5 fw-semibold mb-0">Hotel Facility</div>
                            </div>
                        </div>
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>Meal Price</th>
                                    <th>Flower Bed Price</th>
                                    <th>Candle Light Dinner price</th>
                                    <th>Extra Person with Mattress</th>
                                    <th>Extra Person without Mattress</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $hotel['hotel_facility']['meal_price'] }}</td>
                                    <td>{{ $hotel['hotel_facility']['flower_bed_price'] }}</td>
                                    <td>{{ $hotel['hotel_facility']['candle_light_dinner_price'] }}</td>
                                    <td>{{ $hotel['hotel_facility']['extra_person_with_mattres'] }}</td>
                                    <td>{{ $hotel['hotel_facility']['extra_person_without_mattres'] }}</td>
                                    <td>
                                        @if(($hotel['hotel_facility']['status'])==0)
                                        {{'Active'}}
                                         @else
                                         {{"Inactive"}}
                                         @endif
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                        @endif
                    </div>


                    <div class="col-xl-12">
                        @if(!empty($hotel['location']))
                        <div class="card-header d-block mt-4" style="background-color: #c8d8f4!important;">
                            <div class="d-sm-flex d-block align-items-center justify-content-between">
                                <div class="h5 fw-semibold mb-0">Room</div>
                                {{-- <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                    <a href="{{ route('hotel.edit',$hotel['id']) }}" type="button" id="addroombtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"> Add/Edit</a>
                                    <input type="hidden" id="count_room" name="count_room" value="1">
                                </div> --}}
                            </div>
                        </div>
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                    <th>price Per Day</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hotel['room'] as $key => $room)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ ucfirst($room['title']) }}</td>
                                    <td>{{ ucfirst(substr($room['subtitle'],0, 100).'..') }}</td>
                                    <td>{{ $room['price_per_day'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection