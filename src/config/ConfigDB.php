<?php

namespace App\config;

class ConfigDB
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
ConfigDB::write('db.host', 'localhost');      //mettre valeur perso ici
ConfigDB::write('db.basename', 'pak_dataviz');   //mettre valeur perso ici
ConfigDB::write('db.user', 'dataviz');           //mettre valeur perso ici
ConfigDB::write('db.pwd', 'dataviz');                //mettre valeur perso ici
ConfigDB::write('options', [
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
]);