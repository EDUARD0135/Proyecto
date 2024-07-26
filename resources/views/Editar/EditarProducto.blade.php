@extends('Navbar')

@section('titulo', 'Editar Producto')

@section('todo')

    <style>
        section {
        background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
        background-size: cover;
        }

        .h2 {
            color: #28a745;
            font-size: 38px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .card {
            width: 48%;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-right: 2%;
            /* Espaciado entre las cartas */
            box-sizing: border-box;
            float: left;
            /* Hace que las cartas se ubiquen una al lado de la otra */
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #28a745;
            border-radius: 4px;
        }

        button {
            background-color: #4caf50;
            color: #ffffff;
            cursor: pointer;
            padding: 10px;
            border: none;
            border-radius: 4px;
        }

        button:hover {
            background-color: #45a049;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        #preview-container {
            text-align: center;
        }

        #preview-container img {
            max-width: 100%;
            max-height: 300px;
            margin-top: 10px;
            margin-bottom: 10px;
            border: 1px solid #28a745;
            border-radius: 5px;
        }

        #preview-container .old-image,
        #preview-container .new-image {
            text-align: center;
        }

        /* Clearfix para manejar la flotación */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>

    <!-- INICIO CONTENIDO -->
    <section class="custom-bg2">
        <div class="container pb-5 py-5 clearfix" style="text-align:center">
            <div class="card">

            <div style="text-align:center">
                <img src="{{ $ImagenLogo }}" alt="No hay imagen" class="img-fluid" style="max-width: 40%; max-height: 40%; background: transparent;">
            </div>
            
                <h2 class="h2">Editar Producto</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- H. JUNIOR -->
                <form method="post" action="{{ route('producto.update', ['id' => $producto->id]) }}"
                    enctype="multipart/form-data">
                    @method('put')
                    @csrf

                    <label for="nombre"><b>Nuevo Nombre del Producto:</b></label>
                    <input type="text" id="nombre" name="nombre" value="{{ $producto->nombre }}" required>

                    <label for="precio"><b>Nuevo Precio:</b></label>
                    <input type="number" id="precio" name="precio" step="0.01" value="{{ $producto->precio }}"
                        required>

                    <label for="categoria"><b>Nuevo Categoría:</b></label>
                    <select id="categoria" name="categoria" required>
                        <option value="Pantalones" {{ $producto->categoria == 'Pantalones' ? 'selected' : '' }}>Pantalones
                        </option>
                        <option value="Camisas" {{ $producto->categoria == 'Camisas' ? 'selected' : '' }}>Camisas</option>
                        <option value="Zapatos" {{ $producto->categoria == 'Zapatos' ? 'selected' : '' }}>Zapatos</option>
                        <option value="Dulces" {{ $producto->categoria == 'Dulces' ? 'selected' : '' }}>Dulces</option>
                        <option value="Postres" {{ $producto->categoria == 'Postres' ? 'Postres' : '' }}>Postres</option>
                        <option value="Variado" {{ $producto->categoria == 'Variado' ? 'selected' : '' }}>Variado</option>
                        <option value="llaveros" {{ $producto->categoria == 'llaveros' ? 'selected' : '' }}>llaveros
                        </option>
                        <option value="Pulseras" {{ $producto->categoria == 'Pulseras' ? 'selected' : '' }}>Pulseras
                        </option>
                        <option value="Collares" {{ $producto->categoria == 'Collares' ? 'selected' : '' }}>Collares
                        </option>
                    </select>

                    <label for="descripcion"><b>Nuevo Descripción:</b></label>
                    <textarea id="descripcion" name="descripcion" rows="4" style="width: 100%;" required>{{ $producto->descripcion }}</textarea>
            </div>

            <div class="card">

                <div id="preview-container">
                    <div class="old-image">
                        <label><b>Imagen Actual:</b></label>
                        <img src="{{ asset($producto->Imagen) }}" alt="Imagen Actual">
                    </div>
                </div>

                <label for="Imagen"><b>Nuevo Imagen:</b></label>
                <input type="file" id="Imagen" name="Imagen" accept="image/*">

                <div id="preview-container">
                    <div class="new-image">
                        <label><b>Nueva Imagen:</b></label>
                        <img id="preview-new">
                    </div>
                </div>

                <button type="submit">Guardar Producto</button>
                </form>
                <!-- H. JUNIOR -->
            </div>
        </div>
    </section>

    <!-- Script para mostrar la nueva imagen -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('Imagen').addEventListener('change', function() {
                const previewNew = document.getElementById('preview-new');
                const files = this.files;

                previewNew.src = '';

                for (const file of files) {
                    const reader = new FileReader();

                    reader.addEventListener('load', function() {
                        previewNew.src = reader.result;
                    });

                    reader.readAsDataURL(file);
                }
            });
        });
    </script>

@endsection
