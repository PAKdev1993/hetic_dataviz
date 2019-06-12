<?php

namespace App\dataviz\datavizs;

use App\dataviz\datavizs\Dataviz11;
use App\dataviz\datavizs\Dataviz12;
use App\dataviz\datavizs\FiltersList;

use App\model\db\PDOconnector as DB;

class DatavizFactory
{
    public static function get($num, FiltersList $filters = null){
        switch($num) {
            case '1.1' :
                return new Dataviz11( DB::getInstance(), $filters );
            case '1.2' :
                return new Dataviz12( DB::getInstance(), $filters );
            case '1.3' :
                return new Dataviz13( DB::getInstance(), $filters );
            case '2.1' :
                return new Dataviz21( DB::getInstance(), $filters );
            case '3.1' :
                return new Dataviz31( DB::getInstance(), $filters );
            case '3.1.1' :
                return new Dataviz311( DB::getInstance(), $filters );
            case '3.1.2' :
                return new Dataviz312( DB::getInstance(), $filters );
            case '3.1.3' :
                return new Dataviz313( DB::getInstance(), $filters );
            case '3.2' :
                return new Dataviz32( DB::getInstance(), $filters );
            case '3.4' :
                return new Dataviz34( DB::getInstance(), $filters );
            case '4.1' :
                return new Dataviz41( DB::getInstance(), $filters );
            case '4.2' :
                return new Dataviz42( DB::getInstance(), $filters );
            case '4.3' :
                return new Dataviz43( DB::getInstance(), $filters );
            case '4.4' :
                return new Dataviz44( DB::getInstance(), $filters );
            default :
                throw new Exception("Cette dataviz n'existe pas"); 
        }
    }
}