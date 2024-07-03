@extends('layouts.app')


@section('content')
<div class="container-fluid">
  <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
    <div class="ms-md-1 ms-0">
      <nav>
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">menu</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12">
      <div class="card custom-card">
        <div class="card-header d-block">
          <div class="d-sm-flex d-block align-items-center justify-content-between">
            <div class="h5 fw-semibold mb-0">Menu Management</div>
            <div class="d-flex mt-sm-0 mt-2 align-items-center">
              <div class="input-group">
                <input type="text" class="form-control bg-light border-0" placeholder="Search menu" aria-describedby="search-contact-member">
                <button class="btn btn-light" type="button" id="search-contact-member"><i class="ri-search-line text-muted"></i></button>
              </div>
              <div class="dropdown ms-2 d-none">
                <button class="btn btn-icon btn-primary-light btn-wave" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="ti ti-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="javascript:void(0);">Delete All</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);">Copy All</a></li>
                  <li><a class="dropdown-item" href="javascript:void(0);">Move To</a></li>
                </ul>
              </div>
              @can('menu-create')
              <a href="{{ route('menu.create') }}" class="btn btn-success ms-2">Create</a>
              @endcan
            </div>
          </div>
        </div>
        <div class="card-body">
          <table id="" class="table table-bordered text-nowrap w-100 mb-2">
            <thead>
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Url</th>
                <th width="280px">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($menus as $key => $menu)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $menu->title }}</td>
                <td>{{ $menu->base_url }}</td>
                <td>
                  <form action="{{ route('menu.destroy',$menu->id) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('menu.show',$menu->id) }}">Show</a>
                    @can('menu-edit')
                    <a class="btn btn-primary" href="{{ route('menu.edit',$menu->id) }}">Edit</a>
                    @endcan
                    @csrf
                    @method('DELETE')
                    @can('menu-delete')
                    <button type="submit" class="btn btn-danger">Delete</button>
                    @endcan
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          {{ $menus->appends(Request::all())->links("pagination::bootstrap-4"); }}
        </div>
      </div>
    </div>
  </div>

  @endsection