@extends('AdminNavbar')

@section('titulo', 'Lista de Usuarios')

@section('Contenido')


    <!-- H. KELEN -->
    <style>
        section {
            background: url('{{ $ImagenFondo }}') no-repeat center center fixed;
            background-size: cover;
        }

        .page-link {
            color: rgb(61, 69, 80);
            border-color: rgb(61, 69, 80);
        }

        .pagination-item {
            margin-right: 15px;
        }

        .page-item.active .page-link {
            background-color: rgb(61, 69, 80);
            border-color: rgb(61, 69, 80);
        }

        .page-link:hover {
            background-color: rgba(61, 69, 80, 0.8);
        }

        .search-form {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-input {
            margin-right: 10px;
            flex-grow: 1;
            min-width: 200px;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            min-width: 200px;
        }

        .user-table th,
        .user-table td {
            text-align: center;
            vertical-align: middle;
            max-width: 150px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .full-screen {
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

    </style>
    <!-- H. KELEN -->

    <!-- H. JUNIOR -->
    <section class="custom-bg2 @if ($usuarios->isEmpty()) full-screen @endif">
        <div class="container py-5">

            <h1 style="color:rgb(61, 69, 80); font-size:50px; font: sans-serif;"><b>USUARIOS</b></h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row align-items-center mb-3">
                <div class="col-md-6">
                    <form class="d-flex" action="{{ route('Admi') }}" method="get">
                        <input class="form-control me-2 search-input" type="search" placeholder="Buscar"
                            aria-label="Search" name="buscar" value="{{ session('UsuarioBuscar') }}">
                        <button class="btn btn" type="submit" style="background-color: #2f2c79; color:white">Buscar</button>
                    </form>
                </div>
            </div>

            <div class="user-table">
                <div class="table-responsive">
                    <table class="table table-bordered table-expand">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">N°</th>
                                <th scope="col" style="text-align: left;">Usuario</th>
                                <th scope="col" style="text-align: left;">Nombre</th>
                                <th scope="col">Ver</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($usuarios as $index => $usuario)
                                @if ($index > 0)
                                    <tr>
                                        <td>{{ $usuario->id }}</td>
                                        <td style="text-align: left;">{{ $usuario->nombre_usuario }}</td>
                                        <td style="text-align: left;">{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                                        <td>
                                            <a class="btn btn-outline-info btn-custom"
                                                href="{{ route('usuario.mostrar', ['id' => $usuario->id]) }}"><i
                                                    class="fas fa-eye"></i></a>
                                        </td>
                                        <td>
                                        @if ($usuario->activo)
                                            <button type="button" class="btn btn-outline-primary btn-custom"  data-toggle="modal" data-target="#confirmarModal{{ $usuario->id }}"><i class="fas fa-toggle-off"></i> Habilitado</button>
                                        @else
                                            <button type="button" class="btn btn-outline-danger btn-custom"  data-toggle="modal" data-target="#confirmarModal{{ $usuario->id }}"><i class="fas fa-toggle-on"></i> Deshabilitado</button>
                                        @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger btn-danger-custom"
                                                data-toggle="modal" data-target="#eliminarUsuarioModal{{ $usuario->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>

                                            <!-- MODAL ELIMINAR USUARIO-->
                                            <div class="modal fade" id="eliminarUsuarioModal{{ $usuario->id }}"
                                                tabindex="-1" role="dialog"
                                                aria-labelledby="eliminarUsuarioModalLabel{{ $usuario->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="eliminarUsuarioModalLabel{{ $usuario->id }}">Confirmar
                                                                eliminación</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de que deseas eliminar al usuario
                                                            {{ $usuario->nombre }}?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Cancelar</button>
                                                            <form method="post"
                                                                action="{{ route('usuario.borrar', $usuario->id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-danger-custom">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- MODAL ELIMINAR USUARIO -->
<div class="modal fade" id="confirmarModal{{ $usuario->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmarModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarModalLabel">Confirmar Acción</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que quieres cambiar el estado del usuario?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <!-- Agrega el enlace de acción dentro de este botón -->
                <a id="confirmarAccionBtn" class="btn btn-primary" href="{{ route('activar.desactivar.usuario', ['id' => $usuario->id]) }}">Confirmar</a>
            </div>
        </div>
    </div>
</div>


                                            
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="6">NO HAY USUARIOS</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <ul class="pagination pagination-lg justify-content-end py-3" id="pagination">
                @php
                    $currentPage = $usuarios->currentPage();
                    $totalPages = $usuarios->lastPage();
                    $range = 3;
                    $start = max(1, $currentPage - floor($range / 2));
                    $end = min($start + $range - 1, $totalPages);
                    $start = max(1, min($totalPages - $range + 1, $start));
                @endphp

                @for ($page = $start; $page <= $end; $page++)
                    <li class="page-item pagination-item @if ($page == $currentPage) active @endif">
                        <a class="page-link shadow-sm text-dark @if ($page == $currentPage) text-white @endif"
                            href="{{ route('Admi', ['page' => $page]) }}">{{ $page }}</a>
                    </li>
                @endfor
            </ul>

        </div>
    </section>

    <script>
        function confirmarEliminar(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
                document.getElementById('formEliminar' + id).submit();
            }
        }
    </script>
    <!-- H. JUNIOR -->

@endsection
