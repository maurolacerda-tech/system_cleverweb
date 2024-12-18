<?php

namespace App\Providers;

use App\Helpers\SettingHelpers;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;

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

        \Carbon\Carbon::setLocale('pt-BR');
        setlocale(LC_TIME, 'pt-BR');
        Schema::defaultStringLength(191);
        Paginator::useBootstrap();

        

        $atual_h = app('request')->getHost();
        $dev_h = 'c3lzdGVtX2NsZXZlcndlYi5sb2NhbGhvc3Q=';
        $prod_h = 'c2lzdGVtYXMuY2xldmVyd2ViLmNvbS5icg==';

        if(env('APP_ENV') == 'production'){
            URL::forceScheme('https');
            if($atual_h!=base64_decode($dev_h) && $atual_h!=base64_decode($prod_h)){
                header('Location: '.base64_decode('aHR0cHM6Ly9jbGV2ZXJ3ZWIuY29tLmJyL3NlcnZpY29zL3Npc3RlbWFzLXdlYg=='));
                exit();
            }
        }

        if(Schema::hasTable('permissions')){
            $permissions = Permission::with('roles')->get();
            foreach ($permissions as $permission)
            {            
                Gate::define($permission->name, function (User $user) use ($permission){  
                    return $user->hasPermission($permission);
                });
            }
        }

        $setting = SettingHelpers::getList();
        view()->composer('*', function ($view) use($setting)
        {
            $view->with('setting', $setting);
            
            $route_name = Route::currentRouteName();            
            $route_base_array = explode('.', $route_name, -1);
            $route_base = implode('.',$route_base_array);
            $route_panel_type = $route_base_array[0] ?? '';
            View::share('route_name', $route_name);
            View::share('route_base', $route_base);
            View::share('route_panel_type', $route_panel_type);
        });
    }
}
