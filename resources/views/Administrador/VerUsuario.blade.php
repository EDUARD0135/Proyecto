@extends('AdminNavbar')

@section('titulo', 'Ver Usuario')

@section('Contenido')

<style>
    section {
        background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
        background-size: cover;
    }

    .profile-container {
        display: flex;
    }

    .profile-sidebar {
        width: 25%;
        padding: 20px;
        background-color: ;
    }

    .profile-content {
        flex: 1;
        padding: 20px;
    }

    .profile-name {
        margin-top: 10px;
    }

    .profile-info {
        margin-bottom: 12px;
    }

    .btn-sm {
        margin-right: 5px;
    }

    .nav-tabs {
        margin-bottom: 20px;
    }

    .product-card {
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .product-title {
        font-size: 1.5rem;
        margin-bottom: 10px;
        color: #161d6c;
    }

    .product-description {
        margin-bottom: 20px;
    }

    .product-price {
        font-size: 1.3rem;
    }

    .no-products {
        font-weight: bold;
        color: #dc3545;
    }

    .product-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }

    .product-actions a,
    .product-actions button {
        display: inline-block;
        margin-right: 10px;
    }

    .product-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1px;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 10px;
    }

    .action-buttons button,
    .action-buttons a {
        display: inline-block;
        margin: 0 5px;
        padding: 10px 15px;
    }
</style>

@if (session('success') || session('mensaje') || session('error'))
    <div class="alert alert-{{ session('success') ? 'success' : (session('mensaje') ? 'success' : 'danger') }}">
        {{ session('success') ?? (session('mensaje') ?? session('error')) }}
    </div>
@endif

<section class="profile-container py-3">

    <div class="profile-sidebar">
        <div class="card">
            <div class="card-header text-center" style="background-color: #dfe7ff;">
                @if ($usuario->Imagen)
                    <img style="height: 300px; object-fit: cover;" src="{{ asset($usuario->Imagen) }}" alt="Profile Image"
                        class="img-fluid">
                @endif
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h4 class="profile-name"><b style="color: #161d6c">{{ $usuario->nombre }}
                            {{ $usuario->apellido }}</b></h4>
                </div>
                <p class="profile-info"><b style="color: #161d6c">Usuario:</b> {{ $usuario->nombre_usuario }}</p>
                <p class="profile-info"><b style="color: #161d6c">Telefono:</b> {{ $usuario->telefono }}</p>
                <p class="profile-info"><b style="color: #161d6c">Email:</b> {{ $usuario->email }}</p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header" style="background-color: #dfe7ff;">
                <h5 class="mb-0">Reportes ({{ $reportes->count() }})</h5>
            </div>
            <div class="card-body">
                @forelse ($reportes as $reporte)
                    <div class="card mt-2">
                        <div class="card-body">
                            <strong>Reportado por:</strong>
                            <a class="text-decoration-none" style="color: #161d6c" href="{{ route('usuario.mostrar', ['id' => $reporte->usuarioReporta->id]) }}">
                                <b>{{ $reporte->usuarioReporta->nombre_usuario }}</b>
                            </a> <br>
                            <strong>Motivo del reporte:</strong> {{ $reporte->motivo }}
                        </div>
                    </div>
                @empty
                    <div class="card mt-2">
                        <div class="card-body">
                            <strong>No Tiene Reportes</strong><br>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="profile-content">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active"><b> <span style="color: #161d6c">Productos</span> y <span
                            style="color:red">Ofertas</span> Subidos
                        por {{ $usuario->nombre }} {{ $usuario->apellido }} </b></a></li>
        </ul>

        <div class="row mt-3">
            @forelse($usuario->productos as $producto)
                <div class="col-md-4 mb-4">
                    <div class="card product-card">
                        <img class="card-img-top product-image" style="height: 200px; object-fit: cover;"
                            src="{{ asset($producto->Imagen) }}" alt="Producto Image">
                        <div class="card-body">
                            <div class="product-details">
                                <h5 class="card-title product-title" title="{{ $producto->nombre }}" style="height: 34px; width: 200px; overflow: hidden;">
                                    <b>{{ $producto->nombre }}</b>
                                </h5>
                                <p class="product-price"><b>Lps {{ $producto->precio }}</b></p>
                            </div>
                            <p class="card-text product-description" style="height: 70px; overflow: hidden;">{{ $producto->descripcion }}</p>
                            <div class="action-buttons">
                                <a href="{{ route('ShowProductoAdmin', ['id' => $producto->id]) }}" class="btn btn"
                                    style="background-color: #161d6c; width: 100px;">
                                    <i class="fas fa-eye" style="color: white;"></i>
                                </a>
                                <!-- Botón para abrir el modal -->
<button type="button" class="btn btn-danger text-white mx-2" style="width: 100px;" data-toggle="modal" data-target="#eliminarProducto{{ $producto->id }}">
    <i class="fa-solid fa-circle-xmark"></i>
</button>

<!-- Modal de confirmación -->
<div class="modal fade" id="eliminarProducto{{ $producto->id }}" tabindex="-1" role="dialog" aria-labelledby="eliminarProductoLabel{{ $producto->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eliminarProductoLabel{{ $producto->id }}">Confirmar eliminación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de que deseas eliminar el producto <strong>{{ $producto->nombre }}</strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <!-- Formulario para enviar la solicitud de eliminación -->
        <form id="formEliminar{{ $producto->id }}" method="post" action="{{ route('producto.borrar1', $producto->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
</div>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p class="no-products">No tiene productos.</p>
                </div>
            @endforelse

            @forelse($usuario->ofertas as $oferta)
                <div class="col-md-4 mb-4">
                    <div class="card product-card">
                        <img class="card-img-top product-image" style="height: 200px; object-fit: cover;"
                            src="{{ asset($oferta->Imagen) }}" alt="Producto Image">
                        <div class="card-body">
                            <div class="product-details">
                                <h5 class="card-title product-title text-danger" title="{{ $oferta->nombre }}" style="height: 34px; width: 200px; overflow: hidden;">
                                    <b>{{ $oferta->nombre }}</b>
                                </h5>
                                <p class="product-price text-danger"><b>Lps {{ $oferta->precio }}</b></p>
                            </div>
                            <p class="card-text product-description" style="height: 70px; overflow: hidden;">{{ $oferta->descripcion }}</p>
                            <div class="action-buttons">
                                <a href="{{ route('ShowOfertaAdmin', ['id' => $oferta->id]) }}" class="btn btn"
                                    style="background-color: #161d6c; width: 100px;">
                                    <i class="fas fa-eye" style="color: white;"></i>
                                </a>
                                <form id="formEliminar{{ $oferta->id }}" method="post"
                                    action="{{ route('oferta.borrar', $oferta->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger text-white mx-2" style="width: 100px;"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar la oferta {{ $oferta->nombre }}?')">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <p class="no-products">No tiene ofertas.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
