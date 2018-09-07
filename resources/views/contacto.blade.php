@extends('layouts.master')

@section('title')
	@lang('Page.Contacto.Title')
@stop

@section('content')
	<div class="contenido" id="contacto">
		<div class="row">
			<div class="col-md-5 text-center right-line-container">
				<h2 class="title">@lang('Page.Contacto.Contactanos')</h2>
				<p><strong>@lang('Page.Contacto.Telefono'):</strong> {{ $_sociales->phone }}</p>
				<p><strong>@lang('Page.Contacto.Email'):</strong> {{ $_sociales->email }}</p>
				<p><strong>@lang('Page.Contacto.Ubicacion'):</strong> {!! nl2br($_sociales->address) !!}</p>
				<div class="right-line"></div>
			</div>
			<div class="col-md-7 text-center">
				{{ Form::open(['v-on:submit.prevent' => 'submit()']) }}
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('nombre',Lang::get('Page.Contacto.Nombre')) }}
								{{ Form::text('nombre','',['class' => 'form-control','v-model' => 'form.nombre']) }}
							</div>
							<div class="form-group">
								{{ Form::label('email',Lang::get('Page.Contacto.Email')) }}
								{{ Form::text('email','',['class' => 'form-control','v-model' => 'form.email']) }}
							</div>
							<div class="form-group">
								{{ Form::label('pais',Lang::get('Page.Contacto.Pais')) }}
								{{ Form::select('pais',$paises,null,['class' => 'form-control','v-model' => 'form.pais']) }}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('mensaje',Lang::get('Page.Contacto.Mensaje')) }}
								{{ Form::textarea('mensaje','',['class' => 'form-control','v-model' => 'form.mensaje', 'rows' => 8]) }}
							</div>
						</div>
					</div>
					<div class="text-center">
						<button class="btn btn-default" type="submit">
							@lang('Page.Contacto.Enviar')
						</button>
					</div>
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#contacto',
			data: {
				form: {
					nombre: '',
					email: '',
					mensaje: '',
					pais: ''
				}
			},
			methods: {
				submit() {
					setLoader();
					axios.post("{{ URL('contacto') }}",this.form)
						.then(res => {
							if (res.data.result) {
								swal('','{{ Lang::get('Page.Contacto.Success') }}','success');
								this.form = {};
							}
							else {
								swal('',res.data.error,'warning');
							}
						})
						.catch(err => {
							swal('',"{{ Lang::get('Page.Error') }}",'warning');
						})
						.then(() => {
							quitLoader();
						});
				}
			}
		});
	</script>
@stop