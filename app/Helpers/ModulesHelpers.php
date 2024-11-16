<?php
namespace App\Helpers;

use Composer\Autoload\ClassLoader;

class ModulesHelpers
{
   public function get_all_modules()
   {
        $namespaces = $this->_get_namespaces();
        $modules = isset($namespaces['Modules']) ? $namespaces['Modules'] : [];
        return $modules;
   }

   public function get_list($group_module)
   {
        try {
            return $this->get_all_modules()[$group_module] ?? [];
        } catch (\Throwable $th) {
            return [];
        }
   }


    public function get_modules_config()
    {
        $modules_file = config('_modules');
        $modules_name = [];
        foreach ($modules_file as $key => $path_provider) {
            $path_provider_array = explode("\\",$path_provider);
            $module_name = $path_provider_array[1];
            $modules_name[$module_name] = [];
            //array_push($modules_name, $module_name);
        }
            return $modules_name;
    }

   protected function _get_namespaces()
   {
        $namespaces=[];
        $key_list = array_keys(ClassLoader::getRegisteredLoaders())[0];
        $get_declared_classes = ClassLoader::getRegisteredLoaders()[$key_list]->getClassMap();
        $get_declared_classes =  array_keys($get_declared_classes);
        //get_declared_classes()
        foreach($get_declared_classes as $name) {
            
            if(preg_match_all("@[^\\\]+(?=\\\)@iU", $name, $matches)) {
                $matches = $matches[0];
                $parent =&$namespaces;
                while(count($matches)) {
                    $match = array_shift($matches);
                    if(!isset($parent[$match]) && count($matches))
                        $parent[$match] = array();
                    $parent =&$parent[$match];        
                }
            }
        }
        return $namespaces;
   }
}