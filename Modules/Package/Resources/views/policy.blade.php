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
                            <div class="h5 fw-semibold mb-0">policy</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <button href="javascript:void(0)" type="button" id="addpolicybtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"><i class="bx bx-plus side-menu__icon"></i> Add</button>
                                <input type="hidden" id="count_policy" name="count_policy" value="{{ !empty($package['policy'])?count($package['policy']):1 }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <form class="row g-3 mt-0" method="POST" action="{{ url('package/policy-save/'.$package['id']) }}" id="creation_form" name="creation_form">
                            @csrf
                            <div id="appendpolicyHere">
                                @if(!empty($package['policy']))
                                @foreach ($package['policy'] as $key => $policy)
                                <div class="row mb-4" id="policydiv{{ $key+1 }}">
                                    @if($key>0)
                                    <div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                                            <div class="h6 fw-semibold mb-0">policy Add</div><button href="javascript:void(0)" type="button" forid="{{ $key+1 }}" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removepolicybtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="hidden" id="policy_id{{ $key+1 }}" name="policy_id[{{ $key+1 }}]" value="{{ $policy['id'] }}">
                                    <div class="col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" placeholder="Policy" aria-label="Title" id="policy_title{{ $key+1 }}" name="policy_title[{{ $key+1 }}]" value="{{ $policy['title'] }}">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Subtitle</label>
                                        <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="policy_subtitle{{ $key+1 }}" name="policy_subtitle[{{ $key+1 }}]" rows='4' cols='50'>{{ $policy['subtitle'] }}</textarea>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="row mb-4" id="policydiv1">
                                    <input type="hidden" id="policy_id1" name="policy_id[1]" value="">
                                    <div class="col-md-4">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" placeholder="Policy" aria-label="Title" id="policy_title1" name="policy_title[1]">
                                    </div>
                                    <div class="col-md-8">
                                        <label class="form-label">Subtitle</label>
                                        <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="policy_subtitle1" name="policy_subtitle[1]" rows='4' cols='50'> </textarea>
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
    var uploadedDocumentMap = {}
    $(document).on("click", "#addpolicybtn", function() {
        var policy_count = $("#count_policy").val();
        policy_count++;
        var html = '<div class="row  mb-4" id="policydiv' + policy_count + '">' +
            '<input type="hidden" id="policy_id' + policy_count + '" name="policy_id[' + policy_count + ']" value="">' +
            '<div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;"><div class="d-sm-flex d-block align-items-center justify-content-between"><div class="h6 fw-semibold mb-0">policy Add</div><button href="javascript:void(0)" type="button" forid="' + policy_count + '" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removepolicybtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button></div></div>' +
            '<div class="col-md-4">' +
            '<label class="form-label">Title</label>' +
            '<input type="text" class="form-control" placeholder="Policy" aria-label="Title" id="policy_title' + policy_count + '" name="policy_title[' + policy_count + ']">' +
            '</div>' +
            '<div class="col-md-8">' +
            '<label class="form-label">Subtitle</label>' +
            '<textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="policy_subtitle' + policy_count + '" name="policy_subtitle[' + policy_count + ']" rows="4" cols="25"> </textarea>' +
            '</div>' +
            '</div>';
        $("#appendpolicyHere").append(html);
        $("#count_policy").val(policy_count);
    });
    $(document).on("click", ".removepolicybtn", function() {
        var getdivid = $(this).attr('forid');
        $("#policydiv" + getdivid + "").remove();
    });
    $(document).on('click', ".addpolicyBtn, .addTypeBtn, .addPolicyBtn", function() {
        var valueBtn = $(this).val();
        $("#redirectTo").val(valueBtn);
        $('.formSubmitBtn').click();
    });
    $(document).on('submit', "#creation_form", function(e) {
        //e.preventDefault();
        $(".invalid_msg").remove();
        var error = 0;
        var policy_count = $("#count_policy").val();
        for (var i = 1; i <= policy_count; i++) {
            if ($("#policy_title" + i).length > 0) {
                if ($.trim($("#policy_title" + i).val()) == '') {
                    $("#policy_title" + i + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_policy_title" + i + "'>Please enter a title.</div>");
                    $("#invalid_msg_policy_title" + i + "").show();
                    error++;
                }
            }
        }
        if (error == 0) {
            return true;
            $("#creation_form").submit();
        } else {
            return false;
        }

    });
</script>
@endpush