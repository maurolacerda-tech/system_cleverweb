<?php

namespace App\Services;

abstract class Service
{
    protected function _validator_fails($validator)
    {
        $errors_list = json_decode($validator->errors());
        $errors_array = [];
        foreach ($errors_list as $errors) {
            foreach ($errors as  $error) {
                $errors_array[] = $error;
            }                    
        }
        $msg_erro = implode(','.chr(10),$errors_array);
        return [
            'error' => true,
            'message' => $msg_erro
        ];
    }
}
