@extends('Navbar')

@section('titulo', 'Inicio')

@section('todo')

    <style>
        .custom-bg {
            background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
            background-size: cover;
        }

        .custom-bg2 {
            background-color: #dbfcda;
        }
    </style>

    <!-- Sección de Categorías -->
    <section class="custom-bg">
        <div class="container py-5">
            <div class="row text-center pt-3">
                <div class="col-lg-12">
                    <h1 class="display-4 text-success"><b>CATEGORÍAS</b></h1>
                    <p class="lead">
                        Bienvenido a un mundo de opciones, donde cada categoría cuenta una historia única de estilo,
                        rendimiento y satisfacción.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-4 p-4 mt-3">
                    <a href="{{ route('CategoriaRopa') }}"><img src="{{ $ImagenRopa }}"
                            class="rounded-circle img-fluid border border-success"></a>
                    <h5 class="text-center mt-3 mb-3 display-6 text-success"><b>ROPA</b></h5>
                </div>

                <div class="col-12 col-md-4 p-4 mt-3">
                    <a href="{{ route('CategoriaAccesorios') }}"><img src="{{ $ImagenAccesorios }}"
                            class="rounded-circle img-fluid border border-success"></a>
                    <h5 class="text-center mt-3 mb-3 display-6 text-success"><b>ACCESORIOS</b></h5>
                </div>

                <div class="col-12 col-md-4 p-4 mt-3">
                    <a href="{{ route('CategoriaAlimentos') }}"><img src="{{ $ImagenAlimentos }}"
                            class="rounded-circle img-fluid border border-success"></a>
                    <h5 class="text-center mt-3 mb-3 display-6 text-success"><b>ALIMENTOS</b></h5>
                </div>
            </div>
        </div>

        {{-- INICIO ULTIMOS PRODUCTOS AGREGADOS --}}
        <section class="custom-bg2">
            <div class="container py-5 text-center">
                <div class="row">
                    <h1 class="display-4 text-success"><b>Últimos Productos Agregados</b></h1>
                    <p class="lead">Explora nuestros nuevos productos. Estilo y rendimiento excepcionales en cada opción.
                        <br><b>¡Bienvenido a un mundo emocionante de elecciones!</b>
                    </p>
                </div><br>

                <div class="row">
                    @foreach ($ultimosProductos as $producto)
                        <div class="col-12 col-md-4 mb-4">
                            <div class="card h-100">
                                <div>
                                    <a href="{{ route('ShowProducto', ['id' => $producto->id]) }}">
                                        <img style="height: 230px; object-fit: cover;" class="card-img-top"
                                            src="{{ asset($producto->Imagen) }}" alt="{{ $producto->nombre }}">
                                    </a>
                                </div>

                                <div class="card-body d-flex flex-column align-items-center">
                                    <div class="d-inline-block m-2" style="display: inline-block;">

                                        <!-- LOGO CORAZON -->
                                        <form action="{{ route('AgregarFavorito', ['producto' => $producto->id]) }}"
                                            style="display: inline-block;" method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success text-white mx-2"><i
                                                    class="far fa-heart"></i></button>
                                        </form>

                                        <!-- LOGO OJO -->
                                        <a href="{{ route('ShowProducto', ['id' => $producto->id]) }}"
                                            class="btn btn-success text-white mx-2" style="display: inline-block;"><i
                                                class="far fa-eye"></i></a>

                                        <!-- LOGO CARRITO -->
                                        <form action="{{ route('AgregarPedido', ['producto' => $producto->id]) }}"
                                            method="post" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-success text-white mx-2">
                                                <i class="fas fa-cart-plus"></i>
                                            </button>
                                        </form>

                                    </div>
                                    <br>
                                    <a href="{{ route('ShowProducto', ['id' => $producto->id]) }}"
                                        title="{{ $producto->nombre }}" class="h3 text-decoration-none text-success"
                                        style="height: 40px; overflow: hidden;"><b>{{ $producto->nombre }}</b></a>
                                    <span class="h5 text-decoration-none"><b>Lps {{ $producto->precio }}</b></span>
                                    <a class="h5 text-decoration-none text-left">Categoría: <span
                                            style="color: red;"><b>{{ $producto->categoria }}</b></span></a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
        </section>
        {{-- FIN ULTIMOS PRODUCTOS AGREGADOS --}}

    </section>

@endsection
