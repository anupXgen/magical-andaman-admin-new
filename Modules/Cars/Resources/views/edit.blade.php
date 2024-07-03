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
//echo "<pre>";print_r($activity);die;
?>
<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cars.index') }}">Cars</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-block">
                    <div class="d-sm-flex d-block align-items-center justify-content-between">
                        <div class="h5 fw-semibold mb-0">Cars Edit</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('cars.index') }}" class="btn btn-warning-light ms-2">Back</a>
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
                        <form class="row g-3 mt-0" method="POST" action="{{ route('cars.update',$cars['id']) }}" id="creation_form" name="creation_form">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Title" aria-label="Title" id="title" name="title" value="{{ $cars['title'] }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subtitle</label>
                                <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="subtitle" name="subtitle" rows='4' cols='50'>{{ $cars['subtitle'] }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Seater</label>
                                <input type="text" class="form-control" placeholder="Seater" aria-label="seater" id="seater" name="seater" value="{{ $cars['seater'] }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">AC</label>
                                <input type="text" class="form-control" placeholder="AC" aria-label="Title" id="ac" name="ac" value="{{ $cars['ac'] }}">
                            </div>
                          
                            <div class="col-md-6">
                                <label class="form-label">Car Category</label>
                                <select class="form-control" name="car_category" id="car_category">
                                    <option value="">Select Category</option>
                                    @foreach($car_categories as $category)
                                        <option value="{{ $category->id }}" {{ ($category->id == $cars['car_category']) ? 'selected' : '' }}>
                                            {{ $category->category_title}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Price Per Hour</label>
                                <input type="text" class="form-control" placeholder="Price Per Hour" aria-label="Price" id="price" name="price_per_hour" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.\d\d)\d/g, '$1');" value="{{ ($cars['price_per_hour'])?$cars['price_per_hour']:'' }}">
                            </div>
                            <div class="col-md-10">
                                <label class="form-label" for="document">Car Image </label><span class="text-muted"> Only JPEG and JPG and PNG file types are allowed</span>
                                <!-- <div class="field" align="left">
                                    <input class="form-control filepond" type="file" id="activity" name="activity[]" multiple />
                                </div> -->
                                <div class="form-group">
                                    <div class="needsclick dropzone" id="document-dropzone"></div>

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
        acceptedFiles: 'image/jpeg,image/jpg,image/png',
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(file, response) {
            $("#invalid_msg_activity_img").remove();
            //console.log(response)
            if (response.name != '') {
                $('form').append('<input type="hidden" name="car_image[]" value="' + response.name + '">')
                uploadedDocumentMap[file.name] = response.name
            }
        },
        removedfile: function(file) {
            file.previewElement.remove()
            var name = '';
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedDocumentMap[file.name]
            }
            if (name == '' || typeof file.name !== 'undefined') {
                name = file.name
            }
            var is_exists_ids = $('form').find('input[name="car_image[]"][value="' + name + '"]').attr('imgids');
            if (is_exists_ids && is_exists_ids !== 'undefined') {
                $('form').append('<input type="hidden" name="exists_remove_activity_img[' + is_exists_ids + ']" value="' + name + '">')
            }
            $('form').find('input[name="car_image[]"][value="' + name + '"]').remove();
            $('form').append('<input type="hidden" name="remove_activity_img[]" value="' + name + '">')
        },
        init: function() {
            @if(isset($cars['car_image']) && $cars['car_image'])
                var base_path = "{{url('/')}}";
                var file = {!! json_encode($cars['car_image']) !!};
                var lastPart = file.split("/").pop().split('?')[0];
                var imagename = lastPart;
                console.log(imagename)
                var mockFile = {
                    id: file.id,
                    name: imagename,
                    
                };
                var filepath = base_path + '/' + file;
                console.log('mockFile', mockFile);
                this.emit("addedfile", mockFile);
                //this.emit("thumbnail", mockFile, filepath);
                this.options.thumbnail.call(this, mockFile, filepath);
                this.emit("complete", mockFile);
                $('form').append('<input type="hidden" name="car_image[]" value="' + imagename + '" is_exists="1" imgids="' + file.id + '" >');
            @endif
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
        if ($.trim($("#subtitle").val()) == '') {
            $("#subtitle").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_subtitle'>Please enter a subtitle.</div>");
            $("#invalid_msg_subtitle").show();
            error++;
        }
        if ($.trim($("#car_category").val()) == '') {
            $("#car_category").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_subtitle'>Please enter a Category.</div>");
            $("#invalid_msg_subtitle").show();
            error++;
        }
        if ($.trim($("#price").val()) == '') {
            $("#price").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_price'>Please enter price.</div>");
            $("#invalid_msg_price").show();
            error++;
        }
        var activity_img = {};
        if ($("input[name='car_image[]']").length == 0) {
            $(".dz-message").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_activity_img'>Please upload a image.</div>");
            $("#invalid_msg_activity_img").show();
            error++;
        }
        if (error == 0) {
            $('form').find('input[name="car_image[]"][is_exists="1"]').remove();
            return true;
            $("#creation_form").submit();
        } else {
            return false;
        }

    });
</script>
@endpush