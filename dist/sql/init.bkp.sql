# ************************************************************
# Sequel Pro SQL dump
# Version 4529
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.44-0ubuntu0.14.04.1)
# Database: dbhcare
# Generation Time: 2016-05-11 08:49:51 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table agents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `agents`;

CREATE TABLE `agents` (
  `id` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(250) NOT NULL,
  `source_info` varchar(100) DEFAULT NULL,
  `referal_code` varchar(20) DEFAULT NULL,
  `subscribe_newsletter` varchar(3) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `profile_pic_name` varchar(250) DEFAULT NULL,
  `activation_code` varchar(150) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `mood` text,
  `samplefield` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table api
# ------------------------------------------------------------

DROP TABLE IF EXISTS `api`;

CREATE TABLE `api` (
  `client_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `public_id` char(64) NOT NULL DEFAULT '',
  `private_key` char(64) NOT NULL DEFAULT '',
  `status` enum('ACTIVE','INACTIVE') DEFAULT 'ACTIVE',
  PRIMARY KEY (`client_id`),
  UNIQUE KEY `private_key` (`private_key`),
  UNIQUE KEY `public_id` (`public_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `api` WRITE;
/*!40000 ALTER TABLE `api` DISABLE KEYS */;

INSERT INTO `api` (`client_id`, `public_id`, `private_key`, `status`)
VALUES
	(1,'','593fe6ed77014f9507761028801aa376f141916bd26b1b3f0271b5ec3135b989','ACTIVE');

/*!40000 ALTER TABLE `api` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table members
# ------------------------------------------------------------

DROP TABLE IF EXISTS `members`;

CREATE TABLE `members` (
  `memberid` varchar(250) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(500) NOT NULL,
  `permission` int(11) NOT NULL,
  `firstname` varchar(250) DEFAULT NULL,
  `middlename` varchar(250) DEFAULT NULL,
  `lastname` varchar(250) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` char(10) DEFAULT NULL,
  `address` text,
  `picture` text,
  `datecreated` datetime NOT NULL,
  `dateedited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`memberid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;

INSERT INTO `members` (`memberid`, `username`, `email`, `password`, `permission`, `firstname`, `middlename`, `lastname`, `birthdate`, `gender`, `address`, `picture`, `datecreated`, `dateedited`)
VALUES
	('3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','superagent','support@geeksnest.com','7c222fb2927d828af22f592134e8932480637c0d',0,'Superagent','geeks','Geeksnest','2015-01-05','Male','Urdaneta City Pangasinan','hfmL09FNaNkaMZB2ib52ixGeIbOgZXey.jpg','2016-04-27 20:25:11','2016-04-27 20:25:11'),
	('44B11111-0A6F-422B-B323-1CBF7751B9F2','hartjo','llarenasjanrainier@gmail.com','9e6c9d8ae3a0201fa8c6bc12bcd811129ace90f4',0,'Jan Rainier','Manaois','Llarenas','2016-03-10','Male','SMP','SoksPmSregLQzSVeDr4GCU4rgSlN9qRx.jpg','2016-03-10 00:00:00','2016-03-14 01:42:41');

/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table membersdirectory
# ------------------------------------------------------------

DROP TABLE IF EXISTS `membersdirectory`;

CREATE TABLE `membersdirectory` (
  `directoryid` varchar(250) NOT NULL,
  `memberid` varchar(250) NOT NULL,
  `directorytitle` varchar(250) NOT NULL,
  `directorypath` mediumtext NOT NULL,
  `contentpath` mediumtext NOT NULL,
  `datecreated` datetime NOT NULL,
  `dateedited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`directoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `membersdirectory` WRITE;
/*!40000 ALTER TABLE `membersdirectory` DISABLE KEYS */;

INSERT INTO `membersdirectory` (`directoryid`, `memberid`, `directorytitle`, `directorypath`, `contentpath`, `datecreated`, `dateedited`)
VALUES
	('7DDBC9DA-B0C7-4641-A2DC-65E69B4A8F56','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','sample folder','/','/C92151A9-F063-4DEC-8B7B-5720AB33DF6A','2016-04-28 21:02:10','2016-04-28 21:02:10'),
	('A13806C1-0BCF-4B5F-ABFC-8D27889E7275','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','sample folder(sub folder)','/C92151A9-F063-4DEC-8B7B-5720AB33DF6A','/C92151A9-F063-4DEC-8B7B-5720AB33DF6A/764ACD3E-F5EA-489C-A852-1741F4309FF6','2016-04-28 21:13:26','2016-04-28 21:13:26');

/*!40000 ALTER TABLE `membersdirectory` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table membersfile
# ------------------------------------------------------------

DROP TABLE IF EXISTS `membersfile`;

CREATE TABLE `membersfile` (
  `fileid` varchar(250) NOT NULL,
  `memberid` varchar(250) NOT NULL,
  `filetitle` varchar(500) NOT NULL,
  `filedescription` text NOT NULL,
  `filepath` longtext NOT NULL,
  `filename` text NOT NULL,
  `filetype` varchar(250) NOT NULL,
  `datecreated` datetime NOT NULL,
  `dateedited` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`fileid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `membersfile` WRITE;
/*!40000 ALTER TABLE `membersfile` DISABLE KEYS */;

INSERT INTO `membersfile` (`fileid`, `memberid`, `filetitle`, `filedescription`, `filepath`, `filename`, `filetype`, `datecreated`, `dateedited`)
VALUES
	('0B2C5EA0-FF26-43CA-BDAD-C7A9A91D166E','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','ewrwewt','etwetw','/','qyp63jo47vi14520208136970.jpg','image','2016-04-28 00:01:26','2016-04-28 00:01:26'),
	('1B6F1E28-ED49-4DCB-AA0F-CB7F8D323C05','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','2222222','sdsdg dfgdgdg','/','General test scenarios.xlsx','application','2016-04-28 00:02:00','2016-04-28 00:02:00'),
	('21F688B7-3EC2-448C-A86C-2AB58D0EFDC3','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','hrttrr@#523``~','yhreye21$!2$12`~ eirwerhw tiwetiweutiweotu ewtwetwoiutwoit \nfrasrsar','/','[Revised_Wireframe] PowerBrainEducation.com.pptx','application','2016-04-28 00:03:03','2016-04-28 00:03:03'),
	('3B964EAD-E877-4B73-826E-A51B49306969','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','adadda@1!@`~\'','sample','/','tumblr_ni2xwbNQEO1u6jz3do1_1280.jpg','image','2016-04-27 23:36:23','2016-04-27 23:36:23'),
	('3D741692-C815-41EF-9220-E10B3E4DE926','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','sample video','sffsafasa 421%! sdDsG\ngssg \nGEETte65^85','/','Selenium TestNG Tutorial.mp4','video','2016-04-27 23:47:03','2016-04-27 23:47:03'),
	('7E356DBA-2CA6-4031-B88F-B53F834AAF67','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','OASIS C1','START OF CARE','/C92151A9-F063-4DEC-8B7B-5720AB33DF6A','cat3.pdf','application','2016-04-28 21:16:14','2016-04-28 21:16:14'),
	('8DC92AF4-FCA0-4735-BA4C-848E09DB25F8','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','#4','sdsgsgsgsg','/','kuqjrvhd7vi14534986052210~` ssaassa.jpg','image','2016-04-27 23:54:11','2016-04-27 23:54:11'),
	('917F6CA4-50CF-4790-AFB9-E750C1061944','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','xcfjhfh asaasfsf','ertewtwetwe','/','Tanung.txt','text','2016-04-28 00:02:31','2016-04-28 00:02:31'),
	('A31B766F-C8D9-43A0-BBFD-1F95C49D048B','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','wetwet','dsfsggssgsgs','/','FAQ (BNB).docx','application','2016-04-28 00:01:38','2016-04-28 00:01:38'),
	('ACA96FAE-22F5-489F-BA50-ACFC0B8472C6','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','adadda@1!@`~\'','sama ssama21@!42`~`\'','/','1471280300677973315.jpg','image','2016-04-27 23:37:28','2016-04-27 23:37:28'),
	('D5AD8705-65F6-4678-BBFF-4DCF54CF6371','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','wrwer12$12@','gsgsdgsdgsdg','/','index.html','text','2016-04-28 00:02:16','2016-04-28 00:02:16'),
	('F2629DB7-8FD8-4FED-9479-01444A5CF6B1','3AF6D25B-DD7F-497B-9FA9-2B8C1E18ECB3','23525sdfsdg','gwgewtgwwds','/','cat3.pdf','application','2016-04-28 00:01:50','2016-04-28 00:01:50');

/*!40000 ALTER TABLE `membersfile` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
