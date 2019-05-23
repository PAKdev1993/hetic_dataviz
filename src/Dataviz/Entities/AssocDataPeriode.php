<?php

namespace src\Dataviz\Entities;

class AssocDataPeriode extends Entite
{
    private $id;
    private $idPeriode;
    private $idGroupe;
    private $idFonction;
    private $idContrat;
    private $idSecteur;
    private $idFourchette;

    public function __construct( array $pros ) {
        $this->id =   isset( $props['id'] ) ? $props['id'] : self::UNKNOW_ID;
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
}