<?php namespace datavizs;

    require_once "../Autoload.php";

    class Dataviz11 extends Dataviz{

        public function __construct()
        {
            parent::__construct();
        }

        public static function getData()
        {
            var_dump('ok');
        }
    }