<?php

namespace src\Dataviz\Entities;

class Contrat extends Entite
{    
    private $id;
    private $nom;

    public function __construct( array $props ) {
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

    protected function clean() {
        if($this->nom == '') {
            $this->nom = self::WORD_NC;
            return;
        }
        if(strpos( $this->nom, "NC" ) !== false) {
            $this->nom = self::WORD_NC;
            return;
        } 
        if(strpos( strtolower($this->nom), "CDD contrat pro" ) !== false) {
            $this->nom = self::WORD_CONTRAT_CONTRAT_PRO;
            return;
        }
        if(strpos( strtolower($this->nom), "CDD" ) !== false) {
            $this->nom = self::WORD_CONTRAT_CDD;
            return;
        }
        if(strpos( strtolower($this->nom), "CDI" ) !== false) {
            $this->nom = self::WORD_CONTRAT_CDI;
            return;
        }
        $this->nom = self::WORD_NC;
    }

    public function isEmpty() {
        return (bool) !$this->nom;
    }
}