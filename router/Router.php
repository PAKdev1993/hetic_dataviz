<?php

namespace Route;

use src\Controller\ControllerFactory;

class Router
{
    const PATH_ROUTES_YAML = "./Config/routes.yaml";
    const ROUTE_NOT_FOUND = 1;

    const HEAD_404 = "HTTP/1.0 404 Not Found";

    public function redirectToRoute($route) {
        return $this->RouteTo($route);
    }

    public function RouteTo($route) {
        if(count($route) > 1){
            header(self::HEAD_404);
            exit();
        }
        //load controller
        $result = $this->matchRoute($route);

        if($result === self::ROUTE_NOT_FOUND) {
            header(self::HEAD_404);
            exit();
        }
        else {
            $controllerObj = ControllerFactory::get($result->controllerName);
            if(method_exists($controllerObj, $result->methodName)) {
                return call_user_func_array(array($controllerObj, $result->methodName));
            }
            else{
                header(self::HEAD_404);
                exit(); 
            }
        }
    }

    private function matchRoute($routeName) : string {
        $found = false;
        $data = yaml_parse($yaml, 0);
        foreach($data as $route) {
            if($route === $routeName) {
                $controller = new \stdClass();
                $controller->controllerName = $route['controller'];
                $controller->methodName = $route['methode'];
                return $controller;
            }
        }
        return self::ROUTE_NOT_FOUND;
    }
}