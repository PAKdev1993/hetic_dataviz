<?php

class Config
{
    static $confArray;

    public static function read($name)
    {
        return self::$confArray[$name];
    }

    public static function write($name, $value)
    {
        self::$confArray[$name] = $value;
    }

}

// db
Config::write('db.host', 'localhost');      //mettre valeur perso ici
Config::write('db.basename', 'hetic_dataviz');   //mettre valeur perso ici
Config::write('db.user', 'dataviz');           //mettre valeur perso ici
Config::write('db.pwd', 'dataviz');                //mettre valeur perso ici
Config::write('options', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
]);