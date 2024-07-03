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
                    <li class="breadcrumb-item"><a href="{{ route('hotel.index') }}">Hotels</a></li>
                    <li class="breadcrumb-item active" aria-current="page">edit</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-block">
                    <div class="d-sm-flex d-block align-items-center justify-content-between">
                        <div class="h5 fw-semibold mb-0">Hotel Edit</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('hotel.index') }}" class="btn btn-warning-light ms-2">Back</a>
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
                        <form class="row g-3 mt-0" method="POST" action="{{ route('hotel.update',$hotel['id']) }}" id="creation_form" name="creation_form">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Title" aria-label="Title" id="title" name="title" value="{{ $hotel['title'] }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <select class="form-control" placeholder="Location" aria-label="Location" id="location" name="location">
                                    <option value='0'>Select Location</option>
                                    @if(!empty($location))
                                    @foreach($location as $loc)
                                    <option value="{{ $loc['id'] }}" {{ $hotel['location_id']==$loc['id']?'selected':'' }}>{{ $loc['name'] }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subtitle</label>
                                <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="subtitle" name="subtitle" rows='4' cols='50'>{{ $hotel['subtitle'] }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>
                                <div class="form-group">
                                    <div class="needsclick dropzone" id="hotel-dropzone"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City Limit</label>
                                <select name="city_limit" id="city_limit" class="form-control">
                                    <option value="1" {{ $hotel['city_limit'] == 1 ? 'selected' : '' }}>In-city</option>
                                    <option value="0" {{ $hotel['city_limit'] == 0 ? 'selected' : '' }}>Out of City</option>
                                </select>
                            </div>                            

                            {{-- hotel_facility --}}
                            <div class="card-header d-block mb-4" style="background-color: #c8d8f4!important;">
                                <div class="d-sm-flex d-block align-items-center justify-content-between">
                                    <div class="h5 fw-semibold mb-0">Hotel Facility</div>
                                </div>
                            </div>
                            <div class="row" >                              
                                <div class="col-md-4">
                                    <label class="form-label">Meal Price</label>
                                    <input type="Number" class="form-control" placeholder="Meal Price" aria-label="Title" id="meal_price" name="meal_price" value="{{$hotel['hotel_facility']['meal_price'] }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Flower Bed Price</label>
                                    <input type="Number" class="form-control" placeholder="Flower Bed Price" aria-label="Title" id="flower_bed_price" name="flower_bed_price" value="{{$hotel['hotel_facility']['flower_bed_price'] }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Candle Light Dinner Price</label>
                                    <input type="Number" class="form-control" placeholder="Candle Light Dinner Price" aria-label="Title" id="candle_light_dinner_price" name="candle_light_dinner_price" value="{{$hotel['hotel_facility']['candle_light_dinner_price'] }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Extra Person With Mattres</label>
                                    <input type="Number" class="form-control" placeholder="Extra Person With Mattres" aria-label="Title" id="extra_person_with_mattres" name="extra_person_with_mattres" value="{{$hotel['hotel_facility']['extra_person_with_mattres'] }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Extra Person Without Mattres</label>
                                    <input type="Number" class="form-control" placeholder="Extra Person Without Mattres" aria-label="Title" id="extra_person_without_mattres" name="extra_person_without_mattres" value="{{$hotel['hotel_facility']['extra_person_without_mattres'] }}">
                                </div>
                            </div>

                             {{-- hotel_Price
                             <div class="card-header d-block mb-4" style="background-color: #c8d8f4!important;">
                                <div class="d-sm-flex d-block align-items-center justify-content-between">
                                    <div class="h5 fw-semibold mb-0">Hotel Price</div>
                                </div>
                            </div>
                            @foreach($hotel['hotel_price'] as $val)
                            <div style="border:1px solid; margin:5px 15px; border-radius:10px; padding-bottom:10px; ">
                                <div class="row" >                              
                                    <div class="col-md-6 pt-2 pb-2">
                                        <label class="form-label" style="font-size: 16px;">Hotel Category : <span style="font-size: 16px; font-weight:800">{{ $val['category']['category_title']}}</span></label>
                                        <input type="hidden" name="category_id[]" value="{{$val['category_id']}}">
                                    </div>
                                    <div class="col-md-6">
                                    
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">CP</label>
                                        <input type="Number" class="form-control" placeholder="" aria-label="Title" id="cp" name="cp[]" value="{{$val['cp'] }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">MAP</label>
                                        <input type="Number" class="form-control" placeholder="" aria-label="Title" id="" name="map[]" value="{{$val['map'] }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">AP</label>
                                        <input type="Number" class="form-control" placeholder="" aria-label="Title" id="ap" name="ap[]" value="{{$val['ap'] }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">EP</label>
                                        <input type="Number" class="form-control" placeholder="" aria-label="Title" id="ep" name="ep[]" value="{{$val['ep'] }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach --}}


                    {{-- Hotel price --}}
                        <div style="">
                            <div class="card-header d-block mb-4" style="background-color: #c8d8f4!important;">
                               <div class="d-sm-flex d-block align-items-center justify-content-between">
                                   <div class="h5 fw-semibold mb-0">Hotel Price</div>
                               </div>
                           </div>
                           @foreach($hotel['hotel_price'] as $val)
                               <div class="row flist me-3 ms-1" id="row1">
                                   <div style="border:1px solid; margin:5px 15px; border-radius:10px; padding-bottom:10px;position: relative">
                                       <div class="row pt-2">
                                           <div>
                                               <span class="btn btn-danger btn-xs " style="position: absolute; right:10px; top:33px; padding:5px 10px" id="del1" onclick="deleterow(this.id);">Delete</span>
                                           </div>
                                         
                                           <div class="col-md-3 p-4">
                                               <select class="form-select" name="category_id[]">
                                                   <option value="">Select Hotel Category</option>
                                                   @foreach($hotel_categories as $cat)
                                                   <option value="{{$cat->id}}" {{ $cat->id == $val['category_id'] ? 'selected' : '' }}>{{$cat->category_title}}</option>
                                                   @endforeach
                                               </select>
                                           </div>
                                           <div class="col-md-2">
                                               <label class="form-label">CP Price</label>
                                               <input type="number" class="form-control" placeholder="CP price" aria-label="Title" name="cp[]" value="{{$val['cp']}}">
                                           </div>
                                           <div class="col-md-2">
                                               <label class="form-label">MAP Price</label>
                                               <input type="number" class="form-control" placeholder="MAP price" aria-label="Title" name="map[]"  value="{{$val['map']}}">
                                           </div>
                                           <div class="col-md-2">
                                               <label class="form-label">AP Price</label>
                                               <input type="number" class="form-control" placeholder="AP Price" aria-label="Title" name="ap[]"  value="{{$val['ap']}}">
                                           </div>
                                           <div class="col-md-2">
                                               <label class="form-label">EP Price</label>
                                               <input type="number" class="form-control" placeholder="EP Price" aria-label="Title" name="ep[]"  value="{{$val['ep']}}">
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


                            {{-- room edit --}}
                            <div class="card-header d-block mb-4" style="background-color: #c8d8f4!important;">
                                <div class="d-sm-flex d-block align-items-center justify-content-between">
                                    <div class="h5 fw-semibold mb-0">Room</div>
                                    <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                        <button href="javascript:void(0)" type="button" id="addroombtn" class="btn btn-secondary-gradient btn-wave waves-effect waves-light ms-2"><i class="bx bx-plus side-menu__icon"></i> Room</button>
                                        <input type="hidden" id="count_room" name="count_room" value="{{ count($hotel['room']) }}">
                                    </div>
                                </div>
                            </div>
                            <div id="appendRoomHere">
                                @if(!empty($hotel['room']))
                                @foreach($hotel['room'] as $key=>$rooms)
                                <div class="row" id="roomdiv{{ $key+1 }}">
                                    <input type="hidden" id="room_id{{ $key+1 }}" name="room_id[{{ $key+1 }}]" value="{{ $rooms['id'] }}">
                                    @if($key>0)
                                    <div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                                            <div class="h6 fw-semibold mb-0">Room Add</div><button href="javascript:void(0)" type="button" forid="{{ $key+1 }}" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removeroombtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-md-6">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" placeholder="Title" aria-label="Title" id="room_title{{ $key+1 }}" name="room_title[{{ $key+1 }}]" value="{{ $rooms['title'] }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Subtitle</label>
                                        <textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="room_subtitle{{ $key+1 }}" name="room_subtitle[{{ $key+1 }}]" rows='2' cols='25'>{{ $rooms['subtitle'] }} </textarea>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Total Room</label>
                                        <input type="number" class="form-control" placeholder="Total Room" aria-label="Total Room" id="room_total{{ $key+1 }}" name="room_total[{{ $key+1 }}]" value="{{ $rooms['room_count'] }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Max Pax</label>
                                        <input type="number" class="form-control" placeholder="Max Pax" aria-label="Max Pax" id="room_pax{{ $key+1 }}" name="room_pax[{{ $key+1 }}]" value="{{ $rooms['max_pax'] }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Price Per Day</label>
                                        <input type="text" class="form-control" placeholder="Price Per Day" aria-label="Price Per Day" id="price_perday{{ $key+1 }}" name="price_perday[{{ $key+1 }}]" value="{{ $rooms['price_per_day'] }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1').replace(/(\.\d\d)\d/g, '$1');">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>
                                        <div class="form-group">
                                            <div class="needsclick dropzone" id="roomimage{{ $key+1 }}-dropzone"></div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @endif
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
    ////https://stackoverflow.com/questions/33795948/multiple-dropzone-with-single-function
    var uploadedDocumentMap = {}
    $(document).on("click", "#addroombtn", function() {
        var room_count = $("#count_room").val();
        room_count++;
        var html = '<div class="row" id="roomdiv' + room_count + '">' +
            '<input type="hidden" id="room_id' + room_count + '" name="room_id[' + room_count + ']" value="">' +
            '<div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;"><div class="d-sm-flex d-block align-items-center justify-content-between"><div class="h6 fw-semibold mb-0">Room Add</div><button href="javascript:void(0)" type="button" forid="' + room_count + '" class="btn btn-danger-gradient btn-wave waves-effect waves-light ms-2 removeroombtn"><i class="bx bx-minus side-menu__icon"></i> Remove</button></div></div>' +
            '<div class="col-md-6">' +
            '<label class="form-label">Title</label>' +
            '<input type="text" class="form-control" placeholder="Title" aria-label="Title" id="room_title' + room_count + '" name="room_title[' + room_count + ']">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="form-label">Subtitle</label>' +
            '<textarea class="form-control" placeholder="Subtitle" aria-label="Subtitle" id="room_subtitle' + room_count + '" name="room_subtitle[' + room_count + ']" rows="2" cols="25"> </textarea>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<label class="form-label">Total Room</label>' +
            '<input type="number" class="form-control" placeholder="Total Room" aria-label="Total Room" id="room_total' + room_count + '" name="room_total[' + room_count + ']">' +
            '</div>' +
            '<div class="col-md-2">' +
            '<label class="form-label">Max Pax</label>' +
            '<input type="number" class="form-control" placeholder="Max Pax" aria-label="Max Pax" id="room_pax' + room_count + '" name="room_pax[' + room_count + ']">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<label class="form-label">Price Per Day</label>' +
            '<input type="text" class="form-control" placeholder="Price Per Day" aria-label="Price Per Day" id="price_perday' + room_count + '" name="price_perday[' + room_count + ']" oninput="this.value = this.value.replace(\/[^0-9.]\/g, \'\').replace(\/(\\..*)\\.\/g, \'$1\').replace(\/(\\.\\d\\d)\\d\/g, \'$1\');">' +
            '</div>' +
            '<div class="col-md-8">' +
            '<label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>' +
            '<div class="form-group">' +
            '<div class="needsclick dropzone" id="roomimage' + room_count + '-dropzone"></div>' +
            '</div>' +
            '</div>' +
            '</div>';
        $("#appendRoomHere").append(html);
        $("#count_room").val(room_count);
        $('#roomimage' + room_count + '-dropzone').dropzone({
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
    $(document).on("click", ".removeroombtn", function() {
        var getdivid = $(this).attr('forid');
        $("#roomdiv" + getdivid + "").remove();
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
            //console.log(response)original_name
            if (response.name != '') {
                $('form').append('<input type="hidden" name="' + divid + '_img[]" value="' + response.name + '" org_name="' + response.original_name + '">')
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
            if (divid == 'hotel') {
                @if(isset($hotel['hotelimage']) && $hotel['hotelimage'])
                var base_path = "{{url('/')}}";
                var files = {!! json_encode($hotel['hotelimage']) !!};
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
                    //console.log('mockFile', mockFile)
                    this.emit("addedfile", mockFile);
                    //this.emit("thumbnail", mockFile, filepath);
                    this.options.thumbnail.call(this, mockFile, filepath);
                    this.emit("complete", mockFile);
                    $('form').append('<input type="hidden" name="hotel_img[]" value="' + imagename + '" is_exists="1" imgids="' + files[i].id + '" >')
                }
                @endif
            } else {
                var roomid = divid.replace('roomimage', '');
                @if(isset($hotel['room']) && $hotel['room'])
                var base_path = "{{url('/')}}";
                var files = {!! json_encode($hotel['room']) !!};
                console.log(files[roomid - 1])
                for (var i in files[roomid - 1]['roomimage']) {
                    var base_path = "{{url('/')}}";
                    var lastPart = files[roomid - 1]['roomimage'][i].path.split("/").pop().split('?')[0];
                    var imagename = lastPart;
                    var mockFile = {
                        id: files[roomid - 1]['roomimage'][i].id,
                        name: imagename,
                        size: files[roomid - 1]['roomimage'][i].size
                    };
                    var filepath = base_path + '/' + files[roomid - 1]['roomimage'][i].path
                    //console.log('mockFile', mockFile)
                    this.emit("addedfile", mockFile);
                    //this.emit("thumbnail", mockFile, filepath);
                    this.options.thumbnail.call(this, mockFile, filepath);
                    this.emit("complete", mockFile);
                    $('form').append('<input type="hidden" class="roomImgclass" name="' + divid + '_img[]" value="' + imagename + '" is_exists="1" imgids="' + files[roomid - 1]['roomimage'][i].id + '" >')
                }
                @endif
            }
        }
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
        if ($.trim($("#location").val()) == '0' || $.trim($("#location").val()) == '') {

            $("#location").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_location'>Please select a location.</div>");
            $("#invalid_msg_location").show();
            error++;
        }
        var hotel_img = {};
        if ($("input[name='hotel_img[]']").length == 0) {
            $("#hotel-dropzone").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_hotel_img'>Please upload a image.</div>");
            $("#invalid_msg_hotel_img").show();
            error++;
        }
        var room_count = $("#count_room").val();
        for (var i = 1; i <= room_count; i++) {
            if ($("#room_title" + i).length > 0) {
                if ($.trim($("#room_title" + i).val()) == '') {
                    $("#room_title" + i + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_room_title" + i + "'>Please enter a title.</div>");
                    $("#invalid_msg_room_title" + i + "").show();
                    error++;
                }
                if ($.trim($("#room_title" + i).val()) == '') {
                    $("#room_title" + i + "").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_room_title" + i + "'>Please enter a title.</div>");
                    $("#invalid_msg_room_title" + i + "").show();
                    error++;
                }
                if ($("input[name='roomimage" + i + "_img[]']").length == 0) {
                    $("#roomimage" + i + "-dropzone").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_roomimage" + i + "_img'>Please upload a image.</div>");
                    $("#invalid_msg_roomimage" + i + "_img").show();
                    error++;
                }
            }
        }
        if (error == 0) {
            $('form').find('input[name="hotel_img[]"][is_exists="1"]').remove();
            $('form').find('input[class="roomImgclass"][is_exists="1"]').remove();
            return true;
            $("#creation_form").submit();
        } else {
            return false;
        }

    });


    
//add/remove row
    $(".addrow").click(function() {
            var lcount = $(".flist").length;
            var newCount = lcount + 1;

            var newRow = $("#row1").clone().attr("id", "row" + newCount);
            newRow.find("input").val("");
            newRow.find("select").prop("selectedIndex", 0);
            newRow.find("span").attr("id", "del" + newCount);
            newRow.insertAfter(".flist:last");

            newRow.find("input").each(function() {
                $(this).attr("name", $(this).attr("name").replace(/\[\d*\]/, '[]'));
            });
        });
   

    function deleterow(id) {
        var lastId = parseInt(id.slice(3));
        if (lastId == 1) {
            alert("This row cannot be deleted");
        } else {
            $("#row" + lastId).remove();
            $(".flist").each(function(index) {
                var uCount = index + 1;
                $(this).attr("id", "row" + uCount);
                $(this).find("span").attr("id", "del" + uCount);
            });
        }
    }
</script>
@endpush