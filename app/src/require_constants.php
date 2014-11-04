<?php

$constants = json_decode(file_get_contents(__DIR__.'/../config/constants.json'), true);

foreach($constants as $key => $value) {
  define($key, $value);
}