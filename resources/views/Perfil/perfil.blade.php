@extends('Navbar')

@section('titulo', 'Perfil de Usuario')

@section('todo')

<style>
    /* Estilos generales */
    .custom-bg2 {
        background-color: #f5fff5;
    }

    /* Estilos de perfil */
    .profile {
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .profile-cover img {
        width: 100%;
        height: 230px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .profile-avatar img {
        width: 240px;
        height: 240px;
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #ffffff;
        margin-top: -110px;
    }

    .profile-details h2 {
        margin-bottom: 10px;
        color: #343a40;
    }

    .profile-actions {
        margin-top: 20px;
    }

    .profile-actions a {
        margin-right: 10px;
    }

    /* Estilos de pestañas de navegación */
    .profile-tabs {
        border-bottom: 1px solid #dee2e6;
        margin-top: 20px;
    }

    .profile-tabs .nav-item {
        margin-right: 10px;
    }

    .profile-tabs .nav-link {
        color: #495057;
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 5px;
    }

    .profile-tabs .nav-link.active {
        background-color: #28a745;
        color: #ffffff;
    }

    /* Estilo para el contenedor de productos */
    .product-container {
        margin: 20px 0;
    }


    /* Estilo para la tarjeta de producto */
    .product-card {
        width: 400px;
        padding: 15px;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        overflow: hidden;
        transition: box-shadow 0.3s;
        background-color: #fff;
        margin-right: 32px;
        /* Espaciado entre tarjetas de producto */
    }

    /* Estilo para la imagen del producto */
    .product-image {
        width: 100%;
        height: 230px;
        object-fit: cover;
        border-radius: 10px;
    }

    /* Estilo para los detalles del producto */
    .product-details {
        margin-top: 15px;
    }

    /* Estilo para el título del producto */
    .product-title {
        font-size: 25px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* Estilo para la descripción del producto */
    .product-description {
        font-size: 30px color: #6c757d;
        height: 45px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    /* Estilo para la categoría del producto */
    .product-category {
        font-size: 20px;
        color: #6c757d;
        margin-bottom: 5px;
    }

    /* Estilo para el precio del producto */
    .product-price {
        font-size: 20px;
        font-weight: bold;
        color: red;
    }

    /* Estilo para las acciones del producto */
    .product-actions {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }

    /* Estilo para los enlaces dentro de las acciones del producto */
    .product-actions a {
        text-decoration: none;
        color: #fff;
        padding: 8px 15px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    /* Estilo para el botón de edición en las acciones del producto */
    .product-actions .btn-edit {
        background-color: #007bff;
    }

    .btn {
        font-size: 14px;
        /* Ajusta el tamaño del texto del botón según tus necesidades */
    }

    /* Estilo para el botón de ofertas en las acciones del producto */
    .product-actions .btn-offers {
        background-color: #ffc107;
        /* Color amarillo */
        color: #fff;
        /* Color del texto */
        border: 5px solid #ffc107;
        /* Borde del botón */
    }

    .product-card:hover {
        transform: scale(1.05);
        transition: transform 0.4s;
    }

    .product-card:not(:hover) {
        transition: transform 0.4s ease-out;
        transform: scale(1);
        /* Ajusta el valor según tus necesidades */
    }
</style>

<section class="custom-bg2">
    <div class="container">
        @if (session('usuario'))

        <div class="profile text-center">
            <div class="profile-cover">
                <img src="{{ $ImagenFondo }}" alt="Cover Image" class="img-fluid">
            </div>
            <div class="profile-avatar">
                <img src="{{ asset(session('usuario')->Imagen) }}" alt="Profile Image" class="img-fluid rounded-circle">
            </div>
            <div class="profile-details mt-3">
                <h2 class="display-6 pb-3"><b>{{ session('usuario')->nombre }}
                        {{ session('usuario')->apellido }}</b></h2>
            </div>

            {{-- Botones de acciones --}}
            <div class="profile-actions mt-3">
                <a href="{{ route('usuario.edit', ['id' => session('usuario')->id]) }}" class="btn btn-primary btn-editar">Editar Perfil</a>
                <a href="{{ route('AñadirProducto') }}" class="btn btn-success btn-añadir">Añadir Producto</a>
                <a type="button" class="btn btn-danger btn-cerrar-sesion" href="#" data-toggle="modal" data-target="#modalCerrarSesion">Cerrar Sesión</a>
            </div>
        </div>

        <h1 class="display-6 text-success py-4"><b>Productos</b></h1>

        {{-- Contenido de Productos --}}
        <div id="content" class="col-md-12 mb-4">
            <div class="product-container d-flex flex-wrap">
                @forelse($productos as $producto)
                <div class="product-card col-md-4 mb-4">
                    <img class="product-image" src="{{ asset($producto->Imagen) }}" alt="{{ $producto->nombre }}">
                    <div class="product-details">
                        <h5 class="product-title" style="height: 36px; overflow: hidden;"><a href="{{ route('ShowProductoPerfil', ['id' => $producto->id]) }}" class="text-decoration-none text-success" title="{{ $producto->nombre }}">{{ $producto->nombre }}</a></h5>
                        <p class="product-description">{{ $producto->descripcion }}</p>
                        <p class="product-category">Categoría: <span style="color: #008410;"><b>{{ $producto->categoria }}</b></span></p>
                        <p class="product-price">Lps {{ $producto->precio }}</p>
                        <div class="product-actions">
                            <a href="{{ route('producto.edit', ['id' => $producto->id]) }}" class="btn btn-info btn-edit"><i class="fa-solid fa-pen-to-square"></i>
                                Editar</a>
                            <a href="{{ route('ShowProductoPerfil', ['id' => $producto->id]) }}" class="btn btn-success btn-view"><i class="fa fa-eye"></i> Ver</a>
                            <a type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#modalEliminarProducto{{ $producto->id }}"><i class="fa fa-trash"></i> Eliminar</a>
                            <form action="{{ route('AgregarOferta', ['producto' => $producto->id]) }}" method="post">
                                @csrf
                                <button type="button" class="btn btn-offers text-white" data-toggle="modal" data-target="#modalCambiarPrecioOferta">
                                    <i class="fa-solid fa-envelopes-bulk"></i> <b>Oferta</b>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12 text-center mt-1">
                    <div class="alert alert-info">
                        <strong>¡Oops!</strong> Parece que aún no tienes ningún producto registrado.
                    </div>
                    <p class="lead">¿Por qué no pruebas a añadir uno ahora?</p>
                    <a href="{{ route('AñadirProducto') }}" class="btn btn-success btn-lg">Añadir Producto</a>
                </div>
                @endforelse
            </div>
        </div>

        <h1 class="display-6 text-success"><b>Ofertas</b></h1>

        {{-- Contenido de Ofertas --}}
        <div id="content" class="col-md-12 mb-4">
            <div class="product-container d-flex flex-wrap">
                @forelse($ofertas as $oferta)
                <div class="product-card col-md-4 mb-4">
                    <img class="product-image" src="{{ asset($oferta->Imagen) }}" alt="{{ $oferta->nombre }}">
                    <div class="product-details">
                        <h5 class="product-title" style="height: 36px; overflow: hidden;"><a href="{{ route('ShowOfertaPerfil', ['id' => $oferta->id]) }}" class="text-decoration-none text-success" title="{{ $oferta->nombre }}">{{ $oferta->nombre }}</a></h5>
                        <p class="product-description">{{ $oferta->descripcion }}</p>
                        <p class="product-category">Categoría: <span style="color: #008410;"><b>{{ $oferta->categoria }}</b></span></p>
                        <p class="product-price">Lps {{ $oferta->precio }}</p>
                        <div class="product-actions">
                            <a href="{{ route('ShowOfertaPerfil', ['id' => $oferta->id]) }}" class="btn btn-success btn-view"><i class="fa fa-eye"></i> Ver</a>
                            <a type="button" class="btn btn-danger btn-delete" data-toggle="modal" data-target="#modalEliminarOferta{{ $oferta->id }}"><i class="fa fa-trash"></i> Eliminar</a>
                            <form action="{{ route('AgregarProductoPerfil', ['oferta' => $oferta->id]) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-offers text-white"><i class="fa-solid fa-envelopes-bulk"></i> <b>Producto</b></button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-md-12 text-center mt-1">
                    <div class="alert alert-danger">
                        <strong>¡Oops!</strong> Parece que aún no tienes ninguna Oferta.
                    </div>
                    @endforelse
                </div>
            </div>

            @endif
        </div>
        <br>

        {{-- Modales --}}
         <!-- Modal Cerrar Sesión -->
        <div class="modal fade" id="modalCerrarSesion" tabindex="-1" role="dialog" aria-labelledby="modalCerrarSesionLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #28a745; color: white;">
                        <h5 class="modal-title" id="modalCerrarSesionLabel">Cerrar Sesión</h5>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que quieres cerrar sesión?
                    </div>
                    <div class="modal-footer">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <a class="btn btn-danger" href="#" onclick="document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Eliminar Producto -->
        @forelse($productos as $producto)
        <div class="modal fade" id="modalEliminarProducto{{ $producto->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEliminarProductoLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #28a745; color: white;">
                        <h5 class="modal-title" id="modalEliminarProductoLabel">Eliminar Producto</h5>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que quieres eliminar este producto?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form action="{{ route('productos.destroy', ['producto' => $producto->id]) }}" method="post" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar Producto</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        @endforelse

        <!-- Modal Eliminar Producto -->
        @forelse($ofertas as $oferta)
        <div class="modal fade" id="modalEliminarOferta{{ $oferta->id }}" tabindex="-1" role="dialog" aria-labelledby="modalEliminarOfertaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #dc3545; color: white;">
                        <h5 class="modal-title" id="modalEliminarOfertaLabel">Eliminar Oferta</h5>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que quieres eliminar esta oferta?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form action="{{ route('EliminarOferta', [$oferta->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar Oferta</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @empty
        @endforelse

        <!-- Modal para cambiar el precio de la oferta -->
        @forelse($productos as $producto)
        <div class="modal fade" id="modalCambiarPrecioOferta" tabindex="-1" role="dialog" aria-labelledby="modalCambiarPrecioOfertaLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #28a745; color: white;">
                        <h5 class="modal-title" id="modalCambiarPrecioOfertaLabel">Cambiar Precio de la Oferta</h5>
                    </div>
                    <form action="{{ route('AgregarOferta', ['producto' => $producto->id]) }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="precio" style="margin-bottom: 10px"><b>Nuevo Precio:</b></label>
                                <input type="number" class="form-control" id="precio" name="precio" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @empty
        @endforelse


</section>

<script>
    // Agrega este script al final del archivo o en la sección de <script> de tu HTML
    $(document).ready(function() {
        // Inicializa los modales
        $('#modalCerrarSesion').modal();
        @forelse($productos as $producto)
        $('#modalEliminarProducto{{ $producto->id }}').modal();
        @empty
        @endforelse
    });
</script>

@endsection