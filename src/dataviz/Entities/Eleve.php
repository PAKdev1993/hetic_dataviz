<?php      

namespace App\dataviz\Entities;

use \PhpOffice\PhpSpreadsheet\Shared\Date;

class Eleve extends Entite
{
    private $id;
    private $cursus; //enum ('Web','Web Marketing'),
    private $civilite; //enum ('Mr','Mme')
    private $date_sortie_hetic; //int(4)
    private $ville; //varchar(30)
    private $code_postal_residence; //int(5)
    private $pays; //varchar(20)
    private $annee_promo; //enum ('Web','Web Marketing')
    private $etudes_avant_hetic; //varchar(100)
    private $situation_pro_sortie_hetic; //enum ('Recherche emploi','En activité','En création d'entreprise', 'NC')
    private $jobs_notables_exerces; //varchar(100)

    public function __construct( array $props ) {
        $this->id =                         isset( $props['idEleve'] ) ? $props['idEleve'] : self::UNKNOW_ID;
        $this->cursus =                     $props['cursus'];
        $this->civilite =                   $props['civilite'];
        $this->date_sortie_hetic =          $props['date_sortie_hetic'];
        $this->ville =                      $props['ville'];
        $this->code_postal_residence =      $props['code_postal_residence'];
        $this->pays =                       $props['pays'];
        $this->annee_promo =                $props['annee_promo'];
        $this->etudes_avant_hetic =         $props['etudes_avant_hetic'];
        $this->situation_pro_sortie_hetic = $props['situation_pro_sortie_hetic'];
        $this->jobs_notables_exerces =      $props['jobs_notables_exerces'];

        $this->clean();
    }

    /**
     * GETTERS
     */
    public function id() {
        return $this->id;
    }
    public function cursus() {
        return $this->cursus;
    }
    public function civilite() {
        return $this->civilite;
    }
    public function date_sortie_hetic() {
        return $this->date_sortie_hetic;
    }
    public function ville() {
        return $this->ville;
    }
    public function code_postal_residence() {
        return $this->code_postal_residence;
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
    /**
     * SETTERS
     */
    public function setId($id) {
        $this->id = $id;
    }

    protected function clean() {
        foreach ($this as $prop => $value) {    // How to refer to all the class properties?
            switch($prop){
                case "cursus" : {
                    if(strpos( strtolower($value), 'mark' ) !== false)
                    {
                        $this->{$prop} = self::WORD_PROMO_WEB_MARKETING;
                    }
                    else{
                        $this->{$prop} = self::WORD_PROMO_WEB;
                    }
                    break;
                }
                case "civilite" : {
                    if(strpos( strtolower($value), 'mme' ) !== false)
                    {
                        $this->{$prop} = self::HOMME_ACRONYME;
                    }
                    else{
                        $this->{$prop} = self::FEMME_ACRONYME;
                    }
                    break;
                }
                case "date_sortie_hetic" : {
                    $this->{$prop} = is_null($prop) ? (int) date("Y", Date::excelToTimestamp($value)) : $this->annee_promo; 
                    break;
                }
                case "code_postal_residence" : {
                    $this->{$prop} = $value;
                    break;
                }
                case "ville" : {
                    $this->{$prop} = utf8_encode(ucfirst(strtolower($value)));
                    break;
                }
                case "pays" : {
                    $this->{$prop} = $value;
                    break;
                }
                case "annee_promo" : {
                    $this->{$prop} = (int) $value;
                    break;
                }
                case "etudes_avant_hetic" : {
                    if(strlen($value) <= 2)
                    {
                        $this->{$prop} = self::WORD_NC;
                        break;
                    }
                    if(strpos( $value, '?' ) !== false)
                    {
                        $this->{$prop} = self::WORD_NC;
                        break;
                    }
                    $this->{$prop} = (string) trim(substr($value, 0, self::LENGTH_ETUDE_AVNT_H));
                    break;
                }
                case "situation_pro_sortie_hetic" : {
                    $this->{$prop} = $value;
                    break;
                }
                case "jobs_notables_exerces" : {
                    $this->{$prop} = $this->clean_jobs_notables_exerces($value);
                    break;
                }            
            }
        }
    }

    private function clean_jobs_notables_exerces($value) {
        switch ($index = 0){
            case 0 : 
                $tmp = explode('(', $value);
                if(count($tmp) > 1)
                {
                    $job = trim(substr($tmp[0], 0, self::LENGTH_JOB_NOTABLES_EXERCES));
                    $duree = $tmp[1];
                    break;
                }
            case 1 :
                $tmp = explode('/', $value);
                if(count($tmp) > 1)
                {
                    $job = trim(substr($tmp[0], 0, self::LENGTH_JOB_NOTABLES_EXERCES));
                    $duree = $tmp[1];
                    break;
                }
            case 2 :
                if(strlen($value) <= 3)
                {
                    $job = self::WORD_NC;
                    break;
                }
            default :
                $job = trim(substr($value, 0, self::LENGTH_JOB_NOTABLES_EXERCES));
        }

        return $job;
    }

    protected function isEmpty() { return false; }
}