<?php

$actions = [];


return [
    'name' => 'Cnpjws',
    'label' => 'Cnpj.ws',
    'controller' => 'CnpjwsController',
    'actions' => $actions,
    'fields' => [],
    'type' => 'Others',
    'author' => 'Mauro Lacerda - maurolacerda@dotspace.com.br',
    'folder' => 'cnpjws',
    'config' => [
        'fields' => [
            [
                'type' => 'select',
                'key' => 'modulue_cnpjws_config_status',
                'label' => 'Status',
                'class' => 'form-control',
                'option' => [
                    'inactive' => 'Inativo',
                    'active' => 'Ativo'
                ]
            ],
            [
                'type' => 'krypt',
                'key' => 'modulue_cnpjws_token',
                'label' => 'Token',
                'class' => 'form-control'
            ]
        ]
    ]
];