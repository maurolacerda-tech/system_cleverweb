<?php

$modules = include(__DIR__.'/../config/_modules.php');

$return = [
    App\Providers\AppServiceProvider::class,
];

foreach($modules as $module){
    array_push($return, $module);
}
return $return;
