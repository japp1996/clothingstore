@extends('layouts.admin')
@section('title', 'Contácto')
@section('content')
<social-edit :posts="{{ $social }}" url="{{ url('') }}"></social-edit>
@endsection