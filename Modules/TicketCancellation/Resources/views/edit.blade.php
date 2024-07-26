@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Pessengers Details</li>
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
                            </div>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (!$querys->isEmpty())
                    <div>
                        <p>Book For : {{ $bookings->type }}</p>
                        <p>Order Id :{{ $bookings->order_id }}</p>
                        <p>Ship Name : {{ $bookings->ship_name }} </p>
                        @if ($bookings->type == 'ferry')
                        <p>Ferry Class : {{ $bookings->ferry_class }}</p>
                        @endif

                    </div>

                    <div class="card-body">
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Full Name</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Country</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                <tr>
                                    @foreach ($querys as $data)
                                        <th>{{ $i++ }}</th>
                                        <td>{{ ucfirst($data->full_name) }}</td>
                                        <td>{{ $data->dob }}</td>
                                        <td>{{ ucfirst($data->gender) }}</td>
                                        <td>
                                            {{ $data->country ?? 'INDIA' }}

                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                            <form action="{{ route('ticketcancellation.update', $bookings->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="id" value="{{ $bookings->id }}">
                                <button type="submit" class="btn btn-primary" onclick="return confirmDelete(); ">Cancel
                                    Request</button>
                            </form>
                     
                    </div>
                    @else
                    <h4 class="text-center">No Pessangers Data Found</h4>
                    @endif
                </div>
            </div>
        </div>
        <script>
            function confirmDelete() {
                return confirm('Are you sure you want to Cancel this Passenger?');
            }
        </script>
    @endsection
