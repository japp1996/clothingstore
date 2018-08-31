@extends('layouts.master')

@section('title')
	Aliados Comerciales
@stop

@section('content')
	<div class="contenido" id="aliados">
		<h2 class="title">Aliados Comerciales</h2>
		<div class="masonry">
			@foreach($aliados as $aliado)
				<div class="item">
					<div class="container-item">
						<div id="carousel{{ $aliado->id }}" class="carousel slide carousel-fade" data-ride="carousel">
						
						  <div class="carousel-inner">
							@foreach($aliado->fotos as $key => $item)
							    <div class="carousel-item @if ($key == 0) active @endif">
							      <img class="d-block w-100" src="{{ URL('img/aliados/'.$item->file) }}" />
							    </div>
							 @endforeach
						  </div>
						
						  <a class="carousel-control-prev" href="#carousel{{ $aliado->id }}" role="button" data-slide="prev">
						    {{ HTML::Image('img/icons/left.png') }}
						  </a>
						  <a class="carousel-control-next" href="#carousel{{ $aliado->id }}" role="button" data-slide="next">
						    {{ HTML::Image('img/icons/right.png') }}
						  </a>		  
						</div>
						
						<div class="container-text">
							<h2>{{ $aliado->name }}</h2>
							<div class="text-center">
								<table>
									<tr>
										<td>
											<a href="{{ $aliado->instagram }}" class="instagram_white">
												{{ HTML::Image('img/icons/instagram.png') }}
											</a>
										</td>
										<td>
											<a href="{{ $aliado->facebook }}" class="facebook_white">
												{{ HTML::Image('img/icons/facebook.png') }}
											</a>
										</td>
										<td>
											<a href="{{ $aliado->twitter }}" class="youtube">
												{{ HTML::Image('img/icons/twitter.png') }}
											</a>
										</td>
									</tr>
								</table>
							</div>
							<p class="bold">Ubicación:</p>
							<p>{!! nl2br($aliado->address) !!}</p>
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@stop