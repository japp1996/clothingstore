@extends('layouts.master')

@section('title')
	Mundo Wará
@stop

@section('content')
	<div class="contenido" id="mundo">
		<h2 class="title">Mundo Wará</h2>
		<p>Entérate con nosotros los nuevos eventos, campañas y nuestros embajadores</p>
		<div class="row">
			@foreach($blogs as $blog)
				<div class="col-md-4">
					<div class="blog-image" style="background-image: url({{ URL('img/blogs/'.$blog[0]->file) }})"></div>
					<h4>{{ $blog->title }}</h4>
					<p>Fecha: {{ \Carbon\Carbon::parse($blog->created_at)->format('d.m.Y') }}</p>
					<p>{!! nl2br($blog->description) !!}</p>
				</div>
			@endforeach
		</div>
		<div class="text-center">
			<ul class="pagination justify-content-center">
		         {{ $blogs->links('vendor.pagination.bootstrap-4') }}
		    </ul>
		</div>		
	</div>
@stop