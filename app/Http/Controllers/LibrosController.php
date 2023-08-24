<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use Illuminate\Support\Facades\DB; 

class LibrosController extends Controller
{
    
    public function index(Request $request)
    {
        $LibroBuscar=$request->get('buscar');
        $libros=DB::table('libros')
                    ->select('id','titulo','autor', 'editorial', 'año_publicacion','cantidad_disponible')
                    ->where('titulo', 'LIKE', '%'.$LibroBuscar.'%')
                    ->orwhere('autor', 'LIKE', '%'.$LibroBuscar.'%')
                    ->orwhere('editorial', 'LIKE', '%'.$LibroBuscar.'%')
                    ->orwhere('año_publicacion', 'LIKE', '%'.$LibroBuscar.'%')
                    ->orwhere('cantidad_disponible', 'LIKE', '%'.$LibroBuscar.'%')
                    ->paginate(10);
        return view ('Libro.LIndex', compact('libros','LibroBuscar'));
    
        $libros =Libro::paginate(20);
        return view('Libro.LIndex', compact('libros'));
 
    }

    public function create()
    {
        return view('Libro.LCreate');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'=>'required|regex:/[A-Z][a-z]+/i',
            'autor'=>'required|regex:/[A-Z][a-z]+/i',
            'editorial'=>'required|regex:/[A-Z][a-z]+/i',
            'año_publicacion'=>'required|numeric|min:1880|max:2023',
            'cantidad_disponible'=>'required|numeric|min:1|max:500',
        ]);
        
        $libro = new Libro();
        $libro->titulo=$request->input('titulo');
        $libro->autor=$request->input('autor');
        $libro->editorial=$request->input('editorial');
        $libro->año_publicacion=$request->input('año_publicacion');
        $libro->cantidad_disponible=$request->input('cantidad_disponible'); 

        if ($libro->save()){
         $mensaje = "El libro se creo exitosamente"; 
        }
        
        else{
          $mensaje = "El libro no se creo exitosamente"; 
        }

        return redirect()->route('libro.index')->with('mensaje',$mensaje);
    }

    public function show(string $id)
    {
        $libro = Libro::findOrfail($id);
        return view('Libro.LShow' , compact('libro'));
    }

    public function edit(string $id)
    {
        $libro = Libro::findOrfail($id);
        return view('Libro.LEdit')->with('libros',$libro);
    }

    public function update(Request $request, string $id)
    {
        $libro = Libro::findOrfail($id);
        
        $request->validate([
            'titulo'=>'required|regex:/[A-Z][a-z]+/i',
            'autor'=>'required|regex:/[A-Z][a-z]+/i',
            'editorial'=>'required|regex:/[A-Z][a-z]+/i',
            'año_publicacion'=>'required|numeric|min:1880|max:2023',
            'cantidad_disponible'=>'required|numeric|min:1|max:500',
        ]);

        $libro->titulo=$request->input('titulo');
        $libro->autor=$request->input('autor');
        $libro->editorial=$request->input('editorial');
        $libro->año_publicacion=$request->input('año_publicacion');
        $libro->cantidad_disponible=$request->input('cantidad_disponible'); 

        if ($libro->save()){
            $mensaje = "El libro se edito exitosamente"; 
           }
           
           else{
             $mensaje = "El libro no se edito exitosamente"; 
           }
   
           return redirect()->route('libro.index')->with('mensaje',$mensaje);

    }

    public function destroy(string $id)
    {
        $borrados = Libro::destroy($id);
    
        if ($borrados > 0){
            $mensaje = "El libro se elimino exitosamente"; 
           }
           
           else{
             $mensaje = "El libro no se elimino exitosamente"; 
           }
   
           return redirect()->route('libro.index')->with('mensaje',$mensaje);
    }
}