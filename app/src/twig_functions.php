<?php

$app['twig']->addFunction(new \Twig_SimpleFunction('asset', function ($asset) {
  $splode = explode('.', $asset);
  $type = end($splode);
  $file = reset($splode);
  
  if ($type === 'js' || $type === 'coffee') {
    echo "<script src=\"/assets/".$type.'/'.$file.'"></script>';
  } else if ($type === 'sass' || $type === 'css') {
    echo '<link rel="stylesheet" href="/assets/'.$type.'/'.$file.'">';
  } else {
    echo '';
  }
}));

$app['twig']->addFunction(new \Twig_SimpleFunction('vendor', function ($asset) {
  $type = end(explode('.', $asset));
  $path = explode('/', $asset);
  array_splice($path, 1, 0, 'dist');
  $path = implode('/', $path);
  
  if ($type === 'js') {
    echo '<script src="/vendor/'.$path.'"></script>';
  } else if ($type === 'css') {
    echo '<link rel="stylesheet" href="/vendor/'.$path.'">';
  } else {
    echo '';
  }
}));