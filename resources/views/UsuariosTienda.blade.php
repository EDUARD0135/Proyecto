@extends('Navbar')

@section('titulo', 'Tiendas')

@section('todo')

<style>
    /* Estilo de fondo personalizado */
    .custom-bg {
        background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
        background-size: cover;
        padding: 35px 0;
        /* Agregar espacio en la parte superior e inferior */
    }

    /* Estilo para los elementos de paginación */
    .pagination-item {
        margin-right: 20px;
    }

    /* Estilo para la tarjeta de usuario */
    .user-card {
        transition: transform 0.3s ease;
        /* Transición suave al pasar el ratón sobre la tarjeta */
    }

    .user-card:hover {
        transform: translateY(-5px);
        /* Elevación sutil al pasar el ratón sobre la tarjeta */
    }

    /* Estilo para el título de la tarjeta */
    .card-header {
    background-color: #28a745; /* Color de fondo */
    color: white; /* Color del texto */
    padding: 10px;
    border-radius: 0; /* Bordes redondeados */
    margin-bottom: 0; /* Eliminar margen inferior */
    margin-top: 0px; /* Agregar margen superior */
    }

    /* Estilo para el cuerpo de la tarjeta */
    .card-body {
        padding: 10px;
    }

    .card-body p {
        margin-bottom: 7px;
        /* Reducir el margen inferior de los elementos <p> */
        font-size: 17px;
        /* Tamaño de fuente deseado */
    }

    /* Estilo para el texto del cuerpo de la tarjeta */
    .card-text {
        margin-bottom: 10px;
    }
</style>

<section class="custom-bg">
    <div class="container">

        <div class="text-center mb-4">
            <h1 class="display-4 text-success"><b>Explora las Tiendas</b></h1>
            <p class="lead">¡Descubre joyas escondidas mientras te sumerges en un mundo de opciones y diversión!</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('UsuariosTienda') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" placeholder="Buscar usuarios...">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit"><i class="fas fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row">
            @forelse ($usuarios as $usuario)
            <div class="col-md-6">
                <div class="user-card mb-4">
                    <div class="card shadow">
                        <div class="row">
                            <div class="col-md-6">
                            <a href="{{ route('vertienda', ['id' => $usuario->id]) }}">
                                <img style="width: 330px; height: 205px; object-fit: cover;" class="card-img-top" src="{{ asset($usuario->Imagen) }}" alt="{{ $usuario->nombre }}">
                            </a>
                            </div>
                            <div class="col-md-6">
                                <div class="card-header">
                                    <h5 class="card-title"><b>{{ $usuario->nombre_usuario }}</b></h5>
                                </div>
                                <div class="card-body">
                                    <p class="text-success"><b>Email:</b></p>
                                    <p>{{ $usuario->email }}</p>
                                    <p class="text-success"><b>Telefono:</b></p>
                                    <p>{{ $usuario->telefono }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center my-3 mb-5">
                <h2 class="display-4 text-muted">¡Oh no!</h2>
                <p class="lead">No ahi Tiendas Por los Momentos.</p>
                <p>Explora nuestra tienda y encuentra productos increíbles.</p>
                <a href="{{ route('Tienda') }}" class="btn btn-success btn-lg mt-3">
                    <i class="fas fa-shopping-cart"></i> Ir de compras
                </a>
            </div>
            @endforelse
        </div>

        <!-- INCIO PAGINACION -->
        <div class="row py-4">
            {{-- Enlaces de paginación para $usuarios --}}
            <ul class="pagination pagination-lg justify-content-end" id="pagination">

                {{-- Mostrar enlaces de páginas --}}
                @php
                // Página actual
                $currentPage = $usuarios->currentPage();

                // Rango total de páginas a mostrar
                $totalPages = $usuarios->lastPage();

                // Rango de páginas a mostrar (máximo 4)
                $range = 3;

                // Calcula el inicio y fin del rango de páginas
                $start = max(1, $currentPage - floor($range / 2));
                $end = min($start + $range - 1, $totalPages);

                // Ajusta el inicio si el rango es menor a 4
                $start = max(1, min($totalPages - $range + 1, $start));
                @endphp

                @for ($page = $start; $page <= $end; $page++) <li class="page-item pagination-item @if ($page == $currentPage) active @endif">
                    <a class="page-link  shadow-sm  text-dark @if ($page == $currentPage) bg-success text-white @endif" href="{{ route('UsuariosTienda', ['page' => $page]) }}">{{ $page }}</a>
                    </li>
                    @endfor

            </ul>
        </div>
        <!-- FIN PAGINACION -->

    </div>
</section>

@endsection