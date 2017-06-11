# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 192.168.6.108 (MySQL 5.6.22)
# Database: box
# Generation Time: 2017-06-05 12:28:58 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table lb_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lb_category`;

CREATE TABLE `lb_category` (
  `cat_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) NOT NULL DEFAULT '',
  `sort` int(11) DEFAULT '0' COMMENT '排序',
  `type` int(11) DEFAULT '0' COMMENT '1:audio 2:video',
  `cover_pic` varchar(100) DEFAULT NULL,
  `status` int(11) DEFAULT '1' COMMENT '1. 正常 2. 异常',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `lb_category` WRITE;
/*!40000 ALTER TABLE `lb_category` DISABLE KEYS */;

INSERT INTO `lb_category` (`cat_id`, `cat_name`, `sort`, `type`, `cover_pic`, `status`, `created_at`, `updated_at`)
VALUES
	(9,'Music 1-Chant',0,2,NULL,1,NULL,NULL),
	(10,'Music 1-Dance',0,2,NULL,1,NULL,NULL),
	(11,'Music 2-Chant',0,2,NULL,1,NULL,NULL),
	(12,'Music 2-Dance',0,2,NULL,1,NULL,NULL),
	(13,'Firstleap Songs 1',0,2,NULL,1,NULL,NULL),
	(14,'Firstleap Songs 2',0,2,NULL,1,NULL,NULL),
	(15,'Firstleap Songs 3',0,2,NULL,1,NULL,NULL),
	(16,'Kids Vocabulary',0,2,NULL,1,NULL,NULL),
	(17,'Theme',0,0,NULL,1,NULL,NULL);

/*!40000 ALTER TABLE `lb_category` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
