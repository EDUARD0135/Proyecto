@extends('Navbar')

@section('titulo', 'Ofertas')

@section('todo')

    <style>
        .pagination-item {
            margin-right: 20px;
            /* Ajusta este valor según tus necesidades */
        }

        .custom-bg {
            background-color: #dbfcda;
        }

        .custom-bg2 {
            background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
            background-size: cover;
        }

        /* Estilo para la sección de filtros */
        .dropdown {
            display: inline-block;
            margin-right: 10px;
        }

        /* Estilo para el formulario de búsqueda */
        .form-control {
            border-radius: 10;
        }

        /* Estilo para los botones de búsqueda y filtros */
        .btn-success {
            border-radius: 10;
        }

        /* Estilo para los productos */
        .card {
            border: 1px solid #ddd;
            border-radius: 20;
            transition: transform 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-img-top {
            max-height: 200px;
            object-fit: cover;
        }

        /* Estilo para los botones de acciones en los productos */
        .btn-outline-success {
            border-radius: 100;
        }

        /* Espaciado entre los productos */
        .mb-4 {
            margin-bottom: 20px;
        }

        /* Estilo para el mensaje de "NO HAY PRODUCTOS" */
        .text-center {
            margin-top: 0px;
        }

        /* Espaciado en la parte inferior */
        .py-5 {
            padding-bottom: 50px;
        }
    </style>

    <style>
        /* Estilo para las tarjetas de productos */
        .product-card {
            border: 1px solid #ddd;
            border-radius: 0;
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-card .card-img-top {
            max-height: 240px;
            object-fit: cover;
        }

        /* Estilo para los botones de acción en las tarjetas de productos */
        .action-buttons {
            display: flex;
            justify-content: center;
            margin: 10px 0;
        }

        .action-buttons .btn {
            font-size: 18px;
        }
    </style>


    <!-- INCIO OFERTAS -->
    <!-- H. SANDY -->
    <section class="custom-bg2">
        <div class="container py-5">
            <div class="row">

                <!-- INCIO FILTRO 1 -->
                <div id="accordion" class="col-lg-3">
                    <h1 class="display-5 text pb-4"><b>Categorias</b></h1>

                    @php
                        // Definición de filtros y opciones
                        $nombresFiltros = ['ROPA', 'ACCESORIOS', 'ALIMENTOS'];
                        $opciones = [
                            'ROPA' => ['Camisas', 'Pantalones', 'Zapatos'],
                            'ACCESORIOS' => ['Llaveros', 'Pulseras', 'Collares'],
                            'ALIMENTOS' => ['Dulces', 'Postres', 'Variado'],
                        ];

                        // Asociar un icono a cada opción
                        $iconosOpciones = [
                            'Camisas' => 'fa fa-fw fa-tshirt',
                            'Pantalones' => 'fa fa-fw fa-tshirt',
                            'Zapatos' => 'fa fa-fw fa-shoe-prints',
                            'Llaveros' => 'fa fa-fw fa-key',
                            'Pulseras' => 'fa fa-fw fa-ring',
                            'Collares' => 'fa fa-fw fa-gem',
                            'Dulces' => 'fa fa-fw fa-candy-cane',
                            'Postres' => 'fa fa-fw fa-birthday-cake',
                            'Variado' => 'fa fa-fw fa-th',
                        ];
                    @endphp

                    @for ($filtro = 0; $filtro < count($nombresFiltros); $filtro++)
                        <!-- FILTRO {{ $filtro + 1 }} -->
                        <div class="card mb-3 bg-success">
                            <div class="card-header" id="heading{{ $filtro }}">
                                <h5 class="mb-0">
                                    <!-- Botón de colapso del filtro -->
                                    <button class="btn btn" style="color: white; width: 100%; text-align: left;"
                                        data-toggle="collapse" data-target="#collapse{{ $filtro }}"
                                        aria-expanded="true" aria-controls="collapse{{ $filtro }}">
                                        {{ $nombresFiltros[$filtro] }}
                                    </button>
                                </h5>
                            </div>

                            <div id="collapse{{ $filtro }}" class="collapse"
                                aria-labelledby="heading{{ $filtro }}" data-parent="#accordion">
                                <div class="card-body bg-light p-4">
                                    <form>
                                        <div class="options-vertical"> <!-- Nueva clase para organizar verticalmente -->
                                            @foreach ($opciones[$nombresFiltros[$filtro]] as $index => $opcion)
                                                <!-- Opción de selección {{ $index + 1 }} -->
                                                <div class="option">
                                                    <i class="{{ $iconosOpciones[$opcion] }} text-dark mr-1"></i>
                                                    <a href="{{ route('Ofertas', ['buscar' => request()->get('buscar'), 'categoria' => $opcion]) }}"
                                                        class="btn btn">{{ $opcion }}</a>
                                                </div>
                                                <!-- Fin de la opción de selección {{ $index + 1 }} -->
                                            @endforeach
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Fin del FILTRO {{ $filtro + 1 }} -->
                    @endfor
                </div>
                <!-- FIN FILTRO 1 -->

                <div class="col-lg-9">

                    <!-- INCIO FILTROS -->
                    <div class="row">
                        <!-- INCIO FILTRO 2 -->
                        <div class="col-md-3">
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    ORDENAR POR PRECIO
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('Ofertas', ['precio' => 'TODOS']) }}">TODOS</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('Ofertas', ['precio' => 'CARO']) }}">CARO</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('Ofertas', ['precio' => 'BARATO']) }}">BARATO</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- FIN FILTRO 2-->

                        <!-- INCIO FILTRO 3 -->
                        <div class="col-md-4">
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    ORDENAR POR LETRA
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('Ofertas', ['nombre' => 'ASCENDENTE']) }}">ASCENDENTE</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('Ofertas', ['nombre' => 'DESCENDENTE']) }}">DESCENDENTE</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('Ofertas', ['nombre' => 'TODOS']) }}">TODOS</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- FIN FILTRO 3-->

                        <!-- INCIO BUSCAR -->
                        <div class="col-md-5 pb-4">
                            <form class="d-flex" action="{{ route('Ofertas') }}" method="get">
                                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search"
                                    name="buscar" value="{{ session('OfertaBuscar') }}">
                                <!-- Agregar la clase personalizada "search-button" al botón de búsqueda -->
                                <button class="btn btn-success" type="submit">Buscar</button>
                            </form>
                        </div>
                        <!-- FIN BUSCAR -->
                    </div>
                    <!-- FIN FILTROS -->

                    <!-- INCIO OFERTA -->
                    <div id="content">
                        <div class="row">
                            @forelse($ofertas as $oferta)
                                <div class="col-md-4 mb-4">
                                    <div class="card product-card">
                                        <a href="{{ route('ShowOferta', ['id' => $oferta->id]) }}">
                                            <img style="height: 200px; object-fit: cover;" class="card-img-top"
                                                src="{{ asset($oferta->Imagen) }}" alt="{{ $oferta->nombre }}">
                                        </a>
                                        <div class="card-body d-flex flex-column align-items-left">
                                            <div class="action-buttons">
                                                <!-- LOGO CORAZON -->
                                                <!-- H. EDUARDO -->
                                                <form
                                                    action="{{ route('AgregarFavoritoOferta', ['oferta' => $oferta->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success text-white mx-2">
                                                        <i class="far fa-heart"></i>
                                                    </button>
                                                </form>
                                                <!-- H. EDUARDO -->

                                                <!-- LOGO OJO -->
                                                <!-- H. SANDY -->
                                                <a href="{{ route('ShowOferta', ['id' => $oferta->id]) }}"
                                                    class="btn btn-success text-white mx-2">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <!-- H. SANDY -->
                                                <!-- H. EDUARDO -->

                                                <!-- LOGO CORRRITO -->
                                                <!-- H. EDUARDO -->
                                                <form action="{{ route('AgregarPedidoOferta', ['oferta' => $oferta->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success text-white mx-2">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </form>
                                                <!-- H. EDUARDO -->

                                            </div>
                                            <br>
                                            <a href="{{ route('ShowOferta', ['id' => $oferta->id]) }}" class="h5 text-decoration-none text-success" 
                                                title="{{ $oferta->nombre }}" style="height: 22px; overflow: hidden;"><b>{{ $oferta->nombre }}</b></a>
                                            <a class="h6 text-decoration-none text-danger"><b>Lps
                                                    {{ $oferta->precio }}</b></a>
                                            <a class="h6 text-decoration-none" style="height: 40px; overflow: hidden;">Lps
                                                {{ $oferta->descripcion }}</a>
                                            <a class="h6 text-decoration-none text-left">Categoria: <span
                                                    style="color: #008410;"><b>{{ $oferta->categoria }}</b></span></a>

                                        </div>
                                    </div>
                                </div>
                            @empty
                            <div class="container text-center py-5">
                            <p>¡Vaya! Parece que no hay Ofertas en este momento.</p>
                            <p>¡Se el primero en añadir una oferta Iniciando Sesion!.</p>
                            <a href="{{ route('usuario.login') }}" class="btn btn-success btn-lg mt-1">
                                <i class="fa fa-fw fa-user"></i> Inicia Sesion
                              </a>
                            </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- FIN OFERTAS -->

                    <!-- INCIO PAGINACION -->
                    <br>
                    <div class="row">
                        {{-- Enlaces de paginación para ofertas --}}
                        <ul class="pagination pagination-lg justify-content-end" id="pagination">

                            {{-- Mostrar enlaces de páginas --}}
                            @php
                                // Página actual
                                $currentPage = $ofertas->currentPage();

                                // Rango total de páginas a mostrar
                                $totalPages = $ofertas->lastPage();

                                // Rango de páginas a mostrar (máximo 4)
                                $range = 3;

                                // Calcula el inicio y fin del rango de páginas
                                $start = max(1, $currentPage - floor($range / 2));
                                $end = min($start + $range - 1, $totalPages);

                                // Ajusta el inicio si el rango es menor a 4
                                $start = max(1, min($totalPages - $range + 1, $start));
                            @endphp

                            @for ($page = $start; $page <= $end; $page++)
                                <li class="page-item pagination-item @if ($page == $currentPage) active @endif">
                                    <a class="page-link  shadow-sm  text-dark @if ($page == $currentPage) bg-success text-white @endif"
                                        href="{{ route('Ofertas', ['page' => $page]) }}">{{ $page }}</a>
                                </li>
                            @endfor

                        </ul>
                    </div>
                    <!-- FIN PAGINACION -->

                </div>
            </div>
        </div>
    </section>
    <!-- H. SANDY -->
    <!-- FIN OFERTAS -->

    <!-- INICIO PRODUCTOS MAS BUSCADOS -->
    <section class="custom-bg py-4">
        <div class="container my-4">
            <div class="container">
                <div style="text-align:center">
                    <h1 class="display-4 text-success"><b>PRODUCTOS MAS BUSCADOS</b></h1>
                </div>
                <br>
                <div class="outer-container" style="overflow: hidden;">
                    <div class="scroll-container" style="overflow-x: auto; white-space: nowrap; padding-bottom: 20px;">
                        <!-- Mostrar resultados de búsquedas populares en tarjetas -->
                        @forelse ($busquedasPopulares as $busqueda)
                            <div class="card"
                                style="display: inline-block; width: 300px; margin-right: 10px; object-fit: cover;">
                                <img src="{{ asset($busqueda->Imagen) }}" style="height: 200px; object-fit: cover;"
                                    class="card-img-top" alt="{{ $busqueda->term }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $busqueda->term }}</h5>
                                    <p class="card-text">{{ $busqueda->count }} veces buscado</p>
                                </div>
                            </div>
                        @empty
                        <div class="container text-center">
                            <p>¡Vaya! Parece que no hay Ofertas disponibles en este momento.</p>
                            <p>No te preocupes, nuestra tienda está llena de emocionantes productos esperándote.</p>
                            <a href="{{ route('Ofertas') }}" class="btn btn-success btn-lg mt-3">
                                <i class="fas fa-shopping-cart"></i> Explorar Oferta
                              </a>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--FIN PRODUCTOS MAS BUSCADOS -->

@endsection
