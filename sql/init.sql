CREATE TABLE `Ip` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `adresse_ip` VARCHAR(40) NOT NULL,
  `nb_echec` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `adresse_ip` (`adresse_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `Ip` WRITE;
INSERT INTO `Ip` (`id`,`adresse_ip`,`nb_echec`) VALUES
(3,'127.0.0.1',0),
(4,'192.168.0.1',0);
UNLOCK TABLES;


CREATE TABLE `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(50) NOT NULL,
  `prenom` VARCHAR(50) NOT NULL,
  `admin` TINYINT(1) NOT NULL DEFAULT 0,
  `telephone` CHAR(10) NOT NULL,
  `mail` VARCHAR(100) NOT NULL,
  `actif` TINYINT(1) NOT NULL DEFAULT 1,
  `clef_connexion` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `user` WRITE;
INSERT INTO `user` VALUES
(1,'TOTO','TATA',0,'0123456789','toto@gmail.com',1,'b188f429056f143854354596583bef63caaa3b18d697f7d4a12b28df6ac44d11'),
(2,'TITI','TUTU',1,'9876543210','titi@gmail.com',1,'9d2c596705b928184505b9451b5db2d6268689d27c22a99df06ae9c1ecc3682e');
UNLOCK TABLES;


CREATE TABLE `vehicule` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `plaque` CHAR(255) NOT NULL,
  `marque` VARCHAR(50) NOT NULL,
  `modele` VARCHAR(50) NOT NULL,
  `date_achat` DATE NOT NULL,
  `date_immat` DATE NOT NULL,
  `ct` DATE NOT NULL,
  `actif` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQUE_plaque` (`plaque`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `vehicule` WRITE;
INSERT INTO `vehicule` VALUES
(1,'BC-234-DE','Peugeot','208','2021-05-31','2021-05-31','2031-05-22',1),
(2,'AC-128-SG','CITROEN','C3','2025-10-16','2025-10-31','2025-11-01',0);
UNLOCK TABLES;

DELIMITER //
CREATE TRIGGER trg_vehicule_date_achat_bi BEFORE INSERT ON vehicule
FOR EACH ROW
BEGIN
  IF NEW.date_achat > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date d'achat est ultérieur à aujourd'hui. Veuillez resaisir votre date.";
  END IF;
END//
CREATE TRIGGER trg_vehicule_date_achat_bu BEFORE UPDATE ON vehicule
FOR EACH ROW
BEGIN
  IF NEW.date_achat > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date d'achat est ultérieur à aujourd'hui. Veuillez resaisir votre date.";
  END IF;
END//
DELIMITER ;

CREATE TABLE `type_incident` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(255) NOT NULL,
  `critique` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `type_incident` WRITE;
INSERT INTO `type_incident` VALUES
(1,'Accident',1),
(2,'Panne',0),
(3,'Fuite',0),
(4,'Défectuosité',0),
(5,'Problème technique',0);
UNLOCK TABLES;


CREATE TABLE `assurance` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `date_contrat` DATE NOT NULL,
  `nom_assurance` VARCHAR(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `assurance` WRITE;
INSERT INTO `assurance` VALUES
(1,'2025-03-01', 'AXA'),
(2,'2025-02-15', 'EDF');
UNLOCK TABLES;

DELIMITER //
CREATE TRIGGER trg_assurance_date_bu BEFORE UPDATE ON assurance
FOR EACH ROW
BEGIN
  IF NEW.date_contrat < OLD.date_contrat THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = "La date du nouveau contrat est antérieur à celle de l ancien. Veuillez resaisir votre date.";
  END IF;
END//
DELIMITER ;


CREATE TABLE `assurance_vehicule` (
  `id_assurance` INT(11) NOT NULL,
  `id_vehicule` INT(11) NOT NULL,
  PRIMARY KEY (`id_assurance`,`id_vehicule`),
  KEY `id_vehicule` (`id_vehicule`),
  CONSTRAINT `assurance_vehicule_ibfk_1` FOREIGN KEY (`id_assurance`) REFERENCES `assurance` (`id`),
  CONSTRAINT `assurance_vehicule_ibfk_2` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `assurance_vehicule` WRITE;
INSERT INTO `assurance_vehicule` VALUES
(1,1),
(2,2);
UNLOCK TABLES;


CREATE TABLE `lieu` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `nom_lieu` VARCHAR(100) NOT NULL,
  `code_postal` CHAR(5) NOT NULL,
  `numero` INT(11) NOT NULL,
  `adresse` VARCHAR(255) NOT NULL,
  `actif` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `lieu` WRITE;
INSERT INTO `lieu` VALUES
(1,'Paris','75000',1,'10 rue de Paris',1),
(2,'Lyon','69000',2,'20 avenue des Alpes',1),
(3,'Marseille','13000',3,'30 boulevard Saint-Pierre',1),
(4,'Toulouse','31000',4,'40 rue de la Garonne',1),
(5,'Nice','06000',5,'50 avenue des Anges',1);
UNLOCK TABLES;


CREATE TABLE `mission` (
  `id` INT(11) NOT NULL,
  `id_vehicule` INT(11) NOT NULL,
  `id_user` INT(11) NOT NULL,
  `id_lieu_depart` INT(11) NOT NULL,
  `id_lieu_arrive` INT(11) NOT NULL,
  `motif` ENUM('maraude','livraison','repas','demenagement','personnel') NOT NULL,
  `date_depart` DATE NOT NULL,
  `date_arrivee` DATE NOT NULL,
  `km_depart` INT(11) NOT NULL,
  `km_arrive` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_camion` (`id_vehicule`),
  KEY `FK_user` (`id_user`),
  KEY `FK_lieu_depart` (`id_lieu_depart`),
  KEY `FK_lieu_arrive` (`id_lieu_arrive`),
  CONSTRAINT `mission_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`),
  CONSTRAINT `mission_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  CONSTRAINT `mission_ibfk_3` FOREIGN KEY (`id_lieu_depart`) REFERENCES `lieu` (`id`),
  CONSTRAINT `mission_ibfk_4` FOREIGN KEY (`id_lieu_arrive`) REFERENCES `lieu` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER //
CREATE TRIGGER trg_mission_dates_bi BEFORE INSERT ON mission
FOR EACH ROW
BEGIN
  IF NEW.date_arrivee < NEW.date_depart THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date d arrivée est antérieur à celle de départ. Veuillez resaisir votre date.";
  END IF;
  IF NEW.date_depart > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT ="La date de départ est ultérieur à aujourd hui. Veuillez resaisir votre date.";
  END IF;
  IF NEW.km_arrive < NEW.km_depart THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Le kilométrage d arrivé est plus petit que celui de départ. Veuillez resaisir votre nombre.";
  END IF;
END//
CREATE TRIGGER trg_mission_dates_bu BEFORE UPDATE ON mission
FOR EACH ROW
BEGIN
  IF NEW.date_arrivee < NEW.date_depart THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date d arrivée est antérieur à celle de départ. Veuillez resaisir votre date.";
  END IF;
  IF NEW.date_depart > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT ="La date de départ est ultérieur à aujourd hui. Veuillez resaisir votre date.";
  END IF;
  IF NEW.km_arrive < NEW.km_depart THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Le kilométrage d arrivé est plus petit que celui de départ. Veuillez resaisir votre nombre.";
  END IF;
END//
DELIMITER ;


CREATE TABLE `incident` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_vehicule` INT(11) NOT NULL,
  `id_user` INT(11) NOT NULL,
  `id_type_incident` INT(11) NOT NULL,
  `date_incident` DATE NOT NULL,
  `explication_incident` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_camion` (`id_vehicule`),
  KEY `id_user` (`id_user`),
  KEY `id_type_accident` (`id_type_incident`),
  CONSTRAINT `incident_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`),
  CONSTRAINT `incident_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  CONSTRAINT `incident_ibfk_3` FOREIGN KEY (`id_type_incident`) REFERENCES `type_incident` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER //
CREATE TRIGGER trg_incident_date_bi BEFORE INSERT ON incident
FOR EACH ROW
BEGIN
  IF NEW.date_incident > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l accident est ultérieur à celle d aujourd hui. Veuillez resaisir vos dates.";
  END IF;
END//
CREATE TRIGGER trg_incident_date_bu BEFORE UPDATE ON incident
FOR EACH ROW
BEGIN
  IF NEW.date_incident > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l accident est ultérieur à celle d aujourd hui. Veuillez resaisir vos dates.";
  END IF;
END//
DELIMITER ;

LOCK TABLES `incident` WRITE;
UNLOCK TABLES;

CREATE TABLE `infraction` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_mission` INT(11) NOT NULL,
  `date_infraction` DATE NOT NULL,
  `commentaire` TEXT NOT NULL,
  `points` TINYINT(3) UNSIGNED NOT NULL,
  `prix` SMALLINT(5) UNSIGNED NOT NULL,
  `stationnement` TINYINT(1) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_trajet` (`id_mission`),
  CONSTRAINT `infraction_ibfk_1` FOREIGN KEY (`id_mission`) REFERENCES `mission` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

DELIMITER //
CREATE TRIGGER trg_infraction_date_bi BEFORE INSERT ON infraction
FOR EACH ROW
BEGIN
  IF NEW.date_infraction > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l infraction est ultérieur à celle d aujourd hui. Veuillez resaisir votre date.";
  END IF;
END//
CREATE TRIGGER trg_infraction_date_bu BEFORE UPDATE ON infraction
FOR EACH ROW
BEGIN
  IF NEW.date_infraction > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l infraction est ultérieur à celle d aujourd hui. Veuillez resaisir votre date.";
  END IF;
END//
DELIMITER ;

LOCK TABLES `infraction` WRITE;
UNLOCK TABLES;


CREATE TABLE `permis` (
  `id_user` INT(11) NOT NULL,
  `num_permis` CHAR(12) NOT NULL,
  `date_permis` DATE NOT NULL,
  `update_permis` DATE NOT NULL,
  `type_permis` ENUM('B','BE','C','C1','C1E') NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `UNIQUE_num_permis` (`num_permis`) USING BTREE,
  CONSTRAINT `permis_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `permis` WRITE;
INSERT INTO `permis` VALUES
(1,'1234567888','2025-06-01','2038-11-03','C'),
(2,'1234567900','2025-09-04','2025-09-28','C');
UNLOCK TABLES;

DELIMITER //
CREATE TRIGGER trg_permis_update_date_bu BEFORE UPDATE ON permis
FOR EACH ROW
BEGIN
  IF NEW.update_permis < OLD.update_permis THEN
    SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = "La date de péremption du permis est antérieur à l ancienne. Veuillez resaisir votre date.";
  END IF;
END//
DELIMITER ;


CREATE TABLE `historique` (
  `id_user` INT(11) NOT NULL,
  `id_ip` INT(11) NOT NULL,
  `date_dbt` TIMESTAMP NOT NULL,
  `date_fin` TIMESTAMP NOT NULL,
  PRIMARY KEY (`id_user`,`date_dbt`),
  KEY `FK_user` (`id_user`),
  KEY `FK_ip` (`id_ip`) USING BTREE,
  CONSTRAINT `fk_ip` FOREIGN KEY (`id_ip`) REFERENCES `Ip` (`id`),
  CONSTRAINT `historique_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `historique` WRITE;
UNLOCK TABLES;


CREATE TABLE `suivi` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `id_incident` INT(11) NOT NULL,
  `date_intervention` DATE NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_incident` (`id_incident`),
  CONSTRAINT `suivi_ibfk_1` FOREIGN KEY (`id_incident`) REFERENCES `incident` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `suivi` WRITE;
UNLOCK TABLES;
