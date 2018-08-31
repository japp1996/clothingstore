@extends('layouts.master')

@section('title')
	Perfil
@stop

@section('content')
	<div class="contenido contenido-no-padding" id="perfil">
		<div class="row">
			<div class="col-lg-3 separacion">
				<h2>Perfil</h2>
				<ul>
					<li>
						<a href="#" :class="{ bold: seccion == 1 }" v-on:click.prevent="seccion = 1">Editar Datos</a>
					</li>
					<li>
						<a href="#" :class="{ bold: seccion == 2 }" v-on:click.prevent="seccion = 2">Cambiar Contraseña</a>
					</li>
					<li>
						<a href="#" :class="{ bold: seccion == 3 }" v-on:click.prevent="seccion = 3">Historial de Pedidos</a>
					</li>
					<li>
						<a href="{{ URL('logout') }}">Cerrar Sesión</a>
					</li>
				</ul>
			</div>
			<div class="col-lg-9">
				{{ Form::open(['v-on:submit.prevent' => 'submit()', 'v-if' => 'seccion == 1','class' => 'seccion']) }}
					<h3>Editar Datos</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('nombre','Nombre Completo') }}
								{{ Form::text('nombre','',['class' => 'form-control','v-model' => 'user.name']) }}
							</div>
							<div class="form-group">
								{{ Form::label('pais','País') }}
								{{ Form::select('pais',$paises,null,['class' => 'form-control','v-model' => 'user.pais_id', 'v-on:change' => "user.estado_id = ''"]) }}
							</div>
							<div class="form-group">
								{{ Form::label('telefono','Teléfono') }}
								{{ Form::text('telefono','',['class' => 'form-control','v-model' => 'user.telefono']) }}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('email','Correo Electrónico') }}
								{{ Form::text('email','',['class' => 'form-control','v-model' => 'user.email']) }}
							</div>
							<div class="form-group">
								{{ Form::label('estado','Estado') }}
								<select :disabled="user.pais_id == ''" name="estado" id="estado" class="form-control" tabindex="8" v-model="user.estado_id">
									<option v-for="item in estados" :value="item.id" v-if="user.pais_id == item.pais_id">@{{ item.nombre }}</option>
								</select>
							</div>
							<div class="form-group">
								{{ Form::label('codigo','Código Postal') }}
								{{ Form::text('codigo','',['class' => 'form-control','v-model' => 'user.codigo']) }}
							</div>
						</div>
					</div>
					<div class="text-center">
						<button class="btn btn-default" type="submit">
							Guardar
						</button>
					</div>
				{{ Form::close() }}

				{{ Form::open(['v-on:submit.prevent' => 'submitPassword()', 'v-if' => 'seccion == 2','class' => 'seccion']) }}
					<h3>Cambiar Contraseña</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('old_password','Contraseña Actual') }}
								{{ Form::password('old_password',['class' => 'form-control', 'v-model' => 'password.old_password']) }}
							</div>
							<div class="form-group">
								{{ Form::label('password','Nueva Contraseña') }}
								{{ Form::password('password',['class' => 'form-control', 'v-model' => 'password.password']) }}
							</div>
							<div class="form-group">
								{{ Form::label('password_confirmation','Repetir Contraseña') }}
								{{ Form::password('password_confirmation',['class' => 'form-control', 'v-model' => 'password.password_confirmation']) }}
							</div>
						</div>
					</div>
					<div class="text-center">
						<button class="btn btn-default" type="submit">
							Cambiar
						</button>
					</div>
				{{ Form::close() }}

				<div class="seccion" v-if="seccion == 3">
					<h3>Historial de Pedidos</h3>
				</div>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#perfil',
			data: {
				seccion: 1,
				user: {!! json_encode($user) !!},
				estados: {!! json_encode($estados) !!},
				password: {
					old_password: '',
					password: '',
					password_confirmation: ''
				}
			},
			methods: {
				submit() {
					setLoader();
					axios.post('{{ URL('perfil') }}',this.user)
						.then(res => {
							if (res.data.result) {
								swal('',"Se han guardado los datos correctamente",'success');
							}
							else {
								swal('',res.data.error,'warning');
							}
						})
						.catch(err => {
							swal('','Se ha producido un error','warning');
						})
						.then(() => {
							quitLoader();
						});
				},
				submitPassword() {
					setLoader();
					axios.post('{{ URL('password') }}',this.password)
						.then(res => {
							if (res.data.result) {
								swal('',"Se ha cambiado la contraseña correctamente",'success');
								this.password = {
									old_password: '',
									password: '',
									password_confirmation: ''
								}
							}
							else {
								swal('',res.data.error,'warning');
							}
						})
						.catch(err => {
							swal('','Se ha producido un error','warning');
						})
						.then(() => {
							quitLoader();
						});
				}
			}
		});
	</script>
@stop