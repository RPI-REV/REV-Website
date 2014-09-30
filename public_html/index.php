<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../app/propel/generated-conf/config.php';
$assets = require __DIR__.'/assets.php';

use Silex\Application;

$app = new Application();

$app->register(new Silex\Provider\TwigServiceProvider(), [
	'twig.path' => '../app/templates' 
]);

$app['twig']->addFunction(new \Twig_SimpleFunction('asset', function ($asset) {
  $splode = explode('.', $asset);
  $type = end($splode);
  $file = reset($splode);
  
  if ($type === 'js' || $type === 'coffee') {
    echo "<script src=\"/assets/".$type.'/'.$file.'"></script>';
  } else if ($type === 'sass' || $type === 'css') {
    echo '<link rel="stylesheet" href="/assets/'.$type.'/'.$file.'">';
  } else {
    echo '';
  }
}));

$app['twig']->addFunction(new \Twig_SimpleFunction('vendor', function ($asset) {
  $type = end(explode('.', $asset));
  $path = explode('/', $asset);
  array_splice($path, 1, 0, 'dist');
  $path = implode('/', $path);
  
  if ($type === 'js') {
    echo '<script src="/vendor/'.$path.'"></script>"';
  } else if ($type === 'css') {
    echo '<link rel="stylesheet" href="/vendor/'.$path.'">';
  } else {
    echo '';
  }
}));

$app->register(new SilexMtHaml\MtHamlServiceProvider());

$detect = new Mobile_Detect;

$app['debug'] = true;

$app->get('/', function(Application $app) use ($detect) {
	return $app['twig']->render('home.html', [
		'mobile' => $detect->isMobile()
	]);
})->bind('home');

$app->get('/cars/', function(Application $app) {
  return $app['twig']->render('cars.haml');
})->bind('cars');

$app->get('/sponsors/', function(Application $app) {
	return $app['twig']->render('sponsors.haml');
})->bind('sponsors');

$app->get('/marketing/', function(Application $app) {
	return $app['twig']->render('marketing.html');
})->bind('marketing');

$app->get('/assets/{type}/{name}/', $assets)
->assert('name', '.*');

$app->run();