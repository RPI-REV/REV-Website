<?php

foreach (scandir(__DIR__.'/../controllers/') as $controller) {
  if (REVLib\endsWith($controller, '.php')) {
    require_once __DIR__.'/../controllers/'.$controller;
  }
}