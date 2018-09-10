<ul class="leftside-navigation">

    {{-- <li class="navigation">Menú</li> --}}

    <li>
        <a href="{{ url('/admin') }}" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Inicio">
            <img src="{{ asset('img/icons/ico-inicio.png') }}" alt="" class="img-responsive">Inicio
        </a>
    </li>

    <li>
        <a href="{{ url('/admin/exchange_rate') }}" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Tasa de Cambio">
            <img src="{{ asset('img/icons/ico-inicio.png') }}" alt="" class="img-responsive">Tasa de Cambio
        </a>
    </li>

    <li>
        <a href="{{ url('/admin/sizes') }}" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Tallas">
            <img src="{{ asset('img/icons/ico-inicio.png') }}" alt="" class="img-responsive">Tallas
        </a>
    </li>

    <li>
        <a href="{{ url('/admin/categories') }}" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Categorías">
            <img src="{{ asset('img/icons/ico-inicio.png') }}" alt="" class="img-responsive">Categorías
        </a>
    </li>

    <li>
        <a href="{{ url('/admin/collections') }}" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Colecciones">
            <img src="{{ asset('img/icons/ico-inicio.png') }}" alt="" class="img-responsive">Colecciones
        </a>
    </li>
    <li>
        <a href="{{ url('/admin/designs') }}" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Diseños">
            <img src="{{ asset('img/icons/ico-inicio.png') }}" alt="" class="img-responsive">Diseños
        </a> 
    </li>
    <li>
        <a href="{{ url('/admin/products') }}" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Productos">
            <img src="{{ asset('img/icons/ico-inicio.png') }}" alt="" class="img-responsive">Productos
        </a> 
    </li>
</ul>