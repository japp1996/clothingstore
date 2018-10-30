@extends('layouts.admin')

@section('title', 'Clientes')

@section('content')
    <client-index :clients="{{ $clients }}"></client-index>
@endsection