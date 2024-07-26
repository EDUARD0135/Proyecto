<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Oferta;
use App\Models\Comentario;
use App\Models\Favorito;
use App\Models\Registro;
use App\Models\Like;
use App\Models\Dislike;
use App\Models\Pedido;
use App\Models\Reporte;
use App\Models\Buscar;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class UsuarioController extends Controller
{

    // H. JUNIOR / A. EDUAROD / A. ELVIN 
    public function loginForm()
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

        // Liberar la memoria de ambas imágenes
        imagedestroy($imageLogo);
        imagedestroy($imageFondo);

        // Puedes pasar ambas rutas a la vista según tus necesidades
        return view('InicioSesion.login')->with(['ImagenLogo' => $ImagenLogo, 'ImagenFondo' => $ImagenFondo]);
    }
    // H. JUNIOR / A. EDUAROD / A. ELVIN


    // H. JUNIOR / A. EDUAROD / A. ELVIN
    public function index(Request $request)
    {
        $ImagenFondo = asset('img/FondoLucemAdmin2.jpg');

        // Obtenemos el parámetro de búsqueda
        $query = $request->input('buscar');

        // Realizamos la búsqueda de usuarios
        $usuarios = Usuario::where('nombre_usuario', 'like', "%$query%")
            ->orWhere('nombre', 'like', "%$query%")
            ->orWhere('apellido', 'like', "%$query%")
            ->orderBy('id')
            ->paginate(10);

        // Retornamos la vista con los usuarios y la query de búsqueda
        return view('Administrador.ListaUsuarios', compact('usuarios', 'query', 'ImagenFondo'));
    }
    // H. JUNIOR / A. EDUAROD / A. ELVIN


    // En tu controlador de inicio de sesión
    // H. JUNIOR 
    public function login(Request $request)
    {
        $nombre_usuario = $request->input('nombre_usuario');
        $contrasena = $request->input('contrasena');

        $usuario = Usuario::where('nombre_usuario', $nombre_usuario)->first();

        if ($usuario && Hash::check($contrasena, $usuario->contrasena)) {
            if (!$usuario->activo) {
                // Si el usuario está desactivado, redirigir de nuevo al formulario de inicio de sesión con un mensaje
                return redirect()->route('usuario.login.submit')->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
            }

            if ($usuario->rol === 'admin') {
                // Redirigir al administrador directamente a la ruta de administrador
                session(['usuario' => $usuario]);
                return redirect()->route('Admi');
            }

            // Almacenar el usuario en la sesión
            session(['usuario' => $usuario]);

            // Obtener los pedidos del usuario
            $pedidos = Pedido::where('usuario_id', $usuario->id)->get();

            // Obtener los favoritos del usuario
            $favoritos = Favorito::where('usuario_id', $usuario->id)->get();

            // Redirigir a la página de inicio y pasar los pedidos y favoritos a la vista
            return redirect()->route('Inicio')->with('pedidos', $pedidos)->with('favoritos', $favoritos);
        } else {
            return redirect()->route('usuario.login.submit')->with('error', 'Credenciales Incorrectas');
        }
    }
    // H. JUNIOR 


    // H. JUNIOR / A. EDUAROD / A. ELVIN
    public function create()
    {
        $rutaImagen = public_path('img/LogoLucem2.png');
        $rutaImagen2 = public_path('img/FondoLucemStore.jpg');

        // Crear una nueva imagen desde el archivo PNG
        $imageLogo = imagecreatefrompng($rutaImagen);
        $imageFondo = imagecreatefromjpeg($rutaImagen2);

        // Habilitar la transparencia (si no está habilitada automáticamente)
        imagealphablending($imageLogo, true);
        imagesavealpha($imageLogo, true);

        // Obtener la ruta pública de la imagen para pasarla a la vista
        $ImagenLogo = asset('img/LogoLucem2.png');
        $ImagenFondo = asset('img/FondoLucemStore.jpg');

        // Liberar la memoria
        imagedestroy($imageLogo);
        imagedestroy($imageFondo);

        return view('InicioSesion.registro')->with(['ImagenLogo' => $ImagenLogo, 'ImagenFondo' => $ImagenFondo]);
    }
    // H. JUNIOR / A. EDUAROD / A. ELVIN


    // H. JUNIOR 
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
            'apellido' => 'required|string|max:255|regex:/^[a-zA-Z]+$/',
            'email' => 'required|email',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario',
            'contrasena' => [
                'required',
                'string',
                'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).*$/',
            ],
            'telefono' => 'required|integer|digits:8',
        ]);

        $nuevousuario = new Usuario;
        $nuevousuario->nombre = $request->input('nombre');
        $nuevousuario->apellido = $request->input('apellido');
        $nuevousuario->email = $request->input('email');
        $nuevousuario->nombre_usuario = $request->input('nombre_usuario');
        $nuevousuario->contrasena = Hash::make($request->contrasena);
        $nuevousuario->telefono = $request->input('telefono');
        $nuevousuario->activo = true;
        $creado = $nuevousuario->save();

        if ($request->hasFile('Imagen')) {
            $imagen = $request->file('Imagen');
            $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
            $ruta = public_path('Uimages');
            $imagen->move($ruta, $nombreImagen);
            $nuevousuario->Imagen = 'Uimages/' . $nombreImagen;
        }


        if ($creado) {
            // Asignar el rol por defecto al nuevo usuario
            $nuevousuario->rol = 'usuario'; // Rol por defecto para usuarios normales

            // Si el usuario es el primer usuario (admin), asignar el rol de administrador
            if (Usuario::count() === 1) {
                $nuevousuario->rol = 'admin';
            }

            $nuevousuario->save();

            return redirect()->route('usuario.login.submit')->with('mensaje', 'Usuario registrado con éxito');
        } else {
            // Manejar el caso en que no se pueda crear el usuario
        }
    }
    // H. JUNIOR 


    // H. SANDY / A. EDUARDO / A. ELVIN
    public function edit($id)
    {
        // Buscar el usuario por su ID
        $usuario = Usuario::find($id);

        // Verificar si se encontró el usuario
        if ($usuario) {
            // Rutas de las imágenes
            $rutaImagen = public_path('img/LogoLucem2.png');
            $rutaImagen2 = public_path('img/FondoLucemStore.jpg');

            // Obtener la ruta pública de la imagen para pasarla a la vista
            $ImagenLogo = asset('img/LogoLucem2.png');
            $ImagenFondo = asset('img/FondoLucemStore.jpg');

            // Retornar la vista de edición con los datos del usuario y las rutas de las imágenes
            return view('Editar.EditarPefil')->with([
                'usuario' => $usuario, 'ImagenLogo' => $ImagenLogo, 'ImagenFondo' => $ImagenFondo,
            ]);
        } else {
            // Redirigir con un mensaje de error si el usuario no se encuentra
            return redirect()->route('usuarioPerfil')->with('error', 'Usuario no encontrado.');
        }
    }
    // H. SANDY / A. EDUARDO / A. ELVIN


    // H. SANDY 
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario,' . $id,
            'telefono' => 'required|integer|digits:8',
        ]);

        $usuario = Usuario::find($id);

        // Verificar si se encontró el usuario
        if ($usuario) {
            $usuario->nombre = $request->input('nombre');
            $usuario->apellido = $request->input('apellido');
            $usuario->email = $request->input('email');
            $usuario->nombre_usuario = $request->input('nombre_usuario');
            $usuario->telefono = $request->input('telefono');

            if ($request->hasFile('Imagen')) {
                $imagen = $request->file('Imagen');
                $nombreImagen = time() . '_' . $imagen->getClientOriginalName();
                $ruta = public_path('Uimages');
                $imagen->move($ruta, $nombreImagen);
                $usuario->Imagen = 'Uimages/' . $nombreImagen;
            }

            $usuario->save();

            // Redirigir con un mensaje de éxito
            return redirect()->route('usuarioPerfil')->with('mensaje', 'Usuario actualizado con éxito.');
        } else {
            // Redirigir con un mensaje de error si el usuario no se encuentra
            return redirect()->route('usuarioPerfil')->with('error', 'Usuario no encontrado.');
        }
    }
    // H. SANDY 


    // H. JUNIOR 
    public function destroy(Request $request)
    {
        $request->session()->forget('usuario');

        return redirect('/');
    }
    // H. JUNIOR 

    protected $redirectTo = RouteServiceProvider::HOME;


    // H. JUNIOR / A. EDUARDO / A. ELVIN
    public function show($id)
    {
        $ImagenFondo = asset('img/FondoLucemAdmin2.jpg');

        $usuario = Usuario::findOrFail($id);
        $reportes = Reporte::where('usuario_id', $id)->get();
        return view('Administrador.VerUsuario', compact('usuario', 'reportes', 'ImagenFondo'));
    }
    // H. JUNIOR / A. EDUARDO / A. ELVIN


    // H. JUNIOR 
    public function activarDesactivarUsuario($id)
    {
        $usuario = Usuario::find($id);

        if ($usuario && $usuario->rol === 'admin') {
            return redirect()->route('Admi')->with('error', 'No puedes desactivar al administrador.');
        }

        // Continuar con la lógica de activar/desactivar solo si no es el administrador
        if ($usuario) {
            $usuario->activo = !$usuario->activo;
            $usuario->save();
            // Redirigir a la lista de usuarios con un mensaje de éxito
            return redirect()->route('Admi')->with('success', 'Estado del usuario actualizado correctamente.');
        }

        // Redirigir a la lista de usuarios con un mensaje de error si el usuario no se encuentra
        return redirect()->route('Admi')->with('error', 'Usuario no encontrado.');
    }
    // H. JUNIOR 


    // H. JUNIOR 
    public function eliminar($id)
    {
        // Buscar el usuario por su ID
        $usuario = Usuario::find($id);

        // Verificar si se encontró el usuario
        if ($usuario) {
            // Verificar si el usuario no es el administrador
            if ($usuario->rol !== 'admin') {
                // Eliminar los productos del usuario
                $usuario->productos()->delete();

                // Eliminar los pedidos del usuario
                $usuario->pedidos()->delete();

                // Eliminar las ofertas del usuario
                $usuario->ofertas()->delete();

                // Eliminar los favoritos del usuario
                $usuario->favoritos()->delete();

                // Eliminar el usuario
                $usuario->delete();

                // Redirigir con un mensaje de éxito
                return redirect()->route('Admi')->with('mensaje', 'El usuario y sus registros relacionados fueron eliminados correctamente.');
            } else {
                // Redirigir con un mensaje de error si intentas eliminar al administrador
                return redirect()->route('Admi')->with('error', 'No puedes eliminar al administrador.');
            }
        } else {
            // Redirigir con un mensaje de error si el usuario no se encuentra
            return redirect()->route('Admi')->with('error', 'Usuario no encontrado.');
        }
    }
    // H. JUNIOR 


    // H. JUNIOR / A. EDUARDO / A. ELVIN
    public function productos(Request $request)
    {
        // Obtener la ruta pública de la imagen para pasarla a la vista
        $ImagenFondo = asset('img/FondoLucemAdmin2.jpg');

        // Eliminar la línea imagedestroy($imageFondo);

        $ProductoBuscar = $request->get('buscar');
        session(['ProductoBuscar' => $ProductoBuscar]);

        $query = DB::table('productos')
            ->select('id', 'nombre', 'Imagen', 'descripcion', 'precio', 'categoria');

        if ($ProductoBuscar) {
            $query->where('nombre', 'LIKE', '%' . $ProductoBuscar . '%');
        }

        $categoriaSeleccionada = $request->get('categoria');
        if ($categoriaSeleccionada) {
            $query->where('categoria', $categoriaSeleccionada);
        }

        $filtroPrecio = $request->get('precio');
        if ($filtroPrecio === 'CARO') {
            $query->orderBy('precio', 'desc');
        } elseif ($filtroPrecio === 'BARATO') {
            $query->orderBy('precio', 'asc');
        }

        $productos = $query->paginate(9);

        // Pasa la ruta de la imagen y la imagen misma a la vista
        return view('Administrador.ListaProductos', compact('productos', 'ProductoBuscar', 'ImagenFondo'));
    }
    // H. JUNIOR / A. EDUARDO / A. ELVIN


    // H. EDUARDO / A. ELVIN
    public function registros(Request $request)
    {
        // Obtener la ruta pública de la imagen para pasarla a la vista
        $ImagenFondo = asset('img/FondoLucemAdmin2.jpg');

        $RegistroBuscar = $request->get('buscar');
        session(['RegistroBuscar' => $RegistroBuscar]);

        $query = Registro::select('id', 'pedido_id', 'usuario_id', 'comprador_id', 'descripcion_pedido', 'cantidad','created_at','pedido');

        if ($RegistroBuscar) {
            $query->where('pedido_id', 'LIKE', '%' . $RegistroBuscar . '%');
            // Reemplaza 'campo1', 'campo2', 'campo3', 'campo4', 'campo5' con los nombres de los campos reales de tu modelo Registro.
            // Ajusta las condiciones según los campos específicos que deseas buscar.
        }

        // Agrega más condiciones según tus necesidades, si las hay.

        $registros = $query->paginate(20);

        // Pasa la ruta de la imagen y la imagen misma a la vista
        return view('Administrador.ListaRegistros', compact('registros', 'RegistroBuscar', 'ImagenFondo'));
    }
    // H. EDUARDO / A. ELVIN
    

    // H. EDUARDO / A. ELVIN
    public function ofertas(Request $request)
    {
        // Obtener la ruta pública de la imagen para pasarla a la vista
        $ImagenFondo = asset('img/FondoLucemAdmin2.jpg');

        // Eliminar la línea imagedestroy($imageFondo);

        $OfertaBuscar = $request->get('buscar');
        session(['OfertaBuscar' => $OfertaBuscar]);

        $query = DB::table('ofertas')
            ->select('id', 'nombre', 'Imagen', 'descripcion', 'precio', 'categoria');

        if ($OfertaBuscar) {
            $query->where('nombre', 'LIKE', '%' . $OfertaBuscar . '%');
        }

        $categoriaSeleccionada = $request->get('categoria');
        if ($categoriaSeleccionada) {
            $query->where('categoria', $categoriaSeleccionada);
        }

        $filtroPrecio = $request->get('precio');
        if ($filtroPrecio === 'CARO') {
            $query->orderBy('precio', 'desc');
        } elseif ($filtroPrecio === 'BARATO') {
            $query->orderBy('precio', 'asc');
        }

        $ofertas = $query->paginate(9);

        // Pasa la ruta de la imagen y la imagen misma a la vista
        return view('Administrador.ListaOfertas', compact('ofertas', 'OfertaBuscar', 'ImagenFondo'));
    }
    // H. EDUARDO / A. ELVIN


    // H. JUNIOR / A. EDUARDO / A. ELVIN
    public function createAdmin()
    {

        $rutaImagen2 = public_path('img/FondoLucemAdmin2.jpg');

        // Crear una nueva imagen desde el archivo PNG
        $imageFondo = imagecreatefromjpeg($rutaImagen2);


        // Obtener la ruta pública de la imagen para pasarla a la vista
        $ImagenFondo = asset('img/FondoLucemAdmin2.jpg');


        return view('Administrador.AgregarAdmin', compact('ImagenFondo'));
    }
    // H. JUNIOR / A. EDUARDO / A. ELVIN


    // H. JUNIOR 
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario',
            'contrasena' => [
                'required',
                'string',
                'regex:/^(?=.*[A-Z])(?=.*[0-9])(?=.*[\W_]).*$/',
            ],
            'telefono' => 'required|integer|digits:8',
            'rol' => 'required|string|max:255'
        ]);

        $nuevousuario = new Usuario;
        $nuevousuario->nombre = $request->input('nombre');
        $nuevousuario->apellido = $request->input('apellido');
        $nuevousuario->email = $request->input('email');
        $nuevousuario->nombre_usuario = $request->input('nombre_usuario');
        $nuevousuario->contrasena = Hash::make($request->contrasena);
        $nuevousuario->telefono = $request->input('telefono');
        $nuevousuario->rol = $request->input('rol');
        $nuevousuario->activo = true;
        $creado = $nuevousuario->save();

        if ($creado) {

            $nuevousuario->save();

            return redirect()->route('usuario.login.submit')->with('mensaje', 'Administrador registrado con éxito');
        } else {
            // Manejar el caso en que no se pueda crear el usuario
        }
    }
    // H. JUNIOR 

    
    // A. EDUARDO / A. ELVIN
    public function showTienda($id)
    {
        $ImagenFondo = asset('img/FondoLucemStoreProductos.jpg');
        $usuario = Usuario::findOrFail($id);

        return view('Shows.ShowTiendas', compact('usuario', 'ImagenFondo'));
    }
    // A. EDUARDO / A. ELVIN


    // H. JUNIOR / A. EDUARDO
    public function ShowProductoAdmin(string $id)
    {
        $producto = Producto::find($id);
        $comentarios = Comentario::with('usuario')->where('producto_id', $producto->id)->get();
        $likes = Like::where('producto_id', $producto->id)->count();
        $dislikes = Dislike::where('producto_id', $producto->id)->count();

        return view('Administrador.ShowProductoAdmin', compact('producto','comentarios','likes', 'dislikes'));
    }
    // H. JUNIOR / A. EDUARDO


    // A. EDUARDO 
    public function ShowOfertaAdmin(string $id)
    {
        $oferta = Oferta::find($id);
        $comentarios = Comentario::with('usuario')->where('oferta_id', $oferta->id)->get();
        $likes = Like::where('oferta_id', $oferta->id)->count();
        $dislikes = Dislike::where('oferta_id', $oferta->id)->count();

        return view('Administrador.ShowOfertaAdmin', compact('oferta','comentarios','likes', 'dislikes'));
    }
    // A. EDUARDO 


    // H. JUNIOR 
    public function reportar(Request $request)
    {
        // Verificar si el usuario está autenticado utilizando la variable de sesión
        if (!session()->has('usuario')) {
            return redirect()->route('usuario.login.submit')->with('error', 'Debes iniciar sesión para realizar un reporte.');
        }

        $request->validate([
            'motivo' => 'required',
            'usuario_id' => 'required|exists:usuarios,id',
        ]);

        $reporte = new Reporte();
        $reporte->motivo = $request->motivo;
        $reporte->usuario_id = $request->usuario_id;
        $reporte->usuario_reporta_id = session('usuario')->id; // Usamos session('usuario')->id para obtener el ID del usuario almacenado en la sesión
        $reporte->save();

        return redirect()->back()->with('success', 'El usuario ha sido reportado exitosamente.');
    }
    // H. JUNIOR


    // A. EDUARDO 
    public function EliminarComentarioAdmin(string $id)
    {
        $comentario = Comentario::findOrFail($id); // Obtener el comentario que se está eliminando
        $productoId = $comentario->producto_id; 

        Comentario::destroy($id);

        return redirect()->route('ShowProductoAdmin', ['id' => $productoId]);
    }
    // A. EDUARDO 
}
