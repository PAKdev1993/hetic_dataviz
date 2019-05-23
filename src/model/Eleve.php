<?php      

    class Eleve {

        const UNKNOW_ID = -1;
        const LENGTH_JOB_NOTABLES_EXERCES = 100;
        const LENGTH_ETUDE_AVNT_H = 100;
        const HOMME_ACRONYME = "Mr";
        const FEMME_ACRONYME = "Mme";
        const WORD_PROMO_WEB = "Web";
        const WORD_PROMO_WEB_MARKETING = "Web Marketing";

        const WORD_NC = null;

        private $id;
        private $promo; //enum ('Web','Web Marketing'),
        private $civilite; //enum ('Mr','Mme')
        private $date_sortie_hetic; //int(4)
        private $ville; //varchar(30)
        private $code_postal_residence; //int(5)
        private $pays; //varchar(20)
        private $annee_promo; //enum ('Web','Web Marketing')
        private $etudes_avant_hetic; //varchar(100)
        private $situation_pro_sortie_hetic; //enum ('Recherche emploi','En activité','En création d'entreprise', 'NC')
        private $jobs_notables_exerces; //varchar(100)

        /*private $props_periode_6_mois__groupe_socio_pro; //enum ('Employé','Indépendant','Cadre','NC')
        private $props_periode_actuelle__groupe_socio_pro; //enum ('Employé','Indépendant','Cadre','NC')

        private $props_periode_6_mois__fonction; //varchar(50)
        private $props_periode_actuelle__fonction; //varchar(50)

        private $props_periode_6_mois__contrat; //enum ('CDD contrat pro','CDD','CDI','Autre')
        private $props_periode_actuelle__contrat; //enum ('CDD contrat pro','CDD','CDI','Autre')

        private $props_periode_6_mois__secteur; //varchar(50)
        private $props_periode_actuelle__secteur; //varchar(50)

        private $props_periode_6_mois__fourchette_salaire; //varchar(17)
        private $props_periode_actuelle__fourchette_salaire; //varchar(17)
        */

        private $cleaner;

        public function __construct( array $props ) {
            $this->promo =                      isset( $props['id'] ) ? $props['id'] : self::UNKNOW_ID;
            $this->promo =                      $props['promo'];
            $this->civilite =                   $props['civilite'];
            $this->date_sortie_hetic =          $props['date_sortie_hetic'];
            $this->ville =                      $props['ville'];
            $this->code_postal_residence =      $props['code_postal_residence'];
            $this->pays =                       $props['pays'];
            $this->annee_promo =                $props['annee_promo'];
            $this->etudes_avant_hetic =         $props['etudes_avant_hetic'];
            $this->situation_pro_sortie_hetic = $props['situation_pro_sortie_hetic'];
            $this->jobs_notables_exerces =      $props['jobs_notables_exerces'];

            $this->cleaner = $cleaner;
            $this->cleaner->cleanProperties($this);
        }

        /**
         * GETTERS
         */
        public function promo() {
            return $this->promo;
        }
        public function civilite() {
            return $this->civilite;
        }
        public function pays() {
            return $this->pays;
        }
        public function annee_promo() {
            return $this->annee_promo;
        }
        public function etudes_avant_hetic() {
            return $this->etudes_avant_hetic;
        }
        public function situation_pro_sortie_hetic() {
            return $this->situation_pro_sortie_hetic;
        }
        public function jobs_notables_exerces() {
            return $this->jobs_notables_exerces;
        }

        public function getAllProperties($prefix = null, $filter = null)
        {
            $objProperties = array();
            foreach ($this as $key => $value) {
                switch($filter){                        
                    //discrimination des valeurs uniquement réservé aux infos de la table élève
                    case 'eleve' :
                        if(strpos( $key, "props" ) === false && $key !== "cleaner") 
                            $objProperties[$prefix . $key] = $value;
                        break;
                    //discrimination des valeurs uniquement réservé aux infos liés à la periode
                    case "periode_6_mois" :
                        if(strpos( $key, "periode_6_mois" ) !== false && $value !== ConfigData::WORD_NC) $objProperties[$prefix . $key] = $value;
                        break;
                    //discrimination des valeurs uniquement réservé aux infos liés à la periode
                    case "periode_actuelle" : 
                        if(strpos( $key, "periode_actuelle" ) !== false && $value !== ConfigData::WORD_NC) $objProperties[$prefix . $key] = $value;
                        break;
                    default :
                        $objProperties[$prefix . $key] = $value;
                        break;
                }
            }
            return $objProperties;
        }

        /*public function cleanProperties()
        {
            $this->cleaner->cleanProps($this);
        }*/
    }