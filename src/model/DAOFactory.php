<?php

namespace src\model;

use src\model\ContratDAO;
use src\model\EleveDAO;
use src\model\FonctionDAO;
use src\model\FourchetteDAO;
use src\model\GroupeSocioProDAO;
use src\model\SecteurDAO;
use src\model\PeriodeDAO;
use src\model\AssocDataPeriodeDAO;
use src\model\AssocPeriodeEleveDAO;
use src\model\db\PDOconnector as DB;

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