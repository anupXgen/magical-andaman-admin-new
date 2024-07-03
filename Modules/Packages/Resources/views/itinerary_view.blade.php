@extends('layouts.app')


@section('content')
<div class="container-fluid">
  <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
    <div class="ms-md-1 ms-0">
      <nav>
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Itinerary View</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12">
      <div class="card custom-card">
        <div class="card-header d-block">
          <div class="d-sm-flex d-block align-items-center justify-content-between">
            <div class="h5 fw-semibold mb-0">Itinerary Management</div>
            <div class="d-flex mt-sm-0 mt-2 align-items-center">
              <form id='searchform' name='searchform' action=''>
                {{-- <div class="input-group">
                  <input type="text" class="form-control bg-light border-0" placeholder="Search Date Of journey" aria-describedby="search-contact-member" id='search_txt' name='search_txt'>
                  <button class="btn btn-light" type="submit" id="search-destination"><i class="ri-search-line text-muted"></i></button>
                </div> --}}
              </form>
              <div class="dropdown ms-2 d-none">
                <button class="btn btn-icon btn-primary-light btn-wave" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ti ti-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="javascript:void(0);">Delete All</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);">Copy All</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);">Move To</a></li>
                </ul>
              </div>
              <!-- @can('destination-create')
              <a href="{{ route('destination.create') }}" class="btn btn-success ms-2">Create</a>
              @endcan -->
            </div>
          </div>
        </div>
        <div class="card-body">
          <table id="" class="table table-bordered text-nowrap w-100 mb-2">
            <thead>
              <tr>
                <th style="font-size: 16px; font-weight: 800; color: #21D8F9;">Itinerary Day</th>
                <th style="font-size: 16px; font-weight: 800; color:  #21D8F9;">Car Type</th>
                <th style="font-size: 16px; font-weight: 800; color:  #21D8F9;">Sightseeing</th>
                <th style="font-size: 16px; font-weight: 800; color:  #21D8F9;">Hotel</th>
                <th style="font-size: 16px; font-weight: 800; color:  #21D8F9;">Extra Facility</th>
                <th style="font-size: 16px; font-weight: 800; color:  #21D8F9;">Activity</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($packageIti as $key => $iti_day)
              <tr>
                <td style="width: 125px; white-space: normal;">{{$key}} Day</td>
                <td>{{$data['car']['title']}}</td>
                <td>{{$iti_day['sightseeing']->title}}</td>
                <td>{{$iti_day['hotel']['hotel_id']->title}}</td>
                <td style="width: 225px; white-space: normal;">
                  @if(($iti_day['hotel']['meal'])==1)
                    {{"Extra Meal"}},
                  @endif
                  @if(($iti_day['hotel']['flower_bed_decoration'])==1)
                    {{"Flower Bed Decoration"}},
                  @endif
                  @if(($iti_day['hotel']['candle_light_dinner'])==1)
                    {{"candle_light_dinner"}},
                  @endif
                  @if(($iti_day['hotel']['extra_person_with_mattres'])==1)
                    {{"extra_person_with_mattres"}},
                  @endif
                  @if(($iti_day['hotel']['extra_person_without_mattres'])==1)
                    {{"extra_person_without_mattres"}},
                  @endif
                  </td>
                <td>
                @foreach ($iti_day['activity'] as $val)
                {{$val->title}} ,
                @endforeach
                </td>               
              </tr>
              @endforeach
            </tbody>
          </table>

          {{-- <table id="" class="table table-bordered text-nowrap w-100 mb-2">
            <thead>
              <tr>
                <th style="font-size: 16px; font-weight: 800; color: #21D8F9;">Extra Facility</th>
                <th></th>
              </tr>
            </thead>
          </table> --}}
         {{-- {{ $data->appends(Request::all())->links("pagination::bootstrap-4") }} --}}
        </div>
      </div>
    </div>
  </div>

  @endsection