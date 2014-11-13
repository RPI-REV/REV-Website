<?php

$app['twig']->addFunction(new \Twig_SimpleFunction('asset', function ($asset, $height=0, $width=0) use ($app) {
  $splode = explode('.', $asset);
  $type = end($splode);
  $file = reset($splode);
  
  if ($type === 'js' || $type === 'coffee') {
    echo '<script src="/assets/'.$type.'/'.$file.'"></script>';
  } else if ($type === 'sass' || $type === 'css') {
    echo '<link rel="stylesheet" href="/assets/'.$type.'/'.$file.'">';
  } else if ($type === 'jpg' || $type === 'png') {
    if ($app['cache_settings']['image_cache']) {
      echo '<img src="/assets/'.$type.'/'.$file.'?height='.$height.'&width='.$width.'" alt="Image"/>';
    } else {
      echo '<img src="/assets/'.$type.'/'.$file.'" height='.($height == 0 ? '' : $height).'" width="'.($width == 0 ? '' : $width).'" alt="Image"/>';      
    }
  } else {
    echo '';
  }
}));

$app['twig']->addFunction(new \Twig_SimpleFunction('vendor', function ($asset) {
  $type = end(explode('.', $asset));
  
  if ($type === 'js') {
    echo '<script src="/vendor/'.$asset.'"></script>';
  } else if ($type === 'css') {
    echo '<link rel="stylesheet" href="/vendor/'.$asset.'">';
  } else {
    echo '';
  }
}));