<?php

namespace App\Services;

use App\Mail\SendMailSuporte;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthService extends Service
{
    public function default_login(Array $data)
    {
        try {
            $validator = Validator::make(
                $data, 
                [
                    'email' => 'required|email',
                    'password' => 'required',
                    'captcha' => 'required'
                ],
                [
                    'email.required' => 'O E-mail é obrigatório',
                    'email.email' => 'E-mail inválido',
                    'password.required' => 'A Senha é obrigatória',
                    'captcha.required' => 'Captcha não informado'
                ]
            );

            if ($validator->fails()) {
                return response()->json(
                    $this->_validator_fails($validator),
                    200
                );
            }

            $post_data = http_build_query(
                array(
                    'secret' => config('auth.captcha_secret'),
                    'response' => $data['captcha'],
                    'remoteip' => $_SERVER['REMOTE_ADDR']
                )
            );
            $opts = array('http' =>
                array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $post_data
                )
            );
            $context  = stream_context_create($opts);
            $response_g = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
            $result_g = json_decode($response_g);	
            if (!$result_g->success) {
                return response()->json([
                    'error' => true,
                    'message' => 'A validação captcha falhou'
                ], 200);
            }

            $credentials = [
                'email' => $data['email'],
                'password' => $data['password']
            ];
            $filled_filled = false;
            if(!Auth::guard()->attempt($credentials, $filled_filled)){
                return response()->json([
                    'error' => true,
                    'message' => 'E-mail ou Senha não corresponde ao nosso registro!'
                ], 200);
            }

            $user = User::where('email', $data['email'])->first();
            if(!$user->status){
                Auth::guard()->logout();
                return response()->json([
                    'error' => true,
                    'message' => 'Este usuário não possui permissão para acessar este painel'
                ], 200);
            }
            $user->last_login = date('Y-m-d H:i:s');
            $user->save();

            return response()->json([
                'error' => false,
                'message' => 'Usuário logado com sucesso'
            ], 200);

        } catch (\Throwable $th) {

            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->AuthService->default_login';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Houve um problema ao tentar realizar a autenticação, nosso suporte foi notificado, tente novamente em alguns minutos.'
            ], 200);
        }
    }

    public function default_logout()
    {        
        try {
            Auth::logout();
            return response()->json([
                'error' => false,
                'message' => 'Sessão encerrada com sucesso!'
            ], 200);
        } catch (\Throwable $th) {
            $error_page = $th->getMessage().' linha:'.$th->getLine().' do arquivo:'.$th->getFile().' | Services->AuthService->default_logout';
            $error_title = 'Error Suporte - '.config('app.name');
            $mail_support = config('app.mail_support');
            Mail::to($mail_support)->send(new SendMailSuporte($error_page, $error_title));

            return response()->json([
                'error' => true,
                'message' => 'Não  foi possível encerrar a sessão! Nosso suporte foi notificado, tente novamente em alguns minutos.',
            ], 500);
        }
    }
}