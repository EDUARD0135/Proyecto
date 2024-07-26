@extends('AdminNavbar')
@section('titulo', 'Lista de Ofertas')

@section('Contenido')

    <!-- H. EDUARDO -->
    <style>
        section {
            background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
            ;
            background-size: cover;
        }

        .page-link {
            color: rgb(61, 69, 80);
            /* Cambia el color del texto de los enlaces de la paginación */
            border-color: rgb(61, 69, 80);
            /* Cambia el color del borde de los enlaces de la paginación */
        }

        .pagination-item {
            margin-right: 15px;
            /* Ajusta la separación entre los elementos de la paginación según tu preferencia */
        }

        .page-item.active .page-link {
            background-color: rgb(61, 69, 80);
            /* Cambia el color de fondo de la página activa */
            border-color: rgb(61, 69, 80);
            /* Cambia el color del borde de la página activa */
        }

        .page-link:hover {
            background-color: rgba(61, 69, 80, 0.8);
            /* Cambia el color de fondo al pasar el mouse sobre los enlaces */
        }

        .search-form {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-input {
            margin-right: 10px;
        }

        .product-table {
            margin-top: 20px;
        }

        .product-table th,
        .product-table td {
            text-align: center;
        }

        /* Nuevos estilos para botones */
        .btn-custom {
            margin-right: 10px;
            color: rgb(61, 69, 80);

        }

        .btn-danger-custom {
            margin-right: 10px;
        }

        .search-input {
            flex-grow: 1;
            /* Hace que la barra de búsqueda ocupe todo el espacio disponible */
            min-width: 200px;
            /* Define un ancho mínimo para la barra de búsqueda */
        }

        .dropdown {
            position: relative;
            /* Ajusta la posición de los filtros */
        }

        .dropdown-menu {
            min-width: 200px;
            /* Define un ancho mínimo para los menús desplegables */
        }

        .product-table th,
        .product-table td {
            text-align: center;
            vertical-align: middle;
            /* Centra el contenido verticalmente */
            max-width: 150px;
            /* Tamaño máximo para el contenido de la celda */
            overflow: hidden;
            /* Oculta el contenido que excede el tamaño máximo */
            text-overflow: ellipsis;
            /* Agrega puntos suspensivos (...) al texto cortado */
            white-space: nowrap;
            /* Evita que el texto se divida en varias líneas */
        }

        .full-screen {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>

    <section class="custom-bg2 @if ($ofertas->isEmpty()) full-screen @endif">
        <div class="container py-5">

            <h1 style="color:rgb(61, 69, 80); font-size:50px; font: sans-serif;"><b>OFERTAS</b></h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <!-- Barra de búsqueda -->
                    <form class="d-flex" action="{{ route('ofertaslist') }}" method="get">
                        <input class="form-control me-2 search-input" type="search" placeholder="Buscar"
                            aria-label="Search" name="buscar" value="{{ session('OfertaBuscar') }}">
                        <button class="btn btn" type="submit"
                            style="background-color: #2f2c79; color:white">Buscar</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <!-- Filtros -->
                    <div class="d-flex justify-content-end">

                        <!-- Filtro 1 -->
                        <div class="dropdown mx-2">
                            <button class="btn btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false" style="background-color: #2f2c79; color:white">
                                FILTRAR POR CATEGORÍAS
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['categoria' => 'pantalones']) }}">Pantalones</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['categoria' => 'camisas']) }}">Camisas</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['categoria' => 'collares']) }}">Collares</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['categoria' => 'zapatos']) }}">Zapatos</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['categoria' => 'llaveros']) }}">Llaveros</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['categoria' => 'pulseras']) }}">Pulseras</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['categoria' => 'dulces']) }}">Dulces</a></li>

                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['categoria' => 'postres']) }}">Postres</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['categoria' => 'variados']) }}">Variados</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Filtro 2 -->
                        <div class="dropdown mx-2">
                            <button class="btn btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false" style="background-color: #2f2c79; color:white">
                                FILTRAR POR PRECIO
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['precio' => 'BARATO']) }}">BARATO</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['precio' => 'CARO']) }}">CARO</a>
                                </li>
                            </ul>
                        </div>

                        <!-- Filtro 3 -->
                        <div class="dropdown mx-2">
                            <button class="btn btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false" style="background-color: #2f2c79; color:white">
                                FILTRAR POR LETRA
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['nombre' => 'ASCENDENTE']) }}">ASCENDENTE</a>
                                </li>
                                <li><a class="dropdown-item"
                                        href="{{ route('ofertaslist', ['nombre' => 'DESCENDENTE']) }}">DESCENDENTE</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <div class="product-table">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="width: 150px; text-align: left;">Nombre</th>
                                <th style="text-align: center; width: 120px;" scope="col">Precio</th>
                                <th style="width: 250px; text-align: left;" scope="col">Descripción</th>
                                <th scope="col" style="width: 100px;">Categoría</th>
                                <th scope="col" style="width: 100px;">Ver</th>
                                <th scope="col" style="width: 100px;">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ofertas as $oferta)
                                <tr>
                                    <td style="text-align: left;">
                                        <a href="{{ route('ShowOfertaAdmin', ['id' => $oferta->id]) }}"
                                            class="text-decoration-none" style="color: black;">
                                            {{ $oferta->nombre }}
                                        </a>
                                    </td>
                                    <td>Lps {{ $oferta->precio }}</td>
                                    <td style="text-align: left;">{{ $oferta->descripcion }}</td>
                                    <td>{{ $oferta->categoria }}</td>
                                    <td>
                                        <a href="{{ route('ShowOfertaAdmin', ['id' => $oferta->id]) }}"
                                            class="btn btn-outline-info btn-custom">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>

                                    <td>
                                        <form action="{{ route('oferta.borrar1', $oferta->id) }}" method="POST"
                                            id="formEliminar{{ $oferta->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="row">
                                                <div class="col">
                                                    <button type="submit" class="btn btn-outline-danger btn-danger-custom">
                                                        <i class="fas fa-trash-alt"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">NO HAY OFERTAS</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- INICIO PAGINACION -->
            <ul class="pagination pagination-lg justify-content-end py-3" id="pagination">
                {{-- Enlaces de paginación para ofertas --}}
                @php
                    $currentPage = $ofertas->currentPage();
                    $totalPages = $ofertas->lastPage();
                    $range = 3;
                    $start = max(1, $currentPage - floor($range / 2));
                    $end = min($start + $range - 1, $totalPages);
                    $start = max(1, min($totalPages - $range + 1, $start));
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    <li class="page-item pagination-item @if ($page == $currentPage) active @endif">
                        <a class="page-link  shadow-sm  text-dark @if ($page == $currentPage) text-white @endif"
                            href="{{ route('ofertaslist', ['page' => $page]) }}">{{ $page }}</a>
                    </li>
                @endfor
            </ul>
            <!-- FIN PAGINACION-->

        </div>
    </section>

@endsection
