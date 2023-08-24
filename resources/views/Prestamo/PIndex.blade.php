@extends('Plantilla')

@section('titulo','index')

@section('contenido')

@if(session('mensaje'))
    <div class="alert alert-success d-flex align-items-center position-relative" role="alert">
        {{session('mensaje')}}
        <button type="button" class="btn-close position-absolute top-1 end-0" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<br>
<h1><center><b><i><u>Lista de Prestamos</u></i></b></center></h1>

<div class="container">
    <h5><center>BUSCAR</center></h5>
    <div class="row" ALIGN="center">
      <div class="col-xl-12" ALIGN="center">
        <form action="{{ route('prestamo.index')}}" method="get">
          <div class="form-row">
            <div class="col-sm-4">
              <input type="text" class="form-control" name="buscar" value="{{$PrestamoBuscar}}">
            </div>
            <div class="col-auto">
              <br>
              <input type="submit" class="btn btn-primary" value="Buscar">
              <a class="btn btn-success" href="{{ route('prestamo.index') }}">Volver</a>
              <a href="{{ route('prestamo.crear') }}" class="btn btn-warning">Crear</a>
            </div>
          </div>
        </form>
      </div>
      <div class="col-xl-12">
      </div>
    </div>
  </div>
 <br>

<div class="container"> 
<table class="table table-bordered border-black" class>
    <thead class="table-dark">
        <th class="table-dark"><center>ID</center></th>
        <th><center>FECHA DEL PRESTAMO</center></th>
        <th><center>ID LIBRO</center></th>
        <th><center>ID USUARIO</center></th>
        <th colspan="3"><center>OPCIONES</center></th>
    </thead>
    <tbody>
        @forelse($prestamos as $prestamo)
        <tr>
        <td class="table-dark"><center>{{$prestamo->id}}</center></td>
        <td><center>{{$prestamo->fecha_prestamo}}</center></td>
        <td><center>{{$prestamo->libro_id}}</center></td>
        <td><center>{{$prestamo->usuario_id}}</center></td>
        <td><center><a class="btn btn-success" href= "{{route('prestamo.show', ['id'=>$prestamo->id])}}"><u>Ver Datos</u></a></center></td>
        <td><center><a class="btn btn-primary" href= "{{route('prestamo.editar', ['id'=>$prestamo->id])}}"><u>Editar Datos</u></a></center></td>
 
        <td><center>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-{{$prestamo->id}}">
            Eliminar Datos     
            </button>

            <form  method="post" action="{{route('prestamo.borrar',[$prestamo->id])}}">
            @method("DELETE")
            @csrf

            <div class="modal" id="modal-{{$prestamo->id}}" tabindex="-1">
             <div class="modal-dialog">
               <div class="modal-content">
                 <div class="modal-header">
                    <h5 class="modal-title">Eliminar este Dato</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                      <div class="modal-body">
                     <p>¿QUIERE ELIMINAR PERMANENTEMENTE ESTE DATO?</p>
                    </div>
                    <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                     <button type="submit" class="btn btn-danger">Eliminar</button>
                    </div>
                  </div>
               </div>
            </div>
            </form>
         </center></td>
          
        </tr>
        @empty
        <tr>
            <td>NO AHI PRESTAMOSS</td>
        </tr>
        @endforelse

    </tbody>
</table>
</div>
<br>

<style>
    .custom-center {
        display: flex;
        justify-content: center;
    }
</style>

<div class="custom-center">
    {{ $prestamos->render('pagination::bootstrap-4') }}
</div>


@endsection()