/*
 Navicat Premium Data Transfer

 Source Server         : intraslpr
 Source Server Type    : MySQL
 Source Server Version : 50623
 Source Host           : 10.52.62.214
 Source Database       : chargement

 Target Server Type    : MySQL
 Target Server Version : 50623
 File Encoding         : utf-8

 Date: 06/02/2015 08:46:50 AM
*/

SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `client`
-- ----------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codecli` varchar(6) DEFAULT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `codecli` (`codecli`)
) ENGINE=InnoDB AUTO_INCREMENT=2553 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `compteur`
-- ----------------------------
DROP TABLE IF EXISTS `compteur`;
CREATE TABLE `compteur` (
  `compteur` smallint(3) unsigned DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `erreur`
-- ----------------------------
DROP TABLE IF EXISTS `erreur`;
CREATE TABLE `erreur` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numtournee` varchar(10) DEFAULT NULL,
  `erreur` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `palette`
-- ----------------------------
DROP TABLE IF EXISTS `palette`;
CREATE TABLE `palette` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ean` varchar(45) DEFAULT NULL,
  `codemag` varchar(5) DEFAULT NULL,
  `dateheure_exp` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateheure_rec` datetime DEFAULT NULL,
  `receive` tinyint(1) unsigned DEFAULT NULL,
  `id_tournee` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_camion_tournee_idx` (`id_tournee`),
  KEY `ean` (`ean`),
  KEY `codemag` (`codemag`)
) ENGINE=InnoDB AUTO_INCREMENT=80242 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `tournee`
-- ----------------------------
DROP TABLE IF EXISTS `tournee`;
CREATE TABLE `tournee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numtournee` varchar(10) DEFAULT NULL,
  `dateheure_start` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateheure_end` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2832 DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS = 1;




GRANT USAGE ON *.* TO 'admin_chargement'@'localhost' IDENTIFIED BY 'R88aV23B7GpD9rnk'
WITH MAX_QUERIES_PER_HOUR 0
MAX_UPDATES_PER_HOUR 0
MAX_CONNECTIONS_PER_HOUR 0;

GRANT Insert, Select, Update ON `chargement`.* TO `admin_chargement`@`localhost`;
