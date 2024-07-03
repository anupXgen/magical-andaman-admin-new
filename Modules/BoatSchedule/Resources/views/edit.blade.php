@extends('layouts.app')

@section('content')


<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('boatschedule.index') }}">Boat Edit</a></li>
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
                        <div class="h5 fw-semibold mb-0">Boat Edit</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('boatschedule.index') }}" class="btn btn-warning-light ms-2">Back</a>
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
                        <form class="row g-3 mt-0" method="POST"  action="{{ route('boatschedule.update', $boatschedules->id) }}" id="creation_form" name="creation_form" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control" placeholder="Title" aria-label="Title" id="title" name="title" value="{{ $boatschedules->title }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">From Date</label>
                                <input type="text" class="form-control datepicker" placeholder="From Date" id="from_date" name="from_date" value="{{ date('d-m-Y',strtotime($boatschedules->from_date))}}">
                               
                            </div>


                            <div class="col-md-6">
                                <label class="form-label">To Date</label>
                                <input type="text" class="form-control datepicker" placeholder="To Date"
                                    id="to_date" name="to_date" value="{{date('d-m-Y',strtotime($boatschedules->to_date))}}">
                              
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control d" placeholder="Price"
                                    id="price" name="price" min="1" value="{{ $boatschedules->price }}">
                                    
                               
                            </div>


                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" >
                                        <option value="Y" {{ $boatschedules->status == 'Y' ? 'selected' : '' }}>Active</option>
                                        <option value="N" {{ $boatschedules->status == 'N' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </select>
                            </div>

                            
                            <div class="col-md-12">
                                <label class="form-label" for="document">Images </label><span class="text-muted"> Only JPEG and JPG file types are allowed</span>
                                <div class="form-group">
                                    <input type="file" name="image" id="image">
                                </div>
                                @if ($boatschedules->image)
                                    <img src="{{asset('uploads/boat/'.$boatschedules->image)}}" alt="" width="100">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Charters Speed Boat</label>
                                <input type="checkbox" 
                                    id="charters_speed_boat" value="chek_box" name="chek_box" {{  $charterBoat == '' ? 'checked' : ''
                                     }}>
                            </div>


                            <div class="col-md-12 card {{ $charterBoat }}" id="charter_speed_boat_price">
                                <div class="card-header">
                                    Charters Speed Boat Price
                                </div>
                               
                                   
                              
                                <div class="card-body">
                                    <div class="row">
                                        @for($i=1;$i<=8;$i++)
                                        <div class="col-md-3">
                                            <label class="form-label">Passenger {{$i}}</label>
                                            <input type="text" 
                                                id="charters_speed_boat" name="passenger[{{$i}}]" value="{{ !empty($boat_schedule_prices) ? $boat_schedule_prices[$i-1]->per_passenger_price : ''}}">
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-12">
                                <button type="button" class="btn btn-light" onclick="javascript:location.reload()">Cancel</button>
                                <button type="submit" class="btn btn-primary">Update</button>
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
        $('#charters_speed_boat').on('change', function() {
            var cardDiv = $('#charter_speed_boat_price');
            if (this.checked) {
                cardDiv.removeClass('d-none'); 
            } else {
                cardDiv.addClass('d-none'); 
            }
        });
    });
</script>

@endpush