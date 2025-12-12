<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- 1. AGREGADO AQUÍ

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
        // <--- 2. AGREGADO AQUÍ: Forzar HTTPS para que cargue el CSS
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
