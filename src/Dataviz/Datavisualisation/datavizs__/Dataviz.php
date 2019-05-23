<?php 
    require_once "../db/DB.php";

    abstract class Dataviz {

        protected $db;

        public function __construct(){
            $this->db = DB::getInstance();
        }
    }