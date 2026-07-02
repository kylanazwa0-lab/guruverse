<?php

return [

    'defaults' => [
        'guard'     => 'web',
        'passwords' => 'members',
    ],

    'guards' => [
        // Guard untuk Member (pengguna biasa)
        'web' => [
            'driver'   => 'session',
            'provider' => 'members',
        ],
        // Guard untuk Admin Panel
        'admin' => [
            'driver'   => 'session',
            'provider' => 'admins',
        ],
    ],

    'providers' => [
        'members' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Member::class,
        ],
        'admins' => [
            'driver' => 'eloquent',
            'model'  => App\Models\Member::class, // Admin = Member dengan role admin
        ],
    ],

    'passwords' => [
        'members' => [
            'provider' => 'members',
            'table'    => 'password_reset_tokens',
            'expire'   => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
