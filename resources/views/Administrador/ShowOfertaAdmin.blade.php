@extends('AdminNavbar')

@section('titulo', 'Descripcion de la Oferta Aministrador')

@section('Contenido')

    <!-- H. EDUARDO -->
    <style>
        .custom-bg2 {
            background-color: #e2ebff;
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
        <div class="container ">
            <div class="row">
                <div class="col-lg-5 mt-5" id="product-container">
                    <!-- Añadimos el contenedor adicional para el área de zoom -->
                    <div id="zoom-area">
                        <div class="card mb-3">
                            <img class="card-img img-fluid" src="{{ asset($oferta->Imagen) }}" alt="Product Image"
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
                                <h1 class="h2" style="color: #2f2c79; text-align: justify; width: 590px;">
                                    <b>{{ $oferta->nombre }}</b></h1>
                                <button type="button" class="btn btn" style="background-color: #dfe7ff;"
                                    onclick="window.location.href='{{ route('usuario.mostrar', ['id' => $oferta->usuario_id]) }}'">
                                    <i class="fa-solid fa-shop"></i> Tienda
                                </button>
                            </div>

                            <div class="mt-2">
                                <a style="background: #2f2c79; color:white;" class="btn btn">Me Gusta
                                    ({{ $likes }})</a>

                                <a style="background: #2f2c79; color:white;" class="btn btn">No me Gusta
                                    ({{ $dislikes }})</a>
                            </div>

                            <p class="h3 py-2 text-danger"><b>Lps {{ $oferta->precio }}</b></p>

                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6><b>Categoria:</b></h6>
                                </li>
                                <li>
                                    <h6>{{ $oferta->categoria }}</h6>
                                </li>
                            </ul>

                            <h6><b>Vendedor:</b></h6>
                            @if ($oferta->usuario)
                                <p><a class="text-decoration-none" style="color:black"
                                        href="{{ route('usuario.mostrar', ['id' => $oferta->usuario_id]) }}">{{ $oferta->usuario->nombre ?? 'Nombre no disponible' }}
                                        {{ $oferta->usuario->apellido ?? 'Apellido no disponible' }}</a></p>
                            @else
                                <p>Vendedor no disponible</p>
                            @endif

                            <h6>
                                <b>Description:</b>
                            </h6>
                            <div>
                                <p>{{ $oferta->descripcion }}</p>
                            </div>

                            <div class="row pb-3">
                                <div class="d-inline-block col d-grid">
                                    <form action="{{ route('oferta.borrar1', $oferta->id) }}" method="POST"
                                        id="formEliminar{{ $oferta->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <div class="row">
                                            <div class="col d-grid">
                                                <button type="submit" class="btn-danger btn-lg" name="submit"
                                                    value="addtocard">ELIMINAR</button>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- FIN SHOW -->

    <!-- INICIO COMENTARIOS -->
    <section class="custom-bg2 py-3">
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
                                    <a href="{{ route('usuario.mostrar', ['id' => $comentario->usuario->id]) }}"
                                        style="color: #2f2c79"
                                        class="text-decoration-none">{{ $comentario->usuario->nombre_usuario }}</a>
                                </p>
                                <p class="comment-text">{{ $comentario->contenido }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center bg-light">
                            <b>No hay comentarios aún.</b>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </section>
    <!-- FIN COMENTARIOS -->

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
    <!-- H. EDUARDO -->


@endsection
