<?php

$settings = parse_ini_file(__DIR__.'/../../key.ini', true);
$dbname = 'solarrac_' . $settings['database']['dbname']; //'solarrac_test';
$user = 'solarrac_' . $settings['database']['user'];
$password = $settings['database']['password'];

return [
    'propel' => [
        'database' => [
            'connections' => [
                $dbname => [
                    'adapter' => 'mysql',
                    'classname' => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'dsn' => 'mysql:host=http://db.union.rpi.edu;dbname='.$dbname,
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