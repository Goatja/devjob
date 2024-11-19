<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        VerifyEmail::toMailUsing(function($notifiable,$url){
            return (new MailMessage)
            ->subject('Verificar Cuenta')
            ->line('Tu Cuenta ya esta casi lista  , solo debes de Presionar el enlace a continuacion')
            ->action('Confirmar Cuenta',$url)
            ->line('Si tu no creaste esta cuenta puedes Ignorar este  mensaje');
        });
    }
}
