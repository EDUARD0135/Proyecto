<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\Oferta;
use App\Models\Favorito;
use App\Models\Registro;
use App\Models\Comentario;
use App\Models\Usuario;
use App\Models\Like;
use App\Models\Dislike;
use App\Mail\SendOrderNotification;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class ProductoController extends Controller
{

    // INICIO PEDIDO 
    // H. SANDY / A. EDUARDO / A. JUNIOR / A ELVIN
    public function Pedidos(Request $request)
    {
        $ImagenFondo = asset('img/FondoLucemStoreProductos.jpg');

        // Verifica si hay un usuario en sesión
        if ($request->session()->has('usuario')) {
            // Recupera el ID del usuario en sesión
            $usuario_id = $request->session()->get('usuario')->id;

            // Obtener los pedidos del usuario en sesión como comprador
            $pedidos = Pedido::where('comprador_id', $usuario_id)->get();

            // Contar la cantidad de pedidos
            $cantidadPedidos = $pedidos->count();

            // Almacena la cantidad de pedidos en la sesión
            session(['cantidadPedidos' => $cantidadPedidos]);

            // Pasar los pedidos y la cantidad a la vista
            return view('Pedidos')->with('pedidos', $pedidos)->with('cantidadPedidos', $cantidadPedidos)->with('ImagenFondo', $ImagenFondo);
        } else {
            // Si el usuario no está autenticado, redirigir al inicio de sesión
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para ver tus pedidos.');
        }
    }
    // H. SANDY / A. EDUARDO / A JUNIOR / A ELVIN


    // H. SANDY / A. JUNIOR
    public function AgregarPedido(Request $request, $producto_id)
    {
        // Verifica si hay un usuario en sesión
        if ($request->session()->has('usuario')) {
            // Recupera el producto que deseas agregar al pedido
            $producto = Producto::find($producto_id);

            // Verifica que el producto existe
            if (!$producto) {
                return redirect()->route('Productos.Tienda');
            }

            // Recupera el ID del usuario en sesión
            $usuario_id = $request->session()->get('usuario')->id;

            // Crea un nuevo pedido usando los datos del producto y el ID del usuario en sesión
            // H. SANDY
            $pedido = new Pedido();
            $pedido->nombre = $producto->nombre;
            $pedido->categoria = $producto->categoria;
            $pedido->descripcion = $producto->descripcion;
            $pedido->precio = $producto->precio;
            // H. SANDY
            
            // Recupera la cantidad seleccionada desde la solicitud y asegúrate de que sea un número entero
            $cantidad = (int)$request->input('quantity', 1);

            // Asigna la cantidad seleccionada al pedido
            // H. SANDY
            $pedido->cantidad = $cantidad;
            $pedido->usuario_id = $producto->usuario_id;
            $pedido->comprador_id = $usuario_id; // Asigna el ID del usuario en sesión
            $pedido->Imagen = $producto->Imagen;

            // Guarda el pedido en la base de datos
            $pedido->save();

            // Redirecciona a una página de confirmación o a donde lo necesites
            return redirect()->route('Pedidos');
            // H. SANDY

        } else {
            // Redirecciona al inicio de sesión si el usuario no está autenticado
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para realizar un pedido.');
        }
    }
    // H. SANDY / A. JUNIOR


    // H. SANDY
    public function EliminarPedido(string $id)
    {
        Pedido::destroy($id);

        return redirect()->route('Pedidos');
    }
    // H. SANDY
    // FIN PEDIDO


    // INICIO FAVORITO

    // H. SANDY / A. EDUARDO / A ELVIN
    public function Favoritos(Request $request)
    {
        $ImagenFondo = asset('img/FondoLucemStoreFavorito.jpg');

        // Verifica si hay un usuario en sesión
        if ($request->session()->has('usuario')) {
            // Recupera el ID del usuario en sesión
            $usuario_id = $request->session()->get('usuario')->id;

            // Obtener los pedidos del usuario en sesión como comprador
            $favoritos = Favorito::where('comprador_id', $usuario_id)->get();

            // Contar la cantidad de favoritos
            $cantidadFavoritos = $favoritos->count();

            // Almacena la cantidad de favoritos en la sesión
            session(['cantidadFavoritos' => $cantidadFavoritos]);

            // Pasar los favoritos a la vista
            return view('Favoritos')->with('favoritos', $favoritos)->with('cantidadFavoritos', $cantidadFavoritos)->with('ImagenFondo', $ImagenFondo);
        } else {
            // Si el usuario no está autenticado, redirigir al inicio de sesión
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para ver tus favoritos.');
        }
    }
    // H. SANDY / A. EDUARDO / A ELVIN


    // H. SANDY 
    public function AgregarFavorito(Request $request, $producto_id)
    {
        // Verifica si hay un usuario en sesión
        if ($request->session()->has('usuario')) {
            // Recupera el producto que deseas agregar al pedido
            $producto = Producto::find($producto_id);

            // Verifica que el producto existe
            if (!$producto) {
                return redirect()->route('Productos.Tienda');
            }

            // Recupera el ID del usuario en sesión
            $usuario_id = $request->session()->get('usuario')->id;

            // Crea un nuevo pedido usando los datos del producto y el ID del usuario en sesión
            $favorito = new Favorito();
            $favorito->nombre = $producto->nombre;
            $favorito->categoria = $producto->categoria;
            $favorito->descripcion = $producto->descripcion;
            $favorito->precio = $producto->precio;
            $favorito->cantidad = $producto->cantidad;
            $favorito->usuario_id = $producto->usuario_id;
            $favorito->comprador_id = $usuario_id; // Asigna el ID del usuario en sesión
            $favorito->Imagen = $producto->Imagen;

            // Guarda el pedido en la base de datos
            $favorito->save();

            // Redirecciona a una página de confirmación o a donde lo necesites
            return redirect()->route('Favoritos');
        } else {
            // Redirecciona al inicio de sesión si el usuario no está autenticado
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para realizar un pedido.');
        }
    }
    // H. SANDY 

   
    // H. SANDY
    public function EliminarFavorito(string $id)
    {
        Favorito::destroy($id);

        return redirect()->route('Favoritos');
    }
    // H. SANDY


    // A. EDUARDO
    public function AgregarPedidoFavorito(Request $request, $favorito_id)
    {
        // Verifica si hay un usuario en sesión
        if ($request->session()->has('usuario')) {
            // Recupera el producto que deseas agregar al pedido
            $favorito = Favorito::find($favorito_id);

            // Verifica que el producto existe
            if (!$favorito) {
                return redirect()->route('Productos.Ofertas');
            }

            // Recupera el ID del usuario en sesión
            $usuario_id = $request->session()->get('usuario')->id;

            // Crea un nuevo pedido usando los datos del producto y el ID del usuario en sesión
            $pedido = new Pedido();
            $pedido->nombre = $favorito->nombre;
            $pedido->categoria = $favorito->categoria;
            $pedido->descripcion = $favorito->descripcion;
            $pedido->precio = $favorito->precio;

            // Recupera la cantidad seleccionada desde la solicitud y asegúrate de que sea un número entero
            $cantidad = (int)$request->input('quantity', 1);

            // Asigna la cantidad seleccionada al pedido
            $pedido->cantidad = $cantidad;

            $pedido->usuario_id = $favorito->usuario_id;
            $pedido->comprador_id = $usuario_id; // Asigna el ID del usuario en sesión
            $pedido->Imagen = $favorito->Imagen;

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
    public function ShowFavorito(string $id)
    {
        $favorito = Favorito::find($id);
        $favoritos = Favorito::where('categoria', $favorito->categoria)->where('id', '!=', $favorito->id)->take(3)->get(); // ESE 3 ES EL NUMERO DE PRODUCTOS PARECIDOS

        return view('Shows.ShowFavorito', compact('favorito', 'favoritos'));
    }
    // A. EDUARDO 
    // FIN FAVORITO


    // H. KELEN / A. JUNIOR / A. ELVIN
    public function ShowProducto(string $id)
    {
        $producto = Producto::find($id);
        $productos = Producto::where('categoria', $producto->categoria)->where('id', '!=', $producto->id)->take(3)->get();
        
        // Incluye la relación 'usuario' para obtener la información del usuario que hizo el comentario
        $comentarios = Comentario::with('usuario')->where('producto_id', $producto->id)->get();
        // Obtener la cantidad de likes para el producto
        $likes = Like::where('producto_id', $producto->id)->count();
        $dislikes = Dislike::where('producto_id', $producto->id)->count();

        return view('Shows.ShowProducto', compact('producto', 'productos', 'comentarios', 'likes', 'dislikes'));
    }
    // H. KELEN / A. JUNIOR / A. ELVIN


    // A. EDUARDO
    public function ShowProductoPerfil(string $id)
    {
        $producto = Producto::find($id);
        $productos = Producto::where('categoria', $producto->categoria)->where('id', '!=', $producto->id)->take(3)->get(); // ESE 3 ES EL NUMERO DE PRODUCTOS PARECIDOS
        
        // Incluye la relación 'usuario' para obtener la información del usuario que hizo el comentario
        $comentarios = Comentario::with('usuario')->where('producto_id', $producto->id)->get();
        // Obtener la cantidad de likes para el producto
        $likes = Like::where('producto_id', $producto->id)->count();
        $dislikes = Dislike::where('producto_id', $producto->id)->count();

        return view('Shows.ShowProductoPerfil', compact('producto', 'productos', 'comentarios', 'likes', 'dislikes'));
    }
    // A. EDUARDO


    // H. KELEN / A. EDUARDO / A. ELVIN
    public function AñadirProducto()
    {
        // Ruta a la imagen PNG (Logo)
        $rutaImagen = public_path('img/LogoLucem2.png');

        // Ruta a la imagen JPG (Fondo)
        $rutaImagen2 = public_path('img/FondoLucemStore.jpg');

        // Crear una nueva imagen desde el archivo de la imagen PNG (Logo)
        $imageLogo = imagecreatefrompng($rutaImagen);

        // Crear una nueva imagen desde el archivo de la imagen JPG (Fondo)
        $imageFondo = imagecreatefromjpeg($rutaImagen2);

        // Habilitar la transparencia para la imagen PNG (Logo)
        imagealphablending($imageLogo, true);
        imagesavealpha($imageLogo, true);

        // Obtener las rutas públicas de ambas imágenes para pasarlas a la vista
        $ImagenLogo = asset('img/LogoLucem2.png');
        $ImagenFondo = asset('img/FondoLucemStore.jpg');

        // Don't destroy the images here if you plan to use them further

        // Pass the image paths to the view
        return view('Productos.AñadirProducto', compact('ImagenLogo', 'ImagenFondo'));
    }
    // H. KELEN / A. EDUARDO / A. ELVIN


    // H. KELEN
    public function AgregarProducto(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'usuario_id' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|numeric|min:0',
            'categoria' => 'required',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $producto = new Producto();
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->usuario_id = $request->input('usuario_id');
        $producto->precio = $request->input('precio');
        $producto->cantidad = $request->input('cantidad');
        $producto->categoria = $request->input('categoria');

        if ($request->hasFile('Imagen')) {
            $imagen = $request->file('Imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $ruta = public_path('images');
            $imagen->move($ruta, $nombreImagen);
            $producto->Imagen = 'images/' . $nombreImagen;
        }

        $producto->save();

        return redirect()->route('usuarioPerfil');
    }
    // H. KELEN

    
    // H. JUNIOR
    public function destroy($id)
    {
        $producto = Producto::find($id);

        // Verificar si el producto existe
        if (!$producto) {
            return redirect()->route('Tienda')->with('error', 'Producto no encontrado');
        }

        // Eliminar la imagen asociada si existe
        if ($producto->Imagen) {
            $rutaImagen = public_path($producto->Imagen);
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }

        // Eliminar el producto
        $producto->delete();

        return redirect()->route('usuarioPerfil')->with('success', 'Producto eliminado correctamente');
    }
    // H. JUNIOR


    //Editar Producto
    // H. JUNIOR / A. EDUARDO / A. ELVIN
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);

        // Ruta a la imagen PNG (Logo)
        $rutaImagen = public_path('img/LogoLucem2.png');

        // Ruta a la imagen JPG (Fondo)
        $rutaImagen2 = public_path('img/FondoLucemStore.jpg');

        // Crear una nueva imagen desde el archivo de la imagen PNG (Logo)
        $imageLogo = imagecreatefrompng($rutaImagen);

        // Crear una nueva imagen desde el archivo de la imagen JPG (Fondo)
        $imageFondo = imagecreatefromjpeg($rutaImagen2);

        // Habilitar la transparencia para la imagen PNG (Logo)
        imagealphablending($imageLogo, true);
        imagesavealpha($imageLogo, true);

        // Obtener las rutas públicas de ambas imágenes para pasarlas a la vista
        $ImagenLogo = asset('img/LogoLucem2.png');
        $ImagenFondo = asset('img/FondoLucemStore.jpg');

        // Pasa las rutas de las imágenes y el objeto $producto a la vista
        return view('Editar.EditarProducto', compact('producto', 'ImagenLogo', 'ImagenFondo'));
    }
    // H. JUNIOR / A. EDUARDO / A. ELVIN


    // H. JUNIOR 
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'required|string',
            'categoria' => 'required',
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $producto = Producto::findOrFail($id);

        $producto->nombre = $request->input('nombre');
        $producto->precio = $request->input('precio');
        $producto->descripcion = $request->input('descripcion');
        $producto->categoria = $request->input('categoria');

        if ($request->hasFile('Imagen')) {
            $imagen = $request->file('Imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $ruta = public_path('images');
            $imagen->move($ruta, $nombreImagen);
            $producto->Imagen = 'images/' . $nombreImagen;
        }

        $guardado = $producto->save();

        if ($guardado) {
            return redirect()->route('usuarioPerfil')->with('mensaje', 'El producto fue editado exitosamente.');
        } else {
            // Manejar el caso donde no se pudo guardar
        }
    }
    // H. JUNIOR 


    // H. JUNIOR 
    public function eliminarPro($id)
    {
        // Buscar el producto por su ID
        $producto = Producto::find($id);

        // Verificar si se encontró el producto
        if ($producto) {
            // Verificar si el usuario tiene una sesión activa y es un administrador o el dueño del producto
            if (session()->has('usuario') && (session('usuario')->rol === 'admin' || $producto->usuario_id == session('usuario')->id)) {
                // Eliminar el producto
                $producto->delete();

                // Redirigir con un mensaje de éxito
                return redirect()->route('productoslist')->with('mensaje', 'El producto fue eliminado correctamente.');
            } else {
                // Redirigir con un mensaje de error si no se cumplen las condiciones
                return redirect()->route('productoslist')->with('error', 'No tienes permisos para eliminar este producto.');
            }
        } else {
            // Redirigir con un mensaje de error si el producto no se encuentra
            return redirect()->route('productoslist')->with('error', 'Producto no encontrado.');
        }
    }
    // H. JUNIOR 


    // H. JUNIOR 
    public function eliminarPro1($id)
    {
        // Buscar el producto por su ID
        $producto = Producto::find($id);

        // Verificar si se encontró el producto
        if ($producto) {
            // Verificar si el usuario tiene una sesión activa y es un administrador o el dueño del producto
            if (session()->has('usuario') && (session('usuario')->rol === 'admin' || $producto->usuario_id == session('usuario')->id)) {
                // Obtén el ID del usuario antes de eliminar el producto
                $usuario_id = $producto->usuario_id;

                // Eliminar el producto
                $producto->delete();

                // Redirigir con un mensaje de éxito
                return redirect()->route('usuario.mostrar', ['id' => $usuario_id])->with('success', 'Producto eliminado correctamente');
            } else {
                // Redirigir con un mensaje de error si no se cumplen las condiciones
                return redirect()->route('usuario.mostrar', ['id' => $id])->with('error', 'No tienes permisos para eliminar este producto.');
            }
        } else {
            // Redirigir con un mensaje de error si el producto no se encuentra
            return redirect()->route('usuario.mostrar', ['id' => $id])->with('error', 'Producto no encontrado.');
        }
    }
    // H. JUNIOR 


    // H. EDUARDO 
    public function eliminaroferta($id)
    {
        // Buscar el producto por su ID
        $oferta = Oferta::find($id);

        // Verificar si se encontró el producto
        if ($oferta) {
            // Verificar si el usuario tiene una sesión activa y es un administrador o el dueño del producto
            if (session()->has('usuario') && (session('usuario')->rol === 'admin' || $oferta->usuario_id == session('usuario')->id)) {
                // Obtén el ID del usuario antes de eliminar el producto
                $usuario_id = $oferta->usuario_id;

                // Eliminar el producto
                $oferta->delete();

                // Redirigir con un mensaje de éxito
                return redirect()->route('usuario.mostrar', ['id' => $usuario_id])->with('success', 'Oferta eliminada correctamente');
            } else {
                // Redirigir con un mensaje de error si no se cumplen las condiciones
                return redirect()->route('usuario.mostrar', ['id' => $id])->with('error', 'No tienes permisos para eliminar esta oferta.');
            }
        } else {
            // Redirigir con un mensaje de error si el producto no se encuentra
            return redirect()->route('usuario.mostrar', ['id' => $id])->with('error', 'Producto no encontrado.');
        }
    }
    // H. EDUARDO 


    // H. EDUARDO 
    public function eliminaroferta1($id)
    {
        // Buscar el producto por su ID
        $oferta = Oferta::find($id);

        // Verificar si se encontró la oferta
        if ($oferta) {
            // Verificar si el usuario tiene una sesión activa y es un administrador o el dueño de la oferta
            if (session()->has('usuario') && (session('usuario')->rol === 'admin' || $oferta->usuario_id == session('usuario')->id)) {
                // Eliminar el producto
                $oferta->delete();

                // Redirigir con un mensaje de éxito
                return redirect()->route('ofertaslist')->with('mensaje', 'El oferta fue eliminado correctamente.');
            } else {
                // Redirigir con un mensaje de error si no se cumplen las condiciones
                return redirect()->route('ofertaslist')->with('error', 'No tienes permisos para eliminar esta oferta.');
            }
        } else {
            // Redirigir con un mensaje de error si la oferta no se encuentra
            return redirect()->route('ofertaslist')->with('error', 'Oferta no encontrado.');
        }
    }
    // H. EDUARDO 


    // H. KELEN / H. EDUARDO
    public function sendEmail(Request $request)
    {
        try {
            $pedido_id = $request->input('pedido_id');
            $descripcion_pedido = $request->input('descripcion-pedido');
            $productos_seleccionados = $request->input('productos_seleccionados');

            // Obtener el pedido
            $pedido = Pedido::find($pedido_id);

            // Obtener el comprador del pedido
            $comprador = Usuario::find($pedido->comprador_id);

            // Obtener los productos del pedido
            $products = Pedido::whereIn('id', $productos_seleccionados)->get();

            // Guardar la información en la tabla registros         
            // H. EDUARDO
                foreach ($products as $product) {
                    Registro::create([
                        'pedido_id' => $pedido_id,
                        'usuario_id' => $request['id-usuario'],
                        'comprador_id' => $pedido->comprador_id,
                        'descripcion_pedido' => $descripcion_pedido,
                        'cantidad' => $product->cantidad, 
                        'pedido' => $product->nombre
                    ]);
                }
            // H. EDUARDO

            // Configurar el asunto del correo
            $subject = "Pedido LucemStore";

            // Obtener el correo del usuario
            $email = $request['email'];

            // Inicializar el mensaje con la descripción escrita por el usuario
            $mensaje = "Los productos que se han solicitado en este pedido son los siguientes: \r\n";

            // Verificar si hay una descripción del pedido
            if (!empty($descripcion_pedido)) {
                $mensaje = "Con la siguiente descripción: \r\n" . $descripcion_pedido . ". \r\n \r\nLos productos que se han solicitado en este pedido son los siguientes: \r\n";
            } else {
                $mensaje = "No hay descripción de pedido. \r\n \r\nLos productos que se han solicitado en este pedido son los siguientes: \r\n";
            }

            // Enviar el correo al dueño del producto
            Mail::to($email)->send(new SendOrderNotification($mensaje, $subject, $products, $comprador->nombre, $comprador->apellido, $comprador->nombre_usuario, $comprador->email, $comprador->telefono));

            return redirect()->route('Pedidos');
        } catch (Exception $th) {
            return response()->json([
                'error' => "Error: " . $th->getMessage()
            ], 422);
        }
    }
    // H. KELEN / H. EDUARDO


    // H JUNIOR
    public function agregarComentario(Request $request, $productoId)
    {
        // Valida el formulario y verifica si el usuario está autenticado
        if (!session()->has('usuario_id')) {
            // El usuario está autenticado, procede a guardar el comentario
            $comentario = new Comentario();
            $comentario->contenido = $request->input('contenido');
            $comentario->producto_id = $productoId;
            $comentario->oferta_id = null; // Establece el id de oferta como nulo
            $comentario->usuario_id = session('usuario')->id;
            $comentario->save();

            return redirect()->back()->with('success', 'Comentario guardado correctamente.');
        } else {
            // El usuario no está autenticado, redirige a una página que requiera autenticación
            // En este ejemplo, estoy redirigiendo al formulario de inicio de sesión
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para comentar.');
        }
    }
    // H JUNIOR


    // A. EDUARDO
    public function EliminarComentario(string $id)
    {
        $comentario = Comentario::findOrFail($id); // Obtener el comentario que se está eliminando
        $productoId = $comentario->producto_id;

        Comentario::destroy($id);

        return redirect()->route('ShowProducto', ['id' => $productoId]);
    }
    // A. EDUARDO


    // H, ELVIN / A JUNIOR
    public function like(Request $request, $productoId)
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('usuario_id')) {
            
            // Obtener el usuario_id de la sesión
            $usuarioId = session('usuario')->id;

            // Verificar si ya existe un like para este usuario y producto
            $likeExistente = Like::where('usuario_id', $usuarioId)
                ->where('producto_id', $productoId)
                ->exists();

            if ($likeExistente) {
                // El usuario ya ha dado like a este producto
                Like::where('usuario_id', $usuarioId)
                     ->where('producto_id', $productoId)
                    ->delete();
                return redirect()->back()->with('error', 'Ya has dado like a este producto.');
            }

            // Crear un nuevo like
            $like = new Like();
            $like->usuario_id = session('usuario')->id;
            $like->producto_id = $productoId;
            $like->oferta_id = null;
            $like->save();

            return redirect()->back()->with('success', 'Like guardado correctamente.');
        } else {
            // Redirigir al usuario al inicio de sesión si no está autenticado
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para dar Me gusta a un producto.');
        }
    }
    // H, ELVIN / A JUNIOR


    // H, ELVIN / A JUNIOR
    public function dislike(Request $request, $productoId)
    {
        // Verificar si el usuario está autenticado
        if (!session()->has('usuario_id')) {
            
            // Obtener el usuario_id de la sesión
            $usuarioId = session('usuario')->id;

            // Verificar si ya existe un dislike para este usuario y producto
            $dislikeExistente = Dislike::where('usuario_id', $usuarioId)
                ->where('producto_id', $productoId)
                ->exists();

            if ($dislikeExistente) {
                // El usuario ya ha dado dislike a este producto
                Dislike::where('usuario_id', $usuarioId)
                     ->where('producto_id', $productoId)
                    ->delete();
                return redirect()->back()->with('error', 'Ya has dado dislike a este producto.');
            }

            // Crear un nuevo dislike
            $dislike = new Dislike();
            $dislike->usuario_id = session('usuario')->id;
            $dislike->producto_id = $productoId;
            $dislike->oferta_id = null;
            $dislike->save();

            return redirect()->back()->with('success', 'Dislike guardado correctamente.');
        } else {
            // Redirigir al usuario al inicio de sesión si no está autenticado
            return redirect()->route('usuario.login')->with('error', 'Debes iniciar sesión para dar No me gusta a un producto.');
        }
    }
    // H, ELVIN / A JUNIOR
}
