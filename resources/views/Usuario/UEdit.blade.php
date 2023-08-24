@extends('Plantilla')

@section('titulo','EDIT')

@section('contenido')

<br><br>
<form  method="POST" action="{{route('usuario.update',[$usuarios->id])}}" class0="needs-validation">
@method("PUT")
@csrf

<div class="container" style="max-width: 600px;" >  
<div class="card">
  <h4 class="card-header"><center><b><ul>EDITAR DATOS DEL USUARIO</ul></b></center></h4>
    <div class="card">
    <div class="card-body">

    <div class="card-title"><center><b>NOMBRE:</b>
    <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
    name="nombre"  id="nombre" placeholder="Ingrese El Nuevo Nombre" value="{{old('nombre') ?? $usuarios->nombre}}">
    
    @error('nombre')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>CORREO ELECTRONICO:</b>
    <input type="text" class="form-control @error('correo_electronico') is-invalid @enderror" 
    name="correo_electronico"  id="correo_electronico" placeholder="Ingrese El Nuevo Correo" value="{{old('correo_electronico') ?? $usuarios->correo_electronico}}">

    @error('correo_electronico')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>TELEFONO:</b>
    <input type="number" class="form-control @error('teléfono') is-invalid @enderror" 
    name="teléfono"  id="teléfono" placeholder="Ingrese El Nuevo eléfono" value="{{old('teléfono') ?? $usuarios->teléfono}}">

    @error('teléfono')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>DIRECCION DEL USUARIO:</b>
    <input type="text" class="form-control @error('direccion') is-invalid @enderror" 
    name="direccion"  id="direccion" placeholder="Ingrese La Nueva direccion" value="{{old('direccion') ?? $usuarios->direccion}}">

    @error('direccion')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div><center>
    <input type="submit" class="btn btn-primary" value="Editar">
    <a href="{{ route('usuario.index') }}" class="btn btn-success">Volver</a>
    </center></div>

   </div>
  </div>
 </div>
</div>
</form>
@endsection()