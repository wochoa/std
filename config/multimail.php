<?php

return [
    /*
    |--------------------------------------------------------------------------
    | List your email providers
    |--------------------------------------------------------------------------
    |
    | Enjoy a life with multimail
    |
    */
    'use_default_mail_facade_in_tests' => true,

    'emails' => [
        'mpv.gorehco@gmail.com'      => [
            'pass'      => env('MAIL_PASSWORD'),
            'username'  => env('MAIL_USERNAME'),
            'from_name' => env('MAIL_FROM_NAME'),
        ],
        // 'mpvg.gorehco@gmail.com'     => [
        //     'pass'      => env('MAIL_PASSWORD'),
        //     'username'  => 'mpvg.gorehco@gmail.com' ,
        //     'from_name' => env('MAIL_FROM_NAME'),
        // ],//esta bloqueado
        // 'mpvrh.gorehco@gmail.com'    => [
        //     'pass'      => 'htyahhkrezmtezgm',
        //     'username'  => 'mpvrh.gorehco@gmail.com',
        //     'from_name' => env('MAIL_FROM_NAME'),
        // ],//esta bloqueando
        'grhmpv.gorehco@gmail.com'    => [
            'pass'      => env('MAIL_PASSWORD'),
            'username'  => 'grhmpv.gorehco@gmail.com',
            'from_name' => env('MAIL_FROM_NAME'),
        ],
        'grmpv.gorehco@gmail.com'    => [
            'pass'      =>  env('MAIL_PASSWORD'),
            'username'  => 'grmpv.gorehco@gmail.com',
            'from_name' => env('MAIL_FROM_NAME'),
        ],
        // 'mpvgrh.gorehco@gmail.com'   => [
        //     'pass'      => env('MAIL_PASSWORD'),
        //     'username'  => 'mpvgrh.gorehco@gmail.com',
        //     'from_name' => env('MAIL_FROM_NAME'),
        // ],//esta bloqueado
        'mpvgrhco.gorehco@gmail.com' => [
            'pass'      => env('MAIL_PASSWORD'),
            'username'  => 'mpvgrhco.gorehco@gmail.com',
            'from_name' => env('MAIL_FROM_NAME'),
        ],
    ],

    'provider' => [
        'default' => [
            'host'       => env('MAIL_HOST'),
            'port'       => env('MAIL_PORT'),
            'encryption' => env('MAIL_ENCRYPTION'),
        ],
    ],

];
