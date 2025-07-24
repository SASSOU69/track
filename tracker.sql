-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 24 juil. 2025 à 13:55
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tracker`
--

-- --------------------------------------------------------

--
-- Structure de la table `candidatures`
--

DROP TABLE IF EXISTS `candidatures`;
CREATE TABLE IF NOT EXISTS `candidatures` (
  `id` int NOT NULL AUTO_INCREMENT,
  `poste` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `entreprise` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `date` date NOT NULL,
  `statut` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `cv` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `USER_ID` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `candidatures`
--

INSERT INTO `candidatures` (`id`, `poste`, `entreprise`, `date`, `statut`, `cv`, `notes`, `user_id`) VALUES
(1, 'Développeur PHP', 'Société A', '2025-07-01', 'Acceptée', NULL, 'Poste accepté, signature du contrat prévue le 22 juillet.', 1),
(2, 'Intégrateur Web', 'Société B', '2025-06-20', 'Relancée', NULL, 'Premier mail resté sans réponse, relance envoyée le 12 juillet.', 1),
(3, 'Chef de projet', 'Société C', '2025-05-30', 'En attente', NULL, 'Candidature envoyée le 5 juillet. Pas encore de réponse.', 1),
(4, 'UX Designer', 'Startup D', '2025-07-05', 'Refusée', NULL, 'Refus sans justification, poste pourvu en interne.', 1),
(6, 'Développeur Frontend', 'OpenAI', '2025-07-01', 'Entretien', NULL, 'Entretien prévu le 18 juillet à 10h via Zoom. Préparer étude de cas.', 1),
(7, 'Développeur Frontend', 'OpenTech', '2025-06-01', 'En attente', NULL, 'Premier contact par mail.', 1),
(8, 'Chef de projet', 'DigitalCorp', '2025-06-10', 'Entretien', NULL, 'Entretien prévu le 25 juin.', 1),
(9, 'Analyste données', 'DataSolutions', '2025-06-15', 'Refusée', NULL, 'Profil trop junior pour ce poste.', 1),
(10, 'Ingénieur QA', 'SoftWareHouse', '2025-06-20', 'Acceptée', NULL, 'Offre acceptée, début en juillet.', 1),
(11, 'Consultant IT', 'TechConsult', '2025-07-01', 'Relancée', NULL, 'Relance envoyée suite au silence.', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$z...exempleDeHash...T3q'),
(2, 'toto@gmail.com', '$2y$10$cVoIzNKFgTRsXDvX48yfi.u11FtTIJLgEfbMaRdhvfa0kzCAYJXWK');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD CONSTRAINT `candidatures_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
