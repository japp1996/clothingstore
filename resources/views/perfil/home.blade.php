@extends('layouts.master')

@section('title')
	@lang('Page.Perfil.Title')
@stop

@section('content')
	<div class="contenido contenido-no-padding" id="perfil" v-cloak>
		<div class="row">
			<div class="col-lg-3 separacion">
				<h2>@lang('Page.Perfil.Title')</h2>
				<ul>
					<li>
						<a href="#" :class="{ bold: seccion == 1 }" v-on:click.prevent="seccion = 1">@lang('Page.Perfil.Editar.Title')</a>
					</li>
					<li>
						<a href="#" :class="{ bold: seccion == 2 }" v-on:click.prevent="seccion = 2">@lang('Page.Perfil.CambiarPassword.Title')</a>
					</li>
					<li>
						<a href="#" :class="{ bold: seccion == 3 }" v-on:click.prevent="seccion = 3">@lang('Page.Perfil.Historial.Title')</a>
					</li>
					<li>
						<a href="{{ URL('logout') }}">@lang('Page.Perfil.Logout')</a>
					</li>
				</ul>
			</div>
			<div class="col-lg-9">
				{{ Form::open(['v-on:submit.prevent' => 'submit()', 'v-if' => 'seccion == 1','class' => 'seccion']) }}
					<h3>@lang('Page.Perfil.Editar.Title')</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('nombre',Lang::get('Page.Perfil.Editar.Nombre')) }}
								{{ Form::text('nombre','',['class' => 'form-control','v-model' => 'user.name']) }}
							</div>
							<div class="form-group">
								{{ Form::label('pais',Lang::get('Page.Perfil.Editar.Pais')) }}
								{{ Form::select('pais',$paises,null,['class' => 'form-control','v-model' => 'user.pais_id', 'v-on:change' => "user.estado_id = ''"]) }}
							</div>
							<div class="form-group">
								{{ Form::label('telefono',Lang::get('Page.Perfil.Editar.Telefono')) }}
								{{ Form::text('telefono','',['class' => 'form-control','v-model' => 'user.telefono']) }}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('email',Lang::get('Page.Perfil.Editar.Email')) }}
								{{ Form::text('email','',['class' => 'form-control','v-model' => 'user.email']) }}
							</div>
							<div class="form-group">
								{{ Form::label('estado',Lang::get('Page.Perfil.Editar.Estado')) }}
								<select :disabled="user.pais_id == ''" name="estado" id="estado" class="form-control" tabindex="8" v-model="user.estado_id">
									<option v-for="item in estados" :value="item.id" v-if="user.pais_id == item.pais_id">@{{ item.nombre }}</option>
								</select>
							</div>
							<div class="form-group">
								{{ Form::label('codigo',Lang::get('Page.Perfil.Editar.Codigo')) }}
								{{ Form::text('codigo','',['class' => 'form-control','v-model' => 'user.codigo']) }}
							</div>
						</div>
					</div>
					<div class="text-center">
						<button class="btn btn-default" type="submit">
							@lang('Page.Perfil.Editar.Guardar')
						</button>
					</div>
				{{ Form::close() }}

				{{ Form::open(['v-on:submit.prevent' => 'submitPassword()', 'v-if' => 'seccion == 2','class' => 'seccion']) }}
					<h3>@lang('Page.Perfil.CambiarPassword.Title')</h3>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								{{ Form::label('old_password',Lang::get('Page.Perfil.CambiarPassword.Actual')) }}
								{{ Form::password('old_password',['class' => 'form-control', 'v-model' => 'password.old_password']) }}
							</div>
							<div class="form-group">
								{{ Form::label('password',Lang::get('Page.Perfil.CambiarPassword.Nueva')) }}
								{{ Form::password('password',['class' => 'form-control', 'v-model' => 'password.password']) }}
							</div>
							<div class="form-group">
								{{ Form::label('password_confirmation',Lang::get('Page.Perfil.CambiarPassword.Confirmar')) }}
								{{ Form::password('password_confirmation',['class' => 'form-control', 'v-model' => 'password.password_confirmation']) }}
							</div>
						</div>
					</div>
					<div class="text-center">
						<button class="btn btn-default" type="submit">
							@lang('Page.Perfil.CambiarPassword.Cambiar')
						</button>
					</div>
				{{ Form::close() }}

				<div class="seccion" v-if="seccion == 3">
					<h3>@lang('Page.Perfil.Historial.Title')</h3>
					<div class="responsive-table" v-if="pedidos.length > 0">
						<table class="table text-center">
							<thead>
								<tr>
									<th>@lang('Page.Perfil.Historial.Fecha')</th>
									<th>@lang('Page.Perfil.Historial.Metodo')</th>
									<th>@lang('Page.Perfil.Historial.Productos')</th>
									<th>@lang('Page.Perfil.Historial.Cantidades')</th>
									<th>@lang('Page.Perfil.Historial.Precio')</th>
								</tr>
							</thead>
							<tbody>
								<template v-for="item in pedidos">
									<tr v-for="(i,index) in item.details" :class="{ borderGold: index == 0 }">
										<td>@{{ (index == 0 ? (item.created_at) : '') | date }}</td>
										<td>@{{ (index == 0 ? (item.payment_type) : '') | metodo }}</td>
										<td class="bold">
											@if (\App::getLocale() == 'es') @{{ i.product.name }} @else @{{ i.product.name_english }} @endif
										</td>
										<td>@{{ i.quantity }}</td>										
										<td>
											<span class="bold" v-if="currency == 1">@{{ getPrice(i.price,i.coin,item.exchange.change) * i.quantity | VES }}</span>
											<span class="bold" v-if="currency == 2">@{{ getPrice(i.price,i.coin,item.exchange.change) * i.quantity | USD }}</span>
										</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td class="borderWhite">@lang('Page.Perfil.Historial.Total')</td>
										<td class="borderWhite">
											<span class="bold-gold" v-if="currency == 1">@{{ getTotal(item) | VES }}</span>
											<span class="bold-gold" v-if="currency == 2">@{{ getTotal(item) | USD }}</span>
										</td>
									</tr>
								</template>
							</tbody>
						</table>
					</div>

					<div class="text-center" v-if="paginator.last_page > 1">
						<ul class="pagination justify-content-center">
				            <li class="page-item disabled" v-if="paginator.current_page == 1">
				                <span class="page-link">
				                    <i class="fa fa-angle-left"></i>
				                </span>
				            </li>
				            <li class="page-item" v-else>
				                <a class="page-link" href="#" rel="prev" v-on:click.prevent="load(paginator.current_page - 1)">
				                    <i class="fa fa-angle-left"></i>
				                </a>
				            </li>
					        <li class="page-item page-of disabled">
					            <span class="page-link">
					                @{{ paginator.current_page }} {{ Lang::get('Page.De') }} @{{ paginator.last_page }}
					            </span>
					        </li>
				            <li class="page-item" v-if="paginator.last_page > paginator.current_page">
				                <a class="page-link" href="#" rel="next" v-on:click.prevent="load(paginator.current_page + 1)">
				                    <i class="fa fa-angle-right"></i>
				                </a>
				            </li>
				            <li class="page-item disabled" v-else>
				                <span class="page-link">
				                    <i class="fa fa-angle-right"></i>
				                </span>
				            </li>
					    </ul>
					</div>

					<div class="text-center">
						<h4 class="no-items" v-if="pedidos.length <= 0">@lang('Page.Perfil.Historial.NoItems')</h4>
					</div>

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
				pedidos: [],
				currency: getCurrency('{{ $_ip }}'),
				password: {
					old_password: '',
					password: '',
					password_confirmation: ''
				},
				pedidos: [],
				paginator: {}
			},
			created() {
				this.load();
			},
			methods: {
				getTotal(pedido) {
					let total = 0;
					pedido.details.forEach(item => {
						total += item.quantity * this.getPrice(item.price,item.coin,pedido.exchange.change);
					});
					return total;
				},
				getPrice(precio,coin,exchange) {
					let price = precio;
					if (coin == '1' && this.currency == '2') {
						price = price / exchange;
					}
					else if (coin == '2' && this.currency == '1') {
						price = price * exchange;
					}
					return price;
				},
				load(page = 1) {
					axios.post('{{ URL('perfil/pedidos') }}?page=' + page)
						.then(res => {
							if (res.data.result) {
								this.pedidos = res.data.pedidos.data;
								this.paginator = res.data.pedidos;
							}
						})
						.catch(err => {
							swal('','{{ Lang::get('Page.Error') }}','warning');
							console.log(err);
						});
				},
				submit() {
					setLoader();
					axios.post('{{ URL('perfil') }}',this.user)
						.then(res => {
							if (res.data.result) {
								swal('',"{{ Lang::get('Page.Perfil.Success') }}",'success');
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
				submitPassword() {
					setLoader();
					axios.post('{{ URL('password') }}',this.password)
						.then(res => {
							if (res.data.result) {
								swal('',"{{ Lang::get('Page.Perfil.SuccessPassword') }}",'success');
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
							swal('','{{ Lang::get('Page.Error') }}','warning');
						})
						.then(() => {
							quitLoader();
						});
				}
			}
		});
	</script>
@stop