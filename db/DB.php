<?php 
require "Config.php";

class DB{

    private static $instance;

    private function __construct()
    {
        
    }

    //Singleton pattern
    public static function getInstance(){
        if (!isset(self::$instance))
        {
            $dsn =  'mysql:host=' . Config::read('db.host') .
                    ';dbname='    . Config::read('db.basename') .
                    ';charset=utf8';         // building data source name 
            $user =     Config::read('db.user'); // getting DB user from config
            $pwd =      Config::read('db.pwd');   // getting DB password from config                
            $options =  Config::read('options'); // getting options
            try{
                self::$instance = new PDO($dsn, $user, $pwd, $options); // geting PDO object
                return self::$instance;
            }
            catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return self::$instance;
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}