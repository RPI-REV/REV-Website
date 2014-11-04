<?php

use Aptoma\Twig\Extension\MarkdownExtension;
use Aptoma\Twig\Extension\MarkdownEngine\MichelfMarkdownEngine;
use Silex\Provider\UrlGeneratorServiceProvider;
use Silex\Provider\TwigServiceProvider;
use SilexMtHaml\MtHamlServiceProvider;
use Binfo\Silex\MobileDetectServiceProvider;
use Igorw\Silex\ConfigServiceProvider;

$app->register(new UrlGeneratorServiceProvider());

$app->register(new TwigServiceProvider(), [
  'twig.path' => '../app/templates' 
]);

$app['twig']->addExtension(new MarkdownExtension(new MichelfMarkdownEngine()));

require_once __DIR__.'/twig_functions.php';

$app->register(new MtHamlServiceProvider());

$app->register(new MobileDetectServiceProvider());

$app->register(new ConfigServiceProvider(__DIR__."/../config/config.json"));