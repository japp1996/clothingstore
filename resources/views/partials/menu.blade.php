<ul class="leftside-navigation">

    {{-- <li class="navigation">Menú</li> --}}

    <li>
        <a href="{{ url('/admin') }}" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Inicio">
            <img src="{{ asset('img/icons/ico-inicio.png') }}" alt="" class="img-responsive">Inicio
        </a>
    </li>
    
    @if(Auth::user()->hasPermission('module_registration') || Auth::user()->hasRole('super-admin'))
        <li>
            <a href="javascript:void(0)" class="collapsible-label1 tooltipped" data-position="right" data-delay="50" data-tooltip="Matrícula">
                <img src="{{ asset('img/icons/ico-matricula.png') }}" alt="" class="img-responsive">
                {{-- <i class="material-icons left-icon">person</i> --}}
                <img src="{{ asset('img/icons/ico-flecha.png') }}" alt="" class="img-responsive pull-right ico-flecha  right-icon">       
                {{-- <i class="material-icons right-icon">arrow_drop_down</i> --}}
                Matrícula
            </a>
            <ul class="collapsible-body">
                <li><a href="{{ url('/admin/registration/create') }}">Registro de Estudiantes</a></li>
                <li><a href="{{ url('/admin/consult-students') }}">Consulta de Estudiantes</a></li>
                <li><a href="{{ url('/admin/enrollment-information') }}">Informes de Matricula</a></li>
            </ul>
        </li>
    @endif
    
    @if(Auth::user()->hasPermission('module_administration') || Auth::user()->hasRole('super-admin'))
        <li>
            <a href="javascript:void(0)" class="collapsible-label1  waves-default tooltipped" data-position="right" data-delay="50" data-tooltip="Administración">
                <img src="{{ asset('img/icons/ico-administracion.png') }}" alt="" class="img-responsive">                
                {{-- <i class="material-icons left-icon">build</i> --}}
                <img src="{{ asset('img/icons/ico-flecha.png') }}" alt="" class="img-responsive pull-right ico-flecha  right-icon">       
                {{-- <i class="material-icons right-icon">arrow_drop_down</i> --}}
                Administración
            </a>
            <ul class="collapsible-body">
                <li><a href="{{ url('/admin/create-users') }}"">Creación de Usuarios</a></li>
                <li><a href="{{ url('/admin/courses-classes') }}"">Curso - Clases</a></li>
                <li><a href="{{ url('/admin/document_managements') }}"">Gestión Documental</a></li>
                <li><a href="{{ url('/admin/informe') }}"">Informe administrativo</a></li>
                <li><a href="{{ url('/admin/periods') }}"">Períodos</a></li>
            </ul>
        </li>
    @endif

    @if(Auth::user()->hasPermission('module_financial') || Auth::user()->hasRole('super-admin'))
        <li>
            <a href="javascript:void(0)" class="collapsible-label1 waves-default tooltipped" data-position="right" data-delay="50" data-tooltip="Financiera">
                {{-- <i class="material-icons left-icon">business</i> --}}
                <img src="{{ asset('img/icons/ico-financiera.png') }}" alt="" class="img-responsive">                
                <img src="{{ asset('img/icons/ico-flecha.png') }}" alt="" class="img-responsive pull-right ico-flecha  right-icon">       
                {{-- <i class="material-icons right-icon">arrow_drop_down</i> --}}
                Financiera
            </a>
            <ul class="collapsible-body">
                <li><a href="{{ url('/admin/invoices') }}">Facturación</a></li>
                <li><a href="{{ url('/admin/treasure') }}">Tesorería</a></li>
                <li><a href="{{ url('/admin/purse') }}">Cartera</a></li> 
                {{--  <li><a href="collections.html" class="waves-default">Informes Adimistrativo</a></li>  --}}
            </ul>
        </li>
    @endif

    @if(Auth::user()->hasPermission('module_academic') || Auth::user()->hasRole('super-admin'))
        <li>
            <a href="javascript:void(0)" class="collapsible-label1 waves-default tooltipped" data-position="right" data-delay="50" data-tooltip="Académico">
                {{-- <i class="material-icons left-icon">assignment</i> --}}
                <img src="{{ asset('img/icons/ico-academico.png') }}" alt="" class="img-responsive">                
                <img src="{{ asset('img/icons/ico-flecha.png') }}" alt="" class="img-responsive pull-right ico-flecha  right-icon">       
                {{-- <i class="material-icons right-icon">arrow_drop_down</i> --}}
                Académico
            </a>
            <ul class="collapsible-body">
                <li><a href="{{ url('/admin/assistances') }}">Asistencia</a></li>
                <li><a href="{{ url('/admin/qualifications') }}">Calificaciones</a></li>
                {{--  <li><a href="{{ url('/admin/tasks')}}" class="waves-default">Tareas</a></li>  --}}
                <li><a href="{{ url('/admin/homework') }}">Tareas</a></li>
                {{--  <li><a href="collections.html" class="waves-default">Gestión Documental</a></li>  --}}
                {{--  <li><a href="collections.html" class="waves-default">Informes Adimistrativo</a></li>  --}}
            </ul>
        </li>
    @endif
    
    @if(Auth::user()->hasPermission('module_calender') || Auth::user()->hasRole('super-admin'))
        <li>
            <a href="javascript:void(0)" class="collapsible-label1 waves-default tooltipped" data-position="right" data-delay="50" data-tooltip="Calendarios">
                {{-- <i class="material-icons left-icon">calendar_today</i> --}}
                <img src="{{ asset('img/icons/ico-calendarios.png') }}" alt="" class="img-responsive">                

                <img src="{{ asset('img/icons/ico-flecha.png') }}" alt="" class="img-responsive pull-right ico-flecha  right-icon">       
                {{-- <i class="material-icons right-icon">arrow_drop_down</i> --}}
                Calendarios
            </a>
            <ul class="collapsible-body">
                <li><a href="{{ url('/admin/record_calendar') }}">Registrar Actividad</a></li>
                <li><a href="{{ url('/admin/check_calendar') }}">Consultar Calendarios</a></li>
            </ul>
        </li>
    @endif

    @if(Auth::user()->hasPermission('module_school_life') || Auth::user()->hasRole('super-admin'))
        <li>
            <a href="javascript:void(0)" class="collapsible-label1 waves-default tooltipped" data-position="right" data-delay="50" data-tooltip="Convivencia Escolar">
                {{-- <i class="material-icons left-icon">supervised_user_circle</i> --}}
                <img src="{{ asset('img/icons/ico-convivencia.png') }}" alt="" class="img-responsive">                

                {{-- <i class="material-icons right-icon">arrow_drop_down</i> --}}
                <img src="{{ asset('img/icons/ico-flecha.png') }}" alt="" class="img-responsive pull-right ico-flecha  right-icon">       
                {{-- <i class="material-icons right-icon">arrow_drop_down</i> --}}
                Convivencia Escolar
            </a>
            <ul class="collapsible-body">
                <li><a href="{{ url('/admin/convivencia/ruta') }}" class="waves-default">Ruta de Atención Integral</a></li>
                <li><a href="{{ url('/admin/convivencia/reporte') }}" class="waves-default">Reporte de Eventos</a></li>
                <li><a href="{{ url('/admin/convivencia/seguimiento') }}" class="waves-default">Seguimiento a Eventos</a></li>
            </ul>
        </li>
    @endif

    @if(Auth::user()->hasPermission('module_galleries') || Auth::user()->hasRole('super-admin'))
        <li>
            <a href="javascript:void(0)" class="collapsible-label1 waves-default tooltipped" data-position="right" data-delay="50" data-tooltip="Galerías">
                {{-- <i class="material-icons left-icon">collections</i> --}}
                <img src="{{ asset('img/icons/ico-galerias.png') }}" alt="" class="img-responsive">                
                Galerías
                <img src="{{ asset('img/icons/ico-flecha.png') }}" alt="" class="img-responsive pull-right ico-flecha  right-icon">       
                {{-- <i class="material-icons right-icon">arrow_drop_down</i> --}}
            </a>
            <ul class="collapsible-body">
                <li><a href="{{ url('/admin/galleries') }}">Crear galerías</a></li>
                <li><a href="{{ url('/admin/read_galleries') }}">Consultar galerías</a></li>
            </ul>
        </li>
    @endif
    
    @if(Auth::user()->hasPermission('module_messages') || Auth::user()->hasRole('super-admin'))
        <li>
            <a href="javascript:void(0)" class="collapsible-label1 waves-default tooltipped" data-position="right" data-delay="50" data-tooltip="Mensajes">
                {{-- <i class="material-icons left-icon">message</i> --}}
                <img src="{{ asset('img/icons/ico-mensajes.png') }}" alt="" class="img-responsive">       
                Mensajes

                <img src="{{ asset('img/icons/ico-flecha.png') }}" alt="" class="img-responsive pull-right ico-flecha  right-icon">       
                {{-- <i class="material-icons right-icon">arrow_drop_down</i> --}}
            </a>
            <ul class="collapsible-body">
                <li><a href="{{ url('/admin/messages/1') }}">Mensajes Recibidos</a></li>
                <li><a href="{{ url('/admin/messages/0') }}">Mensajes Enviados</a></li>
            </ul>
        </li>
    @endif

    @if(Auth::user()->hasPermission('module_commercial_benefits') || Auth::user()->hasRole('super-admin'))
        <li>
            <a href="javascript:void(0)" class="collapsible-label1 waves-default tooltipped" data-position="right" data-delay="50" data-tooltip="Beneficios Comerciales">
                <img src="{{ asset('img/icons/ico-beneficios.png') }}" alt="" class="img-responsive">  
                
                <img src="{{ asset('img/icons/ico-flecha.png') }}" alt="" class="img-responsive pull-right ico-flecha  right-icon">       
                {{-- <i class="material-icons right-icon">arrow_drop_down</i> --}}
                Beneficios Comerciales
            </a>
            <ul class="collapsible-body">
                <li><a href="{{ url('/admin/benefits/code') }}">Código QR</a></li>
                <li><a href="{{ url('/admin/benefits') }}">Comercios Aliados</a></li>
            </ul>
        </li>
    @endif
  
</ul>