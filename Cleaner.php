<?php
require "iClean.php";
require_once "./data/ConfigData.php";

use \PhpOffice\PhpSpreadsheet\Shared\Date;

class Cleaner implements CleanerInterface {

    public function __construct()
    {

    }

    public function cleanProps(Eleve &$eleveObj)
    {
        foreach($eleveObj->getAllProperties() as $name => $value)
        {
            switch($name){
                case "promo" : {
                    if(strpos( strtolower($value), 'mark' ) !== false)
                    {
                        $eleveObj->{$name} = ConfigData::WORD_PROMO_WEB_MARKETING;
                    }
                    else{
                        $eleveObj->{$name} = ConfigData::WORD_PROMO_WEB;
                    }
                    break;
                }
                case "civilite" : {
                    if(strpos( $value, 'Mm' ) !== false)
                    {
                        $eleveObj->{$name} = ConfigData::HOMME_ACRONYME;
                    }
                    else{
                        $eleveObj->{$name} = ConfigData::FEMME_ACRONYME;
                    }
                    break;
                }
                case "date_sortie_hetic" : {
                    $eleveObj->{$name} = (int) date("Y", Date::excelToTimestamp($value));
                    break;
                }
                case "code_postal_residence" : {
                    $eleveObj->{$name} = utf8_encode($value);
                    break;
                }
                case"ville" : {
                    $eleveObj->{$name} = utf8_encode(ucfirst(strtolower($value)));
                    break;
                }
                case "pays" : {
                    $eleveObj->{$name} = utf8_encode($value);
                    break;
                }
                case "annee_promo" : {
                    $eleveObj->{$name} = (int) $value;
                    break;
                }
                case "etudes_avant_hetic" : {
                    if(strlen($value) <= 2)
                    {
                        $eleveObj->{$name} = ConfigData::WORD_NC;
                        break;
                    }
                    if(strpos( $value, '?' ) !== false)
                    {
                        $eleveObj->{$name} = ConfigData::WORD_NC;
                        break;
                    }
                    $eleveObj->{$name} = (string) trim(substr($value, 0, ConfigData::LENGTH_ETUDE_AVNT_H));
                    break;
                }
                case "situation_pro_sortie_hetic" : {
                    $eleveObj->{$name} = trim($value);
                    break;
                }
                case "jobs_notables_exerces" : {
                    $eleveObj->{$name} = $this->clean_jobs_notables_exerces($value);
                    break;
                }        
                case "props_periode_6_mois__groupe_socio_pro" : {
                    if(strpos( $value, "Emp" ) !== false){
                        $eleveObj->{$name} = ConfigData::WORD_GR_EMPLOYE; 
                        break;
                    }
                    if(strpos( $value, "Ind" ) !== false){
                        $eleveObj->{$name} = ConfigData::WORD_GR_INDEPENDANT; 
                        break;
                    }
                    if(strpos( $value, "Ca" ) !== false){
                        $eleveObj->{$name} = ConfigData::WORD_GR_CADRE; 
                        break;
                    }
                    if(strpos( $value, "Dir" ) !== false){
                        $eleveObj->{$name} = ConfigData::WORD_GR_PATRON; 
                        break;
                    }
                    //#TODO ici il n'y a pas le cas "Poursuite d'étude" car inutile ds ce champ
                    $eleveObj->{$name} = ConfigData::WORD_NC; 
                    break;
                }
                case "props_periode_6_mois__fonction" : {
                    $eleveObj->{$name} = $this->clean_props_periode_6_mois__fonction($value);
                    break;
                }
                case "props_periode_6_mois__contrat" : {
                    $eleveObj->{$name} = $this->clean_props_periode_6_mois__contrat($value);
                    break;
                }
                case "props_periode_6_mois__secteur" : {
                    $eleveObj->{$name} = $value == '' ? ConfigData::WORD_NC : utf8_encode(trim(ucfirst(strtolower($value))));
                    break;
                }
                case "props_periode_6_mois__fourchette_salaire" : {
                    $eleveObj->{$name} = $this->clean_props_periode_6_mois__fourchette_salaire($value);
                    break;
                }
                case "props_periode_actuelle__groupe_socio_pro" : {
                    if(strpos( $value, "Emp" ) !== false){
                        $eleveObj->{$name} = ConfigData::WORD_GR_EMPLOYE; 
                        break;
                    }
                    if(strpos( $value, "Ind" ) !== false){
                        $eleveObj->{$name} = ConfigData::WORD_GR_INDEPENDANT; 
                        break;
                    }
                    if(strpos( $value, "Ca" ) !== false){
                        $eleveObj->{$name} = ConfigData::WORD_GR_CADRE; 
                        break;
                    }
                    if(strpos( $value, "Dir" ) !== false){
                        $eleveObj->{$name} = ConfigData::WORD_GR_PATRON; 
                        break;
                    }
                    //#TODO ici il n'y a pas le cas "Poursuite d'étude" car inutile ds ce champ
                    $eleveObj->{$name} = ConfigData::WORD_NC; 
                    break;
                }
                case "props_periode_actuelle__fonction" : {
                    $eleveObj->{$name} = $this->clean_props_periode_6_mois__fonction($value);
                    break;      
                }
                case "props_periode_actuelle__contrat" : {
                    $eleveObj->{$name} = $this->clean_props_periode_6_mois__contrat($value);
                    break;
                }
                case "props_periode_actuelle__secteur" : {
                    $eleveObj->{$name} = $value == '' ? ConfigData::WORD_NC : utf8_encode(trim(ucfirst(strtolower($value))));
                    break;
                }
                case "props_periode_actuelle__fourchette_salaire" : {
                    $eleveObj->{$name} = $this->clean_props_periode_6_mois__fourchette_salaire($value);
                    break;
                }
                default :
                    break;
            }
        }
    }

    private function clean_jobs_notables_exerces($value)
    {
        switch ($index = 0){
            case 0 : 
                $tmp = explode('(', $value);
                if(count($tmp) > 1)
                {
                    $job = trim(substr($tmp[0], 0, ConfigData::LENGTH_JOB_NOTABLES_EXERCES));
                    $duree = $tmp[1];
                    break;
                }
            case 1 :
                $tmp = explode('/', $value);
                if(count($tmp) > 1)
                {
                    $job = trim(substr($tmp[0], 0, ConfigData::LENGTH_JOB_NOTABLES_EXERCES));
                    $duree = $tmp[1];
                    break;
                }
            case 2 :
                if(strlen($value) <= 3)
                {
                    $job = ConfigData::WORD_NC;
                    break;
                }
            default :
                $job = trim(substr($value, 0, ConfigData::LENGTH_JOB_NOTABLES_EXERCES));
        }

        return $job;
    }

    private function clean_props_periode_6_mois__contrat($value)
    {       
            if($value == '') return ConfigData::WORD_NC;
            if(strpos( $value, "NC" ) !== false) return ConfigData::WORD_NC;
            if(strpos( strtolower($value), "CDD contrat pro" ) !== false) return ConfigData::WORD_CONTRAT_CONTRAT_PRO;
            if(strpos( strtolower($value), "CDD" ) !== false) return ConfigData::WORD_CONTRAT_CDD;
            if(strpos( strtolower($value), "CDI" ) !== false) return ConfigData::WORD_CONTRAT_CDI;
            return ConfigData::WORD_NC;
    }

    private function clean_props_periode_6_mois__fonction($value)
    {
            if($value == '') return ConfigData::WORD_NC;
            if(strpos( $value, "NC" ) !== false) return ConfigData::WORD_NC;
            if(strpos( strtolower($value), "poursuite" ) !== false) return ConfigData::WORD_FONCTION_POURSUITE_ETUDE;
            if(strpos( strtolower($value), "emploi" ) !== false) return ConfigData::WORD_FONCTION_RECH_EMPLOI;
            return utf8_encode(trim(ucfirst(strtolower($value))));
    }    
    
    private function clean_props_periode_6_mois__fourchette_salaire($value)
    {
        if(strpos( $value, "NC" ) !== false) return ConfigData::WORD_NC;
        if(strpos( strtolower($value), "poursuite" ) !== false) return ConfigData::WORD_NC;
        if(strpos( strtolower($value), "emploi" ) !== false) return ConfigData::WORD_NC;
        //cas de : "moins de X €"
        if(strpos( strtolower($value), "moins de" ) !== false)
        {
            $tmp = trim(str_replace("moins de", "", $value)); // recup "X €"
            $tmp_chiffre_salaire = substr($tmp, 0, 6); //on extrait les 6 premiers caractères qui représente la fourchette
            $chiffre_salaire = str_replace(" ", "", $tmp_chiffre_salaire);
            return "0," . $chiffre_salaire;
        }
        //cas de : "plus de X €"
        if(strpos( strtolower($value), "plus de" ) !== false)
        {
            $tmp = trim(str_replace("plus de", "", $value)); // recup "X €"
            $tmp_chiffre_salaire = substr($tmp, 0, 6); //on extrait les 6 premiers caractères qui représente la fourchette
            $chiffre_salaire = str_replace(" ", "", $tmp_chiffre_salaire);
            return $chiffre_salaire . ',+';
        }

        //cas de : 'de 32 000 € à 34 999 €'
        if($value !== null)
        {
            $tmp = trim(str_replace("de", "", $value)); // recup "32 000 € à 34 999 €"
            $chiffre_bas = trim(str_replace(" ", "",substr($tmp, 0, 6))); //on extrait les 6 premiers caractères qui représente la fourchette basse
            $chiffre_haut = trim(str_replace(" ", "",substr($tmp, 13, 7))); //on extrait les caractères 13 à 20 qui représente la fourchette haute
            return $chiffre_bas . "," . $chiffre_haut;
        }
    }
}