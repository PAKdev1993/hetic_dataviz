<?php

namespace src\Dataviz\DataInsertion;

use src\Dataviz\Entities\EntityFactory;
use src\model\Entities\DAOFactory;

class ExcellDataFetcher implements InsertionInterface
{
    const PATH_DATA = './data/bd.xlsx';
    const PATH_DATA_MAPPING = './data/bd_mapping.json';

    private $mappingFile;
    private $excellReader;
    private $spreadSheets;

    public function __construct( $excellReader ) {
        $this->excellReader = $excellReader;
        $this->mappingFile = $this->fetchMappingFile();
        $this->spreadSheets = $this->getSpeadsheets();
    }

    private function fetchMappingFile() {
        // Read JSON file
        $json = file_get_contents(self::PATH_DATA_MAPPING);
        return json_decode($json);
    }

    private function getSpeadsheets() {
        $this->excellReader->setReadDataOnly(true); // Tell the Reader that we want to Read Only
        //if ($customExcellReader) $excellReader->setReadFilter($customExcellReader);// Tell the Reader that we want to use the Read Filter
        return $excellReaderLoaded->load(self::PATH_DATA); // Load Spreadsheet
    }

    private function extractEleve($sheetMapping, $sheet, $line, $periode) {
        $props = array();

        $props['promo'] = $sheetMapping->props->promo;
        $props['annee_promo'] = $sheetMapping->props->annee_promo;

        $cellToRead = (string) $sheetMapping->props->civilite . $line;
        $props['civilite'] = $currentSheet->getCell($cellToRead, false)->getValue();

        $cellToRead = (string) $sheetMapping->props->date_sortie_hetic . $line;
        $props['date_sortie_hetic'] = $currentSheet->getCell($cellToRead, false)->getValue();

        $cellToRead = (string) $sheetMapping->props->ville . $line;
        $props['ville'] = $currentSheet->getCell($cellToRead, false)->getValue();

        $cellToRead = (string) $sheetMapping->props->code_postal_residence . $line;
        $props['code_postal_residence'] = $currentSheet->getCell($cellToRead, false)->getValue();

        $cellToRead = (string) $sheetMapping->props->pays . $line;
        $props['pays'] = $currentSheet->getCell($cellToRead, false)->getValue();

        $cellToRead = (string) $sheetMapping->props->etudes_avant_hetic . $line;
        $props['etudes_avant_hetic'] = $currentSheet->getCell($cellToRead, false)->getValue();

        $cellToRead = (string) $sheetMapping->props->situation_pro_sortie_hetic . $line;
        $props['situation_pro_sortie_hetic'] = $currentSheet->getCell($cellToRead, false)->getValue();

        $cellToRead = (string) $sheetMapping->props->jobs_notables_exerces . $line;
        $props['jobs_notables_exerces'] = $currentSheet->getCell($cellToRead, false)->getValue();

        return EntityFactory::get('eleve', $props);
    }
    private function extractFonction($sheetMapping, $sheet, $line, $periode) {
        if( $periode === '6mois') {
            $cellToRead = (string) $sheetMapping->props_periode_6_mois->fonction . $line;
            $props['nom'] = $currentSheet->getCell($cellToRead, false)->getValue();
        }
        if( $periode === 'actuelle') {
            $cellToRead = (string) $sheetMapping->props_periode_actuelle->fonction . $line;
            $props['nom'] = $currentSheet->getCell($cellToRead, false)->getValue();
        }

        return EntityFactory::get('fonction', $props);
    }
    private function extractGroupe_socio_pro($sheetMapping, $sheet, $line, $periode) {
        if( $periode === '6mois') {
            $cellToRead = (string) $sheetMapping->props_periode_6_mois->groupe_socio_pro . $line;
            $props['nom'] = $currentSheet->getCell($cellToRead, false)->getValue();
        }
        if( $periode === 'actuelle') {
            $cellToRead = (string) $sheetMapping->props_periode_actuelle->groupe_socio_pro . $line;
            $props['nom'] = $currentSheet->getCell($cellToRead, false)->getValue();
        }

        return EntityFactory::get('groupe_socio_pro', $props);
    }
    private function extractSecteur($sheetMapping, $sheet, $line, $periode) {
        if( $periode === '6mois') {
            $cellToRead = (string) $sheetMapping->props_periode_6_mois->secteur . $line;
            $props['nom'] = $currentSheet->getCell($cellToRead, false)->getValue();
        }
        if( $periode === 'actuelle') {
            $cellToRead = (string) $sheetMapping->props_periode_actuelle->secteur . $line;
            $props['nom'] = $currentSheet->getCell($cellToRead, false)->getValue();
        }

        return EntityFactory::get('secteur', $props);
    }
    private function extractFourchette($sheetMapping, $sheet, $line, $periode) {
        if( $periode === '6mois') {
            $cellToRead = (string) $sheetMapping->props_periode_6_mois->fourchette_salaire . $line;
            $props['fourchette'] = $currentSheet->getCell($cellToRead, false)->getValue();
        }
        if( $periode === 'actuelle') {
            $cellToRead = (string) $sheetMapping->props_periode_actuelle->fourchette_salaire . $line;
            $props['fourchette'] = $currentSheet->getCell($cellToRead, false)->getValue();
        }

        return EntityFactory::get('fourchette', $props);
    }

    public function InsertDatas() {
        //get entites DAO
        $contratDAO = DAOFactory::get('contrat');
        $eleveDAO = DAOFactory::get('eleve');
        $fonctionDAO = DAOFactory::get('fonction');
        $contratDAO = DAOFactory::get('contrat');
        $fourchetteDAO = DAOFactory::get('fourchette');
        $groupe_socio_proDAO = DAOFactory::get('groupe_socio_pro');
        $secteurDAO = DAOFactory::get('secteur');
        $periodeDAO = DAOFactory::get('periode');
        $assoc_data_periodeDAO = DAOFactory::get('assoc_data_periode');
        $assoc_periode_eleveDAO = DAOFactory::get('assoc_periode_eleve');

        //parcours du fichier de mapping des sheets 
        //le but est de recuperer la colonne associé à chaque type de donnée
        foreach($this->mappingFile->sheetMarkpoints as $sheetMapping)
        {
            //init pour les parcours
            //recuperation de la sheet a extraire avec le ExcellReader
            $currentSheet = $this->spreadsheet->getSheetByName($sheetMapping->title);
            //determine (grace aux infos de mapping) le nombre de ligne a parcourir sur la sheet
            $maxLine = $sheetMapping->beginLine + $sheetMapping->nbLines;

            //parcours des lignes de la sheet et inserer les données
            for($line = $sheetMapping->beginLine; $line <= $maxLine; $line++)
            {
                //get entity eleve object
                $eleveObj =             $this->extractEleve($sheetMapping, $currentSheet, $line);
                //get entities pour la periode 6 mois
                //build entities objects
                //pour periode 6 mois
                $fonction6moisObj =     $this->extractFonction($sheetMapping, $currentSheet, $line, '6mois');
                $groupe6moisObj =       $this->extractGroupe_socio_pro($sheetMapping, $currentSheet, $line, '6mois');
                $contrat6moisObj =      $this->extractContrat($sheetMapping, $currentSheet, $line, '6mois');
                $secteur6moisObj =      $this->extractSecteur($sheetMapping, $currentSheet, $line, '6mois');
                $foucehette6moisObj =   $this->extractFourchette($sheetMapping, $currentSheet, $line, '6mois');
                //pour la periode actuelle
                $fonctionActuelleObj =     $this->extractFonction($sheetMapping, $currentSheet, $line, 'actuelle');
                $groupeActuelleObj =       $this->extractGroupe_socio_pro($sheetMapping, $currentSheet, $line, 'actuelle');
                $contratActuelleObj =      $this->extractContrat($sheetMapping, $currentSheet, $line, 'actuelle');
                $secteurActuelleObj =      $this->extractSecteur($sheetMapping, $currentSheet, $line, 'actuelle');
                $foucehetteActuelleObj =   $this->extractFourchette($sheetMapping, $currentSheet, $line, 'actuelle');
                //insert
                //pour la periode 6 mois
                $fonctionDAO->save($fonction6moisObj); 
                $contratDAO->save($contrat6moisObj); 
                $secteurDAO->save($secteur6moisObj); 
                $groupe_socio_proDAO->save($groupe6moisObj); 
                $fourchetteDAO->save($foucehette6moisObj); 
                //pour la periode actuelle
                $fonctionDAO->save($fonction6moisObj);
                $contratDAO->save($contratActuelleObj);
                $secteurDAO->save($secteurActuelleObj);
                $groupe_socio_proDAO->save($groupeActuelleObj); 
                $fourchetteDAO->save($foucehetteActuelleObj);

                //create assocs si cela est nescessaire car des données peuvent etre vides
                $assocPeriodeEleveObj;
                $assocDataPerideObj;
                //si l'Eleve a renseigné des données pour la periode 6 mois
                $isEleveRenseignePeriode6mois = (bool) $fonction6moisObj->isEmpty() || $groupe6moisObj->isEmpty() || $contrat6moisObj->isEmpty()|| $secteur6moisObj->isEmpty() || $foucehette6moisObj->isEmpty();
                if( $isEleveRenseignePeriode6mois ) {
                    //build entity assoc object
                    //assoc periode eleve
                    //pour la periode 6 mois
                    $idPeriode = $periodeDAO->get6moisId();
                    $assocPeriodeEleveObj = EntityFactory::get('assoc_periode_eleve', array(
                            'idPeriode' => $idPeriode,
                            'idEleve' => $eleve->id()
                        ));
                    $assocDataPerideObj = EntityFactory::get('assoc_data_periode', array(
                            'idPeriode' =>  $idPeriode,
                            'idGroupe' => $groupe6moisObj->id(),
                            'idContrat' => $contrat6moisObj->id(),
                            'idFonction' => $fonction6moisObj->id(),
                            'idSecteur' => $secteur6moisObj->id(),
                            'idFourchette' => $foucehette6moisObj>id()
                        ));
                }
                $assoc_periode_eleveDAO->save($assocPeriodeEleve);
                $assoc_data_periodeDAO->save($assocDataPeride);

                //si l'Eleve a renseigné des données pour la periode actuelle
                $isEleveRenseignePeriodeActuelle = (bool) $fonctionActuelleObj->isEmpty() || $groupeActuelleObj->isEmpty() || $contratActuelleObj->isEmpty()|| $secteurActuelleObj->isEmpty() || $foucehetteActuelleObj->isEmpty();
                if( $isEleveRenseignePeriodeActuelle ) {
                    //build entity assoc object
                    //assoc periode eleve
                    //pour la periode 6 mois
                    $idPeriode = $periodeDAO->get6moisId();
                    $assocPeriodeEleveObj = EntityFactory::get('assoc_periode_eleve', array(
                            'idPeriode' => $idPeriode,
                            'idEleve' => $eleve->id()
                        ));
                    $assocDataPerideObj = EntityFactory::get('assoc_data_periode', array(
                            'idPeriode' =>  $idPeriode,
                            'idGroupe' => $groupeActuelleObj->id(),
                            'idContrat' => $contratActuelleObj->id(),
                            'idFonction' => $fonctionActuelleObj->id(),
                            'idSecteur' => $secteurActuelleObj->id(),
                            'idFourchette' => $foucehetteActuelleObj>id()
                        ));
                }
            }
        }
        return true;
    }
}