<?php

// config for Kangangga/Bpjs
return [

    'default_auth' => [
        'username' => 'timoti',
        'password' => 'Timoti-1992',
        'app_code' => '095',
    ],

    'default_options' => [
        'debug' => false,
        'timeout' => 30,
        'http_errors' => false,
        'connect_timeout' => 10,
    ],

    'pcare' => [
        'base_url' => env('BPJS_PCARE_BASE_URL', 'https://apijkn-dev.bpjs-kesehatan.go.id/pcare-rest-dev'),
        'auth' => [
            'user_key' => env('BPJS_USER_KEY'),
            'secret_key' => env('BPJS_SECRET_KEY'),
            'consumer_id' => env('BPJS_CONSUMER_ID'),
        ],
        'options' => [],
    ],

    'antrean' => [
        'base_url' => env('BPJS_ANTREAN_BASE_URL', 'https://apijkn-dev.bpjs-kesehatan.go.id/antreanrs_dev'),
        'auth' => [],
        'options' => [],
    ],

    'apotek' => [
        'base_url' => env('BPJS_APOTEK_BASE_URL', 'https://apijkn-dev.bpjs-kesehatan.go.id/apotek-rest-dev'),
        'auth' => [],
        'options' => [],
    ],

    'vclaim' => [
        'base_url' => env('BPJS_VCLAIM_BASE_URL', 'https://apijkn-dev.bpjs-kesehatan.go.id/vclaim-rest-dev'),
        'auth' => [],
        'options' => [],
    ],

    'logging' => [
        'driver' => 'single',
        'path' => storage_path('logs/bpjs.log'),
        'level' => env('LOG_LEVEL', 'debug'),
    ],

    'listen' => [
        \Illuminate\Http\Client\Events\RequestSending::class => [
            \Kangangga\Bpjs\Listeners\BpjsRequestSending::class,
        ],
        \Illuminate\Http\Client\Events\ResponseReceived::class => [
            \Kangangga\Bpjs\Listeners\BpjsResponseReceived::class,
        ],
        \Illuminate\Http\Client\Events\ConnectionFailed::class => [
            \Kangangga\Bpjs\Listeners\BpjsConnectionFailed::class,
        ],
    ],
];
