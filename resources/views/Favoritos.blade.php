@extends('Navbar')

@section('titulo', 'Favoritos')

@section('todo')

    @if (session('usuario'))

        <style>
            .custom-bg {
                background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
                background-size: cover;
                padding: 50px;
                /* Ajusta el espacio interno según tus necesidades */
            }

            .favorito-card {
                height: 100%;
            }

            .card:hover {
                transform: scale(1.05);
                transition: transform 0.4s;
            }

            .card:not(:hover) {
                transition: transform 0.4s ease-out;
                transform: scale(1);
                /* Ajusta el valor según tus necesidades */
            }
        </style>

        <section class="custom-bg py-5">
            <div class="text-center mb-5">
                <h1 class="display-3 text-success"><b>Explora tus Favoritos</b></h1>
                <p class="lead">Encuentra los productos que te encantan y agrégales a tu lista de favoritos.</p>
            </div>

            <div id="content" class="row">
                @forelse($favoritos as $favorito)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow favorito-card">
                            <a href="{{ route('ShowFavorito', ['id' => $favorito->id]) }}">
                                <img style="height: 250px; object-fit: cover;" class="card-img-top"
                                    src="{{ asset($favorito->Imagen) }}" alt="{{ $favorito->nombre }}">
                            </a>
                            <div class="card-body d-flex flex-column justify-content-between">
                                <a class="display-6 text-center text-success text-decoration-none"
                                    style="height: 55px; overflow: hidden;"
                                    title="{{ $favorito->nombre }}"><b>{{ $favorito->nombre }}</b></a>
                                <p class="card-text" style="height: 55px; overflow: hidden;">{{ $favorito->descripcion }}
                                </p>
                                <div class="text-center">
                                    <p class="h4 text-danger mb-4"><b>Lps {{ $favorito->precio }}</b></p>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('ShowFavorito', ['id' => $favorito->id]) }}"
                                            class="btn btn-success mx-2" role="button">
                                            <i class="far fa-eye"></i> Ver
                                        </a>
                                        <form action="{{ route('AgregarPedidoFavorito', ['favorito' => $favorito->id]) }}"
                                            method="post">
                                            @csrf
                                            <button type="submit" class="btn btn-success mx-2"><i
                                                    class="fas fa-cart-plus"></i>
                                                Carrito</button>
                                        </form>
                                        <form method="post" action="{{ route('EliminarFavorito', [$favorito->id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger mx-2"><i class="fa fa-trash"></i>
                                                Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center my-3 mb-5">
                        <h2 class="display-4 text-muted">¡Oh no!</h2>
                        <p class="lead">No tienes favoritos por el momento.</p>
                        <p>Explora nuestra tienda y encuentra productos increíbles.</p>
                        <a href="{{ route('Tienda') }}" class="btn btn-success btn-lg mt-3">
                            <i class="fas fa-shopping-cart"></i> Ir de compras
                        </a>
                    </div>
                @endforelse
            </div>
        </section>

    @endif
@endsection
