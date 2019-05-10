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
Config::write('db.host', 'ec2-79-125-2-142.eu-west-1.compute.amazonaws.com');      //mettre valeur perso ici
Config::write('db.basename', 'd7v42q0lff610j');   //mettre valeur perso ici
Config::write('db.user', 'jytfsfbvfwymqq');           //mettre valeur perso ici
Config::write('db.pwd', 'b3fdcdbc64bc06f20fb090eba957ca7a87fc791bc6937f28deb1c5d70636da5a');                //mettre valeur perso ici
Config::write('options', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
]);