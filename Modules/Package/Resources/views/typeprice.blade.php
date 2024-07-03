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
                            <div class="h5 fw-semibold mb-0">Type & Price</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <button href="javascript:void(0)" type="button" id="addtypepricebtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"><i class="bx bx-plus side-menu__icon"></i> Add</button>
                                <input type="hidden" id="count_typeprice" name="count_typeprice" value="{{ !empty($package['typeprice'])?count($package['typeprice']):1 }}">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <form class="row g-3 mt-0" method="POST" action="{{ url('package/typeprice-save/'.$package['id']) }}" id="creation_form" name="creation_form">
                            @csrf
                            <div id="appendtypepriceHere">
                                @if(!empty($package['typeprice']))
                                @foreach ($package['typeprice'] as $key => $typeprice)
                                <div class="row mb-4" id="typepricediv{{ $key+1 }}">
                                    @if($key>0)
                                    <div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                                            <div class="h6 fw-semibold mb-0">Type & Price Add</div><button href="javascript:void(0)" type="button" forid="{{ $key+1 }}" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removetypepricebtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="hidden" id="typeprice_id{{ $key+1 }}" name="typeprice_id[{{ $key+1 }}]" value="{{ $typeprice['id'] }}">
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Type</label>
                                        <select class="form-control" placeholder="Type" aria-label="Type" id="typeprice_type{{ $key+1 }}" name="typeprice_type[{{ $key+1 }}]">
                                            <option value='0'>Select Type</option>
                                            @if(!empty($packagetypes))
                                            @foreach($packagetypes as $type)
                                            <option value="{{ $type['id'] }}" {{ ($type['id']==$typeprice['type_id'])?'selected':'' }}>{{ $type['title'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-9 mb-2">
                                        <label class="form-label">Subtitle</label>
                                        <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="typeprice_subtitle{{ $key+1 }}" name="typeprice_subtitle[{{ $key+1 }}]" rows='2' cols='25'>{{ $typeprice['subtitle'] }}</textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">CP Plan</label>
                                        <input type="text" class="form-control" placeholder="CP Plan" aria-label="CP Plan" id="typeprice_cpplan{{ $key+1 }}" name="typeprice_cpplan[{{ $key+1 }}]" value="{{ $typeprice['cp_plan'] }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.\d\d)\d/g, '$1');">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Map With Dinner</label>
                                        <input type="text" class="form-control" placeholder="Map With Dinner" aria-label="Map With Dinner" id="typeprice_mapdinner{{ $key+1 }}" name="typeprice_mapdinner[{{ $key+1 }}]" value="{{ $typeprice['map_with_dinner'] }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.\d\d)\d/g, '$1');">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Actual Price</label>
                                        <input type="text" class="form-control" placeholder="Actual Price" aria-label="Actual Price" id="typeprice_actualprice{{ $key+1 }}" name="typeprice_actualprice[{{ $key+1 }}]" value="{{ $typeprice['actual_price'] }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.\d\d)\d/g, '$1');">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>
                                        <div class="form-group form-control">
                                            <div class="needsclick dropzone" id="typepriceimage{{ $key+1 }}-dropzone"></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="row mb-4" id="typepricediv1">
                                    <input type="hidden" id="typeprice_id1" name="typeprice_id[1]" value="">
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label">Type</label>
                                        <select class="form-control" placeholder="Type" aria-label="Type" id="typeprice_type1" name="typeprice_type[1]">
                                            <option value='0'>Select Type</option>
                                            @if(!empty($packagetypes))
                                            @foreach($packagetypes as $type)
                                            <option value="{{ $type['id'] }}">{{ $type['title'] }}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-9 mb-2">
                                        <label class="form-label">Subtitle</label>
                                        <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="typeprice_subtitle1" name="typeprice_subtitle[1]" rows='2' cols='25'> </textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">CP Plan</label>
                                        <input type="text" class="form-control" placeholder="CP Plan" aria-label="CP Plan" id="typeprice_cpplan1" name="typeprice_cpplan[1]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.\d\d)\d/g, '$1');">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Map With Dinner</label>
                                        <input type="text" class="form-control" placeholder="Map With Dinner" aria-label="Map With Dinner" id="typeprice_mapdinner1" name="typeprice_mapdinner[1]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.\d\d)\d/g, '$1');">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Actual Price</label>
                                        <input type="text" class="form-control" placeholder="Actual Price" aria-label="Actual Price" id="typeprice_actualprice1" name="typeprice_actualprice[1]" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.\d\d)\d/g, '$1');">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>
                                        <div class="form-group form-control">
                                            <div class="needsclick dropzone" id="typepriceimage1-dropzone"></div>
                                        </div>
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
$type_dropdown = '<option value="0">Select Type</option>';
if(!empty($packagetypes)){
foreach($packagetypes as $type){
$type_dropdown = $type_dropdown.'<option value="'. $type['id'] .'">'. $type['title'] .'</option>';
}
}
@endphp
@endsection
@push('js')
<script type="text/javascript">
    var uploadedDocumentMap = {}
    $(document).on("click", "#addtypepricebtn", function() {
        var typeprice_count = $("#count_typeprice").val();
        typeprice_count++;
        var html = '<div class="row  mb-4" id="typepricediv' + typeprice_count + '">' +
            '<input type="hidden" id="typeprice_id' + typeprice_count + '" name="typeprice_id[' + typeprice_count + ']" value="">' +
            '<div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;"><div class="d-sm-flex d-block align-items-center justify-content-between"><div class="h6 fw-semibold mb-0">Type & Price Add</div><button href="javascript:void(0)" type="button" forid="' + typeprice_count + '" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removetypepricebtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button></div></div>' +
            '<div class="col-md-3 mb-2">' +
            '<label class="form-label">Type</label>' +
            '<select class="form-control" placeholder="Type" aria-label="Type" id="typeprice_type' + typeprice_count + '" name="typeprice_type[' + typeprice_count + ']">' +
            '{!! $type_dropdown !!}' +
            '</select>' +
            '</div>' +
            '<div class="col-md-9 mb-2">' +
            '<label class="form-label">Subtitle</label>' +
            '<textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="typeprice_subtitle' + typeprice_count + '" name="typeprice_subtitle[' + typeprice_count + ']" rows="2" cols="25"> </textarea>' +
            '</div>' +
            '<div class="col-md-4">' +
            '<label class="form-label">CP Plan</label>' +
            '<input type="text" class="form-control" placeholder="CP Plan" aria-label="CP Plan" id="typeprice_cpplan' + typeprice_count + '" name="typeprice_cpplan[' + typeprice_count + ']" oninput="this.value = this.value.replace(\/[^0-9.]\/g, \'\').replace(\/(\\..*)\\.\/g, \'$1\').replace(\/(\\.\\d\\d)\\d\/g, \'$1\');">' +
            '</div>' +
            '<div class="col-md-4">' +
            '<label class="form-label">Map With Dinner</label>' +
            '<input type="text" class="form-control" placeholder="Map With Dinner" aria-label="Map With Dinner" id="typeprice_mapdinner' + typeprice_count + '" name="typeprice_mapdinner[' + typeprice_count + ']" oninput="this.value = this.value.replace(\/[^0-9.]\/g, \'\').replace(\/(\\..*)\\.\/g, \'$1\').replace(\/(\\.\\d\\d)\\d\/g, \'$1\');">' +
            '</div>' +
            '<div class="col-md-4">' +
            '<label class="form-label">Actual Price</label>' +
            '<input type="text" class="form-control" placeholder="Actual Price" aria-label="Actual Price" id="typeprice_actualprice' + typeprice_count + '" name="typeprice_actualprice[' + typeprice_count + ']" oninput="this.value = this.value.replace(\/[^0-9.]\/g, \'\').replace(\/(\\..*)\\.\/g, \'$1\').replace(\/(\\.\\d\\d)\\d\/g, \'$1\');">' +
            '</div>' +
            '<div class="col-md-12">' +
            '<label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>' +
            '<div class="form-group form-control">' +
            '<div class="needsclick dropzone" id="typepriceimage' + typeprice_count + '-dropzone"></div>' +
            '</div>' +
            '</div>' +
            '</div>';
        $("#appendtypepriceHere").append(html);
        $("#count_typeprice").val(typeprice_count);
        $('#typepriceimage' + typeprice_count + '-dropzone').dropzone({
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
                    $('form').append('<input type="hidden" name="' + divid + '_img[]" value="' + response.name + '">')
                    uploadedDocumentMap[file.name] = response.name
                }
            },
        });
    });
    $(document).on("click", ".removetypepricebtn", function() {
        var getdivid = $(this).attr('forid');
        $("#typepricediv" + getdivid + "").remove();
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
            var typepriceid = divid.replace('typepriceimage', '');
            @if(isset($package['typeprice']) && $package['typeprice'])
            var base_path = "{{url('/')}}";
            var files = {!! json_encode($package['typeprice']) !!};
            console.log(files[typepriceid - 1])
            for (var i in files[typepriceid - 1]['typepriceimage']) {
                var base_path = "{{url('/')}}";
                var lastPart = files[typepriceid - 1]['typepriceimage'][i].path.split("/").pop().split('?')[0];
                var imagename = lastPart;
                var mockFile = {
                    id: files[typepriceid - 1]['typepriceimage'][i].id,
                    name: imagename,
                    size: files[typepriceid - 1]['typepriceimage'][i].size
                };
                var filepath = base_path + '/' + files[typepriceid - 1]['typepriceimage'][i].path
                //console.log('mockFile', mockFile)
                this.emit("addedfile", mockFile);
                //this.emit("thumbnail", mockFile, filepath);
                this.options.thumbnail.call(this, mockFile, filepath);
                this.emit("complete", mockFile);
                $('form').append('<input type="hidden" class="typepriceImgclass" name="' + divid + '_img[]" value="' + imagename + '" is_exists="1" imgids="' + files[typepriceid - 1]['typepriceimage'][i].id + '" >')
            }
            @endif
        }
    })




    $(document).on('click', ".addtypepriceBtn, .addTypeBtn, .addPolicyBtn", function() {
        var valueBtn = $(this).val();
        $("#redirectTo").val(valueBtn);
        $('.formSubmitBtn').click();
    });
    $(document).on('submit', "#creation_form", function(e) {
        //e.preventDefault();
        $(".invalid_msg").remove();
        var error = 0;
        var typeprice_count = $("#count_typeprice").val();
        for (var i = 1; i <= typeprice_count; i++) {
            if ($("#typeprice_type" + i).length > 0) {
                if ($.trim($("#typeprice_type" + i).val()) == '' || $.trim($("#typeprice_type" + i).val()) == '0') {
                    $("#typeprice_type" + i + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_typeprice_type" + i + "'>Please select type.</div>");
                    $("#invalid_msg_typeprice_type" + i + "").show();
                    error++;
                }
                if ($.trim($("#typeprice_actualprice" + i).val()) == '') {
                    $("#typeprice_actualprice" + i + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_typeprice_actualprice" + i + "'>Please enter a price.</div>");
                    $("#invalid_msg_typeprice_actualprice" + i + "").show();
                    error++;
                }
                if ($("input[name='typepriceimage" + i + "_img[]']").length == 0) {
                    $("#typepriceimage" + i + "-dropzone").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_typepriceimage" + i + "_img'>Please upload a image.</div>");
                    $("#invalid_msg_typepriceimage" + i + "_img").show();
                    error++;
                }
            }
        }
        //alert(error)
        if (error == 0) {
            $('form').find('input[class="typepriceImgclass"][is_exists="1"]').remove();
            return true;
            $("#creation_form").submit();
        } else {
            return false;
        }

    });
</script>
@endpush