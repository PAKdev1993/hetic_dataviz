<?php
    require_once "Autoloader.php";

    class DatavizFactory {

        public static function get($num){
            Autoloader::register();

            switch($num) {
                case '1.1' :
                    return new Dataviz11();
            }
        }
    }