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
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db0y6oahjhailh` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `db0y6oahjhailh`;

/*Table structure for table `ci_sessions` */

DROP TABLE IF EXISTS `ci_sessions`;

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT 0,
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `ci_sessions` */

/*Table structure for table `hunt_delivery` */

DROP TABLE IF EXISTS `hunt_delivery`;

CREATE TABLE `hunt_delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `hunt_delivery` */

insert  into `hunt_delivery`(`id`,`name`) values (1,'Zoom'),(2,'Physical');

/*Table structure for table `hunt_infos` */

DROP TABLE IF EXISTS `hunt_infos`;

CREATE TABLE `hunt_infos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hunt_name` text NOT NULL,
  `hunt_logo` text NOT NULL,
  `hunt_logo2` text NOT NULL,
  `zoom_account_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_date` date NOT NULL,
  `end_time` time NOT NULL,
  `max_time` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `deleted` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `hunt_infos` */

insert  into `hunt_infos`(`id`,`hunt_name`,`hunt_logo`,`hunt_logo2`,`zoom_account_id`,`school_id`,`type_id`,`delivery_id`,`start_date`,`start_time`,`end_date`,`end_time`,`max_time`,`status_id`,`created`,`deleted`) values (1,'Test Hunt','university_logo_small_vertical_blue.png','dW5pdmVyc2l0eV9sb2dvX3NtYWxsX3ZlcnRpY2FsX2JsdWUucG5n.png',1,1,1,1,'2021-03-30','12:00:00','2021-03-30','01:00:00',60,1,'2021-03-26 11:08:15',NULL);

/*Table structure for table `hunt_types` */

DROP TABLE IF EXISTS `hunt_types`;

CREATE TABLE `hunt_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `hunt_types` */

insert  into `hunt_types`(`id`,`name`) values (1,'Traditional'),(2,'Race'),(3,'Treasure');

/*Table structure for table `players` */

DROP TABLE IF EXISTS `players`;

CREATE TABLE `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `std_id_req` text NOT NULL,
  `school_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `game_link` text NOT NULL,
  `status_id` int(1) NOT NULL,
  `logged_in` datetime NOT NULL,
  `room_exited` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `players` */

insert  into `players`(`id`,`name`,`email`,`std_id_req`,`school_id`,`team_id`,`room_id`,`game_link`,`status_id`,`logged_in`,`room_exited`) values (1,'aa','aa@aa.com','aa',1,1,1,'https://virtualescaperoom.fun/CSI/',1,'2021-04-13 16:03:13',NULL),(2,'bb','bb@bb.com','bb',1,2,1,'https://virtualescaperoom.fun/CSI/',1,'2021-04-13 16:03:26',NULL),(3,'cc','cc@cc.com','cc',1,3,1,'https://virtualescaperoom.fun/CSI/',1,'2021-04-13 16:03:35',NULL),(4,'ddd','ddd@ddd.com','ddd',1,4,2,'https://virtualescaperoom.fun/CSI/',1,'2021-04-13 16:03:55',NULL),(5,'eee','eee@eee.com','eee',1,4,2,'https://virtualescaperoom.fun/CSI/',1,'2021-04-13 16:04:45',NULL),(6,'fff','fff@fff.com','fff',1,4,2,'https://virtualescaperoom.fun/CSI/',1,'2021-04-13 16:05:11',NULL);

/*Table structure for table `room_status` */

DROP TABLE IF EXISTS `room_status`;

CREATE TABLE `room_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `room_status` */

insert  into `room_status`(`id`,`status`) values (1,'Vacant'),(2,'Occupied'),(3,'Solo Vacant'),(4,'Started'),(5,'Closed'),(6,'Need Help');

/*Table structure for table `schools` */

DROP TABLE IF EXISTS `schools`;

CREATE TABLE `schools` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sch_name` text NOT NULL,
  `sch_logo` text NOT NULL,
  `sch_logo2` text NOT NULL,
  `sch_address` text NOT NULL,
  `zoom_account_id` int(11) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 0,
  `std_id_required` int(1) NOT NULL DEFAULT 0,
  `sch_details` text NOT NULL,
  `zoom_link` text NOT NULL,
  `video_id` text NOT NULL,
  `subdomains` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

/*Data for the table `schools` */

insert  into `schools`(`id`,`sch_name`,`sch_logo`,`sch_logo2`,`sch_address`,`zoom_account_id`,`is_active`,`std_id_required`,`sch_details`,`zoom_link`,`video_id`,`subdomains`,`created`) values (1,'SUNY WCC','WCCLogo.jpg','V0NDTG9nby5qcGc=.jpg','Westchester, NY',1,1,1,'.','https://virtualescaperoom.fun/CSI/','https://virtualescaperoom.fun/CSI/','7991539575','2021-03-23 10:54:04'),(2,'John Hopkins University','university_logo_small_vertical_blue.png','dW5pdmVyc2l0eV9sb2dvX3NtYWxsX3ZlcnRpY2FsX2JsdWUucG5n.png','Baltimore, MD',2,0,1,'.','https://virtualescaperoom.fun/zombie/','https://virtualescaperoom.fun/zombie/','9324921726','2021-03-23 10:57:26'),(3,'North Dakota State University','CrimeScene.jpg','Q3JpbWVTY2VuZS5qcGc=.jpg','ND',1,0,1,'.','https://virtualescaperoom.fun/CSI/','https://virtualescaperoom.fun/CSI/','6649644497','2021-03-24 17:29:59'),(4,'Century College','CrimeScene.jpg','Q3JpbWVTY2VuZS5qcGc=.jpg','MN',3,0,1,'.','https://virtualescaperoom.fun/CSI/','https://virtualescaperoom.fun/CSI/','6738818428','2021-03-25 16:53:11'),(5,'Lehigh University','DesertBackground.jpg','RGVzZXJ0QmFja2dyb3VuZC5qcGc=.jpg','PA',2,1,1,'.','https://virtualescaperoom.fun/zombie/','https://virtualescaperoom.fun/zombie/','6977400058','2021-03-26 15:08:31'),(6,'Sacred Heart University','CrimeScene.jpg','Q3JpbWVTY2VuZS5qcGc=.jpg','CT',3,1,1,'.','https://virtualescaperoom.fun/CSI/','https://virtualescaperoom.fun/CSI/','4240029680','2021-03-27 14:52:05'),(7,'CNY Attractions','MagGlass.jpg','TWFnR2xhc3MuanBn.jpg','SC',3,1,1,'+','www.cnyattractions.com','x','3478679912','2021-03-27 20:51:47'),(12,'Randolph College','tigerlogo.jpg','dGlnZXJsb2dvLmpwZw==.jpg','.',3,1,1,'.','https://virtualescaperoom.fun/tiger/','https://virtualescaperoom.fun/tiger/','6150481808','2021-03-31 17:12:31'),(13,'test school','tigerlogo.jpg','dGlnZXJsb2dvLmpwZw==.jpg','test',4,1,0,'.','www.test.com','x','4679811441','2021-03-31 18:09:56'),(10,'MarcTest1','WheatonHS.png','V2hlYXRvbkhTLnBuZw==.png','555 Anywhere Street  Test, MD 12345',3,1,0,'pqr','www.cnyattractions.com','x','1540011023','2021-03-30 20:35:09'),(11,'Penn State University','background.jpg','YmFja2dyb3VuZC5qcGc=.jpg','PA',3,1,1,'.','https://virtualescaperoom.fun/Scavenger/Music-Movies/','https://virtualescaperoom.fun/Scavenger/Music-Movies/','5076360278','2021-03-31 16:46:05'),(14,'test school','tigerlogo.jpg','dGlnZXJsb2dvLmpwZw==.jpg','SC',4,1,0,'test details','test zoom','test video','2808527467','2021-03-31 18:12:29'),(15,'Marc Test 3-31-21','graduation-cap.jpg','Z3JhZHVhdGlvbi1jYXAuanBn.jpg','988 Anywhere Street  Test, MD 12345',4,1,1,'mno','https://us02web.zoom.us/j/81970345238','https://virtualescaperoom.fun/CSI/','8716100383','2021-03-31 21:10:18'),(16,'Test School Delete','2020-10-08_16-39-15.png','MjAyMC0xMC0wOF8xNi0zOS0xNS5wbmc=.png','Westchester, NY',1,1,0,'.','https://virtualescaperoom.fun/CSI/','https://virtualescaperoom.fun/CSI/','3844300836','2021-03-31 22:21:49'),(17,'MST1','WheatonHS.png','V2hlYXRvbkhTLnBuZw==.png','555 Anywhere Street  Test, MD 12345',2,1,0,'ghi','https://us02web.zoom.us/j/81970345238','https://virtualescaperoom.fun/CSI/','3569349232','2021-04-01 00:38:42'),(18,'MST2','graduation-cap.jpg','Z3JhZHVhdGlvbi1jYXAuanBn.jpg','987 Anywhere Street  Test, MD 12345',2,1,1,'jkl','https://us02web.zoom.us/j/81970345238','https://virtualescaperoom.fun/CSI/','9604452526','2021-04-01 00:39:46'),(19,'George Mason University','CrimeScene.jpg','Q3JpbWVTY2VuZS5qcGc=.jpg','.',1,1,1,'.','https://virtualescaperoom.fun/CSI/','www.virtualescaperoom.fun/CSI','1333887569','2021-04-01 12:41:02'),(20,'University of Nevada-Reno','CrimeScene.jpg','Q3JpbWVTY2VuZS5qcGc=.jpg','NV',1,1,1,'.','https://virtualescaperoom.fun/CSI/','www.virtualescaperoom.fun/CSI','4341913511','2021-04-01 13:44:30'),(21,'University of South Florida - Tampa','LIBRARY-CompositeDONOTUSE.jpg','TElCUkFSWS1Db21wb3NpdGVET05PVFVTRS5qcGc=.jpg','FL',5,1,1,'.','https://virtualescaperoom.fun/mascot/USF/start.html','.','6041179013','2021-04-02 21:03:29'),(22,'University of South Florida - Tampa','ShadowyMan.jpg','U2hhZG93eU1hbi5qcGc=.jpg','FL',6,1,1,'.','https://virtualescaperoom.fun/exitfiles/USF/start.html','.','2893040755','2021-04-02 23:39:45'),(23,'University of South Florida - Tampa','zombie desert graphic.jpg','em9tYmllIGRlc2VydCBncmFwaGljLmpwZw==.jpg','FL',7,1,1,'.','https://virtualescaperoom.fun/zombie/USF/start.html','.','8072017343','2021-04-03 01:22:33'),(25,'North Hennepin Community College','tigerlogo.jpg','dGlnZXJsb2dvLmpwZw==.jpg','.',1,1,1,'.','https://virtualescaperoom.fun/tiger/','.','5649219078','2021-04-07 14:21:49');

/*Table structure for table `tbl_last_login` */

DROP TABLE IF EXISTS `tbl_last_login`;

CREATE TABLE `tbl_last_login` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userId` bigint(20) NOT NULL,
  `sessionData` varchar(2048) NOT NULL,
  `machineIp` varchar(1024) NOT NULL,
  `userAgent` varchar(128) NOT NULL,
  `agentString` varchar(1024) NOT NULL,
  `platform` varchar(128) NOT NULL,
  `createdDtm` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_last_login` */

insert  into `tbl_last_login`(`id`,`userId`,`sessionData`,`machineIp`,`userAgent`,`agentString`,`platform`,`createdDtm`) values (1,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-22 22:30:00'),(2,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-22 22:33:02'),(3,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-22 22:33:11'),(4,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-23 06:43:55'),(5,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','98.30.75.81','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-23 10:47:57'),(6,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-23 20:08:14'),(7,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-23 21:11:24'),(8,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-24 14:30:23'),(9,3,'{\"role\":\"2\",\"roleText\":\"Game Master\",\"name\":\"Mike Cirri\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-24 14:35:07'),(10,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-24 14:35:37'),(11,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-24 17:28:36'),(12,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-24 20:21:16'),(13,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','73.154.229.188','Chrome 86.0.4240.183','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.183 Safari/537.36','Windows 10','2021-03-25 00:35:48'),(14,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','71.185.45.152','Chrome 88.0.4324.192','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36','Mac OS X','2021-03-25 00:37:48'),(15,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','73.133.241.125','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-25 00:39:00'),(16,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-25 08:44:13'),(17,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-25 16:50:10'),(18,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','73.133.241.125','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-25 20:13:47'),(19,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-25 22:17:05'),(20,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-26 07:09:16'),(21,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','98.30.75.81','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-26 11:02:37'),(22,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-26 14:55:58'),(23,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-26 15:11:04'),(24,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','73.133.241.125','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-26 22:29:38'),(25,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','68.175.138.126','Chrome 88.0.4324.192','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36','Mac OS X','2021-03-26 22:33:04'),(26,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','73.133.241.125','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-27 20:23:21'),(27,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','98.30.75.81','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-28 12:20:53'),(28,4,'{\"role\":\"2\",\"roleText\":\"Game Master\",\"name\":\"Jason Bock Test Gm\"}','98.30.75.81','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-28 13:10:51'),(29,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-28 21:07:18'),(30,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','98.30.75.81','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-28 21:34:22'),(31,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','98.30.75.81','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-28 21:50:38'),(32,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-28 22:09:28'),(33,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-29 06:59:55'),(34,4,'{\"role\":\"2\",\"roleText\":\"Game Master\",\"name\":\"Jason Bock Test Gm\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-29 07:00:40'),(35,4,'{\"role\":\"2\",\"roleText\":\"Game Master\",\"name\":\"Jason Bock Test Gm\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-29 07:01:02'),(36,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-29 07:23:23'),(37,4,'{\"role\":\"2\",\"roleText\":\"Game Master\",\"name\":\"Jason Bock Test Gm\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-29 07:24:25'),(38,4,'{\"role\":\"2\",\"roleText\":\"Game Master\",\"name\":\"Jason Bock Test Gm\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-29 19:26:42'),(39,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-30 07:31:17'),(40,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-30 09:59:49'),(41,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-30 14:37:54'),(42,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','209.119.211.66','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-30 15:11:12'),(43,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','73.133.241.125','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-30 19:54:59'),(44,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-30 22:38:28'),(45,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','98.30.75.81','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-31 01:47:55'),(46,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-31 13:37:32'),(47,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-31 16:44:30'),(48,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-31 18:07:48'),(49,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-31 19:51:22'),(50,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','73.133.241.125','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-31 21:06:11'),(51,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-31 21:14:09'),(52,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','98.30.75.81','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-03-31 21:32:01'),(53,3,'{\"role\":\"2\",\"roleText\":\"Game Master\",\"name\":\"Mike Cirri\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-04-01 12:36:54'),(54,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-04-01 12:40:04'),(55,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-01 18:46:49'),(56,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','73.154.229.188','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-04-01 20:12:12'),(57,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','73.133.241.125','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-04-01 22:45:17'),(58,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','68.175.138.126','Chrome 88.0.4324.192','Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36','Mac OS X','2021-04-01 22:46:28'),(59,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-04-02 18:22:36'),(60,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-04-02 21:02:35'),(61,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-04-02 23:36:16'),(62,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-03 12:35:44'),(63,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-04-05 16:09:14'),(64,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-06 10:25:03'),(65,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-04-06 21:37:48'),(66,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','173.49.152.131','Chrome 89.0.4389.90','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.90 Safari/537.36','Windows 10','2021-04-07 15:26:50'),(67,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-07 17:10:25'),(68,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','173.49.152.131','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-07 20:34:32'),(69,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-07 22:22:03'),(70,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','68.84.79.162','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-08 01:45:31'),(71,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-08 07:16:47'),(72,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','172.75.68.144','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-08 11:18:22'),(73,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','107.126.32.30','Safari 604.1','Mozilla/5.0 (iPhone; CPU iPhone OS 14_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/87.0.4280.77 Mobile/15E148 Safari/604.1','iOS','2021-04-08 13:40:17'),(74,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-08 13:44:22'),(75,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','107.126.32.71','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-08 13:49:06'),(76,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','188.43.235.177','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-08 18:07:05'),(77,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','::1','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-10 07:19:39'),(78,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','::1','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-13 09:02:18'),(79,1,'{\"role\":\"1\",\"roleText\":\"Administrator\",\"name\":\"Jason Bock\"}','::1','Chrome 89.0.4389.114','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36','Windows 10','2021-04-13 22:34:23');

/*Table structure for table `tbl_reset_password` */

DROP TABLE IF EXISTS `tbl_reset_password`;

CREATE TABLE `tbl_reset_password` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `activation_id` varchar(32) NOT NULL,
  `agent` varchar(512) NOT NULL,
  `client_ip` varchar(32) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `createdBy` bigint(20) NOT NULL DEFAULT 1,
  `createdDtm` datetime NOT NULL,
  `updatedBy` bigint(20) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `tbl_reset_password` */

/*Table structure for table `tbl_roles` */

DROP TABLE IF EXISTS `tbl_roles`;

CREATE TABLE `tbl_roles` (
  `roleId` tinyint(4) NOT NULL AUTO_INCREMENT COMMENT 'role id',
  `role` varchar(50) NOT NULL COMMENT 'role text',
  PRIMARY KEY (`roleId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_roles` */

insert  into `tbl_roles`(`roleId`,`role`) values (1,'Administrator'),(2,'Game Master'),(3,'Player');

/*Table structure for table `tbl_users` */

DROP TABLE IF EXISTS `tbl_users`;

CREATE TABLE `tbl_users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL COMMENT 'login email',
  `password` varchar(128) NOT NULL COMMENT 'hashed login password',
  `name` varchar(128) DEFAULT NULL COMMENT 'full name of user',
  `mobile` varchar(20) DEFAULT NULL,
  `roleId` tinyint(4) NOT NULL,
  `isDeleted` tinyint(4) NOT NULL DEFAULT 0,
  `createdBy` int(11) NOT NULL,
  `createdDtm` datetime NOT NULL,
  `updatedBy` int(11) DEFAULT NULL,
  `updatedDtm` datetime DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `tbl_users` */

insert  into `tbl_users`(`userId`,`email`,`password`,`name`,`mobile`,`roleId`,`isDeleted`,`createdBy`,`createdDtm`,`updatedBy`,`updatedDtm`) values (1,'admin@example.com','$2y$10$93XrqZUi4zJbeDfq5IDcC.7z6jYp0QFT0VgEssAeITnYhbANJ6wou','Jason Bock','9890098900',1,0,0,'2020-12-01 10:09:51',1,'2021-02-20 08:11:06'),(2,'user@example.com','$2y$10$Wa0GDp5g0sx49CTfo6La9uaR11hFzZvqt8EXKYCRnao04kxRVa4Wu','User','9890098900',3,0,1,'2020-12-01 10:11:20',1,'2021-02-15 23:25:39'),(3,'mike@cnyattractions.com','$2y$10$mMNTTY2NUX7967XfWtNazeSyMCuSCGDKHcxSFpPeptR3.6D7JdXmC','Mike Cirri','6073162237',2,0,1,'2021-03-24 14:34:01',NULL,NULL),(4,'jbock@lasertagguy.com','$2y$10$IAswsFXiGLYksIknKDZsyuwTqgl2l2hXa5jSY3Y3eA8lBUw/O.CBC','Jason Bock Test Gm','5183543093',2,0,1,'2021-03-28 13:10:17',1,'2021-03-29 07:00:15');

/*Table structure for table `team_status` */

DROP TABLE IF EXISTS `team_status`;

CREATE TABLE `team_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `team_status` */

insert  into `team_status`(`id`,`status`) values (1,'Ready'),(2,'Playing'),(3,'Exited');

/*Table structure for table `teams` */

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) NOT NULL,
  `team_name` text NOT NULL,
  `players_count` int(11) NOT NULL,
  `same_device` int(1) NOT NULL DEFAULT 0,
  `room_id` int(11) NOT NULL,
  `captain` text NOT NULL,
  `members` text NOT NULL,
  `status_id` int(1) NOT NULL DEFAULT 1,
  `created` datetime NOT NULL,
  `room_exited` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `teams` */

insert  into `teams`(`id`,`school_id`,`team_name`,`players_count`,`same_device`,`room_id`,`captain`,`members`,`status_id`,`created`,`room_exited`) values (1,1,'Solo Team',1,0,1,'','',1,'2021-04-13 16:03:13',NULL),(2,1,'Solo Team',1,0,1,'','',1,'2021-04-13 16:03:26',NULL),(3,1,'Solo Team',1,0,1,'','',1,'2021-04-13 16:03:35',NULL),(4,1,'333',3,0,2,'ddd','eee,fff',1,'2021-04-13 16:03:55',NULL);

/*Table structure for table `zoom_account` */

DROP TABLE IF EXISTS `zoom_account`;

CREATE TABLE `zoom_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `zoom_account` */

insert  into `zoom_account`(`id`,`account_name`,`created`) values (1,'Alex\'s Zoom Account','2021-03-23 10:53:24'),(2,'Marc\'s Zoom Account','2021-03-23 10:56:49'),(3,'Mike\'s Zoom Account','2021-03-24 19:40:10'),(4,'Test Zoom Account','2021-03-31 18:08:39'),(5,'12pm University of South Florida','2021-04-02 18:23:08'),(6,'4pm University of South Florida','2021-04-02 18:23:20'),(7,'10pm University of South Florida','2021-04-02 18:23:29');

/*Table structure for table `zoom_rooms` */

DROP TABLE IF EXISTS `zoom_rooms`;

CREATE TABLE `zoom_rooms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zoom_account_id` int(11) NOT NULL,
  `room_no` int(11) NOT NULL,
  `status_id` int(1) NOT NULL,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=351 DEFAULT CHARSET=utf8;

/*Data for the table `zoom_rooms` */

insert  into `zoom_rooms`(`id`,`zoom_account_id`,`room_no`,`status_id`,`school_id`) values (1,1,1,3,1),(2,1,2,2,1),(3,1,3,1,0),(4,1,4,1,0),(5,1,5,1,0),(6,1,6,1,0),(7,1,7,1,0),(8,1,8,1,0),(9,1,9,1,0),(10,1,10,1,0),(11,1,11,1,0),(12,1,12,1,0),(13,1,13,1,0),(14,1,14,1,0),(15,1,15,1,0),(16,1,16,1,0),(17,1,17,1,0),(18,1,18,1,0),(19,1,19,1,0),(20,1,20,1,0),(21,1,21,1,0),(22,1,22,1,0),(23,1,23,1,0),(24,1,24,1,0),(25,1,25,1,0),(26,1,26,1,0),(27,1,27,1,0),(28,1,28,1,0),(29,1,29,1,0),(30,1,30,1,0),(31,1,31,1,0),(32,1,32,1,0),(33,1,33,1,0),(34,1,34,1,0),(35,1,35,1,0),(36,1,36,1,0),(37,1,37,1,0),(38,1,38,1,0),(39,1,39,1,0),(40,1,40,1,0),(41,1,41,1,0),(42,1,42,1,0),(43,1,43,1,0),(44,1,44,1,0),(45,1,45,1,0),(46,1,46,1,0),(47,1,47,1,0),(48,1,48,1,0),(49,1,49,1,0),(50,1,50,1,0),(51,2,1,1,0),(52,2,2,1,0),(53,2,3,1,0),(54,2,4,1,0),(55,2,5,1,0),(56,2,6,1,0),(57,2,7,1,0),(58,2,8,1,0),(59,2,9,1,0),(60,2,10,1,0),(61,2,11,1,0),(62,2,12,1,0),(63,2,13,1,0),(64,2,14,1,0),(65,2,15,1,0),(66,2,16,1,0),(67,2,17,1,0),(68,2,18,1,0),(69,2,19,1,0),(70,2,20,1,0),(71,2,21,1,0),(72,2,22,1,0),(73,2,23,1,0),(74,2,24,1,0),(75,2,25,1,0),(76,2,26,1,0),(77,2,27,1,0),(78,2,28,1,0),(79,2,29,1,0),(80,2,30,1,0),(81,2,31,1,0),(82,2,32,1,0),(83,2,33,1,0),(84,2,34,1,0),(85,2,35,1,0),(86,2,36,1,0),(87,2,37,1,0),(88,2,38,1,0),(89,2,39,1,0),(90,2,40,1,0),(91,2,41,1,0),(92,2,42,1,0),(93,2,43,1,0),(94,2,44,1,0),(95,2,45,1,0),(96,2,46,1,0),(97,2,47,1,0),(98,2,48,1,0),(99,2,49,1,0),(100,2,50,1,0),(101,3,1,1,0),(102,3,2,1,0),(103,3,3,1,0),(104,3,4,1,0),(105,3,5,1,0),(106,3,6,1,0),(107,3,7,1,0),(108,3,8,1,0),(109,3,9,1,0),(110,3,10,1,0),(111,3,11,1,0),(112,3,12,1,0),(113,3,13,1,0),(114,3,14,1,0),(115,3,15,1,0),(116,3,16,1,0),(117,3,17,1,0),(118,3,18,1,0),(119,3,19,1,0),(120,3,20,1,0),(121,3,21,1,0),(122,3,22,1,0),(123,3,23,1,0),(124,3,24,1,0),(125,3,25,1,0),(126,3,26,1,0),(127,3,27,1,0),(128,3,28,1,0),(129,3,29,1,0),(130,3,30,1,0),(131,3,31,1,0),(132,3,32,1,0),(133,3,33,1,0),(134,3,34,1,0),(135,3,35,1,0),(136,3,36,1,0),(137,3,37,1,0),(138,3,38,1,0),(139,3,39,1,0),(140,3,40,1,0),(141,3,41,1,0),(142,3,42,1,0),(143,3,43,1,0),(144,3,44,1,0),(145,3,45,1,0),(146,3,46,1,0),(147,3,47,1,0),(148,3,48,1,0),(149,3,49,1,0),(150,3,50,1,0),(151,4,1,1,0),(152,4,2,1,0),(153,4,3,1,0),(154,4,4,1,0),(155,4,5,1,0),(156,4,6,1,0),(157,4,7,1,0),(158,4,8,1,0),(159,4,9,1,0),(160,4,10,1,0),(161,4,11,1,0),(162,4,12,1,0),(163,4,13,1,0),(164,4,14,1,0),(165,4,15,1,0),(166,4,16,1,0),(167,4,17,1,0),(168,4,18,1,0),(169,4,19,1,0),(170,4,20,1,0),(171,4,21,1,0),(172,4,22,1,0),(173,4,23,1,0),(174,4,24,1,0),(175,4,25,1,0),(176,4,26,1,0),(177,4,27,1,0),(178,4,28,1,0),(179,4,29,1,0),(180,4,30,1,0),(181,4,31,1,0),(182,4,32,1,0),(183,4,33,1,0),(184,4,34,1,0),(185,4,35,1,0),(186,4,36,1,0),(187,4,37,1,0),(188,4,38,1,0),(189,4,39,1,0),(190,4,40,1,0),(191,4,41,1,0),(192,4,42,1,0),(193,4,43,1,0),(194,4,44,1,0),(195,4,45,1,0),(196,4,46,1,0),(197,4,47,1,0),(198,4,48,1,0),(199,4,49,1,0),(200,4,50,1,0),(201,5,1,1,0),(202,5,2,1,0),(203,5,3,1,0),(204,5,4,1,0),(205,5,5,1,0),(206,5,6,1,0),(207,5,7,1,0),(208,5,8,1,0),(209,5,9,1,0),(210,5,10,1,0),(211,5,11,1,0),(212,5,12,1,0),(213,5,13,1,0),(214,5,14,1,0),(215,5,15,1,0),(216,5,16,1,0),(217,5,17,1,0),(218,5,18,1,0),(219,5,19,1,0),(220,5,20,1,0),(221,5,21,1,0),(222,5,22,1,0),(223,5,23,1,0),(224,5,24,1,0),(225,5,25,1,0),(226,5,26,1,0),(227,5,27,1,0),(228,5,28,1,0),(229,5,29,1,0),(230,5,30,1,0),(231,5,31,1,0),(232,5,32,1,0),(233,5,33,1,0),(234,5,34,1,0),(235,5,35,1,0),(236,5,36,1,0),(237,5,37,1,0),(238,5,38,1,0),(239,5,39,1,0),(240,5,40,1,0),(241,5,41,1,0),(242,5,42,1,0),(243,5,43,1,0),(244,5,44,1,0),(245,5,45,1,0),(246,5,46,1,0),(247,5,47,1,0),(248,5,48,1,0),(249,5,49,1,0),(250,5,50,1,0),(251,6,1,1,0),(252,6,2,1,0),(253,6,3,1,0),(254,6,4,1,0),(255,6,5,1,0),(256,6,6,1,0),(257,6,7,1,0),(258,6,8,1,0),(259,6,9,1,0),(260,6,10,1,0),(261,6,11,1,0),(262,6,12,1,0),(263,6,13,1,0),(264,6,14,1,0),(265,6,15,1,0),(266,6,16,1,0),(267,6,17,1,0),(268,6,18,1,0),(269,6,19,1,0),(270,6,20,1,0),(271,6,21,1,0),(272,6,22,1,0),(273,6,23,1,0),(274,6,24,1,0),(275,6,25,1,0),(276,6,26,1,0),(277,6,27,1,0),(278,6,28,1,0),(279,6,29,1,0),(280,6,30,1,0),(281,6,31,1,0),(282,6,32,1,0),(283,6,33,1,0),(284,6,34,1,0),(285,6,35,1,0),(286,6,36,1,0),(287,6,37,1,0),(288,6,38,1,0),(289,6,39,1,0),(290,6,40,1,0),(291,6,41,1,0),(292,6,42,1,0),(293,6,43,1,0),(294,6,44,1,0),(295,6,45,1,0),(296,6,46,1,0),(297,6,47,1,0),(298,6,48,1,0),(299,6,49,1,0),(300,6,50,1,0),(301,7,1,1,0),(302,7,2,1,0),(303,7,3,1,0),(304,7,4,1,0),(305,7,5,1,0),(306,7,6,1,0),(307,7,7,1,0),(308,7,8,1,0),(309,7,9,1,0),(310,7,10,1,0),(311,7,11,1,0),(312,7,12,1,0),(313,7,13,1,0),(314,7,14,1,0),(315,7,15,1,0),(316,7,16,1,0),(317,7,17,1,0),(318,7,18,1,0),(319,7,19,1,0),(320,7,20,1,0),(321,7,21,1,0),(322,7,22,1,0),(323,7,23,1,0),(324,7,24,1,0),(325,7,25,1,0),(326,7,26,1,0),(327,7,27,1,0),(328,7,28,1,0),(329,7,29,1,0),(330,7,30,1,0),(331,7,31,1,0),(332,7,32,1,0),(333,7,33,1,0),(334,7,34,1,0),(335,7,35,1,0),(336,7,36,1,0),(337,7,37,1,0),(338,7,38,1,0),(339,7,39,1,0),(340,7,40,1,0),(341,7,41,1,0),(342,7,42,1,0),(343,7,43,1,0),(344,7,44,1,0),(345,7,45,1,0),(346,7,46,1,0),(347,7,47,1,0),(348,7,48,1,0),(349,7,49,1,0),(350,7,50,1,0);

/*Table structure for table `zoom_rooms_log` */

DROP TABLE IF EXISTS `zoom_rooms_log`;

CREATE TABLE `zoom_rooms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `room_id` int(11) NOT NULL,
  `school_id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `room_closed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `zoom_rooms_log` */

insert  into `zoom_rooms_log`(`id`,`room_id`,`school_id`,`team_id`,`status_id`,`room_closed`) values (1,1,1,1,3,NULL),(2,1,1,2,3,NULL),(3,1,1,3,3,NULL),(4,2,1,4,2,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
