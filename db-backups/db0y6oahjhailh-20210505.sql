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

/*Table structure for table `challenge_status` */

DROP TABLE IF EXISTS `challenge_status`;

CREATE TABLE `challenge_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `challenge_status` */

insert  into `challenge_status`(`id`,`name`) values (1,'Ready'),(2,'Submitted'),(3,'Judged'),(4,'Deleted');

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
  `chg_image2` text NOT NULL,
  `chg_link` text NOT NULL,
  `status_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `challenges` */

insert  into `challenges`(`id`,`hunt_id`,`chg_name`,`description`,`points`,`chg_type_id`,`chg_image`,`chg_image2`,`chg_link`,`status_id`,`created`,`deleted`) values (1,1,'Challenge1','<p>My Sample Description</p>',200,1,'60928779707df.png','60928779707df.png','https://aaa.com/',1,'2021-05-05 07:54:33',NULL),(2,1,'Challenge 2','<p>My Sample Description 2</p>',300,2,'','','https://bbb.com/',1,'2021-05-05 07:56:45',NULL);

/*Table structure for table `hunt_judge` */

DROP TABLE IF EXISTS `hunt_judge`;

CREATE TABLE `hunt_judge` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `hunt_id` int(11) NOT NULL,
  `chg_id` int(11) NOT NULL,
  `chg_result` text NOT NULL,
  `points` int(11) NOT NULL,
  `status_id` int(1) NOT NULL DEFAULT 1,
  `submitted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Data for the table `hunt_judge` */

/*Table structure for table `hunt_status` */

DROP TABLE IF EXISTS `hunt_status`;

CREATE TABLE `hunt_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `hunt_status` */

insert  into `hunt_status`(`id`,`name`) values (1,'Ready'),(2,'Started'),(3,'End'),(4,'Deleted');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
