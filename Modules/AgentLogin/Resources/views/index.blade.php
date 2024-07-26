
@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Agent Login</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-block">
                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                            <div class="h5 fw-semibold mb-0">Agent Login</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <form id='searchform' name='searchform' action=''>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0"
                                            placeholder="Search banner" aria-describedby="search-contact-member"
                                            id='search_txt' name='search_txt'>
                                        <button class="btn btn-light" type="submit" id="search-banner"><i
                                                class="ri-search-line text-muted"></i></button>
                                    </div>
                                </form>
                                <div class="dropdown ms-2 d-none">
                                    <button class="btn btn-icon btn-primary-light btn-wave" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                </div>
                                    <a href="{{ route('agentlogin.create') }}" class="btn btn-success ms-2">Create</a>
                               
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                        <table id="" class="table table-striped w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Agent Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Pan number</th>
                                    <th>Action</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i=1;
                                @endphp
                                @foreach ($agent_logins as $agent_login)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{ $agent_login->name }}</td>
                                        <td>{{ $agent_login->email }}</td>
                                        <td>{{ $agent_login->phone }}</td>
                                        <td>{{ $agent_login->pan_number }}</td>
                                        <td>
                                            {{-- <a class="btn "
                                                href="{{ route('agentlogin.show', $agent_login->id) }}"><i
                                                    class='bx bxs-show fs-4'></i></a> --}}
                                            {{-- @can('agentlogin-edit') --}}
                                                <a class="btn "
                                                    href="{{ route('agentlogin.edit', $agent_login->id) }}"><i
                                                        class='bx bxs-edit fs-4'></i></a>
                                            {{-- @endcan --}}
                                    
                                            {{-- @can('agentlogin-delete') --}}
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['agentlogin.destroy', $agent_login->id], 'style' => 'display:inline']) !!}
                                            {!! Form::button('<i class="bx bxs-trash-alt"></i>', [
                                                'type' => 'submit',
                                                'class' => 'btn',
                                                'onclick' => 'return confirmDelete()',
                                            ]) !!}
                                            {!! Form::close() !!}
                                            {{-- @endcan --}}

                                            <a href="{{ route('agentlogin.show', $agent_login->id) }}">
                                                <i class="bi bi-person-badge-fill" style="font-size: 1rem;"></i>
                                            </a>
                                      
                                        </td>
                                    </tr>
                                    @endforeach
                            
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
          function confirmDelete() {
              return confirm('Are you sure you want to delete this item?');
          }
      </script>
@endsection

   
