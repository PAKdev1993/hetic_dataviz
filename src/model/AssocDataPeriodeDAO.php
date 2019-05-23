<?php

namespace src\model;

use src\Entities\AssocDataPeriode;
use src\model\DAO;

class AssocDataPeriodeDAO extends DAO
{
    const TABLE_NAME = 'assoc_data_periode';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($eleve) {
        
    }

    public function getAll() {

    }

    public function save($assocDataPeriode) {
        if( $eleve->id() === AssocDataPeriode::UNKNOWN_ID ) {
            //INSERT
            $sql = "INSERT INTO " . self::TABLE_NAME . " (".
                    "idPeriode,
                     idGroupe,
                     idContrat,
                     idFonction,
                     idSecteur,
                     idFourchette".
                    ") VALUES (".
                    $eleve->idPeriode() . ',' .
                    $eleve->idGroupe() . ',' .
                    $eleve->idContrat() . ',' .
                    $eleve->idFonction() . ',' .
                    $eleve->idSecteur() . ',' .
                    $eleve->idFourchette() . ')';
            $this->db->exec($sql);
            //set l'id de l'élève inseré
            $eleve->setId($this->lastInsertId());
        }
        else {
            //UPDATE
        }
    }

    public function delete() {

    }

    public function lastInsertId() {

    }
}