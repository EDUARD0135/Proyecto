@extends('Navbar')

@section('titulo', 'Accesorios')

@section('todo')

    <style>
        .card:hover {
            transform: scale(1.05);
            transition: transform 0.4s;
        }

        .card:not(:hover) {
        transition: transform 0.4s ease-out;
        transform: scale(1); /* Ajusta el valor según tus necesidades */
        }

        .custom-bg {
            background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
            background-size: cover;
        }

        .pagination-item {
            margin-right: 20px;
            /* Ajusta este valor según tus necesidades */
        }
    </style>

    <section class="custom-bg">
        <div class="container py-4">
            <div class="text-center">
                <h1 class="display-3 text-success"><b>Accesorios</b></h1>
                <p class="lead">Encuentra accesorios increíbles para complementar tu estilo.</p>
            </div>

            <!-- Filtros -->
            <div class="row my-4 py-2">
                <div class="col-md-4">
                    <!-- Dropdown para ordenar por precio -->
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Ordenar por Precio
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ route('CategoriaAccesorios', ['precio' => 'TODOS']) }}">Todos</a></li>
                            <li><a class="dropdown-item" href="{{ route('CategoriaAccesorios', ['precio' => 'CARO']) }}">Más
                                    caro</a></li>
                            <li><a class="dropdown-item"
                                    href="{{ route('CategoriaAccesorios', ['precio' => 'BARATO']) }}">Más barato</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Dropdown para ordenar por letra -->
                    <div class="dropdown">
                        <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Ordenar por Letra
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ route('CategoriaAccesorios', ['nombre' => 'ASCENDENTE']) }}">Ascendente</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('CategoriaAccesorios', ['nombre' => 'DESCENDENTE']) }}">Descendente</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('CategoriaAccesorios', ['nombre' => 'TODOS']) }}">Todos</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Formulario de búsqueda -->
                    <form class="d-flex" action="{{ route('CategoriaAccesorios') }}" method="get">
                        <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search"
                            name="buscar" value="{{ session('ProductoBuscar') }}">
                        <button class="btn btn-success" type="submit">Buscar</button>
                    </form>
                </div>
            </div>

            <!-- Contenido de productos -->
            <div class="row">
                @forelse($productos as $producto)
                    <div class="col-md-4 mb-4">
                        <!-- Tarjeta de producto -->
                        <div class="card h-100 shadow producto-card">
                            <a href="{{ route('ShowProducto', ['id' => $producto->id]) }}">
                                <img style="height: 250px; object-fit: cover;" class="card-img-top"
                                    src="{{ asset($producto->Imagen) }}" alt="{{ $producto->nombre }}">
                            </a>
                            <div class="card-body">
                                <h5 class="h4 card-title text-success" style="height: 34px; overflow: hidden;" title="{{ $producto->nombre }}"><b>{{ $producto->nombre }}</b></h5>
                                <p class="card-text" style="height: 50px; overflow: hidden;">{{ $producto->descripcion }}
                                </p>
                                <a class="h5 text-decoration-none text-left">Categoria: <span
                                        style="color: #008410;"><b>{{ $producto->categoria }}</b></span></a>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <p class="h4 text-danger mb-0"><b>Lps {{ $producto->precio }}</b></p>
                                <div class="d-flex">

                                    <!-- Logo Corazon -->
                                    <!-- H. SANDY -->
                                    <form action="{{ route('AgregarFavorito', ['producto' => $producto->id]) }}"
                                        method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success"><i class="far fa-heart"></i></button>
                                    </form>
                                    <!-- H. SANDY -->

                                    <!-- Logo Ojito -->
                                    <!-- H. KELEN -->
                                    <a href="{{ route('ShowProducto', ['id' => $producto->id]) }}"
                                        class="btn btn-success mx-2"><i class="far fa-eye"></i></a>
                                    <!-- H. KELEN -->
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Mensaje si no hay productos -->
                    <div class="col-md-12">
                        <div class="text-center my-5">
                            <h2 class="display-4 text-muted">¡Oh no!</h2>
                            <p class="lead">No hay productos disponibles por el momento.</p>
                            <p>Explora nuestra tienda y encuentra productos increíbles.</p>
                            <a href="{{ route('Tienda') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-shopping-cart"></i> Ir de compras
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- INCIO PAGINACION -->
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
                                href="{{ route('CategoriaAccesorios', ['page' => $page]) }}">{{ $page }}</a>
                        </li>
                    @endfor

                </ul>
            </div>
            <!-- FIN PAGINACION -->
        </div>

    </section>
@endsection
