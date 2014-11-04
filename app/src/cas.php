<?php

use Silex\Appliction;
use Symfony\Component\HttpFoundation\Response;

class CAS {
  public static $app;
  
  public static function init(&$app) {
    self::$app = $app;
    if ($app['cas_settings']['host'] != false) {
      phpCAS::client(CAS_VERSION_2_0, self::$app['cas_settings']['host'], self::$app['cas_settings']['port'], self::$app['cas_settings']['method']);
      phpCAS::setNoCasServerValidation();
    }
  }
  
  public static function login() {
    if (self::$app['cas_settings']['host'] != false) {
      return phpCAS::forceAuthentication();
    }
  }
  
  
  public static function logout() {
    if (self::$app['cas_settings']['host'] != false) {
      return phpCAS::logout();
    }
  }
  
  
  public static function isAuthenticated() {
    if (self::$app['cas_settings']['host'] != false) {
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
    if (self::$app['cas_settings']['host'] != false) {
      return phpCAS::getUser();
    } else {
      return 'develp';
    }
  }
  
  public static function getUser() {
    if (self::$app['club_api_key'] != false && self::$app['cas_settings']['host'] != false) {
      $username = self::getUsername();
      $user = json_decode(file_get_contents('http://api.union.rpi.edu/query.php?task=GetUser&rcsid='.$username.'&apikey='.self::$app['club_api_key']), true)['result'];
      $user['id'] = $username;
      $dbuser = UserQuery::create()->findPK($username);
      if ($dbuser == null) {
        $user['access'] = 10;
      } else {
        $user['access'] = $dbuser->getAccess();
      }
    } else {
      $user = [
        'id' => 'develp',
        'name' => 'developer',
        'rin' => 666666666,
        'phone' => '',
        'class' => 'JR',
        'access' => 0
      ];
    }
    
    return $user;
  }
  
  public static function requireLogin($access, $controller) {
    self::requireAuthentiction();
    $user = self::getUser();
    
    if ($user['access'] > $access) {
      return new Response("User is not authorized!", 401);
    }
    
    return $controller($user);
  }
}

CAS::init($app);