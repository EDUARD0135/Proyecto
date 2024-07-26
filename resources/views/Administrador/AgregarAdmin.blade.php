@extends('CuentaAdminNavbar')

@section('titulo', 'Registro Administrador')

@section('Contenido')

<!-- H. EDUARDO -->
<style>
    section {
        background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
        background-size: cover;
    }

    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 30px;
        max-width: 600px;
        margin: 15px auto;
    }

    .card-title {
        color: #2f2c79;
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .form-label,
    .form-control {
        color: #000000;
    }

    .form-control {
        border: 1px solid #2f2c79;
    }

    .btn-primary {
        background-color: #2f2c79;
        border: 1px solid #2f2c79;
        color: #ffffff;
        width: 100%;
        margin-top: 20px;
    }

    .btn-secondary {
        background-color: #2f2c79;
        border: 1px solid #2f2c79;
        color: #ffffff;
        width: 100%;
        margin-top: 10px;
    }

    .forgot-password {
        color: #6c757d;
        text-decoration: none;
        display: block;
        margin-top: 10px;
    }

    input:focus {
        outline-color: #2f2c79;
    }

    .modal-header {
        background-color: #2f2c79;
        color: #ffffff;
    }
</style>
<!-- H. EDUARDO -->


<!-- H. JUNIOR -->
<section class="py-2">
    <div class="row justify-content-center">

        <div style="text-align:center">
            <div class="card">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <h2 class="card-title py-1">Registro de Administrador</h2>
                <form action="{{ route('Adminstore') }}" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label"><b>Nombre Completo:</b></label>
                        <div class="row">
                            <div class="col">
                                <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre" value="{{ old('nombre') }}" required>
                            </div>
                            <div class="col">
                                <input class="form-control" type="text" id="apellido" name="apellido" placeholder="Apellido" value="{{ old('apellido') }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label"><b>Correo Electrónico:</b></label>
                        <input class="form-control" type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label"><b>Nombre de Usuario:</b></label>
                        <div class="row">
                            <div class="col">
                                <input class="form-control" type="text" id="nombre_usuario" name="nombre_usuario" required placeholder="Escribir Nombre de Usuario" value="{{ old('nombre_usuario') }}">
                            </div>
                            <div class="col">
                                <input class="form-control" type="text" id="repite_nombre_usuario" name="repite_nombre_usuario" required placeholder="Repetir Nombre de Usuario" value="{{ old('repite_nombre_usuario') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="contrasena" class="form-label"><b>Contraseña:</b></label>
                        <div class="row">
                            <div class="col">
                                <div class="input-group">
                                    <input class="form-control" type="password" id="contrasena" name="contrasena" required placeholder="Escribir Contraseña">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="mostrarOcultarContrasena('contrasena', 'toggleContrasena')">
                                            <i class="fas fa-eye" id="toggleContrasena"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <input class="form-control" type="password" id="repite_contrasena" name="repite_contrasena" required placeholder="Repetir Contraseña">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" onclick="mostrarOcultarContrasena('repite_contrasena', 'toggleRepiteContrasena')">
                                            <i class="fas fa-eye" id="toggleRepiteContrasena"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label"><b>Número de Teléfono:</b></label>
                        <input class="form-control" type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                    </div>

                    <div class="mb-3">
                        <input type="hidden" value="admin" id="rol" name="rol" required readonly>
                    </div>

                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="errorUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #007bff; color: white;">
                    <h5 class="modal-title" id="errorUsuarioModalLabel">Nombre de Usuario</h5>
                </div>
                <div class="modal-body">
                    <p>Los campos de "Nombre de Usuario" no coinciden.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorContrasenaModal" tabindex="-1" role="dialog" aria-labelledby="errorContrasenaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #007bff; color: white;">
                    <h5 class="modal-title" id="errorContrasenaModalLabel">Contraseña</h5>
                </div>
                <div class="modal-body">
                    <p>Los campos de "Contraseña" no coinciden.</p>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- H. JUNIOR -->


<!-- H. EDUARDO -->
<!-- PREVISUALIZACION DE IMAGEN -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('Imagen').addEventListener('change', function() {
            const previewContainer = document.getElementById('preview-container');
            const preview = document.getElementById('preview');
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    preview.src = reader.result;
                    previewContainer.style.display = 'block';
                });

                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                previewContainer.style.display = 'none';
            }
        });
    });
</script>

<!-- VALIDACION DE REPETICION -->
<script>
    function validarFormulario() {
        var nombreUsuario = document.getElementById('nombre_usuario').value;
        var repiteNombreUsuario = document.getElementById('repite_nombre_usuario').value;

        var contrasena = document.getElementById('contrasena').value;
        var repiteContrasena = document.getElementById('repite_contrasena').value;

        if (nombreUsuario !== repiteNombreUsuario) {
            // Abre el modal de error de Nombre de Usuario
            $('#errorUsuarioModal').modal('show');
            return false;
        }

        if (contrasena !== repiteContrasena) {
            // Abre el modal de error de Contraseña
            $('#errorContrasenaModal').modal('show');
            return false;
        }

        // Si todo está bien, permitir el envío del formulario
        return true;
    }
</script>

<!-- MOSTRAR CONTRASEÑA -->
<script>
    function mostrarOcultarContrasena(inputId, toggleId) {
        var contrasenaInput = document.getElementById(inputId);
        var toggleElement = document.getElementById(toggleId);

        if (contrasenaInput.type === 'password') {
            contrasenaInput.type = 'text';
            toggleElement.classList.remove('fa-eye');
            toggleElement.classList.add('fa-eye-slash');
        } else {
            contrasenaInput.type = 'password';
            toggleElement.classList.remove('fa-eye-slash');
            toggleElement.classList.add('fa-eye');
        }
    }
</script>
<!-- H. EDUARDO -->

@endsection