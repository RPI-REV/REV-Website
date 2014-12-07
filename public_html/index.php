<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/src/revlib.php';
require_once __DIR__.'/../app/src/require_constants.php';

$app = new Silex\Application();

require_once __DIR__.'/../app/src/silex_services.php';
require_once __DIR__.'/../app/propel/generated-conf/config.php';
require_once __DIR__.'/../app/src/cas.php';
require_once __DIR__.'/../app/src/require_controllers.php';
require_once __DIR__.'/../app/src/routes.php';

$app->run();