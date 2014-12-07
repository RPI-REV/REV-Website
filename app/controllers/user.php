<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

function newUser(Application $app, Request $request) {
 $user = UserQuery::create()->findPK($request->get('id'));
  if ($user == null) {
    $user = new User();
    $user->setId($request->get('id'));
  }
  
  $user->setAccess($request->get('access'));
  $user->save();
  return $app->redirect('/admin/');
}

function admin(Application $app) {
  return CAS::requireLogin(2, function($user) use ($app) {
    return $app['twig']->render('admin.haml', [
      'user' => $user,
      'users' => UserQuery::create()->find()
    ]);
  });
}