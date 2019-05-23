<?php

namespace src\Dataviz\Entities;

class AssocPeriodeEleve extends Entite
{
    private $id;
    private $idPeriode;
    private $idEleve;

    public function __construct( array $pros ) {
        $this->id =   isset( $props['id'] ) ? $props['id'] : self::UNKNOW_ID;
        $this->idPeriode =  $props['idPeriode'];
        $this->idEleve =    $props['idEleve'];
    }

    /**
     * GETTERS
     */
    public function idPeriode() {
         return $this->idPeriode;
    }
    public function idEleve() {
        return $this->idEleve;
    }
    /**
     * SETTERS
     */
    public function setId($id) {
        $this->id = $id;
    }

}