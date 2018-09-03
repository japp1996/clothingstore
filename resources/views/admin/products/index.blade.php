@extends('layouts.admin')

@section('title', 'Productos')

@section('content')
    <product-index :categories="{{ $categories }}" :designs="{{ $designs }}" :collections="{{ $collections }}" :products="{{ $products }}" ></product-index>
@endsection