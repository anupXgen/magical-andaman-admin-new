@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('destination.index') }}">destinations</a></li>
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
                        <div class="h5 fw-semibold mb-0">destination</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('destination.index') }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12 row">
                        <div class="col-md-6">
                            <label class="form-label">Name :</label>
                            <p class="text-muted fs-16">
                                {{ ($destination['name'])?$destination['name']:'' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subtitle :</label>
                            <p class="text-muted fs-16">
                                {{ ($destination['subtitle'])?$destination['subtitle']:'' }}
                            </p>
                        </div>

                        <div class="col-12 mr-2 ">

                            <div class="row">
                                @if(isset($destination['path']) && $destination['path'])
                                <div class="col-3 px-1" style="height: 200px; overflow: hidden;">
                                    <label class="form-label"></label>
                                    <img src="{{ url('/') .'/'.  $destination['path']; }}" width="100%" height="100%" alt="Girl in a jacket">
                                </div>
                                @endif
                            </div>

                        </div>


                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection