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
                        <div class="h5 fw-semibold mb-0">Package Create</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('package.index') }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12">
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
                        <form class="row g-3 mt-0" method="POST" action="{{ route('package.store') }}" id="creation_form" name="creation_form">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Title" aria-label="Title" id="title" name="title">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subtitle</label>
                                <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="subtitle" name="subtitle" rows='4' cols='50'> </textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Duration</label>
                                <div class="d-sm-flex align-items-center justify-content-between">
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="Days" aria-label="Days" id="days" name="days" value="2">
                                        <span class="input-group-text" id="days-addon2">Days</span>
                                    </div>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="Nights" aria-label="Nights" id="nights" name="nights" value="1">
                                        <span class="input-group-text" id="nights-addon2">Nights</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Features</label>
                                <div class="d-sm-flex align-items-center justify-content-between form-control">
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="feature_night_stay" name="feature_night_stay" value='1'>
                                        <label class="form-check-label" for="feature_night_stay">
                                            Night Stay
                                        </label>
                                    </div>
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="feature_transport" name="feature_transport" value='1'>
                                        <label class="form-check-label" for="feature_transport">
                                            Transport
                                        </label>
                                    </div>
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="feature_activity" name="feature_activity" value='1'>
                                        <label class="form-check-label" for="feature_activity">
                                            Activity
                                        </label>
                                    </div>
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="feature_ferry" name="feature_ferry" value='1'>
                                        <label class="form-check-label" for="feature_ferry">
                                            Ferry
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Style</label>
                                <div class="d-sm-flex align-items-center justify-content-between form-control">
                                    
                                    @foreach($packageStyle as $row)
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="style_couple" name="package_style[]" value="{{ $row->id }}">
                                        <label class="form-check-label" for="style_couple">
                                            {{ $row->title }}
                                        </label>
                                    </div>
                                    @endforeach

                                    
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>
                                <div class="form-group form-control">
                                    <div class="needsclick dropzone" id="document-dropzone"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="hidden" id="redirectTo" name="redirectTo" value="">
                                <button type="button" class="btn btn-info-gradient btn-wave waves-effect waves-light label-btn addPolicyBtn" id="addPolicyBtn" value="policy">
                                    <i class="bi bi-suit-club label-btn-icon me-2"></i>
                                    Add Policy
                                </button>
                                {{-- <button type="button" class="btn btn-secondary-gradient btn-wave waves-effect waves-light label-btn addTypeBtn" id="addTypeBtn" value="typeprice">
                                    <i class="bi bi-stars label-btn-icon me-2"></i>
                                    Add Type & Price
                                </button> --}}
                                <button type="button" class="btn btn-primary-gradient btn-wave waves-effect waves-light label-btn addItineraryBtn" id="addItineraryBtn" value="itinerary">
                                    <i class="bi bi-image-alt label-btn-icon me-2"></i>
                                    Add Itinerary
                                </button>

                                {{-- <button type="button" class="btn btn-info-gradient btn-wave waves-effect waves-light label-btn addHotelBtn" id="addHotelBtn" value="hotel">
                                    <i class="bi bi-suit-club label-btn-icon me-2"></i>
                                    Add Hotel
                                </button>
                                <button type="button" class="btn btn-secondary-gradient btn-wave waves-effect waves-light label-btn addSightseeingBtn" id="addSightseeingBtn" value="sightseeing">
                                    <i class="bi bi-stars label-btn-icon me-2"></i>
                                    Add Sight Seeing
                                </button>
                                <button type="button" class="btn btn-primary-gradient btn-wave waves-effect waves-light label-btn addActivityBtn" id="addActivityBtn" value="activity">
                                    <i class="bi bi-image-alt label-btn-icon me-2"></i>
                                    Add Activity
                                </button> --}}
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
    Dropzone.options.documentDropzone = {
        url: "{{ url('upload-image') }}",
        maxFilesize: 25, // MB
        acceptedFiles: 'image/jpeg,image/jpg,',
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(file, response) {
            $("#invalid_msg_package_img").remove();
            //console.log(response)
            if (response.name != '') {
                $('form').append('<input type="hidden" name="package_img[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            }
        },
        removedfile: function(file) {
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }
            $('form').find('input[name="package_img[]"][value="' + name + '"]').remove();
            $('form').append('<input type="hidden" name="remove_package_img[]" value="' + name + '">')
        },
        init: function() {

        }
    }
    $(document).on('click', ".addItineraryBtn, .addTypeBtn, .addPolicyBtn, .addHotelBtn, .addSightseeingBtn, .addActivityBtn", function() {
        var valueBtn = $(this).val();
        $("#redirectTo").val(valueBtn);
        $('.formSubmitBtn').click();
    });
    $(document).on('submit', "#creation_form", function(e) {
        //e.preventDefault();
        $(".invalid_msg").remove();
        var error = 0;
        if ($.trim($("#title").val()) == '') {
            $("#title").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_title'>Please enter a title.</div>");
            $("#invalid_msg_title").show();
            error++;
        }
        if ($.trim($("#days").val()) == '' || $.trim($("#days").val()) == '0') {
            $("#days").parent().append("<div class='invalid-feedback invalid_msg' id='invalid_msg_days'>Please enter days no.</div>");
            $("#invalid_msg_days").show();
            error++;
        }
        if ($.trim($("#nights").val()) == '' || $.trim($("#nights").val()) == '0') {
            $("#nights").parent().append("<div class='invalid-feedback invalid_msg' id='invalid_msg_nights'>Please enter nights no.</div>");
            $("#invalid_msg_nights").show();
            error++;
        }
        var package_img = {};
        if ($("input[name='package_img[]']").length == 0) {
            $(".dz-message").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_package_img'>Please upload a image.</div>");
            $("#invalid_msg_package_img").show();
            error++;
        }
        if (error == 0) {
            return true;
            $("#creation_form").submit();
        } else {
            $("#redirectTo").val('');
            return false;
        }

    });
</script>
@endpush