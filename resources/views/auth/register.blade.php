@extends('layouts.master')

@section('title')
	Regístrarse
@stop

@section('content')
	<div class="contenido" id="register">
		<div class="row">
			<div class="col-md-5 text-center right-line-container">
				<h2 class="title">Regístrate</h2>
				<p>Llena los siguientes campos para crear tu cuenta en Wára y descubrir más de nosotros. ¿Tienes ya una cuenta?</p>
				<div class="text-center">
					<a href="{{ URL('login') }}">
						<button class="btn btn-default" type="submit">
							Iniciar Sesión
						</button>
					</a>
				</div>
				<a href="{{ URL('condiciones') }}" class="item-right">
					{{ HTML::Image('img/icons/right.png') }}
					Condiciones de Compra
				</a>
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
								{{ Form::label('type','Tipo de Persona') }}
								{{ Form::select('type',[
									'1' => 'Persona Natural',
									'2' => 'Persona Jurídica'
								],null,['class' => 'form-control','v-model' => 'form.type']) }}
							</div>
							<div class="form-group">
								{{ Form::label('empresa','Nombre de Empresa') }}
								<input type="text" v-model="form.empresa" :disabled="form.type != '2'" class="form-control" name="empresa" id="empresa" />
							</div>
							<div class="form-group">
								{{ Form::label('pais','País') }}
								{{ Form::select('pais',$paises,null,['class' => 'form-control','v-model' => 'form.pais', 'v-on:change' => "form.estado = ''"]) }}
							</div>
							<div class="form-group">
								{{ Form::label('codigo','Código Postal') }}
								{{ Form::text('codigo','',['class' => 'form-control','v-model' => 'form.codigo']) }}
							</div>
							<div class="form-group">
								{{ Form::label('direccion','Dirección') }}
								{{ Form::text('direccion','',['class' => 'form-control','v-model' => 'form.direccion']) }}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('email','Correo Electrónico') }}
								{{ Form::text('email','',['class' => 'form-control','v-model' => 'form.email']) }}
							</div>
							<div class="form-group">
								{{ Form::label('identificacion','Identificación') }}
								{{ Form::text('identificacion','',['class' => 'form-control','v-model' => 'form.identificacion']) }}
							</div>
							<div class="form-group">
								{{ Form::label('telefono','Teléfono') }}
								{{ Form::text('telefono','',['class' => 'form-control','v-model' => 'form.telefono']) }}
							</div>
							<div class="form-group">
								{{ Form::label('estado','Estado') }}
								<select :disabled="form.pais == ''" name="estado" id="estado" class="form-control">
									<option v-for="item in estados" :value="item.id" v-if="form.pais == item.pais_id">@{{ item.nombre }}</option>
								</select>
							</div>							
							<div class="form-group">
								{{ Form::label('password','Contraseña') }}
								{{ Form::password('password',['class' => 'form-control','v-model' => 'form.password']) }}
							</div>
							<div class="form-group">
								{{ Form::label('password_confirmation','Repetir Contraseña') }}
								{{ Form::password('password_confirmation',['class' => 'form-control','v-model' => 'form.password_confirmation']) }}
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
			el: '#register',
			data: {
				form: {
					nombre: '',
					password: '',
					password_confirmation: '',
					telefono: '',
					pais: '',
					email: '',
					direccion: '',
					codigo: '',
					type: '',
					identificacion: '',
					estado: '',
					empresa: ''
				},
				estados: {!! json_encode($estados) !!}
			},
			methods: {
				submit() {
					setLoader();
					axios.post("{{ URL('register') }}",this.form)
						.then(res => {
							if (res.data.result) {
								swal('','Se ha registrado correctamente','success');
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