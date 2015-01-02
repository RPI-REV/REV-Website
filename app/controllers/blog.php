<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;

function isBlogAdmin() {
  if (CAS::isAuthenticated()) {
    $user = CAS::getUser();
    return in_array('BLOG_ADMIN', $user['permissions']);
  }

  return false;
}

class newBlogPost {
  public static function get(Application $app) {
    return CAS::requireLogin('BLOG_ADMIN', function($user) use ($app) {
      return $app['twig']->render('create_blog_post.haml');
    });
  }

  public static function post(Application $app) {
    return CAS::requireLogin('BLOG_ADMIN', function($user) use ($app) {
      $post = new BlogPost();
      $post->setTitle($_POST['title']);
      $post->setBody($_POST['body']);
      $post->setTags(explode(',', str_replace(' ', '', $_POST['tags'])));
      $db_user = UserQuery::create()->findPK($user['id']);

      if (!$db_user) {
        return $app->redirect('/blog');
      }

      $post->setUser($db_user);
      $post->save();
      return $app->redirect('/blog');
    });
  }
}

function blog(Application $app) {
  return $app['twig']->render('blog.haml', [
    'blog_posts' => BlogPostQuery::create()
                      ->orderByDate('desc')
                      ->joinWith('BlogPost.User')
                      ->paginate(1, 15),
    'mobile' => $app['mobile_detect']->isMobile(),
    'page' => 1,
    'admin' => isBlogAdmin()
  ]);
}

function blogPage(Application $app, $page) {
  return $app['twig']->render('blog.haml', [
    'blog_posts' => BlogPostQuery::create()
                      ->orderByDate('desc')
                      ->joinWith('BlogPost.User')
                      ->paginate($page, 15),
    'mobile' => $app['mobile_detect']->isMobile(),
    'page' => $page,
    'admin' => isBlogAdmin()
  ]);
}

function blogPost(Application $app, $id) {
  return $app['twig']->render('blog_post.haml', [
    'blog_post' => BlogPostQuery::create()->findPK($id),
    'mobile' => $app['mobile_detect']->isMobile(),
    'admin' => isBlogAdmin()
  ]);
}

function blogTag(Application $app, $tag) {
  return $app['twig']->render('blog.haml', [
    'blog_posts' => BlogPostQuery::create()
    ->filterByTags([$tag])
    ->orderByDate('desc')
    ->joinWith('BlogPost.User')
    ->find(),
    'mobile' => $app['mobile_detect']->isMobile(),
    'page' => 0,
    'admin' => isBlogAdmin()
  ]);
}

function editBlogPost(Application $app) {
  $admin_access = isBlogAdmin();

  if ($admin_access) {
    $post = BlogPostQuery::create()->findPK($_POST['id']);
    $post->setBody($_POST['body']);
    $post->save();
    return new Response('Success!');
  } else {
    return new Response('User not authorized!');
  }
}
