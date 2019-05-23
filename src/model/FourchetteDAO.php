<?php

namespace src\model;

use src\Dataviz\Entities\Fourchette;

class FourchetteDAO extends DAO{

    const TABLE_NAME = 'fourchette';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) {
        
    }

    public function getAll() {

    }

    public function save(Fourchette $fourchette) {
        if( $fourchette->id() === Fourchette::UNKNOWN_ID ) {
            //INSERT
            $sql = "INSERT INTO ". self::TABLE_NAME." (". 
                    "fourchette".
                    ") VALUES (".
                    $fourchette->fourchette() . ')';
            $this->db->exec($sql);
            $fourchette->setId($this->lastInsertId());
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