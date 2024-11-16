<?php

namespace App\Helpers;

use function GuzzleHttp\Psr7\str;

class EncryptionHelpers
{
    public static function Randomizar($iv_len, $rand=true)
    {
        $iv = '';
        while ($iv_len-- > 0) {
            $number = $rand ? mt_rand() : 915762897;
            $iv .= chr($number & 0xff);
        }
        return $iv;
    }
    
    public static function encode($texto, $key='keychave@kSystemCl3v3RPs77', $iv_len = 16, $rand=true)
    {
        $texto .= "\x13";
        $n = strlen($texto);
        if ($n % 16) $texto .= str_repeat("\0", 16 - ($n % 16));
        $i = 0;
        $Enc_Texto = self::Randomizar($iv_len,$rand);
        $iv = substr($key ^ $Enc_Texto, 0, 512);
        while ($i < $n) {
            $Bloco = substr($texto, $i, 16) ^ pack('H*', md5($iv));
            $Enc_Texto .= $Bloco;
            $iv = substr($Bloco . $iv, 0, 512) ^ $key;
            $i += 16;
        }
        return base64_encode($Enc_Texto);
    }
    
    public static function decode($Enc_Texto, $key='keychave@kSystemCl3v3RPs77', $iv_len = 16)
    {
        $Enc_Texto = base64_decode($Enc_Texto);
        $n = strlen($Enc_Texto);
        $i = $iv_len;
        $texto = '';
        $iv = substr($key ^ substr($Enc_Texto, 0, $iv_len), 0, 512);
        while ($i < $n) {
            $Bloco = substr($Enc_Texto, $i, 16);
            $texto .= $Bloco ^ pack('H*', md5($iv));
            $iv = substr($Bloco . $iv, 0, 512) ^ $key;
            $i += 16;
        }
        return preg_replace('/\\x13\\x00*$/', '', $texto);
    }

}