<?php

use App\Helpers\EncryptionHelpers;
use App\Helpers\SettingHelpers;
use Illuminate\Support\Facades\Storage;

function show_thumb($website_url='')
{
    $browser = new COM("InternetExplorer.Application");
    $handle = $browser->HWND;
    $browser->Visible = true;
    $browser->Navigate("http://www.libgd.org");

    /* Still working? */
    while ($browser->Busy) {
        com_message_pump(4000);
    }
    $im = imagegrabwindow($handle, 0);
    $browser->Quit();
    imagepng($im, "iesnap.png");
    imagedestroy($im);
}


function path_file($path)
{
    $session_tenant = session()->get('tenant') ?? 'nao_autorizado';
    $session_tenant_slug = $session_tenant['slug'];
    $path = $session_tenant_slug.'/'.$path;
    return $path;
}

function get_link_watsapp($number=null,$msg=null)
{
    $setting = SettingHelpers::getList();
    if(isset($setting['setting_general_whatsapp'])){

        $whatsApp = !is_null($number) ? $number : $setting['setting_general_whatsapp'];
        $msg_show = !is_null($msg) ? $msg : 'Olá, gostaria de mais informações';

        $numeroWhatsApp = '55'.preg_replace("/[^0-9]/", "", $whatsApp);
        $mobile = FALSE;
        $user_agents = array("iPhone","iPad","Android","webOS","BlackBerry","iPod","Symbian","IsGeneric");
        foreach($user_agents as $user_agent){
            if (strpos($_SERVER['HTTP_USER_AGENT'], $user_agent) !== FALSE) {
                $mobile = TRUE;	
                $modelo = $user_agent;	
                break;
            }
        }
        if ($mobile){
            //echo "Acesso feito via ".strtolower($modelo);
            $linkWhatsApp = 'https://api.whatsapp.com/send?phone=+'.$numeroWhatsApp.'&text='.$msg_show;
        }else{	
            //echo "Acesso feito via computador";
            $linkWhatsApp = 'https://web.whatsapp.com/send?phone=+'.$numeroWhatsApp.'&text='.$msg_show;
        }
        return $linkWhatsApp;
    }
    return '';
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function generate_code()
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $alphaLength = strlen($alphabet) - 1;

    $a = rand(0, $alphaLength);
    $b = rand(0, $alphaLength);
    $c = rand(0, $alphaLength);
    $d = rand(0, $alphaLength);

    $alphabet_01 = $alphabet[$a];
    $alphabet_02 = $alphabet[$b];
    $alphabet_03 = $alphabet[$c];
    $alphabet_04 = $alphabet[$d];

    $code = date('Y').$alphabet_01.date('m').$alphabet_02.date('d').$alphabet_03.date('His').$alphabet_04;
    return $code;
}

function get_image_base64($path_image)
{
    $type_image = pathinfo($path_image, PATHINFO_EXTENSION);
    $data_image = file_get_contents($path_image);
    $base64_image = 'data:image/' . $type_image . ';base64,' . base64_encode($data_image);
    return $base64_image;
}

function kriptar($texto)
{
    return EncryptionHelpers::encode($texto);
}

function dekriptar($texto)
{
    return EncryptionHelpers::decode($texto);
}

function kriptar_indication($contact_id)
{
    $key='keychave@kSystemCl3v3RPs77';
    $iv_len = 7;
    $param_link = urlencode(EncryptionHelpers::encode($contact_id, $key, $iv_len, false));
    return $param_link;
}

function dekriptar_indication($param_link)
{
    $key='keychave@kSystemCl3v3RPs77';
    $iv_len = 7;
    $decode = urldecode($param_link);
    $decripta = EncryptionHelpers::decode($decode, $key, $iv_len, false);
    return $decripta;
}

function diff_time($data_rigister)
{
    $date_now = new \DateTime('now');
    $interval = $date_now->diff( $data_rigister );
    $interval_s = ' ';
    if($interval->y > 0)
        $interval_s .= $interval->y.' '.($interval->y == 1 ? 'ano ' : 'anos ');

    if($interval->m > 0)
        $interval_s .= $interval->m.' '.($interval->m == 1 ? 'mês ' : 'meses ');

    if($interval->d > 0)
        $interval_s .= $interval->d.' '.($interval->d == 1 ? 'dia ' : 'dias ');

    if($interval->h > 0)
        $interval_s .= $interval->h.' '.($interval->h == 1 ? 'hora ' : 'horas ');

    if($interval->i > 0)
        $interval_s .= $interval->i.' '.($interval->i == 1 ? 'minuto ' : 'minutos ');

    if($interval->s > 0)
        $interval_s .= $interval->s.' '.($interval->s == 1 ? 'segundo ' : 'segundos ');

    if($interval_s == ' ')
        $interval_s .= 'Agora';
         
    return $interval_s;
}

function diff_time_hours($data_rigister)
{
    $date_now = new \DateTime('now');
    $interval = $date_now->diff( $data_rigister );
    return $interval->h + ($interval->days * 24);
}


function format_phonenumber($numero){
    $novo = $numero;
    if(!is_null($numero) && !empty($numero)){
        $novo = substr_replace($numero, '(', 0, 0);
        $novo = substr_replace($novo, ') ', 3, 0);
        if(strlen($numero) == 10){
            $novo = substr_replace($novo, '- ', 9, 0);
        }else{
            $novo = substr_replace($novo, '- ', 10, 0);
        }
    }
    return $novo;
}


function mask_field($val, $mask) {
    $maskared = '';
    $k = 0;
    if($mask == '##.###.###/####-##')
        $val = str_pad($val , 14 , '0' , STR_PAD_LEFT);

    for($i = 0; $i<=strlen($mask)-1; $i++) {
        if($mask[$i] == '#') {
            if(isset($val[$k])) $maskared .= $val[$k++];
        } else {
            if(isset($mask[$i])) $maskared .= $mask[$i];
        }
    }
    return $maskared;
}

function clean_text_caracteres($text)
{
    $array_index = ['/','*'];
    $text = str_replace($array_index,'',$text);
    return $text;
}

function change_text_caracteres($text)
{
    $array_index = ['/'];
    $array_change = ['<br />'];
    $text = str_replace($array_index,$array_change,$text);
    $regrex = "/\*(.*)\*/U";

    preg_match_all($regrex, $text, $new_text_array);

    if(isset($new_text_array[0]) && is_array($new_text_array[0])){
        foreach ($new_text_array[0] as $word) {
            $word_clean = str_replace('*','',$word);
            $text = str_replace(
                $word,
                '<strong>'.$word_clean.'</strong>',
                $text
            );
        }
    }
    return $text;
}

function min_caracter($text,$qtd=120)
{
    if(strlen($text) > $qtd){
        return substr($text,0,$qtd).'...';
    }
    return $text;
}

function slug($word)
{
    return \Illuminate\Support\Str::slug($word, '-');
}

function date_extenso($date)
{
    try {
        $date = date('Y-m-d',strtotime($date));
        //$date_extenso = strftime('%A, %d de %B de %Y', strtotime($date));
        $date_extenso = strftime('%d de %B, %Y', strtotime($date));
        $month_english = ['January','February','March','April','May','June','July','August','September','October','November','December'];
        $month_pt_br = ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
        $date_extenso = str_replace($month_english,$month_pt_br,$date_extenso);
        return $date_extenso;
    } catch (\Throwable $th) {
        return $date;
    }
    
}

function path_public_file($path)
{
    try {
        $setting = SettingHelpers::getList();
        $system_upload_type = $setting['system_upload_type'] ?? 'public';
        $path = substr($path,0,8) == 'storage/' ? substr($path,7) : $path;
        /** @disregard [url] [method in Storage Facades] */
        return Storage::disk($system_upload_type)->url($path);
    } catch (\Throwable $th) {
        return null;
    }
    
}

