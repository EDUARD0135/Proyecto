<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <title>@yield('titulo')</title>

    <style>
    body {
    background-color:rgb(234, 236, 238);
    color: black;
    font-family: Times , sans-serif;
    }
    
    .card-header {
    background-color: black;
    color: white;
    text-align: center;
    padding: 10px;
    }
  
    ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
   }

  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary" class="navbar bg-dark border-bottom border-body" data-bs-theme="dark">
<a class="navbar-brand">BIBLIOTECA VIRTUAL</a>  
<div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <b>ESCOGE UNA TABLA</b>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('libro.index')}}">Libros</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{route('prestamo.index')}}">Prestamos </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="{{route('usuario.index')}}">Usuarios</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
</body>
<div>
    @yield('contenido')
</div>
</html>