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
//echo "<pre>";print_r($sightseeing);die;
?>
<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sightseeing.index') }}">Sight Seeings</a></li>
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
                        <div class="h5 fw-semibold mb-0">Sight Seeing Edit</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('sightseeing.index') }}" class="btn btn-warning-light ms-2">Back</a>
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
                        <form class="row g-3 mt-0" method="POST" action="{{ route('sightseeing.update',$sightseeing['id']) }}" id="creation_form" name="creation_form">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Title" aria-label="Title" id="title" name="title" value="{{ $sightseeing['title'] }}">
                            </div>
                        
                            <div class="col-md-4 ">
                                <label class="form-label">Location</label>
                                <select class="form-control select_location" name="location_id" id="location_id">
                                    <option value="">Select location</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}"{{($location->id==$sightseeing['location_id']) ? 'selected' : '' }}>
                                            {{ $location->name}}
                                        </option>
                                    @endforeach
                                </select> 
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Subtitle</label>
                                <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="subtitle" name="subtitle" rows='4' cols='50'>{{ $sightseeing['subtitle'] }}</textarea>
                            </div>
                        
                            <div class="col-md-12">
                                <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>
                                <!-- <div class="field" align="left">
                                    <input class="form-control filepond" type="file" id="sightseeing" name="sightseeing[]" multiple />
                                </div> -->
                                <div class="form-group">
                                    <div class="needsclick dropzone" id="document-dropzone"></div>

                                </div>
                            </div>


                            <div>
                                <div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;">
                                    <div class="text-center">
                                        <div class="h6 fw-semibold mb-0 ">Sightseing Location </div>
                                    </div>
                                </div>
                        @foreach($sightseeing['sight_location'] as $val)
                                <div class="row flist me-3 ms-1" id="row1">
                                    <div style="border:1px solid #ccc; margin-bottom:25px; border-radius:10px; padding:10px; position: relative">
                                        <div class="row pt-2">
                                            <div>
                                                <span class="btn btn-danger btn-xs " style="position: absolute; right:10px; top:5px; padding:5px 10px" id="del1" onclick="deleterow(this.id);">Delete</span>
                                            </div>
                                            <input type="hidden" name="sight_loc_id[]" value="{{$val['id']}}">
                                            <div class="col-md-3 p-2">
                                                <label class="form-label">Location Title</label>
                                                <input type="text" class="form-control" placeholder="Location Title" aria-label="Title" id="location_title" name="location_title[]" value="{{$val['title']}}">
                                            </div>
                
                                            <div class="col-md-3">
                                                <label class="form-label">Location Subtitle</label>
                                                <input type="text" class="form-control" placeholder="Location Subtitle" aria-label="Title" id="location_subtitle" name="location_subtitle[]" value="{{$val['subtitle']}}">
                                            </div>

                                            <div class="col-md-3 p-2">
                                                <label class="form-label">Duration</label>
                                                <input type="text" class="form-control" placeholder="Duration" aria-label="Title" id="duration" name="duration[]" value="{{$val['duration']}}">
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <label class="form-label">Entry Fees</label>
                                                <input type="text" class="form-control" placeholder="Entry Fees" aria-label="Title" id="entry_fees" name="entry_fees[]" value="{{$val['entry_fees']}}">
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <label class="form-label">XUV price</label>
                                                <input type="text" class="form-control" placeholder="XUV price" aria-label="Title" id="xuv_price" name="xuv_price[]" value="{{$val['xuv_price']}}">
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <label class="form-label">Sedan price</label>
                                                <input type="text" class="form-control" placeholder="Sedan price" aria-label="Title" id="sedan_price" name="sedan_price[]" value="{{$val['sedan_price']}}">
                                            </div>
                                            <div class="col-md-3 p-2">
                                                <label class="form-label">Hatchback price</label>
                                                <input type="text" class="form-control" placeholder="Hatchback price" aria-label="Title" id="hatchback_price" name="hatchback_price[]" value="{{$val['hatchback_price']}}">
                                            </div>
          
                                            <div class="col-md-3 p-2">
                                                <label class="form-label">Parking Fees</label>
                                                <input type="text" class="form-control" placeholder="Parking Fees" aria-label="Title" id="parking_fees" name="parking_fees[]" value="{{$val['parking_fees']}}">
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                                <div class="row">
                                    <div class="col-12">
                                        <a href="javascript:void(0)" class="btn btn-info btn-xs addrow" style="float: right;padding:5px 8px">Add Row</a>
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
        headers: {'X-CSRF-TOKEN': "{{ csrf_token()}}"
        },
        success: function(file, response) {
            $("#invalid_msg_sightseeing_img").remove();
            //console.log(response)
            if (response.name != '') {
                $('form').append('<input type="hidden" name="sightseeing_img[]" value="' + response.name + '">')
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
            var is_exists_ids = $('form').find('input[name="sightseeing_img[]"][value="' + name + '"]').attr('imgids');
            if (is_exists_ids && is_exists_ids !== 'undefined') {
                $('form').append('<input type="hidden" name="exists_remove_sightseeing_img[' + is_exists_ids + ']" value="' + name + '">')
            }
            $('form').find('input[name="sightseeing_img[]"][value="' + name + '"]').remove();
            $('form').append('<input type="hidden" name="remove_sightseeing_img[]" value="' + name + '">')
        },
        init: function() {
            @if(isset($sightseeing['sightseeingimage']) && $sightseeing['sightseeingimage'])
            var base_path = "{{url('/')}}";
            var files = {!! json_encode($sightseeing['sightseeingimage']) !!};
            for (var i in files) {
                var base_path = "{{url('/')}}";
                var lastPart = files[i].path.split("/").pop().split('?')[0];
                var imagename = lastPart;
                var mockFile = {
                    id: files[i].id,
                    name: imagename,
                    size: files[i].size
                };
                var filepath = base_path + '/' + files[i].path
                console.log('mockFile', mockFile)
                this.emit("addedfile", mockFile);
                //this.emit("thumbnail", mockFile, filepath);
                this.options.thumbnail.call(this, mockFile, filepath);
                this.emit("complete", mockFile);
                $('form').append('<input type="hidden" name="sightseeing_img[]" value="' + imagename + '" is_exists="1" imgids="' + files[i].id + '" >')
            }
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
        var sightseeing_img = {};
        if ($("input[name='sightseeing_img[]']").length == 0) {
            $(".dz-message").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_sightseeing_img'>Please upload a image.</div>");
            $("#invalid_msg_sightseeing_img").show();
            error++;
        }
        if (error == 0) {
            $('form').find('input[name="sightseeing_img[]"][is_exists="1"]').remove();
            return true;
            $("#creation_form").submit();
        } else {
            return false;
        }

    });

    //add/remove row
    $(document).ready(function() {
            $(".addrow").click(function() {
                var lcount = $(".flist").length;
                var newCount = parseInt(lcount) + 1;

                $("#row" + lcount).clone()
                    .attr("id", "row" + newCount)
                    .insertAfter("#row" + lcount);

                $("#row" + newCount + " input[type=text]").val("");
                $("#row" + newCount + " span").attr("id", "del" + newCount);
                $("#row" + newCount + " select").attr("id", "school_fee_dd" + newCount);
                $("#row" + newCount + " h4").html("Question " + newCount);

            });
        });

        function deleterow(id) {
            var lastId = id.slice(3);

            if (lastId == 1) {
                alert("This row cannot be deleted");
            } else {
                $("#row" + lastId).remove();

                $(".flist").each(function(index, element) {
                    var uCount = index + 1;
                    $(this).attr("id", "row" + uCount);
                    $("#row" + uCount + " input[type=radio]").attr("name", "corans" + uCount);
                    $("#row" + uCount + " span").attr("id", "del" + uCount);
                    $("#row" + uCount + " h4").html("Question " + uCount);
                });
            }
        }


</script>
@endpush