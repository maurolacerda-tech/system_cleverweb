<?php

namespace Modules\Others\Cnpjws\Providers;

use Illuminate\Support\ServiceProvider;


class CnpjwsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        include(__DIR__. '/../Routes/web.php');
        
        $this->publishes([
            __DIR__.'/../Config/cnpjws.php' => config_path('cnpjws.php'),
        ], 'config');
            
    }
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/cnpjws.php',
            'cnpjws'
        );
        
    }
}