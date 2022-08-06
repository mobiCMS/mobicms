<?php

declare(strict_types=1);

return [
    'debug'     => true,
    'log_file'  => 'system/log/app.log',
    'templates' => [
        'paths' => [
            'app'     => ['system/templates/app'],
            'error' => ['system/templates/error'],
            'layouts' => ['system/templates/layouts'],
        ],
    ],
];
