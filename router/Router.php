<?php

namespace Router;

use src\Controller\ControllerFactory;
use Symfony\Component\Yaml\Yaml;

class Router
{
    /* PATH TO ROUTE CONFIG FILE*/
    const PATH_ROUTES_YAML = "./../config/routes.yaml";
    /* ROUTING ERRORS */
    const ROUTE_NOT_FOUND = 1;
    const HEAD_404 = "HTTP/1.0 404 Not Found";

    public function redirectToRoute($route) {
        return $this->RouteTo($route);
    }

    public function RouteTo($route) {
        //load controller
        $controller = $this->matchRoute($route);

        if($controller === self::ROUTE_NOT_FOUND) {
            header(self::HEAD_404);
            exit();
        }
        else {
            $controllerObj = ControllerFactory::get($controller->controllerName);
            if(method_exists($controllerObj, $controller->methodName)) {
                $methodName = $controller->methodName;
                return call_user_func_array( array($controllerObj, $controller->methodName), array() );
            }
            else{
                header(self::HEAD_404);
                exit(); 
            }
        }
    }

    private function matchRoute($routeName) {
        $found = false;
        $data = Yaml::parseFile(self::PATH_ROUTES_YAML);
        foreach($data as $route) {
            if($route['path'] === $routeName) {
                $controller = new \stdClass();
                $controller->controllerName = $route['controller'];
                $controller->methodName = $route['methode'];
                return $controller;
            }
        }
        return self::ROUTE_NOT_FOUND;
    }
}