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

class DAOFactory 
{
    public function __construct() {

    }

    public static function get($className) {
        switch($className) {
            case 'contrat' :
                return new ContratDAO( PDO::getInstance() );
            case 'eleve' :
                return new EleveDAO( PDO::getInstance() );
            case 'fonction' :
                return new FonctionDAO( PDO::getInstance() );
            case 'fourchette' :
                return new FourchetteDAO( PDO::getInstance() ); 
            case 'groupe_socio_pro' :
                return new GroupeSocioProDAO( PDO::getInstance() );
            case 'secteur' :
                return new SecteurDAO( PDO::getInstance() );
            case 'periode' :
                return new PeriodeDAO( PDO::getInstance() );
            case 'assoc_data_periode' :
                return new AssocDataPeriodeDAO( PDO::getInstance() );
            case 'assoc_periode_eleve' :
                return new AssocPeriodeEleveDAO( PDO::getInstance() );
        }
    }
}