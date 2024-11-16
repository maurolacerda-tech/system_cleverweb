<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;


Route::namespace('Modules\Others\Cnpjws\Http\Controllers')->middleware(['web','auth'])->group(function () {
    $actions_array = config('cnpjws.actions');
    foreach($actions_array as $actions_item){
        $verb   = $actions_item['verb'];
        $url    = '/'.$actions_item['url'];
        $method = $actions_item['method'];
        Route::$verb($url, "CnpjwsController@$method");
    }    
});
