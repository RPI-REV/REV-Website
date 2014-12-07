<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Intervention\Image\ImageManagerStatic as Image;

function coffee_cache($file, $filename) {
  $dir = __DIR__.'/../assets/cache/coffee/';

  $hash = hash('md5', $file);
  $cached_file = @file_get_contents($dir.$hash);
  if ($cached_file !== false) return $cached_file;

  $compiled = JShrink\Minifier::minify(CoffeeScript\Compiler::compile($file, ['filename' => $filename]));
  @file_put_contents($dir.$hash, $compiled);

  return $compiled;
}

function js_cache($file) {
  $dir = __DIR__.'/../assets/cache/js/';

  $hash = hash('md5', $file);
  $cached_file = @file_get_contents($dir.$hash);
  if ($cached_file !== false) return $cached_file;

  $compiled = JShrink\Minifier::minify($file);
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

  $compiled = CssMin::minify($file);
  @file_put_contents($dir.$hash, $compiled);

  return $compiled;
}

function image_cache($type, $name, $path) {
  $file = __DIR__.$path.'/'.'/image/'.$name.'.'.$type;
  
  if (!file_exists($file)) {
    return new Response('Asset not found: '.$name.'.'.$type, 404);
  }
  
  if ($type == 'png') {
    $mimetype = 'image/png';
  } else if ($type == 'jpg' || $type == 'jpeg') {
    $mimetype = 'image/jpeg';
  } else {
    return new Response('Type not found: '.$type, 404);
  }
  
  $height = isset($_GET['height']) ? $_GET['height'] : false;
  $width = isset($_GET['width']) ? $_GET['width'] : false;
  
  if ((!$height) && (!$width)) {
    return new Response(file_get_contents($file), 200, array('Content-Type' => $mimetype));  
  }
  
  $cached_file = __DIR__.'/../assets/cache/image/'.hash('md5', $name.$height.$type.$width);

  if (file_exists($cached_file)) {
    return new Response(file_get_contents($cached_file), 200, array('Content-Type' => 'image/png')); 
  }
  
  $img = Image::make($file);
  
  if ($height && !$width) {
    $img->heighten($height)->save($cached_file);
  } else if (!$heighten && $width) {
    $img->widen($width)->save($cached_file);
  } else {
    $img->resize($width, $height)->save($cached_file);
  }
  
  return new Response(file_get_contents($cached_file), 200, array('Content-Type' => $mimetype)); 
}


function assets($type, $name, $path="/../assets") {
  if ($type == 'jpg' || $type == 'png' || $type == 'jpeg') {
    return image_cache($type, $name, $path);
  } else {
    $file_type = $type;
    $file = @file_get_contents(__DIR__.$path.'/'.$type.'/'.$name.'.'.$type);
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
  }
}

