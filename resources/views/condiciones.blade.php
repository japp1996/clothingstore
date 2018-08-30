@extends('layouts.master')

@section('title')
	Condiciones de Compra
@stop

@section('content')
	<div class="contenido" id="condiciones">
		<h3 class="title title-line">
			Condiciones de Compra
		</h3>
		<p>
			{!! nl2br($condiciones->texto) !!}
		</p>
		<p class="item-right">
			{{ HTML::Image('img/icons/right.png') }}
			Condiciones de Envío con DHL
		</p>			
	</div>
@stop