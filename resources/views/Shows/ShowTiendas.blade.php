@extends('Navbar')

@section('titulo', 'Ver Usuario')

@section('todo')

    <style>
        section {
            background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
            background-size: cover;
        }

        .profile-container {
            display: flex;
        }

        .profile-sidebar {
            width: 25%;
            padding: 20px;
            background-color: ;
        }

        .profile-content {
            flex: 1;
            padding: 20px;
        }

        .profile-name {
            margin-top: 10px;
        }

        .profile-info {
            margin-bottom: 12px;
        }

        .btn-sm {
            margin-right: 5px;
        }

        .nav-tabs {
            margin-bottom: 20px;
        }

        .product-card {
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .product-title {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .product-description {
            margin-bottom: 20px;
        }

        .product-price {
            font-size: 1.3rem;
        }

        .no-products {
            font-weight: bold;
            color: #dc3545;
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .product-actions a,
        .product-actions button {
            display: inline-block;
            margin-right: 10px;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            /* Centra los botones horizontalmente */
            align-items: center;
            /* Centra los botones verticalmente */
            margin-top: 10px;
        }

        .action-buttons button,
        .action-buttons a {
            display: inline-block;
            margin: 0 5px;
            /* Espaciado entre los botones */
            padding: 10px 15px;
            /* Tamaño de los botones */
        }
    </style>

    @if (session('success') || session('mensaje') || session('error'))
        <div class="alert alert-{{ session('success') ? 'success' : (session('mensaje') ? 'success' : 'danger') }}">
            {{ session('success') ?? (session('mensaje') ?? session('error')) }}
        </div>
    @endif

    <section class="profile-container py-3">
        <div class="profile-sidebar">
            <div class="card">
                <div class="card-header text-center" style="background-color: #e4ffe2;">
                    @if ($usuario->Imagen)
                        <img style="height: 300px; object-fit: cover;" src="{{ asset($usuario->Imagen) }}" alt="Profile Image"
                            class="img-fluid">
                    @endif
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <h4 class="profile-name text-success"><b>{{ $usuario->nombre }} {{ $usuario->apellido }}</b></h4>
                    </div>
                    <p class="profile-info"><b class="text-success">Usuario:</b> {{ $usuario->nombre_usuario }}</p>
                    <p class="profile-info"><b class="text-success">Telefono:</b> {{ $usuario->telefono }}</p>
                    <p class="profile-info"><b class="text-success">Email:</b> {{ $usuario->email }}</p>
                    <button style="width: 305px" type="button" class="btn btn-danger" id="reportarUsuarioModalBtn">
                        <b>Reportar Usuario</b>
                    </button>
                </div>
            </div>
        </div>

        <div class="profile-content">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a class="nav-link active"><b> <span style="color:green">Productos</span> y <span
                                style="color:red">Ofertas</span> Subidos
                            por {{ $usuario->nombre }} {{ $usuario->apellido }} </b></a></li>
            </ul>

            <div class="row mt-3">
                @forelse($usuario->productos as $producto)
                    <div class="col-md-4 mb-4">
                        <div class="card product-card">
                            <img style="height: 200px; object-fit: cover;" class="card-img-top product-image"
                                src="{{ asset($producto->Imagen) }}" alt="Producto Image">
                            <div class="card-body">
                                <div class="product-details">
                                    <h5 class="card-title product-title text-success" title="{{ $producto->nombre }}"
                                        style="height: 34px; width: 200px; overflow: hidden;">
                                        <b>{{ $producto->nombre }}</b>
                                    </h5>
                                    <p class="product-price"><b>Lps {{ $producto->precio }}</b></p>
                                </div>
                                <p class="card-text product-description" style="height: 70px; overflow: hidden;">
                                    {{ $producto->descripcion }}</p>
                                <div class="action-buttons">
                                    <!-- LOGO CORAZON -->
                                    <form action="{{ route('AgregarFavorito', ['producto' => $producto->id]) }}"
                                        method="post">
                                        @csrf
                                        <button style="width: 80px" type="submit" class="btn btn-success text-white mx-2">
                                            <i class="fas far fa-heart"></i>
                                        </button>
                                    </form>

                                    <!-- LOGO OJO -->
                                    <a href="{{ route('ShowProducto', ['id' => $producto->id]) }}"
                                        class="btn btn-success text-white mx-2" style="width: 80px">
                                        <i class="fas far fa-eye"></i>
                                    </a>

                                    <!-- LOGO CORRRITO -->
                                    <form action="{{ route('AgregarPedido', ['producto' => $producto->id]) }}"
                                        method="post">
                                        @csrf
                                        <button style="width: 80px" type="submit" class="btn btn-success text-white mx-2">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p class="no-products">No tiene productos.</p>
                    </div>
                @endforelse

                @forelse($usuario->ofertas as $oferta)
                    <div class="col-md-4 mb-4">
                        <div class="card product-card">
                            <img style="height: 200px; object-fit: cover;" class="card-img-top product-image"
                                src="{{ asset($oferta->Imagen) }}" alt="Producto Image">
                            <div class="card-body">
                                <div class="product-details">
                                    <h5 class="card-title product-title text-danger" title="{{ $oferta->nombre }}"
                                        style="height: 34px; width: 200px; overflow: hidden;"><b>{{ $oferta->nombre }}</b>
                                    </h5>
                                    <p class="product-price text-danger"><b>Lps {{ $oferta->precio }}</b></p>
                                </div>
                                <p class="card-text product-description" style="height: 70px; overflow: hidden;">
                                    {{ $oferta->descripcion }}</p>
                                <div class="action-buttons">
                                    <!-- LOGO CORAZON -->
                                    <form action="{{ route('AgregarFavoritoOferta', ['oferta' => $oferta->id]) }}"
                                        method="post">
                                        @csrf
                                        <button style="width: 80px" type="submit" class="btn btn-success text-white mx-2">
                                            <i class="fas far fa-heart"></i>
                                        </button>
                                    </form>

                                    <!-- LOGO OJO -->
                                    <a href="{{ route('ShowOferta', ['id' => $oferta->id]) }}"
                                        class="btn btn-success text-white mx-2" style="width: 80px">
                                        <i class="fas far fa-eye"></i>
                                    </a>

                                    <!-- LOGO CORRRITO -->
                                    <form action="{{ route('AgregarPedidoOferta', ['oferta' => $oferta->id]) }}"
                                        method="post">
                                        @csrf
                                        <button style="width: 80px" type="submit" class="btn btn-success text-white mx-2">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <p class="no-products">No tiene ofertas.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- INICIO MODAL -->
    <div class="modal" id="reportarUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="reportarUsuarioModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #28a745; color: white;">
                    <h5 class="modal-title" id="reportarUsuarioModalLabel">Reportar Usuario</h5>
                </div>
                <form action="{{ route('reportar.usuario') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <!-- Elimina la etiqueta label y coloca el texto directamente como placeholder -->
                            <textarea class="form-control" id="motivo" name="motivo" rows="3" placeholder="Motivo del Reporte"
                                required></textarea>
                        </div>
                        <input type="hidden" name="usuario_id" value="{{ $usuario->id }}">
                    </div>
                    <div class="modal-footer">
                        <!-- Elimina el botón de cerrar del footer del modal -->
                        <button type="submit" class="btn btn-danger">Enviar Reporte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- FIN MODAL -->

    <!-- JavaScript para manejar el modal -->
    <script>
        $(document).ready(function() {
            // Manejar el click en el botón para abrir el modal
            $('#reportarUsuarioModalBtn').click(function() {
                $('#reportarUsuarioModal').modal('show');
            });

            // Manejar el cierre del modal
            $('#cerrarReportarUsuarioModalBtn').click(function() {
                $('#reportarUsuarioModal').modal('hide');
            });

            // Limpiar el contenido del modal al cerrarlo
            $('#reportarUsuarioModal').on('hidden.bs.modal', function() {
                $(this).find('form').trigger('reset');
            });
        });
    </script>

@endsection
