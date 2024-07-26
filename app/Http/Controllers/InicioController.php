<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Buscar;
use App\Models\Producto;
use App\Models\Comentario;
use App\Models\Like;
use App\Models\Dislike;
use App\Models\Usuario;
use App\Models\Pedido;
use App\Models\Oferta;
use App\Models\Favorito;
use App\Models\Nuevo;


class InicioController extends Controller
{

    // H. JUNIOR / A. EDUARDO / A. ELVIN
    public function perfil()
    {
        $usuario = session('usuario');
        $ImagenFondo = asset('img/ImagenFondo.jpg');

        $productos = Producto::where('usuario_id', $usuario->id)->paginate(100);
        $ofertas = Oferta::where('usuario_id', $usuario->id)->paginate(100);

        return view('Perfil.perfil', ['productos' => $productos, 'ofertas' => $ofertas, 'ImagenFondo' => $ImagenFondo]);
    }
    // H. JUNIOR / A. EDUARDO / A. ELVIN


    // INICIO INICIO
    // H. ELVIN / H. EDUARDO
    public function Inicio()
    {
        $ImagenFondo = asset('img/FondoLucemStoreProductos.jpg');
        $ImagenRopa = asset('img/CaRopa.jpg');
        $ImagenAccesorios = asset('img/CaAccesorios.jpg');
        $ImagenAlimentos = asset('img/CaComida.jpg');

        // Obtener los últimos productos agregados
        $ultimosProductos = Producto::latest()->take(3)->get();

        // Pasar la URL de la imagen y los productos a la vista
        return view('Inicio')->with([
            'ImagenRopa' => $ImagenRopa,
            'ImagenAccesorios' => $ImagenAccesorios,
            'ImagenAlimentos' => $ImagenAlimentos,
            'ImagenFondo' => $ImagenFondo,
            'ultimosProductos' => $ultimosProductos, // Pasar los últimos productos a la vista
        ]);
    }
    // H. ELVIN / H. EDUARDO
    // FIN INICIO



    // INICIO USUARIOSTIENDA
    // A. EDUARDO
    public function UsuariosTienda(Request $request)
    {
        $ImagenFondo = asset('img/FondoLucemStoreProductos.jpg');

        // Obtener la consulta base de usuarios
        $query = Usuario::query();

        // Realizar la búsqueda si hay un término de búsqueda
        if ($request->has('q')) {
            $searchTerm = $request->input('q');
            $query->where('nombre_usuario', 'like', "%$searchTerm%");
        }

        // Filtrar usuarios que tengan productos o ofertas
        $query->whereHas('productos')
            ->orWhereHas('ofertas');

        // Obtener los usuarios paginados
        $usuarios = $query->paginate(8);

        return view('UsuariosTienda')->with('usuarios', $usuarios)->with('ImagenFondo', $ImagenFondo);
    }
    // A. EDUARDO
    // FIN USUARIOSTIENDA


    // INCIO TIENDA
    // H. KELEN / H. EDUARDO / H. ELVIN
    public function Tienda(Request $request)
    {
        // H. EDUARDO
            $ProductoBuscar = $request->get('buscar');
            session(['ProductoBuscar' => $ProductoBuscar]); // Almacenar en la sesión

            // Obtener la ruta pública de la imagen para pasarla a la vista
            $ImagenFondo = asset('img/FondoLucemStoreProductos.jpg');

            // Obtener la categoría seleccionada
            $categoriaSeleccionada = $request->get('categoria');
        // H. EDUARDO

        // H. KELEN 
            // Obtener el filtro de precio seleccionado
            $filtroPrecio = $request->get('precio');

            // Obtener el filtro de nombre seleccionado
            $filtroNombre = $request->get('nombre');
        // H. KELEN 

        // H. EDUARDO
            $query = DB::table('productos')
                ->select('id', 'nombre', 'Imagen', 'descripcion', 'precio', 'categoria');

            // Verificar si hay un usuario activo y excluir sus productos
            if (session()->has('usuario')) {
                $userId = session('usuario')->id;
                $query->where('usuario_id', '!=', $userId);
            }

            // Aplicar el filtro de búsqueda por nombre
            if ($ProductoBuscar) {
                $query->where('nombre', 'LIKE', '%' . $ProductoBuscar . '%');
            }

            // Aplicar el filtro de categoría si está seleccionada
            if ($categoriaSeleccionada) {
                $query->where('categoria', $categoriaSeleccionada);
            }
        // H. EDUARDO
        
        // H. KELEN 
            // Aplicar el filtro de precio
            if ($filtroPrecio === 'CARO') {
                $query->orderBy('precio', 'desc');
            } elseif ($filtroPrecio === 'BARATO') {
                $query->orderBy('precio', 'asc');
            }

            // Aplicar el filtro Alfabético
            if ($filtroNombre === 'DESCENDENTE') {
                $query->orderBy('nombre', 'desc');
            } elseif ($filtroNombre === 'ASCENDENTE') {
                $query->orderBy('nombre', 'asc');
            }

            $productos = $query->paginate(9);
        // H. KELEN

        // H. ELVIN
            // Actualizar la tabla de búsquedas solo si hay al menos un producto encontrado
            if ($ProductoBuscar && $productos->count() > 0) {
                // ... (código existente para actualizar las búsquedas)
            }

            // Obtener las 10 búsquedas más populares
            if ($ProductoBuscar && $productos->count() > 0) {
                $buscar = Buscar::firstOrNew(['term' => $ProductoBuscar]);
                $buscar->increment('count');

                // Obtener la imagen del primer producto encontrado
                $primerProducto = $productos->first();
                if ($primerProducto) {
                    $buscar->Imagen = $primerProducto->Imagen;
                }

                $buscar->save();
            }

            // Obtener las 10 búsquedas más populares
            $busquedasPopulares = Buscar::orderBy('count', 'desc')->take(10)->get(['term', 'count', 'Imagen']);
        // H. ELVIN

        // H. KELEN
        return view('Productos.Tienda', compact('productos', 'ProductoBuscar', 'busquedasPopulares', 'ImagenFondo'));
    }
    // H. KELEN / H. EDUARDO / H. ELVIN

    
    // A. EDUARDO
    public function AgregarProductoPerfil(Request $request, $oferta_id)
    {
        // Recupera el producto que deseas agregar al pedido
        $oferta = Oferta::find($oferta_id);

        // Crea un nuevo objeto de oferta y asigna los datos del producto
        $producto = new Producto();
        $producto->nombre = $oferta->nombre;
        $producto->categoria = $oferta->categoria;
        $producto->descripcion = $oferta->descripcion;
        $producto->usuario_id = $oferta->usuario_id;
        $producto->precio = $oferta->precio;
        $producto->Imagen = $oferta->Imagen; // Asegúrate de usar el nombre correcto del atributo

        // Guarda la oferta en la base de datos
        $producto->save();

        // Elimina el producto de la tabla de productos
        $oferta->delete();

        // Redirecciona a una página de confirmación o a donde lo necesites
        return redirect()->route('Tienda');
    }
    // A. EDUARDO


    // INICIO OFERTA  
    // H. SANDY 
    public function Ofertas(Request $request)
    {
        $OfertaBuscar = $request->get('buscar');
        session(['OfertaBuscar' => $OfertaBuscar]); // Almacenar en la sesión

        // Establecer la variable de sesión, ESTO HACE QUE NO AFECTE MAS VISTA SOLO DONDE ESTA SELECIONADA

        // Obtener la ruta pública de la imagen para pasarla a la vista
        $ImagenFondo = asset('img/FondoLucemStoreProductos.jpg');

        // Obtener la categoría seleccionada
        $categoriaSeleccionada = $request->get('categoria');

        // Obtener el filtro de precio seleccionado
        $filtroPrecio = $request->get('precio');

        // Obtener el filtro de nombre seleccionado
        $filtroNombre = $request->get('nombre');

        $query = DB::table('ofertas')
            ->select('id', 'nombre', 'Imagen', 'descripcion', 'precio', 'categoria');

        // Verificar si hay un usuario activo y excluir sus productos
        if (session()->has('usuario')) {
            $userId = session('usuario')->id;
            $query->where('usuario_id', '!=', $userId);
        }

        // Aplicar el filtro de búsqueda por nombre
        if ($OfertaBuscar) {
            $query->where('nombre', 'LIKE', '%' . $OfertaBuscar . '%');
        }

        // Aplicar el filtro de categoría si está seleccionada
        if ($categoriaSeleccionada) {
            $query->where('categoria', $categoriaSeleccionada);
        }

        // Aplicar el filtro de precio
        if ($filtroPrecio === 'CARO') {
            $query->orderBy('precio', 'desc');
        } elseif ($filtroPrecio === 'BARATO') {
            $query->orderBy('precio', 'asc');
        }

        // Aplicar el filtro Alfabetico
        if ($filtroNombre === 'DESCENDENTE') {
            $query->orderBy('nombre', 'desc');
        } elseif ($filtroNombre === 'ASCENDENTE') {
            $query->orderBy('nombre', 'asc');
        }

        $ofertas = $query->paginate(9);

        // Actualizar la tabla de búsquedas solo si hay al menos un producto encontrado
        if ($OfertaBuscar && $ofertas->count() > 0) {
            // ... (código existente para actualizar las búsquedas)
        }

        // Obtener las 10 búsquedas más populares
        // Actualizar la tabla de búsquedas solo si hay al menos un producto encontrado
        if ($OfertaBuscar && $ofertas->count() > 0) {
            $buscar = Buscar::firstOrNew(['term' => $OfertaBuscar]);
            $buscar->increment('count');

            // Obtener la imagen del primer producto encontrado
            $primerOferta = $ofertas->first();
            if ($primerOferta) {
                $buscar->Imagen = $primerOferta->Imagen;
            }

            $buscar->save();
        }

        $ofertas = $query->paginate(9);

        // Obtener las 10 búsquedas más populares
        $busquedasPopulares = Buscar::orderBy('count', 'desc')->take(10)->get(['term', 'count', 'Imagen']);

        return view('Productos.Ofertas', compact('ofertas', 'OfertaBuscar', 'busquedasPopulares', 'ImagenFondo'));
    }
    // H. SANDY 


    // A. EDUARDO
    public function AgregarPedidoOferta(Request $request, $oferta_id)
    {
        // Verifica si hay un usuario en sesión
        if ($request->session()->has('usuario')) {
            // Recupera el producto que deseas agregar al pedido
            $oferta = Oferta::find($oferta_id);

            // Verifica que el producto existe
            if (!$oferta) {
                return redirect()->route('Ofertas');
            }

            // Recupera el ID del usuario en sesión
            $usuario_id = $request->session()->get('usuario')->id;

            // Crea un nuevo pedido usando los datos de la oferta y el ID del usuario en sesión
            $pedido = new Pedido();
            $pedido->nombre = $oferta->nombre;
            $pedido->categoria = $oferta->categoria;
            $pedido->descripcion = $oferta->descripcion;
            $pedido->precio = $oferta->precio;

            // Recupera la cantidad seleccionada desde la solicitud y asegúrate de que sea un número entero
            $cantidad = (int)$request->input('quantity', 1);

            // Asigna la cantidad seleccionada al pedido
            $pedido->cantidad = $cantidad;

            $pedido->usuario_id = $oferta->usuario_id;
            $pedido->comprador_id = $usuario_id; // Asigna el ID del usuario en sesión
            $pedido->Imagen = $oferta->Imagen;


            // Guarda el pedido en la base de datos
            $pedido->save();

            // Redirecciona a una página de confirmación o a donde lo necesites
            return redirect()->route('Pedidos');
        } else {
            // Redirecciona al inicio de sesión si el usuario no está autenticado
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para realizar un pedido.');
        }
    }
    // A. EDUARDO


    // A. EDUARDO
    public function AgregarFavoritoOferta(Request $request, $oferta_id)
    {
        // Verifica si hay un usuario en sesión
        if ($request->session()->has('usuario')) {
            // Recupera el producto que deseas agregar al pedido
            $oferta = Oferta::find($oferta_id);

            // Verifica que el producto existe
            if (!$oferta) {
                return redirect()->route('Ofertas');
            }

            // Recupera el ID del usuario en sesión
            $usuario_id = $request->session()->get('usuario')->id;

            // Crea un nuevo pedido usando los datos del producto y el ID del usuario en sesión
            $favorito = new Favorito();
            $favorito->nombre = $oferta->nombre;
            $favorito->categoria = $oferta->categoria;
            $favorito->descripcion = $oferta->descripcion;
            $favorito->precio = $oferta->precio;
            $favorito->cantidad = $oferta->cantidad;
            $favorito->usuario_id = $oferta->usuario_id;
            $favorito->comprador_id = $usuario_id; // Asigna el ID del usuario en sesión
            $favorito->Imagen = $oferta->Imagen;

            // Guarda el pedido en la base de datos
            $favorito->save();

            // Redirecciona a una página de confirmación o a donde lo necesites
            return redirect()->route('Favoritos');
        } else {
            // Redirecciona al inicio de sesión si el usuario no está autenticado
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para realizar un pedido.');
        }
    }
    // A. EDUARDO


    // H. SANDY / A JUIOR / A. ELVIN
    public function ShowOferta(string $id)
    {
        $oferta = Oferta::find($id);
        $ofertas = Oferta::where('categoria', $oferta->categoria)->where('id', '!=', $oferta->id)->take(3)->get(); // ESE 3 ES EL NUMERO DE PRODUCTOS PARECIDOS
        // Incluye la relación 'usuario' para obtener la información del usuario que hizo el comentario
        $comentarios = Comentario::with('usuario')->where('oferta_id', $oferta->id)->get();
        // Obtener la cantidad de likes para el producto
        $likes = Like::where('oferta_id', $oferta->id)->count();
        // Obtener la cantidad de dislikes para el producto
        $dislikes = Dislike::where('oferta_id', $oferta->id)->count();

        return view('Shows.ShowOferta', compact('oferta', 'ofertas', 'comentarios', 'likes', 'dislikes'));
    }
    // H. SANDY / A JUIOR / A. ELVIN


    // A. EDUARDO
    public function ShowOfertaPerfil(string $id)
    {
        $oferta = Oferta::find($id);
        $ofertas = Oferta::where('categoria', $oferta->categoria)->where('id', '!=', $oferta->id)->take(3)->get(); // ESE 3 ES EL NUMERO DE PRODUCTOS PARECIDOS
        $comentarios = Comentario::with('usuario')->where('oferta_id', $oferta->id)->get();
        $likes = Like::where('oferta_id', $oferta->id)->count();
        $dislikes = Dislike::where('oferta_id', $oferta->id)->count();

        return view('Shows.ShowOfertaPerfil', compact('oferta', 'ofertas', 'comentarios', 'likes', 'dislikes'));
    }
    // A. EDUARDO


    // A. EDUARDO
    public function AgregarOferta(Request $request, $producto_id)
    {
        // Recupera el producto que deseas agregar al pedido
        $producto = Producto::find($producto_id);

        // Crea un nuevo objeto de oferta y asigna los datos del producto
        $oferta = new Oferta();
        $oferta->nombre = $producto->nombre;
        $oferta->categoria = $producto->categoria;
        $oferta->descripcion = $producto->descripcion;
        $oferta->usuario_id = $producto->usuario_id;
        $oferta->precio = $request->input('precio');
        $oferta->Imagen = $producto->Imagen; // Asegúrate de usar el nombre correcto del atributo

        // Guarda la oferta en la base de datos
        $oferta->save();

        // Elimina el producto de la tabla de productos
        $producto->delete();

        // Redirecciona a una página de confirmación o a donde lo necesites
        return redirect()->route('Ofertas');
    }
    // A. EDUARDO


    // A. EDUARDO
    public function EliminarOferta(string $id)
    {
        Oferta::destroy($id);

        return redirect()->route('usuarioPerfil');
    }
    // A. EDUARDO


    // A. EDUARDO
    public function agregarComentarioOferta(Request $request, $ofertaId)
    {
        // Valida el formulario y verifica si el usuario está autenticado
        if (!session()->has('usuario_id')) {
            // El usuario está autenticado, procede a guardar el comentario
            $comentario = new Comentario();
            $comentario->contenido = $request->input('contenido');
            $comentario->oferta_id = $ofertaId;
            $comentario->producto_id = null; // Establece el id de producto como nulo
            $comentario->usuario_id = session('usuario')->id;
            $comentario->save();

            return redirect()->back()->with('success', 'Comentario guardado correctamente.');
        } else {
            // El usuario no está autenticado, redirige a una página que requiera autenticación
            // En este ejemplo, estoy redirigiendo al formulario de inicio de sesión
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para comentar.');
        }
    }
    // A. EDUARDO


    // A. EDUARDO
    public function EliminarComentarioOferta(string $id)
    {
        $comentario = Comentario::findOrFail($id); // Obtener el comentario que se está eliminando
        $ofertaId = $comentario->oferta_id;

        Comentario::destroy($id);

        return redirect()->route('ShowOferta', ['id' => $ofertaId]);
    }
    // A. EDUARDO


    // H. ELVIN 
    public function like(Request $request, $ofertaId)
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('usuario_id')) {
            // Obtener el usuario_id de la sesión
            $usuarioId = session('usuario')->id;

            // Verificar si ya existe un like para este usuario y producto
            $likeExistente = Like::where('usuario_id', $usuarioId)
                ->where('oferta_id', $ofertaId)
                ->exists();

                if ($likeExistente) {
                    // El usuario ya ha dado like a este producto
                    Like::where('usuario_id', $usuarioId)
                         ->where('oferta_id', $ofertaId)
                        ->delete();
                    return redirect()->back()->with('error', 'Ya has dado like a este producto.');
                }

            // Crear un nuevo like
            $like = new Like();
            $like->usuario_id = session('usuario')->id;
            $like->producto_id = null;
            $like->oferta_id = $ofertaId;
            $like->save();

            return redirect()->back()->with('success', 'Like guardado correctamente.');
        } else {
            // Redirigir al usuario al inicio de sesión si no está autenticado
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para dar Me gusta a un producto.');
        }
    }
    // H. ELVIN 


    // H. ELVIN 
    public function dislike(Request $request, $ofertaId)
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('usuario_id')) {
            
            // Obtener el usuario_id de la sesión
            $usuarioId = session('usuario')->id;

            // Verificar si ya existe un dislike para este usuario y producto
            $dislikeExistente = Dislike::where('usuario_id', $usuarioId)
                ->where('oferta_id', $ofertaId)
                ->exists();

            if ($dislikeExistente) {
                // El usuario ya ha dado dislike a este producto
                Dislike::where('usuario_id', $usuarioId)
                     ->where('oferta_id', $ofertaId)
                    ->delete();
                return redirect()->back()->with('error', 'Ya has dado dislike a este producto.');
            }

            // Crear un nuevo dislike
            $dislike = new Dislike();
            $dislike->usuario_id = session('usuario')->id;
            $dislike->oferta_id = $ofertaId;
            $dislike->producto_id = null;
            $dislike->save();

            return redirect()->back()->with('success', 'Dislike guardado correctamente.');
        } else {
            // Redirigir al usuario al inicio de sesión si no está autenticado
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para dar No me gusta a un producto.');
        }
    }
    // H. ELVIN 
    // FIN OFERTA  


    // INICIO CATEGORIA

    // ACCESORIOS
    // H. ELVIN / H. EDUARDO
    public function CategoriaAccesorios(Request $request)
    {
        $ImagenFondo = asset('img/FondoLucemStoreAccesorio.png');

        $ProductoBuscar = $request->get('buscar');
        session(['ProductoBuscar' => $ProductoBuscar]); // Almacenar en la sesión

        // Obtener la cantidad de pedidos desde tu modelo 'Pedido'
        $cantidadPedidos = Pedido::count();
        session(['cantidadPedidos' => $cantidadPedidos]);
        // Establecer la variable de sesión, ESTO HACE QUE NO AFECTE MÁS VISTA SOLO DONDE ESTÁ SELECCIONADA

        // Obtener la cantidad de pedidos desde tu modelo 'Pedido'
        $cantidadFavoritoa = Favorito::count();
        session(['cantidadFavoritos' => $cantidadFavoritoa]);
        // Establecer la variable de sesión, ESTO HACE QUE NO AFECTE MÁS VISTA SOLO DONDE ESTÁ SELECCIONADA

        // Obtener el filtro de precio seleccionado
        $filtroPrecio = $request->get('precio');

        // Obtener el filtro de nombre seleccionado
        $filtroNombre = $request->get('nombre');

        $query = DB::table('productos')
            ->select('id', 'nombre', 'Imagen', 'descripcion', 'precio', 'categoria')
            ->whereIn('categoria', ['llaveros', 'Pulseras', 'Collares']); // Filtrar por categorías

        // Aplicar el filtro de búsqueda por nombre
        if ($ProductoBuscar) {
            $query->where('nombre', 'LIKE', '%' . $ProductoBuscar . '%');
        }

        // Aplicar el filtro de precio
        if ($filtroPrecio === 'CARO') {
            $query->orderBy('precio', 'desc');
        } elseif ($filtroPrecio === 'BARATO') {
            $query->orderBy('precio', 'asc');
        }

        // Aplicar el filtro Alfabético
        if ($filtroNombre === 'DESCENDENTE') {
            $query->orderBy('nombre', 'desc');
        } elseif ($filtroNombre === 'ASCENDENTE') {
            $query->orderBy('nombre', 'asc');
        }

        $productos = $query->paginate(12);

        return view('Categorias.Accesorios', compact('productos', 'ProductoBuscar', 'ImagenFondo'));
    }
    // H. ELVIN / H. EDUARDO


    // ALIMENTOS
    // H. ELVIN / H. EDUARDO
    public function CategoriaAlimentos(Request $request)
    {
        $ImagenFondo = asset('img/FondoLucemStoreAlimento.png');

        $ProductoBuscar = $request->get('buscar');
        session(['ProductoBuscar' => $ProductoBuscar]); // Almacenar en la sesión

        // Obtener la cantidad de pedidos desde tu modelo 'Pedido'
        $cantidadPedidos = Pedido::count();
        session(['cantidadPedidos' => $cantidadPedidos]);
        // Establecer la variable de sesión, ESTO HACE QUE NO AFECTE MÁS VISTA SOLO DONDE ESTÁ SELECCIONADA

        // Obtener la cantidad de pedidos desde tu modelo 'Pedido'
        $cantidadFavoritoa = Favorito::count();
        session(['cantidadFavoritos' => $cantidadFavoritoa]);
        // Establecer la variable de sesión, ESTO HACE QUE NO AFECTE MÁS VISTA SOLO DONDE ESTÁ SELECCIONADA

        // Obtener el filtro de precio seleccionado
        $filtroPrecio = $request->get('precio');

        // Obtener el filtro de nombre seleccionado
        $filtroNombre = $request->get('nombre');

        $query = DB::table('productos')
            ->select('id', 'nombre', 'Imagen', 'descripcion', 'precio', 'categoria')
            ->whereIn('categoria', ['Dulces', 'Postres', 'Variado']); // Filtrar por categorías

        // Aplicar el filtro de búsqueda por nombre
        if ($ProductoBuscar) {
            $query->where('nombre', 'LIKE', '%' . $ProductoBuscar . '%');
        }

        // Aplicar el filtro de precio
        if ($filtroPrecio === 'CARO') {
            $query->orderBy('precio', 'desc');
        } elseif ($filtroPrecio === 'BARATO') {
            $query->orderBy('precio', 'asc');
        }

        // Aplicar el filtro Alfabético
        if ($filtroNombre === 'DESCENDENTE') {
            $query->orderBy('nombre', 'desc');
        } elseif ($filtroNombre === 'ASCENDENTE') {
            $query->orderBy('nombre', 'asc');
        }

        $productos = $query->paginate(12);

        return view('Categorias.Alimentos', compact('productos', 'ProductoBuscar', 'ImagenFondo'));
    }
    // H. ELVIN / H. EDUARDO

    
    // ROPA
    // H. ELVIN / H. EDUARDO
    public function CategoriaRopa(Request $request)
    {
        $ImagenFondo = asset('img/FondoLucemStoreRopas.png');

        $ProductoBuscar = $request->get('buscar');
        session(['ProductoBuscar' => $ProductoBuscar]); // Almacenar en la sesión

        // Obtener la cantidad de pedidos desde tu modelo 'Pedido'
        $cantidadPedidos = Pedido::count();
        session(['cantidadPedidos' => $cantidadPedidos]);
        // Establecer la variable de sesión, ESTO HACE QUE NO AFECTE MÁS VISTA SOLO DONDE ESTÁ SELECCIONADA

        // Obtener la cantidad de pedidos desde tu modelo 'Pedido'
        $cantidadFavoritoa = Favorito::count();
        session(['cantidadFavoritos' => $cantidadFavoritoa]);
        // Establecer la variable de sesión, ESTO HACE QUE NO AFECTE MÁS VISTA SOLO DONDE ESTÁ SELECCIONADA

        // Obtener el filtro de precio seleccionado
        $filtroPrecio = $request->get('precio');

        // Obtener el filtro de nombre seleccionado
        $filtroNombre = $request->get('nombre');

        $query = DB::table('productos')
            ->select('id', 'nombre', 'Imagen', 'descripcion', 'precio', 'categoria')
            ->whereIn('categoria', ['Camisas', 'Pantalones', 'Zapatos']); // Filtrar por categorías

        // Aplicar el filtro de búsqueda por nombre
        if ($ProductoBuscar) {
            $query->where('nombre', 'LIKE', '%' . $ProductoBuscar . '%');
        }

        // Aplicar el filtro de precio
        if ($filtroPrecio === 'CARO') {
            $query->orderBy('precio', 'desc');
        } elseif ($filtroPrecio === 'BARATO') {
            $query->orderBy('precio', 'asc');
        }

        // Aplicar el filtro Alfabético
        if ($filtroNombre === 'DESCENDENTE') {
            $query->orderBy('nombre', 'desc');
        } elseif ($filtroNombre === 'ASCENDENTE') {
            $query->orderBy('nombre', 'asc');
        }

        $productos = $query->paginate(12);

        return view('Categorias.Ropa', compact('productos', 'ProductoBuscar', 'ImagenFondo'));
    }
    // H. ELVIN / H. EDUARDO
}
