@extends('AdminNavbar')

@section('titulo', 'Lista de Registros')

@section('Contenido')

    <!-- H. EDUAROD -->
    <style>
        section {
            background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
            background-size: cover;
        }

        .page-link {
            color: rgb(61, 69, 80);
            border-color: rgb(61, 69, 80);
        }

        .pagination-item {
            margin-right: 15px;
        }

        .page-item.active .page-link {
            background-color: rgb(61, 69, 80);
            border-color: rgb(61, 69, 80);
        }

        .page-link:hover {
            background-color: rgba(61, 69, 80, 0.8);
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
            vertical-align: middle;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-custom {
            margin-right: 10px;
            color: rgb(61, 69, 80);
        }

        .btn-danger-custom {
            margin-right: 10px;
        }

        .search-input {
            flex-grow: 1;
            min-width: 200px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        .full-screen {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }
    </style>

    <section class="custom-bg2 @if ($registros->isEmpty()) full-screen @endif">
        <div class="container py-5">

            <h1 style="color:rgb(61, 69, 80); font-size:50px; font: sans-serif;"><b>REGISTROS</b></h1>

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
                    <form class="d-flex" action="{{ route('registroslist') }}" method="get">
                        <input class="form-control me-2 search-input" type="search" placeholder="Buscar"
                            aria-label="Search" name="buscar" value="{{ session('RegistroBuscar') }}">
                        <button class="btn btn" type="submit"
                            style="background-color: #2f2c79; color:white">Buscar</button>
                    </form>
                </div>
            </div>

            <div class="product-table">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Dueño ID</th>
                                <th scope="col">Dueño</th>
                                <th scope="col">Comprador ID</th>
                                <th scope="col">Comprador</th>
                                <th scope="col">Producto</th>
                                <th scope="col">Descripción del Pedido</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Fecha de Creación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($registros as $registro)
                                <tr>
                                    <td>{{ $registro->usuario_id }}</td>
                                    <td>{{ $registro->usuario->nombre_usuario }}</td>
                                    <td>{{ $registro->comprador_id }}</td>
                                    <td>{{ $registro->comprador->nombre_usuario }}</td>
                                    <td>{{ $registro->pedido }}</td>
                                    <td>
                                        @if (!empty($registro->descripcion_pedido))
                                            {{ $registro->descripcion_pedido }}
                                        @else
                                            No hay descripción
                                        @endif
                                    </td>
                                    <td>{{ $registro->cantidad }}</td>
                                    <td>{{ $registro->created_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">NO HAY REGISTROS</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <ul class="pagination pagination-lg justify-content-end py-3" id="pagination">
                {{-- Enlaces de paginación para registros --}}
                @php
                    $currentPage = $registros->currentPage();
                    $totalPages = $registros->lastPage();
                    $range = 3;
                    $start = max(1, $currentPage - floor($range / 2));
                    $end = min($start + $range - 1, $totalPages);
                    $start = max(1, min($totalPages - $range + 1, $start));
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    <li class="page-item pagination-item @if ($page == $currentPage) active @endif">
                        <a class="page-link  shadow-sm  text-dark @if ($page == $currentPage) text-white @endif"
                            href="{{ route('registroslist', ['page' => $page]) }}">{{ $page }}</a>
                    </li>
                @endfor
            </ul>

        </div>
    </section>
    <!-- H. EDUAROD -->

@endsection
