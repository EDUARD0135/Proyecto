<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $mensaje;
    public $subject;
    public $products;
    public $compradorNombre;
    public $compradorApellido;
    public $compradorNombreUsuario;
    public $compradorEmail;
    public $compradorTelefono;
    

    public function __construct($mensaje, $subject, $products, $compradorNombre, $compradorApellido, $compradorNombreUsuario, $compradorEmail,$compradorTelefono)
    {
        $this->mensaje = $mensaje;
        $this->subject = $subject;
        $this->products = $products;
        $this->compradorNombre = $compradorNombre;
        $this->compradorApellido = $compradorApellido;
        $this->compradorNombreUsuario = $compradorNombreUsuario;
        $this->compradorEmail = $compradorEmail;
        $this->compradorTelefono = $compradorTelefono;
    }


    public function build()
    {
        return $this->view('Mails.SendOrderNotification')
                    ->subject($this->subject)
                    ->with([
                        'mensaje' => $this->mensaje,
                        'products' => $this->products,
                        'compradorNombre' => $this->compradorNombre,
                        'compradorApellido' => $this->compradorApellido,
                        'compradorTelefono' => $this->compradorTelefono,
                        'compradorNombreUsuario' => $this->compradorNombreUsuario,
                        'compradorEmail' => $this->compradorEmail
                    ]);
    }
}
