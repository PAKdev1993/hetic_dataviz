<?php

namespace App\dataviz\Entities;

abstract class Entite {

    /* ENTITE ELEVE */
    const UNKNOW_ID = -1;
    const LENGTH_JOB_NOTABLES_EXERCES = 100;
    const LENGTH_ETUDE_AVNT_H = 100;
    const HOMME_ACRONYME = "Mr";
    const FEMME_ACRONYME = "Mme";
    const WORD_PROMO_WEB = "Web";
    const WORD_PROMO_WEB_MARKETING = "Web Marketing";

    /* ENTITE CONTRAT */
    const WORD_CONTRAT_CONTRAT_PRO = 'CDD contrat pro';
    const WORD_CONTRAT_CDD = 'CDD';
    const WORD_CONTRAT_CDI = 'CDI';
    const WORD_CONTRAT_AUTRE = 'Autre';

    /* ENTITE GROUPE SOCIO PRO */
    const WORD_GR_EMPLOYE = "Employé";
    const WORD_GR_INDEPENDANT = "Indépendant";
    const WORD_GR_CADRE = "Cadre";
    const WORD_GR_PATRON = "Directeur/Associé";

    /* ENTITE PERIODE */
    const PERIODE_6MOIS_NAME = '6 mois après';
    const PERIODE_ACTUELLE_NAME = 'Actuelle';

    /* ENTITE FONCTION */
    const WORD_FONCTION_POURSUITE_ETUDE = "Poursuite d'étude";
    const WORD_FONCTION_RECH_EMPLOI = "Recherche d'emploi";

    const WORD_NC = 'NC';

    abstract protected function id();

    abstract protected function setId($id);
    
    abstract protected function clean();

    abstract protected function isEmpty();
}