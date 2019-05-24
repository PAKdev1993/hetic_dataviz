<?php

namespace src\Controller;

use src\Controller\InsertionController;

class ControllerFactory
{
    public static function get($className) {
        switch($className) {
            case 'index' :
                return new IndexController();
            case 'insertion' :
                return new InsertionController();
        }
    }
}