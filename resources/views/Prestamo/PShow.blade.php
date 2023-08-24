@extends('Plantilla')

@section('titulo','Show')

@section('contenido')

<br>
<br>
<div class="container" style="max-width: 600px;" >
    
<div class="card">
  <h4 class="card-header"><center><b><ul>DATOS DEL PRESTAMO</ul></b></center></h4>
    <div class="card">
    <div class="card-body">

    <p class="card-title"><center><b>NOMBRE DEL LIBRO:</b><br>
        {{$prestamo->libro->titulo}}</center></p>

    <p class="card-title"><center><b>ID DEL LIBRO:</b><br>
       {{$prestamo->libro_id}}</center></p>

    <p class="card-title"><center><b>NOMBRE DEL USUARIO:</b><br>
       {{$prestamo->usuario->nombre}}</center></p>

       <p class="card-title"><center><b>ID DEL USUARIO:</b><br>
        {{$prestamo->usuario_id}}</center></p>

    <p class="card-title"><center><b>FECHA DE SOLICITUD:</b><br>
      {{$prestamo->fecha_solicitud}}</center></p>

    <p class="card-title"><center><b>FECHA DEL PRESTAMO:</b><br>
     {{$prestamo->fecha_prestamo}}</center></p>

    <p class="card-title"><center><b>FECHA DE DEVOLUCION</b><br>
        {{$prestamo->fecha_devolucion}}</center></p>
    
    
    <div><center>
    <a href="{{ route('prestamo.index') }}" class="btn btn-success">Volver</a>
    </center></div>
   </div>
  </div>
 </div>
</div>

@endsection()