<?php

namespace src\model;

use src\model\DAO;
use src\Dataviz\Entities\Entite;
use src\Dataviz\Entities\AssocDataPeriode;

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

    public function save(Entite &$assocDataPeriode) {
        if( $assocDataPeriode->id() === self::UNKNOWN_ID ) {
            //INSERT
            $sql = "INSERT INTO " . self::TABLE_NAME . " (".
                    "idEleve,
                     idPeriode,
                     idGroupe,
                     idContrat,
                     idFonction,
                     idSecteur,
                     idFourchette".
                    ") VALUES (".
                    ":idEleve,
                     :idPeriode,
                     :idGroupe,
                     :idContrat,
                     :idFonction,
                     :idSecteur,
                     :idFourchette )";
            $sth = $this->db->prepare($sql);
            $sth->execute( array(
                    ':idEleve' => $assocDataPeriode->idELeve(),
                    ':idPeriode' => $assocDataPeriode->idPeriode(),
                    ':idGroupe' => $assocDataPeriode->idGroupe(),
                    ':idContrat' => $assocDataPeriode->idContrat(),
                    ':idFonction' => $assocDataPeriode->idFonction(),
                    ':idSecteur' => $assocDataPeriode->idSecteur(),
                    ':idFourchette' => $assocDataPeriode->idFourchette()) );
            //set l'id de l'élève inseré
            $assocDataPeriode->setId($this->db->lastInsertId());
        }
        else {
            //UPDATE
        }
    }

    public function delete(Entite $obj) { }
}