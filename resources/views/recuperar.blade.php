@extends('layouts.master')

@section('title')
	@lang('Page.ResetPassword.Title')
@stop

@section('content')
	<div class="contenido" id="recuperar" v-cloak>
		<h2 class="title">@lang('Page.ResetPassword.Title')</h2>
		<div v-if="seccion == 1">
			{{ Form::open(['v-on:submit.prevent' => 'send()']) }}
				<p>@lang('Page.ResetPassword.Enviara')</p>
				<div class="form-group">
					{{ Form::label('email',Lang::get('Page.ResetPassword.Email')) }}
					{{ Form::text('email','',['class' => 'form-control','v-model' => 'form.email']) }}
				</div>
				<div class="text-center">
					<button class="btn btn-default" type="submit">
						@lang('Page.ResetPassword.Continuar')
					</button>
				</div>
			{{ Form::close() }}
		</div>
		<div v-if="seccion == 2">
			{{ Form::open(['v-on:submit.prevent' => 'codigo()']) }}
				<p>@lang('Page.ResetPassword.Escriba')</p>
				<div class="form-group">
					{{ Form::text('codigo','',['class' => 'form-control','v-model' => 'form.codigo']) }}
				</div>
				<div class="row text-center">
					<div class="col-md-6">
						<div class="text-center">
							<button class="btn btn-default" type="button" v-on:click="reenviar()">
								@lang('Page.ResetPassword.Reenviar')
							</button>
						</div>
					</div>
					<div class="col-md-6">
						<div class="text-center">
							<button class="btn btn-default" type="submit">
								@lang('Page.ResetPassword.Continuar')
							</button>
						</div>
					</div>
				</div>
			{{ Form::close() }}
		</div>
		<div v-if="seccion == 3">
			{{ Form::open(['v-on:submit.prevent' => 'recuperar()']) }}
				<div class="form-group">
					{{ Form::label('password',Lang::get('Page.ResetPassword.Password')) }}
					{{ Form::password('password',['class' => 'form-control','v-model' => 'form.password']) }}
				</div>
				<div class="form-group">
					{{ Form::label('password_confirmation',Lang::get('Page.ResetPassword.Repetir')) }}
					{{ Form::password('password_confirmation',['class' => 'form-control','v-model' => 'form.password_confirmation']) }}
				</div>
				<div class="text-center">
					<button class="btn btn-default" type="submit">
						@lang('Page.ResetPassword.Guardar')
					</button>
				</div>
			{{ Form::close() }}
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#recuperar',
			data: {
				seccion: 1,
				form: {
					email: null,
					codigo: null,
					password: null,
					password_confirmation: null
				}
			},
			methods: {
				send() {
					setLoader();
					let data = {
						email: this.form.email
					}
					axios.post('{{ URL('recuperar/send') }}',data)
						.then(res => {
							if (res.data.result) {
								swal('','{{ Lang::get('Page.ResetPassword.Success') }}','success');
								this.seccion = 2;
							}
							else {
								swal('',res.data.error,'warning');
							}
						})
						.catch(err => {
						   swal('','{{ Lang::get('Page.Error') }}','warning');
						})
						.then(() => {
							quitLoader();
						});
				},
				codigo() {
					setLoader();
					let data = {
						codigo: this.form.codigo
					}
					axios.post('{{ URL('recuperar/codigo') }}',data)
						.then(res => {
							if (res.data.result) {
								this.seccion = 3;
							}
							else {
								swal('',res.data.error,'warning');
							}
						})
						.catch(err => {
						   swal('','{{ Lang::get('Page.Error') }}','warning');
						})
						.then(() => {
							quitLoader();
						});
				},
				recuperar() {
					setLoader();
					let data = {
						password: this.form.password,
						password_confirmation: this.form.password_confirmation,
						email: this.form.email,
						codigo: this.form.codigo
					}
					axios.post('{{ URL('recuperar/recuperar') }}',data)
						.then(res => {
							if (res.data.result) {
								swal('','{{ Lang::get('Page.ResetPassword.SuccessPassword') }}','success');
								setTimeout(() => {
									window.location = res.data.url;
								},1500);
							}
							else {
								swal('',res.data.error,'warning');
							}
						})
						.catch(err => {
						   swal('','{{ Lang::get('Page.Error') }}','warning');
						})
						.then(() => {
							quitLoader();
						});
				},
				reenviar() {
					setLoader();
					let data = {
						email: this.form.email
					}
					axios.post('{{ URL('recuperar/reenviar') }}',data)
						.then(res => {
							if (res.data.result) {
								swal('','{{ Lang::get('Page.ResetPassword.SuccessReenvio') }}','success');
							}
							else {
								swal('',res.data.error,'warning');
							}
						})
						.catch(err => {
						   swal('','{{ Lang::get('Page.Error') }}','warning');
						})
						.then(() => {
							quitLoader();
						});
				}
			}
		})
	</script>	
@stop