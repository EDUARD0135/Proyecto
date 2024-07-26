<?php

namespace App\Http\Controllers;

use App\Mail\RecuperacionContrasenaMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Usuario;
use DB;

class RecuperacionContrasenaController extends Controller
{
    public function sendTestEmail()
    {
        Mail::raw('Este es un correo de prueba desde Gmail usando Laravel', function ($message) {
            $message->to('juniorgarcia05092002@gmail.com');
            $message->subject('Correo de Prueba');
        });

        return 'Correo enviado';
    }

    public function mostrarConfirmacion()
    {
        return view('InicioSesion.mensaje_confirmacion');
    }

    public function FormularioSolicitud()
    {
        return view('InicioSesion.solicitud_recuperacion');
    }

    public function procesarSolicitud(Request $request)
    {
        $email = $request->input('email');
        $user = Usuario::where('email', $email)->first();

        if ($user) {
            $token = bin2hex(random_bytes(32));
            $caducidad = now()->addHours(1);

            DB::table('tokens_recuperacion')->insert([
                'usuario_id' => $user->id,
                'token' => $token,
                'caducidad' => $caducidad
            ]);

            $url = route('mostrarRestablecimiento', ['token' => $token]);
            $mensaje = "Hola, para restablecer tu contraseña, por favor sigue el siguiente enlace: $url";
            Mail::raw($mensaje, function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Restablecimiento de Contraseña');
            });
        }

        return redirect()->route('mensaje_confirmacion');
    }

    public function mostrarRestablecimiento($token)
    {
        return view('InicioSesion.restablecer_contrasena', ['token' => $token]);
    }

    public function procesarRestablecimiento(Request $request)
    {
        $token = $request->input('token');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');

        // Encuentra el registro del token en la base de datos
        $tokenRecord = DB::table('tokens_recuperacion')->where('token', $token)->first();

        // Verifica que el token sea válido
        if (!$tokenRecord || now() > $tokenRecord->caducidad) {
            return redirect()->route('FormularioSolicitud')->withErrors(['El token es inválido o ha expirado.']);
        }

        // Verifica que las contraseñas coincidan
        if ($password !== $confirm_password) {
            return back()->withErrors(['Las contraseñas no coinciden.']);
        }

        // Restablecer la contraseña del usuario
        $user = Usuario::find($tokenRecord->usuario_id);
        $user->contrasena = bcrypt($password);  // Asegúrate de cifrar la contraseña
        $user->save();

        // Elimina el token de restablecimiento para que no pueda ser usado nuevamente
        DB::table('tokens_recuperacion')->where('token', $token)->delete();

        return redirect()->route('usuario.login')->with('success', 'Contraseña restablecida con éxito.');
    }

    
}
