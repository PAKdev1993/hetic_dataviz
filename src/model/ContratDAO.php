<?php

namespace src\model;

use src\Entities\Contrat;
use src\model\DAO;

class ContratDAO extends DAO 
{
    const TABLE_NAME = 'contrat';
    const ID_NAME = 'idPeriode';
    const NAME_WORD = "name";

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getCddId() {
        $sql = "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_CONTRAT . 
                " WHERE nom = '". Contrat::WORD_CONTRAT_CDD . "'";
                $sth = $this->db->query($sql);
        return (int) $sth->fetch()->idContrat;                   
    }

    public function getCddContratProId() {
        $sql = "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_CONTRAT . 
                " WHERE nom = '". Contrat::WORD_CONTRAT_CONTRAT_PRO . "'";
                $sth = $this->db->query($sql);
        return (int) $sth->fetch()->idContrat;                
    }

    public function getCdiId() {
        $sql = "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_CONTRAT . 
                " WHERE nom = '". Contrat::WORD_CONTRAT_CDI . "'";
                $sth = $this->db->query($sql);
        return (int) $sth->fetch()->idContrat;                
    }

    public function getContratAutreId() {
        $sql = "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_CONTRAT . 
                " WHERE nom = '". Contrat::WORD_CONTRAT_AUTRE . "'";
                $sth = $this->db->query($sql);
        return (int) $sth->fetch()->idContrat;                
    }

    public function save($contrat){
        //ici vu que les differents type de contrat sont des valeurs enums, 
        //on rempli juste l'id du contrat correspondant a celui de l'objet
        switch($contrat->nom) {
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
        }
    }
}