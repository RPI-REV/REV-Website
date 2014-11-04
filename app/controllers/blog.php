<?php

use Silex\Application;

function blog(Application $app) {
  $admin_access = false;
  if (CAS::isAuthenticated()) {
    $user = CAS::getUser();
    if ($user['access'] < BLOG_ADMIN) {
      $admin_access = true;
    }    
  }
  
  if ($admin_access) {
    return $app['twig']->render('blog_admin.haml', [
      'blog_posts' => BlogPostQuery::create()->find(),
      'mobile' => $app['mobile_detect']->isMobile(),
      'user' => $user
    ]);
  } else {
    return $app['twig']->render('blog.haml', [
      'blog_posts' => BlogPostQuery::create()->find(),
      'mobile' => $app['mobile_detect']->isMobile()
    ]);
  }
}

function newBlogPost(Application $app) {
  $admin_access = false;
  if (CAS::isAuthenticated()) {
    $user = CAS::getUser();
    if ($user['access'] < BLOG_ADMIN) {
      $admin_access = true;
    }    
  }
  
  if (!$admin_access) {
    return $app->redirect('/blog');
  } else {
    $post = new BlogPost();
    $post->setTitle($_POST['title']);
    $post->setBody($_POST['body']);
    $db_user = UserQuery::create()->findPK($user['id']);
    if (!$db_user) {
      return $app->redirect('/blog');
    }
    $post->setUser($db_user);    
    $post->save();
    return $app->redirect('/blog');
  }
}