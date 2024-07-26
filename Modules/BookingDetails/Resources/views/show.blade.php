@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bookingdetails.index') }}">Booking Details</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-block">
                    <div class="d-sm-flex d-block align-items-center justify-content-between">
                        <div class="h5 fw-semibold mb-0">Details</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('bookingdetails.index') }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
             
             
                <div class="text-muted fs-16">
                    <p> 
                    Name: {{$booking->c_name}}</p>
                  
                    <p class="text-muted fs-16">
                     Order Id :   {{$booking->order_id}}
                    </p>
                    
                    <p class="text-muted fs-16">
                        Amount :   {{$booking->amount}}
                       </p>
                       @if($booking->type == 'ferry')
            
                          <label class="form-label">Ferry Class :</label>
                           <p class="text-muted fs-16">
                               {{$booking->ferry_class}}
                           </p>
                
                       @endif

                        <label class="form-label">Ship Name:</label>
                        <p class="text-muted fs-16">
                            {{$booking->ship_name}}
                        </p>
          
                </div>
                <hr>
                @foreach ($detail as $details )
                    
                <div class="card-body">
                    <div class="col-xl-12 row">
                        <div class="col-md-6">
                            <label class="form-label">Booking Type :</label>
                            <p class="text-muted fs-16">
                               {{$details->type}}
                            </p>
                        </div>

                     
                        <div class="col-md-6">
                            <label class="form-label">Pessanger Name:</label>
                            <p class="text-muted fs-16">
                                {{$details->full_name}}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Age:</label>
                            <p class="text-muted fs-16">
                                {{$details->dob}}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Grender</label>
                            <p class="text-muted fs-16">
                                {{$details->gender}}
                            </p>
                        </div>
                       

                        <div class="col-md-6">
                            <label class="form-label">Amount :</label>
                            <p class="text-muted fs-16">
                                {{$details->amount}}
                            </p>
                        </div>
                      
                        <div class="col-md-6">
                            <label class="form-label">Country :</label>
                            <p class="text-muted fs-16">
                                {{$details->country}}
                            </p>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Passport :</label>
                            <p class="text-muted fs-16">
                                {{$details->passport_id}}
                            </p>
                        </div>

                       
                       


                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection