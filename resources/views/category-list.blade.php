@extends('layout1')
@section('page-title','Category-List')
@section('page-subtitle','List of Categories')
@section('add')
    <a href="{{ route('category-create') }}">Create Category</a>
@endsection

@section('content')
@include('category-list-content')
@endsection
