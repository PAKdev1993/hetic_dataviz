<?php
require_once __DIR__.'/../vendor/autoload.php';

use Router\Router;

$router = new Router();

if(isset($_GET['to'])) {
    $router->RouteTo($_GET['to']);
}
else{
    $router->RouteTo('/');
}