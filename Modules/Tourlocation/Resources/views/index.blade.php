@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Location</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-block">
                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                            <div class="h5 fw-semibold mb-0">Location</div>
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
                                @can('tourlocation-create')
                                    <a href="{{ route('tourlocation.create') }}" class="btn btn-success ms-2">Create</a>
                                @endcan
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
                        <table id="" class="table table-bordered text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($locations as $location)
                                    <tr>
                                        <td>{{ $location->id }}</td>
                                        <td>{{ $location->name}}</td>
                                        <td>{{ $location->description }}</td>
                                        <td>
                                            @if ($location->path)
                                                <img src="{{asset('uploads/location/'.$location->path)}}" alt=""
                                                    width="50">
                                            @endif
                                        </td>
                                        <td>
                                          <a class="btn btn-info"
                                              href="{{ route('tourlocation.show', $location->id) }}">Show</a>
                                          @can('tourlocation-edit')
                                              <a class="btn btn-primary"
                                                  href="{{ route('tourlocation.edit', $location->id) }}">Edit</a>
                                          @endcan
                                          @can('tourlocation-delete')
                                              {!! Form::open([
                                                  'method' => 'DELETE',
                                                  'route' => ['tourlocation.destroy', $location->id],
                                                  'style' => 'display:inline',
                                                  'onsubmit' => 'return confirmDelete()',
                                              ]) !!}
                                              {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                              {!! Form::close() !!}
                                          @endcan
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

   