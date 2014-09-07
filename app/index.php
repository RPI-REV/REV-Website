<?php

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/assets/php/Mobile_Detect.php';

use Silex\Application;

$app = new Application();

$app->register(new Silex\Provider\TwigServiceProvider(), array( 
	'twig.path' => 'templates' 
));

$detect = new Mobile_Detect;

$app['debug'] = true;

$app->get('/', function(Application $app) use ($detect) {
	return $app['twig']->render('home.html', array(
		'mobile' => $detect->isMobile()
	));
})->bind('home');

$app->get('/cars/', function(Application $app) {
	return $app['twig']->render('cars.html');
})->bind('cars');

$app->get('/sponsors/', function(Application $app) {
	return $app['twig']->render('sponsors.html');
})->bind('sponsors');

$app->get('/marketing/', function(Application $app) {
	return $app['twig']->render('marketing.html');
})->bind('marketing');

$app->run();