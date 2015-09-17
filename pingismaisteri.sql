-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: pingismaisteri
-- ------------------------------------------------------
-- Server version	5.6.26

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
-- Table structure for table `pingis2_access_objects`
--

DROP TABLE IF EXISTS `pingis2_access_objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_access_objects` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `role_id` int(4) NOT NULL,
  `controller` varchar(32) NOT NULL,
  `action` varchar(32) DEFAULT NULL,
  `type` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_access_objects`
--

LOCK TABLES `pingis2_access_objects` WRITE;
/*!40000 ALTER TABLE `pingis2_access_objects` DISABLE KEYS */;
INSERT INTO `pingis2_access_objects` VALUES (1,1,'tournaments','view','allow'),(2,2,'tournaments','view','allow'),(3,3,'tournaments','view','allow'),(4,2,'tournaments','edit','allow'),(5,3,'tournaments','edit','allow'),(6,2,'tournaments','add','allow'),(7,3,'tournaments','add','allow'),(8,1,'tournaments','register','allow'),(9,2,'tournaments','register','allow'),(10,3,'tournaments','register','allow'),(11,1,'tournaments','show','allow'),(12,2,'tournaments','show','allow'),(13,3,'tournaments','show','allow'),(14,3,'tournaments','deletetournament','allow'),(15,2,'tournaments','deletetournament','allow'),(16,3,'tournaments','collecttournamentdata','allow'),(17,2,'tournaments','collecttournamentdata','allow'),(18,3,'tournaments','sendemail','allow'),(19,2,'tournaments','sendemail','allow'),(20,3,'tournamentclasses','*','allow'),(21,2,'tournamentclasses','*','allow'),(22,2,'users','*','allow'),(23,3,'users','*','allow'),(24,1,'users','myaccount','allow'),(25,0,'users','validateemail','allow'),(26,1,'users','validateemail','allow'),(27,0,'users','forgotpassword','allow'),(28,0,'users','register','allow'),(29,0,'users','login','allow'),(30,1,'users','logout','allow'),(33,1,'users','addplayer','allow'),(36,1,'users','changepassword','allow'),(39,2,'ajax','newtournamentclassrow','allow'),(40,2,'ajax','removerowfromclass','allow'),(41,3,'ajax','newtournamentclassrow','allow'),(42,3,'ajax','removerowfromclass','allow'),(43,2,'clubs','*','allow'),(44,3,'clubs','*','allow'),(45,2,'files','*','alloe'),(46,3,'files','*','allow'),(47,0,'pages','display','allow'),(48,1,'pages','display','allow'),(49,2,'pages','display','allow'),(50,3,'pages','display','allow'),(51,1,'users','login','deny'),(52,2,'users','login','deny'),(53,3,'users','login','deny'),(54,1,'users','register','deny'),(55,2,'users','register','deny'),(56,3,'users','register','deny'),(57,1,'users','cancelregistration','allow'),(58,3,'tournaments','*','allow'),(59,1,'users','deleteplayer','allow'),(60,2,'users','deleteplayer','allow');
/*!40000 ALTER TABLE `pingis2_access_objects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_class_in_tournaments`
--

DROP TABLE IF EXISTS `pingis2_class_in_tournaments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_class_in_tournaments` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `tournament_id` int(8) NOT NULL,
  `tournament_class_id` int(8) NOT NULL,
  `date` date DEFAULT NULL,
  `description` text,
  `price` decimal(6,2) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `maxage` int(3) NOT NULL,
  `minage` int(3) DEFAULT NULL,
  `maxrating` int(4) DEFAULT NULL,
  `minrating` int(4) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_class_in_tournaments`
--

LOCK TABLES `pingis2_class_in_tournaments` WRITE;
/*!40000 ALTER TABLE `pingis2_class_in_tournaments` DISABLE KEYS */;
INSERT INTO `pingis2_class_in_tournaments` VALUES (6,1,5,'2014-02-22',NULL,12.00,'',0,NULL,NULL,NULL,NULL),(7,1,6,'2014-02-22',NULL,12.00,'',0,NULL,NULL,NULL,NULL),(8,1,7,'2014-02-22',NULL,12.00,'',0,NULL,NULL,NULL,NULL),(9,1,8,'2014-02-22',NULL,12.00,'',0,NULL,NULL,NULL,NULL),(10,1,9,'2014-02-22',NULL,12.00,'',0,NULL,NULL,NULL,NULL),(11,1,10,'2014-02-22',NULL,12.00,'',0,NULL,NULL,NULL,NULL),(12,1,11,'2014-02-22',NULL,12.00,'',0,NULL,NULL,NULL,NULL),(13,1,12,'2014-02-22',NULL,7.00,'',0,NULL,NULL,NULL,NULL),(14,1,13,'2014-02-22',NULL,7.00,'',0,NULL,NULL,NULL,NULL),(15,1,18,'2014-02-22',NULL,7.00,'',0,NULL,NULL,NULL,NULL),(16,1,14,'2014-02-22',NULL,7.00,'',0,NULL,NULL,NULL,NULL),(17,1,15,'2014-02-22',NULL,7.00,'',0,NULL,NULL,NULL,NULL),(18,1,16,'2014-02-22',NULL,12.00,'',0,NULL,NULL,NULL,NULL),(19,1,17,'2014-02-22',NULL,10.00,'',0,NULL,NULL,NULL,NULL),(23,3,3,'0014-02-15',NULL,10.00,'',0,NULL,NULL,NULL,NULL),(24,3,4,'0014-02-15',NULL,10.00,'',0,NULL,NULL,NULL,NULL),(25,8,7,'2015-09-03',NULL,123.00,'',0,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `pingis2_class_in_tournaments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_clubs`
--

DROP TABLE IF EXISTS `pingis2_clubs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_clubs` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_clubs`
--

LOCK TABLES `pingis2_clubs` WRITE;
/*!40000 ALTER TABLE `pingis2_clubs` DISABLE KEYS */;
INSERT INTO `pingis2_clubs` VALUES (1,'LPTS'),(2,'KoKa'),(3,'Atlas'),(4,'HUT'),(5,'TuKa'),(6,'NuPS'),(7,'PT Espoo'),(8,'TIP-70'),(9,'Ballong'),(10,'BF-78'),(11,'BK'),(12,'Boom'),(13,'GraPi'),(14,'Gurut'),(15,'HarSpo'),(16,'HaTe'),(17,'Heitto'),(18,'HIK'),(19,'HP'),(20,'H盲Ki'),(21,'IPT-94'),(22,'JPT'),(23,'JysRy'),(24,'KePts'),(26,'KoKu'),(27,'KSF'),(28,'KuPTS'),(29,'KurVi'),(30,'Laivasto'),(31,'LeVi'),(32,'LiPi'),(33,'LoLo'),(34,'LoVo'),(35,'LrTU'),(36,'Maraton'),(37,'MBF'),(38,'MPS'),(39,'MPTS-13'),(41,'Nu-Se'),(42,'OPT-86'),(43,'Pallas'),(44,'Pa-Po'),(45,'ParPi'),(46,'PiPy'),(47,'Por-83'),(48,'PT 75'),(49,'PT-2000'),(50,'PTS-60'),(51,'RGB'),(52,'SeSi'),(53,'Spinni'),(54,'SS'),(55,'Star'),(56,'Stara'),(57,'ToTe'),(58,'TuPy'),(59,'TuTo'),(60,'T盲hti'),(61,'UU'),(62,'Vana'),(63,'VarTa'),(64,'Wega'),(65,'VehVi'),(66,'YNM');
/*!40000 ALTER TABLE `pingis2_clubs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_player_in_pools`
--

DROP TABLE IF EXISTS `pingis2_player_in_pools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_player_in_pools` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `pool_id` int(4) NOT NULL,
  `player_id` int(4) NOT NULL,
  `order` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1322 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_player_in_pools`
--

LOCK TABLES `pingis2_player_in_pools` WRITE;
/*!40000 ALTER TABLE `pingis2_player_in_pools` DISABLE KEYS */;
INSERT INTO `pingis2_player_in_pools` VALUES (1,1,50,''),(2,1,49,''),(3,1,18,''),(4,1,51,''),(5,2,18,''),(6,2,51,''),(7,2,53,''),(8,3,16,''),(9,3,29,''),(10,3,41,''),(11,4,41,''),(12,4,42,''),(13,4,17,''),(14,4,45,''),(15,5,43,''),(16,5,34,''),(17,5,44,''),(18,5,28,''),(19,6,43,''),(20,6,44,''),(21,6,45,''),(22,6,23,''),(23,7,42,''),(24,7,36,''),(25,7,28,''),(26,7,40,''),(27,8,34,''),(28,8,17,''),(29,8,37,''),(30,8,47,''),(31,9,37,''),(32,9,47,''),(33,9,33,''),(34,10,28,''),(35,10,54,''),(36,10,25,''),(37,11,23,''),(38,11,38,''),(39,11,24,''),(40,12,40,''),(41,12,5,''),(42,12,32,''),(43,12,19,''),(44,13,39,''),(45,13,13,''),(46,13,52,''),(47,13,27,''),(48,14,38,''),(49,14,33,''),(50,14,12,''),(51,15,54,''),(52,15,25,''),(53,15,26,''),(54,16,5,''),(55,16,24,''),(56,16,30,''),(57,16,27,''),(58,17,13,''),(59,17,32,''),(60,17,52,''),(61,17,19,''),(62,18,18,''),(63,18,29,''),(64,18,43,''),(65,18,5,''),(66,19,16,''),(67,19,35,''),(68,19,44,''),(69,19,39,''),(70,20,47,''),(71,20,48,''),(72,22,28,''),(73,25,43,''),(74,25,40,''),(75,25,33,''),(76,26,34,''),(77,26,5,''),(78,26,52,''),(79,26,19,''),(80,27,44,''),(81,27,23,''),(82,27,24,''),(83,27,26,''),(84,28,36,''),(85,28,39,''),(86,28,32,''),(87,28,27,''),(88,29,12,''),(89,29,26,''),(90,29,30,''),(91,29,48,''),(92,30,50,''),(93,30,49,''),(94,30,18,''),(95,30,51,''),(96,31,18,''),(97,31,51,''),(98,31,53,''),(99,32,16,''),(100,32,29,''),(101,32,41,''),(102,33,41,''),(103,33,42,''),(104,33,44,''),(105,33,45,''),(106,34,43,''),(107,34,34,''),(108,34,17,''),(109,34,28,''),(110,35,43,''),(111,35,36,''),(112,35,37,''),(113,35,47,''),(114,36,42,''),(115,36,44,''),(116,36,28,''),(117,36,23,''),(118,37,34,''),(119,37,17,''),(120,37,45,''),(121,37,40,''),(122,38,37,''),(123,38,13,''),(124,38,24,''),(125,39,28,''),(126,39,38,''),(127,39,33,''),(128,40,23,''),(129,40,5,''),(130,40,52,''),(131,41,40,''),(132,41,54,''),(133,41,32,''),(134,41,27,''),(135,42,39,''),(136,42,47,''),(137,42,25,''),(138,42,19,''),(139,43,38,''),(140,43,24,''),(141,43,26,''),(142,44,54,''),(143,44,33,''),(144,44,30,''),(145,45,5,''),(146,45,25,''),(147,45,12,''),(148,45,19,''),(149,46,13,''),(150,46,32,''),(151,46,52,''),(152,46,27,''),(153,47,18,''),(154,47,29,''),(155,47,44,''),(156,47,5,''),(157,48,16,''),(158,48,35,''),(159,48,43,''),(160,48,39,''),(161,49,47,''),(162,49,48,''),(163,51,28,''),(164,54,43,''),(165,54,40,''),(166,54,24,''),(167,55,34,''),(168,55,23,''),(169,55,33,''),(170,55,27,''),(171,56,44,''),(172,56,39,''),(173,56,52,''),(174,56,19,''),(175,57,36,''),(176,57,5,''),(177,57,32,''),(178,57,26,''),(179,58,12,''),(180,58,26,''),(181,58,30,''),(182,58,48,'');
/*!40000 ALTER TABLE `pingis2_player_in_pools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_players`
--

DROP TABLE IF EXISTS `pingis2_players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_players` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `address` varchar(32) DEFAULT NULL,
  `postalcode` varchar(8) DEFAULT NULL,
  `postarea` varchar(32) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `club_id` int(4) DEFAULT NULL,
  `license_code` varchar(16) DEFAULT NULL,
  `license_status` varchar(16) DEFAULT NULL,
  `license_renewed` datetime DEFAULT NULL,
  `license_type` varchar(1) DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` int(8) DEFAULT NULL,
  `rating_id` int(8) DEFAULT NULL,
  `sptl_id` int(8) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_players`
--

LOCK TABLES `pingis2_players` WRITE;
/*!40000 ALTER TABLE `pingis2_players` DISABLE KEYS */;
INSERT INTO `pingis2_players` VALUES (2,'Miikka','K盲hk枚nen','Tampellan Esplanadi','33100','Tampere','1988-10-31','M',NULL,NULL,NULL,NULL,NULL,'kahmiikka@gmail.com','0408458907','2014-01-30 20:48:31',NULL,NULL,NULL),(3,'Essi','Esimerkki','Esimerkkitie 1','33820','Tampere','1991-06-16','F',60,NULL,NULL,NULL,NULL,'essi.esimerkki@uta.fi','','2014-02-02 18:26:28',NULL,NULL,NULL),(4,'Timo','Testi','Testitie 1','33820','Tampere','1990-05-08','M',3,NULL,NULL,NULL,NULL,'timo.testi@uta.fi','','2014-02-02 18:27:36',NULL,NULL,NULL),(5,'Jyrki','Nummenmaa','Tohtorinkatu 10','33720','Tampere','1961-05-01','M',48,NULL,NULL,NULL,NULL,'jyrki.nummenmaa@gmail.com','040-5277999','2014-02-05 07:48:25',NULL,NULL,NULL),(6,'Pekka','Pingistelij盲','','','','2000-01-01','M',48,NULL,NULL,NULL,NULL,'','','2014-02-05 08:44:07',NULL,NULL,NULL),(7,'Aarne','Alakierre','','','','2000-01-01','M',48,NULL,NULL,NULL,NULL,'','','2014-02-05 08:46:55',NULL,NULL,NULL),(8,'Tomi','Nummenmaa','Karosenkatu 1','33710','Tampere','2000-11-21','M',48,NULL,NULL,NULL,NULL,'','','2014-02-05 15:10:28',NULL,NULL,NULL),(9,'Elina','Nummenmaa','','','','1986-11-14','F',NULL,NULL,NULL,NULL,NULL,'','','2014-02-05 15:33:56',NULL,NULL,NULL),(10,'Jukka','Nieminen','Kalkunviertotie 20 F 30','33330','Tampere','1956-07-22','M',48,NULL,NULL,NULL,NULL,'niemisjukka@gmail.com','3584577302122','2014-02-07 07:01:54',NULL,NULL,NULL),(11,'Jukka','Nieminen','Kalkunviertotie 20 F 30','33330','Tampere','1956-07-22','M',48,NULL,NULL,NULL,NULL,'niemisjukka@gmail.com','3584577302122','2014-02-07 07:02:49',NULL,NULL,NULL),(12,'Ilmari','Heikkil盲','','','','1984-10-13','M',37,NULL,NULL,NULL,NULL,'ilmari.heikkila@windowslive.com','0505746210','2014-02-07 09:42:02',NULL,NULL,NULL),(13,'Ismo','Kaarineva','Rusthollinkatu 13 B 4','33610','Tampere','1964-04-12','M',48,NULL,NULL,NULL,NULL,'ismo.kaarineva@kolumbus.fi','0400751649','2014-02-07 10:45:11',NULL,NULL,NULL),(14,'Veeti','Kaarineva','Rusthollinkatu 13 B 4','33610','TAMPERE','2001-04-18','M',48,NULL,NULL,NULL,NULL,'ismo.kaarineva@kolumbus.fi','0400751649','2014-02-07 10:46:08',NULL,NULL,NULL),(15,'Jouko','Manni','','','','1952-08-16','M',5,NULL,NULL,NULL,NULL,'','','2014-02-07 13:47:34',NULL,NULL,NULL),(16,'Ismo','Lallo','Kivimets盲ntie 11','21420','Lieto','1963-12-07','M',5,NULL,NULL,NULL,NULL,'ismo.lallo@kolumbus.fi','0500-721649','2014-02-07 15:48:25',NULL,NULL,NULL),(17,'Mika','Heiskanen','Koivukyl盲n puistotie 31 B 6','01360','Vantaa','1970-05-09','M',8,NULL,NULL,NULL,NULL,'mika.heiskanen@fmi.fi','0503593796','2014-02-07 17:04:23',NULL,NULL,NULL),(18,'Tapio','Syrj盲nen','Kanjoninreuna 10D16','33720','Tre','1961-05-10','M',48,NULL,NULL,NULL,NULL,'tapiosyr@gmail.com','0405222110','2014-02-07 22:26:26',NULL,NULL,NULL),(19,'Joonas','Vuorinen','Haahkatie 2 a 14','00200','Helsinki','1972-11-25','M',7,NULL,NULL,NULL,NULL,'joonas.vuorinen@gmail.com','0405320227','2014-02-08 21:03:34',NULL,NULL,NULL),(20,'Matias','Ojala','Isohaantie 19','21290','Rusko','2000-05-08','M',58,NULL,NULL,NULL,NULL,'ojalaha@gmail.com','050-67520','2014-02-09 17:31:05',NULL,NULL,NULL),(21,'Pertti','Pelaaja','H盲meenkatu 1','12345','Tampere','1976-09-19','M',14,NULL,NULL,NULL,NULL,'pertti.pelaaja@gmail.com','050-1234567','2014-02-09 17:59:01',NULL,NULL,NULL),(22,'Petra','Kautonen','Sirkantie 1','36420','Sahalahti','1995-02-02','F',12,NULL,NULL,NULL,NULL,'petra.kautonen@sci.fi','050-14564654','2014-02-09 18:32:58',NULL,NULL,NULL),(23,'Jani','Helin','Laulunmaankatu 10 B 5','33800','Tampere','1976-08-23','M',48,NULL,NULL,NULL,NULL,'jani.helin@gmail.com','0408670340','2014-02-09 21:31:02',NULL,NULL,NULL),(24,'Atte','Lepp盲nen','Vaarinkatu 8','37120','Nokia','1964-01-11','M',48,NULL,NULL,NULL,NULL,'atttte@gmail.com','040-5732183','2014-02-09 21:45:39',NULL,NULL,NULL),(25,'Mauri','Peltonen','Taimipolku 6','04620','M盲nts盲l盲','1971-04-17','M',39,NULL,NULL,NULL,NULL,'mauri.peltonen@msoynet.com','0407538838','2014-02-10 09:55:58',NULL,NULL,NULL),(26,'Martti','Kangas','Pitk盲nnotkontie 4 B 8','02760','Espoo','1945-01-16','M',52,NULL,NULL,NULL,NULL,'marttikkangas@gmail.com','050-5631416','2014-02-12 08:06:27',NULL,NULL,NULL),(27,'Jussi','Kuusisto','','','','2014-12-07','M',48,NULL,NULL,NULL,NULL,'jussi.kuusisto@gmail.com','','2014-02-13 12:39:37',NULL,NULL,NULL),(28,'Arttu','Pihkala','Nuolitie 36B','02240','Espoo','2002-08-22','M',7,NULL,NULL,NULL,NULL,'','','2014-02-13 19:47:49',NULL,NULL,NULL),(29,'Ky枚sti','Kurunm盲ki','Korkeavuorenkatu 2B b13','00140','Helsinki','1960-01-20','M',64,NULL,NULL,NULL,NULL,'kyosti.kurunmaki@gmail.com','050 350 4647','2014-02-13 19:47:58',NULL,NULL,NULL),(30,'Kimmo','Pihkala','Nuolitie 36B','02240','Espoo','1973-11-02','M',7,NULL,NULL,NULL,NULL,'kimmo.pihkala@iki.fi','+358 40 709 4781','2014-02-13 19:48:52',NULL,NULL,NULL),(31,'B枚rje','Str枚m','','','','1949-01-01','M',2,NULL,NULL,NULL,NULL,'','','2014-02-13 20:12:31',NULL,NULL,NULL),(32,'B枚rje','Str枚m','','','','1949-01-01','M',26,NULL,NULL,NULL,NULL,'','','2014-02-13 20:16:59',NULL,NULL,NULL),(33,'Kimmo','Rasimus','','','','1959-01-01','M',48,NULL,NULL,NULL,NULL,'','','2014-02-13 21:44:09',NULL,NULL,NULL),(34,'Jarkko','Risku','','','','1970-01-01','M',26,NULL,NULL,NULL,NULL,'','','2014-02-14 14:11:55',NULL,NULL,NULL),(35,'Ingvar','S枚derstr枚m','','','','1936-01-01','M',48,NULL,NULL,NULL,NULL,'','','2014-02-14 18:37:09',NULL,NULL,NULL),(36,'Jyrki','Virtanen','','','','1969-01-01','M',20,NULL,NULL,NULL,NULL,'','','2014-02-14 18:38:36',NULL,NULL,NULL),(37,'Risto','Pohjalahti','','','','1951-01-01','M',20,NULL,NULL,NULL,NULL,'','','2014-02-14 18:39:53',NULL,NULL,NULL),(38,'Ilpo','Salo','','','','1953-01-01','M',20,NULL,NULL,NULL,NULL,'','','2014-02-14 18:40:44',NULL,NULL,NULL),(39,'Paavo','H盲nninen','','','','1935-01-01','M',47,NULL,NULL,NULL,NULL,'','','2014-02-14 21:18:22',NULL,NULL,NULL),(40,'Juho','Tiitinen','','','','1993-01-01','M',48,NULL,NULL,NULL,NULL,'','','2014-02-14 21:19:09',NULL,NULL,NULL),(41,'Yusef','Faily','Kreetankuja 4 D 33','33950','Pirkkala','1975-09-15','M',48,NULL,NULL,NULL,NULL,'jusef75@gmail.com','0407679483','2014-02-15 00:41:31',NULL,NULL,NULL),(42,'Heikki','Tanhua','','','','1969-07-29','M',1,NULL,NULL,NULL,NULL,'heikki.tanhua@hollola.fi','040-5799855','2014-02-15 19:51:57',NULL,NULL,NULL),(43,'Veikko','Holm','','','','1945-05-08','M',48,NULL,NULL,NULL,NULL,'','','2014-02-16 09:32:42',NULL,NULL,NULL),(44,'Jyri','Valtakoski','','','','1950-01-10','M',48,NULL,NULL,NULL,NULL,'','','2014-02-16 09:33:21',NULL,NULL,NULL),(45,'Rafail','Potiris','','','','1995-08-10','M',48,NULL,NULL,NULL,NULL,'','','2014-02-16 09:34:10',NULL,NULL,NULL),(46,'Petra','Kautonen','','','','1995-02-02','F',3,NULL,NULL,NULL,NULL,'','','2014-02-16 09:34:27',NULL,NULL,NULL),(47,'Erik','Kivel盲','','','','1997-03-03','M',48,NULL,NULL,NULL,NULL,'','','2014-02-16 09:49:27',NULL,NULL,NULL),(48,'Sakari','Haapala','','','','1998-08-27','M',48,NULL,NULL,NULL,NULL,'','','2014-02-16 09:50:08',NULL,NULL,NULL),(49,'Mika','Tuomola','','','','1970-05-03','M',48,NULL,NULL,NULL,NULL,'','','2014-02-16 09:57:59',NULL,NULL,NULL),(50,'Antti ','Jokinen','','','','1960-12-15','M',48,NULL,NULL,NULL,NULL,'','','2014-02-16 10:17:03',NULL,NULL,NULL),(51,'Huy','Tran','','','','1990-01-01','M',48,NULL,NULL,NULL,NULL,'','','2014-02-16 11:27:40',NULL,NULL,NULL),(52,'Juha','Meinander','','','','1962-03-18','M',13,NULL,NULL,NULL,NULL,'','','2014-02-16 16:01:03',NULL,NULL,NULL),(53,'Matias','Ojala',NULL,NULL,NULL,'1999-01-01',NULL,58,NULL,NULL,NULL,NULL,NULL,NULL,'2014-02-17 13:43:57',10,NULL,NULL),(54,'Jesse','J盲rvinen',NULL,NULL,NULL,'1998-05-01',NULL,5,NULL,NULL,NULL,NULL,NULL,NULL,'2014-02-17 14:05:12',10,NULL,NULL),(55,'Jere','Myyryl盲inen','Perki枚nkatu 68 A 1','33900','Tampere','0000-00-00',NULL,13,NULL,NULL,NULL,NULL,'jere.myyrylainen@gmail.com',NULL,'2014-03-04 18:04:16',NULL,NULL,NULL),(56,'Kevin','Zhang','ertyuiophuih','33700','Tampere','1994-02-02','M',2,NULL,NULL,NULL,NULL,'zhangcong2711@gmail.com','0345664768','2015-06-24 10:21:39',NULL,NULL,NULL),(57,'cc','bear','Canada','0000011','ccbear@gmail.com','1987-06-06','M',2,NULL,NULL,NULL,NULL,'','0798886666','2015-08-14 06:38:07',NULL,NULL,NULL);
/*!40000 ALTER TABLE `pingis2_players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_players_users`
--

DROP TABLE IF EXISTS `pingis2_players_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_players_users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `player_id` int(8) NOT NULL,
  `user_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_players_users`
--

LOCK TABLES `pingis2_players_users` WRITE;
/*!40000 ALTER TABLE `pingis2_players_users` DISABLE KEYS */;
INSERT INTO `pingis2_players_users` VALUES (4,2,4),(5,3,6),(6,4,6),(7,5,7),(9,7,7),(10,6,7),(14,8,8),(15,9,8),(16,10,10),(17,11,10),(18,12,11),(19,13,12),(20,14,12),(21,15,14),(22,16,16),(23,17,17),(24,18,18),(25,19,20),(26,20,22),(27,21,6),(28,22,6),(29,23,19),(30,24,24),(31,25,29),(32,26,30),(33,27,31),(34,28,34),(35,29,33),(36,30,34),(37,31,7),(38,32,7),(39,33,7),(40,34,7),(41,35,7),(42,36,7),(43,37,7),(44,38,7),(45,39,7),(46,40,7),(47,41,35),(48,42,36),(49,43,10),(50,44,10),(51,45,10),(52,46,37),(53,47,10),(54,48,10),(55,49,10),(56,50,10),(57,51,10),(58,52,21),(59,54,10),(60,53,10),(61,55,41),(62,56,42),(63,57,1);
/*!40000 ALTER TABLE `pingis2_players_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_pool_matches`
--

DROP TABLE IF EXISTS `pingis2_pool_matches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_pool_matches` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `pool_id` int(4) DEFAULT NULL,
  `player1_id` int(4) DEFAULT NULL,
  `player2_id` int(4) DEFAULT NULL,
  `score1` varchar(64) DEFAULT NULL,
  `score2` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_pool_matches`
--

LOCK TABLES `pingis2_pool_matches` WRITE;
/*!40000 ALTER TABLE `pingis2_pool_matches` DISABLE KEYS */;
/*!40000 ALTER TABLE `pingis2_pool_matches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_pools`
--

DROP TABLE IF EXISTS `pingis2_pools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_pools` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `class_id` int(4) DEFAULT NULL,
  `name` varchar(32) NOT NULL,
  `type` varchar(1) NOT NULL,
  `stage_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=328 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_pools`
--

LOCK TABLES `pingis2_pools` WRITE;
/*!40000 ALTER TABLE `pingis2_pools` DISABLE KEYS */;
INSERT INTO `pingis2_pools` VALUES (1,6,'','',0),(2,7,'','',0),(3,7,'','',0),(4,8,'','',0),(5,8,'','',0),(6,9,'','',0),(7,9,'','',0),(8,9,'','',0),(9,10,'','',0),(10,10,'','',0),(11,10,'','',0),(12,10,'','',0),(13,10,'','',0),(14,11,'','',0),(15,11,'','',0),(16,11,'','',0),(17,11,'','',0),(18,12,'','',0),(19,12,'','',0),(20,13,'','',0),(21,14,'','',0),(22,15,'','',0),(23,16,'','',0),(24,17,'','',0),(25,18,'','',0),(26,18,'','',0),(27,18,'','',0),(28,18,'','',0),(29,19,'','',0),(30,6,'','',0),(31,7,'','',0),(32,7,'','',0),(33,8,'','',0),(34,8,'','',0),(35,9,'','',0),(36,9,'','',0),(37,9,'','',0),(38,10,'','',0),(39,10,'','',0),(40,10,'','',0),(41,10,'','',0),(42,10,'','',0),(43,11,'','',0),(44,11,'','',0),(45,11,'','',0),(46,11,'','',0),(47,12,'','',0),(48,12,'','',0),(49,13,'','',0),(50,14,'','',0),(51,15,'','',0),(52,16,'','',0),(53,17,'','',0),(54,18,'','',0),(55,18,'','',0),(56,18,'','',0),(57,18,'','',0),(58,19,'','',0);
/*!40000 ALTER TABLE `pingis2_pools` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_rating_rows`
--

DROP TABLE IF EXISTS `pingis2_rating_rows`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_rating_rows` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `rating_id` int(8) NOT NULL,
  `player_id` int(8) NOT NULL,
  `rating` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=213 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_rating_rows`
--

LOCK TABLES `pingis2_rating_rows` WRITE;
/*!40000 ALTER TABLE `pingis2_rating_rows` DISABLE KEYS */;
INSERT INTO `pingis2_rating_rows` VALUES (1,1,50,2226),(2,1,49,2219),(3,1,15,2038),(4,1,18,1998),(5,1,16,1983),(6,1,51,1973),(7,1,29,1811),(8,1,35,1720),(9,1,53,1703),(10,1,43,1700),(11,1,42,1677),(12,1,34,1618),(13,1,44,1598),(14,1,36,1591),(15,1,17,1555),(16,1,37,1550),(17,1,45,1521),(18,1,28,1492),(19,1,23,1491),(20,1,39,1444),(21,1,47,1428),(22,1,38,1385),(23,1,5,1327),(24,1,13,1324),(25,1,32,1284),(26,1,33,1278),(27,1,24,1244),(28,1,52,1237),(29,1,25,1237),(30,1,26,1212),(31,1,30,1158),(32,1,19,1139),(33,1,27,1042),(34,1,48,998),(35,1,1,0),(36,1,2,0),(37,1,3,0),(38,1,4,0),(39,1,6,0),(40,1,7,0),(41,1,8,0),(42,1,9,0),(43,1,10,0),(44,1,11,0),(45,1,12,1221),(46,1,14,0),(47,1,21,0),(48,1,22,0),(49,1,31,1284),(50,1,40,1472),(51,1,41,1736),(52,1,46,0),(53,1,54,1331),(54,2,50,2226),(55,2,49,2219),(56,2,15,2038),(57,2,18,1998),(58,2,16,1983),(59,2,51,1973),(60,2,29,1811),(61,2,35,1720),(62,2,53,1703),(63,2,43,1700),(64,2,42,1677),(65,2,34,1618),(66,2,44,1598),(67,2,36,1591),(68,2,17,1555),(69,2,37,1550),(70,2,45,1521),(71,2,28,1492),(72,2,23,1491),(73,2,39,1444),(74,2,47,1428),(75,2,38,1385),(76,2,5,1327),(77,2,13,1324),(78,2,32,1284),(79,2,33,1278),(80,2,24,1244),(81,2,52,1237),(82,2,25,1237),(83,2,26,1212),(84,2,30,1158),(85,2,19,1139),(86,2,27,1042),(87,2,48,998),(88,2,1,0),(89,2,2,0),(90,2,3,0),(91,2,4,0),(92,2,6,0),(93,2,7,0),(94,2,8,0),(95,2,9,0),(96,2,10,0),(97,2,11,0),(98,2,12,1221),(99,2,14,0),(100,2,21,0),(101,2,22,0),(102,2,31,1284),(103,2,40,1472),(104,2,41,1736),(105,2,46,0),(106,2,54,1331),(107,3,50,2226),(108,3,49,2219),(109,3,15,2038),(110,3,18,1998),(111,3,16,1983),(112,3,51,1973),(113,3,29,1811),(114,3,35,1720),(115,3,53,1703),(116,3,43,1700),(117,3,42,1677),(118,3,34,1618),(119,3,44,1598),(120,3,36,1591),(121,3,17,1555),(122,3,37,1550),(123,3,45,1521),(124,3,28,1492),(125,3,23,1491),(126,3,39,1444),(127,3,47,1428),(128,3,38,1385),(129,3,5,1327),(130,3,13,1324),(131,3,32,1284),(132,3,33,1278),(133,3,24,1244),(134,3,52,1237),(135,3,25,1237),(136,3,26,1212),(137,3,30,1158),(138,3,19,1139),(139,3,27,1042),(140,3,48,998),(141,3,1,0),(142,3,2,0),(143,3,3,0),(144,3,4,0),(145,3,6,0),(146,3,7,0),(147,3,8,0),(148,3,9,0),(149,3,10,0),(150,3,11,0),(151,3,12,1221),(152,3,14,0),(153,3,21,0),(154,3,22,0),(155,3,31,1284),(156,3,40,1472),(157,3,41,1736),(158,3,46,0),(159,3,54,1331),(160,4,50,2226),(161,4,49,2219),(162,4,15,2038),(163,4,18,1998),(164,4,16,1983),(165,4,51,1973),(166,4,29,1811),(167,4,35,1720),(168,4,53,1703),(169,4,43,1700),(170,4,42,1677),(171,4,34,1618),(172,4,44,1598),(173,4,36,1591),(174,4,17,1555),(175,4,37,1550),(176,4,45,1521),(177,4,28,1492),(178,4,23,1491),(179,4,39,1444),(180,4,47,1428),(181,4,38,1385),(182,4,54,1331),(183,4,5,1327),(184,4,13,1324),(185,4,32,1284),(186,4,33,1278),(187,4,24,1244),(188,4,52,1237),(189,4,25,1237),(190,4,26,1212),(191,4,30,1158),(192,4,19,1139),(193,4,27,1042),(194,4,48,998),(195,4,1,0),(196,4,2,0),(197,4,3,0),(198,4,4,0),(199,4,6,0),(200,4,7,0),(201,4,8,0),(202,4,9,0),(203,4,10,0),(204,4,11,0),(205,4,12,1221),(206,4,14,0),(207,4,21,0),(208,4,22,0),(209,4,31,1284),(210,4,40,1472),(211,4,41,1736),(212,4,46,0);
/*!40000 ALTER TABLE `pingis2_rating_rows` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_ratings`
--

DROP TABLE IF EXISTS `pingis2_ratings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_ratings` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `filename` varchar(128) NOT NULL,
  `date` date NOT NULL,
  `added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `filename` (`filename`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_ratings`
--

LOCK TABLES `pingis2_ratings` WRITE;
/*!40000 ALTER TABLE `pingis2_ratings` DISABLE KEYS */;
INSERT INTO `pingis2_ratings` VALUES (1,'/tmp/php2SrnOx','2004-02-20','2014-02-17 17:43:21'),(2,'/tmp/phpL6KBXo','2004-02-20','2014-02-17 20:08:39'),(3,'/tmp/phpLSSQSD','2004-02-20','2014-02-17 20:52:30'),(4,'/tmp/phpsTK2Vb','2005-02-20','2014-02-17 20:56:18');
/*!40000 ALTER TABLE `pingis2_ratings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_registrations`
--

DROP TABLE IF EXISTS `pingis2_registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_registrations` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `tournament_class_id` int(8) NOT NULL,
  `player_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_registrations`
--

LOCK TABLES `pingis2_registrations` WRITE;
/*!40000 ALTER TABLE `pingis2_registrations` DISABLE KEYS */;
INSERT INTO `pingis2_registrations` VALUES (38,10,5),(39,11,5),(40,12,5),(41,18,5),(66,11,12),(67,19,12),(68,10,13),(69,11,13),(70,7,16),(71,12,16),(72,8,17),(73,9,17),(74,6,18),(75,7,18),(76,12,18),(77,10,19),(78,11,19),(79,18,19),(80,8,20),(81,15,20),(82,18,20),(88,9,23),(89,10,23),(90,18,23),(91,10,24),(92,11,24),(93,18,24),(94,10,25),(95,11,25),(96,11,26),(97,18,26),(98,19,26),(99,10,27),(100,11,27),(101,18,27),(103,7,29),(104,12,29),(105,9,28),(106,10,28),(107,15,28),(108,11,30),(109,19,30),(113,10,32),(114,11,32),(115,18,32),(116,10,33),(117,11,33),(118,18,33),(119,8,34),(120,9,34),(121,18,34),(122,12,35),(123,9,36),(124,18,36),(125,9,37),(126,10,37),(127,10,38),(128,11,38),(129,10,39),(130,12,39),(131,18,39),(132,9,40),(133,10,40),(134,18,40),(135,7,41),(136,8,41),(137,8,42),(138,9,42),(141,8,43),(142,9,43),(143,12,43),(144,18,43),(145,8,44),(146,9,44),(147,12,44),(148,18,44),(149,8,45),(150,9,45),(151,9,47),(152,10,47),(153,13,47),(154,13,48),(155,19,48),(156,6,49),(157,6,50),(158,6,51),(159,7,51),(160,10,52),(161,11,52),(162,18,52),(163,7,53),(164,8,28),(165,10,54),(166,11,54),(167,23,56),(168,24,56),(169,6,56),(170,7,56),(171,23,57),(172,24,57);
/*!40000 ALTER TABLE `pingis2_registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_roles`
--

DROP TABLE IF EXISTS `pingis2_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_roles` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_roles`
--

LOCK TABLES `pingis2_roles` WRITE;
/*!40000 ALTER TABLE `pingis2_roles` DISABLE KEYS */;
INSERT INTO `pingis2_roles` VALUES (3,'P盲盲k盲ytt盲j盲'),(1,'Perusk盲ytt盲j盲'),(2,'Turnausj盲rjest盲j盲');
/*!40000 ALTER TABLE `pingis2_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_stages`
--

DROP TABLE IF EXISTS `pingis2_stages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_stages` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `type` varchar(1) NOT NULL,
  `tournament_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_stages`
--

LOCK TABLES `pingis2_stages` WRITE;
/*!40000 ALTER TABLE `pingis2_stages` DISABLE KEYS */;
INSERT INTO `pingis2_stages` VALUES (1,'1','P',1),(2,'2','C',1),(3,'1','P',3),(4,'2','C',3),(5,'APG','P',8),(6,'CBG','P',8);
/*!40000 ALTER TABLE `pingis2_stages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_tournament_classes`
--

DROP TABLE IF EXISTS `pingis2_tournament_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_tournament_classes` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT '0',
  `maxage` int(3) DEFAULT NULL,
  `minage` int(3) DEFAULT NULL,
  `maxrating` int(4) DEFAULT NULL,
  `minrating` int(4) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_tournament_classes`
--

LOCK TABLES `pingis2_tournament_classes` WRITE;
/*!40000 ALTER TABLE `pingis2_tournament_classes` DISABLE KEYS */;
INSERT INTO `pingis2_tournament_classes` VALUES (3,'Testiluokka 2',1,30,18,3000,1500,NULL,''),(4,'Testiluokka',1,NULL,NULL,NULL,NULL,NULL,''),(5,'MK',0,NULL,NULL,NULL,NULL,NULL,'Poolit'),(6,'M-2000',0,NULL,NULL,2000,NULL,NULL,'Poolit'),(7,'M-1850',0,NULL,NULL,1850,NULL,NULL,'Poolit'),(8,'M-1700',0,NULL,NULL,1700,NULL,NULL,'Poolit'),(9,'M-1550',0,NULL,NULL,1550,NULL,NULL,'Poolit'),(10,'M-1400',0,NULL,NULL,1400,NULL,NULL,'Poolit'),(11,'Vet. avoin',0,NULL,35,NULL,NULL,NULL,'Poolit'),(12,'M17GP',0,17,NULL,NULL,NULL,NULL,'Poolit'),(13,'N17GP',0,17,NULL,NULL,NULL,'F','Poolit'),(14,'N14GP',0,14,NULL,NULL,NULL,'F','Poolit'),(15,'M12',0,12,NULL,NULL,NULL,NULL,'Poolit'),(16,'TAS',0,NULL,NULL,NULL,NULL,NULL,'Cup'),(17,'Harrastelijat',0,NULL,NULL,NULL,NULL,NULL,'Poolit, osanottajilla enint盲盲n 3 kilpailua tai rating < 1300.'),(18,'M14GP',0,14,NULL,NULL,NULL,NULL,'Poolit');
/*!40000 ALTER TABLE `pingis2_tournament_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_tournaments`
--

DROP TABLE IF EXISTS `pingis2_tournaments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_tournaments` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `organizer` varchar(64) NOT NULL,
  `contact` varchar(64) NOT NULL,
  `contactphone` varchar(64) DEFAULT NULL,
  `contactemail` varchar(64) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `location` varchar(64) NOT NULL,
  `additionalinfo` text,
  `registration_ends` datetime NOT NULL,
  `cuttingdate` date NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_tournaments`
--

LOCK TABLES `pingis2_tournaments` WRITE;
/*!40000 ALTER TABLE `pingis2_tournaments` DISABLE KEYS */;
INSERT INTO `pingis2_tournaments` VALUES (1,'PT 75:n kansalliset','PT 75','Jyrki Nummenmaa','040-5277999','jyrki.nummenmaa@gmail.com','2014-02-22','2014-02-22','Hatanp盲盲n Koulu','Ylituomari: Jukka Nieminen','2014-02-19 00:00:00','2014-02-20','2014-01-30 20:10:17',0),(3,'KTestiturnaus','KTestij盲rjest枚','Laura Kautonen','050-5650690','laura.kautonen@uta.fi','2014-02-15','2014-02-16','Hervantakeskus','','2014-02-14 00:00:00','2014-02-15','2014-02-09 18:34:05',0),(8,'TestTrunaukt','TestTrunaukt','TestTrunaukt','987654','TestTrunaukt@gmail.com','2015-09-03','2015-09-11','Tampere','','2015-09-01 00:00:00','2015-09-26','2015-09-16 22:04:21',0);
/*!40000 ALTER TABLE `pingis2_tournaments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pingis2_users`
--

DROP TABLE IF EXISTS `pingis2_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pingis2_users` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `role_id` int(4) NOT NULL DEFAULT '1',
  `name` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `validation` varchar(64) NOT NULL,
  `validated` datetime DEFAULT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pingis2_users`
--

LOCK TABLES `pingis2_users` WRITE;
/*!40000 ALTER TABLE `pingis2_users` DISABLE KEYS */;
INSERT INTO `pingis2_users` VALUES (1,3,'Jere Myyryl盲inen','jere.myyrylainen@uta.fi','0407571343','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2013-10-08 12:36:55',NULL),(2,3,'Perttu','perttu.hallikainen@uta.fi','0407182105','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2013-12-04 07:18:42',NULL),(4,1,'Miikka','kahmiikka@gmail.com','0408458907','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-01-30 14:23:40',NULL),(6,3,'Laura Kautonen','laura.kautonen@uta.fi','','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-02 18:21:25',NULL),(7,3,'Jyrki Nummenmaa','jyrki.nummenmaa@gmail.com','0405277999','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-04 09:54:51',NULL),(8,1,'Jyrki Nummenmaa2','jyrki.nummenmaa@uta.fi','','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-05 15:02:39',NULL),(10,1,'Jukka Nieminden','niemisjukka@gmail.com','33330 Tamperere','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-07 06:55:23',NULL),(11,1,'Ilmari Heikkil盲','ilmari.heikkila@windowslive.com','0505746210','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-07 09:31:44',NULL),(12,1,'Ismo Kaarineva','ismo.kaarineva@kolumbus.fi','0400751649','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-07 10:40:39',NULL),(13,1,'Jukka Julin','ttcboom@koumbus.fi','+358407716050','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-07 10:47:43',NULL),(14,1,'Jouko Manni','jouko.manni@turuntilikeskus.fi','0400520674','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-07 13:42:50',NULL),(15,1,'Jukka Julin','ttcboom@kolumbus.fi','0407716050','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-07 13:43:53',NULL),(16,1,'Ismo Lallo','ismo.lallo@kolumbus.fi','0500-721649','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-07 15:46:00',NULL),(17,1,'Mika Heiskanen','mika.heiskanen@fmi.fi','0503593796','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-07 17:01:15',NULL),(18,1,'Tapio Syrj盲nen','tapiosyr@gmail.com','0405222110','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-07 22:23:26',NULL),(19,1,'Jani Helin','jani.helin@gmail.com','0408670340','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-08 17:27:16',NULL),(20,1,'Joonas Vuorinen','joonas.vuorinen@gmail.com','0405320227','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-08 20:56:10',NULL),(21,1,'Juha Meinander','juha.meinander@welho.com','0405163272','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-09 14:17:58',NULL),(22,1,'Matias Ojala','ojalaha@gmail.com','050-67520','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-09 17:29:22',NULL),(24,1,'Atte lepp盲nen','atttte@gmail.com','040-5732183','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-09 21:40:31',NULL),(25,1,'Aki Puustj盲rvi','aki.puustjarvi@gmil.com','040 555 0699','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-10 06:54:44',NULL),(26,1,'Aki Puustj盲rvi','aki.puustjarvi@gmail.com','040 555 0699','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-10 06:54:52',NULL),(28,1,'Testi Henkil枚','testi@testi.fi','040 123 1234','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-10 07:37:05',NULL),(29,1,'Mauri Peltonen','mauri.peltonen@msoynet.com','0407538838','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-10 09:52:17',NULL),(30,1,'Martti Kangas','marttikkangas@gmail.com','050-5631416','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-12 07:47:33',NULL),(31,1,'Jussi Kuusisto','jussi.kuusisto@gmail.com','','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-13 12:32:26',NULL),(32,1,'B枚rje Str枚m','borje.strom@netikka.fi','050-5852326','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-13 15:52:26',NULL),(33,1,'Ky枚sti Kurunm盲ki','kyosti.kurunmaki@gmail.com','050 350 4647','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-13 19:42:59',NULL),(34,1,'Kimmo','kimmo.pihkala@iki.fi','+358 40 709 4781','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-13 19:44:31',NULL),(35,1,'JUSEF FAILY','jusef75@gmail.com','0407679483','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-15 00:26:37',NULL),(36,1,'Heikki Tanhua','heikki.tanhua@hollola.fi','040-5799855','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-15 19:49:20',NULL),(37,1,'Laura Kautonen','laura.kautonen@sci.fi','050-5650690','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-02-16 09:30:20',NULL),(41,1,'Jere Myyryl盲inen','jere.myyrylainen@gmail.com','0407571343','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2014-03-04 18:04:16',NULL),(42,1,'cz99713','zhang.cong.x@student.uta.fi','12345678','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2015-06-12 03:26:04',NULL),(43,1,'dfgjkl','afk@hotmail.com','5677788','f0fa096267149acd14aa1f500660f170972271f6','f46ab765ee990bc1d26b5efd85c7e1a4',NULL,'2015-08-09 03:05:47',NULL);
/*!40000 ALTER TABLE `pingis2_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-09-17 16:10:47
