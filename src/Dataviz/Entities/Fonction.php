<?php

namespace src\Dataviz\Entities;

class Fonction extends Entite
{
    private $id;
    private $nom;

    public function __construct( array $pros ) {
        $this->id =   isset( $props['id'] ) ? $props['id'] : self::UNKNOW_ID;
        $this->nom = $props['nom'];

        $this->clean();
    }

    /**
     * GETTES
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
    
    protected function clean() {
        if($this->nom == '') $this->nom = self::WORD_NC;
        if(strpos( $this->nom, "NC" ) !== false) $this->nom = self::WORD_NC;
        if(strpos( strtolower($this->nom), "poursuite" ) !== false) $this->nom = self::WORD_FONCTION_POURSUITE_ETUDE;
        if(strpos( strtolower($this->nom), "emploi" ) !== false) $this->nom = self::WORD_FONCTION_RECH_EMPLOI;
        $this->nom = utf8_encode(trim(ucfirst(strtolower($this->nom))));
    }

    protected function isEmpty() {
        return (bool) $this->nom;
    }
}