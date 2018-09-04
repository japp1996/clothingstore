@extends('layouts.master')

@section('title')
	Carrito de Compras
@stop

@section('content')
	<div class="contenido" id="carrito">
		<h2 class="title title-line">
			Carrito de Compras
		</h2>

		<table class="table">
			<thead>
				<tr>
					<th>Nombre de Producto</th>
					<th>Precio (VES)</th>
					<th>Precio (USD)</th>
					<th>Cantidades</th>
					<th>Total (VES)</th>
					<th>Total (USD)</th>
				</tr>
			</thead>
			<tbody>
				@foreach($carrito as $item)
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
				@endforeach
			</tbody>
		</table>

		<div class="text-center footer-carrito">
			@if (count($carrito) <= 0)
				<h3 class="no-items">No has agregado productos al carrito de compras</h3>
			@endif
			<a href="{{ URL('condiciones') }}" v-on:click.prevent="pago()">
				Condiciones de Compra
			</a>
		</div>

		<div class="modal fade" id="modal-alerta">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-body">
		        <div class="modal-container">
		        	<div v-if="tipo_alerta == 1">
		        		<p>Su pago se ha registrado con exito</p>
		        		<div class="text-center">
		        			<a href="#" data-dismiss="modal">
		        				{{ HTML::Image('img/icons/check.png') }}
		        			</a>
		        		</div>
		        	</div>
		        	<div v-if="tipo_alerta == 2">
		        		<p>Al registrarse de modo <strong>persona jurídica el mínimo</strong> de piezas es <strong>12 (al mayor).</strong></p>
		        		<div class="text-center">
		        			<button class="btn btn-default" data-dismiss="modal">
		        				Aceptar
		        			</button>
		        		</div>
		        	</div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>	

		<div class="modal fade" id="modal-proceder">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-body">
		        <div class="modal-container">
		        	<p>Para proceder el pago debe iniciar sesión</p>
		        	<div class="row">
		        		<div class="col-sm-6 text-left">
		        			<a href="{{ URL('login') }}">
		        				<button class="btn btn-default">
		        					Iniciar Sesión
		        				</button>
		        			</a>
		        		</div>
		        		<div class="col-sm-6 text-right">
		        			<a href="{{ URL('register') }}">
		        				<button class="btn btn-default">
		        					Regístrate
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
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-body">
		        <div class="modal-container">
		        	<h3 class="title title-line">Métodos de Pago</h3>
		        	<div class="row">
		        		<div class="col-md-6 text-center">
		        			{{ HTML::Image('img/mercadopago.png') }}
		        			<p>Método de pago unicamente para las personas ubicadas en Venezuela</p>
		        			<button class="btn btn-default">
		        				Seleccionar
		        			</button>
		        		</div>
		        		<div class="col-md-6 text-center">
		        			{{ HTML::Image('img/paypal.png') }}
		        			<p>Método de pago unicamente para las personas ubicadas a nivel internacional</p>
		        			<button class="btn btn-default">
		        				Seleccionar
		        			</button>
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
		new Vue({
			el: '#carrito',
			data: {
				tipo_alerta: '1'
			},
			methods: {
				alerta(num) {
					this.tipo_alerta = num;
					$('#modal-alerta').modal();
				},
				proceder() {
					$('#modal-proceder').modal();
				},
				pago() {
					$('#modal-pago').modal();
				}
			}
		});
	</script>
@stop