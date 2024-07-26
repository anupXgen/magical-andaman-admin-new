@extends('layouts.app')


@section('content')
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-2 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"></h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Faq</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header d-block">
                        <div class="d-sm-flex d-block align-items-center justify-content-between">
                            <div class="h5 fw-semibold mb-0">Faq Management</div>
                            <div class="d-flex mt-sm-0 mt-2 align-items-center">
                                <form id='searchform' name='searchform' action=''>
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0"
                                            placeholder="Search Question/Answer" aria-describedby="search-contact-member"
                                            id='search_txt' name='search_txt'>
                                        <button class="btn btn-light" type="submit" id="search-activity"><i
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
                                {{-- @can('activity-create') --}}
                                <a href="{{ route('faqs.create') }}" class="btn btn-success ms-2">Create</a>
                                {{-- @endcan --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        <table id="" class="table table-striped text-nowrap w-100 mb-2">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Questions</th>
                                    <th>Answers</th>
                                    <th>Related Module</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($data as $key => $faq)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td style="inline-size: 300px; white-space: normal; ">{{ ucfirst($faq->questions) }}
                                        </td>
                                        <td style="inline-size: 400px; white-space: normal; ">{{ ucfirst($faq->answers) }}
                                        </td>
                                        <td>{{ $faq->related_module }}</td>

                                        <td>
                                            <a class="btn" href="{{ route('faqs.show', $faq->id) }}"><i
                                                    class='bx bxs-show fs-4'></i></a>
                                            {{-- @can('faq-edit') --}}
                                            <a class="btn " href="{{ route('faqs.edit', $faq->id) }}"><i
                                                    class='bx bxs-edit fs-4'></i></a>
                                            {{-- @endcan --}}

                                            {{-- @can('faq-delete') --}}
                                           
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['faqs.destroy', $faq->id], 'style' => 'display:inline']) !!}
                                            {!! Form::button('<i class="bx bxs-trash-alt"></i>', [
                                                'type' => 'submit',
                                                'class' => 'btn',
                                                'onclick' => 'return confirmDelete()',
                                            ]) !!}
                                            {!! Form::close() !!}
                                            {{-- @endcan --}}
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
