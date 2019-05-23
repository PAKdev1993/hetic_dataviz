<?php

namespace src\Dataviz\Entities;

class Secteur extends Entite
{    
    private $id;
    private $nom;

    public function __construct( array $pros ) {
        $this->id =   isset( $props['id'] ) ? $props['id'] : self::UNKNOW_ID;
        $this->nom = $props['nom'];

        $this->clean();
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

    private function clean() {
        $this->nom = $this->nom == '' ? self::WORD_NC : utf8_encode(trim(ucfirst(strtolower($value))));
    }

    protected function isEmpty() {
        return (bool) $this->nom;
    }
}