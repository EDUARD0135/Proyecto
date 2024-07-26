<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RecuperacionContrasenaController;

// INICIO CONTROLADOR INICIO
Route::get('/',[InicioController::class,'Inicio'])->name('Inicio');
Route::get('/Tienda',[InicioController::class,'Tienda'])->name('Tienda');
Route::post('/AgregarProductoPerfil/{oferta}', [InicioController::class, 'AgregarProductoPerfil'])->name('AgregarProductoPerfil');
Route::get('/UsuariosTienda',[InicioController::class,'UsuariosTienda'])->name('UsuariosTienda');

// INICIO OFERTAS
Route::get('/Ofertas',[InicioController::class,'Ofertas'])->name('Ofertas');
Route::post('/AgregarOferta/{producto}', [InicioController::class, 'AgregarOferta'])->name('AgregarOferta');
Route::post('/AgregarPedidoOferta/{oferta}', [InicioController::class, 'AgregarPedidoOferta'])->name('AgregarPedidoOferta');
Route::post('/AgregarFavoritoOferta/{oferta}', [InicioController::class, 'AgregarFavoritoOferta'])->name('AgregarFavoritoOferta');
Route::get('/oferta/{id}/show',[InicioController::class,'ShowOferta'])->name('ShowOferta');
Route::get('/oferta/{id}/showperfil',[InicioController::class,'ShowOfertaPerfil'])->name('ShowOfertaPerfil');
Route::delete('/EliminarOferta/{id}/borrar',[InicioController::class,'EliminarOferta'])->whereNumber('id')->name('EliminarOferta');
Route::post('/oferta/{id}/comentarios', [InicioController::class, 'agregarComentarioOferta'])->name('agregar_comentario_oferta');
Route::delete('/EliminarComentarioOferta/{id}/borrar',[InicioController::class,'EliminarComentarioOferta'])->whereNumber('id')->name('EliminarComentarioOferta');

// FIN OFERTAS

// INICIO CATEGORIA
Route::get('/CategoriaAccesorios',[InicioController::class,'CategoriaAccesorios'])->name('CategoriaAccesorios');
Route::get('/CategoriaAlimentos',[InicioController::class,'CategoriaAlimentos'])->name('CategoriaAlimentos');
Route::get('/CategoriaRopa',[InicioController::class,'CategoriaRopa'])->name('CategoriaRopa');
// FIN CATEGORIA

// FIN CONTROLADOR INICIO


// INICIO CONTROLADOR USUARIO

// INICIO Y REGRISTO DE SESION
Route::get('/loginUsuario', [UsuarioController::class, 'loginForm'])->name('usuario.login');
Route::post('/loginUsuario', [UsuarioController::class, 'login'])->name('usuario.login.submit');

// INICIO Y REGRISTO DE SESION 2
Route::get('/loginUsuario/registro', [UsuarioController::class, 'create'])->name('usuario.create');
Route::post('/loginUsuario/registro', [UsuarioController::class, 'store'])->name('usuario.store');

Route::get('/perfilUsuario', [InicioController::class, 'perfil'])->name('usuarioPerfil');
// En web.php
Route::get('/perfilProducto', [InicioController::class, 'perfilProducto'])->name('PerfilProducto');


Auth::routes();
Route::post('/logout', [UsuarioController::class, 'destroy'])->name('logout');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/usuario/{id}/editar', [UsuarioController::class, 'edit'])
    ->name('usuario.edit')
    ->where('id', '[0-9]+');

Route::put('/usuario/{id}/update', [UsuarioController::class, 'update'])
    ->name('usuario.update')
    ->where('id', '[0-9]+');
// FIN CONTROLADOR USUARIO


// INICIO CONTROLADOR RECUPERACIONCONTRASEÑA

// RECUPERARION DE CONTRASEÑA 1
Route::get('/solicitud_recuperacion', [RecuperacionContrasenaController::class, 'FormularioSolicitud'])->name('FormularioSolicitud');
Route::post('/solicitud_recuperacion', [RecuperacionContrasenaController::class, 'procesarSolicitud'])->name('procesarSolicitud');

// MOSTRAR FORMULARIO DE RESTABLECIMIENTO 
Route::get('/restablecer/{token}', [RecuperacionContrasenaController::class, 'mostrarRestablecimiento'])->name('mostrarRestablecimiento');

// PROCESOS FORMULARIO DE RESTABLECIMIENTO
Route::post('/restablecer', [RecuperacionContrasenaController::class, 'procesarRestablecimiento'])->name('procesarRestablecimiento');
Route::get('/mensaje_confirmacion',  [RecuperacionContrasenaController::class, 'mostrarConfirmacion'])->name('mensaje_confirmacion');
Route::get('/test-email', [RecuperacionContrasenaController::class, 'sendTestEmail']);

// FIN CONTROLADOR RECUPERACIONCONTRASEÑA


// INICIO CONTROLADOR PRODUCTO

// INICIO SHOW
Route::get('/producto/{id}/show',[ProductoController::class,'ShowProducto'])->name('ShowProducto');
Route::get('/producto/{id}/showperfil',[ProductoController::class,'ShowProductoPerfil'])->name('ShowProductoPerfil');
Route::get('/favorito/{id}/show',[ProductoController::class,'ShowFavorito'])->name('ShowFavorito');
Route::get('/tienda/{id}', [UsuarioController::class, 'showtienda'])->name('vertienda')->where('id', '[0-9]+');
// FIN SHOW

// INICIO LIKE
Route::post('/productos/{id}/like', [ProductoController::class, 'like'])->name('producto.like');
Route::post('/productos/{id}/dislike', [ProductoController::class, 'dislike'])->name('producto.dislike');

Route::post('/oferta/{id}/like', [InicioController::class, 'like'])->name('oferta.like');
Route::post('/oferta/{id}/dislike', [InicioController::class, 'dislike'])->name('oferta.dislike');
// FIN LIKE

// INICIO COMENTERIO
Route::get('/producto/{id}', [ProductoController::class, 'ShowProducto'])->name('mostrar_producto');
Route::post('/producto/{productoId}/comentarios', [ProductoController::class, 'agregarComentario'])->name('agregar_comentario');
Route::delete('/EliminarFavorito/{id}/borrar',[ProductoController::class,'EliminarFavorito'])->whereNumber('id')->name('EliminarFavorito');
// FIN COMENTERIO

// INICIO PEDIDOS
Route::get('/Pedidos',[ProductoController::class,'Pedidos'])->name('Pedidos');
Route::post('/AgregarPedido/{producto}', [ProductoController::class, 'AgregarPedido'])->name('AgregarPedido');
Route::delete('/EliminarPedido/{id}/borrar',[ProductoController::class,'EliminarPedido'])->whereNumber('id')->name('EliminarPedido');
Route::delete('/EliminarComentario/{id}/borrar',[ProductoController::class,'EliminarComentario'])->whereNumber('id')->name('EliminarComentario');
// FIN PEDIDOS


// INICIO FAVORITOS
Route::get('/Favoritos',[ProductoController::class,'Favoritos'])->name('Favoritos');
Route::post('/AgregarFavorito/{producto}', [ProductoController::class, 'AgregarFavorito'])->name('AgregarFavorito');
Route::post('/AgregarPedidoFavorito/{favorito}', [ProductoController::class, 'AgregarPedidoFavorito'])->name('AgregarPedidoFavorito');
Route::delete('/EliminarFavorito/{id}/borrar',[ProductoController::class,'EliminarFavorito'])->whereNumber('id')->name('EliminarFavorito');
// FIN FAVORITOS


// INICO AGREGAR PRODUCTO
Route::get('/AñadirProducto',[ProductoController::class,'AñadirProducto'])->name('AñadirProducto');
Route::post('/AgregarProducto',[ProductoController::class,'AgregarProducto'])->name('AgregarProducto');
// FIN AGREGAR PRODUCTO

// FIN CONTROLADOR PRODUCTO

// INICIO CONTROLADOR HOME
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// FIN CONTROLADOR HOME

//ENVIAR CORREO
Route::post('/mail/send', [ProductoController::class, 'sendEmail'])->name('send.mail');

Route::middleware(['admin'])->group(function () {
    Route::get('/Usuarios', [UsuarioController::class, 'index'])->name('Admi');
    Route::get('/Usuarios/{id}', [UsuarioController::class, 'show'])->name('usuario.mostrar')
    ->where('id', '[0-9]+');
    Route::delete('/Usuarios/{id}/borrar', [UsuarioController::class, 'eliminar'])
    ->name('usuario.borrar')->where('id', '[0-9]+');


// Rutas
Route::get('/activar-desactivar-usuario/{id}', [UsuarioController::class, 'activarDesactivarUsuario'])->name('activar.desactivar.usuario');

Route::delete('/Usuarios/{id}/eliminar', [ProductoController::class, 'eliminarPro1'])->name('producto.borrar1')->where('id', '[0-9]+');
Route::delete('/Usuarios/{id}/eliminaroferta', [ProductoController::class, 'eliminaroferta'])->name('oferta.borrar')->where('id', '[0-9]+');

Route::delete('/productos/{id}/borrar', [ProductoController::class, 'eliminarPro'])->name('producto.borrar')->where('id', '[0-9]+');
Route::delete('/productos/{id}/borraroferta', [ProductoController::class, 'eliminaroferta1'])->name('oferta.borrar1')->where('id', '[0-9]+');

Route::get('/productos',[UsuarioController::class,'productos'])->name('productoslist');
Route::get('/ofertas',[UsuarioController::class,'ofertas'])->name('ofertaslist');
Route::get('/registros',[UsuarioController::class,'registros'])->name('registroslist');

Route::get('/Usuarios/registro', [UsuarioController::class, 'createAdmin'])->name('Admincreate');
Route::post('/Usuarios/registro', [UsuarioController::class, 'storeAdmin'])->name('Adminstore');

Route::delete('/EliminarComentarioAdmin/{id}/borrar',[UsuarioController::class,'EliminarComentarioAdmin'])->whereNumber('id')->name('EliminarComentarioAdmin');

Route::get('/Admin/{id}/show',[UsuarioController::class,'ShowProductoAdmin'])->name('ShowProductoAdmin');
Route::get('/Admin/{id}/showoferta',[UsuarioController::class,'ShowOfertaAdmin'])->name('ShowOfertaAdmin');});


Route::delete('/productos/{producto}', [ProductoController::class, 'destroy'])
    ->name('productos.destroy')
    ->middleware(['checkProductoOwnership']);
    
Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])
    ->name('producto.edit')
    ->where('id', '[0-9]+')
    ->middleware(['checkProductoOwnership']);

Route::put('/productos/{id}', [ProductoController::class, 'update'])
    ->name('producto.update')
    ->where('id', '[0-9]+')
    ->middleware(['checkProductoOwnership']);

Route::post('/reportar-usuario', [UsuarioController::class,'reportar'])->name('reportar.usuario');
