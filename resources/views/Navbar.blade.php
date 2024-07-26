<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('titulo')</title>
    <link rel="icon" href="{{ asset('img/LogoLucem2.png') }}" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport"
        content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height, target-densitydpi=device-dpi" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS (v5.3.0) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <!-- Font Awesome (v6.0.0-beta3) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Bootstrap JS (v5.3.0) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <!-- jQuery (v3.5.1 slim) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Popper.js (v2.11.8) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <!-- Bootstrap JS (v4.5.2) -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="styles.css">

    <!-- Google Fonts - Pacifico -->
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <style>
        .black-box {
            background-color: black;
            color: black;
            border-radius: 10px;
            height: 40px;
            width: 170px;
        }

        .white-box {
            background-color: white;
            border-radius: 10px;
            height: 40px;
            width: 100px;
        }
    </style>

</head>

<body>

    <!-- INICIO NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light shadow">
        <div class="container">

            <a class="navbar-brand text-success logo h1" href="{{ route('Inicio') }}">
                <span style="font-size: 30px;">LucemStore </span>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#templatemo_main_nav"
                aria-controls="templatemo_main_nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="templatemo_main_nav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link mx-5" href="{{ route('Inicio') }}">INICIO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-5" href="{{ route('Tienda') }}">PRODUCTOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-5" href="{{ route('Ofertas') }}">OFERTAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mx-5" href="{{ route('UsuariosTienda') }}">TIENDAS</a>
                    </li>
                </ul>

                <div class="navbar align-self-center d-flex">
                    <a class="nav-icon position-relative text-decoration-none" href="{{ route('Favoritos') }}">
                        <i class="fa fa-fw fa-heart text-dark"></i>
                        @if (session('usuario'))
                            <span
                                class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">{{ session('cantidadFavoritos') }}</span>
                        @else
                            <span
                                class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">0</span>
                        @endif
                    </a>

                    <a class="nav-icon position-relative text-decoration-none mx-4" href="{{ route('Pedidos') }}">
                        <i class="fa fa-fw fa-cart-arrow-down text-dark"></i>
                        @if (session('usuario'))
                            <span
                                class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">{{ session('cantidadPedidos') }}</span>
                        @else
                            <span
                                class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark">0</span>
                        @endif
                    </a>

                    @if (session('usuario'))
                        <a class="nav-link" href="{{ route('usuarioPerfil') }}"
                            style="text-transform: uppercase;">{{ session('usuario')->nombre_usuario }}</a>
                    @else
                        <a class="nav-icon position-relative text-decoration-none" href="{{ route('usuario.login') }}">
                            <i class="fa fa-fw fa-user text-dark"></i>
                            <span
                                class="position-absolute top-0 lefnslt-100 traate-middle badge rounded-pill bg-light text-dark"></span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <!-- FINAL NAVBAR -->

    <div>
        @yield('todo')
    </div>

    <!-- INICIO PARTE DE ABAJO -->
    <footer class="footer py-3 bg-dark text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>Contacto</h5>
                    <ul class="list-unstyled">
                        <li><i class="fa fa-map-marker"></i> Dirección: UNAH-TEC DANLI, EL Paraiso, Honduras</li>
                        <li><i class="fa fa-phone"></i> Teléfono: +504 95114411</li>
                        <li><i class="fa fa-envelope"></i> Correo electrónico: lucem.store50@gmail.com</li>
                    </ul>
                </div>
            </div>
            <hr>
            <p class="text-center">&copy; 2024 LucemStore. Todos los Derechos Reservados.</p>
            <div class="text-center">
                <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>


    <!-- LINEA NEGRA OSCURA -->
    <div class="w-100 bg-black py-3">
        <div class="container">
            <div class="row pt-2">
                <div class="col-12">
                </div>
            </div>
        </div>
    </div>
    </footer>
    <!-- FIN PARTE DE ABAJO -->

</body>

</html>
