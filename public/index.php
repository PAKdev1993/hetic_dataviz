<?php
require_once('./Autoloader.php');
$router = new Router();

$routeInfos = explode('/', $_SERVER['REQUEST_URI']);

$router->RouteTo($routeInfos[0]);