<?php

namespace App\Services;

abstract class Service
{
    protected function _validator_fails($validator)
    {
        $errors_list = json_decode($validator->errors());
        return [
            'error' => true,
            'message' => $errors_list
        ];
    }
}
