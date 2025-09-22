<?php

use App\Rules\DatabaseConnectionRule;

return [

    'name' => 'FinFunder Web Installer',
    'redirect_route' => "/admin",
    /*
    |--------------------------------------------------------------------------
    | Server Requirements
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel server requirements, you can add as many
    | as your application require, we check if the extension is enabled
    | by looping through the array and run "extension_loaded" on it.
    |
    */
    'core'                 => [
        'minPhpVersion' => '8.1.0',
    ],

    /*
    |--------------------------------------------------------------------------
    | Php and Apache Requirements
    |--------------------------------------------------------------------------
    |
    | php extensions and apache modules requirements
    |
    */
    'requirements'         => [
        'php'    => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
            'gd'
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Folders Permissions
    |--------------------------------------------------------------------------
    |
    | This is the default Laravel folders permissions, if your application
    | requires more permissions just add them to the array list bellow.
    |
    */
    'permissions'          => [
        'storage/framework/' => '777',
        'storage/logs/'      => '777',
        'bootstrap/cache/'   => '777',
        '.env'   => '666',
    ],

    /*
    |--------------------------------------------------------------------------
    | Environment Form
    |--------------------------------------------------------------------------
    |
    | environment form fields
    */
    'environment' => [
        'form' => [
            'envato.purchase_code' => [
                'label'      => 'Purchase Code',
                'required'   => true,
                'rules'      => 'string|max:255',
                'env_key'    => 'PURCHASE_CODE',
                'config_key' => 'app.purchase_code',
            ],
            'app.name'          => [
                'label'      => 'App Name',
                'required'   => true,
                'rules'      => 'string|max:100',
                'env_key'    => 'APP_NAME',
                'config_key' => 'app.name',
            ],
            'app.url'           => [
                'label'      => 'App Url',
                'required'   => true,
                'rules'      => 'url',
                'env_key'    => 'APP_URL',
                'config_key' => 'app.url',
            ],
            'database.host'     => [
                'label'      => 'Database Host',
                'required'   => true,
                'rules'      => [
                    'string', 'max:50',
                    DatabaseConnectionRule::class,
                ],
                'env_key'    => 'DB_HOST',
                'config_key' => 'database.connections.mysql.host',
            ],
            'database.port'     => [
                'label'      => 'Database Port',
                'required'   => true,
                'rules'      => [
                    'numeric',
                    DatabaseConnectionRule::class,
                ],
                'env_key'    => 'DB_PORT',
                'config_key' => 'database.connections.mysql.port',
            ],
            'database.name'     => [
                'label'      => 'Database Name',
                'required'   => true,
                'rules'      => [
                    'string', 'max:50',
                    DatabaseConnectionRule::class,
                ],
                'env_key'    => 'DB_DATABASE',
                'config_key' => 'database.connections.mysql.database',
            ],
            'database.username' => [
                'label'      => 'Database Username',
                'required'   => true,
                'rules'      => [
                    'string', 'max:50',
                    DatabaseConnectionRule::class,
                ],
                'env_key'    => 'DB_USERNAME',
                'config_key' => 'database.connections.mysql.username',
            ],
            'database.password' => [
                'label'      => 'Database Password',
                'required'   => false,
                'rules'      => [
                    'nullable', 'string', 'max:50',
                    DatabaseConnectionRule::class,
                ],
                'env_key'    => 'DB_PASSWORD',
                'config_key' => 'database.connections.mysql.password',
            ],
        ],
    ],
];
