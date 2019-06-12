<?php

namespace App\dataviz\Entities;

class Fonction extends Entite
{
    private $id;
    private $nom;

    public function __construct( array $props ) {
        $this->id =   isset( $props['idFonction'] ) ? $props['idFonction'] : self::UNKNOW_ID;
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
        if(strpos( strtolower($this->nom), "nc" ) !== false) $this->nom = self::WORD_NC;
        if(strpos( strtolower($this->nom), "poursuite" ) !== false) $this->nom = self::WORD_FONCTION_POURSUITE_ETUDE;
        if(strpos( strtolower($this->nom), "emploi" ) !== false) $this->nom = self::WORD_FONCTION_RECH_EMPLOI;
        $this->nom = trim($this->nom);
    }

    public function isEmpty() {
        return (bool) !$this->nom;
    }
}