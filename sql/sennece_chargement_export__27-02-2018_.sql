# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Hôte: localhost (MySQL 5.6.21-log)
# Base de données: sennece_chargement
# Temps de génération: 2018-02-27 15:00:49 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Affichage de la table compteur
# ------------------------------------------------------------

DROP TABLE IF EXISTS `compteur`;

CREATE TABLE `compteur` (
  `compteur` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`compteur`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table palette
# ------------------------------------------------------------

DROP TABLE IF EXISTS `palette`;

CREATE TABLE `palette` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ean` varchar(45) DEFAULT NULL,
  `dateheure_exp` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateheure_rec` datetime DEFAULT NULL,
  `receive` tinyint(1) unsigned DEFAULT NULL,
  `id_tournee` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ean` (`ean`),
  KEY `id_tournee` (`id_tournee`),
  KEY `dateheure_id_tournee` (`dateheure_exp`,`id_tournee`) USING BTREE,
  CONSTRAINT `fk_id_tournee` FOREIGN KEY (`id_tournee`) REFERENCES `tournee` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Affichage de la table tournee
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tournee`;

CREATE TABLE `tournee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numtournee` varchar(12) DEFAULT NULL,
  `dateheure_start` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateheure_end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `numtournee` (`numtournee`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
