-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : mariadb-commandes
-- Généré le : mer. 23 sep. 2026 à 16:45
-- Version du serveur : 11.3.2-MariaDB-1:11.3.2+maria~ubu2204
-- Version de PHP : 8.3.33

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
(1, '2025-03-01', 'AXA');

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
(1, 1);

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
(2, 6, '2026-09-14 09:27:03', '2026-09-14 09:27:03'),
(2, 6, '2026-09-15 15:35:05', '2026-09-15 15:35:20'),
(2, 6, '2026-09-16 09:27:46', '2026-09-16 09:27:46'),
(2, 6, '2026-09-16 15:08:44', '2026-09-16 15:11:17'),
(2, 6, '2026-09-16 17:46:15', '2026-09-16 17:46:46'),
(2, 6, '2026-09-17 09:54:37', '2026-09-17 10:56:07'),
(2, 6, '2026-09-17 10:56:26', '2026-09-17 10:56:26'),
(2, 6, '2026-09-17 11:24:45', '2026-09-17 09:56:04'),
(2, 6, '2026-09-18 10:52:35', '2026-09-18 10:59:46'),
(2, 6, '2026-09-22 10:34:48', '2026-09-22 13:54:12'),
(2, 6, '2026-09-22 13:55:44', '2026-09-22 18:17:18'),
(2, 6, '2026-09-22 18:17:22', '2026-09-22 18:17:22'),
(2, 6, '2026-09-23 10:08:55', '2026-09-23 10:09:32'),
(2, 6, '2026-09-23 13:43:10', '2026-09-23 14:10:37');

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
-- Déchargement des données de la table `incident`
--

INSERT INTO `incident` (`id`, `id_vehicule`, `id_user`, `id_type_incident`, `date_incident`, `explication_incident`) VALUES
(1, 2, 2, 3, '2026-09-22', 'FUITE DE FOU'),
(2, 2, 2, 2, '2026-09-22', 'DD'),
(3, 1, 2, 4, '2026-09-22', 'BC'),
(4, 2, 2, 2, '2026-09-22', 'PANNE'),
(5, 2, 2, 1, '2026-09-22', 'Entretien de routine');

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
-- Déchargement des données de la table `infraction`
--

INSERT INTO `infraction` (`id`, `id_mission`, `date_infraction`, `commentaire`, `points`, `prix`, `stationnement`) VALUES
(1, 1, '2026-09-21', 'PAS DINFRACTION', 4, 135, 1);

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
-- Structure de la table `itineraire`
--

CREATE TABLE `itineraire` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `itineraire`
--

INSERT INTO `itineraire` (`id`, `nom`) VALUES
(1, 'trajet 1'),
(2, 'trajet 2'),
(3, 'trajet 3'),
(4, 'Lyon - Toulouse'),
(5, 'Paris - Lyon'),
(6, 'Paris - Lyon'),
(7, 'Nice - Toulouse - Paris - Toulouse - Marseille'),
(8, 'Marseille - Lyon - Lyon - Nice');

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
  `id_itineraire` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mission`
--

INSERT INTO `mission` (`id`, `id_vehicule`, `id_user`, `id_itineraire`) VALUES
(1, 1, 1, 1);

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

--
-- Déchargement des données de la table `suivi`
--

INSERT INTO `suivi` (`id`, `id_incident`, `date_intervention`, `description`) VALUES
(1, 5, '2026-09-22', '{\"État pneux avants\":{\"etat\":\"Usés\",\"images\":[\"oeil.png\",\"pneu_use.png\"]},\"État pneux arrières\":{\"etat\":\"Usés\",\"images\":[\"oeil.png\",\"pneu_use.png\"]},\"Pression pneux avants\":{\"etat\":\"Gonflés\",\"images\":[\"oeil.png\",\"pneu_pression.png\"]},\"Pression pneux arrières\":{\"etat\":\"Dégonflés\",\"images\":[\"oeil.png\",\"pneu_pression.png\"]},\"Huile moteur\":{\"etat\":\"À remplir\",\"images\":[\"oeil.png\",\"jauge.png\"]},\"Liquide refroidissement\":{\"etat\":\"À remplir\",\"images\":[\"oeil.png\",\"jauge.png\"]},\"Liquide de frein\":{\"etat\":\"À remplir\",\"images\":[\"oeil.png\",\"jauge.png\"]},\"Liquide lave-glace\":{\"etat\":\"À remplir\",\"images\":[\"oeil.png\",\"jauge.png\"]},\"Warning\":{\"etat\":\"Éteints\",\"images\":[\"clignotants.gif\"]},\"Plaque immatriculation avant\":{\"etat\":\"Éteints\",\"images\":[\"plaques.gif\"]},\"Plaque immatricualtion arrière\":{\"etat\":\"Allumés\",\"images\":[\"plaques.gif\"]},\"Feux de stop\":{\"etat\":\"Éteints\",\"images\":[\"feux_stop_recul.png\"]},\"Feux de recul\":{\"etat\":\"Allumés\",\"images\":[\"feux_stop_recul.png\"]},\"Feux de route\":{\"etat\":\"Éteints\",\"images\":[\"feux_croisement_route.png\"]},\"Feux de croisement\":{\"etat\":\"Éteints\",\"images\":[\"feux_croisement_route.png\"]}}');

-- --------------------------------------------------------

--
-- Structure de la table `trajet`
--

CREATE TABLE `trajet` (
  `id` int(11) NOT NULL,
  `id_itineraire` int(11) NOT NULL,
  `id_lieu_depart` int(11) NOT NULL,
  `id_lieu_arrive` int(11) NOT NULL,
  `ordre` tinyint(4) NOT NULL,
  `date_debut` timestamp NOT NULL,
  `date_arrivee` timestamp NOT NULL,
  `motif` enum('maraude','livraison','repas','demenagement','personnel') NOT NULL DEFAULT 'livraison',
  `km_depart` int(11) NOT NULL,
  `km_arrive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `trajet`
--

INSERT INTO `trajet` (`id`, `id_itineraire`, `id_lieu_depart`, `id_lieu_arrive`, `ordre`, `date_debut`, `date_arrivee`, `motif`, `km_depart`, `km_arrive`) VALUES
(1, 1, 2, 5, 1, '2026-06-14 09:08:56', '2026-07-10 09:55:18', 'livraison', 250, 251),
(8, 6, 1, 2, 1, '2026-09-23 00:00:00', '0000-00-00 00:00:00', 'repas', 0, 0),
(9, 7, 5, 4, 1, '2026-10-11 00:00:00', '0000-00-00 00:00:00', 'personnel', 0, 0),
(10, 7, 4, 1, 2, '2026-10-11 00:00:00', '0000-00-00 00:00:00', 'personnel', 0, 0),
(11, 7, 1, 4, 3, '2026-10-11 00:00:00', '0000-00-00 00:00:00', 'personnel', 0, 0),
(12, 7, 4, 3, 4, '2026-10-11 00:00:00', '0000-00-00 00:00:00', 'personnel', 0, 0),
(13, 8, 3, 2, 1, '2026-10-01 00:00:00', '0000-00-00 00:00:00', 'repas', 0, 0),
(14, 8, 2, 2, 2, '2026-10-01 00:00:00', '0000-00-00 00:00:00', 'repas', 0, 0),
(15, 8, 2, 5, 3, '2026-10-01 00:00:00', '0000-00-00 00:00:00', 'repas', 0, 0);

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
(1, 'TOTO', 'TATA', 1, '0123456789', 'toto@gmail.com', 1, 'b188f429056f143854354596583bef63caaa3b18d697f7d4a12b28df6ac44d11'),
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
-- Index pour la table `itineraire`
--
ALTER TABLE `itineraire`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `id_trajet` (`id_itineraire`);

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
  ADD KEY `id_lieu_arrive` (`id_lieu_arrive`),
  ADD KEY `id_itineraire` (`id_itineraire`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `infraction`
--
ALTER TABLE `infraction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `Ip`
--
ALTER TABLE `Ip`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `itineraire`
--
ALTER TABLE `itineraire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `trajet`
--
ALTER TABLE `trajet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
  ADD CONSTRAINT `mission_ibfk_3` FOREIGN KEY (`id_itineraire`) REFERENCES `itineraire` (`id`);

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
  ADD CONSTRAINT `trajet_ibfk_2` FOREIGN KEY (`id_lieu_arrive`) REFERENCES `lieu` (`id`),
  ADD CONSTRAINT `trajet_ibfk_3` FOREIGN KEY (`id_itineraire`) REFERENCES `itineraire` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
