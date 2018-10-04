@extends('layouts.admin')
@section('title','Wholesalers')
@section('content')
<wholesaler-index :wholesaler="{{ $wholesalers }}"></wholesaler-index>
@endsection