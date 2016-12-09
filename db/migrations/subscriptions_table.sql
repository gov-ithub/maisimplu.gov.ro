CREATE DATABASE  IF NOT EXISTS `maisimplu` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `maisimplu`;
-- MySQL dump 10.13  Distrib 5.6.23, for Win64 (x86_64)
--
-- Host: localhost    Database: maisimplu
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
-- Table structure for table `maisiwp_subscriptions`
--

DROP TABLE IF EXISTS `maisiwp_subscriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `maisiwp_subscriptions` (
  `subscription_id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_userid` bigint(20) unsigned NOT NULL,
  `subscription_postid` bigint(20) unsigned NOT NULL COMMENT 'referinta catre un anumit topic pentru subscrierile de tipul 2; null pentru subscrieri la newsletter generic, de tipul 1',
  `subscription_enabled` tinyint(1) DEFAULT '1',
  `subscription_startdate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `subscription_enddate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`subscription_id`),
  KEY `USERS` (`subscription_userid`),
  KEY `POSTS` (`subscription_postid`),
  CONSTRAINT `POST_ID` FOREIGN KEY (`subscription_postid`) REFERENCES `maisiwp_posts` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `USER_ID` FOREIGN KEY (`subscription_userid`) REFERENCES `maisiwp_users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `maisiwp_subscriptions`
--

LOCK TABLES `maisiwp_subscriptions` WRITE;
/*!40000 ALTER TABLE `maisiwp_subscriptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `maisiwp_subscriptions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-25 15:03:13
