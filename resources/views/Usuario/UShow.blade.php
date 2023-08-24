@extends('Plantilla')

@section('titulo','Show')

@section('contenido')

<br>
<br>
<div class="container" style="max-width: 600px;" >
    
<div class="card">
  <h4 class="card-header"><center><b><ul>DATOS DEL USUARIO</ul></b></center></h4>
    <div class="card">
    <div class="card-body">

    <p  class="card-title"><center><b>NOMBRE:</b><br>
        {{$usuario->nombre}}</center></p>

    <p  class="card-title"><center><b>CORREO ELECTRONICO:</b><br>
        {{$usuario->correo_electronico}}</center></p>

    <p  class="card-title"><center><b>TELEFONO:</b><br>
        {{$usuario->teléfono}}</center></p>

    <p class="card-title"><center><b>DIRECCION DEL USUARIO:</b><br>
     {{$usuario->direccion}}</center></p>

     @forelse($usuario->prestamos as $prestamo)
     <p class="card-title"><center><b>FECHA DE SOLICITUD DEL USUARIO</b><br>
     {{$prestamo->fecha_solicitud}}</center></p>

     <p class="card-title"><center><b>FECHA DEL PRESTAMO DEL USUARIO</b><br>
     {{$prestamo->fecha_prestamo}}</center></p>
     
     <p class="card-title"><center><b>FECHA DE LA DEVOLUCION DEL USUARIO</b><br>
     {{$prestamo->fecha_devolucion}}</center></p>
     
     @empty
     <p class="card-title"><center><b>FECHA DE SOLICITUD DEL USUARIO</b><br>
     No ahi fecha</center></p></center></p>

     <p class="card-title"><center><b>FECHA DEL PRESTAMO DEL USUARIO</b><br>
     No ahi fecha</center></p></center></p>
 
     <p class="card-title"><center><b>FECHA DE LA DEVOLUCION DEL USUARIO</b><br>
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