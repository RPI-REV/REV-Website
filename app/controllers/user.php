<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class admin {
  public static function get(Application $app) {
    return CAS::requireLogin('ADMIN', function($user) use ($app) {
      return $app['twig']->render('admin.haml', [
        'user' => $user,
        'users' => UserQuery::create()->find()
      ]);
    });
  }

  public static function post(Application $app, Request $request) {
    return CAS::requireLogin('ADMIN', function($user) use ($app) {
      $dbuser = UserQuery::create()->findPK($_POST['id']);

      if ($dbuser == null) {
        $dbuser = new User();
        $dbuser->setId($_POST['id']);
        $dbuser->setName($_POST['name']);
        $dbuser->setPermissions([]);
      }

      if (isset($_POST['append'])) {
        $permissions = $dbuser->getPermissions();
        $dbuser->setPermissions(array_merge($permissions, explode(',', str_replace(' ', '', $_POST['permissions']))));
      } else {
        $dbuser->setPermissions(explode(',', str_replace(' ', '', $_POST['permissions'])));
      }

      $dbuser->save();
      return $app->redirect('/admin/');
    });
  }
}

function initUser(Application $app) {
  if (array_key_exists('init', $_GET) && array_key_exists('id', $_GET) && array_key_exists('name', $_GET)) {
    if ($_GET['init'] === $app['secret']) {
      $user = UserQuery::create()->findPK($_GET['id']);
      if ($user == null) {
        $user = new User();
        $user->setId($_GET['id']);
        $user->setName($_GET['name']);
        $user->setPermissions(['admin']);
        $user->save();

        return new Response('Success!');
      } else {
        $permissions = $user->getPermissions();
        if (!in_array('ADMIN', $permissions)) {
          array_push($permissions, 'ADMIN');
          $user->setPermissions($permissions);
          $user->save();
        }

        return new Response('admin permission added!');
      }
    } else {
      return new Response('init key not valid!');
    }
  }

  return new Response('Invalid key');
}
