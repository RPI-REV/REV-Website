<?php

$settings = json_decode(file_get_contents(__DIR__.'/../config/config.json'), true);
$dbname = $settings['db_settings']['dbname']; // 'solarrac_test';
$user = $settings['db_settings']['user']; // 'solarrac_admin';
$password = $settings['db_settings']['password'];
$host = $settings['db_settings']['host'];

return [
    'propel' => [
        'database' => [
            'connections' => [
                $dbname => [
                    'adapter' => 'mysql',
                    'classname' => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'dsn' => 'mysql:host='.$host.';dbname='.$dbname,
                    'user' => $user,
                    'password' => $password,
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => $dbname,
            'connections' => [$dbname]
        ],
        'generator' => [
            'defaultConnection' => $dbname,
            'connections' => [$dbname]
        ]
    ]
];