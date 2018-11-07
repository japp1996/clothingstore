<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title>@lang('Page.EmailCompra.Title')</title>
	<link rel="StyleSheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,600,700" />
	@include('emails.style')
</head>
<body>
	<div class="container" style="background-image: url({{ URL('img/fondo-login.jpg') }})">
		<div class="text-center">
			<h4 class="title">@lang('Page.EmailCompra.Title')</h4>
		</div>
		<ul>
			<li><strong>@lang('Page.EmailCompra.Fecha'):</strong> {{ \Carbon\Carbon::parse($compra->created_at)->format('d/m/Y') }}</li>
			<li><strong>@lang('Page.EmailCompra.Metodo'):</strong> {{ Metodo::get($compra->payment_type) }}</li>
			<li><strong>@lang('Page.EmailCompra.Cliente'):</strong> {{ $compra->user->name }}</li>
			@if ($compra->transaction_code != null)
				<li><strong>@lang('Page.EmailCompra.Code'):</strong> {{ $compra->transaction_code }}</li>
			@endif
		</ul>
		<table cellspacing="0" cellpadding="0">
			<thead align="left">
				<tr>
					<th>@lang('Page.EmailCompra.Producto')</th>
					<th class="text-center">@lang('Page.EmailCompra.Costo')</th>
					<th class="text-center">@lang('Page.EmailCompra.Cantidad')</th>
					<th class="text-right">@lang('Page.EmailCompra.Total')</th>
				</tr>
			</thead>
			<tbody>
				@foreach($compra->details as $item)
					<tr class="borde-blanco">
						<td>{{ \App::getLocale() == 'es' ? $item->product->name : $item->product->name_english }} ({{ $item->product_size->name }}) ({{ \App::getLocale() == 'es' ? $item->product_color->name : $item->product_color->name_english }})</td>
						<td class="text-center">{{ Money::get(CalcPrice::get($item->price,$item->coin,$compra->exchange->change)) }}</td>
						<td class="text-center">{{ $item->quantity }}</td>
						<td class="text-right">{{ Money::get(CalcPrice::get($item->price,$item->coin,$compra->exchange->change) * $item->quantity) }}</td>
					</tr>
				@endforeach

				<tr class="text-right total">
					<td></td>
					<td colspan="3">
						<h4>@lang('Page.EmailCompra.TotalPagar')</h4>
					</td>
				</tr>
				<tr class="text-right">
					<td></td>
					<td colspan="3" class="money">
						{{ Money::get(Total::get($compra)) }}
					</td>
				</tr>
			</tbody>
		</table>			
	</div>
</body>
</html>