-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour projects-manager-debug
CREATE DATABASE IF NOT EXISTS `projects-manager-debug` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projects-manager-debug`;

-- Listage de la structure de table projects-manager-debug. categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_category`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Listage des données de la table projects-manager-debug.categories : ~0 rows (environ)

-- Listage de la structure de table projects-manager-debug. projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id_project` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `github_link` varchar(100) DEFAULT NULL,
  `priority` tinyint NOT NULL DEFAULT '0',
  `github_portfolio` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_project`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;

-- Listage des données de la table projects-manager-debug.projects : ~0 rows (environ)

-- Listage de la structure de table projects-manager-debug. projects_categories
CREATE TABLE IF NOT EXISTS `projects_categories` (
  `id_project` int NOT NULL,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id_project`,`id_categorie`) USING BTREE,
  KEY `id_categorie` (`id_categorie`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table projects-manager-debug.projects_categories : ~0 rows (environ)

-- Listage de la structure de table projects-manager-debug. projects_techs
CREATE TABLE IF NOT EXISTS `projects_techs` (
  `id_tech` int unsigned DEFAULT NULL,
  `id_project` int DEFAULT NULL,
  KEY `FK_projects_techs_projects` (`id_project`),
  KEY `FK_projects_techs_techs` (`id_tech`),
  CONSTRAINT `FK_projects_techs_projects` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_projects_techs_techs` FOREIGN KEY (`id_tech`) REFERENCES `techs` (`id_tech`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table projects-manager-debug.projects_techs : ~0 rows (environ)

-- Listage de la structure de table projects-manager-debug. techs
CREATE TABLE IF NOT EXISTS `techs` (
  `id_tech` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tech`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Listage des données de la table projects-manager-debug.techs : ~0 rows (environ)


-- Listage de la structure de la base pour projects-manager-prod
CREATE DATABASE IF NOT EXISTS `projects-manager-prod` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `projects-manager-prod`;

-- Listage de la structure de table projects-manager-prod. categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id_category` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_category`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- Listage des données de la table projects-manager-prod.categories : ~0 rows (environ)

-- Listage de la structure de table projects-manager-prod. projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id_project` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `github_link` varchar(100) DEFAULT NULL,
  `priority` tinyint NOT NULL DEFAULT '0',
  `github_portfolio` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_project`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;

-- Listage des données de la table projects-manager-prod.projects : ~0 rows (environ)

-- Listage de la structure de table projects-manager-prod. projects_categories
CREATE TABLE IF NOT EXISTS `projects_categories` (
  `id_project` int NOT NULL,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id_project`,`id_categorie`) USING BTREE,
  KEY `id_categorie` (`id_categorie`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table projects-manager-prod.projects_categories : ~0 rows (environ)

-- Listage de la structure de table projects-manager-prod. projects_techs
CREATE TABLE IF NOT EXISTS `projects_techs` (
  `id_tech` int unsigned DEFAULT NULL,
  `id_project` int DEFAULT NULL,
  KEY `FK_projects_techs_projects` (`id_project`),
  KEY `FK_projects_techs_techs` (`id_tech`),
  CONSTRAINT `FK_projects_techs_projects` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_projects_techs_techs` FOREIGN KEY (`id_tech`) REFERENCES `techs` (`id_tech`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table projects-manager-prod.projects_techs : ~0 rows (environ)

-- Listage de la structure de table projects-manager-prod. techs
CREATE TABLE IF NOT EXISTS `techs` (
  `id_tech` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tech`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Listage des données de la table projects-manager-prod.techs : ~0 rows (environ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
