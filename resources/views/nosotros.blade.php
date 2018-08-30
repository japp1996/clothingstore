@extends('layouts.master')

@section('title')
	¿Quiénes Somos?
@stop

@section('content')
	<div class="contenido" id="nosotros">
		<div class="row">
			<div class="col-md-5">
				<h2>¿Quiénes Somos?</h2>
				<p>{!! nl2br($nosotros->texto) !!}</p>
			</div>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-6 text-center">
						{{ HTML::Image('img/nosotros/mision.png') }}
					</div>
					<div class="col-md-6 text-center">
						{{ HTML::Image('img/nosotros/vision.png') }}
					</div>
					<div class="col-md-6">
						<h3>Misión</h3>
						<p>{!! nl2br($nosotros->mision) !!}</p>
					</div>
					<div class="col-md-6">
						<h3>Visión</h3>
						<p>{!! nl2br($nosotros->vision) !!}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop