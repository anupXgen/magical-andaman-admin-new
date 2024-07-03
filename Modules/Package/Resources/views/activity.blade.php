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
                            <div class="h5 fw-semibold mb-0">Activity</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <button href="javascript:void(0)" type="button" id="addactivitybtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"><i class="bx bx-plus side-menu__icon"></i> Add</button>
                                <input type="hidden" id="count_activity" name="count_activity" value="{{ !empty($package['packageactivity'])?count($package['packageactivity']):1 }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <form class="row g-3 mt-0" method="POST" action="{{ url('package/activity-save/'.$package['id']) }}" id="creation_form" name="creation_form">
                            @csrf
                            <div id="appendactivityHere">
                                @if(!empty($package['packageactivity']))
                                @foreach ($package['packageactivity'] as $key => $activity)
                                <div class="row mb-4" id="activitydiv{{ $key+1 }}">
                                    @if($key>0)
                                    <div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                                            <div class="h6 fw-semibold mb-0">activity Add</div><button href="javascript:void(0)" type="button" forid="{{ $key+1 }}" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removeactivitybtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="hidden" id="activity_id{{ $key+1 }}" name="activity_id[{{ $key+1 }}]" value="{{ $activity['id'] }}">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">activity</label>
                                        <select class="form-control activity_activity" placeholder="activity" aria-label="activity" id="activity{{ $key+1 }}" name="activity[{{ $key+1 }}]">
                                            <option value='0'>Select activity</option>
                                            @if(!empty($activityall))
                                            @foreach($activityall as $act)
                                            <option value="{{ $act['id'] }}" {{ ($act['id']==$activity['activity_id'])?"selected":"" }}>{{ $act['title'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="row mb-4" id="activitydiv1">
                                    <input type="hidden" id="activity_id1" name="activity_id[1]" value="">
                                    <div class="col-md-6 mb-2">
                                        <label class="form-label">Activity</label>
                                        <select class="form-control" placeholder="Activity" aria-label="Activity" id="activity1" name="activity[1]">
                                            <option value='0'>Select Activity</option>
                                            @if(!empty($activityall))
                                            @foreach($activityall as $act)
                                            <option value="{{ $act['id'] }}">{{ $act['title'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-light" onclick="javascript:activity.reload()">Cancel</button>
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
$activity_dropdown = '<option value="0">Select Activity</option>';
if(!empty($activityall)){
foreach($activityall as $act){
$activity_dropdown = $activity_dropdown.'<option value="'. $act['id'] .'">'. $act['title'] .'</option>';
}
}
@endphp
@endsection
@push('js')
<script type="text/javascript">
    var uploadedDocumentMap = {}
    $(document).on("click", "#addactivitybtn", function() {
        $(".invalid_msg").remove();
        var activity_count = $("#count_activity").val();
        if ($.trim($("#activity" + activity_count).val()) == '' || $.trim($("#activity" + activity_count).val()) == '0') {
            $("#activity" + activity_count + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_activity" + activity_count + "'>Please select activity.</div>");
            $("#invalid_msg_activity" + activity_count + "").show();
        } else if ($.trim($("#activity" + activity_count).val()) == '' || $.trim($("#activity" + activity_count).val()) == '0') {
            $("#activity" + activity_count + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_activity" + activity_count + "'>Please select activity.</div>");
            $("#invalid_msg_activity" + activity_count + "").show();
        } else {
            var dropdown = '{!! $activity_dropdown !!}';
            activity_count++;
            var html = '<div class="row mb-4" id="activitydiv' + activity_count + '">' +
                '<input type="hidden" id="activity_id' + activity_count + '" name="activity_id[' + activity_count + ']" value="">' +
                '<div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;"><div class="d-sm-flex d-block align-items-center justify-content-between"><div class="h6 fw-semibold mb-0">activity Add</div><button href="javascript:void(0)" type="button" forid="' + activity_count + '" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removeactivitybtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button></div></div>' +
                '<div class="col-md-6 mb-2">' +
                '<label class="form-label">activity</label>' +
                '<select class="form-control activity_activity" placeholder="activity" aria-label="activity" id="activity' + activity_count + '" name="activity[' + activity_count + ']">' +
                dropdown +
                '</select>' +
                '</div>' +
                '</div>';
            $("#appendactivityHere").append(html);
            $("#count_activity").val(activity_count);
        }
    });
    $(document).on("click", ".removeactivitybtn", function() {
        var getdivid = $(this).attr('forid');
        $("#activitydiv" + getdivid + "").remove();
    });
    $(document).on('click', ".addactivityBtn, .addTypeBtn, .addPolicyBtn", function() {
        var valueBtn = $(this).val();
        $("#redirectTo").val(valueBtn);
        $('.formSubmitBtn').click();
    });
    $(document).on('submit', "#creation_form", function(e) {
        //e.preventDefault();
        $(".invalid_msg").remove();
        var error = 0;
        var activity_count = $("#count_activity").val();
        for (var i = 1; i <= activity_count; i++) {
            if ($("#activity" + i).length > 0) {
                if ($.trim($("#activity" + i).val()) == '' || $.trim($("#activity" + i).val()) == '0') {
                    $("#activity" + i + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_activity" + i + "'>Please select Activity.</div>");
                    $("#invalid_msg_activity" + i + "").show();
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