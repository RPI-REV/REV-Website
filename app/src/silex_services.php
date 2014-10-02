<?php

$app->register(new Silex\Provider\TwigServiceProvider(), [
  'twig.path' => '../app/templates' 
]);

require_once __DIR__.'/twig_functions.php';

$app->register(new SilexMtHaml\MtHamlServiceProvider());