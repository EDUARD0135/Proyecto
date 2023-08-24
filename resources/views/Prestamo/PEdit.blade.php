@extends('Plantilla')

@section('titulo','EDIT')

@section('contenido')

<br><br>
<form  method="POST" action="{{route('prestamo.update',[$prestamos->id])}}" class0="needs-validation">
@method("PUT")
@csrf

<div class="container" style="max-width: 600px;" >  
<div class="card">
  <h4 class="card-header"><center><b><ul>EDITAR DATOS DEL PRESTAMO</ul></b></center></h4>
    <div class="card">
    <div class="card-body">

    <div class="card-title"><center><b>FECHA DE SOLICITUD:</b>
    <input type="text" class="form-control @error('fecha_solicitud') is-invalid @enderror" 
    name="fecha_solicitud"  id="fecha_solicitud" placeholder="La Nueva Fecha" value="{{old('fecha_solicitud') ?? $prestamos->fecha_solicitud}}">
    
    @error('fecha_solicitud')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>FECHA DEL PRESTAMO:</b>
    <input type="text" class="form-control @error('fecha_prestamo') is-invalid @enderror" 
    name="fecha_prestamo"  id="fecha_prestamo" placeholder="La Nueva Fecha" value="{{old('fecha_prestamo') ?? $prestamos->fecha_prestamo}}">

    @error('fecha_prestamo')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>FECHA DE DEVOLUCION:</b>
    <input type="text" class="form-control @error('fecha_devolucion') is-invalid @enderror" 
    name="fecha_devolucion"  id="fecha_devolucion" placeholder="La Nueva Fecha" value="{{old('fecha_devolucion') ?? $prestamos->fecha_devolucion}}">

    @error('fecha_devolucion')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>ID DEL LIBRO:</b>
    <input type="text" class="form-control @error('libro_id') is-invalid @enderror" 
    name="libro_id"  id="libro_id" placeholder="Ingrese el Nuevo Id del Libro" value="{{old('libro_id') ?? $prestamos->libro_id}}">

    @error('libro_id')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>


    <div class="card-title"><center><b>ID DEL USUARIO</b>
    <input type="text" class="form-control @error('usuario_id') is-invalid @enderror" 
    name="usuario_id"  id="usuario_id" placeholder="Ingrese el Nuevo Id del Usuario" value="{{old('usuario_id') ?? $prestamos->usuario_id}}">
    
    @error('usuario_id')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div>
    <br>

    <div><center>
    <input type="submit" class="btn btn-primary" value="Editar">
    <a href="{{ route('prestamo.index') }}" class="btn btn-success">Volver</a>
    </center></div>


   </div>
  </div>
 </div>
</div>
</form>
@endsection()