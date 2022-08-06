<?php

declare(strict_types=1);

return [
    'debug'     => true,
    'log_file'  => 'log/app.log',
    'templates' => [
        'paths' => [
            'app'     => ['templates/app'],
            'error' => ['templates/error'],
            'layouts' => ['templates/layouts'],
        ],
    ],
];
