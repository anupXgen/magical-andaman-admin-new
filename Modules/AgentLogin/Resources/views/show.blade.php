@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Agent Booking Details</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-block">
                        <div class="row align-items-center justify-content-between">
                            <div class="h5 fw-semibold mb-0 col-4">Agent Booking Details</div>
                            <div class="h5 fw-semibold mb-0 col-4">
                                Agenet Booking Count : {{ $todayBookingCount }}
                            </div>
                            <div class="col-4 mt-sm-0 mt-2 align-items-center">
                                <form id='searchform' name='searchform' class="d-flex">
                                    <div class="input-group">
                                        <select name="agent_id" id="agent-select"class="select2 form-select">
                                            <option value="">Select</option>
                                            @foreach ($agent_logins as $agent)
                                                <option value="{{ $agent->id }}"
                                                    @if (request()->input('agent_id') == $agent->id) selected @endif>
                                                    {{ $agent->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button class="btn btn-light bg-transparent" type="submit" id="search-banner"><i
                                            class="ri-search-line text-muted"></i></button>

                                </form>
                                <div class="dropdown ms-2 d-none">
                                    <button class="btn btn-icon btn-primary-light btn-wave" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                </div>
                                {{-- <a href="{{ route('agentlogin.create') }}" class="btn btn-success ms-2">Create</a> --}}

                            </div>

                        </div>
                    </div>
                    @if (count($userWithBookings) > 0)
                        <table id="Agnet_booking" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Agent Name</th>
                                    <th>Agent Email</th>
                                    <th>Agent Contact Number</th>
                                    <th>Booking Type </th>
                                    <th>Customer Name</th>
                                    <th>Customer Contact Number</th>
                                    <th>Amount</th>
                                    <th>Bookng Date </th>

                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = $userWithBookings->firstItem();
                                @endphp
                                @foreach ($userWithBookings as $booking)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $booking->name }}</td>
                                        <td>{{ $booking->email ?? 'N/A' }}</td>
                                        <td>{{ $booking->phone ?? 'N/A' }}</td>
                                        <th>{{ $booking->type }}</td>
                                        <td>{{ $booking->c_name }}</td>
                                        <td>{{ $booking->c_mobile }}</td>
                                        <td>{{ $booking->amount }}</td>
                                        <td>{{ date('d M,Y', strtotime($booking->created_at)) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $userWithBookings->appends(request()->input())->links('pagination::bootstrap-4') }}
                    @else
                        <h4 class="text-center">No Data Found</h4>
                    @endif

                </div>
            </div>
        </div>
    </div>
    @if (count($userWithBookings) > 0)
        <div>
            <button id="print" type="button" class="btn btn-outline-primary"
                onclick="printDiv('Agnet_booking')">Print</button>
        </div>
    @endif


@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#agent-select').select2({
                placeholder: 'Select an agent',
                width: '100%'
            });
        });

        function printDiv(divName) {
            var originalTable = document.getElementById(divName);
            var clonedTable = originalTable.cloneNode(true);
            var printWindow = window.open('', '_blank');

            printWindow.document.write('<html><head><title>Print</title>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h1>Agent Booking Details</h1>');
            printWindow.document.write('<div class="table-responsive table-bordered text-nowrap">');
            printWindow.document.write(
                '<style>table {width: 100%;} th {border: 1px solid black; border-collapse: collapse;} td {border: 1px solid black; border-collapse: collapse; padding: 5px;}</style>'
            );
            printWindow.document.write(clonedTable.outerHTML);
            printWindow.document.write('</div>');
            printWindow.document.write('</body></html>');

            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
        }
    </script>
@endpush
