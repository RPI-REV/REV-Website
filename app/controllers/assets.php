<?php

require_once __DIR__.'/../../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;

function coffee_cache($file, $filename) {
  $dir = __DIR__.'/../assets/cache/coffee/';

  $hash = hash('md5', $file);
  $cached_file = @file_get_contents($dir.$hash);
  if ($cached_file !== false) return $cached_file;

  $compiled = \JShrink\Minifier::minify(CoffeeScript\Compiler::compile($file, ['filename' => $filename]));
  @file_put_contents($dir.$hash, $compiled);

  return $compiled;
}

function js_cache($file) {
  $dir = __DIR__.'/../assets/cache/js/';

  $hash = hash('md5', $file);
  $cached_file = @file_get_contents($dir.$hash);
  if ($cached_file !== false) return $cached_file;

  $compiled = \JShrink\Minifier::minify($file);
  @file_put_contents($dir.$hash, $compiled);

  return $compiled;
}

function sass_cache($file) {
  $sass = new SassParser([
    'style' => 'compressed',
    'load_paths' => [__DIR__.'/../assets/sass'],
    'cache' => false
  ]);
  
  $dir = __DIR__.'/../assets/cache/sass/';

  $hash = hash('md5', $file);
  $cached_file = @file_get_contents($dir.$hash);
  if ($cached_file !== false) return $cached_file;

  $compiled = $sass->toCss($file);
  @file_put_contents($dir.$hash, $compiled);

  return $compiled;
}


function css_cache($file) {
  $dir = __DIR__.'/../assets/cache/css/';

  $hash = hash('md5', $file);
  $cached_file = @file_get_contents($dir.$hash);
  if ($cached_file !== false) return $cached_file;

  $compiled = \CssMin::minify($file);
  @file_put_contents($dir.$hash, $compiled);

  return $compiled;
}


function assets($type, $name, $path="/../assets") {
  $file = file_get_contents(__DIR__.$path.'/'.$type.'/'.$name.'.'.$type);
  if ($file === false) {
    return new Response('Asset not found: '.$name.'.'.$type, 404);
  }
  
  try {
    switch ($type) {
      case 'coffee':
        return new Response(coffee_cache($file, $name.'.'.$type), 200, [
          'Content-Type' => 'application/javascript'
        ]);
        
      case 'js':
        return new Response(js_cache($file), 200, [
          'Content-Type' => 'application/javascript'
        ]);
          
      case 'sass':
        return new Response(sass_cache($file), 200, [
          'Content-Type' => 'text/css'  
        ]);
      
      case 'css':
        return new Response(css_cache($file), 200, [
          'Content-Type' => 'text/css'
        ]);
        
      default:
        return new Response('Content type not found: '.$type, 404);
    }
  } catch (Exception $e) {
    return new Response('Error parsing '.$name.'.'.$type, 500);
  }
};
