@extends('layouts.app')


@section('content')
<div class="container-fluid">
  <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
    <div class="ms-md-1 ms-0">
      <nav>
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Enquiry Now</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12">
      <div class="card custom-card">
        <div class="card-header d-block">
          <div class="d-sm-flex d-block align-items-center justify-content-between">
            <div class="h5 fw-semibold mb-0">Enquiry Management</div>
            <div class="d-flex mt-sm-0 mt-2 align-items-center">
              <form id='searchform' name='searchform' action=''>
                <div class="input-group">
                  <input type="text" class="form-control bg-light border-0" placeholder="Search Enquiry" aria-describedby="search-contact-member" id='search_txt' name='search_txt'>
                  <button class="btn btn-light" type="submit" id="search-activity"><i class="ri-search-line text-muted"></i></button>
                </div>
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
              {{-- @can('activity-create')
              <a href="{{ route('contactus.create') }}" class="btn btn-success ms-2">Create</a>
              @endcan --}}
            </div>
          </div>
        </div>
        <div class="card-body">
          <table id="" class="table table-bordered text-nowrap w-100 mb-2">
            <thead>
              <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Travel <br> Month</th>      
                <th>Travel <br> Person</th>
                <th>Travel <br> Starting <br> Price</th>
                <th>Travel <br> Ending <br> Price</th>
                <th>Comments</th>
                <th>Created At</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $key => $val)
              <tr>
                <td>{{ ucfirst($val->name) }}</td>
                <td>{{ $val->email }}</td>
                <td style="inline-size:52px; white-space: normal;">{{$val->mobile}}</td>
                <td style="inline-size:22px; white-space: normal;">{{$val->travel_month}}</td>
                <td style="width: 22px; white-space: normal;">{{ $val->travel_person }}</td>
                <td>{{$val->travel_starting_price}}</td>
                <td>{{ $val->travel_ending_price }}</td>
                <td style="inline-size: 422px; white-space: normal;">{{ $val->comments }}</td>
                <td style="inline-size:92px; white-space: normal;">{{ $val->created_at }}</td>
                <td>
                  {{-- <a class="btn btn-info" href="{{ route('cars.show',$val->id) }}">Show</a>
                  @can('activity-edit')
                  <a class="btn btn-primary" href="{{ route('cars.edit',$val->id) }}">Edit</a>
                  @endcan --}}
                  @can('activity-delete')
                  {!! Form::open(['method' => 'DELETE','route' => ['cars.destroy', $val->id],'style'=>'display:inline']) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                  {!! Form::close() !!}
                  @endcan
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{ $data->appends(Request::all())->links("pagination::bootstrap-4"); }}
        </div>
      </div>
    </div>
  </div>

  @endsection