@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sightseeing.index') }}">Sight Seeings</a></li>
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
                        <div class="h5 fw-semibold mb-0">Sight Seeing</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('sightseeing.index') }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12 row">
                        <div class="col-md-6">
                            <label class="form-label">Title :</label>
                            <p class="text-muted fs-16">
                                {{ ($sightseeing['title'])?$sightseeing['title']:'' }}
                            </p>
                        </div>
                       
                        <div class="col-md-12">
                            <label class="form-label">Subtitle :</label>
                            <p class="text-muted fs-16">
                                {{ ($sightseeing['subtitle'])?$sightseeing['subtitle']:'' }}
                            </p>
                        </div>

                        <div class="col-12 mr-2 ">
                            <div class="row">
                                @if(isset($sightseeing['sightseeingimage']) && $sightseeing['sightseeingimage'])
                                @foreach($sightseeing['sightseeingimage'] as $key=>$val)
                                <div class="col-3 px-1" style="height: 200px; overflow: hidden;">
                                    <label class="form-label"></label>
                                    <img src="{{url('/') .'/'.  $val['path']}}" width="100%" height="100%" alt="">
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <div class="col-xl-12">
                            @if(!empty($sightseeing['title']))
                            <div class="card-header d-block mt-4" style="background-color: #c8d8f4!important;">
                                <div class="d-sm-flex d-block align-items-center justify-content-between">
                                    <div class="h5 fw-semibold mb-0">Sightseeing Location</div>
                                </div>
                            </div>
                            <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                                <thead>
                                    <tr>
                                        <th>Location Title</th>
                                        <th>Location Subtitle</th>
                                        <th>XUV price</th>
                                        <th>Sedan Price</th>
                                        <th>Hatchback Price</th>
                                        <th>Duration</th>
                                        <th>Entry Fees</th>
                                        <th>parking Fees </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(($sightseeing['sight_location']) as $val)
                                    <tr>
                                        <td>{{ $val['title'] }}</td>
                                        <td>{{ $val['subtitle'] }}</td>
                                        <td>{{ $val['xuv_price'] }}</td>
                                        <td>{{ $val['sedan_price'] }}</td>
                                        <td>{{ $val['hatchback_price'] }}</td>
                                        <td>{{ $val['duration'] }}</td>
                                        <td>{{ $val['entry_fees'] }}</td>
                                        <td>{{ $val['parking_fees'] }}</td>
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
</div>
@endsection