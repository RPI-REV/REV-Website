<?php

use Silex\Application;

$routes = simplexml_load_file(__DIR__.'/../routes.xml');

foreach ($routes->route as $_route) {
  $route = [
    'method' => 'get',
    'path' => '/',
    'name'=> null,
    'template' => null,
    'controller' => null,
    'redirect' => null
  ];

  $r = null;

  foreach ($_route->attributes() as $prop => $val) {
    $route[$prop] = (string) $val;
  }

  $route['name'] = $route['name'] != null ? $route['name'] : $route['path'];

  if ($route['template'] != null) {
    $r = $app->get($route['path'], function(Application $app) use ($route) {
      return $app['twig']->render($route['template'], [
        'mobile' => $app['mobile_detect']->isMobile()
      ]);
    })->bind($route['name']);
  } else if ($route['controller'] != null) {
    if ($route['method'] === 'get') {
      $r = $app->get($route['path'], $route['controller'])->bind($route['name']);
    } else if ($route['method'] === 'post') {
      $r = $app->post($route['path'], $route['controller'])->bind($route['name']);
    } else if ($routep['method'] === '*') {
      $r = $app->match($route['path'], $route['controller'])->bind($route['name']);
    }
  } else if ($route['redirect'] != null) {
    $r = $app->redirect($route['redirect']);
  }

  if ($r) {
    foreach ($_route->children() as $child) {
      if ($child->getName() === 'assert') {
        foreach ($child->attributes() as $assert => $regex) {
          $r->assert($assert, (string)$regex);
        }
      }
    }
  }
}

foreach ($routes->app as $_application) {
  $application = [
    'path' => '/',
    'name' => null,
    'controller' => null
  ];

  foreach ($_application->attributes() as $prop => $val) {
    $application[$prop] = (string) $val;
  }

  $application['name'] = $application['name'] != null ? $application['name'] : $application['path'];

  if ($application['controller'] != null) {
    if (method_exists($application['controller'], 'get')) {
      $app->get($application['path'], $application['controller'].'::get')->bind($application['name'].'::get');
    }

    if (method_exists($application['controller'], 'post')) {
      $app->post($application['path'], $application['controller'].'::post')->bind($application['name'].'::post');
    }
  }
}
