@extends('CuentaNavbar')

@section('titulo', 'Restablecer Contraseña')

@section('Contenido')

<style>
    .card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        padding: 70px;
        max-width: 400px;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .card h2 {
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
</style>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<body>
    <center>
        <div class="card mb-3">
            <h2>Recuperación</h2>
            <form method="post" action="{{ route('procesarRestablecimiento') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="mb-3">
                    <label for="password" class="form-label">Nueva Contraseña:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmar Contraseña:</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">Restablecer Contraseña</button>
            </form>
        </div>
    </center>
</body>

@endsection
