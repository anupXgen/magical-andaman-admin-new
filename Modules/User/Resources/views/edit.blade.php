@extends('layouts.app')

@section('content')

<div class="container-fluid">
    <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
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
                        <div class="h5 fw-semibold mb-0">User Edit</div>
                        <div class="d-flex mt-sm-0 mt-2 align-items-center">
                            <a href="{{ route('user.index') }}" class="btn btn-warning-light ms-2">Back</a>
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
                        <form class="row g-3 mt-0" method="POST" action="{{ route('user.update', $user->id) }}" id="creation_form" name="creation_form">
                            @csrf
                            @method('PATCH')
                            <div class="col-md-6">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" placeholder="Name" aria-label="Name" id="name" name="name" value="{{ ($user->name)?$user->name:'' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="inputEmail4" class="form-label">Email</label>
                                <input type="text" class="form-control" placeholder="Email" aria-label="Email" id="email" name="email" value="{{ ($user->email)?$user->email:'' }}">
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" placeholder="******" id="password" name="password" value="">
                            </div>
                            <div class="col-md-6">
                                <label for="confirm-password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" placeholder="******" id="confirm-password" name="confirm-password">
                            </div>
                            <div class="col-md-6">
                                <label for="roles" class="form-label">Role</label>
                                <!-- <select class="form-control" multiple="" name="roles[]" id="roles">
                                    @if(!empty($roles))
                                    @foreach($roles as $val)
                                    <option value="{{ $val }}">{{ $val }}</option>
                                    @endforeach
                                    @endif
                                </select> -->
                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','id'=>'roles','multiple')) !!}
                            </div>
                            <div class="col-md-6">
                                <label for="roles" class="form-label">Role Accessable Permissions</label>
                                <div class="justify-content-center" id="appendPermissionList">


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
<script type="text/javascript">
    $(document).ready(function() {
        get_role_permission_page();
    });
    $("#roles").on('change', function() {
        get_role_permission_page();
    });

    function get_role_permission_page() {
        $("#appendPermissionList").html('');
        var APP_URL = "{{ url('/') }}";
        var user_id = "{{ $user->id }}";
        var roles = $("#roles").val();
        if ($.trim(roles) != '') {
            $.ajax({
                type: "GET",
                url: APP_URL + '/get_role_permission_page',
                datatype: "json",
                data: {
                    'roles': roles,
                    'user_id': user_id
                },
                beforeSend: function() {
                    $("#appendPermissionList").html('<div class="spinner-border text-info" role="status"><span class="visually-hidden">Loading...</span></div>');
                },
                complete: function() {},
                success: function(data, textStatus, jqXHR) {
                    $("#appendPermissionList").html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {}
            });
        }
    }
    $(document).on('submit', "#creation_form", function(e) {
        //e.preventDefault();
        $(".invalid_msg").remove();
        var error = 0;
        if ($.trim($("#name").val()) == '') {
            $("#name").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_name'>Please enter your full name.</div>");
            $("#invalid_msg_name").show();
            error++;
        }
        if ($.trim($("#email").val()) == '') {
            $("#email").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_email'>Please enter your email id.</div>");
            $("#invalid_msg_email").show();
            error++;
        }
        if ($.trim($("#password").val()) == '') {
            // $("#password").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_email'>Please enter password.</div>");
            // $("#invalid_msg_email").show();
            // error++;
        } else {
            if ($.trim($("#confirm-password").val()) == '') {
                $("#confirm-password").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_confirm-password'>Please confirm passwords.</div>");
                $("#invalid_msg_confirm-password").show();
                error++;
            } else {
                if ($("#password").val() != $("#confirm-password").val()) {
                    $("#confirm-password").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_confirm-password'>You have entered a wrong password.</div>");
                    $("#invalid_msg_confirm-password").show();
                    error++;
                }
            }
        }
        if ($('#roles').val() == '') {
            $("#roles").after("<div class='invalid-feedback invalid_msg' id='invalid_msg_roles'>Please select role.</div>");
            $("#invalid_msg_roles").show();
            error++;
        }

        if (error == 0) {
            return true;
            $("#creation_form").submit();
        } else {
            return false;
        }

    });
</script>
@endpush