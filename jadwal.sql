-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: localhost    Database: dbregonline
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.18.04.1

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
-- Table structure for table `res_jadwal`
--

DROP TABLE IF EXISTS `res_jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `res_jadwal` (
  `id_jadwal` int(6) NOT NULL AUTO_INCREMENT,
  `dokter_id` int(8) NOT NULL,
  `klinik_id` int(4) NOT NULL,
  `jns_layan_id` int(4) NOT NULL,
  `id_hari` tinyint(4) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota_perjam` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_jadwal`),
  KEY `jns_layan_id` (`jns_layan_id`),
  KEY `res_jadwal_ibfk_1` (`dokter_id`),
  KEY `res_jadwal_ibfk_2` (`klinik_id`),
  CONSTRAINT `res_jadwal_ibfk_1` FOREIGN KEY (`dokter_id`) REFERENCES `res_refdokter` (`id_dokter`),
  CONSTRAINT `res_jadwal_ibfk_2` FOREIGN KEY (`klinik_id`) REFERENCES `res_refklinik` (`id_klinik`),
  CONSTRAINT `res_jadwal_ibfk_3` FOREIGN KEY (`jns_layan_id`) REFERENCES `res_refjns_layan` (`id_jns_layan`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `res_jadwal`
--

LOCK TABLES `res_jadwal` WRITE;
/*!40000 ALTER TABLE `res_jadwal` DISABLE KEYS */;
INSERT INTO `res_jadwal` VALUES (5,111,1,1,1,'07:30:00','15:00:00',20,0),(6,111,1,1,2,'07:30:00','15:00:00',20,0),(7,111,1,1,3,'07:30:00','15:00:00',20,0),(8,111,1,1,4,'07:30:00','15:00:00',20,0),(9,111,1,1,5,'07:30:00','15:00:00',20,0),(10,8,104,2,2,'09:00:00','14:00:00',5,1),(11,5,102,2,5,'09:00:00','14:00:00',5,1),(12,9,103,2,1,'09:00:00','14:00:00',5,1),(13,45,400,2,4,'09:00:00','14:00:00',5,1),(14,45,400,2,5,'09:00:00','14:00:00',5,1),(15,3,400,2,2,'09:00:00','14:00:00',5,1),(16,4,400,2,3,'09:00:00','14:00:00',5,1),(17,7,24,2,3,'09:00:00','14:00:00',5,1),(18,10,24,2,1,'09:00:00','14:00:00',5,1),(19,1,401,2,1,'09:00:00','14:00:00',5,1),(20,48,401,2,4,'09:00:00','14:00:00',5,1),(21,222,3,1,1,'07:30:00','14:00:00',15,0),(22,222,3,1,2,'07:30:00','14:00:00',15,0),(23,222,3,1,3,'07:30:00','14:00:00',15,0),(24,222,3,1,3,'07:30:00','14:00:00',15,0),(25,222,3,1,5,'07:30:00','14:00:00',15,0),(26,4,1,1,1,'07:30:00','14:30:00',10,1),(27,10,1,1,1,'07:30:00','14:30:00',10,1),(28,7,1,1,2,'07:30:00','12:30:00',10,1),(29,5,1,1,2,'07:30:00','14:30:00',10,1),(30,8,1,1,3,'07:30:00','14:30:00',10,1),(31,1,1,1,3,'09:00:00','15:00:00',10,1),(32,3,1,1,4,'07:30:00','14:30:00',10,1),(33,45,1,1,4,'07:30:00','14:30:00',10,1),(34,48,1,1,2,'09:00:00','15:00:00',10,1),(35,48,1,1,5,'09:00:00','15:00:00',10,1),(36,9,1,1,5,'08:00:00','15:00:00',10,1);
/*!40000 ALTER TABLE `res_jadwal` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-06 21:04:33
