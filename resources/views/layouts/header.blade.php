<header>   
	<nav class="navbar navbar-expand-lg fixed-top bg-light">
	   <a class="navbar-brand" href="{{ URL('home') }}">
	    {{ HTML::Image('img/logo.png','',['class' => 'logo']) }}
	   </a>

	   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
	     <i class="fa fa-bars"></i>
	   </button>
		
	   <div class="collapse navbar-collapse" id="collapsibleNavbar">
		   <ul class="navbar-nav">
		   	<li class="nav-item {{ isset($_active) && $_active == 1 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('nosotros') }}">Wará</a>
		    </li>
		    <li class="nav-item {{ isset($_active) && $_active == 2 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('mundo') }}">Mundo Wará</a>
		    </li>
		    <li class="nav-item {{ isset($_active) && $_active == 3 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('tienda') }}">Tienda</a>
		    </li>
		    <li class="nav-item {{ isset($_active) && $_active == 4 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('aliados') }}">Aliados</a>
		    </li>
		    <li class="nav-item {{ isset($_active) && $_active == 5 ? 'active' : '' }}">
		      <a class="nav-link" href="{{ URL('carrito') }}">
		      	Carrito
		      	<span class="container-cart">
			      	{{ isset($_active) && $_active == 5 ? HTML::Image('img/icons/cart_gold.png') : HTML::Image('img/icons/cart.png') }}
			      	@if (Cart::count() > 0)
				      	<span class="badge text-center">
				      		{{ Cart::count() }}
				      	</span>
				    @endif
			    </span>
			    @if (Cart::count() > 0)
				    <span class="counter-cart">
				    	({{ Cart::count() }})
				    </span>
				@endif
		      </a>
		    </li>
		    @if (Auth::check())
			    <li class="nav-item {{ isset($_active) && $_active == 6 ? 'active' : '' }}">
			      <a class="nav-link" href="{{ URL('perfil') }}">Perfil</a>
			    </li>
			@endif
			<li class="nav-item link-idioma-responsive">
		      <a class="nav-link" href="{{ URL('contacto') }}">Contacto</a>
		    </li>
		  </ul>
		  <ul class="navbar-nav ml-auto">
		  	<li class="nav-item dropdown">
		      <a class="nav-link link-idioma text-center dropdown-toggle" data-toggle="dropdown">
		      	{{ HTML::Image('img/icons/idioma.png') }}
		      	<span>Idioma</span>
		      </a>
		      <a class="nav-link link-idioma-responsive text-center dropdown-toggle" data-toggle="dropdown">
		      	Idioma
		      </a>
		      <div class="dropdown-menu dropdown-menu-right">
		          <a class="dropdown-item" href="{{ URL('lang/es') }}">Español</a>
		          <a class="dropdown-item" href="{{ URL('lang/en') }}">Ingles</a>
		      </div>
		    </li>
		  </ul>
	   </div>
	</nav>
</header>