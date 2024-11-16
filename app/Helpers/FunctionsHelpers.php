<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

class FunctionsHelpers
{
   public static function get_menuslug()
   {
    $routeCurrent = Route::current();
    
    $routeCurrentArray = [];
    if(isset($routeCurrent->uri))
        $routeCurrentArray = explode('/',$routeCurrent->uri);

    if(!is_null($routeCurrent) && !empty($routeCurrent))
    return isset($routeCurrentArray[1]) ? $routeCurrentArray[1] : $routeCurrentArray[0];
    
   }

   public static function viacep($cep)
    {
        try {
            $response = Http::get('https://viacep.com.br/ws/'.$cep.'/json/');
            return $response->json();
        } catch (\Throwable $th) {
            return [];
        }
    }

   public function value_array($arrays,$name_field=null)
   {
      $return = [];
      if(is_null($name_field)){   
         foreach($arrays as $key => $value){
            $return[$value] = $value;
         }   
      }else{         
         foreach($arrays as $key => $value){
            if($name_field == $key)           
               $return[$value] = $value;
         }
      }
      return $return;
   }
   
   public static function number_array($numbet)
   {
      $dynamicarray = [];
      for($i=1;$i<=$numbet;$i++)
      {
         $dynamicarray[$i]=$i;
      }
      return $dynamicarray;
   }

   public static function _moedaDb($value)
   {
      $source = array('.', ',','_','R$',' ');
      $replace = array('', '.','','','');
      return str_replace($source, $replace, $value); 
   }

   public static function _cpDb($value)
   {
      $source = array('.', ',');
      $replace = array('', '.');
      return str_replace($source, $replace, $value); 
   }

   public static function getIp(){
      $list_http = ['HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
      foreach ($list_http as $key){
          if (array_key_exists($key, $_SERVER) === true){
              foreach (explode(',', $_SERVER[$key]) as $ip){
                  $ip = trim($ip); // just to be safe
                  if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                      return $ip;
                  }
              }
          }
      }
      return request()->ip(); // it will return server ip when no client ip found
   }

   public static function valorPorExtenso($valor=0) {
      $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
      $plural = array("centavos", "reais", "mil", "milhões", "bilhões", "trilhões","quatrilhões");

      $c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
      $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
      $d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
      $u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");

      $z=0;
      $valor = number_format($valor, 2, ".", ".");
      $inteiro = explode(".", $valor);
      for($i=0;$i<count($inteiro);$i++)
          for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
              $inteiro[$i] = "0".$inteiro[$i];

      // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
      $fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
      $rt = '';
      for ($i=0;$i<count($inteiro);$i++) {
          $valor = $inteiro[$i];
          $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
          $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
          $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

          $r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
          $t = count($inteiro)-1-$i;
          $r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
          if ($valor == "000")$z++; elseif ($z > 0) $z--;
          if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
          if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
      }

      return($rt ? $rt : "zero");
  }
 

   public function truncate_email($email)
   {
      $append = '***';
      $elem = explode('@', $email);

      $qtd_char_email = strlen($elem[0]);
      $half_char_email = (int)($qtd_char_email/2);

      $elem[0] = substr($elem[0], 0, $half_char_email) . $append;
      $elem[1] = $append . substr($elem[1], 2);

      return $elem[0] . '@' . $elem[1];
   }


}