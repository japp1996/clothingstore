@extends('layouts.master')

@section('title')
	@lang('Page.Carrito.Title')
@stop

@section('content')
	<div class="contenido" id="carrito" v-cloak>
		<h2 class="title title-line">
			@lang('Page.Carrito.Title')
		</h2>

		<div class="responsive-table">
			<table class="table">
				<thead>
					<tr>
						<th>@lang('Page.Carrito.Nombre')</th>
						<th v-if="currency == '1'">@lang('Page.Carrito.Precio')</th>
						<th v-if="currency == '2'">@lang('Page.Carrito.PrecioUSD')</th>
						<th>@lang('Page.Carrito.Cantidades')</th>
						<th v-if="currency == '1'">@lang('Page.Carrito.TotalVES')</th>
						<th v-if="currency == '2'">@lang('Page.Carrito.TotalUSD')</th>
						<th style="width: 50px"></th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="(item,index) in carrito">
						<td>
							<p style="line-height: 0.8;" class="bold">
								@if (\App::getLocale() == 'es')
									@{{ item.producto.name }}
								@else
									@{{ item.producto.name_english }}
								@endif
							</p>
							<p style="line-height: 0.8;">@lang('Page.Carrito.Talla'): @{{ item.producto.talla.name }}, @lang('Page.Carrito.Color'): @if (\App::getLocale() == 'es') @{{ item.producto.color.name }} @else @{{ item.producto.color.name_english }} @endif</p>
						</td>
						<td v-if="currency == '1'">
							@{{ getPrice(item.cantidad < 12 ? item.producto.price_1 : item.producto.price_2,item.producto.coin) | VES }}
							<p class="almayor" v-if="item.cantidad < 12">@lang('Page.Tienda.Detal')</p>
							<p class="almayor" v-if="item.cantidad >= 12">@lang('Page.Tienda.Mayor')</p>
						</td>
						<td v-if="currency == '2'">
							@{{ getPrice(item.cantidad < 12 ? item.producto.price_1 : item.producto.price_2,item.producto.coin) | USD }}
							<p class="almayor" v-if="item.cantidad < 12">@lang('Page.Tienda.Detal')</p>
							<p class="almayor" v-if="item.cantidad >= 12">@lang('Page.Tienda.Mayor')</p>
						</td>		
						<td>
							<div class="item-cantidad">
								<button class="btn btn-default remove" v-on:click="item.cantidad > 1 ? item.cantidad-- : null; update(item)">
									{{ HTML::Image('img/icons/cant.png') }}
								</button>
									<span>@{{ item.cantidad }}</span>
								<button class="btn btn-default add" v-on:click="item.producto.amount.amount > item.cantidad ? item.cantidad++ : null; item.producto.amount.amount >= item.cantidad ? update(item) : null">
									{{ HTML::Image('img/icons/add.png') }}
								</button>
							</div>
						</td>
						<td v-if="currency == '1'">@{{ (getPrice(item.cantidad < 12 ? item.producto.price_1 : item.producto.price_2,item.producto.coin) * item.cantidad) | VES }}</td>
						<td v-if="currency == '2'">@{{ (getPrice(item.cantidad < 12 ? item.producto.price_1 : item.producto.price_2,item.producto.coin) * item.cantidad) | USD }}</td>
						<td>
							<button class="btn btn-default" v-on:click="eliminar(item)">
								<i class="fa fa-close"></i>
							</button>
						</td>
					</tr>
					<tr v-if="carrito.length > 0">
						{{-- <td></td> --}}
						<td></td>
						<td></td>
						<td class="envio">
							@lang('Page.Carrito.Envio')
						</td>
						<td class="envio" v-if="currency == '1'">
							<i class="circle-gold"></i> ZOOM, TEALCA, SEREX
						</td>
						<td class="envio" v-if="currency == '2'">
							<i class="circle-gold"></i> DHL
						</td>
						<td></td>
					</tr>
					<tr v-if="carrito.length > 0">
						<td class="empty"></td>
						<td class="empty"></td>
						<td class="total">@lang('Page.Carrito.Total')</td>
						<td v-if="currency == '1'" class="total total-gold">@{{ getTotal() | VES }}</td>
						<td v-if="currency == '2'" class="total total-gold">@{{ getTotalUsd() | USD }}</td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>

		<div class="text-center footer-carrito">
			<h3 class="no-items" v-if="carrito.length <= 0">@lang('Page.Carrito.NoItems')</h3>
			<button class="btn btn-default btn-pagar" v-on:click="proceder()" v-if="carrito.length > 0">
				@lang('Page.Carrito.Pagar')
			</button>
			<a href="{{ URL('condiciones') }}" target="_blank">
				@lang('Page.Carrito.Condiciones')
			</a>
		</div>

		<div class="modal fade" id="modal-alerta">
		  <div class="modal-dialog modal-dialog-centered">
		    <div class="modal-content">
		      <div class="modal-body">
		        <div class="modal-container">
		        	<div v-if="tipo_alerta == 1">
		        		<p>@lang('Page.Carrito.Exito')</p>
		        		<div class="text-center">
		        			<a href="#" data-dismiss="modal">
		        				{{ HTML::Image('img/icons/check.png') }}
		        			</a>
		        		</div>
		        	</div>
		        	<div v-if="tipo_alerta == 2">
		        		<p>@lang('Page.Carrito.Piezas')</p>
		        		<div class="text-center">
		        			<button class="btn btn-default" data-dismiss="modal">
		        				@lang('Page.Carrito.Aceptar')
		        			</button>
		        		</div>
		        	</div>
		        	<div v-if="tipo_alerta == 3">
		        		<p>@lang('Page.PayPal.NoProcesar')</p>
		        		<div class="text-center">
		        			<a href="#" data-dismiss="modal">
		        				{{ HTML::Image('img/icons/check.png') }}
		        			</a>
		        		</div>
		        	</div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>	

		<div class="modal fade" id="modal-proceder">
		  <div class="modal-dialog modal-dialog-centered">
		    <div class="modal-content">
		      <div class="modal-body">
		        <div class="modal-container">
		        	<p>@lang('Page.Carrito.Proceder')</p>
		        	<div class="row">
		        		<div class="col-sm-6 text-left">
		        			<a href="{{ URL('login') }}">
		        				<button class="btn btn-default">
		        					@lang('Page.Carrito.Login')
		        				</button>
		        			</a>
		        		</div>
		        		<div class="col-sm-6 text-right">
		        			<a href="{{ URL('register') }}">
		        				<button class="btn btn-default">
		        					@lang('Page.Carrito.Register')
		        				</button>
		        			</a>
		        		</div>
		        	</div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>	

		<div class="modal fade" id="modal-pago">
		  <div class="modal-dialog modal-dialog-centered">
		    <div class="modal-content">
		      <div class="modal-body">
		        <div class="modal-container">
		        	<h3 class="title title-line">@lang('Page.Carrito.Metodos')</h3>
		        	<div class="row">
		        		<div class="col-md-6 text-center" v-if="currency == '1'">
		        			{{ HTML::Image('img/mercadopago.png','',['class' => 'img-pago']) }}
		        			<p>@lang('Page.Carrito.MercadoPago')</p>
		        			<a v-on:click.prevent="check('{{ URL('mercadopago') }}')" href="#">
		        				<button class="btn btn-default">
		        					@lang('Page.Carrito.Seleccionar')
		        				</button>
		        			</a>
		        		</div>
		        		<div class="col-md-6 text-center" v-if="currency == '1'">
		        			{{ HTML::Image('img/transferencias.png','',['class' => 'img-pago']) }}
		        			<p>@lang('Page.Carrito.Transferencias')</p>
		        			<a v-on:click.prevent="check('{{ URL('transferencia') }}')" href="#">
		        				<button class="btn btn-default">
		        					@lang('Page.Carrito.Seleccionar')
		        				</button>
		        			</a>
		        		</div>
		        		<div class="col-md-6 offset-md-3 text-center" v-if="currency == '2'">
		        			{{ HTML::Image('img/paypal.png','',['class' => 'img-pago']) }}
		        			<p>@lang('Page.Carrito.Paypal')</p>
		        			<a v-on:click.prevent="check('{{ URL('payment') }}')" href="#">
		        				<button class="btn btn-default">
		        					@lang('Page.Carrito.Seleccionar')
		        				</button>
		        			</a>
		        		</div>
		        	</div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>	
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		var vue;

		new Vue({
			el: '#carrito',
			data: {
				tipo_alerta: '1',
				carrito: [],
				currency: getCurrency('{{ $_ip }}'),
				exchange: '{{ $_change }}'
			},
			created() {
				vue = this;
				vue.load();
			},
			methods: {
				alerta(num) {
					vue.tipo_alerta = num;
					$('#modal-alerta').modal();
				},
				check(url) {
					setLoader();
					axios.post('{{ URL('carrito/check') }}')
						.then(function(res) {
							if (res.data.result) {
								window.location = url;
							}
							else {
								swal('',res.data.error,'warning');
							}
						})
						.catch(function(err) {
							swal('','Se ha producido un error','warning');
						})
						.then(function() {
							quitLoader();
						});
				},
				proceder() {
					if ("{{ Auth::check() }}" == true)
						vue.pago();
					else
						$('#modal-proceder').modal();
				},
				pago() {
					$('#modal-pago').modal();
				},
				getTotal() {
					var total = 0;
					vue.carrito.forEach(function(item) {
						total += item.cantidad * vue.getPrice(item.cantidad < 12 ? item.producto.price_1 : item.producto.price_2,item.producto.coin);
					});
					return total;
				},
				getTotalUsd() {
					var total = 0;
					vue.carrito.forEach(function(item) {
						total += item.cantidad * vue.getPrice(item.cantidad < 12 ? item.producto.price_1 : item.producto.price_2,item.producto.coin);
					});
					return total;
				},
				getPrice(precio,coin) {
					var price = precio;
					if (coin == '1' && vue.currency == '2') {
						price = price / vue.exchange;
					}
					else if (coin == '2' && vue.currency == '1') {
						price = price * vue.exchange;
					}
					return price;
				},
				load() {
					setLoader();
					axios.post('{{ URL('carrito/ajax') }}')
						.then(function(res) {
							if (res.data.result) {
								vue.carrito = res.data.carrito;
								vue_header.cart = vue.carrito.length;
								if ('{{ Session('success') }}' != '') {
									vue.alerta(1);
								}
								else if ('{{ Session('errors') }}' != '') {
									vue.alerta(3);
								}
							}
						})
						.catch(function(err) {
							swal('','{{ Lang::get('Page.Error') }}','warning');
							console.log(err);
						})
						.then(function() {
							quitLoader();
						});
				},
				update(producto) {
					var item = {
						id: producto.id,
						cantidad: producto.cantidad,
						color: producto.color,
						talla: producto.talla
					}
					axios.post('{{ URL('tienda/add') }}',item)
						.catch(function(err) {
							console.log(err);
						});
				},
				eliminar(item) {
					swal({
					  title: "",
					  type: 'warning',
					  text: '{{ Lang::get('Page.Carrito.Eliminar') }}',
					  showCancelButton: true,
					  confirmButtonText: "{{ Lang::get('Page.Carrito.Aceptar') }}",
					  cancelButtonText: "{{ Lang::get('Page.Carrito.Cancelar') }}"
					},
					function(confirm) {
					  if (confirm) {
					  		setLoader();
							axios.post('{{ URL('carrito/delete') }}',{item: item})
								.then(function(res) {
									if (res.data.result) {
										vue.load();
									}
								})
								.catch(function(err) {
									swal('','{{ Lang::get('Page.Error') }}','warning');
								})
								.then(function() {
									quitLoader();
								});
							  }
					});					
				}
			}
		});
	</script>
@stop