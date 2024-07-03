@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Ferry Schedule</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-block">
                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                            <div class="h5 fw-semibold mb-0">Ferry Schedule</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <form id='searchform' name='searchform' action="{{ route('ferryschedule.index') }}"
                                    method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0"
                                            placeholder="Search Ferry Schedule" aria-describedby="search-contact-member"
                                            id='search_txt' name='search_txt'value="{{ request()->query('search_txt') }}">
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

                                <a href="{{ route('ferryschedule.create') }}" class="btn btn-success ms-2">Create</a>

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
                        @if ($ferry_schedules->isEmpty())
                            <p>No schedules found.</p>
                        @else
                            <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>From Location</th>
                                        <th>To Location </th>
                                        <th>From Date</th>
                                        <th>To Date</th>
                                        <th>ship_master</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $count = 1; // Initialize counter variable
                                    @endphp
                                    @foreach ($ferry_schedules as $ferry_schedule)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $ferry_schedule->from_location_title }}</td>
                                            <td>{{ $ferry_schedule->to_location_title }}</td>
                                            <td>{{ date('d M, y H:i', strtotime($ferry_schedule->from_date)) }}</td>
                                            <td>{{ date('d M, y H:i', strtotime($ferry_schedule->to_date)) }}</td>
                                            <td>{{ $ferry_schedule->ship_master_title }}</td>

                                            <td>
                                                @if ($ferry_schedule->status == 'Y')
                                                    <span class="badge bg-success">YES</span>
                                                @else
                                                    <span class="badge bg-warning">NO</span>
                                                @endif
                                            </td>

                                            <td>
                                                <a class="btn btn-info"
                                                    href="{{ route('ferryschedule.show', $ferry_schedule->id) }}">Show</a>
                                                @can('banner-edit')
                                                    <a class="btn btn-primary"
                                                        href="{{ route('ferryschedule.edit', $ferry_schedule->id) }}">Edit</a>
                                                @endcan
                                                @can('banner-delete')
                                                    {!! Form::open([
                                                        'method' => 'DELETE',
                                                        'route' => ['ferryschedule.destroy', $ferry_schedule->id],
                                                        'style' => 'display:inline',
                                                        'onsubmit' => 'return confirmDelete()',
                                                    ]) !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $ferry_schedules->links('pagination::bootstrap-4') }} --}}
                            {{ $ferry_schedules->appends(request()->input())->links('pagination::bootstrap-4') }}
                        @endif

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
