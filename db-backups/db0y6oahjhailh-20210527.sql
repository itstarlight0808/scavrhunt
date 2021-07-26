/*
SQLyog Community v12.09 (64 bit)
MySQL - 10.4.14-MariaDB : Database - db0y6oahjhailh
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
USE `db0y6oahjhailh`;

/*Table structure for table `challenge_judge` */

DROP TABLE IF EXISTS `challenge_judge`;

CREATE TABLE `challenge_judge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `player_id` int(11) NOT NULL,
  `gamecode_id` int(11) NOT NULL,
  `hunt_id` int(11) NOT NULL,
  `chg_id` int(11) NOT NULL,
  `chg_result` text NOT NULL,
  `points` int(11) NOT NULL,
  `status_id` int(1) NOT NULL DEFAULT 1,
  `submitted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Table structure for table `hunt_gamecode` */

DROP TABLE IF EXISTS `hunt_gamecode`;

CREATE TABLE `hunt_gamecode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `gamecode` varchar(20) NOT NULL,
  `status_id` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
