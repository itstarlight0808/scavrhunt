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

/*Table structure for table `chg_databank` */

DROP TABLE IF EXISTS `chg_databank`;

CREATE TABLE `chg_databank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chg_name` text NOT NULL,
  `description` text NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `puzzle_page` longtext NOT NULL,
  `puzzle_answer` text NOT NULL,
  `multi_answer` int(1) NOT NULL DEFAULT 1,
  `chg_type_id` int(11) NOT NULL,
  `chg_image` text NOT NULL,
  `chg_image2` text NOT NULL,
  `chg_link` text NOT NULL,
  `status_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
