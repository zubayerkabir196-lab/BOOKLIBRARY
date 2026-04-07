@extends('layout1')
@section('page-title','Create Author')
@section('add-link',route('authors.create'))
@section('page-subtitle','Add a new author to the collection')
@section('content')
@include('authorContent')
@endsection