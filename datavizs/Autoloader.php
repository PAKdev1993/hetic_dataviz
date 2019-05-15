<?php

class Autoloader{

    static function register()
    {
        spl_autoload_register(array(__CLASS__,'autoload'));
    }

    static function autoload($class)
    {
        var_dump($class . 'php');
        require_once($class . '.php');
    }
}