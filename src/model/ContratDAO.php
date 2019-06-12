<?php

namespace App\model;

use App\model\DAO;
use App\dataviz\Entities\Entite;
use App\dataviz\datavizs\FilterList;
use App\dataviz\Entities\Contrat;

class ContratDAO extends DAO 
{
    const TABLE_NAME = 'contrat';
    const ID_NAME = 'idContrat';
    const NAME_WORD = "name";

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE ". self::ID_NAME ." = $id";
        $sth = $this->db->query($sql);
        $props = $sth->fetch();
        return new Contrat($props);
    }

    public function getAll(FilterList $filters = null) {}

    public function getCddId() {
        $sql = "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_NAME . 
                " WHERE nom = '". Contrat::WORD_CONTRAT_CDD . "'";
                $sth = $this->db->query($sql);
        return (int) $sth->fetch()['idContrat'];                   
    }

    public function getCddContratProId() {
        $sql = "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_NAME . 
                " WHERE nom = '". Contrat::WORD_CONTRAT_CONTRAT_PRO . "'";
                $sth = $this->db->query($sql);
        return (int) $sth->fetch()['idContrat'];                
    }

    public function getCdiId() {
        $sql = "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_NAME . 
                " WHERE nom = '". Contrat::WORD_CONTRAT_CDI . "'";
                $sth = $this->db->query($sql);
        return (int) $sth->fetch()['idContrat'];                
    }

    public function getContratAutreId() {
        $sql = "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_NAME . 
                " WHERE nom = '". Contrat::WORD_CONTRAT_AUTRE . "'";
                $sth = $this->db->query($sql);
        return (int) $sth->fetch()['idContrat'];                
    }

    public function save(Entite &$contrat){
        //ici vu que les differents type de contrat sont des valeurs enums, 
        //on rempli juste l'id du contrat correspondant a celui de l'objet
        switch($contrat->nom()) {
            case Contrat::WORD_CONTRAT_CDD :
                $contrat->setId($this->getCddId());
                break;
            case Contrat::WORD_CONTRAT_CONTRAT_PRO :
                $contrat->setId($this->getCddContratProId());
                break;
            case Contrat::WORD_CONTRAT_CDI :
                $contrat->setId($this->getCdiId());
                break;
            case Contrat::WORD_CONTRAT_AUTRE :
                $contrat->setId($this->getContratAutreId());
                break;
            case Contrat::WORD_NC :
                $contrat->setId(null);
                break;
            default:
                throw new \Exception('L\'entite "Contrat" porte une valeur "nom" invalide');
        }
    }

    public function delete(Entite $obj) {}
}