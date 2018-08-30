@extends('layouts.master')

@section('title')
	Iniciar Sesión
@stop

@section('content')
	<div class="contenido" id="login">
		<div class="row">
			<div class="col-md-6 text-center right-line-container">
				<h2 class="title">Iniciar Sesión</h2>
				<p>Inicia sesión para poder comprar directamente desde la página web. ¿No estas aun registrado?</p>
				<div class="text-center">
					<a href="{{ URL('register') }}">
						<button class="btn btn-default" type="submit">
							Regístrate
						</button>
					</a>
				</div>
				<a href="{{ URL('condiciones') }}" class="item-right">
					{{ HTML::Image('img/icons/right.png') }}
					Condiciones de Compra
				</a>
				<div class="right-line"></div>
			</div>
			<div class="col-md-6 text-center">
				{{ Form::open(['v-on:submit.prevent' => 'submit()']) }}
					<div class="form-group">
						{{ Form::label('email','Correo Electrónico') }}
						{{ Form::text('email','',['class' => 'form-control','v-model' => 'form.email']) }}
					</div>
					<div class="form-group">
						{{ Form::label('password','Contraseña') }}
						{{ Form::password('password',['class' => 'form-control','v-model' => 'form.password']) }}
					</div>
					<div class="text-center">
						<button class="btn btn-default" type="submit">
							Entrar
						</button>
					</div>
					<a href="{{ URL('recuperar') }}">
						¿Has olvidado tu contraseña?
					</a>
				{{ Form::close() }}
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#login',
			data: {
				form: {
					email: '',
					password: ''
				}
			},
			methods: {
				submit() {
					setLoader();
					axios.post("{{ URL('login') }}",this.form)
						.then(res => {
							if (res.data.result) {
								window.location = res.data.url;
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