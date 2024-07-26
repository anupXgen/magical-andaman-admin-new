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
                    <li class="breadcrumb-item"><a href="{{ route('banner.index') }}">Banners</a></li>
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
                        <div class="h5 fw-semibold mb-0">Banner Create</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('banner.index') }}" class="btn btn-warning-light ms-2">Back</a>
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
                        <form class="row g-3 mt-0" method="POST" action="{{ route('banner.store') }}" id="creation_form" name="creation_form" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Title" aria-label="Title" id="title" name="title" value="{{old('title')}}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subtitle</label>
                                <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="subtitle" name="subtitle" rows='4' cols='50' >{{old('subtitle')}} </textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Button Text</label>
                                <textarea class="form-control" placeholder="Button Text" aria-label="Subtitle" id="button_text" name="button_text" rows='4' cols='50'> </textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Button Link</label>
                                <textarea class="form-control" placeholder="Button Link" aria-label="Subtitle" id="button_link" name="button_link" rows='4' cols='50'> </textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>
                                 <div class="field" align="left">
                                    <input class="form-control filepond" type="file" id="banner_image" name="banner_image" />
                                </div>
                                {{-- <div class="form-group">
                                    <div class="needsclick dropzone" id="document-dropzone"></div>

                                </div> --}}
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
{{-- @push('js')
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
            $("#invalid_msg_banner_img").remove();
            //console.log(response)
            if (response.name != '') {
                $('form').append('<input type="hidden" name="banner_img[]" value="' + response.name + '">')
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
            $('form').find('input[name="banner_img[]"][value="' + name + '"]').remove();
            $('form').append('<input type="hidden" name="remove_banner_img[]" value="' + name + '">')
        },
        init: function() {
            @if(isset($project) && $project->document)
            var files = {
                !!json_encode($project->document) !!
            }
            for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="banner_img[]" value="' + file.file_name + '">')
            }
            @endif
        }
    }




    // const inputElement = document.querySelector('#banner');

    // FilePond.registerPlugin(FilePondPluginImagePreview);

    // const pond = FilePond.create(inputElement, {
    //     allowMultiple: true,
    //     allowFileEncode: true,
    // });
    // FilePond.parse(document.body);
    // $(function() {
    //     // Multiple images preview in browser
    //     var imagesPreview = function(input, placeToInsertImagePreview) {

    //         if (input.files) {
    //             var filesAmount = input.files.length;

    //             for (i = 0; i < filesAmount; i++) {
    //                 var reader = new FileReader();

    //                 reader.onload = function(event) {
    //                     $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(placeToInsertImagePreview);
    //                 }

    //                 reader.readAsDataURL(input.files[i]);
    //             }
    //         }

    //     };

    //     $('#banner').on('change', function() {
    //         imagesPreview(this, 'div.gallery');
    //     });
    // });
    // $(document).ready(function() {
    //     if (window.File && window.FileList && window.FileReader) {
    //         $("#banner").on("change", function(e) {
    //             var files = e.target.files,
    //                 filesLength = files.length;
    //             var ids = 1;
    //             const validImageTypes = ['image/jpg', 'image/jpeg'];
    //             for (var i = 0; i < filesLength; i++) {
    //                 ids++;
    //                 var f = files[i];
    //                 console.log(f.type);
    //                 if ($.inArray(f.type, validImageTypes) > 0) {
    //                     var fileReader = new FileReader();
    //                     fileReader.onload = (function(e) {
    //                         var file = e.target;
    //                         var inputhtml = "<input type=\"text\" id=\"file_images\"" + ids + "\" name=\"file_images[]\" hidden value=\"" + e.target.result + "\">"
    //                         $("<span class=\"pip\">" + inputhtml +
    //                             "<img class=\"imageThumb\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
    //                             "<br/><span class=\"remove\">Remove image</span>" +
    //                             "</span>").insertAfter("#banner");
    //                         $(".remove").click(function() {
    //                             $(this).parent(".pip").remove();
    //                         });
    //                         // Old code here
    //                         /*$("<img></img>", {
    //                           class: "imageThumb",
    //                           src: e.target.result,
    //                           title: file.name + " | Click to remove"
    //                         }).insertAfter("#files").click(function(){$(this).remove();});*/
    //                     });
    //                     fileReader.readAsDataURL(f);
    //                 }
    //             }
    //         });
    //     } else {
    //         alert("Your browser doesn't support to File API")
    //     }
    // });
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
        var banner_img = {};
        if ($("input[name='banner_img[]']").length == 0) {
            $(".dz-message").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_banner_img'>Please upload a image.</div>");
            $("#invalid_msg_banner_img").show();
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
@endpush --}}

{{-- @push('js')
<script type="text/javascript">
    var uploadedDocumentMap = {}

    Dropzone.options.documentDropzone = {
        url: "{{ url('upload-image') }}",
        maxFilesize: 25, // MB
        acceptedFiles: 'image/jpeg,image/jpg,png',
        maxFiles: 1,
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function(file, response) {
            $("#invalid_msg_banner_img").remove();
            if (response.name != '') {
                $('form').append('<input type="hidden" name="banner_img[]" value="' + response.name + '">')
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
            $('form').find('input[name="banner_img[]"][value="' + name + '"]').remove();
            $('form').append('<input type="hidden" name="remove_banner_img[]" value="' + name + '">')
        },
        init: function() {
            @if(isset($project) && $project->document)
            var files = {!! json_encode($project->document) !!}
            for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="banner_img[]" value="' + file.file_name + '">')
            }
            @endif
        },
        maxfilesexceeded: function(file) {
            this.removeAllFiles();
            this.addFile(file);
        }
    }

    $(document).on('submit', "#creation_form", function(e) {
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
        if ($("input[name='banner_img[]']").length == 0) {
            $(".dz-message").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_banner_img'>Please upload an image.</div>");
            $("#invalid_msg_banner_img").show();
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
@endpush --}}