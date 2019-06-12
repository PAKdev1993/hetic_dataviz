<?php

namespace App\model;

use App\model\DAO;
use App\dataviz\Entities\Entite;
use App\dataviz\datavizs\FilterList;
use App\dataviz\Entities\Secteur;

class SecteurDAO extends DAO
{
    const TABLE_NAME = 'secteur';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) {
        
    }

    public function getAll( FilterList $filters = null ) {

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