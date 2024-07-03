@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('boatschedule.index') }}">Location</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-block">
                    <div class="d-sm-flex d-block align-items-center justify-content-between">
                        <div class="h5 fw-semibold mb-0">Tour Location </div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('boatschedule.index') }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12 row">
                        <div class="col-md-6">
                            <label class="form-label">Title :</label>
                            <p class="text-muted fs-16">
                                {{ $boatschedules->title }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status :</label>
                            <p class="text-muted fs-16">
                                @if($boatschedules->status == 'Y')
                                <span class="badge bg-primary">Yes</span>
                                @else
                                <span class="badge bg-success">No</span>
                                @endif
                            </p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Image :</label>
                            <p class="text-muted fs-16">
                                @if ($boatschedules->image)
                                    <img src="{{asset('uploads/boat/'.$boatschedules->image)}}" alt="" width="200">
                                @else
                                    No image available.
                                @endif
                            </p>
                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection