@extends('layouts.master')

@section('title')
	Contacto
@stop

@section('content')
	<div class="contenido" id="contacto">
		<div class="row">
			<div class="col-md-5 text-center right-line-container">
				<h2 class="title">Contáctanos</h2>
				<p><strong>Teléfono:</strong> 000-000.0000</p>
				<p><strong>Correo Electrónico:</strong> correo@gmail.com</p>
				<p><strong>Ubicación:</strong> Venezuela</p>
				<div class="right-line"></div>
			</div>
			<div class="col-md-7 text-center">
				{{ Form::open(['v-on:submit.prevent' => 'submit()']) }}
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('nombre','Nombre Completo') }}
								{{ Form::text('nombre','',['class' => 'form-control','v-model' => 'form.nombre']) }}
							</div>
							<div class="form-group">
								{{ Form::label('email','Correo Electrónico') }}
								{{ Form::text('email','',['class' => 'form-control','v-model' => 'form.email']) }}
							</div>
							<div class="form-group">
								{{ Form::label('pais','País') }}
								{{ Form::select('pais',$paises,null,['class' => 'form-control','v-model' => 'form.pais']) }}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('mensaje','Mensaje') }}
								{{ Form::textarea('mensaje','',['class' => 'form-control','v-model' => 'form.mensaje', 'rows' => 8]) }}
							</div>
						</div>
					</div>
					<div class="text-center">
						<button class="btn btn-default" type="submit">
							Enviar Mensaje
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
								swal('','Su mensaje ha sido enviado','success');
							}
							else {
								swal('',res.data.error,'warning');
							}
						})
						.catch(err => {
							swal('',"Se ha producido un error",'warning');
						})
						.then(() => {
							quitLoader();
						});
				}
			}
		});
	</script>
@stop