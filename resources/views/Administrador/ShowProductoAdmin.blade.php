@extends('AdminNavbar')

@section('titulo', 'Descripcion del Producto Aministrador')

@section('Contenido')

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

    <!-- H. JUNIOR -->
    <!-- INICIO SHOW -->
    <section class="custom-bg2">
        <div class="container pb-3">
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
                                <h1 class="h2" style="color: #2f2c79; text-align: justify; width: 590px;"><b>{{ $producto->nombre }}</b></h1>
                                <button type="button" class="btn btn" style="background-color: #dfe7ff;"
                                    onclick="window.location.href='{{ route('usuario.mostrar', ['id' => $producto->usuario_id]) }}'">
                                    <i class="fa-solid fa-shop"></i> Tienda
                                </button>
                            </div>

                            <!-- H. EDUARDO -->
                            <div class="mt-2">
                                <a style="background: #2f2c79; color:white;" class="btn btn">Me Gusta ({{ $likes }})</a>

                                <a style="background: #2f2c79; color:white;" class="btn btn">No me Gusta ({{ $dislikes }})</a>
                            </div>
                            <!-- H. EDUARDO -->

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
                                        href="{{ route('usuario.mostrar', ['id' => $producto->usuario_id]) }}">{{ $producto->usuario->nombre ?? 'Nombre no disponible' }}
                                        {{ $producto->usuario->apellido ?? 'Apellido no disponible' }}</a></p>
                            @else
                                <p>Vendedor no disponible</p>
                            @endif

                            <h6>
                                <b>Description:</b>
                            </h6>
                            <div>
                                <p>{{ $producto->descripcion }}</p>
                            </div>

                            <div class="row pb-3">
                                <div class="d-inline-block col d-grid">
                                <button type="button" class="btn btn-danger btn-lg" data-toggle="modal" data-target="#eliminarProductoModal{{ $producto->id }}">
  ELIMINAR
</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!-- H. JUNIOR -->


    <!-- H. EDUARDO -->
    <!-- INICIO COMENTARIOS -->
    <section class="custom-bg2 py-3">
        <div class="container">

            <div class="py-4">
                <h4 class="display-7 text pb-3"><b>Comentarios ({{ $comentarios->count() }})</b></h4>
                <ul class="list-group list-group-flush">
                    @forelse ($comentarios as $comentario)
                        <li class="list-group-item comment-card d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="comment-avatar mr-3">
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
                            </div>
                            <!-- Botón Eliminar -->
                            <form action="{{ route('EliminarComentarioAdmin', [$comentario->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ml-3">Eliminar</button>
                            </form>
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

    <!-- Modal -->
<div class="modal fade" id="eliminarProductoModal{{ $producto->id }}" tabindex="-1" role="dialog" aria-labelledby="eliminarProductoModalLabel{{ $producto->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminarProductoModalLabel{{ $producto->id }}">¿Estás seguro que quieres eliminar este producto?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Esta acción no se puede deshacer.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <form action="{{ route('producto.borrar', $producto->id) }}" method="POST" id="formEliminar{{ $producto->id }}">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection
