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
/*Config::write('db.host', 'localhost');      //mettre valeur perso ici
Config::write('db.basename', 'hetic_dataviz');   //mettre valeur perso ici
Config::write('db.user', 'dataviz');           //mettre valeur perso ici
Config::write('db.pwd', 'dataviz');                //mettre valeur perso ici
Config::write('options', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
]);*/
Config::write('db.host', 'ec2-54-228-252-67.eu-west-1.compute.amazonaws.com');      //mettre valeur perso ici
Config::write('db.basename', 'd9he7gakegn76f');   //mettre valeur perso ici
Config::write('db.user', 'ykvgrxwsmmjwtz');           //mettre valeur perso ici
Config::write('db.pwd', '3dd24e53bd0f71db7630b31145f56cf36213a7b48e602c2bfce1af8ae596ff26');                //mettre valeur perso ici
Config::write('options', [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    //PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
]);