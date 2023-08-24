@extends('Plantilla')

@section('titulo','EDIT')

@section('contenido')

<br><br>
<form  method="POST" action="{{route('libro.update',[$libros->id])}}" class0="needs-validation">
@method("PUT")
@csrf

<div class="container" style="max-width: 600px;" >  
<div class="card">
  <h4 class="card-header"><center><b><ul>EDITAR DATOS DEL LIBRO</ul></b></center></h4>
    <div class="card">
    <div class="card-body">

    <div class="card-title"><center><b>TITULO:</b>
    <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
    name="titulo"  id="titulo" placeholder="Ingrese el Nuevo Titulo" value="{{old('titulo') ?? $libros->titulo}}">
    
    @error('titulo')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>AUTOR:</b>
    <input type="text" class="form-control @error('autor') is-invalid @enderror" 
    name="autor"  id="autor" placeholder="Ingrese el Nuevo Autor" value="{{old('autor') ?? $libros->autor}}">

    @error('autor')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>EDITORIA:</b>
    <input type="text" class="form-control @error('editorial') is-invalid @enderror" 
    name="editorial"  id="editorial" placeholder="Ingrese Nueva la Editorial" value="{{old('editorial') ?? $libros->editorial}}">

    @error('editorial')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>

    <div class="card-title"><center><b>AÑO DE PUBLICACION:</b>
    <input type="text" class="form-control @error('año_publicacion') is-invalid @enderror" 
    name="año_publicacion"  id="año_publicacion" placeholder="Ingrese el Nuevo Año de Publicacion" value="{{old('año_publicacion') ?? $libros->año_publicacion}}">

    @error('año_publicacion')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div><br>


    <div class="card-title"><center><b>CANTIDAD DISPONIBLE</b>
    <input type="text" class="form-control @error('cantidad_disponible') is-invalid @enderror" 
    name="cantidad_disponible"  id="cantidad_disponible" placeholder="Ingrese la Nueva Cantidad Disponible" value="{{old('cantidad_disponible') ?? $libros->cantidad_disponible}}">
    
    @error('cantidad_disponible')
        <div class ="invalid-feedback">{{$message}}</div>
    @enderror
    </div>
    <br>

    <div><center>
    <input type="submit" class="btn btn-primary" value="Editar">
    <a href="{{ route('libro.index') }}" class="btn btn-success">Volver</a>
    </center></div>

   </div>
  </div>
 </div>
</div>
</form>
@endsection()