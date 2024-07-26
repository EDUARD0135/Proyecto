<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <link rel="icon" href="{{ asset('img/LogoLucem2.png') }}" type="image/x-icon">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

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
            width: 100%;
            max-width: 550px;
            margin: 20px auto;
            /* Centra horizontalmente */
            min-height: 500px;
        }

        .card-title {
            color: #28a745;
            /* Cambiado a verde */
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-label,
        .form-control {
            color: black;
            /* Cambiado a verde */
        }

        .form-control {
            border: 1px solid #28a745;
            /* Cambiado a verde */
        }

        .btn-primary {
            background-color: #28a745;
            border: 1px solid #28a745;
            width: 100%;
            margin-top: 20px;
        }

        .btn-primary2 {
            background-color: #28a745;
            border: 1px solid #28a745;
            width: 100%;
            margin-top: 20px;
        }

        .btn-secondary {
            background-color: #28a745;
            /* Cambiado a verde */
            border: 1px solid #28a745;
            /* Cambiado a verde */
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
            outline-color: #28a745;
            /* Cambiado a verde */
        }

        #preview-container {
            display: none;
            text-align: center;
        }

        #preview {
            max-width: 100%;
            max-height: 300px;
            margin-top: 10px;
            border: 1px solid #28a745;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <section>
        <div class="container py-4">
            <div class="row justify-content-center">

                <div style="text-align:lef">
                    <div class="card">

                        <div style="text-align:center">
                            <img src="{{ $ImagenLogo }}" alt="No hay imagen" class="img-fluid"
                                style="max-width: 70%; max-height: 70%; background: transparent;">
                        </div>

                        <h2 class="card-title" style="text-align:center"> REGISTRO </h2>
                        <form method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre" class="form-label"><b>Nombre Completo:</b></label>
                                <div class="row">
                                    <div class="col">
                                        <input class="form-control @error('nombre') is-invalid @enderror" type="text"
                                            id="nombre" name="nombre" placeholder="Nombre"
                                            value="{{ old('nombre') }}" required>

                                        @error('nombre')
                                            <div class ="invalid-feedback">No se aceptan Numeros ni caracteres especiales
                                            </div>
                                        @enderror

                                    </div>
                                    <div class="col">
                                        <input class="form-control @error('apellido') is-invalid @enderror"
                                            type="text" id="apellido" name="apellido" placeholder="Apellido"
                                            value="{{ old('apellido') }}" required>

                                        @error('apellido')
                                            <div class ="invalid-feedback">No se aceptan Numeros ni caracteres especiales
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label"><b>Correo Electrónico:</b></label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email"
                                    id="email" name="email" value="{{ old('email') }}" required>

                                @error('email')
                                    <div class ="invalid-feedback">Formato Invalido</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nombre_usuario" class="form-label"><b>Nombre de Usuario:</b></label>
                                <div class="row">
                                    <div class="col">
                                        <input class="form-control @error('nombre_usuario') is-invalid @enderror"
                                            type="text" id="nombre_usuario" name="nombre_usuario" required
                                            placeholder="Escribir Nombre de Usuario"
                                            value="{{ old('nombre_usuario') }}">

                                        @error('nombre_usuario')
                                            <div class ="invalid-feedback">Formato Invalido</div>
                                        @enderror
                                    </div>
                                    <div class="col">
                                        <input class="form-control @error('repite_nombre_usuario') is-invalid @enderror"
                                            type="text" id="repite_nombre_usuario" name="repite_nombre_usuario"
                                            required placeholder="Repetir Nombre de Usuario"
                                            value="{{ old('repite_nombre_usuario') }}">

                                        @error('repite_nombre_usuario')
                                            <div class ="invalid-feedback">Formato Invalido</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="contrasena" class="form-label"><b>Contraseña:</b></label>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group">
                                            <input class="form-control @error('contrasena') is-invalid @enderror"
                                                type="password" id="contrasena" name="contrasena" required
                                                placeholder="Escribir Contraseña">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="mostrarOcultarContrasena('contrasena', 'toggleContrasena')">
                                                    <i class="fas fa-eye" id="toggleContrasena"></i>
                                                </button>
                                            </div>

                                            @error('contrasena')
                                                <div class ="invalid-feedback">La Contraseña debe tener letras Minisculas
                                                    minimo una
                                                    letra Mayuscula y minimo un Caracter Especial</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <input
                                                class="form-control @error('repite_contrasena') is-invalid @enderror"
                                                type="password" id="repite_contrasena" name="repite_contrasena"
                                                required placeholder="Repetir Contraseña">

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    onclick="mostrarOcultarContrasena('repite_contrasena', 'toggleRepiteContrasena')">
                                                    <i class="fas fa-eye" id="toggleRepiteContrasena"></i>
                                                </button>
                                            </div>

                                            @error('repite_contrasena')
                                                <div class ="invalid-feedback">La Contraseña debe tener letras Minisculas
                                                    minimo una
                                                    letra Mayuscula y minimo un Caracter Especial</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="telefono" class="form-label"><b>Número de Teléfono:</b></label>
                                <input class="form-control  @error('telefono') is-invalid @enderror" type="tel"
                                    id="telefono" name="telefono" value="{{ old('telefono') }}" required>

                                @error('telefono')
                                    <div class ="invalid-feedback">El Telefono debe tener 8 Digitos</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="Imagen" class="form-label"><b>Imagen de Perfil:</b></label>
                                <input class="form-control" type="file" id="Imagen" name="Imagen"
                                    accept="image/*" value="{{ old('Imagen') }}" required>
                            </div>

                            <div id="preview-container">
                                <label><b>Vista Previa de la Imagen:</b></label>
                                <img id="preview">
                            </div>

                            <button class="btn btn-primary" type="submit">Registrar</button>

                        </form>

                        <a class="btn btn-primary" href="{{ route('usuario.login') }}">Volver</a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="errorUsuarioModal" tabindex="-1" role="dialog"
        aria-labelledby="errorUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #28a745; color: white;">
                    <h5 class="modal-title" id="errorUsuarioModalLabel">Nombre de Usuario</h5>
                </div>
                <div class="modal-body">
                    <p>Los campos de "Nombre de Usuario" no coinciden.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorContrasenaModal" tabindex="-1" role="dialog"
        aria-labelledby="errorContrasenaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #28a745; color: white;">
                    <h5 class="modal-title" id="errorContrasenaModalLabel">Contraseña</h5>
                </div>
                <div class="modal-body">
                    <p>Los campos de "Contraseña" no coinciden.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // PREVISUALIZACION DE IMAGEN
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

    <script>
        // VALIDACION DE REPETICION
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

    <script>
        // MOSTRAR CONTRASEÑA
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

</body>
