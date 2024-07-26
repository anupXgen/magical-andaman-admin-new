@section('content')
    @extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Booking Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-block">
                        <div class="row align-items-center justify-content-between">
                            <div class="h5 fw-semibold mb-0 col-5">Booking Details</div>

                            <div class="col-7 mt-sm-0 mt-2 align-items-center">
                                <form id='searchform' name='searchform' class="d-flex">
                                    <div class="input-group me-2">
                                        <select name="type" id="agent-select"class="select2 form-select">
                                            <option value="">Select</option>

                                            <option value="ferry" @if (request()->input('type') == 'ferry') selected @endif>
                                                Ferry
                                            </option>
                                            <option value="boat" @if (request()->input('type') == 'boat') selected @endif>
                                                Boat
                                            </option>
                                        </select>
                                    </div>
                                    <div class="input-group me-2">
                                        <input name="fromDate" value="{{ request()->input('fromDate', '') }}" type="text"
                                            id="fromDate" class="form-control" placeholder="YYYY-MM-DD">
                                    </div>

                                    <div class="input-group me-2">
                                        <input name="pnr_number" value="{{ request()->input('pnr_number', '') }}" type="text"
                                            id="pnr_number" class="form-control" placeholder="PNR Number" >
                                    </div>

                                    <div class="input-group">
                                        <input name="order_id"type="text" class="form-control" placeholder="Order Id"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                                    </div>

                                    <button class="btn btn-light btn-primary ms-2" type="submit" id="search-banner"><i
                                            class="ri-search-line"></i></button>
                                </form>
                                <div class="dropdown ms-2 d-none">
                                    <button class="btn btn-icon btn-primary-light btn-wave" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                </div>
                            
                            </div>

                        </div>
                    </div>
                    @if (count($booking_details) > 0)
                        <table id="Agent_booking" class="table table-striped w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Type</th>
                                    <th>Location</th>
                                    <th>Ship</th>
                                    <th>Journey Date</th>
                                    <th>Customer Name</th>
                                    <th>Mobile No</th>
                                    <th>PNR</th>
                                    <th>Pax</th>
                                    <th>Booking Date</th>
                                    <th>Status</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($booking_details as $booking_detail)
                                    <tr>
                                        <td>{{ $booking_detail->order_id }}</td>
                                        <td><button type="button" class="btn {{ $booking_detail->type == 'ferry' ? 'btn-primary' : 'btn-info' }} btn-sm">{{ ucfirst($booking_detail->type) }}</button></td>
                                        @if ($booking_detail->type == 'ferry')
                                            @php
                                                $locationKey =
                                                    $booking_detail->from_location . '-' . $booking_detail->to_location;
                                            @endphp

                                            @switch($locationKey)
                                                @case('Port Blair-Havelock')
                                                    <td>
                                                        PB - HL
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Havelock-Port Blair')
                                                    <td>
                                                        HL - PB
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Port Blair-Swaraj Dweep (Havelock)')
                                                    <td>
                                                        PB - HL
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Swaraj Dweep  (Havelock)-Port Blair')
                                                    <td>
                                                        HL - PB
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Port Blair-Swaraj Dweep')
                                                    <td>
                                                        PB - HL
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Swaraj Dweep-Port Blair')
                                                    <td>
                                                        HL - PB
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Port Blair-Shaheed Dweep (Neil)')
                                                    <td>
                                                        PB - NL
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Shaheed Dweep (Neil)-Port Blair ')
                                                    <td>
                                                        NL - PB
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Havelock-Shaheed Dweep (Neil)')
                                                    <td>
                                                        HL - NL
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Swaraj Dweep  (Havelock)-Shaheed Dweep (Neil)')
                                                    <td>
                                                        HL - NL
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Swaraj Dweep-Shaheed Dweep (Neil)')
                                                    <td>
                                                        HL - NL
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Shaheed Dweep (Neil)-Swaraj Dweep  (Havelock)')
                                                    <td>
                                                        NL - HL
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @case('Shaheed Dweep (Neil)-Swaraj Dweep')
                                                    <td>
                                                        NL - HL
                                                        <br>
                                                        <span>{{ date('H:i', strtotime($booking_detail->departure_time)) }}-{{ date('H:i', strtotime($booking_detail->arrival_time)) }}</span>
                                                    </td>
                                                @break

                                                @default
                                                    <td>No match found</td>
                                            @endswitch
                                        @else
                                            <td>{{ $booking_detail->ship_name }}</td>
                                        @endif

                                        @if($booking_detail->type == 'ferry')
                                            <td>{{ $booking_detail->ship_name }}</td>
                                        @else
                                            <td></td>
                                        @endif
                                        @php
                                            $dateOfJourney = \Carbon\Carbon::parse($booking_detail->date_of_jurney);
                                        @endphp
                                        <td>{{ $dateOfJourney->format('d-m-Y') }}</td>
                                        <td>{{ ucwords($booking_detail->c_name) }}</td>
                                        <td>{{ $booking_detail->c_mobile }}</td>

                                        @if($booking_detail->type == 'ferry')
                                        <td>{{$booking_detail->pnr_id}}</td>
                                        @else
                                        <td></td>
                                        @endif
                                        @if ($booking_detail->valid_passenger_count != 0 && $booking_detail->valid_passenger_count != null)
                                            <td>{{ $booking_detail->valid_passenger_count }}</td>
                                        @else
                                            <td>N/A</td>
                                        @endif


                                        <td>{{ date('d M,Y', strtotime($booking_detail->created_at)) }}</td>

                                        @if($booking_detail->ship_name == 'Makruzz' || $booking_detail->ship_name == 'Nautika')
                                            <td><button type="button" class="btn btn-success btn-sm">Confirmed</button></td>           
                                        @elseif($booking_detail->ship_name == 'Green Ocean')
                                            <td><button type="button" class="btn btn-info btn-sm">Pending</button></td>
                                        @else
                                            <td><button type="button" class="btn btn-success btn-sm">Confirmed</button></td>
                                        @endif
                                        <td>
                                            <a href="{{route('bookingdetails.show',$booking_detail->id)}}" class="btn btn-info btn-sm"> Details</a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $booking_details->appends(request()->input())->links('pagination::bootstrap-4') }}
                    @else
                        <h4 class="text-center">No Data Found</h4>
                    @endif


                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#fromDate').flatpickr({
                dateFormat: 'Y-m-d',
                maxDate: 'today'
            });
        });
    </script>
@endpush

@endsection
