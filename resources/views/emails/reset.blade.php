<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>@lang('Page.ResetEmail.Title')</title>
	<style type="text/css">
		.container {
			text-align: center;
			font-family: Calibri;
			padding: 40px;
		}
		img {
			width: 350px;
		}
		.title {
			text-transform: uppercase;
			font-weight: 300;
			font-size: 30px;
			margin-top: 40px;
		}
		button {
			margin-top: 20px;
			text-transform: uppercase;
			font-weight: 300;
			width: 250px;
			border-radius: 3px;
			padding: 15px;
			text-align: center;
			outline: 0px !important;
			font-size: 16px !important;
			border: 0px !important;
			background-color: #43A047 !important;
			color: #f4f4f4 !important;
			cursor: pointer;
		}
		.codigo {
			font-size: 30px;
			text-transform: uppercase;
			font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="container">
		<img src="{{ URL('img/logo.png') }}" />
		<h4 class="title">@lang('Page.ResetEmail.Title')</h4>
		<p>@lang('Page.ResetEmail.Continuar')</p>
		<div class="codigo">{{ $codigo }}</div>
	</div>
</body>
</html>