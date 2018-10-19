@extends('layouts.admin')
@section('title','Banners')
@section('content')
    <bank-index url="{{ url('/admin/banners') }}" :banks="{{ $banks }}"></bank-index>
@endsection