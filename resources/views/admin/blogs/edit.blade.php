@extends('layouts.admin')
@section('title', "Editar Blogs")
@section('content')
<blog-edit :posts="{{$posts}}" :set-images="{{$images}}"></blog-edit>
@endsection