@extends('layouts.master')

@section('title')
	Mundo Wará
@stop

@section('content')
	<div class="contenido" id="mundo">
		<h2 class="title">Mundo Wará</h2>
		<p>Entérate con nosotros los nuevos eventos, campañas y nuestros embajadores</p>
		<div class="masonry">
			@foreach($blogs as $blog)
				<div class="item">
					<img src="{{ URL('img/blogs/'.$blog->images[0]->file) }}" />
					<div class="container-text">
						<h4>{{ $blog->title }}</h4>
						<p class="fecha">Fecha: {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</p>
						<p class="ellipsis">{!! nl2br($blog->description) !!}</p>
					</div>
				</div>
			@endforeach
		</div>
		<div class="text-center">
			{{ $blogs->links('vendor.pagination.bootstrap-4') }}
		</div>		
	</div>
@stop