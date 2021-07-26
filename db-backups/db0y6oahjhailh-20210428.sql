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

/*Table structure for table `challenge_types` */

DROP TABLE IF EXISTS `challenge_types`;

CREATE TABLE `challenge_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `challenge_types` */

insert  into `challenge_types`(`id`,`name`,`is_active`) values (1,'Photo',1),(2,'Questions',1),(3,'Location based',1),(4,'Video',0);

/*Table structure for table `challenges` */

DROP TABLE IF EXISTS `challenges`;

CREATE TABLE `challenges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hunt_id` int(11) NOT NULL,
  `chg_name` text NOT NULL,
  `description` text NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `chg_type_id` int(11) NOT NULL,
  `chg_image` text NOT NULL,
  `chg_link` text NOT NULL,
  `status_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `challenges` */

/*Table structure for table `chg_databank` */

DROP TABLE IF EXISTS `chg_databank`;

CREATE TABLE `chg_databank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chg_id` int(11) NOT NULL,
  `hunt_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `chg_databank` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
