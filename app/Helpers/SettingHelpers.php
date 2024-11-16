<?php

namespace App\Helpers;
use Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

class SettingHelpers
{
  public static function getList()
  {
    try {
      $arr = [];
      if(!Schema::hasTable('settings')){
        return $arr;
      }

      $settings = Setting::all();
      foreach($settings as $setting){
          $arr[$setting->key] = $setting->value;
      }
      return $arr;
    } catch (\Throwable $th) {
      $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile();
      return [$error_page];
    }
      
  }

  public static function array_combine_recursive( array $data , $separator = ',' )
  {
    $response = new \stdClass();
    $callback = function( $item , $key , $aux ) use ( $response , $separator ) {
      $aux[ 2 ][] = $item;  
      if ( count( $aux[ 0 ] ) ){
        $array_shift1 = array_shift( $aux[ 0 ] );
        array_walk( $array_shift1 , $aux[ 1 ] , array( $aux[ 0 ] , $aux[ 1 ] , $aux[ 2 ] ) );
      }else{
        $response->data[] = implode( $separator , $aux[ 2 ] );
      }
    };  
    $response->data = array();
    $array_shift2 = array_shift( $data );
    array_walk( $array_shift2 , $callback , array( $data , $callback , array() ) );  
    return $response->data;
  }

  public function save_values(Array $dataForm)
  {

    if( isset($dataForm['source_form_module']) ){
      $config_array = config($dataForm['source_form_module']);            
      foreach ($config_array['fields'] as $field) {
          $array_setting[$field['key']] = $field['type'];
      }
      $dataForm = array_intersect_key($dataForm, $array_setting);
    }else{
        $config_array = config('setting.setting');
        foreach ($config_array as $keyAbas => $valueAbas){
            foreach ($valueAbas['fields'] as $field) {
                $array_setting[$field['key']] = $field['type'];
            }            
        }
    }
    
    foreach($dataForm as $key => $value ){
        $value = (is_array($value) ? implode(',', $value) : $value );
        if(isset($array_setting[$key]) && $array_setting[$key] ==  'krypt'){
            $value = kriptar($value);
        }elseif(isset($array_setting[$key]) && $array_setting[$key] ==  'upload_image'){                
            $path_image = (string)$value;
            $type_image = pathinfo($path_image, PATHINFO_EXTENSION);
            $data_image = file_get_contents($path_image);
            $base64_image = 'data:image/' . $type_image . ';base64,' . base64_encode($data_image);
            $value = $base64_image;
        }
        if($key != 'source_form_module'){
          Setting::updateOrCreate(
              ['key' => $key],
              ['value' => $value]
          );
        }
    }
    return true;
  }

}