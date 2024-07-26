@extends('CuentaNavbar')

@section('titulo', 'Solicitud de Recuperación')

@section('Contenido')
    <style>
        body {
            background-color: #f8f9fa; /* Cambia el color de fondo del cuerpo */
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            padding: 70px;
            max-width: 400px;
            text-align: center;
            margin: 5vh auto; /* Centra verticalmente con Flexbox y agrega margen inferior */
            display: flex; /* Agrega display flex para habilitar las utilidades de flexbox */
            flex-direction: column; /* Alinea los elementos en columna */
            justify-content: center; /* Centra verticalmente los elementos */
        }

        .card h2 {
            color: #28a745; /* Cambia el color del título a verde */
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .form-label,
        .form-control {
            color: #28a745; /* Cambia el color del texto de los formularios a verde */
        }

        .form-control {
            border: 1px solid #28a745; /* Cambia el color del borde del formulario a verde */
        }

        .btn-primary {
            background-color: #28a745; /* Cambia el color de fondo del botón principal a verde */
            border: 1px solid #28a745; /* Cambia el color del borde del botón principal a verde */
            color: #ffffff; /* Cambia el color del texto del botón principal a blanco */
            width: 100%;
            margin-top: 10px;
        }
    </style>

    <div class="card mb-3">
        <h2>Recuperación</h2>
        <form method="post" action="{{ route('procesarSolicitud') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Recuperar Contraseña</button>
        </form>
    </div>
    
    <br><br><br>
@endsection
