@extends('Navbar')

@section('titulo', 'Añadir Productor')

@section('todo')

<!-- H. EDUARDO -->
<style>
    /* Estilos generales */
    section {
        background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
        background-size: cover;
    }

    .form-container {
        width: 600px;
        margin: auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #28a745;
        text-align: left;
    }

    input,
    textarea,
    select,
    button {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
        border: 1px solid #28a745;
        border-radius: 4px;
    }

    .button-primary {
        background-color: #4caf50;
        color: #ffffff;
        cursor: pointer;
    }

    .button-primary:hover {
        background-color: #45a049;
    }

    .h2 {
        color: #28a745;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
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
        display: none;
        text-align: center;
    }

    #preview-container img {
        max-width: 100%;
        max-height: 300px;
        margin-top: 10px;
        border: 1px solid #28a745;
        border-radius: 5px;
    }
</style>
<!-- H. EDUARDO -->

<!-- H. KELEN -->
<section class="custom-bg2">
    <div class="container py-5" style="text-align:center">
        <div class="card form-container">
            <div style="text-align:center">
                <img src="{{ $ImagenLogo }}" alt="No hay imagen" class="img-fluid" style="max-width: 45%; max-height: 45%; background: transparent;">
            </div>

            <h2 class="h2">Añadir Producto</h2>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('AgregarProducto') }}" method="post" enctype="multipart/form-data">
                @csrf

                <label for="nombre"><b>Nombre del Producto:</b></label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required class="input-field">

                <input type="hidden" value="{{ session('usuario')->id }}" id="usuario_id" name="usuario_id" required readonly>

                <input type="hidden" value="1" id="cantidad" name="cantidad" required readonly>

                <label for="descripcion"><b>Descripción:</b></label>
                <textarea id="descripcion" name="descripcion" rows="4" value="{{ old('descripcion') }}" required class="input-field"></textarea>

                <label for="precio"><b>Precio:</b></label>
                <input type="number" id="precio" name="precio" step="1" min="0" required class="input-field">

                <label for="categoria"><b>Categoría:</b></label>
                <select id="categoria" name="categoria" required class="input-field">
                    <option value="Pantalones">Pantalones</option>
                    <option value="Camisas">Camisas</option>
                    <option value="Zapatos">Zapatos</option>
                    <option value="Dulces">Dulces</option>
                    <option value="Postres">Postres</option>
                    <option value="Variado">Variado</option>
                    <option value="llaveros">llaveros</option>
                    <option value="Pulseras">Pulseras</option>
                    <option value="Collares">Collares</option>
                </select>

                <label for="Imagen"><b>Imágen:</b></label>
                <input type="file" id="Imagen" name="Imagen" accept="image/*" required class="input-field">

                <div id="preview-container">
                    <label>Vista Previa de las Imagenes:</label>
                    <img id="preview">
                </div>
                <br>

                <button type="submit" class="button-primary">Agregar Producto</button>
            </form>
        </div>
    </div>
</section>
<!-- H. KELEN -->

@endsection

<!-- H. EDUARDO -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('Imagen').addEventListener('change', function() {
            const previewContainer = document.getElementById('preview-container');
            const files = this.files;

            previewContainer.innerHTML = '';

            for (const file of files) {
                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    const preview = document.createElement('img');
                    preview.src = reader.result;
                    previewContainer.appendChild(preview);
                });

                reader.readAsDataURL(file);
            }

            if (files.length > 0) {
                previewContainer.style.display = 'block';
            } else {
                previewContainer.style.display = 'none';
            }
        });
    });
</script>
<!-- H. EDUARDO -->
