<?php

$app->register(new Silex\Provider\TwigServiceProvider(), [
  'twig.path' => '../app/templates' 
]);

require_once __DIR__.'/twig_functions.php';

$app->register(new SilexMtHaml\MtHamlServiceProvider());

$app->register(new Binfo\Silex\MobileDetectServiceProvider());

$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__."/../config/config.json"));