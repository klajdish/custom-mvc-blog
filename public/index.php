<?php
require_once __DIR__.'/../vendor/autoload.php';

use App\Controllers\UserController;
use App\Controllers\PostController;
use App\Controllers\CategoryController;
use App\Controllers\CommentController;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\CreatorMiddleware;
use App\Middlewares\AdminMiddleware;
use Core\Container;
use Core\Request;
use Core\Response;
use Core\Router;
use Core\Session;
use Core\View;



$container = new Container;
 app()->singleton(Response::class, Response::class);
 app()->singleton( Request::class, Request::class);
 app()->singleton('view', View::class);
 app()->singleton('router', Router::class);
 app()->singleton('session', Session::class);


$router = $container->get('router');
$response =  app()->get(Response::class);

$router->get('/',[UserController::class, 'home']);
$router->get('/login',[UserController::class, 'loginGet',AuthMiddleware::class]);
$router->post('/login',[UserController::class, 'loginPost']);
$router->get('/register',[UserController::class, 'registerGet',AuthMiddleware::class]);
$router->post('/register',[UserController::class, 'registerPost']);
$router->get('/logout',[UserController::class, 'logout']);
$router->get('/article',[PostController::class, 'article']);
$router->post('/article',[CommentController::class, 'create']);
$router->get('/category',[CategoryController::class, 'category']);


$router->get('/admin',[UserController::class, 'admin',CreatorMiddleware::class]);
    $router->get('/admin/users',[UserController::class, 'users',AdminMiddleware::class]);
        $router->get('/admin/add',[UserController::class, 'add',AdminMiddleware::class]);
        $router->post('/admin/add',[UserController::class, 'create',AdminMiddleware::class]);
        $router->get('/admin/update',[UserController::class, 'edit',AdminMiddleware::class]);
        $router->post('/admin/update',[UserController::class, 'update',AdminMiddleware::class]);
        $router->get('/admin/delete',[UserController::class, 'delete',AdminMiddleware::class]);


    $router->get('/admin/posts',[PostController::class, 'posts',CreatorMiddleware::class]);
        $router->get('/admin/post/update',[PostController::class, 'edit',CreatorMiddleware::class]);
        $router->post('/admin/post/update',[PostController::class, 'update',CreatorMiddleware::class]);
        $router->get('/admin/post/delete',[PostController::class, 'delete',CreatorMiddleware::class]);
        $router->get('/admin/post/add',[PostController::class, 'add',CreatorMiddleware::class]);
        $router->post('/admin/post/add',[PostController::class, 'create',CreatorMiddleware::class]);

    $router->get('/admin/categories',[CategoryController::class, 'categories',AdminMiddleware::class]);
        $router->get('/admin/category/update',[CategoryController::class, 'edit',AdminMiddleware::class]);
        $router->post('/admin/category/update',[CategoryController::class, 'update',AdminMiddleware::class]);
        $router->get('/admin/category/delete',[CategoryController::class, 'delete',AdminMiddleware::class]);
        $router->get('/admin/category/add',[CategoryController::class, 'add',AdminMiddleware::class]);
        $router->post('/admin/category/add',[CategoryController::class, 'create',AdminMiddleware::class]);

    $router->get('/admin/comments',[CommentController::class, 'comments',CreatorMiddleware::class]);
        $router->get('/admin/comment/update',[CommentController::class, 'edit',CreatorMiddleware::class]);
        $router->post('/admin/comment/update',[CommentController::class, 'update',CreatorMiddleware::class]);
        $router->get('/admin/comment/delete',[CommentController::class, 'delete',CreatorMiddleware::class]);
    

$router->run();
$response->send();