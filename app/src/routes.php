<?php

use Silex\Application;

$routes = simplexml_load_file(__DIR__.'/../routes/routes.xml');

foreach ($routes->route as $_route) {
  $method = 'get';
  $route = '/';
  $name = '__NULL';
  $template = '__NULL';
  $controller = '__NULL';
  $redirect = '__NULL';
  $access = '__NULL';
  $r = false;
  
  foreach ($_route->attributes() as $prop => $val) {
    $$prop = (string) $val;
  }
  
  $name = $name != '__NULL' ? $name : $route;
  
  if ($template != '__NULL') {
    if ($access == '__NULL') {
      $r = $app->get($route, function(Application $app) use ($template) {
        return $app['twig']->render($template, [
          'mobile' => $app['mobile_detect']->isMobile() 
        ]);
      })->bind($name);
    } else {
      $r = $app->get($route, function(Application $app) use ($template, $access) {
        return CAS::requireLogin($access, function($user) use ($app, $template) {
          return $app['twig']->render($template, [
            'mobile' => $app['mobile_detect']->isMobile(),
            'user' => $user
          ]);
        });
      })->bind($name);
    }
  } else if ($controller != '__NULL') {
    if ($method === 'get') {
      $r = $app->get($route, $controller)->bind($name);
    } else if ($method === 'post') {
      $r = $app->post($route, $controller)->bind($name);
    } else if ($method === '*') {
      $r = $app->match($route, $controller)->bind($name);
    }
  } else if ($redirect != '__NULL') {
    $r = $app->redirect($redirect);
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