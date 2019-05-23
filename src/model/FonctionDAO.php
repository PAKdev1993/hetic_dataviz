<?php

namespace src\model;

use src\Dataviz\Entities\Fonction;

class FonctionDAO extends DAO{

    const TABLE_NAME = 'fonction';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) {
        
    }

    public function getAll() {

    }

    public function save(Fonction $fonction) {
        if( $fonction->id() === Fonction::UNKNOWN_ID ) {
            //INSERT
            $sql = "INSERT INTO ". self::TABLE_NAME." (". 
                    "nom".
                    ") VALUES (".
                    $fonction->nom() . ')';
            $this->db->exec($sql);
            $fonction->setId($this->lastInsertId());
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