@extends('Plantilla')

@section('titulo','Create')

@section('contenido')

<br><br>
<form  method="POST" action="{{route('libro.crear')}}" class0="needs-validation">
@csrf

<div class="container" style="max-width: 600px;" >  
<div class="card">

  <h4 class="card-header"><center><b><ul>CREAR DATOS DEL LIBRO</ul></b></center></h4>
    <div class="card">
    <div class="card-body">

    <div class="card-title"><center><b>TITULO:</b>
    <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
    name="titulo"  id="titulo" placeholder="Ingrese El Titulo" value="{{old('titulo')}}">
    
    @error('titulo')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>AUTOR:</b>
    <input type="text" class="form-control @error('autor') is-invalid @enderror" 
    name="autor"  id="autor" placeholder="Ingrese El Autor" value="{{old('autor')}}">

    @error('autor')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>EDITORIA:</b>
    <input type="text" class="form-control @error('editorial') is-invalid @enderror" 
    name="editorial"  id="editorial" placeholder="Ingrese La Editorial" value="{{old('editorial')}}">

    @error('editorial')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>AÑO DE PUBLICACION:</b>
    <input type="text" class="form-control @error('año_publicacion') is-invalid @enderror" 
    name="año_publicacion"  id="año_publicacion" placeholder="Ingrese El Año de Publicacion" value="{{old('año_publicacion')}}">

    @error('año_publicacion')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>


    <div class="card-title"><center><b>CANTIDAD DISPONIBLE</b>
    <input type="number" class="form-control @error('cantidad_disponible') is-invalid @enderror" 
    name="cantidad_disponible"  id="cantidad_disponible" placeholder="Ingrese la Cantidad Disponible" value="{{old('cantidad_disponible')}}">
    
    @error('cantidad_disponible')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div>
    <br>

    <div><center>
    <input type="submit" class="btn btn-primary" value="Crear">
    <a href="{{ route('libro.index') }}" class="btn btn-success">Volver</a>
    </center></div>

   </div>
  </div>
 </div>
</div>
</form>
@endsection()