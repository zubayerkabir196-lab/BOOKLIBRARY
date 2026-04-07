@extends('layout1')
@section('page-title','Author')
@section('page-subtitle','List of Authors')
@section('add')
    <a href="{{ route('authors.create') }}">Add Author</a>
@endsection

@section('content')
@include('authors-table')
@endsection