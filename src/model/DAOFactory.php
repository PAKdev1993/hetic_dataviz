<?php

namespace App\model;

use App\model\ContratDAO;
use App\model\EleveDAO;
use App\model\FonctionDAO;
use App\model\FourchetteDAO;
use App\model\GroupeSocioProDAO;
use App\model\SecteurDAO;
use App\model\PeriodeDAO;
use App\model\AssocDataPeriodeDAO;
use App\model\AssocPeriodeEleveDAO;
use App\model\db\PDOconnector as DB;

class DAOFactory 
{
    public function __construct() {

    }

    public static function get($className) {
        switch($className) {
            case 'contrat' :
                return new ContratDAO( DB::getInstance() );
            case 'eleve' :
                return new EleveDAO( DB::getInstance() );
            case 'fonction' :
                return new FonctionDAO( DB::getInstance() );
            case 'fourchette' :
                return new FourchetteDAO( DB::getInstance() ); 
            case 'groupe_socio_pro' :
                return new GroupeSocioProDAO( DB::getInstance() );
            case 'secteur' :
                return new SecteurDAO( DB::getInstance() );
            case 'periode' :
                return new PeriodeDAO( DB::getInstance() );
            case 'assoc_data_periode' :
                return new AssocDataPeriodeDAO( DB::getInstance() );
            default:
                throw new \Exception("La classe $className n'existe pas");
        }
    }
}