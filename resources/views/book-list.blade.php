@extends('layout1')
@section('page-title','Books')
@section('page-subtitle','List of Books')
@section('add')
<a href="{{ route('book-create') }}"> Create Book</a>
@endsection
@section('content')
@include('book-list-content')
@endsection
