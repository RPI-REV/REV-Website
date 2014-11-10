<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

function isBlogAdmin() {
  if (CAS::isAuthenticated()) {
    $user = CAS::getUser();
    return $user['access'] < BLOG_ADMIN;
  }
  
  return false;
}

function blog(Application $app) {
  $admin_access = isBlogAdmin();
  
  if ($admin_access) {
    return $app['twig']->render('blog_admin.haml', [
      'blog_posts' => BlogPostQuery::create()
                        ->orderByDate('desc')
                        ->paginate(1, 15),
      'mobile' => $app['mobile_detect']->isMobile(),
      'page' => 1
    ]);
  } else {
    return $app['twig']->render('blog.haml', [
      'blog_posts' => BlogPostQuery::create()
                        ->orderByDate('desc')
                        ->paginate(1, 15),
      'mobile' => $app['mobile_detect']->isMobile(),
      'page' => 1
    ]);
  }
}

function blogPage(Application $app, $page) {
  $admin_access = isBlogAdmin();
  
  if ($admin_access) {
    return $app['twig']->render('blog_admin.haml', [
      'blog_posts' => BlogPostQuery::create()
                        ->orderByDate('desc')
                        ->paginate($page, 15),
      'mobile' => $app['mobile_detect']->isMobile(),
      'page' => $page
    ]);
  } else {
    return $app['twig']->render('blog.haml', [
      'blog_posts' => BlogPostQuery::create()
                        ->orderByDate('desc')
                        ->paginate($page, 15),
      'mobile' => $app['mobile_detect']->isMobile(),
      'page' => $page
    ]);
  }
}

function blogPost(Application $app, $id) {
  $admin_access = isBlogAdmin();
  
  if ($admin_access) {
    return $app['twig']->render('blog_post_admin.haml', [
      'blog_post' => BlogPostQuery::create()->findPK($id),
      'mobile' => $app['mobile_detect']->isMobile()
    ]);
  } else {
    return $app['twig']->render('blog_post.haml', [
      'blog_post' => BlogPostQuery::create()->findPK($id),
      'mobile' => $app['mobile_detect']->isMobile()
    ]);
  }
}

function newBlogPost(Application $app) {
  $admin_access = isBlogAdmin();
  
  if (!$admin_access) {
    return $app->redirect('/');
  } else {
    $user = CAS::getUser();
    $post = new BlogPost();
    $post->setTitle($_POST['title']);
    $post->setBody($_POST['body']);
    $post->setTags(explode(',', str_replace(' ', '', $_POST['tags'])));
    $post->setName($user['name']);
    $db_user = UserQuery::create()->findPK($user['id']);
    if (!$db_user) {
      return $app->redirect('/sponsors');
    }
    $post->setUser($db_user);    
    $post->save();
    return $app->redirect('/blog');
  }
}

function editBlogPost(Application $app) {
  $admin_access = isBlogAdmin();
  
  if ($admin_access) {
    $post = BlogPostQuery::create()->findPK($_POST['id']);
    $post->setBody($_POST['body']);
    $post->save();
    return new Response('Success!');
  } else {
    return new Respons('User not authorized!');
  }
}

function createBlogPost(Application $app) {
  $admin_access = isBlogAdmin();
  if ($admin_access) {
    return $app['twig']->render('create_blog_post.haml');
  } else {
    return $app->redirect('/blog');
  }
}

function blogTag(Application $app, $tag) {
  $admin_access = isBlogAdmin();
  
  if ($admin_access) {
    return $app['twig']->render('blog_admin.haml', [
      'blog_posts' => BlogPostQuery::create()
                        ->filterByTags([$tag])
                        ->orderByDate('desc')
                        ->find(),
      'mobile' => $app['mobile_detect']->isMobile(),
      'page' => 0
    ]);
  } else {
    return $app['twig']->render('blog.haml', [
      'blog_posts' => BlogPostQuery::create()
                        ->filterByTags([$tag])
                        ->orderByDate('desc')
                        ->find(),
      'mobile' => $app['mobile_detect']->isMobile(),
      'page' => 0
    ]);
  }
}