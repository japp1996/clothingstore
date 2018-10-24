@extends('layouts.admin')
@section('title','Banners')
@section('content')
<bank-index url="{{ url('/admin/banners') }}" :accounts="{{ $accounts }}" :banks="{{ $banks }}"></bank-index>
@endsection