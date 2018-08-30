@extends('layouts.master')

@section('title')
	Inicio
@stop

@section('content')
	<div class="contenido" id="intro">
		<div class="text-center">{{ HTML::Image('img/logo-intro.png') }}</div>
		<h2>Lorem ipsum dolor sit amet.</h2>
		<div class="text-center">
			<a href="{{ URL('home') }}">
				<button class="btn btn-default">
					Entrar
				</button>
			</a>
		</div>
	</div>
@stop