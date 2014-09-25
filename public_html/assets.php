<?php

require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Response;

return function($type, $name, $path="/../app/assets") {
  $sass = new SassParser([
    'style' => 'compressed',
    'cache_location' => __DIR__.'/../app/assets/cache/sass/',
    'load_paths' => [__DIR__.'/../app/assets/sass']
  ]);
  
  $file = file_get_contents(__DIR__.$path.'/'.$type.'/'.$name.'.'.$type);
  if ($file === false) {
    return new Response('Asset not found: '.$name.'.'.$type, 404);
  }
  
  try {
    switch ($type) {
      case 'coffee':
        return new Response(\JShrink\Minifier::minify(CoffeeScript\Compiler::compile($file, ['filename' => $name.'.'.$type])), 200, [
          'Content-Type' => 'application/javascript'  
        ]);
        
      case 'js':
        return new Response(\JShrink\Minifier::minify($file), 200, [
          'Content-Type' => 'application/javascript'
        ]);
          
      case 'sass':
        return new Response($sass->toCss($file), 200, [
          'Content-Type' => 'text/css'  
        ]);
      
      case 'css':
        return new Response(\CssMin::minify($file), 200, [
          'Content-Type' => 'text/css'
        ]);
        
      default:
        return new Response('Content type not found: '.$type, 404);
    }
  } catch (Exception $e) {
    return new Response('Error parsing '.$name.'.'.$type, 500);
  }
};