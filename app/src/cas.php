<?php

use Silex\Appliction;
use Symfony\Component\HttpFoundation\Response;

class CAS {
  public static $app;

  public static function init(&$app) {
    self::$app = $app;
    if ($app['cas_settings']['host'] != false && $app['cas_settings']['enabled']) {
      phpCAS::client(CAS_VERSION_2_0, self::$app['cas_settings']['host'], self::$app['cas_settings']['port'], self::$app['cas_settings']['method']);
      phpCAS::setNoCasServerValidation();
    }
  }

  public static function login() {
    if (self::$app['cas_settings']['host'] != false && self::$app['cas_settings']['enabled']) {
      return phpCAS::forceAuthentication();
    }
  }


  public static function logout() {
    if (self::$app['cas_settings']['host'] != false && self::$app['cas_settings']['enabled']) {
      return phpCAS::logout();
    }
  }


  public static function isAuthenticated() {
    if (self::$app['cas_settings']['host'] != false && self::$app['cas_settings']['enabled']) {
      return phpCAS::checkAuthentication();
    } else {
      return true;
    }
  }

  public static function requireAuthentiction() {
    if (!self::isAuthenticated()) {
      self::login();
    }
  }


  public static function getUsername() {
    self::requireAuthentiction();
    if (self::$app['cas_settings']['host'] != false && self::$app['cas_settings']['enabled']) {
      return phpCAS::getUser();
    } else {
      return 'develp';
    }
  }

  public static function getUser() {
    if (self::$app['cas_settings']['host'] != false && self::$app['cas_settings']['enabled']) {
      $user = Array();
      $user['id'] = self::getUsername();
      $dbuser = UserQuery::create()->findPK($user['id']);
      if ($dbuser == null) {
        $user['permissions'] = [];
      } else {
        $user['permissions'] = $dbuser->getPermissions();
      }
    } else {
      $user = [
        'id' => 'develp',
        'name' => 'developer',
        'permissions' => []
      ];
    }

    return $user;
  }

  public static function requireLogin($permission, $controller) {
    self::requireAuthentiction();
    $user = self::getUser();

    if (in_array($permission, $user['permissions'])) {
      return $controller($user);
    }

    return new Response("User is not authorized!", 401);
  }
}

CAS::init($app);
