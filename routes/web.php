<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibrosController;
use App\Http\Controllers\PrestamosController;
use App\Http\Controllers\UsuariosController;

// RUTAS LIBROS
// INDEX
Route::get('/libros',[LibrosController::class,'index'])->name('libro.index');
// SHOW
Route::get('/libros/{id}/show',[LibrosController::class,'show'])->where('id','[0-9]+')->name('libro.show');
// CREATE Y STORE
Route::get('/libros/crear',[LibrosController::class,'create'])->name('libro.crear');
Route::post('/libros/crear',[LibrosController::class,'store'])->name('libro.store');
// EDIT
Route::get('/libros/{id}/editar',[LibrosController::class,'edit'])->whereNumber('id')->name('libro.editar');
Route::put('/libros/{id}/editar',[LibrosController::class,'update'])->whereNumber('id')->name('libro.update');
//DELETE
Route::delete('/libros/{id}/borrar',[LibrosController::class,'destroy'])->whereNumber('id')->name('libro.borrar');



// RUTAS PRESTAMOS
// INDEX
Route::get('/prestamos',[PrestamosController::class,'index'])->name('prestamo.index');
// SHOW
Route::get('/prestamos/{id}/show',[PrestamosController::class,'show'])->where('id','[0-9]+')->name('prestamo.show');
// CREATE Y STORE
Route::get('/prestamos/crear',[PrestamosController::class,'create'])->name('prestamo.crear');
Route::post('/prestamos/crear',[PrestamosController::class,'store'])->name('prestamo.store');
// EDIT
Route::get('/prestamos/{id}/editar',[PrestamosController::class,'edit'])->whereNumber('id')->name('prestamo.editar');
Route::put('/prestamos/{id}/editar',[PrestamosController::class,'update'])->whereNumber('id')->name('prestamo.update');
//DELETE
Route::delete('/prestamos/{id}/borrar',[PrestamosController::class,'destroy'])->whereNumber('id')->name('prestamo.borrar');



// RUTAS USUARIOS
// INDEX
Route::get('/usuarios',[UsuariosController::class,'index'])->name('usuario.index');
// SHOW
Route::get('/usuarios/{id}/show',[UsuariosController::class,'show'])->where('id','[0-9]+')->name('usuario.show');
// CREATE Y STORE
Route::get('/usuarios/crear',[UsuariosController::class,'create'])->name('usuario.crear');
Route::post('/usuarios/crear',[UsuariosController::class,'store'])->name('usuario.store');
// EDIT
Route::get('/usuarios/{id}/editar',[UsuariosController::class,'edit'])->whereNumber('id')->name('usuario.editar');
Route::put('/usuarios/{id}/editar',[UsuariosController::class,'update'])->whereNumber('id')->name('usuario.update');
//DELETE
Route::delete('/usuarios/{id}/borrar',[UsuariosController::class,'destroy'])->whereNumber('id')->name('usuario.borrar');

