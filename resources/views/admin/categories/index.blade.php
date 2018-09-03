@extends('layouts.admin')

@section('tilte', 'Categorías')

@section('content')
    <categoy-index url="{{ url('/admin') }}" :sizes="{{ $categories }}" :categories="{{ $sizes }}"></categoy-index>
@endsection