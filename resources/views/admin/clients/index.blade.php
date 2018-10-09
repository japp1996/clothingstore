@extends('layouts.admin')

@section('title', 'Pedidos')

@section('content')
    <client-index :clients="{{ $clients }}"></client-index>
@endsection