@extends('layouts.admin')
@section('title', 'Contácto')
@section('content')
    <social-index url="{{ url('admin/social') }}" :posts="{{ $social }}"></social-index>  
@endsection