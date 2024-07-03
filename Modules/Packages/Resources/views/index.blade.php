@extends('layouts.app')


@section('content')
<div class="container-fluid">
  <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
    <div class="ms-md-1 ms-0">
      <nav>
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Packages</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12">
      <div class="card custom-card">
        <div class="card-header d-block">
          <div class="d-sm-flex d-block align-items-center justify-content-between">
            <div class="h5 fw-semibold mb-0">Custom Package Management</div>
            <div class="d-flex mt-sm-0 mt-2 align-items-center">
              <form id='searchform' name='searchform' action=''>
                <div class="input-group">
                  <input type="text" class="form-control bg-light border-0" placeholder="Search Date Of journey" aria-describedby="search-contact-member" id='search_txt' name='search_txt'>
                  <button class="btn btn-light" type="submit" id="search-destination"><i class="ri-search-line text-muted"></i></button>
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
             
                <th>email</th>
                <th>Mobile no</th>
                <th>journey_date</th>
                <th>payment_status</th>
                <th>order_id</th>
                <th>invoice_id</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $key => $row)
              <tr>
                
                <td>{{ $row->Package_booking_details->email }}</td>
                <td>{{ $row->Package_booking_details->mobile_no }}</td>               
                <td>{{ $row->Package_booking_details->journey_date}}</td>
                <td>
                  @if($row->Package_booking_details->payment_status == 'success')
                      <span style="background-color: green; color: white; padding: 6px 10px; border-radius: 10px;">
                          {{ $row->Package_booking_details->payment_status }}
                      </span>
                  @else
                      <span style="background-color: red; color: white; padding: 6px 10px; border-radius: 10px;">
                          {{ $row->Package_booking_details->payment_status }}
                      </span>
                  @endif
              </td>
              
              
                <td>{{  $row->Package_booking_details->order_id }}</td>
                <td>{{  $row->Package_booking_details->invoice_id }}</td>
               
                <td>
                  <a class="btn btn-info p-2" href="{{ route('packages.edit',$row->id) }}">View Itinerary</a>
                  <a class="btn btn-info" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Assign to</a>
                 
                  @can('destination-delete')
                  {!! Form::open(['method' => 'DELETE','route' => ['destination.destroy', $row->id],'style'=>'display:inline']) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                  {!! Form::close() !!}
                  @endcan
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
         {{-- {{ $data->appends(Request::all())->links("pagination::bootstrap-4") }} --}}
        </div>
      </div>
    </div>
  </div>



<!-- Modal of assign custom package-->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Assign to Agent</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="row">
          <div class="col-md-12">
            <select class="form-select" name="user_id">
                <option value="">Select Agent</option>
                @foreach($users_dropdown as $user)
                <option value="{{$user->id}}">{{$user->name}} ({{$user->email}})</option>
                @endforeach
            </select>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send Details</button>
      </div>
    </div>
  </div>
</div>

  @endsection