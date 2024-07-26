@extends('Navbar')

@section('titulo', 'Pedidos')

@section('todo')

    @if (session('usuario'))

        <style>
            .custom-bg {
                background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
                background-size: cover;
                padding: 50px;
            }

            .pedido-container {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
                margin-top: 20px;
            }

            .pedido-table {
                width: 95%;
                /* Ajusta el ancho de la tabla según tu preferencia */
                border-collapse: collapse;
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .pedido-table th,
            .pedido-table td {
                border: 1px solid #ddd;
                padding: 10px;
            }

            .pedido-table th {
                color: white;
                position: sticky;
                top: 0;
                background-color: #4CAF50;
            }

            .product-image {
                height: 80px;
                object-fit: cover;
            }

            .wide-column {
                width: 150px;
            }

            .quantity-input {
                width: 50px;
                text-align: center;
            }

            .btn-delete {
                background-color: #ff5c5c;
                color: white;
            }

            .total-row {
                font-weight: bold;
                background-color: #f2f2f2;
            }

            .total-cell {
                text-align: center;
            }
        </style>

        <!-- TABLA PEDIDO -->
        <section class="custom-bg py-5 mb-5-custom">
            <div class="container text-center mb-4">
                <h1 class="display-3 text-success"><b>Tus Pedidos</b></h1>
                <p class="lead">Revisa los productos que has pedido.</p>
            </div>

            <div class="pedido-container">
                @forelse($pedidos->groupBy('usuario_id') as $usuarioPedidos)
                    <table class="pedido-table">
                        <thead>
                            <tr>
                                <th colspan="6" style="color: green; font-size: 20px; background-color: #fff;">
                                    <span style="color: black;">Dueño del Producto:</span>
                                    {{ $usuarioPedidos->first()->usuario->nombre ?? 'Nombre no disponible' }}
                                    {{ $usuarioPedidos->first()->usuario->apellido ?? 'Apellido no disponible' }}
                                </th>
                            </tr>
                            <tr style="text-align: center; background-color: #4CAF50;">
                                <th style=" width: 150px;">Eliminar</th>
                                <th style=" width: 300px;">Imagen</th>
                                <th style=" width: 250px;">Producto</th>
                                <th style=" width: 200px;">Precio</th>
                                <th style=" width: 200px;">Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody style="text-align: center; background-color: white;">
                            @php
                                $totalAcumuladoUsuario = 0;
                            @endphp
                            @forelse($usuarioPedidos as $pedido)
                                <tr class="product-row" data-usuario-id="{{ $pedido->usuario_id }}"
                                    data-pedido-id="{{ $pedido->id }}">
                                    <td>
                                        <form method="post" action="{{ route('EliminarPedido', [$pedido->id]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-danger btn-delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <img class="product-image" src="{{ asset($pedido->Imagen) }}"
                                            alt="{{ $pedido->nombre }}">
                                    </td>
                                    <td>{{ $pedido->nombre }}</td>
                                    <td class="product-price">Lps {{ $pedido->precio }}</td>

                                    <td class="wide-column quantity-input">{{ $pedido->cantidad }}</td>

                                    <td class="product-total" id="total-{{ $pedido->id }}">
                                        {{ $pedido->precio * $pedido->cantidad }}.00
                                    </td>
                                </tr>
                                @php
                                    $totalAcumuladoUsuario += $pedido->precio * $pedido->cantidad;
                                @endphp
                            @empty
                            @endforelse
                            <tr class="total-row">
                                
                                <!-- H. KELEN -->
                                <td colspan="5" style="text-align: left;">
                                    <a type="button" class="btn btn-danger btn-delete"
                                        data-email="{{ $usuarioPedidos->first()->usuario->email }}"
                                        data-id-usuario="{{ $usuarioPedidos->first()->usuario->id }}"
                                        data-pedido-id="{{ $pedido->id }}" data-producto-nombre="{{ $pedido->nombre }}"
                                        data-target="#modal-descripcion-pedido" data-toggle="modal">Realizar Pedido</a>
                                </td>
                                <!-- H. KELEN -->

                                <td class="total-cell" style="font-size: 18px;"
                                    id="totalAcumuladoUsuario{{ $usuarioPedidos->first()->usuario->id }}"
                                    data-usuario-id="{{ $usuarioPedidos->first()->usuario->id }}">
                                    Total Acumulado: <br>
                                    Lps {{ $totalAcumuladoUsuario }}.00
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @empty
                    <div class="text-center my-3 mb-5">
                        <h2 class="display-4 text-muted">¡Oh no!</h2>
                        <p class="lead">No tienes Pedidos por el momento.</p>
                        <p>Explora nuestra tienda y encuentra productos increíbles.</p>
                        <a href="{{ route('Tienda') }}" class="btn btn-success btn-lg mt-3">
                            <i class="fas fa-shopping-cart"></i> Ir de compras
                        </a>
                    </div>
                @endforelse
            </div>
        </section>
        <!-- TABLA PEDIDO -->

        <!-- MODAL REALIZAR PEDIDO -->
        <!-- H. KELEN -->
        @if (isset($usuarioPedidos) && count($usuarioPedidos) > 0)
            <div class="modal" id="modal-descripcion-pedido" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #28a745; color: white;">
                            <h5 class="modal-title" id="exampleModalLabel">Descripción del Pedido</h5>
                        </div>
                        <form action="{{ route('send.mail') }}" method="POST">
                            @method('POST')
                            @csrf
                            <div class="modal-body" id="modal-body-descripcion-pedido">
                                <textarea class="form-control" name="descripcion-pedido" id="descripcion-pedido"></textarea>
                                <input type="hidden" name="pedido_id" id="pedido_id">
                                <input type="hidden" name="email" id="email">
                                <input type="hidden" name="id-usuario" id="id-usuario">
                                @foreach ($usuarioPedidos as $pedido)
                                    <input type="checkbox" name="productos_seleccionados[]" value="{{ $pedido->id }}"
                                        style="display: none;" checked>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-danger">Enviar Pedido</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
        <!-- MODAL REALIZAR PEDIDO -->

        <!-- INICIO SCRIPT MODAL -->
        <!-- H. KELEN -->
        <script>
            $(document).ready(function() {
                $('#modal-descripcion-pedido').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var modal = $(this);

                    modal.find('.modal-body #email').val(button.data("email"));
                    modal.find('.modal-body #pedido_id').val(button.data("pedido-id"));
                    modal.find('.modal-body #id-usuario').val(button.data("id-usuario"));
                })
            })
        </script>
        <!-- FIN SCRIPT MODAL -->

    @endif

@endsection
