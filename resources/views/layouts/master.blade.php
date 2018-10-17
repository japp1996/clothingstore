<!DOCTYPE html>
<html lang="es">
<head>
	<title>Wará | @yield('title')</title>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico?1.1') }}" />
	{{ HTML::Style('bower_components/bootstrap/dist/css/bootstrap.min.css') }}
	{{ HTML::Style('bower_components/font-awesome/css/font-awesome.min.css') }}
	{{ HTML::Style('bower_components/sweetalert/dist/sweetalert.css') }}
	{{ HTML::Style('bower_components/hold-on/src/css/HoldOn.min.css') }}
	{{ HTML::Style('css/main.css?1.0') }}
	@yield('styles')
</head>
<body style="overflow-x: hidden !important;">
	
	@if (!isset($_no_header))
		@include('layouts.header')
	@endif
		
	<main>@yield('content')</main>
	
	@if (!isset($_no_header))
		@include('layouts.footer')
	@endif
	
	{{ HTML::Script('bower_components/jquery/dist/jquery.min.js') }}
	{{ HTML::Script('bower_components/bootstrap/dist/js/bootstrap.min.js') }}
	{{ HTML::Script('bower_components/moment/min/moment.min.js') }}
	{{ HTML::Script('bower_components/vue/dist/vue.min.js') }}
	{{ HTML::Script('bower_components/axios/dist/axios.min.js') }}
	{{ HTML::Script('bower_components/sweetalert/dist/sweetalert.min.js') }}
	{{ HTML::Script('bower_components/hold-on/src/js/HoldOn.min.js') }}
	{{ HTML::Script('js/loader.js') }}
	{{ HTML::Script('js/filtros.js') }}
	{{ HTML::Script('js/currency.js?1.0') }}
	<script type="text/javascript">
		var _transfer = '{{ Lang::get('Page.Transferencia.Type') }}';

		var vue_header = new Vue({
			el: '#vue_header',
			data: {
				cart: '{{ Cart::count() }}'
			}
		});
	</script>
	@yield('scripts')
</body>
</html>