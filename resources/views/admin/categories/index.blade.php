@extends('layouts.admin')

@section('title', 'Categorías')

@section('content')
    <categoy-index url="{{ url('/admin') }}" :sizes="{{ $sizes }}" :categories="{{ $categories }}"></categoy-index>
@endsection