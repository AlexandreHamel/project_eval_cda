<?php

// require __DIR__.'/../app/Controllers/MainController.php';
// require __DIR__.'/../app/Controllers/PostController.php';
// require __DIR__.'/../app/Controllers/ContactController.php';
// require __DIR__.'/../app/Controllers/UserController.php';

require __DIR__.'/../vendor/autoload.php';

const AVAIABLE_ROUTES = [
    'home'=>[
        'controller' => 'PostController',
        'action' => 'renderPost',
    ],
    'contact'=>[
        'controller' => 'ContactController',
        'action' => 'renderContact',
    ],
    'login'=>[
        'controller' => 'UserController',
        'action' => 'renderUser',
    ],
    'logout'=>[
        'controller' => 'UserController',
        'action' => 'renderUser',
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