<?php

namespace src\model;

use src\model\DAO;
use src\Dataviz\Entities\Entite;
use src\Dataviz\Entities\Fourchette;

class FourchetteDAO extends DAO{

    const TABLE_NAME = 'fourchette_salaire';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) {
        
    }

    public function getAll() {

    }

    public function save(Entite &$fourchette) {
        if( $fourchette->id() === self::UNKNOWN_ID ) {
            if(!$fourchette->isEmpty()) {
                //INSERT
                $sql = "INSERT INTO ". self::TABLE_NAME." (". 
                        "fourchette".
                        ") VALUES (".
                        ":fourchette )";
                $sth = $this->db->prepare($sql);
                $sth->execute( array(':fourchette' => $fourchette->fourchette()) );
                $fourchette->setId($this->db->lastInsertId());
            }
            else{
                $fourchette->setId(Entite::WORD_NC); 
            }
        }
        else {
            //UPDATE
        }
    }

    public function delete(Entite $obj) { }
}