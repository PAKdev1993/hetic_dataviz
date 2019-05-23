<?php

namespace src\model;

use src\Entities\AssocPeriodeEleve;
use src\model\DAO;

class AssocPeriodeEleveDAO extends DAO
{
    const TABLE_NAME = 'assoc_periode_eleve';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($groupSocPro) {
        
    }

    public function getAll() {

    }

    public function save(AssocPeriodeEleve $AssocPeriodeEleve) {
        if( $eleve->id() === AssocPeriodeEleve::UNKNOWN_ID ) {
            //INSERT
            $sql = "INSERT INTO " . self::TABLE_ELEVE . " (".
                    "idPeriode,
                     idEleve".
                    ") VALUES (".
                    $AssocPeriodeEleve->idPeriode() . ',' .
                    $AssocPeriodeEleve->idEleve() . ')';
            $this->db->exec($sql);
            $AssocPeriodeEleve->setId($this->lastInsertId());
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