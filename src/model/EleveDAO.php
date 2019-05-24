<?php

namespace src\model;

use src\Dataviz\Entities\Entite;

class EleveDAO extends DAO 
{

    const TABLE_NAME = 'eleve';

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE idEleve = $id";
        $sth = $this->db->query($sql);
        return $sth->fetch();
    }

    public function getAll() {

    }

    public function save(Entite &$eleve) {
        if( $eleve->id() === self::UNKNOWN_ID ) {
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
                    ":promo,
                     :civilite,
                     :date_sortie_hetic,
                     :ville,
                     :code_postal_residence,
                     :pays,
                     :annee_pro,
                     :etudes_avant_hetic,
                     :situation_pro_sortie_hetic,
                     :jobs_notables_exerces )";
            $sth = $this->db->prepare($sql);
            $sth->execute( array( 
                    ':promo' =>$eleve->promo(),
                    ':civilite' => $eleve->civilite(),
                    ':date_sortie_hetic' => $eleve->date_sortie_hetic(),
                    ':ville' => $eleve->ville(),
                    ':code_postal_residence' => $eleve->code_postal_residence(),
                    ':pays' => $eleve->pays(),
                    ':annee_pro' => $eleve->annee_promo(),
                    ':etudes_avant_hetic' => $eleve->etudes_avant_hetic(),
                    ':situation_pro_sortie_hetic' => $eleve->situation_pro_sortie_hetic(),
                    ':jobs_notables_exerces' => $eleve->jobs_notables_exerces() ));
            //set l'id de l'élève inseré
            $eleve->setId($this->db->lastInsertId());
        }
        else {
            //UPDATE
        }
    }

    public function delete(Entite $obj) { }
}