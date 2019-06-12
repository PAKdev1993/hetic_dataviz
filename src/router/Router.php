<?php

namespace App\router;

use App\controller\ControllerFactory;
use Symfony\Component\Yaml\Yaml;

class Router
{
    /* PATH TO ROUTE CONFIG FILE*/
    private const PATH_ROUTES_YAML = __DIR__ . "/../config/routes.yaml";
    /* ROUTING ERRORS */
    private const ROUTE_NOT_FOUND = 1;

    public function redirectToRoute($route) {
        return $this->RouteTo($route);
    }

    public static function RouteTo( $args = null) {
        //load controller
        $controller = self::matchRoute($args['to']);

        if($controller === self::ROUTE_NOT_FOUND) {
            header($_SERVER["SERVER_PROTOCOL"] . "404 Not Found");
            exit();
        }
        else {
            $controllerObj = ControllerFactory::get($controller->controllerName);
            if(method_exists($controllerObj, $controller->methodName)) {
                $methodName = $controller->methodName;
                return call_user_func_array( array($controllerObj, $controller->methodName), array( $args ) );
            }
            else{
                header($_SERVER["SERVER_PROTOCOL"] . "404 Not Found");
                exit(); 
            }
        }
    }

    private static function matchRoute($routeName) {
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