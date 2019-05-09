<?php
    require "./db/DB.php";
    require_once "./data/ConfigData.php";

    class EleveDB{

        private $eleve;

        private static $idGrEmploye;
        private static $idGrInde;
        private static $idGrCadre;
        private static $idGrDir;

        private static $idCddcontratPro;
        private static $idCdd;
        private static $idCdi;
        private static $idAutre;

        private static $idPeriode6mois;
        private static $idPeriodeActuelle;

        public function __construct()
        {
            $this->db = DB::getInstance();

            //set ids des valeurs ENUM de la base
            $this->setIdPeriode6mois();
            $this->setIdPeriodeActuelle();
            $this->setIdTypesContrats();
            $this->setIdGroupSocPro();
        }

        private function setIdPeriode6mois()
        {
            if(!isset(self::$idPeriode6mois))
            {
                //get l'id B de cette periode en DB
                $sql = "SELECT idPeriode FROM " . ConfigData::TABLE_PERIODE . " WHERE nom = '". ConfigData::PERIODE_6MOIS_NAME . "'";
                $sth = $this->db->query($sql);
                self::$idPeriode6mois = (int) $sth->fetch()->idPeriode;
            }
        }

        private function setIdPeriodeActuelle()
        {
            if(!isset(self::$idPeriodeActuelle))
            {
                //get l'id B de cette periode en DB
                $sql = "SELECT idPeriode FROM " . ConfigData::TABLE_PERIODE . " WHERE nom = '". ConfigData::PERIODE_ACTUELLE_NAME . "'";
                $sth = $this->db->query($sql);
                self::$idPeriodeActuelle =(int) $sth->fetch()->idPeriode;
            }
        }

        private function setIdTypesContrats()
        {
            if(!isset(self::$idCddcontratPro))
            {
                $sql = "SELECT idContrat FROM " . ConfigData::TABLE_CONTRAT . " WHERE nom = '". ConfigData::WORD_CONTRAT_CONTRAT_PRO . "'";
                $sth = $this->db->query($sql);
                self::$idCddcontratPro = (int) $sth->fetch()->idContrat;                
            }
            if(!isset(self::$idCdd))
            {
                $sql = "SELECT idContrat FROM " . ConfigData::TABLE_CONTRAT . " WHERE nom = '". ConfigData::WORD_CONTRAT_CDD . "'";
                $sth = $this->db->query($sql);
                self::$idCdd = (int) $sth->fetch()->idContrat;
            }
            if(!isset(self::$idCdi))
            {
                $sql = "SELECT idContrat FROM " . ConfigData::TABLE_CONTRAT . " WHERE nom = '". ConfigData::WORD_CONTRAT_CDI . "'";
                $sth = $this->db->query($sql);
                self::$idCdi = (int) $sth->fetch()->idContrat;
            }
            if(!isset(self::$idAutre))
            {
                $sql = "SELECT idContrat FROM " . ConfigData::TABLE_CONTRAT . " WHERE nom = '". ConfigData::WORD_CONTRAT_AUTRE . "'";
                $sth = $this->db->query($sql);
                self::$idAutre = (int) $sth->fetch()->idContrat;
            }
        }

        private function setIdGroupSocPro()
        {
            if(!isset(self::$idGrEmploye))
            {
                $sql = "SELECT idGroupe FROM " . ConfigData::TABLE_GR_SO_PRO . " WHERE nom = '". ConfigData::WORD_GR_EMPLOYE . "'";
                $sth = $this->db->query($sql);
                self::$idGrEmploye = (int) $sth->fetch()->idGroupe;                
            }
            if(!isset(self::$idGrInde))
            {
                $sql = "SELECT idGroupe FROM " . ConfigData::TABLE_GR_SO_PRO . " WHERE nom = '". ConfigData::WORD_GR_INDEPENDANT . "'";
                $sth = $this->db->query($sql);
                self::$idGrInde = (int) $sth->fetch()->idGroupe;
            }
            if(!isset(self::$idGrCadre))
            {
                $sql = "SELECT idGroupe FROM " . ConfigData::TABLE_GR_SO_PRO . " WHERE nom = '". ConfigData::WORD_GR_CADRE . "'";
                $sth = $this->db->query($sql);
                self::$idGrCadre = (int) $sth->fetch()->idGroupe;
            }
            if(!isset(self::$idGrDir))
            {
                $sql = "SELECT idGroupe FROM " . ConfigData::TABLE_GR_SO_PRO . " WHERE nom = '". ConfigData::WORD_GR_PATRON . "'";
                $sth = $this->db->query($sql);
                self::$idGrDir = (int) $sth->fetch()->idGroupe;
            }
        }

        public function insert($eleveObj)
        {
            /* ----------------------------------------------------------------------
             * Inserer : Eleve
             * ----------------------------------------------------------------------
             * */
            //build request pour la table Eleve
            $sql1 = "INSERT INTO " . ConfigData::TABLE_ELEVE . " (";
            $sql2 = ") VALUES ("; 
            $close = ")";
            $eleveProps = $eleveObj->getAllProperties(null, 'eleve');
            foreach($eleveProps as $key => $val)
            {
                $sql1 .= $key . ', ';
                $sql2 .= ':' . $key . ', ';
            }
            $sql = str_replace(", )", ")", $sql1 . $sql2 . $close);
            //remplir table Eleve
            $sth = $this->db->prepare($sql)->execute($eleveObj->getAllProperties(null,'eleve'));

            //get l'id A de l'eleve inséré
            $idEleve = $this->db->lastInsertId();

            /* ----------------------------------------------------------------------
             * Inserer l'association : Periode 6 mois après HETIC / Eleve 
             * ----------------------------------------------------------------------
             * */
            //si l'élève possède des propriétés de cette periode, inserer l'association
            if(count($eleveObj->getAllProperties(null, 'periode_6_mois')) > 0)
            {
                //insertion de l'association assoc
                $sql = "INSERT INTO " . ConfigData::TABLE_PERIODE_ELEVE . " (fk_idPeriode, fk_idEleve) VALUES (? , ?)";
                $sth = $this->db->prepare($sql)->execute([$idEleve, self::$idPeriode6mois]);
            }
            
            /* ----------------------------------------------------------------------
             * Inserer Data : Fourchette / Contrat / Fonction / Secteur / Groupe Socio Pro
             * Inserer l'association : Période 6 mois après HETIC / Data
             * ----------------------------------------------------------------------
             * */
            //si l'élève possède des propriétés de cette periode, inserer l'association
            if(count($eleveObj->getAllProperties(null, 'periode_6_mois')) > 0)
            {
                $assocPeriode6mois['fk_idPeriode'] = self::$idPeriode6mois;
                foreach($eleveObj->getAllProperties(null, 'periode_6_mois') as $key => $value)
                {
                    //si la valeur a été communiquée on insert dans la table
                    if($value !== ConfigData::WORD_NC)
                    {
                        //recup du nom de la table ou inserer la donnée a partir de la key
                        $tmp = explode('__', $key);
                        $tableName = $tmp[1];
                        switch($tableName){
                            //remplir la table fonction
                            case ConfigData::TABLE_FONCTION : 
                                //rempli la fonction
                                $sql = "INSERT INTO $tableName (nom) VALUES ( ? )";
                                $this->db->prepare($sql)->execute([$value]);
                                //get l'id pour assoc Data / Periode
                                $assocPeriode6mois['fk_idFonction'] = $this->db->lastInsertId();
                                break;
    
                            //remplir fourchette salaire
                            case ConfigData::TABLE_FOURCHETTE_SAL : 
                                //rempli la fonction
                                $sql = "INSERT INTO $tableName (fourchette) VALUES ( ? )";
                                $this->db->prepare($sql)->execute([$value]);
                                //get l'id pour assoc Data / Periode
                                $assocPeriode6mois['fk_idFourchette'] = $this->db->lastInsertId();
                                break;
    
                            //rempli la fourchette secteur
                            case ConfigData::TABLE_SECTEUR :
                                //rempli la fonction
                                $sql = "INSERT INTO $tableName (nom) VALUES ( ? )";
                                $this->db->prepare($sql)->execute([$value]);
                                //get l'id pour assoc Data / Periode
                                $assocPeriode6mois['fk_idSecteur'] = $this->db->lastInsertId();
                                break;

                            //rempli la fourchette contrat
                            case ConfigData::TABLE_CONTRAT :
                                //get l'id pour assoc Data / Periode
                                if($value == ConfigData::WORD_CONTRAT_CONTRAT_PRO) 
                                    $assocPeriode6mois['fk_idContrat'] = self::$idCddcontratPro; 
                                    break;
                                if($value == ConfigData::WORD_CONTRAT_CDD)
                                    $assocPeriode6mois['fk_idContrat'] = self::$idCdd; 
                                    break;
                                if($value == ConfigData::WORD_CONTRAT_CDI)
                                    $assocPeriode6mois['fk_idContrat'] = self::$idCdi; 
                                    break;
                                if($value == ConfigData::WORD_CONTRAT_AUTRE)
                                    $assocPeriode6mois['fk_idContrat'] = self::$idAutre; 
                                    break;
                                break;

                            //rempli le groupe soc pro
                            case ConfigData::TABLE_GR_SO_PRO :
                                //get id groupe soc pro pour assoc Data / Periode
                                if($value == ConfigData::WORD_GR_EMPLOYE) 
                                    $assocPeriode6mois['fk_idGroupe'] = self::$idGrEmploye; 
                                    break;
                                if($value == ConfigData::WORD_GR_INDEPENDANT) 
                                    $assocPeriode6mois['fk_idGroupe'] = self::$idGrInde; 
                                    break;
                                if($value == ConfigData::WORD_GR_CADRE) 
                                    $assocPeriode6mois['fk_idGroupe'] = self::$idGrCadre; 
                                    break;
                                if($value == ConfigData::WORD_GR_PATRON) 
                                    $assocPeriode6mois['fk_idGroupe'] = self::$idGrDir; 
                                    break;
                                break;

                            default : 
                                break;
                        }
                    }
                }
                //build request
                //insertion ds la table assoc_data_periode
                $sql1 = "INSERT INTO " . ConfigData::TABLE_DATA_PERIODE . " ("; $sql2 = ") VALUES ("; $end = ")";
                $valuesArray = array();
                foreach($assocPeriode6mois as $fk => $value)
                {
                    $sql1 .= $fk . ', ';
                    $sql2 .= '?, ';
                    $valuesArray[] = $value;
                }
                $sql = str_replace(", )", ")", $sql1 . $sql2 . $close);
                //remplir table Eleve
                $this->db->prepare($sql)->execute($valuesArray);                
            }
            /* ----------------------------------------------------------------------
             * Inserer Data : Fourchette / Contrat / Fonction / Secteur / Groupe Socio Pro
             * Inserer l'association : Période 6 mois après HETIC / Data
             * ----------------------------------------------------------------------
             * */
            //si l'élève possède des propriétés de cette periode, inserer l'association
            if(count($eleveObj->getAllProperties(null, 'periode_actuelle')) > 0)
            {
                $assocPeriodeActuelle['fk_idPeriode'] = self::$idPeriodeActuelle;
                foreach($eleveObj->getAllProperties(null, 'periode_actuelle') as $key => $value)
                {
                    //si la valeur a été communiquée on insert dans la table
                    if($value !== ConfigData::WORD_NC)
                    {
                        //recup du nom de la table ou inserer la donnée a partir de la key
                        $tmp = explode('__', $key);
                        $tableName = $tmp[1];
                        switch($tableName){
                            //remplir la table fonction
                            case ConfigData::TABLE_FONCTION : 
                                //rempli la fonction
                                $sql = "INSERT INTO $tableName (nom) VALUES ( ? )";
                                $this->db->prepare($sql)->execute([$value]);
                                //get l'id pour assoc Data / Periode
                                $assocPeriodeActuelle['fk_idFonction'] = $this->db->lastInsertId();
                                break;
    
                            //remplir fourchette salaire
                            case ConfigData::TABLE_FOURCHETTE_SAL : 
                                //rempli la fonction
                                $sql = "INSERT INTO $tableName (fourchette) VALUES ( ? )";
                                $this->db->prepare($sql)->execute([$value]);
                                //get l'id pour assoc Data / Periode
                                $assocPeriodeActuelle['fk_idFourchette'] = $this->db->lastInsertId();
                                break;
    
                            //rempli la fourchette secteur
                            case ConfigData::TABLE_SECTEUR :
                                //rempli la fonction
                                $sql = "INSERT INTO $tableName (nom) VALUES ( ? )";
                                $this->db->prepare($sql)->execute([$value]);
                                //get l'id pour assoc Data / Periode
                                $assocPeriodeActuelle['fk_idSecteur'] = $this->db->lastInsertId();
                                break;

                            //rempli la fourchette contrat
                            case ConfigData::TABLE_CONTRAT :
                                //get l'id pour assoc Data / Periode
                                if($value == ConfigData::WORD_CONTRAT_CONTRAT_PRO) 
                                    $assocPeriodeActuelle['fk_idContrat'] = self::$idCddcontratPro; 
                                    break;
                                if($value == ConfigData::WORD_CONTRAT_CDD) 
                                    $assocPeriodeActuelle['fk_idContrat'] = self::$idCdd; 
                                    break;
                                if($value == ConfigData::WORD_CONTRAT_CDI)
                                    $assocPeriodeActuelle['fk_idContrat'] = self::$idCdi; 
                                    break;
                                if($value == ConfigData::WORD_CONTRAT_AUTRE)
                                    $assocPeriodeActuelle['fk_idContrat'] = self::$idAutre; 
                                    break;
                                break;

                            //rempli le groupe soc pro
                            case ConfigData::TABLE_GR_SO_PRO :
                                //get id groupe soc pro pour assoc Data / Periode
                                if($value == ConfigData::WORD_GR_EMPLOYE) 
                                    $assocPeriodeActuelle['fk_idGroupe'] = self::$idGrEmploye; 
                                    break;
                                if($value == ConfigData::WORD_GR_INDEPENDANT)
                                    $assocPeriodeActuelle['fk_idGroupe'] = self::$idGrInde; 
                                    break;
                                if($value == ConfigData::WORD_GR_CADRE) 
                                    $assocPeriodeActuelle['fk_idGroupe'] = self::$idGrCadre; 
                                    break;
                                if($value == ConfigData::WORD_GR_PATRON) 
                                    $assocPeriodeActuelle['fk_idGroupe'] = self::$idGrDir; 
                                    break;
                                break;

                            default : 
                                break;
                            //insertion ds la table assoc_data_periode
                        }
                    }
                }
                //build request
                //insertion ds la table assoc_data_periode
                $sql1 = "INSERT INTO " . ConfigData::TABLE_DATA_PERIODE . " ("; $sql2 = ") VALUES ("; $end = ")";
                $valuesArray = array();
                foreach($assocPeriodeActuelle as $fk => $value)
                {
                    $sql1 .= $fk . ', ';
                    $sql2 .= '?, ';
                    $valuesArray[] = $value;
                }
                $sql = str_replace(", )", ")", $sql1 . $sql2 . $close);
                //remplir table Eleve
                /*var_dump($eleveObj->getAllProperties(null, 'periode_actuelle'));
                var_dump($eleveObj);
                var_dump($assocPeriodeActuelle);
                var_dump($valuesArray);
                var_dump($sql);*/
                $this->db->prepare($sql)->execute($valuesArray);
            }
        }
    }