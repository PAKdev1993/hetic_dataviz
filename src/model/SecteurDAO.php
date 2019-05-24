<?php

namespace src\model;

use src\model\DAO;
use src\Dataviz\Entities\Entite;
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

    public function save(Entite &$secteur) {
        if( $secteur->id() === self::UNKNOWN_ID ) {
            if(!$secteur->isEmpty()) {
                //INSERT
                $sql = "INSERT INTO ". self::TABLE_NAME." (". 
                        "nom".
                        ") VALUES (".
                        ':nom )';
                $sth = $this->db->prepare($sql);
                $sth->execute( array(':nom' => $secteur->nom()) );
                $secteur->setId($this->db->lastInsertId());
            }
            else{
                $secteur->setId(Entite::WORD_NC); 
            }
        }
        else {
            //UPDATE
        }
    }

    public function delete(Entite $obj){}       
}