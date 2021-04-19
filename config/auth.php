<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
            'hash' => false,
        ],

        'root' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'sub_admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'tecnico' => [
            'driver' => 'session',
            'provider' => 'tecnicos',
        ],

        'vendedor' => [
            'driver' => 'session',
            'provider' => 'vendedores',
        ],

        'servicio_cliente' => [
            'driver' => 'session',
            'provider' => 'servicio_clientes',
        ],

        'personalizado' => [
            'driver' => 'session',
            'provider' => 'personalizados',
        ],

        'almacenista' => [
            'driver' => 'session',
            'provider' => 'personalizados',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Admin::class,
        ],

        'tecnicos' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'vendedores' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'servicio_clientes' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'personalizados' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        'almacenista' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ]

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    */
];
