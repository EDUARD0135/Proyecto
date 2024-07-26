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
        max-width: 400px;
        margin: 40px auto; /* Centra horizontalmente */
        min-height: 500px;
    }

    .card-title {
        color: #28a745;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .form-label, .form-control {
        color: #28a745;
    }

    .form-control {
        border: 1px solid #28a745;
    }

    .btn-primary {
        background-color: #28a745;
        border: 1px solid #28a745;
        color: #ffffff;
        width: 100%;
        margin-top: 10px;
    }

    .btn-secondary {
        background-color: #007bff;
        border: 1px solid #007bff;
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
    }
</style>
</head>

<body>
<section>
    <div class="container py-2">
    <div class="row justify-content-center">
        <!-- Columna para el formulario -->
        <div style="text-align:center">
            <div class="card">
                @if (session('mensaje'))
                <div class="alert alert-success">
                    {{ session('mensaje') }}
                </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <div style="text-align:center">
                    <a href="{{ route('Inicio') }}">
                       <img src="{{ $ImagenLogo }}" alt="No hay imagen" class="img-fluid" style="max-width: 70%; max-height: 70%; background: transparent;">
                     </a>
                </div>

                <h2 class="card-title">Inicio Sesión</h2>
                <form action="{{ route('usuario.login.submit') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <p for="nombre_usuario" class="form-label" style="text-align:left">Nombre de usuario</p>
                        <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Escribir Nombre de Usuario">
                    </div>

                    <div class="mb-3">
                    <p for="nombre_usuario" class="form-label" style="text-align:left" >Contraseña</p>
                    <div class="input-group">
                                        <input class="form-control" type="password" id="contrasena" name="contrasena"
                                            required placeholder="Escribir Contraseña">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"
                                                onclick="mostrarOcultarContrasena('contrasena', 'toggleContrasena')">
                                                <i class="fas fa-eye" id="toggleContrasena"></i>
                                            </button>
                                        </div>
                                    </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Ingresar</button>
                    <a type="button" class="btn btn-secondary" href="{{ route('usuario.create') }}">Registrarte</a>
                    <a href="{{ route('FormularioSolicitud') }}" class="forgot-password">¿Olvidaste tu contraseña?</a>
                </form>
            </div>
        </div>

    </div>
    </div>
</section>

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

<body>
</html>