@extends('layouts.master')

@section('title')
	Tienda
@stop

@section('content')
	<div class="contenido" id="tienda">
		<div class="row row-title">
			<div class="col-md-6">
				<h3>
					<a href="#" v-on:click.prevent="filtro()">
						{{ HTML::Image('img/icons/filtro.png') }}
					</a>
					Catálogo
				</h3>
			</div>
			<div class="col-md-6 text-right">
				{{ Form::select('moneda',[
					'1' => 'Bolívar Venezolano (VES)',
					'2' => 'Dolar Estadounidense (USD)'
				],'1',['class' => 'form-control','v-model' => 'currency']) }}
			</div>
		</div>
	
		<div class="filtro" v-on:click.stop="close()"></div>
		<div class="filtro-container">
			<h2>
				Filtros
				<div class="close" v-on:click="close()">
					{{ HTML::Image('img/icons/cancelar.png') }}
				</div>
			</h2>
			<h3>
				{{ HTML::Image('img/icons/filtro.png') }}
				Catálogo
			</h3>
			<ul>
				<li>
					Catálogo al Detal
					<ul style="">
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">Ver Todos
							  </label>
							</div></li>
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">Dama
							  </label>
							</div>
						</li>
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">Caballero
							  </label>
							</div>
						</li>
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">Niños
							  </label>
							</div>
						</li>
					</ul>
				</li>
				<li>
					Catálogo al Mayor
					<ul style="">
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">Ver Todos
							  </label>
							</div></li>
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">Dama
							  </label>
							</div>
						</li>
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">Caballero
							  </label>
							</div>
						</li>
						<li>
							<div class="form-check">
							  <label class="form-check-label">
							    <input type="radio" class="form-check-input" name="detal">Niños
							  </label>
							</div>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
@stop

@section('scripts')
	<script type="text/javascript">
		new Vue({
			el: '#tienda',
			data: {
				currency: '1',
				productos: []
			},
			created() {
				this.load();
			},
			methods: {
				filtro() {
					$('.filtro').fadeIn();
					$('.filtro-container').animate({
						left: '0px'
					},250);
				},
				close(event) {
					$('.filtro').fadeOut();
					$('.filtro-container').animate({
						left: '-500px'
					},250);
					event.stopPropagation();
				},
				load() {
					setLoader();
					let data = {

					}	
					axios.post('{{ URL('tienda/ajax') }}',data)
						.then(res => {
							if (res.data.result) {

							}
						})
						.catch(err => {
							swal('','Se ha producido un error','warning');
							console.log(err);
						})
						.then(() => {
							quitLoader();
						});
				}
			}
		})
	</script>
@stop