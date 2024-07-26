@extends('Navbar')

@section('titulo', 'Descripcion del Producto')

@section('todo')

    <style>
        .custom-bg {
            background-color: #dbfcda;
        }

        .custom-bg2 {
            background-color: #f5fff5;
        }

        .zoomed-image {
            transform: scale(2);
            /* Puedes ajustar el valor según la ampliación que desees */
        }

        #product-container {
            position: relative;
        }

        #product-detail {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Añadimos un contenedor adicional para restringir el área de zoom alrededor del mouse */
        #zoom-area {
            position: relative;
            overflow: hidden;
        }

        .cart:hover {
            transform: scale(1.05);
            transition: transform 0.4s;
        }

        .cart:not(:hover) {
            transition: transform 0.4s ease-out;
            transform: scale(1);
            /* Ajusta el valor según tus necesidades */
        }

        .comment-card {
            display: flex;
            align-items: center;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        .comment-avatar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .comment-content {
            flex: 1;
        }

        .comment-username {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .comment-text {
            margin: 0;
        }

        .comment-options {
            position: absolute;
            top: 0;
            right: 0;
            margin: 10px;
        }
    </style>

    <!-- INICIO SHOW -->
    <!-- H. KELEN -->
    <section class="custom-bg2">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5" id="product-container">
                    <!-- Añadimos el contenedor adicional para el área de zoom -->
                    <div id="zoom-area">
                        <div class="card mb-3">
                            <img class="card-img img-fluid" src="{{ asset($producto->Imagen) }}" alt="Product Image"
                                id="product-detail">
                        </div>
                        <!-- Contenedor de la lupa -->
                        <div id="zoom-container"></div>
                    </div>
                </div>
                <div class="col-lg-7 mt-5">
                    <div class="card">
                        <div class="card-body">


                            <div class="d-flex justify-content-between align-items-center">
                                <h1 style="text-align: justify; width: 590px;">
                                    <b>{{ $producto->nombre }}</b>
                                </h1>
                                <button type="button" class="btn btn" style="background-color: #a4ff87; "
                                    onclick="window.location.href='{{ route('vertienda', ['id' => $producto->usuario_id]) }}'">
                                    <i class="fa-solid fa-shop"></i> Tienda
                                </button>
                            </div>

                            <!-- H. ELVIN -->
                            @if (session('usuario'))
                                <div class="mt-2" style="display: flex;">
                                    <form method="POST" action="{{ route('producto.like', $producto->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-thumbs-up"></i> Me Gusta
                                            ({{ $likes }})</button>
                                    </form>

                                    <form method="POST" action="{{ route('producto.dislike', $producto->id) }}" class="mx-2">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="fa-solid fa-thumbs-down"></i> No me Gusta
                                            ({{ $dislikes }})</button>
                                    </form>

                                </div>
                            @endif
                            <!-- H. ELVIN -->

                            <p class="h3 py-2"><b>Lps {{ $producto->precio }}</b></p>

                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6><b>Categoria:</b></h6>
                                </li>
                                <li>
                                    <h6>{{ $producto->categoria }}</h6>
                                </li>
                            </ul>

                            <h6><b>Vendedor:</b></h6>
                            @if ($producto->usuario)
                                <p><a class="text-decoration-none" style="color:black"
                                        href="{{ route('vertienda', ['id' => $producto->usuario_id]) }}">{{ $producto->usuario->nombre ?? 'Nombre no disponible' }}
                                        {{ $producto->usuario->apellido ?? 'Apellido no disponible' }}</a></p>
                            @else
                                <p>Vendedor no disponible</p>
                            @endif

                            <h6 id="toggleDescripcion" onclick="toggleDescripcion()" class="py-1">
                                <b>Descripcion:</b>
                            </h6>
                            <div id="descripcionProducto" style="display: none;">
                                <p>{{ $producto->descripcion }}</p>
                            </div>

                            <div class="row pb-3">
                                <div class="col d-grid">
                                    <form action="{{ route('AgregarPedido', ['producto' => $producto->id]) }}"
                                        method="POST" id="product-form">
                                        @csrf
                                        <input type="hidden" name="product-title" value="Activewear">
                                        <input type="hidden" name="rating" id="rating" value="0">

                                        <h6><b>Cantidad:</b></h6>
                                        <div class="input-group quantity py-2" style="width: 20%;">
                                            <div class="input-group-prepend">
                                                <a class="btn btn-success btn-minus">
                                                    <i class="fa fa-minus"></i>
                                                </a>
                                            </div>
                                            <input class="form-control border-0 text-center quantity-input" value="1"
                                                min="1" name="quantity">
                                            <div class="input-group-append">
                                                <a class="btn btn-success btn-plus">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-lg mt-3" name="submit"
                                            style="width: 100%;" value="addtocard">AÑADIR AL CARRITO</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- H. KELEN -->
    <!-- FIN SHOW -->

    <!-- INICIO PRODUCTOS PARECIDOS -->
    <!-- H. EDUARDO -->
    <section class="custom-bg py-4">
        <div class="container">
            <div class="row text-left p-2 pb-3">
                <h1 class="display-5 text-success"><b>Productos Parecidos</b></h1>
            </div>

            <div id="carousel-related-product">
                <div id="content">
                    <div class="row">
                        @forelse($productos as $productoparecido)
                            <div class="col-md-4 cart">
                                <div class="card mb-4 product-wap rounded-0">
                                    <div>
                                        <a href="{{ route('ShowProducto', ['id' => $productoparecido->id]) }}">
                                            <img style="height: 230px; object-fit: cover;" class="card-img-top"
                                                src="{{ asset($productoparecido->Imagen) }}"
                                                alt="{{ $productoparecido->nombre }}">
                                        </a>
                                    </div>
                                    <div class="card-body d-flex flex-column align-items-center">
                                        <div class="d-inline-block m-2" style="display: inline-block;">

                                            <form
                                                action="{{ route('AgregarFavorito', ['producto' => $productoparecido->id]) }}"
                                                style="display: inline-block;" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-success text-white mx-2"><i
                                                        class="far fa-heart"></i></button>
                                            </form>

                                            <a href="{{ route('ShowProducto', ['id' => $productoparecido->id]) }}"
                                                class="btn btn-success text-white mx-2" style="display: inline-block;"><i
                                                    class="far fa-eye"></i></a>

                                            <a href="{{ route('ShowProducto', ['id' => $productoparecido->id]) }}"
                                                class="btn btn-success text-white mx-2" style="display: inline-block;"><i
                                                    class="fas fa-cart-plus"></i></a>

                                        </div>
                                        <br>
                                        <a href="{{ route('ShowProducto', ['id' => $productoparecido->id]) }}"
                                            class="h3 text-decoration-none text-success"
                                            title="{{ $productoparecido->nombre }}"
                                            style="height: 40px; overflow: hidden;"><b>{{ $productoparecido->nombre }}</b></a>
                                        <span class="h5 text-decoration-none"><b>Lps
                                                {{ $productoparecido->precio }}</b></span>
                                        <a class="h5 text-decoration-none text-left">Categoría: <span
                                                style="color: red;"><b>{{ $productoparecido->categoria }}</b></span></a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="container text-center">
                                <p><b>¡Vaya! Parece que no hay mas Productos en este Momento.</b></p>
                                <p>¡Añade mas producto en la seccion de <b>Añadir Productos</b>!.</p>
                                <a href="{{ route('AñadirProducto') }}" class="btn btn-success btn-lg mt-1">
                                    <i class="fas fa-shopping-cart"></i> Añadir Productos
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- H. EDUARDO -->
    <!-- FIN PRODUCTOS PARECIDOS -->

    <!-- INICIO COMENTARIOS -->
    <!-- H. JUNIOR -->
    <section class="custom-bg2 py-5">
        <div class="container">
            @if (session('usuario'))
                <div>
                    <h4 class="display-7 text pb-3"><b>Agregar Comentario</b></h4>
                    <form action="{{ route('agregar_comentario', $producto->id) }}" method="post">
                        @csrf
                        <div class="form-group pb-3">
                            <textarea name="contenido" rows="2" class="form-control" placeholder="Tu Comentario"></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-success px-3">Agregar Comentario</button>
                        </div>
                    </form>
                </div>
            @else
                <div class="text-center py-4">
                    <p>Por favor, <a href="{{ route('usuario.login') }}" class="text-decoration-none"><b
                                class="text-success">Inicia Sesión</b></a> para dejar un comentario.</p>
                    <a href="{{ route('usuario.login') }}" class="btn btn-success btn-lg mt-1">
                        <i class="fa fa-fw fa-user"></i> Inicia Sesión
                    </a>
                </div>
            @endif

            <div class="py-4">
                <h4 class="display-7 text pb-3"><b>Comentarios ({{ $comentarios->count() }})</b></h4>
                <ul class="list-group list-group-flush">
                    @forelse ($comentarios as $comentario)
                        <li class="list-group-item comment-card">
                            <div class="comment-avatar">
                                <img src="{{ asset($comentario->usuario->Imagen) }}"
                                    alt="{{ $comentario->usuario->nombre_usuario }}">
                            </div>
                            <div class="comment-content">
                                <p class="comment-username">
                                    <!-- Enlace a la tienda del usuario -->
                                    <a href="{{ route('vertienda', ['id' => $comentario->usuario->id]) }}"
                                        class="text-decoration-none text-success">{{ $comentario->usuario->nombre_usuario }}</a>
                                </p>
                                <p class="comment-text">{{ $comentario->contenido }}</p>
                            </div>
                            <div class="comment-options">
                                <div class="dropdown">
                                    <a href="#" class="text-decoration-none text-muted" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i> <!-- Ícono de tres puntos -->
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        @if (session('usuario') && session('usuario')->id == $comentario->usuario->id)
                                            <!-- Si el usuario tiene sesión iniciada y coincide con el autor del comentario -->
                                            <form method="post"
                                                action="{{ route('EliminarComentario', [$comentario->id]) }}">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="dropdown-item btn btn-danger">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @endif
                                        <a class="dropdown-item text-decoration-none text-muted reportar-link"
                                            data-comentario-id="{{ $comentario->usuario->id }}" data-toggle="modal"
                                            data-target="#reportarModal">
                                            Reportar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center bg-light">
                            No hay comentarios aún. <b>¡Sé el primero en comentar!</b>
                        </li>
                    @endforelse
                </ul>
            </div>

        </div>
    </section>
    <!-- H. JUNIOR -->
    <!-- FIN COMENTARIOS -->

    <!-- INICIO MODAL -->
    @if ($comentarios->isNotEmpty())
        <!-- INICIO MODAL -->
        <div class="modal fade" id="reportarModal" tabindex="-1" role="dialog" aria-labelledby="reportarModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #28a745; color: white;">
                        <h5 class="modal-title" id="reportarModalLabel">Reportar Usuario</h5>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('reportar.usuario') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <textarea placeholder="Motivo del Reporte" class="form-control" id="motivo" name="motivo" rows="3"
                                    required></textarea>
                            </div>
                            <!-- Cambia $comentario->usuario->id por $usuario->id según lo necesites -->
                            <input type="hidden" name="usuario_id" value="{{ $comentarios->first()->usuario->id }}">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Enviar Reporte</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIN MODAL -->
    @endif
    <!-- FIN MODAL -->

    <!-- Inicio Script de Descripcion  -->
    <script>
        function toggleDescripcion() {
            var descripcionProducto = document.getElementById('descripcionProducto');

            if (descripcionProducto.style.display === 'none' || descripcionProducto.style.display === '') {
                descripcionProducto.style.display = 'block';
            } else {
                descripcionProducto.style.display = 'none';
            }

            // Evitar que el enlace redireccione
            return false;
        }
    </script>
    <!-- Fin Script de Descripcion  -->

    <!-- Inicio Script de Zoom imagen-->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var productContainer = document.getElementById('product-container');
            var productImage = document.getElementById('product-detail');
            var zoomContainer = document.getElementById('zoom-container');

            productContainer.addEventListener('mousemove', function(e) {
                var containerOffset = productContainer.getBoundingClientRect();
                var containerWidth = productContainer.clientWidth;
                var containerHeight = productContainer.clientHeight;

                var mouseX = e.pageX - containerOffset.left;
                var mouseY = e.pageY - containerOffset.top;

                if (mouseX >= 0 && mouseX <= containerWidth && mouseY >= 0 && mouseY <= containerHeight) {
                    var percentX = mouseX / containerWidth;
                    var percentY = mouseY / containerHeight;

                    productImage.style.transformOrigin = percentX * 100 + '% ' + percentY * 100 + '%';

                    // Actualiza la posición de la lupa
                    zoomContainer.style.left = mouseX - zoomContainer.clientWidth / 2 + 'px';
                    zoomContainer.style.top = mouseY - zoomContainer.clientHeight / 2 + 'px';

                    productImage.classList.add('zoomed-image');
                    zoomContainer.style.display = 'block';
                } else {
                    productImage.classList.remove('zoomed-image');
                    zoomContainer.style.display = 'none';
                }
            });

            productContainer.addEventListener('mouseleave', function() {
                productImage.classList.remove('zoomed-image');
                zoomContainer.style.display = 'none';
            });
        });
    </script>
    <!-- Fin Script de Zoom imagen-->

    <!-- Inicio Script de Modal-->
    <script>
        $(document).ready(function() {
            $('.reportar-link').click(function(e) {
                e.preventDefault();
                var comentarioId = $(this).data('comentario-id');
                $('#reportarModal').modal('show');
                $('#usuario_id').val(comentarioId);
            });

            $('#cerrarReportarUsuarioModalBtn').click(function() {
                $('#reportarModal').modal('hide');
            });
        });
    </script>
    <!-- Inicio Script de Modal-->

    <!-- Inicio Script de cantidad-->
    <script>
        document.querySelectorAll('.btn-minus').forEach(button => {
            button.addEventListener('click', () => {
                const input = button.parentElement.parentElement.querySelector('.quantity-input');
                let value = parseInt(input.value);
                if (value > 1) {
                    value--;
                    input.value = value;
                }
            });
        });

        document.querySelectorAll('.btn-plus').forEach(button => {
            button.addEventListener('click', () => {
                const input = button.parentElement.parentElement.querySelector('.quantity-input');
                let value = parseInt(input.value);
                value++;
                input.value = value;
            });
        });
    </script>
    <!-- Fin Script de cantidad-->

@endsection
