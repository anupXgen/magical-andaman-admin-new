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
                                <form id='searchform' name='searchform'>
                                    @csrf
                                    <div class="input-group">
                                        <select class="form-select" aria-label="Default select example" name="type">
                                            <option value="">ALL</option>
                                            <option value="ferry">FERRY</option>
                                            <option value="boat">BOAT</option>
                                        </select>
                                        {{-- <input type="text" class="form-control bg-light border-0" aria-describedby=""
                                            id='date' name='date' placeholder="Select Date"> --}}
                                        <button class="btn btn-light" type="submit" id="search-testimonial"><i
                                                class="ri-search-line text-muted"></i></button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card-body">
                        <table id=""  class="table table-striped w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Type</th>
                                    <th>Order Id</th>
                                    <th>Customer Name</th>
                                    <th>Mobile No</th>
                                    <th>Ship Name</th>
                                    <th>Date Of Journey</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                    use Carbon\Carbon;
                                @endphp
                                <tr>
                                    @foreach ($all_datas as $datas)
                                        @php

                                            $departureTime = Carbon::createFromFormat('H:i:s', $datas->departure_time);
                                            $arrivalTime = Carbon::createFromFormat('H:i:s', $datas->arrival_time);

                                            $totalSeconds = $arrivalTime->diffInSeconds($departureTime);

                                            $hours = floor($totalSeconds / 3600);
                                            $minutes = floor(($totalSeconds / 60) % 60);
                                            $seconds = $totalSeconds % 60;

                                            $formattedHours = str_pad($hours, 2, '0', STR_PAD_LEFT);
                                            $formattedMinutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
                                            $formattedSeconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);
                                        @endphp

                                        <th>{{ $i++ }}</th>
                                        <td><button type="button" class="btn {{ $datas->type == 'ferry' ? 'btn-primary' : 'btn-info' }} btn-sm">{{ ucfirst($datas->type) }}</button></td>

                                        <td>{{ $datas->order_id }}</td>
                                        <td>{{ ucfirst($datas->c_name) }}</td>
                                        <td>{{ $datas->c_mobile }}</td>
                                        <td>{{ $datas->ship_name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($datas->date_of_jurney)) }}

                                            - <span>{{ "{$formattedHours}:{$formattedMinutes}" }}

                                            </span>
                                            <br>
                                            <span>
                                                {{ $datas->from_location }} - {{ $datas->to_location }}

                                            </span>
                                        </td>
                                        <td>
                                            <a class="btn" href="{{ route('ticketcancellation.edit', $datas->id) }}"><i
                                                    class='bx bxs-show fs-4'></i></a>
                                        </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    @endsection
