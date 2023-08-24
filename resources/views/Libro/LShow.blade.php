@extends('Plantilla')

@section('titulo','Show')

@section('contenido')

<br>
<br>
<div class="container" style="max-width: 600px;" >
    
<div class="card">
  <h4 class="card-header"><center><b><ul>DATOS DEL LIBRO</ul></b></center></h4>
    <div class="card">
    <div class="card-body">

    <p class="card-title"><center><b>TITULO:</b><br>
        {{$libro->titulo}}</center></p>

    <p class="card-title"><center><b>AUTOR:</b><br>
          {{$libro->autor}}</center></p>

    <p class="card-title"><center><b>EDITORIA:</b><br>
      {{$libro->editorial}}</center></p>

    <p class="card-title"><center><b>AÑO DE PUBLICACION:</b><br>
     {{$libro->año_publicacion}}</center></p>

    <p class="card-title"><center><b>CANTIDAD DISPONIBLE</b><br>
        {{$libro->cantidad_disponible}}</center></p>

     @forelse($libro->prestamos as $prestamo)
     <p class="card-title"><center><b>FECHA DE SOLICITUD DEL LIBRO</b><br>
     {{$prestamo->fecha_solicitud}}</center></p>

     <p class="card-title"><center><b>FECHA DEL PRESTAMO DEL LIBRO</b><br>
     {{$prestamo->fecha_prestamo}}</center></p>
     
     <p class="card-title"><center><b>FECHA DE LA DEVOLUCION DEL LIBRO</b><br>
     {{$prestamo->fecha_devolucion}}</center></p>
     
     @empty
     <p class="card-title"><center><b>FECHA DE SOLICITUD DEL LIBRO</b><br>
     No ahi fecha</center></p></center></p>

     <p class="card-title"><center><b>FECHA DEL PRESTAMO DEL LIBRO</b><br>
     No ahi fecha</center></p></center></p>
 
     <p class="card-title"><center><b>FECHA DE LA DEVOLUCION DEL LIBRO</b><br>
     No ahi fecha</center></p></center></p>
     @endforelse

    <div><center>
    <a href="{{ route('libro.index') }}" class="btn btn-success">Volver</a>
    </center></div>

   </div>
  </div>
 </div>
</div>

@endsection()