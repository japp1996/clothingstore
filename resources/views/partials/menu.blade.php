<ul class="leftside-navigation">

    {{-- <li class="navigation">Menú</li> --}}

    <li>
        <a href="{{ url('/admin') }}" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Inicio">
            <img src="{{ asset('img/icons/ico-inicio.png') }}" alt="" class="img-responsive">Inicio
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
        <a href="{{ url('/admin/collection') }}" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Colección">
            <img src="{{ asset('img/icons/ico-inicio.png') }}" alt="" class="img-responsive">Colección
        </a>
    </li>
</ul>