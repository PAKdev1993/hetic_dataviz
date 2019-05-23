<?php

namespace src\model;

use src\Dataviz\Entities\Secteur;

class SecteurDAO extends DAO
{
    const TABLE_NAME = 'secteur';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) {
        
    }

    public function getAll() {

    }

    public function save(Secteur $secteur) {
        if( $secteur->id() === Secteur::UNKNOWN_ID ) {
            //INSERT
            $sql = "INSERT INTO ". self::TABLE_NAME." (". 
                    "nom".
                    ") VALUES (".
                    $secteur->nom() . ')';
            $this->db->exec($sql);
            $secteur->setId($this->lastInsertId());
        }
        else {
            //UPDATE
        }
    }

    public function delete() {

    }

    public function lastInsertId() {
        $this->db->lastInsertId();
    }        
}