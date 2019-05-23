<?php

namespace src\Dataviz\Entities;

class Periode extends Entite
{
    private $id;
    private $nom;

    public function __construct( array $pros ) {
        $this->id =   $props['id'];
        $this->nom = $props['nom'];
    }

    /**
     * GETTERS
     */
    public function id() {
         return $this->id;
    }
    public function nom() {
        return $this->nom;
    }
    /**
     * SETTERS
     */
    public function setId($id) {
        $this->id = $id;
    }
}