<?php

namespace App\dataviz\Entities;

class GroupeSocioPro extends Entite 
{    
    private $id;
    private $nom;

    public function __construct( array $props ) {
        $this->id =   isset( $props['idGroupe'] ) ? $props['idGroupe'] : self::UNKNOW_ID;
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
        if(strpos( $this->nom, "Emp" ) !== false){
            $this->nom = self::WORD_GR_EMPLOYE; 
            return;
        }
        if(strpos( $this->nom, "Ind" ) !== false){
            $this->nom = self::WORD_GR_INDEPENDANT;
            return; 
        }
        if(strpos( $this->nom, "Ca" ) !== false){
            $this->nom = self::WORD_GR_CADRE;
            return; 
        }
        if(strpos( $this->nom, "Dir" ) !== false){
            $this->nom = self::WORD_GR_PATRON;
            return; 
        }
        //#TODO ici il n'y a pas le cas "Poursuite d'étude" car inutile ds ce champ
        $this->nom = self::WORD_NC;
        return; 
    }

    public function isEmpty() {
        return (bool) !$this->nom;
    }
}