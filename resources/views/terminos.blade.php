@extends('layouts.master')

@section('title')
	@lang('Page.Terminos.Title')
@stop

@section('content')
	<div class="contenido" id="terminos">
		<h3 class="title title-line">
			@lang('Page.Terminos.Title')
		</h3>
		<p>
			{!! \App::getLocale() == 'es' ? nl2br($terminos->texto) : nl2br($terminos->english) !!}
		</p>	
	</div>
@stop