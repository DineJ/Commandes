-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : mariadb-commandes
-- Généré le : mar. 15 sep. 2026 à 09:05
-- Version du serveur : 11.3.2-MariaDB-1:11.3.2+maria~ubu2204
-- Version de PHP : 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `appdb`
--

-- --------------------------------------------------------

--
-- Structure de la table `assurance`
--

CREATE TABLE `assurance` (
  `id` int(11) NOT NULL,
  `date_contrat` date NOT NULL,
  `nom_assurance` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `assurance`
--

INSERT INTO `assurance` (`id`, `date_contrat`, `nom_assurance`) VALUES
(1, '2025-03-01', 'AXA'),
(2, '2025-02-15', 'EDF');

--
-- Déclencheurs `assurance`
--
DELIMITER $$
CREATE TRIGGER `trg_assurance_date_bu` BEFORE UPDATE ON `assurance` FOR EACH ROW BEGIN
  IF NEW.date_contrat < OLD.date_contrat THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = "La date du nouveau contrat est antérieur à celle de l ancien. Veuillez resaisir votre date.";
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `assurance_vehicule`
--

CREATE TABLE `assurance_vehicule` (
  `id_assurance` int(11) NOT NULL,
  `id_vehicule` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `assurance_vehicule`
--

INSERT INTO `assurance_vehicule` (`id_assurance`, `id_vehicule`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_produit`
--

CREATE TABLE `categorie_produit` (
  `id_categorie` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `date_ajout` date NOT NULL,
  `dlc` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_livreur` int(11) NOT NULL,
  `id_lieu` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `date` date NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commande_produit`
--

CREATE TABLE `commande_produit` (
  `id_commande` int(11) NOT NULL,
  `id_produit` int(11) NOT NULL,
  `quantité` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historique`
--

CREATE TABLE `historique` (
  `id_user` int(11) NOT NULL,
  `id_ip` int(11) NOT NULL,
  `date_dbt` timestamp NOT NULL,
  `date_fin` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `historique`
--

INSERT INTO `historique` (`id_user`, `id_ip`, `date_dbt`, `date_fin`) VALUES
(2, 6, '2026-09-14 09:08:56', '2026-09-14 09:08:56'),
(2, 6, '2026-09-14 09:18:45', '2026-09-14 09:18:58'),
(2, 6, '2026-09-14 09:27:03', '2026-09-14 09:27:03');

-- --------------------------------------------------------

--
-- Structure de la table `historique_prix`
--

CREATE TABLE `historique_prix` (
  `id_produit` int(11) NOT NULL,
  `date_modification` date NOT NULL,
  `prix` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `incident`
--

CREATE TABLE `incident` (
  `id` int(11) NOT NULL,
  `id_vehicule` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_type_incident` int(11) NOT NULL,
  `date_incident` date NOT NULL,
  `explication_incident` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déclencheurs `incident`
--
DELIMITER $$
CREATE TRIGGER `trg_incident_date_bi` BEFORE INSERT ON `incident` FOR EACH ROW BEGIN
  IF NEW.date_incident > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l accident est ultérieur à celle d aujourd hui. Veuillez resaisir vos dates.";
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_incident_date_bu` BEFORE UPDATE ON `incident` FOR EACH ROW BEGIN
  IF NEW.date_incident > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l accident est ultérieur à celle d aujourd hui. Veuillez resaisir vos dates.";
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `infraction`
--

CREATE TABLE `infraction` (
  `id` int(11) NOT NULL,
  `id_mission` int(11) NOT NULL,
  `date_infraction` date NOT NULL,
  `commentaire` text NOT NULL,
  `points` tinyint(3) UNSIGNED NOT NULL,
  `prix` smallint(5) UNSIGNED NOT NULL,
  `stationnement` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déclencheurs `infraction`
--
DELIMITER $$
CREATE TRIGGER `trg_infraction_date_bi` BEFORE INSERT ON `infraction` FOR EACH ROW BEGIN
  IF NEW.date_infraction > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l infraction est ultérieur à celle d aujourd hui. Veuillez resaisir votre date.";
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_infraction_date_bu` BEFORE UPDATE ON `infraction` FOR EACH ROW BEGIN
  IF NEW.date_infraction > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date de l infraction est ultérieur à celle d aujourd hui. Veuillez resaisir votre date.";
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `Ip`
--

CREATE TABLE `Ip` (
  `id` int(11) NOT NULL,
  `adresse_ip` varchar(40) NOT NULL,
  `nb_echec` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Ip`
--

INSERT INTO `Ip` (`id`, `adresse_ip`, `nb_echec`) VALUES
(6, '172.28.0.1', 0);

-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE `lieu` (
  `id` int(11) NOT NULL,
  `nom_lieu` varchar(100) NOT NULL,
  `code_postal` char(5) NOT NULL,
  `numero` int(11) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `actif` tinyint(1) NOT NULL,
  `surnom` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`id`, `nom_lieu`, `code_postal`, `numero`, `adresse`, `actif`, `surnom`) VALUES
(1, 'Paris', '75000', 1, '10 rue de Paris', 1, 'Paris'),
(2, 'Lyon', '69000', 2, '20 avenue des Alpes', 1, 'Lyon'),
(3, 'Marseille', '13000', 3, '30 boulevard Saint-Pierre', 1, 'Marseille'),
(4, 'Toulouse', '31000', 4, '40 rue de la Garonne', 1, 'Toulouse'),
(5, 'Nice', '06000', 5, '50 avenue des Anges', 1, 'Nice');

-- --------------------------------------------------------

--
-- Structure de la table `lieu_user`
--

CREATE TABLE `lieu_user` (
  `id_lieu` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id` int(11) NOT NULL,
  `id_commande` int(11) NOT NULL,
  `id_livreur` int(11) NOT NULL,
  `date_livraison` timestamp NOT NULL,
  `commentaire_livreur` text NOT NULL,
  `commentaire_client` text NOT NULL,
  `signature` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `mission`
--

CREATE TABLE `mission` (
  `id` int(11) NOT NULL,
  `id_vehicule` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_trajet` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déclencheurs `mission`
--
DELIMITER $$
CREATE TRIGGER `trg_mission_dates_bi` BEFORE INSERT ON `mission` FOR EACH ROW BEGIN
  IF NEW.date_arrivee < NEW.date_depart THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date d arrivée est antérieur à celle de départ. Veuillez resaisir votre date.";
  END IF;
  IF NEW.date_depart > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT ="La date de départ est ultérieur à aujourd hui. Veuillez resaisir votre date.";
  END IF;
  IF NEW.km_arrive < NEW.km_depart THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Le kilométrage d arrivé est plus petit que celui de départ. Veuillez resaisir votre nombre.";
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_mission_dates_bu` BEFORE UPDATE ON `mission` FOR EACH ROW BEGIN
  IF NEW.date_arrivee < NEW.date_depart THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date d arrivée est antérieur à celle de départ. Veuillez resaisir votre date.";
  END IF;
  IF NEW.date_depart > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT ="La date de départ est ultérieur à aujourd hui. Veuillez resaisir votre date.";
  END IF;
  IF NEW.km_arrive < NEW.km_depart THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "Le kilométrage d arrivé est plus petit que celui de départ. Veuillez resaisir votre nombre.";
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `permis`
--

CREATE TABLE `permis` (
  `id_user` int(11) NOT NULL,
  `num_permis` char(12) NOT NULL,
  `date_permis` date NOT NULL,
  `update_permis` date NOT NULL,
  `type_permis` enum('B','BE','C','C1','C1E') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `permis`
--

INSERT INTO `permis` (`id_user`, `num_permis`, `date_permis`, `update_permis`, `type_permis`) VALUES
(1, '1234567888', '2025-06-01', '2038-11-03', 'C'),
(2, '1234567900', '2025-09-04', '2025-09-28', 'C');

--
-- Déclencheurs `permis`
--
DELIMITER $$
CREATE TRIGGER `trg_permis_update_date_bu` BEFORE UPDATE ON `permis` FOR EACH ROW BEGIN
  IF NEW.update_permis < OLD.update_permis THEN
    SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = "La date de péremption du permis est antérieur à l ancienne. Veuillez resaisir votre date.";
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `prix` float NOT NULL,
  `quantité` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `suivi`
--

CREATE TABLE `suivi` (
  `id` int(11) NOT NULL,
  `id_incident` int(11) NOT NULL,
  `date_intervention` date NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `id` int(11) NOT NULL,
  `id_lieu_depart` int(11) NOT NULL,
  `id_lieu_arrive` int(11) NOT NULL,
  `date_debut` timestamp NOT NULL,
  `date_arrivee` timestamp NOT NULL,
  `motif` enum('maraude','livraison','repas','demenagement','personnel') DEFAULT 'livraison',
  `km_depart` int(11) NOT NULL,
  `km_arrive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_incident`
--

CREATE TABLE `type_incident` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `critique` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `type_incident`
--

INSERT INTO `type_incident` (`id`, `nom`, `critique`) VALUES
(1, 'Accident', 1),
(2, 'Panne', 0),
(3, 'Fuite', 0),
(4, 'Défectuosité', 0),
(5, 'Problème technique', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

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

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `admin`, `telephone`, `mail`, `actif`, `clef_connexion`) VALUES
(1, 'TOTO', 'TATA', 0, '0123456789', 'toto@gmail.com', 1, 'b188f429056f143854354596583bef63caaa3b18d697f7d4a12b28df6ac44d11'),
(2, 'TITI', 'TUTU', 1, '9876543210', 'titi@gmail.com', 1, 'f5930a61102629c152e9d741fae0105207d834ed2bb09a2d5b5ea127cf6ccb6a');

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

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

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id`, `plaque`, `marque`, `modele`, `date_achat`, `date_immat`, `ct`, `actif`) VALUES
(1, 'BC-234-DE', 'Peugeot', '208', '2021-05-31', '2021-05-31', '2031-05-22', 1),
(2, 'AC-128-SG', 'CITROEN', 'C3', '2025-10-16', '2025-10-31', '2025-11-01', 0);

--
-- Déclencheurs `vehicule`
--
DELIMITER $$
CREATE TRIGGER `trg_vehicule_date_achat_bi` BEFORE INSERT ON `vehicule` FOR EACH ROW BEGIN
  IF NEW.date_achat > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date d'achat est ultérieur à aujourd'hui. Veuillez resaisir votre date.";
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_vehicule_date_achat_bu` BEFORE UPDATE ON `vehicule` FOR EACH ROW BEGIN
  IF NEW.date_achat > CURRENT_DATE() THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = "La date d'achat est ultérieur à aujourd'hui. Veuillez resaisir votre date.";
  END IF;
END
$$
DELIMITER ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `assurance`
--
ALTER TABLE `assurance`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `assurance_vehicule`
--
ALTER TABLE `assurance_vehicule`
  ADD PRIMARY KEY (`id_assurance`,`id_vehicule`),
  ADD KEY `id_vehicule` (`id_vehicule`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie_produit`
--
ALTER TABLE `categorie_produit`
  ADD PRIMARY KEY (`id_categorie`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_livreur` (`id_livreur`),
  ADD KEY `id_lieu` (`id_lieu`),
  ADD KEY `id_categorie` (`id_categorie`);

--
-- Index pour la table `commande_produit`
--
ALTER TABLE `commande_produit`
  ADD PRIMARY KEY (`id_commande`,`id_produit`),
  ADD KEY `id_produit` (`id_produit`);

--
-- Index pour la table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id_user`,`date_dbt`),
  ADD KEY `FK_user` (`id_user`),
  ADD KEY `FK_ip` (`id_ip`) USING BTREE;

--
-- Index pour la table `historique_prix`
--
ALTER TABLE `historique_prix`
  ADD PRIMARY KEY (`id_produit`);

--
-- Index pour la table `incident`
--
ALTER TABLE `incident`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_camion` (`id_vehicule`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_type_accident` (`id_type_incident`);

--
-- Index pour la table `infraction`
--
ALTER TABLE `infraction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_trajet` (`id_mission`);

--
-- Index pour la table `Ip`
--
ALTER TABLE `Ip`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `adresse_ip` (`adresse_ip`);

--
-- Index pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lieu_user`
--
ALTER TABLE `lieu_user`
  ADD PRIMARY KEY (`id_lieu`,`id_user`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_commande` (`id_commande`),
  ADD KEY `id_livreur` (`id_livreur`);

--
-- Index pour la table `mission`
--
ALTER TABLE `mission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_camion` (`id_vehicule`),
  ADD KEY `FK_user` (`id_user`),
  ADD KEY `id_trajet` (`id_trajet`);

--
-- Index pour la table `permis`
--
ALTER TABLE `permis`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `UNIQUE_num_permis` (`num_permis`) USING BTREE;

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `suivi`
--
ALTER TABLE `suivi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_incident` (`id_incident`);

--
-- Index pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_lieu_depart` (`id_lieu_depart`),
  ADD KEY `id_lieu_arrive` (`id_lieu_arrive`);

--
-- Index pour la table `type_incident`
--
ALTER TABLE `type_incident`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE_plaque` (`plaque`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `assurance`
--
ALTER TABLE `assurance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `incident`
--
ALTER TABLE `incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `infraction`
--
ALTER TABLE `infraction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `Ip`
--
ALTER TABLE `Ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `lieu`
--
ALTER TABLE `lieu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `suivi`
--
ALTER TABLE `suivi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `type_incident`
--
ALTER TABLE `type_incident`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `assurance_vehicule`
--
ALTER TABLE `assurance_vehicule`
  ADD CONSTRAINT `assurance_vehicule_ibfk_1` FOREIGN KEY (`id_assurance`) REFERENCES `assurance` (`id`),
  ADD CONSTRAINT `assurance_vehicule_ibfk_2` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`);

--
-- Contraintes pour la table `categorie_produit`
--
ALTER TABLE `categorie_produit`
  ADD CONSTRAINT `categorie_produit_ibfk_1` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `categorie_produit_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `commande_ibfk_2` FOREIGN KEY (`id_livreur`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `commande_ibfk_3` FOREIGN KEY (`id_lieu`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `commande_ibfk_4` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`);

--
-- Contraintes pour la table `commande_produit`
--
ALTER TABLE `commande_produit`
  ADD CONSTRAINT `commande_produit_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `commande_produit_ibfk_2` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `historique`
--
ALTER TABLE `historique`
  ADD CONSTRAINT `fk_ip` FOREIGN KEY (`id_ip`) REFERENCES `Ip` (`id`),
  ADD CONSTRAINT `historique_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `historique_prix`
--
ALTER TABLE `historique_prix`
  ADD CONSTRAINT `historique_prix_ibfk_1` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `incident`
--
ALTER TABLE `incident`
  ADD CONSTRAINT `incident_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`),
  ADD CONSTRAINT `incident_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `incident_ibfk_3` FOREIGN KEY (`id_type_incident`) REFERENCES `type_incident` (`id`);

--
-- Contraintes pour la table `infraction`
--
ALTER TABLE `infraction`
  ADD CONSTRAINT `infraction_ibfk_1` FOREIGN KEY (`id_mission`) REFERENCES `mission` (`id`);

--
-- Contraintes pour la table `lieu_user`
--
ALTER TABLE `lieu_user`
  ADD CONSTRAINT `lieu_user_ibfk_1` FOREIGN KEY (`id_lieu`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `lieu_user_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD CONSTRAINT `livraison_ibfk_1` FOREIGN KEY (`id_commande`) REFERENCES `commande` (`id`),
  ADD CONSTRAINT `livraison_ibfk_2` FOREIGN KEY (`id_livreur`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `mission`
--
ALTER TABLE `mission`
  ADD CONSTRAINT `mission_ibfk_1` FOREIGN KEY (`id_vehicule`) REFERENCES `vehicule` (`id`),
  ADD CONSTRAINT `mission_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `mission_ibfk_3` FOREIGN KEY (`id_trajet`) REFERENCES `trajet` (`id`);

--
-- Contraintes pour la table `permis`
--
ALTER TABLE `permis`
  ADD CONSTRAINT `permis_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `suivi`
--
ALTER TABLE `suivi`
  ADD CONSTRAINT `suivi_ibfk_1` FOREIGN KEY (`id_incident`) REFERENCES `incident` (`id`);

--
-- Contraintes pour la table `trajet`
--
ALTER TABLE `trajet`
  ADD CONSTRAINT `trajet_ibfk_1` FOREIGN KEY (`id_lieu_depart`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `trajet_ibfk_2` FOREIGN KEY (`id_lieu_arrive`) REFERENCES `lieu` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
