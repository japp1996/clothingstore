@extends('layouts.master')

@section('title')
	@lang('Page.Tienda.VerProducto')
@stop

@section('content')
	<div class="contenido" id="ver-producto" v-cloak>
		<div class="row row-title">
			<div class="col-md-6">
				<a href="{{ URL('tienda') }}">
					<h3>
						{{ HTML::Image('img/icons/left.png') }}
						@lang('Page.Tienda.Catalogo')
					</h3>
				</a>
			</div>
{{-- 			<div class="col-md-6 text-right">
				{{ Form::select('moneda',[
					'1' => Lang::get('Page.Tienda.Bolivar'),
					'2' => Lang::get('Page.Tienda.Dolar')
				],'1',['class' => 'form-control','v-model' => 'currency']) }}
			</div> --}}
		</div>

		<div class="row producto-container" v-if="producto != null">
        	<div class="col-md-4 image-modal" :style="{ backgroundImage: 'url({{ URL('img/products') }}' + '/' + producto.images[producto.file_selected].file + ')' }">
        		<i class="fa fa-chevron-left" v-on:click="producto.file_selected == 0 ? (producto.file_selected = producto.images.length - 1) : producto.file_selected--"></i>
        			<img class="img-principal" :src="'{{ URL('img/products') }}' + '/' + producto.images[0].file" />
        		<i class="fa fa-chevron-right" v-on:click="producto.file_selected == producto.images.length -1 ? producto.file_selected = 0 : producto.file_selected++"></i>
{{--         		<div class="owl-carousel owl-theme">
				    <div class="item" v-for="i in producto.images" :style="{ backgroundImage: 'url({{ URL('img/products') }}' + '/' + i.file + ')' }"></div>
				</div> --}}
        	</div>
        	<div class="col-md-8">
        		<div class="container-texto">
        			<div class="container-description">
        				<h4>@if (\App::getLocale() == 'es') @{{ producto.name }} @else @{{ producto.name_english }} @endif</h4>
        				<template v-if="form.cantidad < 12">
        					<p class="precio" v-if="currency == 1">@{{ getPrice(producto.price_1,producto.coin) | VES }}</p>
        					<p class="precio" v-if="currency == 2">@{{ getPrice(producto.price_1,producto.coin) | USD }}</p>
        				</template>
        				<template v-if="form.cantidad >= 12">
        					<p class="precio" v-if="currency == 1">@{{ getPrice(producto.price_2,producto.coin) | VES }}</p>
        					<p class="precio" v-if="currency == 2">@{{ getPrice(producto.price_2,producto.coin) | USD }}</p>
        				</template>
        				<p class="almayor" v-if="form.cantidad >= 12">@lang('Page.Tienda.Mayor')</p>
		        		<p class="almayor" v-if="form.cantidad < 12">@lang('Page.Tienda.Detal')</p>
        				<h5>@lang('Page.Tienda.Descripcion')</h5>
        				<p class="strong"><strong>@lang('Page.Tienda.Coleccion'):</strong> @if (\App::getLocale() == 'es') @{{ producto.collections.name }} @else @{{ producto.collections.name_english }} @endif</p>
        				<p class="strong"><strong>@lang('Page.Tienda.Diseno'):</strong> @if (\App::getLocale() == 'es') @{{ producto.designs.name }} @else @{{ producto.designs.name_english }} @endif</p>
        				<p class="strong"><strong>@lang('Page.Tienda.Colores'):</strong> @{{ getColors(producto.colors) }}</p>
        				<p class="strong"><strong>@lang('Page.Tienda.Tallas'):</strong> @{{ getTallas(producto.categories.sizes) }}</p>
        				<p class="nl2br">
        					@if (\App::getLocale() == 'es') @{{ producto.description }} @else @{{ producto.description_english }} @endif
        				</p>
        			</div>
        			<div class="container-add">
        				<div class="row">
        					<div class="col-md-6">
        						<div class="form-group">
		        					{{ Form::label('tallas',Lang::get('Page.Tienda.TallasDisponibles')) }}
		        					<select name="tallas" id="tallas" class="form-control" v-model="form.talla">
		        						<option disabled selected value="">@lang('Page.Tienda.SeleccioneTalla')</option>
		        						<option v-for="item in producto.categories.sizes" :value="item.id">@{{ item.name }}</option>
		        					</select>
		        				</div>
        					</div>
        					<div class="col-md-6">
        						<div class="form-group">
		        					{{ Form::label('colores',Lang::get('Page.Tienda.ColoresDisponibles')) }}
		        					<select name="colores" id="colores" class="form-control" v-model="form.color">
		        						<option disabled selected value="">@lang('Page.Tienda.SeleccioneColor')</option>
		        						<option v-for="item in producto.colors" :value="item.id">@if (\App::getLocale() == 'es') @{{ item.name }} @else @{{ item.name_english }} @endif</option>
		        					</select>
		        				</div>
        					</div>
        				</div>    				
        				<div class="item-cantidad">
							<button class="btn btn-default remove" v-on:click="form.cantidad > 1 ? form.cantidad-- : null">
								{{ HTML::Image('img/icons/cant.png') }}
							</button>
								<span>@{{ form.cantidad }}</span>
							<button class="btn btn-default add" v-on:click="form.cantidad++">
								{{ HTML::Image('img/icons/add.png') }}
							</button>
						</div>
						<button class="btn btn-default btn-add" v-on:click="add()">
							{{ HTML::Image('img/icons/cart_black.png') }}
						</button>
						<span class="agregado" v-if="inCarrito()">@lang('Page.Tienda.AgregadoCarrito') {{ HTML::Image('img/check.png') }}</span>
						<a href="{{ URL('condiciones') }}" target="_blank">
							@lang('Page.Tienda.Condiciones')
						</a>
        			</div>
        		</div>
        	</div>
        </div>
	</div>
@stop

@section('scripts')
	{{ HTML::Script('bower_components/owl-carousel/dist/owl.carousel.min.js') }}
	<script type="text/javascript">
		new Vue({
			el: '#ver-producto',
			data: {
				currency: getCurrency('{{ $_ip }}'),
				producto: null,
				carrito: [],
				exchange: '{{ $_change }}',
				form: {
					talla: '',
					color: '',
					cantidad: 1
				}
			},
			created() {
				this.load();
			},
			methods: {
				load() {
					setLoader();
					axios.post('{{ URL('tienda/get') }}',{id: '{{ $id }}'})
						.then(res => {
							if (res.data.result) {
								res.data.producto.file_selected = 0;
								this.producto = res.data.producto;
								this.carrito = res.data.carrito;
								this.updateCarrito();
								// this.carousel();
							}
						})
						.catch(err => {
							swal('','{{ Lang::get('Page.Error') }}','warning');
							console.log(err)
						})
						.then(() => {
							quitLoader();
						});
				},
				// carousel() {
				// 	setTimeout(() => {
				// 		$('.owl-carousel').owlCarousel({
				// 	        loop: true,
				// 	        margin: 20,
				// 	        nav: false,
				// 	        autoplay: true,
				// 	        autoplayTimeout: 2000,
				// 	        autoplayHoverPause: true,
				// 	        dots: false
				// 	    });
				// 	},100);					
				// },
				getTallas(tallas) {
					let respuesta = "";
					tallas.forEach((item,index) => {
						respuesta += item.name + (index + 1 == tallas.length ? '' : ', ');
					});
					return respuesta;
				},
				getColors(colores) {
					let respuesta = "";
					colores.forEach((item,index) => {
						respuesta += @if (\App::getLocale() == 'es') item.name @else item.name_english @endif + (index + 1 == colores.length ? '' : ', ');
					});
					return respuesta;
				},
				getPrice(precio,coin) {
					let price = precio;
					if (coin == '1' && this.currency == '2') {
						price = price / this.exchange;
					}
					else if (coin == '2' && this.currency == '1') {
						price = price * this.exchange;
					}
					return price;
				},
				add() {
					setLoader();
					let item = {
						id: this.producto.id,
						cantidad: this.form.cantidad,
						color: this.form.color,
						talla: this.form.talla
					}
					axios.post('{{ URL('tienda/add') }}',item)
						.then(res => {
							if (res.data.result) {
								swal('','{{ Lang::get('Page.Tienda.Agregado') }}','success');
								this.carrito = res.data.carrito;
								vue_header.cart = this.carrito.length;
							}
							else {
								swal('',res.data.error,'warning');
							}
						})
						.catch(err => {
							swal('','{{ Lang::get('Page.Error') }}','warning');
							console.log(err);
						})
						.then(() => {
							quitLoader();
						});
				},
				getCarrito() {
					let carrito = this.carrito.map(item => { return item.id });
					return this.carrito[carrito.indexOf(this.producto.id)];
				},
				updateCarrito() {
					if (this.getCarrito() != null) {
						this.form.talla = this.getCarrito().talla;
						this.form.color = this.getCarrito().color;
						this.form.cantidad = this.getCarrito().cantidad;
					}
				},
				inCarrito() {
					let carrito = this.carrito.map(item => { return item.id });
					return carrito.indexOf(this.producto.id) != -1;
				}
			}
		})
	</script>
@stop

{{-- @section('styles')
	{{ HTML::Style("bower_components/owl-carousel/dist/assets/owl.carousel.min.css") }}
@stop --}}