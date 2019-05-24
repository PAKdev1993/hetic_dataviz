<?php

namespace src\model;

use src\model\DAO;
use src\Dataviz\Entities\Entite;
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

    public function save(Entite &$fonction) {
        if( $fonction->id() === self::UNKNOWN_ID ) {
            if(!$fonction->isEmpty()) {
                //INSERT
                $sql = "INSERT INTO ". self::TABLE_NAME ." (". 
                        "nom".
                        ") VALUES (".
                        ":nom )";
                $sth = $this->db->prepare($sql);
                $sth->execute( array(':nom' => $fonction->nom()) );
                $fonction->setId($this->db->lastInsertId());
            }
            else{
                $fonction->setId(Entite::WORD_NC);
            }
        }
        else {
            //UPDATE
        }
    }

    public function delete(Entite $obj) { }
}