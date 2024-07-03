@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('role.index') }}">Roles</a></li>
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
                        <div class="h5 fw-semibold mb-0">Role</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('role.index') }}" class="btn btn-warning-light ms-2">Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-xl-12 row">
                        <div class="col-md-6">
                            <label class="form-label">Name :</label>
                            <p class="text-muted fs-16">
                                {{ ($role->name)?$role->name:'' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Permission :</label>
                            <p class="text-muted fs-16">
                                @if(!empty($rolePermissions))
                                @foreach($rolePermissions as $value)
                                <!-- <input class="form-check-input form-checked-outline form-checked-secondary" name="permission[]" type="checkbox" checked disable> -->
                                <i class="bi bi-bookmark-check text-secondary"></i>
                                <label>{{ $value->name }}</label>
                                <br />
                                @endforeach
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection