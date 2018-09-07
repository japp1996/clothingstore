<footer>
	<div class="row">
		<div class="col-md-4 col-6 center-text">
			<table>
				<tr>
					<td>
						<a target="_blank" href="{{ $_sociales->instagram }}" class="instagram_white">
							{{ HTML::Image('img/icons/instagram_white.png') }}
						</a>
					</td>
					<td>
						<a target="_blank" href="{{ $_sociales->facebook }}" class="facebook_white">
							{{ HTML::Image('img/icons/facebook_white.png') }}
						</a>
					</td>
					<td>
						<a target="_blank" href="{{ $_sociales->youtube }}" class="youtube">
							{{ HTML::Image('img/icons/youtube.png') }}
						</a>
					</td>
				</tr>
			</table>
		</div>
		<div class="col-md-4 col-6 text-center">
			@if (isset($_login))
				<a href="{{ URL('condiciones') }}" class="text-italic">
					@lang('Footer.Condiciones')
				</a>
			@else
				@if (Auth::check())
					<a href="{{ URL('logout') }}">
						<button class="btn btn-default">
							<span>@lang('Footer.Logout')</span>
						</button>
					</a>
				@else
					<a href="{{ URL('login') }}">
						<button class="btn btn-default">
							<span>@lang('Footer.Login')</span>
						</button>
					</a>
				@endif				
			@endif
		</div>
		<div class="col-md-4 right-text contacto">
			<a href="{{ URL('contacto') }}" class="text-degradado">
				{{ HTML::Image('img/icons/contacto.png') }}
				@lang('Footer.Contacto')
			</a>
		</div>
	</div>
</footer>