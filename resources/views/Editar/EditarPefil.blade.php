@extends('CuentaNavbar')

@section('titulo', 'Editar Perfil')

@section('Contenido')

    <!-- H. EDUARD0 -->
    <style>
        /* Estilos comunes */
        .custom-bg2 {
            background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
            background-size: cover;
        }

        .card {
            width: 48%;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-right: 2%;
            box-sizing: border-box;
            float: left;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input,
        select,
        textarea {
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

        .old-image,
        .new-image {
            text-align: center;
        }

        /* Clearfix para manejar la flotación */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

        /* Estilos específicos */
        .h2 {
            color: #28a745;
            font-size: 38px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        #preview {
            max-width: 100%;
            max-height: 200px;
            margin-top: 10px;
            border: 1px solid #28a745;
            border-radius: 5px;
        }
    </style>
    <!-- H. EDUARD0 -->

    <!-- INICIO CONTENIDO -->
    <section class="custom-bg2 clearfix py-3">
        <div class="container">
            @if (session('usuario'))
                <div class="card">

                    <div style="text-align:center">
                        <img src="{{ $ImagenLogo }}" alt="No hay imagen" class="img-fluid"
                            style="max-width: 40%; max-height: 40%; background: transparent;">
                    </div>

                    <!-- H. SANDY -->
                    <h2 class="h2">Editar Perfil</h2>
                    <form method="post" enctype="multipart/form-data"
                        action="{{ route('usuario.update', ['id' => $usuario->id]) }}">
                        @method('put')
                        @csrf

                        <div class="form-group">
                            <label for="nombre"><b>Nuevo Nombre:</b></label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                value="{{ $usuario->nombre }}" required>
                        </div>

                        <div class="form-group">
                            <label for="apellido"><b>Nuevo Apellido:</b></label>
                            <input type="text" class="form-control" id="apellido" name="apellido"
                                value="{{ $usuario->apellido }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email"><b>Nuevo Correo Electrónico:</b></label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $usuario->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nombre_usuario"><b>Nuevo Nombre de Usuario:</b></label>
                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario"
                                value="{{ $usuario->nombre_usuario }}" required>
                        </div>
                </div>

                <div class="card">
                    <div class="form-group">
                        <label for="telefono"><b>Nuevo Número de Teléfono:</b></label>
                        <input type="tel" class="form-control" id="telefono" name="telefono"
                            value="{{ $usuario->telefono }}" required>
                    </div>

                    <div class="form-group">
                        <label for="Imagen"><b>Nuevo Imagen de Perfil:</b></label>
                        <input type="file" class="form-control" id="Imagen" name="Imagen" accept="image/*">
                        <div id="preview-container" class="old-image">
                            <label><b>Imagen Actual:</b></label>
                            <img id="preview-old" src="{{ asset($usuario->Imagen) }}" alt="Imagen Actual">
                        </div>
                    </div>

                    <div id="preview-container" class="new-image">
                        <label><b>Nueva Imagen:</b></label>
                        <img id="preview">
                    </div>

                    <div class="row pb-3">
                        <div class="d-inline-block col d-grid">
                            <button type="button" class="btn btn-success btn-lg" id="guardarCambiosBtn">Guardar
                                Cambios</button>
                        </div>

                        <div class="d-inline-block col d-grid">
                            <a href="{{ route('usuarioPerfil') }}" class="btn btn-success btn-lg">Volver al Perfil</a>
                        </div>
                    </div>
                    </form>
                </div>
                <!-- H. SANDY -->

                <!-- INICIO MODAL -->
                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="background-color: #28a745; color: white;">
                                <h5 class="modal-title" id="confirmModalLabel">Confirmar Cambios</h5>
                            </div>
                            <div class="modal-body">
                                Para Guardar los Cambios Tiene Que <b>Cerrar Sesion</b>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="confirmarBtn">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FINAL MODAL -->

        </div>
        @endif
    </section>

@endsection

 <!-- Script Mostrar Imagen -->
<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('Imagen').addEventListener('change', function() {
            const preview = document.getElementById('preview');
            const files = this.files;

            preview.src = '';

            for (const file of files) {
                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    preview.src = reader.result;
                });

                reader.readAsDataURL(file);
            }
        });

        // Agrega el código para el modal de confirmación
        $('#guardarCambiosBtn').on('click', function(e) {
            e.preventDefault();

            // Mostrar el modal de confirmación
            $('#confirmModal').modal('show');
        });

        $('#confirmarBtn').on('click', function() {
            // Confirmar y permitir que el formulario se envíe
            $('#confirmModal').modal('hide');
            $('form').submit();
        });

        $('#cancelarBtn').on('click', function() {
            // Cancelar y cerrar el modal
            $('#confirmModal').modal('hide');
        });
    });
</script>
