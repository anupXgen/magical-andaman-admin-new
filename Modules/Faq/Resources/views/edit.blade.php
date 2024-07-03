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
                    <li class="breadcrumb-item"><a href="{{ route('faq.index') }}">Faq</a></li>
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
                        <div class="h5 fw-semibold mb-0">Faq Edit</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('faq.index') }}" class="btn btn-warning-light ms-2">Back</a>
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
                        <form class="row g-3 mt-0" method="POST" action="{{ route('faq.update',$faq['id']) }}" id="creation_form" name="creation_form">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-6">
                                <label class="form-label">Questions</label>
                                <input type="text" class="form-control" placeholder="Questions" aria-label="Title" id="questions" name="questions" value="{{ $faq['questions'] }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Answers</label>
                                <textarea class="form-control" placeholder="Answers" aria-label="Subtitle" id="answers" name="answers" rows='4' cols='50'>{{ $faq['answers'] }}</textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Faq Category</label>
                                <select class="form-control" name="faq_category" id="faq_category">
                                    <option value="">Select Category</option>
                                    @foreach($faq_category as $cat)
                                        <option value="{{ $cat->id }}" {{ ($cat->id == $faq['faq_category']) ? 'selected' : '' }}>
                                            {{ $cat->category_title}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Related Module</label>
                                <select class="form-control" name="related_module" id="related_module">
                                    <option value="">Select Related Module</option>
                                    <option value="all" @if($faq['related_module'] === 'all') selected @endif>All</option>
                                    <option value="activity" @if($faq['related_module']  === 'activity') selected @endif>Activity</option>
                                    <option value="blogs" @if($faq['related_module']  === 'blogs') selected @endif>Blogs</option>
                                </select>
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
                $('form').append('<input type="hidden" name="activity_img[]" value="' + response.name + '">')
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
            var is_exists_ids = $('form').find('input[name="activity_img[]"][value="' + name + '"]').attr('imgids');
            if (is_exists_ids && is_exists_ids !== 'undefined') {
                $('form').append('<input type="hidden" name="exists_remove_activity_img[' + is_exists_ids + ']" value="' + name + '">')
            }
            $('form').find('input[name="activity_img[]"][value="' + name + '"]').remove();
            $('form').append('<input type="hidden" name="remove_activity_img[]" value="' + name + '">')
        },
        init: function() {
            @if(isset($activity['activityimage']) && $activity['activityimage'])
            var base_path = "{{url('/')}}";
            var files = {!! json_encode($activity['activityimage']) !!};
            for (var i in files) {
                var base_path = "{{url('/')}}";
                var lastPart = files[i].path.split("/").pop().split('?')[0];
                var imagename = lastPart;
                var mockFile = {
                    id:files[i].id,
                    name: imagename,
                    size: files[i].size
                };
                var filepath = base_path + '/' + files[i].path
                console.log('mockFile', mockFile)
                this.emit("addedfile", mockFile);
                //this.emit("thumbnail", mockFile, filepath);
                this.options.thumbnail.call(this, mockFile, filepath);
                this.emit("complete", mockFile);
                $('form').append('<input type="hidden" name="activity_img[]" value="' + imagename + '" is_exists="1" imgids="' + files[i].id + '" >')
            }
            @endif
        }
    }

    $(document).on('submit', "#creation_form", function(e) {
        //e.preventDefault();
        $(".invalid_msg").remove();
        var error = 0;
        if ($.trim($("#questions").val()) == '') {
            $("#questions").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_title'>Please enter a Questions.</div>");
            $("#invalid_msg_title").show();
            error++;
        }
        if ($.trim($("#answers").val()) == '') {
            $("#answers").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_subtitle'>Please enter a Answers.</div>");
            $("#invalid_msg_subtitle").show();
            error++;
        }
        
        if (error == 0) {
            $('form').find('input[name="activity_img[]"][is_exists="1"]').remove();
            return true;
            $("#creation_form").submit();
        } else {
            return false;
        }

    });
</script>
@endpush