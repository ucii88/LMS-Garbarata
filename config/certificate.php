<?php

return [
    'defaults' => [
        'organization_name' => 'Garbarata Training Center',
        'logo_path' => null,
        'primary_color' => '#d97706',
        'secondary_color' => '#b45309',
        'template_preset' => 'garbarata_default',
        'kepala_training_signature_path' => null,
        'kepala_training_name' => 'Kepala Training Center',
        'kepala_training_title' => 'Garbarata Training Center',
    ],
    'validation' => [
        'max_file_size_mb' => 5,
        'allowed_logo_formats' => ['png', 'jpg', 'jpeg', 'svg'],
        'max_organization_name_length' => 200,
    ],
];
