-- MySQL dump 10.13  Distrib 5.6.19, for osx10.7 (i386)
--
-- Host: localhost    Database: dbphalconrest
-- ------------------------------------------------------
-- Server version	5.6.24

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `api`
--

DROP TABLE IF EXISTS `api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api` (
  `client_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `public_id` char(64) NOT NULL DEFAULT '',
  `private_key` char(64) NOT NULL DEFAULT '',
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE',
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `private_key` (`private_key`),
  UNIQUE KEY `public_id` (`public_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api`
--

LOCK TABLES `api` WRITE;
/*!40000 ALTER TABLE `api` DISABLE KEYS */;
INSERT INTO `api` VALUES (1,'','593fe6ed77014f9507761028801aa376f141916bd26b1b3f0271b5ec3135b989','ACTIVE');
/*!40000 ALTER TABLE `api` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roleitems`
--

DROP TABLE IF EXISTS `roleitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roleitems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL DEFAULT '',
  `items` varchar(250) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roleitems`
--

LOCK TABLES `roleitems` WRITE;
/*!40000 ALTER TABLE `roleitems` DISABLE KEYS */;
INSERT INTO `roleitems` VALUES (1,'s1','api roles example for testpost'),(2,'s2','api roles example for testget'),(3,'userlogin','api role for /login and /refreshtoken'),(4,'roles','api role for /initroles'),(5,'s3','api role for authtest'),(6,'s4','api role for map');
/*!40000 ALTER TABLE `roleitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userroles`
--

DROP TABLE IF EXISTS `userroles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userroles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(250) NOT NULL DEFAULT '',
  `role` char(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userroles`
--

LOCK TABLES `userroles` WRITE;
/*!40000 ALTER TABLE `userroles` DISABLE KEYS */;
INSERT INTO `userroles` VALUES (1,'993E2021-89CB-4E36-B47E-F90332664A96','s1'),(2,'993E2021-89CB-4E36-B47E-F90332664A96','s2'),(3,'993E2021-89CB-4E36-B47E-F90332664A96','s3'),(4,'993E2021-89CB-4E36-B47E-F90332664A96','s4'),(5,'993E2021-89CB-4E36-B47E-F90332664A96','roles'),(6,'4C085AF7-C337-40BA-AE38-B0BEB961ECAE','s1'),(7,'4C085AF7-C337-40BA-AE38-B0BEB961ECAE','s2'),(8,'C0A13197-7711-40CF-8C24-0AE55CBB16F4','s4'),(9,'C0A13197-7711-40CF-8C24-0AE55CBB16F4','roles');
/*!40000 ALTER TABLE `userroles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `userid` varchar(250) NOT NULL DEFAULT '',
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(500) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `lastname` varchar(250) NOT NULL,
  `suffix` char(10) DEFAULT NULL,
  `birthdate` date NOT NULL,
  `gender` char(10) NOT NULL,
  `credential` varchar(150) NOT NULL,
  `title` varchar(150) NOT NULL,
  `employeetype` int(11) NOT NULL,
  `ssn` varchar(250) NOT NULL,
  `employeeid` varchar(250) NOT NULL,
  `address1` text NOT NULL,
  `address2` text,
  `city` varchar(250) NOT NULL,
  `state` varchar(250) NOT NULL,
  `zip` varchar(250) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `mobile` varchar(250) NOT NULL,
  `picture` text,
  `userLevel` char(10) DEFAULT NULL,
  `permission` int(11) DEFAULT NULL,
  `datecreated` datetime NOT NULL,
  `dateedited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('4C085AF7-C337-40BA-AE38-B0BEB961ECAE','efren','efrenbautistajr@gmail.com','7c222fb2927d828af22f592134e8932480637c0d','efren','bautista',NULL,'2016-06-10','Female','','',0,'','','',NULL,'','','','','',NULL,'ADMIN\n',NULL,'2016-06-10 14:02:24','2016-09-21 06:33:17'),('993E2021-89CB-4E36-B47E-F90332664A96','superagent','superagent@mailinator.com','7c222fb2927d828af22f592134e8932480637c0d','superagent','superagent','','2016-06-10','Male','0','0',0,'123-12-3123','23123','123132','sda','0','0','123123','(123)213-1231','(123)123-1231','default.jpg','OWNER',NULL,'2016-06-10 14:02:24','2016-09-20 09:42:08'),('C0A13197-7711-40CF-8C24-0AE55CBB16F4','jassie','efren.bautista.jr@geeksnest.com','7c222fb2927d828af22f592134e8932480637c0d','jassie','bautista',NULL,'1986-02-10','Male','','',0,'123-12-1234','123123','123123',NULL,'','','','','',NULL,'USER',NULL,'2016-06-10 14:02:24','2016-09-21 06:39:59');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-23 16:17:11
