<<<<<<< HEAD
@extends('layouts.admin')
@section('title','Blogs')
@section('content')
    <blog-index url="{{ url('/admin/blogs') }}" :posts="{{ $posts }}"></blog-index>
=======
@extends("layouts.admin")

@section("title", "Blogs")

@section('content')
    
>>>>>>> d62eac9afe32975df76815793f2974c30899db29
@endsection