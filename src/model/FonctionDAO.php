<?php

namespace App\model;

use App\model\DAO;
use App\dataviz\Entities\Entite;
use App\dataviz\datavizs\FilterList;
use App\Dataviz\Entities\Fonction;

class FonctionDAO extends DAO{

    const TABLE_NAME = 'fonction';
    const ID_NAME = 'idFonction';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE ".self::ID_NAME ." = $id";
        $sth = $this->db->query($sql);
        $props = $sth->fetch();
        return new Fonction($props);
    }

    public function getAll(FilterList $filters = null) {

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