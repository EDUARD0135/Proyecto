@extends('CuentaNavbar')

@section('titulo', 'Mensaje de Confirmacion')

@section('Contenido')

<style>

    .card {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        padding: 70px;
        max-width: 400px;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .card-title {
        color: #19B400;
        font-size: 28px; /* Aumentamos el tamaño del título */
        font-weight: bold;
        margin-bottom: 20px;
    }

    .form-label, .form-control {
        color: #3498db;
    }

    .form-control {
        border: 2px solid #3498db;
    }

    .btn-primary, .btn-secondary {
        width: 100%; /* Ancho del 100% para ambos botones */
        margin-top: 10px; /* Margen superior para el segundo botón */
    }

    .forgot-password {
        color: #3498db;
        text-decoration: none;
        display: block;
        margin-top: 10px;
    }
</style>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<body>
    <center>
        <div class="card mb-3">
            <h2 class="card-title">Solicitud de Recuperación de Contraseña</h2>
            <p>Hemos enviado un correo electrónico con instrucciones para restablecer tu contraseña. Si no ves el correo en tu bandeja de entrada, verifica en la carpeta de spam.</p>
            <a href="{{ route('usuario.login') }}" class="btn btn-success">Volver al inicio</a>
        </div>
    </center>
</body>

@endsection
