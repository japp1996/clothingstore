<header id="vue_header">   
	<nav class="navbar navbar-expand-lg fixed-top bg-light">
	   <a class="navbar-brand" href="{{ URL('home') }}">
	    {{ HTML::Image('img/logo.png','',['class' => 'logo']) }}
	   </a>

	   <ul class="navbar-nav navbar-responsive ml-auto">
	   		<li class="nav-item {{ isset($_active) && $_active == 5 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('carrito') }}">
		      	<span class="container-cart container-cart-responsive">
			      	{{ isset($_active) && $_active == 5 ? HTML::Image('img/icons/cart_gold.png') : HTML::Image('img/icons/cart.png') }}
			      	<span class="badge text-center" v-if="cart > 0" v-cloak>
			      		@{{ cart }}
			      	</span>
			    </span>
		      </a>
		    </li>
	   </ul>

	   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
	     <i class="fa fa-bars"></i>
	   </button>
		
	   <div class="collapse navbar-collapse" id="collapsibleNavbar">
		   <ul class="navbar-nav">
		   	<li class="nav-item {{ isset($_active) && $_active == 1 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('nosotros') }}">@lang('Header.Nosotros')</a>
		    </li>
		    <li class="nav-item {{ isset($_active) && $_active == 2 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('mundo') }}">@lang('Header.Mundo')</a>
		    </li>
		    <li class="nav-item {{ isset($_active) && $_active == 3 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('tienda') }}">@lang('Header.Tienda')</a>
		    </li>
		    <li class="nav-item {{ isset($_active) && $_active == 4 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('aliados') }}">@lang('Header.Aliados')</a>
		    </li>
		    <li class="nav-item {{ isset($_active) && $_active == 5 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('carrito') }}">
		      	@lang('Header.Carrito')
		      	<span class="container-cart">
			      	{{ isset($_active) && $_active == 5 ? HTML::Image('img/icons/cart_gold.png') : HTML::Image('img/icons/cart.png') }}
			      	<span class="badge text-center" v-if="cart > 0" v-cloak>
			      		@{{ cart }}
			      	</span>
			    </span>
			    <span class="counter-cart" v-if="cart > 0" v-cloak>
			    	(@{{ cart }})
			    </span>
		      </a>
		    </li>
		    @if (Auth::check())
			    <li class="nav-item {{ isset($_active) && $_active == 6 ? 'active' : '' }}">
			      <a class="nav-link" href="{{ URL('perfil') }}">@lang('Header.Perfil')</a>
			    </li>
			@endif
			<li class="nav-item link-idioma-responsive">
		      <a class="nav-link" href="{{ URL('contacto') }}">@lang('Header.Contacto')</a>
		    </li>
		  </ul>
		  <ul class="navbar-nav ml-auto">
		  	<li class="nav-item dropdown">
		      <a class="nav-link link-idioma text-center dropdown-toggle" data-toggle="dropdown">
		      	{{ HTML::Image('img/icons/idioma.png') }}
		      	<span>@lang('Header.Idioma')</span>
		      </a>
		      <a class="nav-link link-idioma-responsive text-center dropdown-toggle" data-toggle="dropdown">
		      	@lang('Header.Idioma')
		      </a>
		      <div class="dropdown-menu dropdown-menu-right">
		          <a class="dropdown-item" href="{{ URL('lang/es') }}">@lang('Header.Spanish')</a>
		          <a class="dropdown-item" href="{{ URL('lang/en') }}">@lang('Header.English')</a>
		      </div>
		    </li>
		  </ul>
	   </div>
	</nav>
</header>