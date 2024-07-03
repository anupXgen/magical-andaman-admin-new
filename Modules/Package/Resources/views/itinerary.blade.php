@extends('layouts.app')

@section('content')
<style>
    input[type="file"] {
        display: block;
    }

    .imageThumb {
        max-height: 75px;
        border: 2px solid;
        padding: 1px;
        cursor: pointer;
    }

    .pip {
        display: inline-block;
        margin: 10px 10px 0 0;
    }

    .remove {
        display: block;
        background: #444;
        border: 1px solid black;
        color: white;
        text-align: center;
        cursor: pointer;
    }

    .remove:hover {
        background: white;
        color: black;
    }
</style>
<?php
    // echo"<pre>";
    // print_r($package['itinerary']);
    // die();
?>

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('package.index') }}">Packages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12"> 
            <div class="card custom-card">
                <div class="card-header d-block">
                    <div class="d-sm-flex d-block align-items-center justify-content-between">
                        <div class="h5 fw-semibold mb-0">Package Details</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ URL::previous() }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12 row">
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="col-md-6">
                            <label class="form-label">Title :</label>
                            <p class="text-muted fs-16">
                                {{ ($package['title'])?$package['title']:'' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Subtitle :</label>
                            <p class="text-muted fs-16">
                                {{ ($package['subtitle'])?$package['subtitle']:'' }}
                            </p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Feature :</label>
                            <ul class="list-group list-group-horizontal">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagefeature']['night_stay']) && $package['packagefeature']['night_stay']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Night Stay
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagefeature']['transport']) && $package['packagefeature']['transport']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Transport
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagefeature']['activity']) && $package['packagefeature']['activity']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Activity
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagefeature']['ferry']) && $package['packagefeature']['ferry']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Ferry
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Style :</label>
                            <ul class="list-group list-group-horizontal">
                            @foreach($packageStyle as $row)
                            @if(in_array($row->id, $packageStyleId))
                                <div class="form-check form-check-md d-flex align-items-center list-group-item">
                                    <label class="form-check-label " for="style_couple">
                                    <i class="bi bi-check-square-fill text-green"></i> {{ $row->title }}
                                    </label>
                                </div>
                            @endif
                               @endforeach
                            </ul>
                        </div>
                        <div class="col-12 mr-2 mb-4">
                            <div class="row">
                                @if(isset($package['packageimage']) && $package['packageimage'])
                                @foreach($package['packageimage'] as $key=>$val)
                                <div class="col-3 px-1" style="height: 200px; overflow: hidden;">
                                    <label class="form-label"></label>
                                    <img src="{{ url('/') .'/'.  $val['path']}}" width="100%" height="100%" alt="">
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card custom-card">
                <div class="card-body">
                    <div class="card-header d-block mb-4" style="background-color: #c8d8f4!important;">
                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                            <div class="h5 fw-semibold mb-0">Itinerary</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <button href="javascript:void(0)" type="button" id="additinerarybtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"><i class="bx bx-plus side-menu__icon"></i> Add</button>
                                <input type="hidden" id="count_itinerary" name="count_itinerary" value="{{ !empty($package['itinerary'])?count($package['itinerary']):1 }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <form class="row g-3 mt-0" method="POST" action="{{ url('package/itinerary-save/'.$package['id']) }}" id="creation_form" name="creation_form">
                            @csrf
                            <input type="hidden" name="package_id" value="{{$package['id']}}">
                            <div id="appenditineraryHere">
                                @if(!empty($package['itinerary']))
                                @foreach ($package['itinerary'] as $key => $itinerary)

                                <div class="row mb-4" id="itinerarydiv{{ $key+1 }}">
                                    @if($key>0)
                                    <div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                                            <div class="h6 fw-semibold mb-0">itinerary Add</div><button href="javascript:void(0)" type="button" forid="{{ $key+1 }}" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removeitinerarybtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="hidden" id="itinerary_id{{ $key+1 }}" name="itinerary_id[{{ $key+1 }}]" value="{{ $itinerary['id'] }}">
                                    <div class="col-md-6">
                                        <label class="form-label">Itinerary Day</label>
                                        <input readonly type="text" class="form-control" placeholder="" aria-label="Title" id="itinerary_day{{ $key+1 }}" name="itinerary_day[{{ $key+1 }}]" value="Day {{$key+1 }}">
                                    </div>

                                    <div class="col-md-6 ">
                                        <label class="form-label">Location</label>
                                        <select class="form-control select_location" name="location_id[{{ $key+1 }}]" id="location_id">
                                            <option value="">Select location</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}" {{ ($location->id == $itinerary['location_id']) ? 'selected' : '' }}>
                                                    {{ $location->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label">Title</label>
                                        <input  type="text" class="form-control" placeholder="Title" aria-label="Title" id="itinerary_title" name="itinerary_title[{{ $key+1 }}]" value="{{ $itinerary['title'] }}" >
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Subtitle</label>
                                        <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="itinerary_subtitle{{ $key+1 }}" name="itinerary_subtitle[{{ $key+1 }}]" rows='2' cols='25'>{{ $itinerary['subtitle'] }}</textarea>
                                    </div>
                                   
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Itinerary Sightseeing</label>
                                        <select class="form-control" name="sightseeing_id[{{ $key+1 }}]" id="sightseeing_id">
                                            <option value="">Select Sightseeing</option>
                                            @foreach($sightseeeing_id as $sightseeings)
                                                <option value="{{ $sightseeings->id }}" {{ ($sightseeings->id ==$itinerary['sightseeing_id']) ? 'selected' : '' }}>
                                                    {{ $sightseeings->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Itinerary Hotel</label>
                                        <select class="form-control" name="hotel_id[{{ $key+1 }}]" id="hotel_id">
                                            <option value="">Select Hotel</option>
                                            @foreach($hotel_id as $hotel)
                                                <option value="{{ $hotel->id }}" {{ ($hotel->id == $itinerary['hotel_id']) ? 'selected' : '' }}>
                                                    {{ $hotel->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Hotel Category</label>
                                        <select class="form-control sightseeing" name="hotel_category[{{ $key+1 }}]" id="hotel_category[{{ $key+1 }}]">
                                            <option value="">Select Hotel Category</option>
                                            @foreach($hotel_category as $cat)
                                                <option value="{{ $cat->id }}"{{ ($cat->id == $itinerary['hotel_category']) ? 'selected' : '' }}>
                                                    {{ $cat->category_title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Itinerary Activity</label>
                                        <select class="form-control" name="activity_id[{{ $key+1 }}]" id="activity_id">
                                            <option value="">Select Activity</option>
                                            @foreach($activity_id as $activity)
                                                <option value="{{ $activity->id }}" {{ ($activity->id == $itinerary['activity_id']) ? 'selected' : '' }}>
                                                    {{ $activity->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="row mb-4" id="itinerarydiv1">
                                    <input type="hidden" id="itinerary_id1" name="itinerary_id[1]" value="">
                                    <div class="col-md-6">
                                        <label class="form-label">Itinerary Day</label>
                                        <input readonly type="text" class="form-control" placeholder="" aria-label="Title" id="itinerary_day{{ $key+1 }}" name="itinerary_day[{{ $key+1 }}]" value="Day {{$key+1 }}">
                                    </div>
                                    <div class="col-md-6 ">
                                        <label class="form-label">Location</label>
                                        <select class="form-control select_location" name="location_id[{{ $key+1 }}]" id="location_id[{{ $key+1 }}]" data-id="{{ $key+1 }}">
                                            <option value="">Select location</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}" {{ ($location->id == $location->name) ? 'selected' : '' }}>
                                                    {{ $location->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" placeholder="" aria-label="Title" id="itinerary_title" name="itinerary_title[{{ $key+1 }}]" >
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Subtitle</label>
                                        <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="itinerary_subtitle1" name="itinerary_subtitle[{{ $key+1 }}]" rows='2' cols='25'> </textarea>
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>
                                        <div class="form-group form-control">
                                            <div class="needsclick dropzone" id="itineraryimage1-dropzone"></div>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Itinerary Hotel</label>
                                        <select class="form-control hotel" name="hotel_id[{{ $key+1 }}]" id="hotel_id[{{ $key+1 }}]">
                                            <option value="">Select Hotel</option>
                                            @foreach($hotel_id as $hotel)
                                                <option value="{{ $hotel->id }}" {{ ($hotel->id == $hotel->property_types_id) ? 'selected' : '' }}>
                                                    {{ $hotel->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Hotel Category</label>
                                        <select class="form-control hotel_cat" name="hotel_category[{{ $key+1 }}]" id="hotel_category[{{ $key+1 }}]">
                                            <option value="">Select Hotel Category</option>
                                            @foreach($hotel_category as $cat)
                                                <option value="{{ $cat->id }}">
                                                    {{ $cat->category_title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Itinerary Activity</label>
                                        <select class="form-control activity" name="activity_id[{{ $key+1 }}]" id="activity_id[{{ $key+1 }}]">
                                            <option value="">Select Activity</option>
                                            @foreach($activity_id as $activity)
                                                <option value="{{ $activity->id }}" {{ ($activity->id == $activity->title) ? 'selected' : '' }}>
                                                    {{ $activity->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label">Itinerary Sightseeing</label>
                                        <select class="form-control sightseeing" name="sightseeing_id[{{ $key+1 }}]" id="sightseeing_id[{{ $key+1 }}]">
                                            <option value="">Select Sightseeing</option>
                                            @foreach($sightseeeing_id as $sightseeings)
                                                <option value="{{ $sightseeings->id }}" {{ ($sightseeings->id == $sightseeings->title) ? 'selected' : '' }}>
                                                    {{ $sightseeings->title}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-light" onclick="javascript:location.reload()">Cancel</button>
                                <button type="submit" class="btn btn-primary formSubmitBtn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script type="text/javascript">
var uploadedDocumentMap = {};

$(document).on("click", "#additinerarybtn", function() {
    var itinerary_count = parseInt($("#count_itinerary").val());
    itinerary_count++;
    $("#count_itinerary").val(itinerary_count);

    var html = 
        '<div class="row mb-4" id="itinerarydiv' + itinerary_count + '">' +
            '<input type="hidden" id="itinerary_id' + itinerary_count + '" name="itinerary_id[' + itinerary_count + ']" value="">' +
            '<div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;">' +
                '<div class="d-sm-flex d-block align-items-center justify-content-between">' +
                    '<div class="h6 fw-semibold mb-0">Itinerary Add</div>' +
                    '<button type="button" forid="' + itinerary_count + '" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removeitinerarybtn">' +
                        '<i class="bx bx-minus side-menu__icon"></i> Remove' +
                    '</button>' +
                '</div>' +
            '</div>' +

            '<div class="col-md-6">' +
                '<label class="form-label">Itinerary Day</label>' +
                '<input readonly type="text" class="form-control" placeholder="" aria-label="Title" id="itinerary_day' + itinerary_count + '" name="itinerary_day[' + itinerary_count + ']" value="Day ' + itinerary_count + '">' +
            '</div>' +

            '<div class="col-md-6 mt-3">' +
                '<label class="form-label">Location</label>' +
                '<select class="form-control select_location" name="location_id[]" id="location_id[' + itinerary_count + ']" data-id="[' + itinerary_count + ']">' +
                    '<option value="">Select Location</option>' +
                    '@foreach($locations as $location)' +
                        '<option value="{{ $location->id }}" {{ ($location->id == $location->name) ? "selected" : "" }}>' +
                            '{{ $location->name }}' +
                        '</option>' +
                    '@endforeach' +
                '</select>' +
            '</div>'+


            '<div class="col-md-6">' +
                '<label class="form-label">Title</label>' +
                '<input type="text" class="form-control" placeholder="Title" aria-label="Title" id="itinerary_title' + itinerary_count + '" name="itinerary_title[' + itinerary_count + ']">' +
            '</div>' +

            '<div class="col-md-6 mt-3">' +
                '<label class="form-label">Subtitle</label>' +
                '<textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="itinerary_subtitle' + itinerary_count + '" name="itinerary_subtitle[' + itinerary_count + ']" rows="2" cols="25"></textarea>' +
            '</div>' +

          

            '<div class="col-md-6 mt-3">' +
                '<label class="form-label">Itinerary Hotel</label>' +
                '<select class="form-control hotel" name="hotel_id[' + itinerary_count + ']" id="hotel_id[' + itinerary_count + ']">' +
                    '<option value="">Select Hotel</option>' +
                    '@foreach($hotel_id as $hotel)' +
                        '<option value="{{ $hotel->id }}" {{ ($hotel->id == $hotel->property_types_id) ? "selected" : "" }}>' +
                            '{{ $hotel->title }}' +
                        '</option>' +
                    '@endforeach' +
                '</select>' +
            '</div>' +

            '<div class="col-md-6 mt-3">' +
                '<label class="form-label">Hotel Category</label>' +
                '<select class="form-control hotel_cat" name="hotel_category[' + itinerary_count + ']" id="hotel_category[' + itinerary_count + ']">' +
                    '<option value="">Select Hotel Category</option>' +
                    '@foreach($hotel_category as $cat)' +
                        '<option value="{{ $cat->id }}">' +
                            '{{ $cat->category_title }}' +
                        '</option>' +
                    '@endforeach' +
                '</select>' +
            '</div>'+

            '<div class="col-md-6 mt-3">' +
                '<label class="form-label">Itinerary Sightseeing</label>' +
                '<select class="form-control sightseeing" name="sightseeing_id[' + itinerary_count + ']" id="sightseeing_id[' + itinerary_count + ']">' +
                    '<option value="">Select Sightseeing</option>' +
                    '@foreach($sightseeeing_id as $sightseeings)' +
                        '<option value="{{ $sightseeings->id }}" {{ ($sightseeings->id == $sightseeings->title) ? "selected" : "" }}>' +
                            '{{ $sightseeings->title }}' +
                        '</option>' +
                    '@endforeach' +
                '</select>' +
            '</div>' +

            '<div class="col-md-6 mt-3">' +
                '<label class="form-label">Itinerary Activity</label>' +
                '<select class="form-control activity" name="activity_id[' + itinerary_count + ']" id="activity_id[' + itinerary_count + ']">' +
                    '<option value="">Select Activity</option>' +
                    '@foreach($activity_id as $activity)' +
                        '<option value="{{ $activity->id }}" {{ ($activity->id == $activity->title) ? "selected" : "" }}>' +
                            '{{ $activity->title }}' +
                        '</option>' +
                    '@endforeach' +
                '</select>' +
            '</div>' +
        '</div>';

    $("#appenditineraryHere").append(html);
    $("#count_itinerary").val(itinerary_count);

    $('#itineraryimage' + itinerary_count + '-dropzone').dropzone({
        url: "{{ url('upload-image') }}",
        maxFilesize: 25, // MB
        acceptedFiles: 'image/jpeg,image/jpg,',
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(file, response) {
            var getdivid = $(this)[0].element.id;
            var divid = getdivid.replace('-dropzone', '');
            $("#invalid_msg_" + divid + "_img").remove();
            if (response.name != '') {
                $('form').append('<input type="hidden" name="' + divid + '_img[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            }
        },
    });
});
    $(document).on("click", ".removeitinerarybtn", function() {
        var getdivid = $(this).attr('forid');
        $("#itinerarydiv" + getdivid + "").remove();
    });

    //Dropzone.options.documentDropzone = {
    $('.dropzone').dropzone({
        url: "{{ url('upload-image') }}",
        maxFilesize: 25, // MB
        acceptedFiles: 'image/jpeg,image/jpg,',
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(file, response) {
            var getdivid = $(this)[0].element.id;
            var divid = getdivid.replace('-dropzone', '');
            //alert(divid);
            //$('#' + getdivid + ' a[class*="dz-remove"]').attr('idfor', divid);
            $("#invalid_msg_" + divid + "_img").remove();
            //console.log(response)
            if (response.name != '') {
                $('form').append('<input type="hidden" name="' + divid + '_img[]" value="' + response.name + '"  org_name="' + response.original_name + '">')
                uploadedDocumentMap[file.name] = response.name
            }
        },
        removedfile: function(file) {
            var getdivid = $(this)[0].element.id;
            var divid = getdivid.replace('-dropzone', '');
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }
            if (name == '' || typeof file.name !== 'undefined') {
                name = file.name
            }
            //console.log(file);
            var is_exists_ids = $('form').find('input[name="' + divid + '_img[]"][value="' + name + '"]').attr('imgids');
            if (is_exists_ids && is_exists_ids !== 'undefined') {
                $('form').append('<input type="hidden" name="exists_remove_' + divid + '_img[' + is_exists_ids + ']" value="' + name + '">');
                $('form').find('input[name="' + divid + '_img[]"][value="' + name + '"]').remove();
            } else {
                $('form').find('input[name="' + divid + '_img[]"][org_name="' + name + '"]').remove();
            }
            $('form').append('<input type="hidden" name="remove_' + divid + '_img[]" value="' + name + '">');
        },
        init: function() {
            var getdivid = $(this)[0].element.id;
            var divid = getdivid.replace('-dropzone', '');
            var itineraryid = divid.replace('itineraryimage', '');
            @if(isset($package['itinerary']) && $package['itinerary'])
            var base_path = "{{url('/')}}";
            var files = {!! json_encode($package['itinerary']) !!};
            console.log(files[itineraryid - 1])
            for (var i in files[itineraryid - 1]['itineraryimage']) {
                var base_path = "{{url('/')}}";
                var lastPart = files[itineraryid - 1]['itineraryimage'][i].path.split("/").pop().split('?')[0];
                var imagename = lastPart;
                var mockFile = {
                    id: files[itineraryid - 1]['itineraryimage'][i].id,
                    name: imagename,
                    size: files[itineraryid - 1]['itineraryimage'][i].size
                };
                var filepath = base_path + '/' + files[itineraryid - 1]['itineraryimage'][i].path
                //console.log('mockFile', mockFile)
                this.emit("addedfile", mockFile);
                //this.emit("thumbnail", mockFile, filepath);
                this.options.thumbnail.call(this, mockFile, filepath);
                this.emit("complete", mockFile);
                $('form').append('<input type="hidden" class="itineraryImgclass" name="' + divid + '_img[]" value="' + imagename + '" is_exists="1" imgids="' + files[itineraryid - 1]['itineraryimage'][i].id + '" >')
            }
            @endif
        }
    })


    $(document).on('click', ".addItineraryBtn, .addTypeBtn, .addPolicyBtn", function() {
        var valueBtn = $(this).val();
        $("#redirectTo").val(valueBtn);
        $('.formSubmitBtn').click();
    });
    $(document).on('submit', "#creation_form", function(e) {
        //e.preventDefault();
        $(".invalid_msg").remove();
        var error = 0;
        var itinerary_count = $("#count_itinerary").val();
        for (var i = 1; i <= itinerary_count; i++) {
            if ($("#itinerary_title" + i).length > 0) {
                if ($.trim($("#itinerary_title" + i).val()) == '') {
                    $("#itinerary_title" + i + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_itinerary_title" + i + "'>Please enter a title.</div>");
                    $("#invalid_msg_itinerary_title" + i + "").show();
                    error++;
                }
               
            }
        }
        //alert(error)

    });

    //location wise dropdown filter
    $(document).on("change", ".select_location", function() {
        var loc_id = $(this).val();
        var selectid = $(this).data("id");
        var hotel_id = 'hotel_id\\[' + selectid + '\\]';
        
        if ($.trim(loc_id) != '') {
            $("#" + hotel_id).html('');
            var APP_URL = "{{ url('/') }}";
            $.ajax({
                type: "GET",
                url: APP_URL + '/package/get-hotel-by-location/' + loc_id,
                datatype: "json",
                beforeSend: function() {
                    setTimeout(function() {
                        $("#" + hotel_id).html("<option value='0'>Loading....</option>");
                    }, 10);
                },
                complete: function() {},
                success: function(data, textStatus, jqXHR) {
                    $('#' + hotel_id).html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        }
    });

    $(document).on("change", ".select_location", function() {
        var loc_id = $(this).val();
        var selectid = $(this).data("id");
        var sightseeing_id = 'sightseeing_id\\[' + selectid + '\\]';
        if ($.trim(loc_id) != '') {
            $("#" + sightseeing_id).html('');
            var APP_URL = "{{ url('/') }}";
            $.ajax({
                type: "GET",
                url: APP_URL + '/package/get-sightseeing-by-location/' + loc_id,
                datatype: "json",
                // data: {
                //     'loc_id': loc_id
                // },
                beforeSend: function() {
                    setTimeout(function() {
                        $("#" + sightseeing_id).html("<option value='0'>Loading....</option>");
                    }, 10);
                },
                complete: function() {},
                success: function(data, textStatus, jqXHR) {
                    $("#" + sightseeing_id).html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        }
    });

    $(document).on("change", ".select_location", function() {
        var loc_id = $(this).val();
        var selectid = $(this).data("id");
        var activity_id = 'activity_id\\[' + selectid + '\\]';
        if ($.trim(loc_id) != '') {
            $("#" + activity_id).html('');
            var APP_URL = "{{ url('/') }}";
            $.ajax({
                type: "GET",
                url: APP_URL + '/package/get-activity-by-location/' + loc_id,
                datatype: "json",
                // data: {
                //     'loc_id': loc_id
                // },
                beforeSend: function() {
                    setTimeout(function() {
                        $("#" + activity_id).html("<option value='0'>Loading....</option>");
                    }, 10);
                },
                complete: function() {},
                success: function(data, textStatus, jqXHR) {
                    $("#" + activity_id).html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        }
    });
</script>
@endpush