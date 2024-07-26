@extends('Navbar')

@section('titulo', 'Descripcion del Favorito')

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
    </style>

    <section class="custom-bg2">
        <div class="container pb-5">
            <div class="row">
                <div class="col-lg-5 mt-5" id="product-container">
                    <!-- Añadimos el contenedor adicional para el área de zoom -->
                    <div id="zoom-area">
                        <div class="card mb-3">
                            <img class="card-img img-fluid" src="{{ asset($favorito->Imagen) }}" alt="Product Image"
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
                                <h1 class="h2 text-success"><b>{{ $favorito->nombre }}</b></h1>
                                <button type="button" class="btn btn" style="background-color: #a4ff87;"
                                    onclick="window.location.href='{{ route('vertienda', ['id' => $favorito->usuario_id]) }}'">
                                    <i class="fa-solid fa-shop"></i> Tienda
                                </button>
                            </div>

                            <div class="mt-1">
                                <button class="btn btn-success" onclick="sendVote('like')" id="likeBtn">
                                    <i class="fas fa-thumbs-up"></i> Like
                                </button>
                                <span id="likesCount">{{ $favorito->likes }}</span> <!-- Mostrará el número de likes -->

                                <button class="btn btn-danger" onclick="sendVote('dislike')" id="dislikeBtn">
                                    <i class="fas fa-thumbs-down"></i> Dislike
                                </button>
                                <span id="dislikesCount">{{ $favorito->dislikes }}</span>
                                <!-- Mostrará el número de dislikes -->

                                <span id="likeState" style="display:none;"></span> <!-- Mostrará el estado de "like" -->
                            </div>

                            <p class="h3 py-2 text-danger"><b>Lps {{ $favorito->precio }}</b></p>

                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <h6><b>Categoria:</b></h6>
                                </li>
                                <li>
                                    <h6>{{ $favorito->categoria }}</h6>
                                </li>
                            </ul>

                            <h6><b>Vendedor:</b></h6>
                            @if ($favorito->usuario)
                                <p>{{ $favorito->usuario->nombre ?? 'Nombre no disponible' }}
                                    {{ $favorito->usuario->apellido ?? 'Apellido no disponible' }}
                                </p>
                            @else
                                <p>Vendedor no disponible</p>
                            @endif

                            <h6 id="toggleDescripcion" onclick="toggleDescripcion()">
                                <b>Description:</b>
                            </h6>
                            <div>
                                <p>{{ $favorito->descripcion }}</p>
                            </div>

                            <div class="row pb-3">
                                <div class="col d-grid">
                                    <form action="{{ route('AgregarPedidoFavorito', ['favorito' => $favorito->id]) }}"
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
    <br>

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
