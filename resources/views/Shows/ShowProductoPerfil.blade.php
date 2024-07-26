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
    </style>

    <!-- INICIO SHOW -->
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
                                <h1 class="h2 text-success"><b>{{ $producto->nombre }}</b></h1>
                            </div>

                            <div class="mt-2">
                                <a class="btn btn-success">Me Gusta ({{ $likes }})</a>

                                <a class="btn btn-danger mx-2">No me Gusta ({{ $dislikes }})</a>
                            </div>

                            <p class="h3 py-2"><b>Lps {{ $producto->precio }}</b></p>

                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6><b>Categoria:</b></h6>
                                </li>
                                <li>
                                    <h6>{{ $producto->categoria }}</h6>
                                </li>
                            </ul>

                            <h6>
                                <b>Description:</b>
                            </h6>
                            <div>
                                <p>{{ $producto->descripcion }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- FIN SHOW -->

    <!-- INICIO COMENTARIOS -->
    <section class="custom-bg py-5">
        <div class="container">
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
                                <textarea placeholder="Motivo del Reporte" class="form-control" id="motivo" name="motivo" rows="3" required></textarea>
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

    <!-- Script de Zoom imagen-->
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

@endsection
