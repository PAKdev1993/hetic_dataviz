<?php

namespace src\Dataviz\Entities;

class EntityFactory 
{
    public function __construct() { }

    public static function get($className, $props = null) {
        switch($className) {
            case 'contrat' :
                return new Contrat( $props );
            case 'eleve' :
                return new Eleve( $props );
            case 'fonction' :
                return new Fonction( $props );
            case 'fourchette' :
                return new Fourchette( $props ); 
            case 'groupe_socio_pro' :
                return new GroupeSocioPro( $props );
            case 'secteur' :
                return new Secteur( $props );
            case 'assoc_data_periode' :
                return new AssocDataPeriode( $props );
            default:
                throw new \Exception("la classe $className n'existe pas");
        }
    }
}