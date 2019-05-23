<?php

namespace src\model;

use src\Dataviz\Entities\GroupeSocioPro;

class GroupeSocioProDAO extends DAO 
{
    const TABLE_NAME = 'groupe_socio_pro';
    const ID_NAME = 'idGroupe';
    const NAME_WORD = "name";

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getGrEmployeId() {
        $sql =  "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_NAME . 
                " WHERE ". self::NAME_WORD ." = '". GroupeSocioPro::WORD_GR_EMPLOYE . "'";
        $sth = $this->db->query($sql);
        return (int) $sth->fetch()->idGroupe;                                
    }

    public function getGrIndeId() {
        $sql =  "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_NAME . 
                " WHERE ". self::NAME_WORD ." = '". GroupeSocioPro::WORD_GR_INDEPENDANT . "'";
        $sth = $this->db->query($sql);
        return (int) $sth->fetch()->idGroupe;                                                
    }

    public function getGrCadreId() {
        $sql =  "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_NAME . 
                " WHERE ". self::NAME_WORD ." = '". GroupeSocioPro::WORD_GR_CADRE . "'";
        $sth = $this->db->query($sql);
        return (int) $sth->fetch()->idGroupe;                  
    }

    public function getGrDirId() {
        $sql =  "SELECT ". self::ID_NAME .
                " FROM " . self::TABLE_NAME . 
                " WHERE ". self::NAME_WORD ." = '". GroupeSocioPro::WORD_GR_PATRON . "'";
        $sth = $this->db->query($sql);
        return (int) $sth->fetch()->idGroupe;                     
    }

    public function save(GroupeSocioPro $groupSocPro){
        //ici vu que les differents type de contrat sont des valeurs enums, 
        //on rempli juste l'id du contrat correspondant a celui de l'objet
        switch($groupSocPro->nom) {
            case GroupeSocioPro::WORD_GR_EMPLOYE :
                $contrat->setId($this->getGrEmployeId());
                break;
            case GroupeSocioPro::WORD_GR_INDEPENDANT :
                $contrat->setId($this->getGrIndeId());
                break;
            case GroupeSocioPro::WORD_GR_CADRE :
                $contrat->setId($this->getGrCadreId());
                break;
            case Contrat::WORD_GR_PATRON :
                $contrat->setId($this->getGrDirId());
                break;
        }
    }

    public function lastInsertId() {
        $this->db->lastInsertId();
    }
}