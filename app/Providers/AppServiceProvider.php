<?php

namespace App\Providers;

use App\_clases\proyectos\Obra;
use App\_clases\proyectos\ActividadObra;
use App\Observers\ObraObserver;
use App\Observers\ActividadObraObserver;

use App\_clases\proyectos\Actividad;
use App\Observers\OperacionObserver;
use App\Operacion;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Obra::observe(ObraObserver::class);
        ActividadObra::observe(ActividadObraObserver::class);
        Operacion::observe(OperacionObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
