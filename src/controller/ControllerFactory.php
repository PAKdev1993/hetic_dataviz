<?php

namespace App\controller;

use App\controller\InsertionController;
use App\controller\IndexController;
use App\controller\DatavizController;

class ControllerFactory
{
    public static function get($className) {
        switch($className) {
            case 'index' :
                return new IndexController();
            case 'insertion' :
                return new InsertionController();
            case 'dataviz' :
                return new DatavizController();
            default:
                return false;
        }
    }
}