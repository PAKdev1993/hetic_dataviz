<?php

namespace App\model;

use App\model\DAO;
use App\dataviz\Entities\Entite;
use App\dataviz\datavizs\FilterList;
use App\dataviz\Entities\Periode;

class PeriodeDAO extends DAO{

    const TABLE_NAME = 'periode';
    const ID_NAME = 'idPeriode';
    const NAME_WORD = "nom";

    public function __construct( $db ) {
        parent::__construct($db);
    }

    public function getOne($id) { }

    public function getAll( FilterList $filters = null ) { }

    public function save(Entite &$periode) { }

    public function get6moisId() {
        //get l'id B de cette periode en DB
        $sql = "SELECT ". self::ID_NAME ." FROM " . self::TABLE_NAME . " WHERE ". self::NAME_WORD ." = '". Entite::PERIODE_6MOIS_NAME . "'";
        $sth = $this->db->query($sql);
        return (int) $sth->fetch()['idPeriode'];
    }

    public function getActuelleId() {
        $sql = "SELECT ". self::ID_NAME ." FROM " . self::TABLE_NAME . " WHERE ". self::NAME_WORD ." = '". Entite::PERIODE_ACTUELLE_NAME . "'";
                $sth = $this->db->query($sql);
        return (int) $sth->fetch()['idPeriode'];
    }

    public function delete(Entite $obj) {}
}