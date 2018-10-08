@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
    <purchase-index :purchases="{{ $purchases }}"></purchase-index>
@endsection