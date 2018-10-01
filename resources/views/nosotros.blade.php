@extends('layouts.master')

@section('title')
	@lang('Page.Nosotros.Title')
@stop

@section('content')
	<div class="contenido" id="nosotros">
		<div class="row">
			<div class="col-md-5">
				<h2>@lang('Page.Nosotros.Title')</h2>
				<p>{!! \App::getLocale() == 'es' ? nl2br($nosotros->texto) : nl2br($nosotros->english) !!}</p>
			</div>
			<div class="col-md-7">
				<div class="row">
					<div class="col-md-6 text-center">
						{{ HTML::Image('img/nosotros/mision.png') }}
					</div>
					<div class="col-md-6 text-center vision-no-responsive">
						{{ HTML::Image('img/nosotros/vision.png') }}
					</div>
					<div class="col-md-6">
						<h3>@lang('Page.Nosotros.Mision')</h3>
						<p>{!! \App::getLocale() == 'es' ? nl2br($nosotros->mision) : nl2br($nosotros->mision_english) !!}</p>
					</div>
					<div class="col-md-6 text-center vision-responsive">
						{{ HTML::Image('img/nosotros/vision.png') }}
					</div>
					<div class="col-md-6">
						<h3>@lang('Page.Nosotros.Vision')</h3>
						<p>{!! \App::getLocale() == 'es' ? nl2br($nosotros->vision) : nl2br($nosotros->vision_english) !!}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop