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
                            <label class="form-label">Featue :</label>
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
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagestyle']['couple']) && $package['packagestyle']['couple']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Couple
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagestyle']['honeymoon']) && $package['packagestyle']['honeymoon']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Honeymoon
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagestyle']['senior']) && $package['packagestyle']['senior']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Senior
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagestyle']['friends']) && $package['packagestyle']['friends']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Friends
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center">
                                        @if(!empty($package['packagestyle']['solo']) && $package['packagestyle']['solo']==1)
                                        <i class="bi bi-check-square-fill text-green"></i>
                                        @else
                                        <i class="bi bi-x-lg"></i>
                                        @endif
                                        <div class="ms-2 fw-semibold text-muted">
                                            Solo
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 mr-2 mb-4">
                            <div class="row">
                                @if(isset($package['packageimage']) && $package['packageimage'])
                                @foreach($package['packageimage'] as $key=>$val)
                                <div class="col-3 px-1" style="height: 200px; overflow: hidden;">
                                    <label class="form-label"></label>
                                    <img src="{{ url('/') .'/'.  $val['path']; }}" width="100%" height="100%" alt="">
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
                            <div class="h5 fw-semibold mb-0">Sight Seeing</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <button href="javascript:void(0)" type="button" id="addsightseeingbtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"><i class="bx bx-plus side-menu__icon"></i> Add</button>
                                <input type="hidden" id="count_sightseeing" name="count_sightseeing" value="{{ !empty($package['packagesightseeing'])?count($package['packagesightseeing']):1 }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <form class="row g-3 mt-0" method="POST" action="{{ url('package/sightseeing-save/'.$package['id']) }}" id="creation_form" name="creation_form">
                            @csrf
                            <div id="appendsightseeingHere">
                                @if(!empty($package['packagesightseeing']))
                                @foreach ($package['packagesightseeing'] as $key => $sightseeing)
                                <div class="row mb-4" id="sightseeingdiv{{ $key+1 }}">
                                    @if($key>0)
                                    <div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                                            <div class="h6 fw-semibold mb-0">sightseeing Add</div><button href="javascript:void(0)" type="button" forid="{{ $key+1 }}" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removesightseeingbtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="hidden" id="sightseeing_id{{ $key+1 }}" name="sightseeing_id[{{ $key+1 }}]" value="{{ $sightseeing['id'] }}">
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Location</label>
                                        <select class="form-control location_sightseeing" placeholder="Location" aria-label="Location" id="location{{ $key+1 }}" name="location[{{ $key+1 }}]">
                                            <option value='0'>Select Location</option>
                                            @if(!empty($location))
                                            @foreach($location as $loc)
                                            <option value="{{ $loc['id'] }}" {{ ($loc['id']==$sightseeing['location_id'])?"selected":"" }}>{{ $loc['name'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">sightseeing</label>
                                        <select class="form-control " placeholder="sightseeing" aria-label="sightseeing" id="sightseeing{{ $key+1 }}" name="sightseeing[{{ $key+1 }}]">
                                            @if(!empty($location))
                                            @foreach($location as $loc)
                                            @if($loc['id']==$sightseeing['location_id'])
                                            @if(!empty($loc['packagesightseeinglocation']))
                                            @foreach($loc['packagesightseeinglocation'] as $loc_sightseeing)
                                            <option value="{{ $loc_sightseeing['id'] }}" {{ ($loc_sightseeing['id']==$sightseeing['sightseeing_id'])?"selected":"" }}>{{ $loc_sightseeing['title'] }}</option>
                                            @endforeach
                                            @endif
                                            @endif
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="row mb-4" id="sightseeingdiv1">
                                    <input type="hidden" id="sightseeing_id1" name="sightseeing_id[1]" value="">
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Location</label>
                                        <select class="form-control location_sightseeing" placeholder="Location" aria-label="Location" id="location1" name="location[1]">
                                            <option value='0'>Select Location</option>
                                            @if(!empty($location))
                                            @foreach($location as $loc)
                                            <option value="{{ $loc['id'] }}">{{ $loc['name'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">sightseeing</label>
                                        <select class="form-control " placeholder="sightseeing" aria-label="sightseeing" id="sightseeing1" name="sightseeing[1]">
                                            <option value='0'>Select Location First</option>
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
@php
$oninput_valid = 'oninput="this.value = this.value.replace(/[^0-9.]/g, \'\').replace(/(\..*)\./g, \'$1\').replace(/(\.\d\d)\d/g, \'$1\');"';
$location_dropdown = '<option value="0">Select Location</option>';
if(!empty($location)){
foreach($location as $loc){
$location_dropdown = $location_dropdown.'<option value="'. $loc['id'] .'">'. $loc['name'] .'</option>';
}
}
@endphp
@endsection
@push('js')
<script type="text/javascript">
    $(document).on("change", ".location_sightseeing", function() {
        var loc_id = $(this).val();
        var selectid = $(this).attr('id').replace('location', 'sightseeing');
        if ($.trim(loc_id) != '') {
            $("#" + selectid).html('');
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
                        $("#" + selectid).html("<option value='0'>Loading....</option>");
                    }, 10);
                },
                complete: function() {},
                success: function(data, textStatus, jqXHR) {
                    $("#" + selectid).html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        }
    });
    var uploadedDocumentMap = {}
    $(document).on("click", "#addsightseeingbtn", function() {
        $(".invalid_msg").remove();
        var sightseeing_count = $("#count_sightseeing").val();
        if ($.trim($("#location" + sightseeing_count).val()) == '' || $.trim($("#location" + sightseeing_count).val()) == '0') {
            $("#location" + sightseeing_count + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_location" + sightseeing_count + "'>Please select location.</div>");
            $("#invalid_msg_location" + sightseeing_count + "").show();
        } else if ($.trim($("#sightseeing" + sightseeing_count).val()) == '' || $.trim($("#sightseeing" + sightseeing_count).val()) == '0') {
            $("#sightseeing" + sightseeing_count + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_sightseeing" + sightseeing_count + "'>Please select sightseeing.</div>");
            $("#invalid_msg_sightseeing" + sightseeing_count + "").show();
        } else {
            var dropdown = '{!! $location_dropdown !!}';
            sightseeing_count++;
            var html = '<div class="row mb-4" id="sightseeingdiv' + sightseeing_count + '">' +
                '<input type="hidden" id="sightseeing_id' + sightseeing_count + '" name="sightseeing_id[' + sightseeing_count + ']" value="">' +
                '<div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;"><div class="d-sm-flex d-block align-items-center justify-content-between"><div class="h6 fw-semibold mb-0">sightseeing Add</div><button href="javascript:void(0)" type="button" forid="' + sightseeing_count + '" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removesightseeingbtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button></div></div>' +
                '<div class="col-md-3 mb-2">' +
                '<label class="form-label">Location</label>' +
                '<select class="form-control location_sightseeing" placeholder="Location" aria-label="Location" id="location' + sightseeing_count + '" name="location[' + sightseeing_count + ']">' +
                dropdown +
                '</select>' +
                '</div>' +
                '<div class="col-md-6 mb-2">' +
                '<label class="form-label">sightseeing</label>' +
                '<select class="form-control " placeholder="sightseeing" aria-label="sightseeing" id="sightseeing' + sightseeing_count + '" name="sightseeing[' + sightseeing_count + ']">' +
                '<option value="0">Select Location First</option>' +
                '</select>' +
                '</div>' +
                '</div>';
            $("#appendsightseeingHere").append(html);
            $("#count_sightseeing").val(sightseeing_count);
        }
    });
    $(document).on("click", ".removesightseeingbtn", function() {
        var getdivid = $(this).attr('forid');
        $("#sightseeingdiv" + getdivid + "").remove();
    });
    $(document).on('click', ".addsightseeingBtn, .addTypeBtn, .addPolicyBtn", function() {
        var valueBtn = $(this).val();
        $("#redirectTo").val(valueBtn);
        $('.formSubmitBtn').click();
    });
    $(document).on('submit', "#creation_form", function(e) {
        //e.preventDefault();
        $(".invalid_msg").remove();
        var error = 0;
        var sightseeing_count = $("#count_sightseeing").val();
        for (var i = 1; i <= sightseeing_count; i++) {
            if ($("#location" + i).length > 0) {
                if ($.trim($("#location" + i).val()) == '' || $.trim($("#location" + i).val()) == '0') {
                    $("#location" + i + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_location" + i + "'>Please select location.</div>");
                    $("#invalid_msg_location" + i + "").show();
                    error++;
                }
                if ($.trim($("#sightseeing" + i).val()) == '' || $.trim($("#sightseeing" + i).val()) == '0') {
                    $("#sightseeing" + i + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_sightseeing" + i + "'>Please select sightseeing.</div>");
                    $("#invalid_msg_sightseeing" + i + "").show();
                    error++;
                }
            }
        }
        //alert(error)
        if (error == 0) {
            return true;
            $("#creation_form").submit();
        } else {
            return false;
        }

    });
</script>
@endpush