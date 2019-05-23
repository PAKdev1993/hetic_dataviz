<?php

namespace src\Dataviz\Entities;

class GroupeSocioPro extends Entite 
{    
    private $id;
    private $nom;

    public function __construct( array $pros ) {
        $this->id =   isset( $props['id'] ) ? $props['id'] : self::UNKNOW_ID;
        $this->nom = $props['nom'];

        $this->clear();
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

    protected function clear() {
        if(strpos( $this->name, "Emp" ) !== false){
            $this->name = self::WORD_GR_EMPLOYE; 
            return;
        }
        if(strpos( $this->name, "Ind" ) !== false){
            $this->name = self::WORD_GR_INDEPENDANT;
            return; 
        }
        if(strpos( $this->name, "Ca" ) !== false){
            $this->name = self::WORD_GR_CADRE;
            return; 
        }
        if(strpos( $this->name, "Dir" ) !== false){
            $this->name = self::WORD_GR_PATRON;
            return; 
        }
        //#TODO ici il n'y a pas le cas "Poursuite d'étude" car inutile ds ce champ
        $this->name = self::WORD_NC;
        return; 
    }

    protected function isEmpty() {
        return (bool) $this->nom;
    }
}