CREATE DATABASE IF NOT EXISTS `chargement`;

USE `chargement`;
CREATE TABLE IF NOT EXISTS `palette` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ean` varchar(45) DEFAULT NULL,
  `codemag` varchar(5) DEFAULT NULL,
  `dateheure_exp` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateheure_rec` datetime DEFAULT NULL,
  `receive` tinyint(1) unsigned DEFAULT NULL,
  `id_tournee` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_camion_tournee_idx` (`id_tournee`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `codecli` varchar(6) DEFAULT NULL,
  `libelle` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `compteur` (`compteur` smallint(3) unsigned DEFAULT 0) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT INTO compteur (compteur) VALUE (0);


CREATE TABLE IF NOT EXISTS `tournee` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numtournee` varchar(10) DEFAULT NULL,
  `dateheure_start` datetime DEFAULT CURRENT_TIMESTAMP,
  `dateheure_end` datetime,
  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `erreur` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numtournee` varchar(10) DEFAULT NULL,
  `erreur` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE palette ADD INDEX (ean);
ALTER TABLE palette ADD INDEX (codemag);
ALTER TABLE client ADD INDEX (codecli);

USE `mysql`;
INSERT INTO `user` (`Host`, `User`, `Password`, `Select_priv`, `Insert_priv`, `Update_priv`, `Delete_priv`, `Create_priv`, `Drop_priv`, `Reload_priv`, `Shutdown_priv`, `Process_priv`, `File_priv`, `Grant_priv`, `References_priv`, `Index_priv`, `Alter_priv`, `Show_db_priv`, `Super_priv`, `Create_tmp_table_priv`, `Lock_tables_priv`, `Execute_priv`, `Repl_slave_priv`, `Repl_client_priv`, `Create_view_priv`, `Show_view_priv`, `Create_routine_priv`, `Alter_routine_priv`, `Create_user_priv`, `Event_priv`, `Trigger_priv`, `Create_tablespace_priv`, `ssl_type`, `ssl_cipher`, `x509_issuer`, `x509_subject`, `max_questions`, `max_updates`, `max_connections`, `max_user_connections`, `plugin`, `authentication_string`) VALUES ('localhost', 'admin_chargement', PASSWORD('R88aV23B7GpD9rnk'), 'Y', 'Y', 'Y', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', '', '', '', '', 0, 0, 0, 0, '', NULL);
INSERT INTO `db` (`Host`, `Db`, `User`, `Select_priv`, `Insert_priv`, `Update_priv`, `Delete_priv`, `Create_priv`, `Drop_priv`, `Grant_priv`, `References_priv`, `Index_priv`, `Alter_priv`, `Create_tmp_table_priv`, `Lock_tables_priv`, `Create_view_priv`, `Show_view_priv`, `Create_routine_priv`, `Alter_routine_priv`, `Execute_priv`, `Event_priv`, `Trigger_priv`) VALUES ('localhost', 'chargement', 'admin_chargement', 'Y', 'Y', 'N', 'Y', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N');
FLUSH PRIVILEGES;

CREATE USER 'admin_chargement2'@'localhost' IDENTIFIED BY 'R88aV23B7GpD9rnk';
GRANT SELECT, INSERT, UPDATE ON chargment TO 'admin_chargement2'@'localhost';
FLUSH PRIVILEGES;
