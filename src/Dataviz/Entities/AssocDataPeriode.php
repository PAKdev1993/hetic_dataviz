<?php

namespace src\Dataviz\Entities;

class AssocDataPeriode extends Entite
{
    private $id;
    private $idEleve;
    private $idPeriode;
    private $idGroupe;
    private $idFonction;
    private $idContrat;
    private $idSecteur;
    private $idFourchette;

    public function __construct( array $props ) {
        $this->id =   isset( $props['id'] ) ? $props['id'] : self::UNKNOW_ID;
        $this->idEleve = $props['idEleve'];
        $this->idPeriode = $props['idPeriode'];
        $this->idGroupe = $props['idGroupe'];
        $this->idContrat = $props['idContrat'];
        $this->idFonction = $props['idFonction'];
        $this->idSecteur = $props['idSecteur'];
        $this->idFourchette = $props['idFourchette'];
    }

    /**
     * GETTERS
     */
    public function id() {
         return $this->id;
    }
    public function idEleve() {
        return $this->idEleve;
    }
    public function idPeriode() {
        return $this->idPeriode;
    }
    public function idGroupe() {
        return $this->idGroupe;
    }
    public function idFonction() {
        return $this->idFonction;
    }
    public function idContrat() {
        return $this->idContrat;
    }
    public function idSecteur() {
        return $this->idSecteur;
    }
    public function idFourchette() {
        return $this->idFourchette;
    }
    /**
     * SETTERS
     */
    public function setId($id) {
        $this->id = $id;
    }

    public function clean() { }

    public function isEmpty() {
        return  (bool) !$this->idPeriode || 
                (bool) !$this->idGroupe || 
                (bool) !$this->idFonction || 
                (bool) !$this->idContrat || 
                (bool) !$this->idSecteur || 
                (bool) !$this->idFourchette;
    }
}