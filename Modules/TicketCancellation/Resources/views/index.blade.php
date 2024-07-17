@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ticket </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-block">
                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                            <div class="h5 fw-semibold mb-0"> </div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <form id='searchform' name='searchform' method="GET" action="{{route('ticketcancellation.index')}}">
                                  @csrf
                                    <div class="input-group">
                                        <select class="form-select" aria-label="Default select example" name="type">
                                            <option value="">Sekect One</option>
                                            <option value="ferry">Ferry</option>
                                            <option value="boat">Boat</option>
                                        </select>
                                        <input type="text" class="form-control bg-light border-0" aria-describedby=""
                                            id='date' name='date' placeholder="Select Date">
                                        <button class="btn btn-light" type="submit" id="search-testimonial"><i
                                                class="ri-search-line text-muted"></i></button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type</th>
                                    <th>Customer Name</th>
                                    <th>Mobile No</th>
                                    <th>Date Of Journey</th>
                                    <th>Booked At</th>
                                    <th>Resident</th>
                                </tr>
                            </thead>
                            <tbody>
                              @php
                                $i= 1;
                              @endphp
                                <tr>
                                  @foreach($all_datas as $data)
                                  <th>{{$i++}}</th>
                                    <td>{{ ucfirst($data->type) }}</td>
                                    <td>{{ucfirst($data->c_name) }}</td>
                                    <td>{{$data->c_mobile}}</td>
                                    <td>{{$data->date_of_jurney}}</td>
                                    <td>{{$data->created_at}}</td>
                                    <td>{{$data->resident}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    @endsection
    @push('js')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script type="text/javascript">
            $(function() {
                var dateFormat = "dd-mm-yy";

                var today = new Date();
                var maxDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());

                $("#date").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: dateFormat,
                    maxDate: maxDate
                });
            });
        </script>
    @endpush