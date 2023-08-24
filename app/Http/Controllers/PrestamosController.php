<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use Illuminate\Support\Facades\DB; 

class PrestamosController extends Controller
{
    
    public function index(Request $request)
    {
        $PrestamoBuscar=$request->get('buscar');
        $prestamos= DB::table('prestamos')
                      ->select('id','fecha_solicitud','fecha_prestamo', 'fecha_devolucion', 'libro_id','usuario_id')
                      ->where('fecha_solicitud', 'LIKE', '%'.$PrestamoBuscar.'%')
                      ->orwhere('fecha_prestamo', 'LIKE', '%'.$PrestamoBuscar.'%')
                      ->orwhere('fecha_devolucion', 'LIKE', '%'.$PrestamoBuscar.'%')
                      ->orwhere('libro_id', 'LIKE', '%'.$PrestamoBuscar.'%')
                      ->orwhere('usuario_id', 'LIKE', '%'.$PrestamoBuscar.'%')
                      ->paginate(10);
        return view ('Prestamo.PIndex', compact('prestamos','PrestamoBuscar'));
    
        $prestamos = Prestamo::paginate(20);
        return view('Prestamo.PIndex', compact('prestamos'));
 
    }

    public function create()
    {
        return view('Prestamo.PCreate'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_solicitud'=>'required|regex:/[0-9]/',
            'fecha_prestamo'=>'required|regex:/[0-9]/',
            'fecha_devolucion'=>'required|regex:/[0-9]/',
            'usuario_id'=>'required|numeric|min:1|max:500',
            'libro_id'=>'required|numeric|min:1|max:500',
        ]);
        
        $prestamo = new Prestamo();
        $prestamo->fecha_solicitud=$request->input('fecha_solicitud');
        $prestamo->fecha_prestamo=$request->input('fecha_prestamo');
        $prestamo->fecha_devolucion=$request->input('fecha_devolucion');
        $prestamo->usuario_id=$request->input('usuario_id');
        $prestamo->libro_id=$request->input('libro_id'); 

        if ($prestamo->save()){
         $mensaje = "El prestamo se creo exitosamente"; 
        }
        
        else{
          $mensaje = "El prestamo no se creo exitosamente"; 
        }

        return redirect()->route('prestamo.index')->with('mensaje',$mensaje);
    }

    public function show(string $id)
    {
        $prestamo = Prestamo::findOrfail($id);
        return view('Prestamo.PShow' , compact('prestamo'));
    }

    public function edit(string $id)
    {
        $prestamo = Prestamo::findOrfail($id);
        return view('Prestamo.PEdit')->with('prestamos',$prestamo);
    }

    public function update(Request $request, string $id)
    {
        $prestamo = Prestamo::findOrfail($id);
        
        $request->validate([
            'fecha_solicitud'=>'required|regex:/[0-9]/',
            'fecha_prestamo'=>'required|regex:/[0-9]/',
            'fecha_devolucion'=>'required|regex:/[0-9]/',
            'usuario_id'=>'required|numeric|min:1|max:500',
            'libro_id'=>'required|numeric|min:1|max:500',
        ]);

        $prestamo->fecha_solicitud=$request->input('fecha_solicitud');
        $prestamo->fecha_prestamo=$request->input('fecha_prestamo');
        $prestamo->fecha_devolucion=$request->input('fecha_devolucion');
        $prestamo->usuario_id=$request->input('usuario_id');
        $prestamo->libro_id=$request->input('libro_id'); 

        if ($prestamo->save()){
            $mensaje = "El libro se edito exitosamente"; 
           }
           
           else{
             $mensaje = "El libro no se edito exitosamente"; 
           }
   
           return redirect()->route('prestamo.index')->with('mensaje',$mensaje);
    }

    public function destroy(string $id)
    {
        $borrados = Prestamo::destroy($id);
    
        if ($borrados > 0){
            $mensaje = "El prestamo se elimino exitosamente"; 
           }
           
           else{
             $mensaje = "El prestamo no se elimino exitosamente"; 
           }
   
           return redirect()->route('prestamo.index')->with('mensaje',$mensaje);
    }
}