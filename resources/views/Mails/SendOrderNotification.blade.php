<!DOCTYPE html>
<html>

<head>
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            display: table;
            border-collapse: collapse;
        }

        /* Estilos adicionales para la tabla (opcional) */
        table th,
        table td {
            padding: 5px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <!-- Cuerpo del correo -->
    <p>
        <b>{{ $compradorNombre }} {{ $compradorApellido }}</b> ha realizado una compra de tu producto.<br>
        <b>Numero de Telefono:</b> {{ $compradorTelefono }}<br>
        <b>Correo electrónico del Usuario:</b> {{ $compradorEmail }}<br><br>
        {!! nl2br(e($mensaje)) !!}
    </p>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalGeneral = 0;
                @endphp
                @if (!empty($products))
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $product->nombre }}</td>
                            <td>L. {{ $product->precio }}</td>
                            <td>{{ $product->cantidad }}</td>
                            <td>L. {{ $product->precio * $product->cantidad }}</td>
                        </tr>
                        @php
                            $totalGeneral += $product->precio * $product->cantidad;
                        @endphp
                    @empty
                        <tr>
                            <th colspan="4">No hay productos en este pedido.</th>
                        </tr>
                    @endforelse
                @else
                    <tr>
                        <th colspan="4">No hay productos en este pedido.</th>
                    </tr>
                @endif
                <!-- Fila de total general -->
                <tr>
                    <th colspan="3">Total general:</th>
                    <td>L. {{ $totalGeneral }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
