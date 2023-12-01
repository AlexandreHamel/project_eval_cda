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
    'add' =>[
        'controller' => 'AdminController',
        'action' => 'renderAdmin',
    ],
    'adminUser' =>[
        'controller' => 'AdminController',
        'action' => 'renderAdmin',
    ],
    'adminContact' =>[
        'controller' => 'AdminController',
        'action' => 'renderAdmin',
    ],
];

$page = 'home';
$controller;
$action;
$subPage=null;

if(isset($_GET['page']) && !empty($_GET['page'])){
    $page = $_GET['page'];

    if(!empty($_GET['subpage'])){
        $subPage = $_GET['subpage'];
    }

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
$pageController->setSubPage($subPage);
$pageController->$action();