@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">Banners</a></li>
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
                        <div class="h5 fw-semibold mb-0">Banner</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('banner.index') }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12 row">
                        <div class="col-md-6">
                            <label class="form-label">Title :</label>
                            <p class="text-muted fs-16">
                                {{ ($banner['title'])?$banner['title']:'' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subtitle :</label>
                            <p class="text-muted fs-16">
                                {{ ($banner['subtitle'])?$banner['subtitle']:'' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button Text :</label>
                            <p class="text-muted fs-16">
                                {{ ($banner['button_text'])?$banner['button_text']:'' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button Link :</label>
                            <p class="text-muted fs-16">
                                {{ ($banner['button_link'])?$banner['button_link']:'' }}
                            </p>
                        </div>

                        <div class="col-12 mr-2 ">
                        <label class="form-label">Banner Image :</label>
                            <div class="row">
                                @if(isset($banner['bannerimage']) && $banner['bannerimage'])
                                @foreach($banner['bannerimage'] as $key=>$val)
                                <div class="col-3 px-1" style="height: 200px; overflow: hidden;">
                                    <label class="form-label"></label>
                                    <img src="{{ url('/') .'/'.  $val['path']; }}" width="100%" height="100%" alt="Girl in a jacket">
                                </div>
                                @endforeach
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