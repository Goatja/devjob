<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //

        $notificaciones = auth()->user()->unreadNotifications;
      //$notificaciones = auth()->user()->unreadNotifications()->get();

      // dd($notificaciones);
      // $user = user::has('notifications')->first();

         // Limpiar Notificaciones
         auth()->user()->unreadNotifications->markAsRead();
        
        return view('notificaciones.index',[
                    'notificaciones'=>$notificaciones

        ]);
    }
}
