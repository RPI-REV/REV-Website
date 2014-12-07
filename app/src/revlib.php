<?php

class REVLib {
  public static function endsWith($haystack, $needle) {
      return $needle === "" || substr($haystack, -strlen($needle)) === $needle;
  }
}
