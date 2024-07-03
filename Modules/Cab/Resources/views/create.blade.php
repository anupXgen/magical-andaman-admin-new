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
                    <li class="breadcrumb-item"><a href="{{ route('cab.index') }}">Cabs</a></li>
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
                        <div class="h5 fw-semibold mb-0">Cab Create</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('cab.index') }}" class="btn btn-warning-light ms-2">Back</a>
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
                        <form class="row g-3 mt-0" method="POST" action="{{ route('cab.store') }}" id="creation_form" name="creation_form">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Title" aria-label="Title" id="title" name="title">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">From Location</label>
                                <select class="form-control" placeholder="From Location" aria-label="From Location" id="from_location" name="from_location">
                                    <option value='0'>Select Location</option>
                                    @if(!empty($location))
                                    @foreach($location as $loc)
                                    <option value="{{ $loc['id'] }}">{{ $loc['name'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">To Location</label>
                                <select class="form-control" placeholder="To Location" aria-label="To Location" id="to_location" name="to_location">
                                    <option value='0'>Select Location</option>
                                    @if(!empty($location))
                                    @php
                                    $reverse = array_reverse($location, true);
                                    @endphp
                                    @foreach($reverse as $loc)
                                    <option value="{{ $loc['id'] }}">{{ $loc['name'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subtitle</label>
                                <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="subtitle" name="subtitle" rows='4' cols='50'> </textarea>
                            </div>
                            <!-- <div class="col-md-5">
                                <label class="form-label">Facilities</label>
                                <div class="d-sm-flex align-items-center justify-content-between">
                                    <input type="text" class="form-control" placeholder="Facilities" aria-label="Facilities" id="facilities1" name="Facilities" value=''>
                                    <button type="button" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                                <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>
                                <div class="form-group">
                                    <div class="needsclick dropzone" id="document-dropzone"></div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" placeholder="Price" aria-label="Price" id="price" name="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.\d\d)\d/g, '$1');">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Seat Count</label>
                                <input type="number" class="form-control" placeholder="Seat Count" aria-label="Seat Count" id="seat_count" name="seat_count" value=2>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">AC</label>
                                <div class="d-sm-flex align-items-center justify-content-between">
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" type="radio" id="is_ac_yes" name="is_ac" value='1'>
                                        <label class="form-check-label" for="is_ac_yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" type="radio" id="is_ac_no" name="is_ac" checked="" value='0'>
                                        <label class="form-check-label" for="is_ac_no">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Luuggage Count</label>
                                <input type="number" class="form-control" placeholder="Luuggage Count" aria-label="Luuggage Count" id="luggage_count" name="luggage_count" value=2>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">First Aid</label>
                                <div class="d-sm-flex align-items-center justify-content-between">
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" type="radio" id="is_firstaid_yes" name="is_firstaid" checked value='1'>
                                        <label class="form-check-label" for="is_firstaid_yes">
                                            Yes
                                        </label>
                                    </div>
                                    <div class="form-check form-check-md d-flex align-items-center">
                                        <input class="form-check-input" type="radio" id="is_firstaid_no" name="is_firstaid" value='0'>
                                        <label class="form-check-label" for="is_firstaid_no">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-light" onclick="javascript:location.reload()">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
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
            $("#invalid_msg_cab_img").remove();
            //console.log(response)
            if (response.name != '') {
                $('form').append('<input type="hidden" name="cab_img[]" value="' + response.name + '">')
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
            $('form').find('input[name="cab_img[]"][value="' + name + '"]').remove();
            $('form').append('<input type="hidden" name="remove_cab_img[]" value="' + name + '">')
        },
        init: function() {

        }
    }
    $(document).on('submit', "#creation_form", function(e) {
        //e.preventDefault();
        $(".invalid_msg").remove();
        var error = 0;
        if ($.trim($("#title").val()) == '') {
            $("#title").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_title'>Please enter a title.</div>");
            $("#invalid_msg_title").show();
            error++;
        }
        if ($.trim($("#from_location").val()) == '' || $.trim($("#from_location").val()) == '0') {
            $("#from_location").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_from_location'>Please enter a form location.</div>");
            $("#invalid_msg_from_location").show();
            error++;
        }
        if ($.trim($("#to_location").val()) == '' || $.trim($("#to_location").val()) == '0') {
            $("#to_location").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_to_location'>Please enter a to location.</div>");
            $("#invalid_msg_to_location").show();
            error++;
        }
        if ($.trim($("#price").val()) == '') {
            $("#price").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_price'>Please enter a price.</div>");
            $("#invalid_msg_price").show();
            error++;
        }
        var cab_img = {};
        if ($("input[name='cab_img[]']").length == 0) {
            $(".dz-message").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_cab_img'>Please upload a image.</div>");
            $("#invalid_msg_cab_img").show();
            error++;
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