@extends('layouts.master')

@section('title')
	@lang('Page.Tienda.Title')
@stop

@section('content')
	<div class="contenido" id="tienda" v-cloak>
		<div class="row row-title">
			<div class="col-md-6">
				<h3>
					<a href="#" v-on:click.prevent="filtro()">
						{{ HTML::Image('img/icons/filtro.png') }}
					</a>
					@lang('Page.Tienda.Catalogo')
				</h3>
			</div>
{{-- 			<div class="col-md-6 text-right">
				{{ Form::select('moneda',[
					'1' => Lang::get('Page.Tienda.Bolivar'),
					'2' => Lang::get('Page.Tienda.Dolar')
				],'1',['class' => 'form-control','v-model' => 'currency']) }}
			</div> --}}
		</div>

		{{-- <p class="etiqueta" v-if="catalogo_selected == 1"><i class="fa fa-close" v-on:click="catalogo = 0; load()"></i>@lang('Page.Catalogo.Dama')</p>
		<p class="etiqueta" v-if="catalogo_selected == 2"><i class="fa fa-close" v-on:click="catalogo = 0; load()"></i>@lang('Page.Catalogo.Caballero')</p>
		<p class="etiqueta" v-if="catalogo_selected == 3"><i class="fa fa-close" v-on:click="catalogo = 0; load()"></i>@lang('Page.Catalogo.Nino')</p> --}}

		<p v-for="i in filtros" class="etiqueta" v-if="catalogo_selected == i.id"><i class="fa fa-close" v-on:click="catalogo = 0; load()"></i>
			@if (\App::getLocale() == 'es') @{{ i.name }} @else @{{ i.name_english }} @endif
		</p>

		<div class="row row-productos">
			<div class="col-lg-3 col-md-4 col-6" v-for="item in productos">
				<div class="container-item">
					<a :href="'{{ URL('tienda/ver') }}' + '/' + item.id">
						<img :src="'{{ URL('img/products') }}' + '/' + item.images[0].file" />
					</a>
					<div class="container-text">
						<a :href="'{{ URL('tienda/ver') }}' + '/' + item.id">
							<h4>@if (\App::getLocale() == 'es') @{{ item.name }} @else @{{ item.name_english }} @endif</h4>
						</a>
						<p v-if="currency == 1">@{{ getPrice(item.price_1,item.coin) | VES }}</p>
						<p v-if="currency == 2">@{{ getPrice(item.price_1,item.coin) | USD }}</p>
					</div>
					<button class="btn btn-default" v-on:click="ver(item)" :disabled="inCarrito(item.id)">
						<template v-if="!inCarrito(item.id)">{{ HTML::Image('img/icons/cart_gold.png') }}</template>
						<template v-if="inCarrito(item.id)">{{ HTML::Image('img/check.png') }}</template>
					</button>
				</div>
			</div>
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

		<div class="modal fade" id="modal-producto">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-body">
		        <div class="row" v-if="producto != null">
		        	<div class="col-md-4 image-modal" :style="{ backgroundImage: 'url({{ URL('img/products') }}' + '/' + producto.images[producto.file_selected].file + ')' }">
		        		<i class="fa fa-chevron-left" v-on:click="producto.file_selected == 0 ? (producto.file_selected = producto.images.length - 1) : producto.file_selected--"></i>
		        			<img class="img-principal" :src="'{{ URL('img/products') }}' + '/' + producto.images[0].file" />
		        		<i class="fa fa-chevron-right" v-on:click="producto.file_selected == producto.images.length -1 ? producto.file_selected = 0 : producto.file_selected++"></i>
		        	</div>
		        	<div class="col-md-8">
		        		<div class="container-texto">
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
		        			</div>
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
		        				<p class="descripcion ellipsis">
		        					@if (\App::getLocale() == 'es') @{{ producto.description }} @else @{{ producto.description_english }} @endif
		        				</p>
		        				<a :href="'{{ URL('tienda/ver') }}' + '/' + producto.id">@lang('Page.Tienda.VerMas')</a>
		        			</div>
		        		</div>
		        	</div>
		        </div>
		      </div>
		    </div>
		  </div>
		</div>
	
		<div class="filtro" v-on:click="close()"></div>
		<div class="filtro-container">
			<h2>
				@lang('Page.Tienda.Filtros')
				<div class="close" v-on:click="close()">
					{{ HTML::Image('img/icons/cancelar.png') }}
				</div>
			</h2>
			<h3>
				{{ HTML::Image('img/icons/filtro.png') }}
				@lang('Page.Tienda.Catalogo')
			</h3>
			<ul>
				<li>
					{{-- @lang('Page.Tienda.Detal') --}}
					<ul>
						<li v-on:click="catalogo = 0">
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" v-model="catalogo" value="0" name="detal"><span>@lang('Page.Tienda.Todos')</span>
							  </label>
							</div>
						</li>
						<li v-for="item in filtros" v-on:click="catalogo = item.id" class="item-desplegable">
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" v-model="catalogo" :value="item.id" name="detal"><span>
							    	@if (\App::getLocale() == 'es') @{{ item.name }} @else @{{ item.name_english }} @endif
							    </span>
							  </label>
							</div>
							<ul v-if="catalogo == item.id">
								<li v-for="i in item.categories">
									<div class="form-check">
									  <label class="form-check-label">
									    <input type="checkbox" :value="i.id" v-model="categorias_selected" class="form-check-input"><span>@if (\App::getLocale() == 'es') @{{ i.name }} @else @{{ i.name_english }} @endif</span>
									  </label>
									</div>
								</li>
							</ul>
						</li>
						{{-- <li v-on:click="catalogo = 1" class="item-desplegable">
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" v-model="catalogo" value="1" name="detal"><span>@lang('Page.Tienda.Dama')</span>
							  </label>
							</div>
							<ul v-if="catalogo == 1">
								<li v-for="i in categorias" v-if="i.catalogue == 1">
									<div class="form-check">
									  <label class="form-check-label">
									    <input type="checkbox" :value="i.id" v-model="categorias_selected" class="form-check-input"><span>@if (\App::getLocale() == 'es') @{{ i.name }} @else @{{ i.name_english }} @endif</span>
									  </label>
									</div>
								</li>
							</ul>
						</li>
						<li v-on:click="catalogo = 2" class="item-desplegable">
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" v-model="catalogo" value="2" name="detal"><span>@lang('Page.Tienda.Caballero')</span>
							  </label>
							</div>
							<ul v-if="catalogo == 2">
								<li v-for="i in categorias" v-if="i.catalogue == 2">
									<div class="form-check">
									  <label class="form-check-label">
									    <input type="checkbox" :value="i.id" v-model="categorias_selected" class="form-check-input"><span>@if (\App::getLocale() == 'es') @{{ i.name }} @else @{{ i.name_english }} @endif</span>
									  </label>
									</div>
								</li>
							</ul>
						</li>
						<li v-on:click="catalogo = 3" class="item-desplegable">
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" v-model="catalogo" value="3" name="detal"><span>@lang('Page.Tienda.Ninos')</span>
							  </label>
							</div>
							<ul v-if="catalogo == 3">
								<li v-for="i in categorias" v-if="i.catalogue == 3">
									<div class="form-check">
									  <label class="form-check-label">
									    <input type="checkbox" :value="i.id" v-model="categorias_selected" class="form-check-input"><span>@if (\App::getLocale() == 'es') @{{ i.name }} @else @{{ i.name_english }} @endif</span>
									  </label>
									</div>
								</li>
							</ul>
						</li> --}}
					</ul>
				</li>
{{-- 				<li>
					@lang('Page.Tienda.Mayor')
					<ul>
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">@lang('Page.Tienda.Todos')
							  </label>
							</div></li>
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">@lang('Page.Tienda.Dama')
							  </label>
							</div>
						</li>
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">@lang('Page.Tienda.Caballero')
							  </label>
							</div>
						</li>
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">@lang('Page.Tienda.Ninos')
							  </label>
							</div>
						</li>
					</ul>
				</li> --}}
			</ul>
			<div class="text-center">
				<button class="btn btn-default" v-on:click="close(); load()">
					Filtrar
				</button>
			</div>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#tienda',
			data: {
				currency: getCurrency('{{ $_ip }}'),
				productos: [],
				producto: null,
				carrito: [],
				paginator: {},
				exchange: '{{ $_change }}',
				catalogo: 0,
				catalogo_selected: 0,
				categorias: [],
				categorias_selected: [],
				filtros: [],
				page: 1,
				form: {
					talla: '',
					color: '',
					cantidad: 1
				}
			},
			created() {
				this.load();
			},
			// watch: {
			// 	catalogo(item) {
			// 		this.categorias_selected = [];
			// 	}
			// },
			methods: {
				filtro() {
					$('.filtro').fadeIn();
					$('.filtro-container').animate({
						left: '0px'
					},250);
				},
				close() {
					$('.filtro').fadeOut();
					$('.filtro-container').animate({
						left: '-500px'
					},250);
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
				load(page = null) {
					if (page != null)
						this.page = page;
					setLoader();
					axios.post('{{ URL('tienda/ajax') }}?page=' + this.page,{
						categorias: this.categorias_selected,
						catalogo: this.catalogo == 0 ? null : this.catalogo
					})
						.then(res => {
							if (res.data.result) {
								res.data.productos.data.forEach(item => {
									item.file_selected = 0;
								});
								this.filtros = res.data.filtros;
								this.paginator = res.data.productos;
								this.productos = res.data.productos.data;
								this.carrito = res.data.carrito;
								this.categorias = res.data.categorias;
								vue_header.cart = this.carrito.length;
								this.catalogo_selected = this.catalogo;
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
				ver(item) {
					this.producto = item;
					this.form = {
						talla: '',
						color: '',
						cantidad: 1
					}
					$('#modal-producto').modal();
				},
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
								this.load();
								swal('','{{ Lang::get('Page.Tienda.Agregado') }}','success');
								// this.carrito = res.data.carrito;
								// vue_header.cart = this.carrito.length;
								$('#modal-producto').modal('hide');
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
				inCarrito(id) {
					let carrito = this.carrito.map(item => { return item.id });
					return carrito.indexOf(id) != -1;
				},
			}
		})
	</script>
@stop