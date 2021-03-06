DROP TABLE IF EXISTS `eleve`;
CREATE TABLE IF NOT EXISTS `eleve` (
  `idEleve` int(5) NOT NULL AUTO_INCREMENT,
  `civilite` enum ('Mr','Mme'),
  `date_sortie_hetic` int(4),
  `code_postal_residence` int(5),
  `ville` varchar(30),
  `pays` varchar(20),
  `promo` enum ('Web','Web Marketing'),
  `annee_promo` int(4),
  `etudes_avant_hetic` varchar(100),
  `situation_pro_sortie_hetic` enum ('Recherche emploi','En activité',"En création d'entreprise",'NC'),
  `jobs_notables_exerces` varchar(100),
  PRIMARY KEY (`idEleve`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `periode`;
CREATE TABLE IF NOT EXISTS `periode` (
  `idPeriode` int(2) NOT NULL AUTO_INCREMENT,
  `nom` enum ('6 mois après','Actuelle'),
  PRIMARY KEY (`idPeriode`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `periode` (`idPeriode`, `nom`) VALUES
(1, '6 mois après'),
(2, 'Actuelle');


DROP TABLE IF EXISTS `assoc_periode_eleve`;
CREATE TABLE IF NOT EXISTS `assoc_periode_eleve` (
  `fk_idPeriode` int,
  `fk_idEleve` int,
  PRIMARY KEY (`fk_idPeriode`, `fk_idEleve`),
  FOREIGN KEY (`fk_idPeriode`) REFERENCES periode(`idPeriode`),
  FOREIGN KEY (`fk_idEleve`) REFERENCES eleve(`idEleve`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `assoc_data_periode`;
CREATE TABLE IF NOT EXISTS `assoc_data_periode` (
  `idAssoc` int(10) NOT NULL AUTO_INCREMENT,
  `fk_idPeriode` int,
  `fk_idGroupe` int DEFAULT NULL,
  `fk_idFonction` int DEFAULT NULL,
  `fk_idContrat` int DEFAULT NULL,
  `fk_idSecteur` int DEFAULT NULL,
  `fk_idFourchette` int DEFAULT NULL,
  PRIMARY KEY (`idAssoc`, `fk_idPeriode`),
  FOREIGN KEY (`fk_idPeriode`) REFERENCES periode(`idPeriode`),
  FOREIGN KEY (`fk_idFonction`) REFERENCES fonction(`idFonction`),
  FOREIGN KEY (`fk_idGroupe`) REFERENCES groupe_socio_pro(`idGroupe`),
  FOREIGN KEY (`fk_idContrat`) REFERENCES contrat(`idContrat`),
  FOREIGN KEY (`fk_idSecteur`) REFERENCES secteur(`idSecteur`),
  FOREIGN KEY (`fk_idFourchette`) REFERENCES fourchette_salaire(`idFourchette`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `groupe_socio_pro`;
CREATE TABLE IF NOT EXISTS `groupe_socio_pro` (
  `idGroupe` int(2) NOT NULL AUTO_INCREMENT,
  `nom` enum ('Employé','Indépendant','Cadre','Directeur/Associé'),
  PRIMARY KEY (`idGroupe`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `groupe_socio_pro` (`idGroupe`, `nom`) VALUES
(1, 'Employé'),
(3, 'Indépendant'),
(4, 'Cadre'),
(5, 'Directeur/Associé');


DROP TABLE IF EXISTS `fonction`;
CREATE TABLE IF NOT EXISTS `fonction` (
  `idFonction` int(31) NOT NULL AUTO_INCREMENT,
  `nom` varchar(90),
  PRIMARY KEY (`idFonction`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `contrat`;
CREATE TABLE IF NOT EXISTS `contrat` (
  `idContrat` int(11) NOT NULL AUTO_INCREMENT,
  `nom` enum ('CDD contrat pro','CDD','CDI','Autre'),
  PRIMARY KEY (`idContrat`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

INSERT INTO `contrat` (`idContrat`, `nom`) VALUES
(1, 'CDD contrat pro'),
(2, 'CDD'),
(3, 'CDI'),
(4, 'Autre');


DROP TABLE IF EXISTS `secteur`;
CREATE TABLE IF NOT EXISTS `secteur` (
  `idSecteur` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50),
  PRIMARY KEY (`idSecteur`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `fourchette_salaire`;
CREATE TABLE IF NOT EXISTS `fourchette_salaire` (
  `idFourchette` int(11) NOT NULL AUTO_INCREMENT,
  `fourchette` varchar(17),
  PRIMARY KEY (`idFourchette`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
