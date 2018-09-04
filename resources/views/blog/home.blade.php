@extends('layouts.master')

@section('title')
	Mundo Wará
@stop

@section('content')
	<div class="contenido" id="mundo">
		<h2 class="title">Mundo Wará</h2>
		<p>Conoce más de nuestros embajadores, eventos y campañas</p>
		<div class="masonry">
			@foreach($blogs as $blog)
				<a href="{{ URL('mundo/view',$blog->id) }}">
					<div class="item">
						<img src="{{ URL('img/blogs/'.$blog->images[0]->file) }}" />
						<div class="container-text">
							<h4>{{ $blog->title }}</h4>
							<p class="fecha">Fecha: {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</p>
							<p class="ellipsis">{!! nl2br($blog->description) !!}</p>
						</div>
					</div>
				</a>
			@endforeach
		</div>
		<div class="text-center">
			{{ $blogs->links('vendor.pagination.bootstrap-4') }}
		</div>		
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		$(document).ready(function() {
			if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1){
				$('.item').css('display','inline-block');
			}

			$('.item').css('opacity','1');
		});
	</script>
@stop