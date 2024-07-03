@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('boatschedule.index') }}">Boat Create</a></li>
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
                        <div class="h5 fw-semibold mb-0">Boat Create</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('boatschedule.index') }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12">

                        <form class="row g-3 mt-0" method="POST" action="{{ route('boatschedule.store') }}" id="creation_form" name="creation_form" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Title" aria-label="Title" id="title" name="title" value="{{old('title')}}">
                                <span class="text-danger">
                                    @error('title')
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
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control d" placeholder="Price"
                                    id="price" name="price" min="1" value="{{old('price')}}">
                                    
                                <span class="text-danger">
                                    @error('price')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG JPG and PNG file types are allowed</span>
                                <div class="form-group">
                                    <input type="file" name="image" id="image">

                                </div>
                                <span class="text-danger">
                                    @error('image')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="Y" {{ old('status', '') == 'Y'? 'selected' : '' }}>Active</option>
                                    <option value="N" {{ old('status', '') == 'N'? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            
                           
                            <div class="col-md-6">
                                <label class="form-label">Charters Speed Boat</label>
                                <input type="checkbox" 
                                    id="chek_box" name="chek_box" value="">
                            </div>


                            <div class="col-md-12 card d-none" id="charter_speed_boat_price">
                                <div class="card-header">
                                    Charters Speed Boat Price
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Passenger 1</label>
                                            <input type="text" 
                                                id="charters_speed_boat" name="passenger[1]" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Passenger 2</label>
                                            <input type="text" 
                                                id="charters_speed_boat" name="passenger[2]" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Passenger 3</label>
                                            <input type="text" 
                                                id="charters_speed_boat" name="passenger[3]" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Passenger 4</label>
                                            <input type="text" 
                                                id="charters_speed_boat" name="passenger[4]" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="form-label">Passenger 5</label>
                                            <input type="text" 
                                                id="charters_speed_boat" name="passenger[5]" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Passenger 6</label>
                                            <input type="text" 
                                                id="charters_speed_boat" name="passenger[6]" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Passenger 7</label>
                                            <input type="text" 
                                                id="charters_speed_boat" name="passenger[7]" value="">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Passenger 8</label>
                                            <input type="text" 
                                                id="charters_speed_boat" name="passenger[8]" value="">
                                        </div>
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
       
        $('#chek_box').on('change', function() {
            var cardDiv = $('#charter_speed_boat_price');
            if (this.checked) {
                cardDiv.removeClass('d-none'); 
            } else {
                cardDiv.addClass('d-none'); 
            }
        });

        document.getElementById('chek_box').addEventListener('change', function () {

        document.getElementById('chek_box').value = this.checked ? 'Y' : 'N';
    });

    });

  


</script>

@endpush