<?php

namespace src\Dataviz\Entities;

abstract class Entite {

    /* ENTITE ELEVE */
    const UNKNOW_ID = -1;
    const LENGTH_JOB_NOTABLES_EXERCES = 100;
    const LENGTH_ETUDE_AVNT_H = 100;
    const HOMME_ACRONYME = "Mr";
    const FEMME_ACRONYME = "Mme";
    const WORD_PROMO_WEB = "Web";
    const WORD_PROMO_WEB_MARKETING = "Web Marketing";

    /* CONTRAT */
    const WORD_CONTRAT_CONTRAT_PRO = 'CDD contrat pro';
    const WORD_CONTRAT_CDD = 'CDD';
    const WORD_CONTRAT_CDI = 'CDI';
    const WORD_CONTRAT_AUTRE = 'Autre';

    /* GROUPE SOCIO PRO */
    const WORD_GR_EMPLOYE = "Employé";
    const WORD_GR_INDEPENDANT = "Indépendant";
    const WORD_GR_CADRE = "Cadre";
    const WORD_GR_PATRON = "Directeur/Associé";

    /* PERIODE */
    const PERIODE_6MOIS_NAME = '6 mois après';
    const PERIODE_ACTUELLE_NAME = 'Actuelle';

    const WORD_NC = null;

    abstract protected function id();

    abstract protected function setId();
    
    abstract protected function clean();

    abstract protected function isEmpty();
}