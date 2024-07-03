@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('package.index') }}">Packages</a></li>
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
                        <div class="h5 fw-semibold mb-0">Package</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('package.index') }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12 row">
                        <div class="col-md-6">
                            <label class="form-label">Title :</label>
                            <p class="text-muted fs-16">
                                {{ ($package['title'])?$package['title']:'' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subtitle :</label>
                            <p class="text-muted fs-16">
                                {{ ($package['subtitle'])?$package['subtitle']:'' }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Featue :</label>
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagefeature']['night_stay']) && $package['packagefeature']['night_stay']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Night Stay
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagefeature']['transport']) && $package['packagefeature']['transport']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Transport
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagefeature']['activity']) && $package['packagefeature']['activity']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Activity
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagefeature']['ferry']) && $package['packagefeature']['ferry']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Ferry
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        

                        <div class="col-md-12">
                            <label class="form-label">Style :</label>
                            <ul class="list-group list-group-horizontal">

                            @foreach($packageStyle as $row)
                            @if(in_array($row->id, $packageStyleId))
                                <div class="form-check form-check-md d-flex align-items-center list-group-item">
                                  
                                    <label class="form-check-label " for="style_couple">
                                    <i class="bi bi-check-square-fill text-green"></i> {{ $row->title }}
                                    </label>
                                </div>
                            @endif
                               @endforeach

                             
                                <!-- <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagestyle'][0]['package_style_id'])  && ($package['packagestyle'][0]['package_style_id']) ==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Couple
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagestyle'][0]['package_style_id']) && ($package['packagestyle'][0]['package_style_id'])==2)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Honeymoon
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagestyle'][0]['package_style_id']) && ($package['packagestyle'][0]['package_style_id'])==3)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Friends
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagestyle'][0]['package_style_id']) && ($package['packagestyle'][0]['package_style_id'])==4)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Solo
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagestyle'][0]['package_style_id']) && ($package['packagestyle'][0]['package_style_id'])==5)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Family
                                        </div>
                                    </div>
                                </li> -->
                                   
                            </ul>
                        </div>
                   

                        <div class="col-12 mr-2 ">
                            <div class="row">
                                @if(isset($package['packageimage']) && $package['packageimage'])
                                @foreach($package['packageimage'] as $key=>$val)
                                <div class="col-3 px-1" style="height: 200px; overflow: hidden;">
                                    <label class="form-label"></label>
                                    <img src="{{ url('/') .'/'.  $val['path']; }}" width="100%" height="100%" alt="">
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
                        @if(!empty($package['itinerary']))
                        <div class="card-header d-block mt-4" style="background-color: #c8d8f4!important;">
                            <div class="d-sm-flex d-block align-items-center justify-content-between">
                                <div class="h5 fw-semibold mb-0">Itinerary</div>
                                <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                    <a href="{{ url('package/itinerary/' . $package['id']) }}" type="button" id="additinerarybtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"> Add/Edit</a>
                                    <input type="hidden" id="count_itinerary" name="count_itinerary" value="1">
                                </div>
                            </div>
                        </div>
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package['itinerary'] as $key => $itinerary)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ ucfirst($itinerary['title']) }}</td>
                                    <td>{{ ucfirst(substr($itinerary['subtitle'],0, 100).'..') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12">
                        @if(!empty($package['typeprice']))
                        <div class="card-header d-block mt-4" style="background-color: #c8d8f4!important;">
                            <div class="d-sm-flex d-block align-items-center justify-content-between">
                                <div class="h5 fw-semibold mb-0">Type & Price</div>
                                <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                    <a href="{{ url('package/typeprice/' . $package['id']) }}" type="button" id="addtypepricebtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"> Add/Edit</a>
                                    <input type="hidden" id="count_typeprice" name="count_typeprice" value="1">
                                </div>
                            </div>
                        </div>
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type</th>
                                    <th>Subtitle</th>
                                    <th>CP Plan</th>
                                    <th>Map With Dinner</th>
                                    <th>Actual Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package['typeprice'] as $key => $typeprice)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ ucfirst($typeprice['packagetype']['title']) }}</td>
                                    <td>{{ ucfirst(substr($typeprice['subtitle'],0, 100).'..') }}</td>
                                    <td>{{ $typeprice['cp_plan'] }}</td>
                                    <td>{{ $typeprice['map_with_dinner'] }}</td>
                                    <td>{{ $typeprice['actual_price'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif

                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12">
                        @if(!empty($package['policy']))
                        <div class="card-header d-block mt-4" style="background-color: #c8d8f4!important;">
                            <div class="d-sm-flex d-block align-items-center justify-content-between">
                                <div class="h5 fw-semibold mb-0">Policy</div>
                                <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                    <a href="{{ url('package/policy/' . $package['id']) }}" type="button" id="addpolicybtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"> Add/Edit</a>
                                    <input type="hidden" id="count_policy" name="count_policy" value="1">
                                </div>
                            </div>
                        </div>
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Subtitle</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package['policy'] as $key => $policy)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ ucfirst($policy['title']) }}</td>
                                    <td>{{ ucfirst(substr($policy['subtitle'],0, 100).'..') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12">
                        @if(!empty($package['packagehotel']))
                        <div class="card-header d-block mt-4" style="background-color: #c8d8f4!important;">
                            <div class="d-sm-flex d-block align-items-center justify-content-between">
                                <div class="h5 fw-semibold mb-0">Hotel</div>
                                <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                    <a href="{{ url('package/hotel/' . $package['id']) }}" type="button" id="addhotelbtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"> Add/Edit</a>
                                    <input type="hidden" id="count_hotel" name="count_hotel" value="1">
                                </div>
                            </div>
                        </div>
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package['packagehotel'] as $key => $hotel)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ ucfirst($hotel['hotel']['title']) }}</td>
                                    <td>{{ ucfirst($hotel['hotel']['location']['name']) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12">
                        @if(!empty($package['packagesightseeing']))
                        <div class="card-header d-block mt-4" style="background-color: #c8d8f4!important;">
                            <div class="d-sm-flex d-block align-items-center justify-content-between">
                                <div class="h5 fw-semibold mb-0">Sight Seeing</div>
                                <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                    <a href="{{ url('package/sightseeing/' . $package['id']) }}" type="button" id="addsightseeingbtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"> Add/Edit</a>
                                    <input type="hidden" id="count_sightseeing" name="count_sightseeing" value="1">
                                </div>
                            </div>
                        </div>
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package['packagesightseeing'] as $key => $sightseeing)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ ucfirst($sightseeing['sightseeing_pkg']['title']) }}</td>
                                    <td>{{ ucfirst($sightseeing['sightseeing_pkg']['location']['name']) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12">
                        @if(!empty($package['packageactivity']))
                        <div class="card-header d-block mt-4" style="background-color: #c8d8f4!important;">
                            <div class="d-sm-flex d-block align-items-center justify-content-between">
                                <div class="h5 fw-semibold mb-0">Activity</div>
                                <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                    <a href="{{ url('package/activity/' . $package['id']) }}" type="button" id="addactivitybtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"> Add/Edit</a>
                                    <input type="hidden" id="count_activity" name="count_activity" value="1">
                                </div>
                            </div>
                        </div>
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Location</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($package['packageactivity'] as $key => $activity)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ ucfirst($activity['activity']['title']) }}</td>
                                    <td>{{ ucfirst($activity['activity']['subtitle']) }}</td>
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