@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Edit Ferry Schedule</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('ferryschedule.index') }}">Ferry</a></li>
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
                            <div class="h5 fw-semibold mb-0">Ferry Edit</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <a href="{{ route('ferryschedule.index') }}" class="btn btn-warning-light ms-2">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-xl-12">

                            <form class="row g-3 mt-0" method="POST"
                                action="{{ route('ferryschedule.update', $ferry_schedule->id) }}" id="creation_form"
                                name="creation_form">
                                @csrf
                                @method('PATCH')

                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label">From Location</label>
                                    <select class="form-control" id="form_location" name="form_location">
                                        @foreach ($ferry_locations as $location)
                                            <option value="{{ $location->id }}"
                                                {{ $location->id == $ferry_schedule->from_location ? 'selected' : '' }}>
                                                {{ $location->title }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">To Location</label>
                                    <select class="form-control" id="to_location" name="to_location">
                                        @foreach ($ferry_locations as $location)
                                            <option value="{{ $location->id }}"
                                                {{ $location->id == $ferry_schedule->to_location ? 'selected' : '' }}>
                                                {{ $location->title }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">From Date</label>
                                    <input id="from_date" type="text" class="form-control datepicker" name="from_date"
                                        value="{{ $ferry_schedule->from_date }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">To Date</label>
                                    <input id="to_date" type="text" class="form-control datepicker" name="to_date"
                                        value="{{ $ferry_schedule->to_date }}">
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label">Departure Time</label>
                                    <input id="departure_time" type="text" class="form-control" name="departure_time"
                                        value="{{ $ferry_schedule->departure_time }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Arrival Time </label>
                                    <input id="arrival_time" type="text" class="form-control" name="arrival_time"
                                        value="{{ $ferry_schedule->arrival_time }}">

                                </div>


                                <div class="col-md-6">
                                    <label class="form-label">Ship Master</label>
                                    <select class="form-control" id="ship_master" name="ship_master" required>
                                        @foreach ($ship_masters as $ship_master)
                                            <option value="{{ $ship_master->id }}"
                                                {{ $ship_master->id == $ferry_schedule->ship_id ? 'selected' : '' }}>
                                                {{ $ship_master->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Status</label>
                                        <select class="form-control" id="status" name="status" >
                                            <option value="">Select</option>
                                            <option value="Y" {{ $ferry_schedule->status == 'Y' ? 'selected' : '' }}>Yes</option>
                                            <option value="N" {{ $ferry_schedule->status == 'N' ? 'selected' : '' }}>No</option>
                                        </select>
                                    </select>
                                </div>






                                <div>
                                    <div class="card-header d-block mb-4" style="background-color: #c8d8f442!important;">
                                        <div class="text-center">
                                            <div class="h6 fw-semibold mb-0 ">Schedule Price</div>
                                        </div>
                                    </div>
                                    @php
                                        $i = 1;
                                    @endphp

                                    @foreach ($ferry_schedule_price as $row)
                                        <div class="row flist me-3 ms-1" id="row{{ $i++ }}">
                                            <div
                                                style="border:1px solid #ccc; margin-bottom:25px; border-radius:10px; padding:10px; position: relative">
                                                <div class="row pt-2">
                                                    <div>
                                                        <span class="btn btn-danger btn-xs "
                                                            style="position: absolute; right:10px; top:5px; padding:5px 10px"
                                                            id="del1" onclick="deleterow(this.id);">Delete</span>
                                                    </div>

                                                    <div class="col-md-3 p-2">
                                                        <label class="form-label">Ship CLass</label>
                                                        <select class="form-control" name="class_id[]" id="class_id">
                                                            <option value="">Select</option>
                                                            @foreach ($ship_classes as $shipclass)
                                                                <option value="{{ $shipclass->id }}"
                                                                    {{ $shipclass->id == $row->class_id ? 'selected' : '' }}>
                                                                    {{ $shipclass->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 p-2">
                                                        <label class="form-label">Price</label>
                                                        <input type="text" class="form-control" placeholder="Price"
                                                            aria-label="Title" id="price" name="price[]"
                                                            value="{{ $row->price }}">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="javascript:void(0)" class="btn btn-info btn-xs addrow"
                                                style="float: right;padding:5px 8px">Add Row</a>
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
                    var newRow = $(".flist:first").clone();
                    newRow.attr("id", "row" + ($(".flist").length));
                    newRow.insertAfter(".flist:last");

                    newRow.find("input[type=text], select").val("");
                    newRow.find("span").attr("id", "del" + ($(".flist").length));
                });


                $(document).on("click", ".btn-danger.btn-xs", function() {
                    var rowId = $(this).closest('.row.flist').attr('id');
                    var lastId = parseInt(rowId.replace("row", ""));
                    console.log(lastId);

                    if (lastId > 1) {
                        $(this).closest('.row.flist').remove();

                        $(".flist").each(function(index) {
                            var newIndex = index + 1;
                            $(this).attr("id", "row" + newIndex);
                            $(this).find("input[type=text], select").each(function() {
                                var newName = $(this).attr("name") + "_" + newIndex;
                                $(this).attr("name", newName);
                            });
                            $(this).find("span").attr("id", "del" + newIndex);
                        });
                    } else {
                        alert("This row cannot be deleted");
                    }
                });
            });
        </script>
    @endpush
