<?php

namespace App\model;

use App\model\DAO;
use App\dataviz\Entities\Entite;
use App\dataviz\datavizs\FilterList;
use App\dataviz\Entities\Fourchette;

class FourchetteDAO extends DAO{

    const TABLE_NAME = 'fourchette_salaire';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) {
        
    }

    public function getAll(FilterList $filters = null) {

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