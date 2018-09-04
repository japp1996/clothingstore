@extends('layouts.master')

@section('title')
	Ver Blog
@stop

@section('content')
	<div class="contenido contenido-no-padding" id="ver-blog">
		<div id="carousel" class="carousel slide carousel-fade" data-ride="carousel">

		  <div class="carousel-inner">
			@foreach($blog->images as $key => $item)
			    <div class="carousel-item @if ($key == 0) active @endif">
			      <img class="d-block w-100" src="{{ URL('img/blogs/'.$item->file) }}" />
			    </div>
			 @endforeach
		  </div>

		  <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
		    {{ HTML::Image('img/icons/left.png') }}
		  </a>
		  <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
		    {{ HTML::Image('img/icons/right.png') }}
		  </a>		  
		</div>

		<div class="container-text">
			<h2>{{ $blog->title }}</h2>
			<p class="fech">Fecha: {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</p>
			<p>{!! nl2br($blog->description) !!}</p>
		</div>
	</div>
@stop