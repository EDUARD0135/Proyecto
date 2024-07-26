@extends('Navbar')

@section('titulo', 'Productos')

@section('todo')

    <!-- H. EDUARDO -->
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
    <!-- H. EDUARDO -->

    <!-- INCIO PRODUCTOS -->
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
                                                    <a href="{{ route('Tienda', ['buscar' => request()->get('buscar'), 'categoria' => $opcion]) }}"
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
                        <!-- H. KELEN -->
                        <div class="col-md-3">
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    style="height: 40px;" aria-expanded="false">
                                    ORDENAR POR PRECIO
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('Tienda', ['precio' => 'CARO']) }}">CARO</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('Tienda', ['precio' => 'BARATO']) }}">BARATO</a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- FIN FILTRO 2-->

                        <!-- INCIO FILTRO 3 -->
                        <!-- H. KELEN -->
                        <div class="col-md-4">
                            <div class="dropdown">
                                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    style="height: 40px;" aria-expanded="false">
                                    ORDENAR POR LETRA
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('Tienda', ['nombre' => 'ASCENDENTE']) }}">ASCENDENTE</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('Tienda', ['nombre' => 'DESCENDENTE']) }}">DESCENDENTE</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- FIN FILTRO 3-->

                        <!-- INCIO BUSCAR -->
                        <div class="col-md-5 pb-4">
                            <form class="d-flex" action="{{ route('Tienda') }}" method="get">
                                <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search"
                                    style="height: 40px;" name="buscar" value="{{ session('ProductoBuscar') }}">
                                <!-- Agregar la clase personalizada "search-button" al botón de búsqueda -->
                                <button class="btn btn-success" type="submit">Buscar</button>
                            </form>
                        </div>
                        <!-- FIN BUSCAR -->
                    </div>
                    <!-- FIN FILTROS -->

                    <!-- INCIO PRODUCTO -->
                    <!-- H. KELEN -->
                    <div id="content">
                        <div class="row">
                            @forelse($productos as $producto)
                                <div class="col-md-4 mb-4">
                                    <div class="card product-card">
                                        <a href="{{ route('ShowProducto', ['id' => $producto->id]) }}">
                                            <img style="height: 200px; object-fit: cover;" class="card-img-top"
                                                src="{{ asset($producto->Imagen) }}" alt="{{ $producto->nombre }}">
                                        </a>
                                        <div class="card-body d-flex flex-column align-items-left">
                                            <div class="action-buttons">
                                                
                                                <!-- LOGO CORAZON -->
                                                <!-- H. SANDY -->
                                                <form
                                                    action="{{ route('AgregarFavorito', ['producto' => $producto->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success text-white mx-2">
                                                        <i class="far fa-heart"></i>
                                                    </button>
                                                </form>
                                                 <!-- H. SANDY -->

                                                <!-- LOGO OJO -->
                                                <!-- H. KELEN -->
                                                <a href="{{ route('ShowProducto', ['id' => $producto->id]) }}"
                                                    class="btn btn-success text-white mx-2">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                                <!-- H. KELEN -->

                                                <!-- LOGO CARRITO -->
                                                <!-- H. SANDY -->
                                                <form action="{{ route('AgregarPedido', ['producto' => $producto->id]) }}"
                                                    method="post">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success text-white mx-2">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </form>
                                                <!-- H. SANDY -->
                                                <!-- LOGO CARRITO -->

                                            </div>
                                            <br>
                                            <a href="{{ route('ShowProducto', ['id' => $producto->id]) }}"
                                                class="h5 text-decoration-none text-success"
                                                title="{{ $producto->nombre }}"
                                                style="height: 22px; overflow: hidden;"><b>{{ $producto->nombre }}</b></a>
                                            <span class="h6 text-decoration-none"><b>Lps {{ $producto->precio }}</b></span>
                                            <p class="h6 text-decoration-none" style="height: 40px; overflow: hidden;">
                                                {{ $producto->descripcion }}</p>
                                            <a class="h6 text-decoration-none text-left">Categoría: <span
                                                    style="color: #008410;"><b>{{ $producto->categoria }}</b></span></a>

                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="container text-center py-5">
                                    <p>¡Vaya! Parece que no hay Productos en este momento.</p>
                                    <p>¡Se el primero en añadir un producto Iniciando Sesion!.</p>
                                    <a href="{{ route('usuario.login') }}" class="btn btn-success btn-lg mt-1">
                                        <i class="fa fa-fw fa-user"></i> Inicia Sesion
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <!-- H. KELEN -->
                    <!-- FIN PRODUCTO -->

                    <!-- INCIO PAGINACION -->
                    <!-- H. EDUARDO -->
                    <br>
                    <div class="row">
                        {{-- Enlaces de paginación para productos --}}
                        <ul class="pagination pagination-lg justify-content-end" id="pagination">

                            {{-- Mostrar enlaces de páginas --}}
                            @php
                                // Página actual
                                $currentPage = $productos->currentPage();

                                // Rango total de páginas a mostrar
                                $totalPages = $productos->lastPage();

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
                                        href="{{ route('Tienda', ['page' => $page]) }}">{{ $page }}</a>
                                </li>
                            @endfor

                        </ul>
                    </div>
                    <!-- H. EDUARDO -->
                    <!-- FIN PAGINACION -->

                </div>

            </div>
        </div>
    </section>
    <!-- FIN PRODUCTOS -->

    <!--INICIO PRODUCTOS MAS BUSCADOS -->
    <!-- H. ELVIN -->
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
                                <p>¡Vaya! Parece que no hay Productos disponibles en este momento.</p>
                                <p>No te preocupes, nuestra tienda está llena de emocionantes productos esperándote.</p>
                                <a href="{{ route('Tienda') }}" class="btn btn-success btn-lg mt-3">
                                    <i class="fas fa-shopping-cart"></i> Explorar Tienda
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- H. ELVIN -->
    <!--FIN PRODUCTOS MAS BUSCADOS-->

@endsection
