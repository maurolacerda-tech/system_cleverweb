<?php

return [
    'setting' => [
        'general' => [
            'label' => 'Geral',
            'fields' => [
                [
                    'type' => 'text',
                    'key' => 'setting_general_office_name',
                    'label' => 'Nome do Escritório',
                    'class' => 'form-control form-control-solid mb-3 mb-lg-0'
                ],
                [
                    'type' => 'text',
                    'key' => 'setting_general_phone1',
                    'label' => 'Telefone 1',
                    'class_box' => 'col-sm-3',
                    'class' => 'form-control form-control-solid mb-3 mb-lg-0'
                ],
                [
                    'type' => 'text',
                    'key' => 'setting_general_phone2',
                    'label' => 'Telefone 2',
                    'class_box' => 'col-sm-3',
                    'class' => 'form-control form-control-solid mb-3 mb-lg-0'
                ],
                [
                    'type' => 'text',
                    'key' => 'setting_general_whatsapp',
                    'label' => 'WhatsApp',
                    'class_box' => 'col-sm-4',
                    'class' => 'form-control form-control-solid mb-3 mb-lg-0'
                ],
                [
                    'type' => 'text',
                    'key' => 'setting_general_email1',
                    'label' => 'E-mail 1',
                    'class_box' => 'col-sm-4',
                    'class' => 'form-control form-control-solid mb-3 mb-lg-0'
                ],
                [
                    'type' => 'text',
                    'key' => 'setting_general_email2',
                    'label' => 'E-mail 2',
                    'class_box' => 'col-sm-4',
                    'class' => 'form-control form-control-solid mb-3 mb-lg-0'
                ],
                [
                    'type' => 'text',
                    'key' => 'setting_general_address',
                    'label' => 'Endereço',
                    'class_box' => 'col-sm-12',
                    'class' => 'form-control form-control-solid mb-3 mb-lg-0'
                ]
            ]
        ],
        'system' => [
            'label' => 'Sistema',
            'fields' => [
                [
                    'type' => 'select',
                    'key' => 'system_upload_type',
                    'label' => 'Local Upload',
                    'class' => 'form-select form-select-solid mb-3 mb-lg-0',
                    'class_box' => 'col-sm-3',
                    'option' => [
                        'public' => 'Public',
                        's3' => 'AWS S3',
                        'google_drive' => 'Google Drive',
                        'linode' => 'Linode',
                        'digitalocean' => 'DigitalOcean'
                    ]
                ]
            ]
        ]
    ]
];