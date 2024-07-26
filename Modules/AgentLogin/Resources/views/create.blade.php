@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('agentlogin.index') }}">Agent Create</a></li>
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
                            <div class="h5 fw-semibold mb-0">Agent Create</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <a href="{{ route('agentlogin.index') }}" class="btn btn-warning-light ms-2">Back</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-xl-12">

                            <form class="row g-3 mt-0" method="POST" action="{{ route('agentlogin.store') }}"
                                id="creation_form">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Name" aria-label="name"
                                        id="name" name="name" value="{{ old('name') }}">
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" placeholder="Phone" id="phone"
                                        name="phone" value="{{ old('phone') }}">
                                    <span class="text-danger">
                                        @error('phone')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" placeholder="Email" id="email"
                                        name="email" value="{{ old('email') }}">
                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control" placeholder="Address" id="address"
                                        name="address" value="{{ old('address') }}">
                                    <span class="text-danger">
                                        @error('address')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Pan Number</label>
                                    <input type="text" class="form-control" placeholder="Pan Number" id="pan_number"
                                        name="pan_number" value="{{ old('pan_number') }}">
                                    <span class="text-danger">
                                        @error('pan_number')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" id="password"
                                        name="password" value="{{ old('password') }}">


                                    <i id="togglePassword" class="fas fa-eye-slash toggle-password"
                                        onclick="togglePasswordVisibility(this)"
                                        style="position:absolute; right:20px; top:73%; transform: translateY(-50%); cursor:pointer;"></i>


                                    <span class="text-danger">
                                        @error('password')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>


                                <div class="col-md-6">
                                    <label class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="password_confirmation "
                                        id="password" name="password_confirmation"
                                        value="{{ old('password_confirmation') }}">


                                    <i id="toggleConfirmPassword" class="fas fa-eye-slash toggle-password"
                                        onclick="togglePasswordVisibility(this)"
                                        style="position:absolute; right:20px; top:73%; transform: translateY(-50%); cursor:pointer;"></i>

                                    <span class="text-danger">
                                        @error('password_confirmation')
                                            {{ $message }}
                                        @enderror
                                    </span>
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
    <script>
        document.getElementById('pan_number').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });


        function togglePasswordVisibility(iconElement) {
            const inputId = iconElement.id === 'togglePassword' ? 'password' : 'password_confirmation';
            const inputField = document.getElementById(inputId);

            // Toggle the type attribute
            inputField.type = inputField.type === 'password' ? 'text' : 'password';

            // Toggle the icon
            iconElement.classList.toggle('fa-eye');
            iconElement.classList.toggle('fa-eye-slash');
        }
    </script>
@endpush
