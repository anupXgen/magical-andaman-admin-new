    @extends('layouts.app')
    @section('content')
        <div class="container-fluid">
            <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
                <h1 class="page-title fw-semibold fs-18 mb-0">Create Ferry Schedule</h1>
                <div class="ms-md-1 ms-0">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('ferryschedule.index') }}">Ferry</a></li>
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
                                <div class="h5 fw-semibold mb-0">Ferry Create</div>
                                <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                    <a href="{{ route('ferryschedule.index') }}" class="btn btn-warning-light ms-2">Back</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="col-xl-12">
                                <form class="row g-3 mt-0" method="POST" action="{{ route('ferryschedule.store') }}"
                                    id="creation_form" name="creation_form">
                                    @csrf
                                    <div class="col-md-6">
                                        <label class="form-label">From Location</label>
                                        <select class="form-control" id="form_location" name="form_location">
                                            <option value="">Select</option>
                                            @foreach ($ferry_locations as $location)
                                            <option value="{{ $location->id }}" {{ old('form_location', '') == $location->id? 'selected' : '' }}>
                                                {{ $location->title }}
                                            </option>
                                        @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('form_location')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>



                                    <div class="col-md-6">
                                        <label class="form-label">To Location</label>
                                        <select class="form-control" id="to_location" name="to_location">
                                            <option value="">Select</option>
                                            @foreach ($ferry_locations as $location)
                                                <option value="{{ $location->id }}" {{ old('to_location', '') == $location->id? 'selected' : '' }}>
                                                    {{ $location->title }}
                                                </option>
                                            @endforeach

                                        </select>
                                        <span class="text-danger">
                                            @error('to_location')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">From Date</label>
                                        <input type="text" class="form-control datepicker" placeholder="From Date"
                                            id="from_date" name="from_date" value="{{old('from_date')}}">
                                        <span class="text-danger">
                                            @error('from_date')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label">To Date</label>
                                        <input type="text" class="form-control datepicker" placeholder="To Date"
                                            id="to_date" name="to_date" value="{{old('to_date')}}">
                                        <span class="text-danger">
                                            @error('to_date')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>


                                    <div class="col-md-6">
                                        <label class="form-label">Departure Time </label>
                                        <input type="time" class="form-control" id="departure_time" name="departure_time"
                                            placeholder="HH:MM:SS"  value="{{old('departure_time')}}" step="1">
                                        <span class="text-danger">
                                            @error('departure_time')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    {{-- Test --}}
                                    <div class="col-md-6">
                                        <label class="form-label">Arrival Time </label>
                                        <input type="time" class="form-control" id="arrival_time" name="arrival_time"
                                            placeholder="HH:MM:SS"  value="{{old('arrival_time')}}" step="1">
                                        <span class="text-danger">
                                            @error('arrival_time')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Ship Master</label>
                                        <select class="form-control" id="ship_master" name="ship_master">
                                            <option value="">Select</option>
                                            @foreach ($ship_master as $ship_masters)
                                            <option value="{{ $ship_masters->id }}" {{ old('ship_master', '') == $ship_masters->id? 'selected' : '' }}>
                                                {{ $ship_masters->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">
                                            @error('ship_master')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status">
                                            <option value="Y" {{ old('status', '') == 'Y'? 'selected' : '' }}>Yes</option>
                                            <option value="N" {{ old('status', '') == 'N'? 'selected' : '' }}>No</option>
                                        </select>
                                    </div>
                                    


                                    <div>
                                        <div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;">
                                            <div class="text-center">
                                                <div class="h6 fw-semibold mb-0 ">Schedule Price</div>
                                            </div>
                                        </div>
        
                                        <div class="row flist me-3 ms-1" id="row1">
                                            <div style="border:1px solid #ccc; margin-bottom:25px; border-radius:10px; padding:10px; position: relative">
                                                <div class="row pt-2">
                                                    <div>
                                                        <span class="btn btn-danger btn-xs " style="position: absolute; right:10px; top:5px; padding:5px 10px" id="del1" onclick="deleterow(this.id);">Delete</span>
                                                    </div>
                                                    
                                                    <div class="col-md-3 p-2">
                                                        <label class="form-label">Ship CLass</label>
                                                        <select class="form-control" name="class_id[]" id="class_id" >
                                                            <option value="">Select</option>
                                                            @foreach($ship_classes as $shipclass)
                                                            <option value="{{ $shipclass->id }}" {{ old('class_id', '') == $shipclass->id? 'selected' : '' }}>
                                                                {{ $shipclass->title }}
                                                            </option>
                                                            @endforeach
                                                        </select>
                                                        <span class="text-danger">
                                                            @error('class_id.*')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                        
                                                    <div class="col-md-3 p-2">
                                                        <label class="form-label">Price</label>
                                                        <input type="text" class="form-control" placeholder="Price" aria-label="Title" id="price" name="price[]" value="{{old('price[]')}}">
                                                        <span class="text-danger">
                                                            @error('price.*')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <a href="javascript:void(0)" class="btn btn-info btn-xs addrow" style="float: right;padding:5px 8px">Add Row</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="button" class="btn btn-light"
                                            onclick="javascript:location.reload()">Cancel</button>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>


        <script type="text/javascript">
            $(function() {
                var dateFormat = "dd-mm-yy";
                $("#from_date").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: dateFormat,
                    onClose: function(selectedDate) {
                        $("#to_date").datepicker("option", "minDate", selectedDate);
                    }
                });

                $("#to_date").datepicker({
                    defaultDate: "+1w",
                    changeMonth: true,
                    numberOfMonths: 1,
                    dateFormat: dateFormat,
                    onClose: function(selectedDate) {
                        $("#from_date").datepicker("option", "maxDate", selectedDate);
                    }
                });

                function disableSameLocation(selected, target) {
                    var selectedValue = $(selected).val();
                    $(target).find('option').each(function() {
                        if ($(this).val() === selectedValue) {
                            $(this).prop('disabled', true);
                        } else {
                            $(this).prop('disabled', false);
                        }
                    });
                }

                $('#form_location').change(function() {
                    disableSameLocation(this, '#to_location');
                });

                $('#to_location').change(function() {
                    disableSameLocation(this, '#form_location');
                });
            });

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
