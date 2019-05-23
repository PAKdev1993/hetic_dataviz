<?php

namespace src\model;

use src\Dataviz\Entities\Eleve;

class EleveDAO extends DAO 
{

    const TABLE_NAME = 'eleve';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) {
        
    }

    public function getAll() {

    }

    public function save(Eleve $eleve) {
        if( $eleve->id() === Eleve::UNKNOWN_ID ) {
            //insert
            $sql = "INSERT INTO " . self::TABLE_NAME . " (".
                    "promo,
                     civilite,
                     date_sortie_hetic,
                     ville,
                     code_postal_residence,
                     pays,
                     annee_promo,
                     etudes_avant_hetic,
                     situation_pro_sortie_hetic,
                     jobs_notables_exerces".
                    ") VALUES (".
                    $eleve->promo() . ',' .
                    $eleve->civilite() . ',' .
                    $eleve->date_sortie_hetic() . ',' .
                    $eleve->ville() . ',' .
                    $eleve->code_postal_residence() . ',' .
                    $eleve->pays() . ',' .
                    $eleve->annee_promo() . ',' .
                    $eleve->etudes_avant_hetic() . ',' .
                    $eleve->situation_pro_sortie_hetic() . ',' .
                    $eleve->jobs_notables_exerces() . ')';
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
        $this->db->lastInsertId();
    }
}