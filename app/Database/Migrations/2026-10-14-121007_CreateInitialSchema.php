<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

/**
 * Initial database schema generated from appdb(3).sql.
 * Creates structure only: no INSERT statements or example data.
 * Target: MariaDB / MySQL. Run on an EMPTY database.
 */
class CreateInitialSchema extends Migration
{
    public function up()
    {
        // Tables first, then indexes/auto-increments, foreign keys, and triggers.
        $statements = [
            <<<'SQL'
CREATE TABLE `assurance` (
  `id` int(11) NOT NULL,
  `date_contrat` date NOT NULL,
  `nom_assurance` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `assurance_vehicule` (
  `id_assurance` int(11) NOT NULL,
  `id_vehicule` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `categorie_produit` (
  `id_categorie` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `date_ajout` date NOT NULL,
  `dlc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_livreur` int(11) NOT NULL,
  `id_lieu` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `date` date NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `commande_produit` (
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantité` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `historique` (
  `id_user` int(11) NOT NULL,
  `id_ip` int(11) NOT NULL,
  `date_dbt` timestamp NOT NULL,
  `date_fin` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `historique_prix` (
  `id_produit` int(11) NOT NULL,
  `date_modification` date NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `incident` (
  `id` int(11) NOT NULL,
  `id_vehicule` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_type_incident` int(11) NOT NULL,
  `date_incident` date NOT NULL,
  `explication_incident` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `infraction` (
  `id` int(11) NOT NULL,
  `id_mission` int(11) NOT NULL,
  `date_infraction` date NOT NULL,
  `commentaire` text NOT NULL,
  `points` tinyint(3) UNSIGNED NOT NULL,
  `prix` smallint(5) UNSIGNED NOT NULL,
  `stationnement` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `Ip` (
  `id` int(11) NOT NULL,
  `adresse_ip` varchar(40) NOT NULL,
  `nb_echec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `itineraire` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `motif` enum('maraude','livraison','repas','demenagement','personnel') NOT NULL DEFAULT 'livraison'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `lieu` (
  `id` int(11) NOT NULL,
  `nom_lieu` varchar(100) NOT NULL,
  `code_postal` char(5) NOT NULL,
  `numero` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `actif` tinyint(1) NOT NULL,
  `surnom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `lieu_user` (
  `id_lieu` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `livraison` (
  `id` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_livreur` int(11) NOT NULL,
  `date_livraison` timestamp NOT NULL,
  `commentaire_livreur` text NOT NULL,
  `commentaire_client` text NOT NULL,
  `signature` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `mission` (
  `id` int(11) NOT NULL,
  `id_vehicule` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_itineraire` int(11) NOT NULL,
  `km_depart` int(11) NOT NULL,
  `km_arrive` int(11) NOT NULL,
  `date_debut` timestamp NOT NULL,
  `date_arrivee` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `permis` (
  `id_user` int(11) NOT NULL,
  `num_permis` char(12) NOT NULL,
  `date_permis` date NOT NULL,
  `update_permis` date NOT NULL,
  `type_permis` enum('B','BE','C','C1','C1E') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prix` float NOT NULL,
  `quantité` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `suivi` (
  `id` int(11) NOT NULL,
  `id_incident` int(11) NOT NULL,
  `date_intervention` date NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `trajet` (
  `id` int(11) NOT NULL,
  `id_itineraire` int(11) NOT NULL,
  `id_lieu_depart` int(11) NOT NULL,
  `id_lieu_arrive` int(11) NOT NULL,
  `ordre` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `type_incident` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `critique` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `telephone` char(10) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT 1,
  `clef_connexion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
CREATE TABLE `vehicule` (
  `id` int(11) NOT NULL,
  `plaque` char(255) NOT NULL,
  `marque` varchar(50) NOT NULL,
  `modele` varchar(50) NOT NULL,
  `date_achat` date NOT NULL,
  `date_immat` date NOT NULL,
  `ct` date NOT NULL,
  `actif` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
SQL,
            <<<'SQL'
ALTER TABLE `assurance`
  ADD PRIMARY KEY (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `assurance_vehicule`
  ADD PRIMARY KEY (`id_assurance`,`id_vehicule`),
  ADD KEY `id_vehicule` (`id_vehicule`);
SQL,
            <<<'SQL'
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `categorie_produit`
  ADD PRIMARY KEY (`id_categorie`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);
SQL,
            <<<'SQL'
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_livreur` (`id_livreur`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_categorie` (`id_categorie`);
SQL,
            <<<'SQL'
ALTER TABLE `commande_produit`
  ADD PRIMARY KEY (`id_commande`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);
SQL,
            <<<'SQL'
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id_user`,`date_dbt`),
  ADD KEY `FK_user` (`id_user`),
  ADD KEY `FK_ip` (`id_ip`) USING BTREE;
SQL,
            <<<'SQL'
ALTER TABLE `historique_prix`
  ADD PRIMARY KEY (`id_produit`);
SQL,
            <<<'SQL'
ALTER TABLE `incident`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_camion` (`id_vehicule`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_type_accident` (`id_type_incident`);
SQL,
            <<<'SQL'
ALTER TABLE `infraction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_trajet` (`id_mission`);
SQL,
            <<<'SQL'
ALTER TABLE `Ip`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adresse_ip` (`adresse_ip`);
SQL,
            <<<'SQL'
ALTER TABLE `itineraire`
  ADD PRIMARY KEY (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `lieu_user`
  ADD PRIMARY KEY (`id_lieu`,`id_user`),
  ADD KEY `id_user` (`id_user`);
SQL,
            <<<'SQL'
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_livreur` (`id_livreur`);
SQL,
            <<<'SQL'
ALTER TABLE `mission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_camion` (`id_vehicule`),
  ADD KEY `FK_user` (`id_user`),
  ADD KEY `id_trajet` (`id_itineraire`);
SQL,
            <<<'SQL'
ALTER TABLE `permis`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `UNIQUE_num_permis` (`num_permis`) USING BTREE;
SQL,
            <<<'SQL'
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `suivi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_incident` (`id_incident`);
SQL,
            <<<'SQL'
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lieu_depart` (`id_lieu_depart`),
  ADD KEY `id_lieu_arrive` (`id_lieu_arrive`),
  ADD KEY `id_itineraire` (`id_itineraire`);
SQL,
            <<<'SQL'
ALTER TABLE `type_incident`
  ADD PRIMARY KEY (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_plaque` (`plaque`) USING BTREE;
SQL,
            <<<'SQL'
ALTER TABLE `assurance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `infraction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `Ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `itineraire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `livraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `suivi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `trajet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `type_incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `vehicule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
SQL,
            <<<'SQL'
ALTER TABLE `assurance_vehicule`
  ADD CONSTRAINT `assurance_vehicule_ibfk_1` FOREIGN KEY (`id_assurance`) REFERENCES `assurance` (`id`),
  ADD CONSTRAINT `assurance_vehicule_ibfk_2` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `categorie_produit`
  ADD CONSTRAINT `categorie_produit_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `categorie_produit_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_livreur`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `commande_ibfk_3` FOREIGN KEY (`id_lieu`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `commande_ibfk_4` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `commande_produit`
  ADD CONSTRAINT `commande_produit_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `commande_produit_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `historique`
  ADD CONSTRAINT `fk_ip` FOREIGN KEY (`id_ip`) REFERENCES `Ip` (`id`),
  ADD CONSTRAINT `historique_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `historique_prix`
  ADD CONSTRAINT `historique_prix_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `incident`
  ADD CONSTRAINT `incident_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`),
  ADD CONSTRAINT `incident_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `incident_ibfk_3` FOREIGN KEY (`id_type_incident`) REFERENCES `type_incident` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `infraction`
  ADD CONSTRAINT `infraction_ibfk_1` FOREIGN KEY (`id_mission`) REFERENCES `mission` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `lieu_user`
  ADD CONSTRAINT `lieu_user_ibfk_1` FOREIGN KEY (`id_lieu`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `lieu_user_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `livraison`
  ADD CONSTRAINT `livraison_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `livraison_ibfk_2` FOREIGN KEY (`id_livreur`) REFERENCES `user` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `mission`
  ADD CONSTRAINT `mission_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`),
  ADD CONSTRAINT `mission_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `mission_ibfk_3` FOREIGN KEY (`id_itineraire`) REFERENCES `itineraire` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `permis`
  ADD CONSTRAINT `permis_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `suivi`
  ADD CONSTRAINT `suivi_ibfk_1` FOREIGN KEY (`id_incident`) REFERENCES `incident` (`id`);
SQL,
            <<<'SQL'
ALTER TABLE `trajet`
  ADD CONSTRAINT `trajet_ibfk_1` FOREIGN KEY (`id_lieu_depart`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `trajet_ibfk_2` FOREIGN KEY (`id_lieu_arrive`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `trajet_ibfk_3` FOREIGN KEY (`id_itineraire`) REFERENCES `itineraire` (`id`);
SQL,
            <<<'SQL'
CREATE TRIGGER `trg_assurance_date_bu` BEFORE UPDATE ON `assurance` FOR EACH ROW BEGIN
  IF NEW.date_contrat < OLD.date_contrat THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = "La date du nouveau contrat est antérieur à celle de l ancien. Veuillez resaisir votre date.";
  END IF;
END
SQL,
            <<<'SQL'
CREATE TRIGGER `trg_incident_date_bi` BEFORE INSERT ON `incident` FOR EACH ROW BEGIN
  IF NEW.date_incident > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l accident est ultérieur à celle d aujourd hui. Veuillez resaisir vos dates.";
  END IF;
END
SQL,
            <<<'SQL'
CREATE TRIGGER `trg_incident_date_bu` BEFORE UPDATE ON `incident` FOR EACH ROW BEGIN
  IF NEW.date_incident > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l accident est ultérieur à celle d aujourd hui. Veuillez resaisir vos dates.";
  END IF;
END
SQL,
            <<<'SQL'
CREATE TRIGGER `trg_infraction_date_bi` BEFORE INSERT ON `infraction` FOR EACH ROW BEGIN
  IF NEW.date_infraction > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l infraction est ultérieur à celle d aujourd hui. Veuillez resaisir votre date.";
  END IF;
END
SQL,
            <<<'SQL'
CREATE TRIGGER `trg_infraction_date_bu` BEFORE UPDATE ON `infraction` FOR EACH ROW BEGIN
  IF NEW.date_infraction > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l infraction est ultérieur à celle d aujourd hui. Veuillez resaisir votre date.";
  END IF;
END
SQL,
            <<<'SQL'
CREATE TRIGGER `trg_permis_update_date_bu` BEFORE UPDATE ON `permis` FOR EACH ROW BEGIN
  IF NEW.update_permis < OLD.update_permis THEN
    SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = "La date de péremption du permis est antérieur à l ancienne. Veuillez resaisir votre date.";
  END IF;
END
SQL,
            <<<'SQL'
CREATE TRIGGER `trg_vehicule_date_achat_bi` BEFORE INSERT ON `vehicule` FOR EACH ROW BEGIN
  IF NEW.date_achat > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date d'achat est ultérieur à aujourd'hui. Veuillez resaisir votre date.";
  END IF;
END
SQL,
            <<<'SQL'
CREATE TRIGGER `trg_vehicule_date_achat_bu` BEFORE UPDATE ON `vehicule` FOR EACH ROW BEGIN
  IF NEW.date_achat > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date d'achat est ultérieur à aujourd'hui. Veuillez resaisir votre date.";
  END IF;
END
SQL,
        ];

        foreach ($statements as $statement) {
            $this->db->query($statement);
        }
    }

    public function down()
    {
        // Remove triggers and foreign-key constraints along with their tables.
        $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
        try {
            $this->db->query('DROP TABLE IF EXISTS `vehicule`');
            $this->db->query('DROP TABLE IF EXISTS `user`');
            $this->db->query('DROP TABLE IF EXISTS `type_incident`');
            $this->db->query('DROP TABLE IF EXISTS `trajet`');
            $this->db->query('DROP TABLE IF EXISTS `suivi`');
            $this->db->query('DROP TABLE IF EXISTS `produit`');
            $this->db->query('DROP TABLE IF EXISTS `permis`');
            $this->db->query('DROP TABLE IF EXISTS `mission`');
            $this->db->query('DROP TABLE IF EXISTS `livraison`');
            $this->db->query('DROP TABLE IF EXISTS `lieu_user`');
            $this->db->query('DROP TABLE IF EXISTS `lieu`');
            $this->db->query('DROP TABLE IF EXISTS `itineraire`');
            $this->db->query('DROP TABLE IF EXISTS `Ip`');
            $this->db->query('DROP TABLE IF EXISTS `infraction`');
            $this->db->query('DROP TABLE IF EXISTS `incident`');
            $this->db->query('DROP TABLE IF EXISTS `historique_prix`');
            $this->db->query('DROP TABLE IF EXISTS `historique`');
            $this->db->query('DROP TABLE IF EXISTS `commande_produit`');
            $this->db->query('DROP TABLE IF EXISTS `commande`');
            $this->db->query('DROP TABLE IF EXISTS `categorie_produit`');
            $this->db->query('DROP TABLE IF EXISTS `categorie`');
            $this->db->query('DROP TABLE IF EXISTS `assurance_vehicule`');
            $this->db->query('DROP TABLE IF EXISTS `assurance`');
        } finally {
            $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
        }
    }
}
