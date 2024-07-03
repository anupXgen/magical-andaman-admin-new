@extends('webusers::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>Module: {!! config('webusers.name') !!}</p>
@endsection
