<?php

namespace App\dataviz\Entities;

class Secteur extends Entite
{    
    private $id;
    private $nom;

    public function __construct( array $props ) {
        $this->id =   isset( $props['idSecteur'] ) ? $props['idSecteur'] : self::UNKNOW_ID;
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
        if(strpos( strtolower(trim($this->nom)), 'nc' ) !== false ) {
            $this->nom = self::WORD_NC;
        }
        elseif($this->nom === '') {
            $this->nom = self::WORD_NC;
        }
        else{
            $this->nom = trim($this->nom);
        }
    }

    public function isEmpty() {
        return (bool) !$this->nom;
    }
}