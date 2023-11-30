<?php

require __DIR__.'/../vendor/autoload.php';
session_start();

const AVAIABLE_ROUTES = [
    'home'=>[
        'controller' => 'PostController',
        'action' => 'renderPost',
    ],
    'contact'=>[
        'controller' => 'ContactController',
        'action' => 'renderContact',
    ],
    'register'=>[
        'controller' => 'UserController',
        'action' => 'renderUser',
    ],
    'login'=>[
        'controller' => 'UserController',
        'action' => 'renderUser',
    ],
    'logout'=>[
        'controller' => 'UserController',
        'action' => 'renderUser',
    ],
    'admin' =>[
        'controller' => 'AdminController',
        'action' => 'renderAdmin',
    ],
];

$page = 'home';
$controller;
$action;

if(isset($_GET['page']) && !empty($_GET['page'])){
    $page = $_GET['page'];
}else{
    $page = 'home';    
}

if(array_key_exists($page, AVAIABLE_ROUTES)){
    $controller = AVAIABLE_ROUTES[$page]['controller'];
    $action = AVAIABLE_ROUTES[$page]['action'];
}

$namespace = 'App\Controllers';
$namespaceController = $namespace.'\\'.$controller;

$pageController = new $namespaceController();
$pageController->setView($page);
$pageController->$action();