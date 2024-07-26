@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blogs</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-block">
                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                            <div class="h5 fw-semibold mb-0">Blog Management</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <form id='searchform' name='searchform' action='{{ route('blog.index') }}'>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0"
                                            placeholder="Search blog" aria-describedby="search-contact-member"
                                            id='search_txt' name='search_txt'>
                                        <button class="btn btn-light" type="submit" id="search-blog"><i
                                                class="ri-search-line text-muted"></i></button>
                                    </div>
                                </form>
                                <div class="dropdown ms-2 d-none">
                                    <button class="btn btn-icon btn-primary-light btn-wave" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:void(0);">Delete All</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Copy All</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Move To</a></li>
                                    </ul>
                                </div>
                                @can('blog-create')
                                    <a href="{{ route('blog.create') }}" class="btn btn-success ms-2">Create</a>
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
                            
                            <table id="" class="table table-striped text-nowrap w-100 mb-2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Author Name</th>
                                        <th>Subtitle</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $blog)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td style="white-space: pre-wrap; max-width: 300px; word-wrap: break-word;">
                                                {{ $blog->title }}</td>
                                            <td>{{ ucfirst($blog->author_name) }}</td>
                                            <td style="white-space: pre-wrap; max-width: 300px; word-wrap: break-word;">
                                                {{ $blog->subtitle }}</td>
                                            <td>
                                                <a class="btn" href="{{ route('blog.show', $blog->id) }}"><i
                                                        class='bx bxs-show fs-4'></i></a>
                                                @can('blog-edit')
                                                    <a class="btn " href="{{ route('blog.edit', $blog->id) }}"><i
                                                            class='bx bxs-edit fs-4'></i></a>
                                                @endcan

                                                {!! Form::open(['method' => 'DELETE', 'route' => ['blog.destroy', $blog->id], 'style' => 'display:inline']) !!}
                                                {!! Form::button('<i class="bx bxs-trash-alt"></i>', [
                                                    'type' => 'submit',
                                                    'class' => 'btn',
                                                    'onclick' => 'return confirmDelete()',
                                                ]) !!}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $data->appends(Request::all())->links('pagination::bootstrap-4') }}
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
