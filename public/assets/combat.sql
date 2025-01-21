-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 21 jan. 2025 à 10:06
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `combat`
--

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

DROP TABLE IF EXISTS `competence`;
CREATE TABLE IF NOT EXISTS `competence` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `base_damage` bigint NOT NULL,
  `cooldown` bigint NOT NULL,
  `level` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `competencemultiplier`
--

DROP TABLE IF EXISTS `competencemultiplier`;
CREATE TABLE IF NOT EXISTS `competencemultiplier` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_competence` bigint NOT NULL,
  `stat_name` varchar(255) NOT NULL,
  `multiplier` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `competencemultiplier_id_competence_foreign` (`id_competence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `effects`
--

DROP TABLE IF EXISTS `effects`;
CREATE TABLE IF NOT EXISTS `effects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `effect_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hero`
--

DROP TABLE IF EXISTS `hero`;
CREATE TABLE IF NOT EXISTS `hero` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `level` bigint NOT NULL DEFAULT '1',
  `isDead` tinyint(1) NOT NULL DEFAULT '0',
  `url_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'defaultHero.png',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `herostat`
--

DROP TABLE IF EXISTS `herostat`;
CREATE TABLE IF NOT EXISTS `herostat` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_hero` bigint NOT NULL,
  `stat_name` varchar(255) NOT NULL,
  `stat_value` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `herostat_id_hero_foreign` (`id_hero`)
) ENGINE=MyISAM AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hero_competence`
--

DROP TABLE IF EXISTS `hero_competence`;
CREATE TABLE IF NOT EXISTS `hero_competence` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_hero` bigint NOT NULL,
  `id_competence` bigint NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hero_competence_id_hero_foreign` (`id_hero`),
  KEY `hero_competence_id_competence_foreign` (`id_competence`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hero_inventory`
--

DROP TABLE IF EXISTS `hero_inventory`;
CREATE TABLE IF NOT EXISTS `hero_inventory` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_hero` int NOT NULL,
  `id_item` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL,
  `item_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `item_effects`
--

DROP TABLE IF EXISTS `item_effects`;
CREATE TABLE IF NOT EXISTS `item_effects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_item` int NOT NULL,
  `id_effect` int NOT NULL,
  `stat_type` enum('hp','str','dex','int','def') NOT NULL,
  `effect_value` int NOT NULL COMMENT 'How much should the effect give you. Negative values for debuff',
  `effect_duration` int NOT NULL COMMENT 'Duration in Turns, 0 = instant',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
