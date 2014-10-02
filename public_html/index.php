<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/src/revlib.php';
require_once __DIR__.'/../app/propel/generated-conf/config.php';

foreach (scandir(__DIR__.'/../app/controllers/') as $controller) {
  if (\REVLib\endsWith($controller, '.php')) {
    require_once __DIR__.'/../app/controllers/'.$controller;
  }
}

use Silex\Application;

$detect = new Mobile_Detect;
$app = new Application();
$app['debug'] = true;

require_once __DIR__.'/../app/src/silex_services.php';
require_once __DIR__.'/../app/src/routes.php';

$app->run();