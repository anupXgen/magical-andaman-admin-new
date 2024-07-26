@extends('layouts.app')


@section('content')
<div class="container-fluid">
  <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
    <div class="ms-md-1 ms-0">
      <nav>
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">testimonials</li>
        </ol>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col-xl-12">
      <div class="card custom-card">
        <div class="card-header d-block">
          <div class="d-sm-flex d-block align-items-center justify-content-between">
            <div class="h5 fw-semibold mb-0">testimonial Management</div>
            <div class="d-flex mt-sm-0 mt-2 align-items-center">
              <form id='searchform' name='searchform' action=''>
                <div class="input-group">
                  <input type="text" class="form-control bg-light border-0" placeholder="Search testimonial" aria-describedby="search-contact-member" id='search_txt' name='search_txt'>
                  <button class="btn btn-light" type="submit" id="search-testimonial"><i class="ri-search-line text-muted"></i></button>
                </div>
              </form>
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
              @can('testimonial-create')
              <a href="{{ route('testimonial.create') }}" class="btn btn-success ms-2">Create</a>
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
        <div class="card-body">
          <table id="" class="table table-striped w-100 mb-2">
            <thead>
              <tr>
                <th>No</th>
                <th>Title</th>
                <th>Subtitle</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $key => $testimonial)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ ucfirst($testimonial->title) }}</td>
                <td style="white-space: pre-wrap; max-width: 300px; word-wrap: break-word;">{{$testimonial->subtitle }}</td>
                {{-- <td>
                  <a class="btn btn-info" href="{{ route('testimonial.show',$testimonial->id) }}">Show</a>
                  @can('testimonial-edit')
                  <a class="btn btn-primary" href="{{ route('testimonial.edit',$testimonial->id) }}">Edit</a>
                  @endcan
                  @can('testimonial-delete')
                  {!! Form::open(['method' => 'DELETE','route' => ['testimonial.destroy', $testimonial->id],'style'=>'display:inline']) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                  {!! Form::close() !!}
                  @endcan
                </td> --}}

                <td>
                  <a class="btn"
                      href="{{ route('testimonial.show', $testimonial->id) }}"><i
                          class='bx bxs-show fs-4'></i></a>
                  @can('testimonial-edit')
                      <a class="btn "
                          href="{{ route('testimonial.edit', $testimonial->id) }}"><i
                              class='bx bxs-edit fs-4'></i></a>
                  @endcan
          
                  @can('testimonial-delete')
                      {!! Form::open([
                          'method' => 'DELETE',
                          'onsubmit' => 'return confirmDelete()',
                          'route' => ['testimonial.destroy', $testimonial->id],
                          'style' => 'display:inline',
                      ]) !!}
                      {!! Form::button('<i class="bx bxs-trash-alt"></i>', [
                          'type' => 'submit',
                          'class' => 'btn',
                          'onclick' => 'return confirmDelete()',
                      ]) !!}
                      {!! Form::close() !!}
                  @endcan
                </td>

              </tr>
              @endforeach
            </tbody>
          </table>
          {{ $data->appends(Request::all())->links("pagination::bootstrap-4"); }}
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