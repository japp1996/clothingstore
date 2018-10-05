@extends('layouts.admin')
@section('title','Collecciones mayoristas')
@section('content')
<wholesaler-index :wholesaler="{{ $wholesalers }}"></wholesaler-index>
@endsection