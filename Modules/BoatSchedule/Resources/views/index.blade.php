
@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Boat Management</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-block">
                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                            <div class="h5 fw-semibold mb-0">Boat Management</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <form id='searchform' name='searchform' action='{{route('boatschedule.index')}}'>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0"
                                            placeholder="Search Boat Title" aria-describedby="search-contact-member"
                                            id='search_txt' name='search_txt' value="{{ request()->query('search_txt')}}">
                                        <button class="btn btn-light" type="submit" id="search-banner"><i
                                                class="ri-search-line text-muted"></i></button>
                                    </div>
                                </form>
                                <div class="dropdown ms-2 d-none">
                                    <button class="btn btn-icon btn-primary-light btn-wave" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                </div>
                                    <a href="{{ route('boatschedule.create') }}" class="btn btn-success ms-2">Create</a>
                               
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                        <table id="" class="table table-striped text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($boat_schedules as $boat_schedule)
                                    <tr>
                                        <td>{{ $i++}}</td>
                                        <td>{{ $boat_schedule->title}}</td>
                                        <td>
                                            @if ($boat_schedule->image)
                                                <img src="{{asset('uploads/boat/'.$boat_schedule->image)}}" alt=""
                                                    width="50">
                                            @endif
                                        </td>
                                        <td>{{ date('d M, y H:i', strtotime($boat_schedule->from_date)) }}</td>
                                        <td>{{ date('d M, y H:i', strtotime($boat_schedule->to_date)) }}</td>
                                        <td>
                                            @if (is_null($boat_schedule->price))
                                                {{ $boat_schedule->per_passenger_price }}
                                            @else
                                                {{ $boat_schedule->price }}
                                            @endif
                                        </td>
                                        <td>
                                            @if($boat_schedule->status == 'Y')
                                            <span class="btn btn-success btn-sm">Active</span>
                                            @else
                                            <span class="btn btn-danger btn-sm">Inactive</span>
                                            @endif
                                        </td>
                                      
                                        {{-- <td>
                                          <a class="btn btn-info"
                                              href="{{ route('boatschedule.show', $boat_schedule->id ) }}">Show</a>
                                   
                                              <a class="btn btn-primary"
                                                  href="{{ route('boatschedule.edit', $boat_schedule->id )}}">Edit</a>
                                    
                                              {!! Form::open([
                                                  'method' => 'DELETE',
                                                  'route' => ['boatschedule.destroy', $boat_schedule->id],
                                                  'style' => 'display:inline',
                                                  'onsubmit' => 'return confirmDelete()',
                                              ]) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                              {!! Form::close() !!}                              
                                      </td> --}}

                                      <td>
                                        <a class="btn"
                                            href="{{ route('boatschedule.show', $boat_schedule->id) }}"><i
                                                class='bx bxs-show fs-4'></i></a>
                                        
                                            <a class="btn "
                                                href="{{ route('boatschedule.edit', $boat_schedule->id) }}"><i
                                                    class='bx bxs-edit fs-4'></i></a>
                                        
                                
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['boatschedule.destroy', $boat_schedule->id], 'style' => 'display:inline']) !!}
                                                    {!! Form::button('<i class="bx bxs-trash-alt"></i>', [
                                                        'type' => 'submit',
                                                        'class' => 'btn',
                                                        'onclick' => 'return confirmDelete()',
                                                    ]) !!}
                                                    {!! Form::close() !!}
                                    </td>
                      

                                    
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
          function confirmDelete() {
              return confirm('Are you sure you want to delete this item?');
          }
      </script>
    @endsection

   