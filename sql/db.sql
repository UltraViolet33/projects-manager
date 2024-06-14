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
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table projects-manager-debug. portfolios
CREATE TABLE IF NOT EXISTS `portfolios` (
  `id_portfolio` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  KEY `FK__categories` (`category_id`),
  KEY `id_portfolio` (`id_portfolio`),
  CONSTRAINT `FK__categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table projects-manager-debug. portfolio_projects
CREATE TABLE IF NOT EXISTS `portfolio_projects` (
  `id_portfolio_project` int NOT NULL AUTO_INCREMENT,
  `project_id` int DEFAULT NULL,
  `portfolio_id` int DEFAULT NULL,
  PRIMARY KEY (`id_portfolio_project`),
  KEY `FK_portfolio_projects_projects` (`project_id`),
  KEY `FK_portfolio_projects_portfolios` (`portfolio_id`),
  CONSTRAINT `FK_portfolio_projects_portfolios` FOREIGN KEY (`portfolio_id`) REFERENCES `portfolios` (`id_portfolio`),
  CONSTRAINT `FK_portfolio_projects_projects` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id_project`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table projects-manager-debug. projects
CREATE TABLE IF NOT EXISTS `projects` (
  `id_project` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` date NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `github_link` varchar(100) DEFAULT NULL,
  `priority` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_project`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=120 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table projects-manager-debug. projects_categories
CREATE TABLE IF NOT EXISTS `projects_categories` (
  `id_project` int NOT NULL,
  `id_category` int NOT NULL,
  PRIMARY KEY (`id_project`,`id_category`) USING BTREE,
  KEY `id_categorie` (`id_category`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table projects-manager-debug. projects_techs
CREATE TABLE IF NOT EXISTS `projects_techs` (
  `id_tech` int unsigned DEFAULT NULL,
  `id_project` int DEFAULT NULL,
  KEY `FK_projects_techs_projects` (`id_project`),
  KEY `FK_projects_techs_techs` (`id_tech`),
  CONSTRAINT `FK_projects_techs_projects` FOREIGN KEY (`id_project`) REFERENCES `projects` (`id_project`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_projects_techs_techs` FOREIGN KEY (`id_tech`) REFERENCES `techs` (`id_tech`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de table projects-manager-debug. techs
CREATE TABLE IF NOT EXISTS `techs` (
  `id_tech` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_tech`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
