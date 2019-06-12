<?php

namespace App\model;

use App\dataviz\Entities\Entite;
use App\dataviz\datavizs\FilterList;

abstract class DAO
{
    const UNKNOWN_ID = -1; // Identifiant non déterminé

    protected $db; // Objet pdo pour l'accès à la table

    // Le constructeur reçoit l'objet PDO contenant la connexion
    public function __construct( $connector ) {
        $this->db = $connector;
    }

    // Récupération d'un objet dont on donne l'identifiant
    abstract public function getOne($id);

    // Récupération de tous les objets dans une table
    abstract public function getAll(FilterList $filters = null);

    // Sauvegarde de l'objet $obj :
    //     $obj->id == UNKNOWN_ID ==> INSERT
    //     $obj->id != UNKNOWN_ID ==> UPDATE
    abstract public function save(Entite &$obj);

    // Effacement de l'objet $obj (DELETE)
    abstract public function delete(Entite $obj);
}
