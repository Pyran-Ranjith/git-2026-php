-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: ranjith_personal
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `diary`
--

DROP TABLE IF EXISTS `diary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `diary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `status` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `event` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `diary`
--

LOCK TABLES `diary` WRITE;
/*!40000 ALTER TABLE `diary` DISABLE KEYS */;
INSERT INTO `diary` VALUES (1,'2026-10-03','pending','login','PC switched on | Last 03-09-2026'),(2,'2026-10-30','pending','helth','Wakugadu Clinic | Blood test - fasting after 22.00'),(3,'2026-11-03','pending','helth','Wakugadu Clinic'),(5,'2026-11-09','info','donation','Garvin 50,000/= recieved on 09-Aug-2026 Expected once 3 monts'),(6,'2026-08-25','pending','donation','Ranga Last recieved Rs 15,000 for JULY on 14-08-2026'),(7,'2026-08-17','pending','donation','Daya Mali Last recieved Rs 10,000 for JUL on 03-08-2026'),(8,'2026-09-10','completed','donation','Chandrika Last recieved Rs 18,000 for SEP on17-09-2026'),(9,'2026-09-14','completed','bill_monthly','CC 6,621.69 Due: 14-09  Payed on 14-09'),(11,'2026-09-22','completed','bill_monthly','Water 534.66 Due: 22-09 Payed on 21-09-2026'),(12,'2026-09-10','completed','bill_monthly','Electricity 1,020.51 Due: 10-09 Payed on 14-09'),(13,'2026-09-28','completed','bill_monthly','Upahara 634.75 Due: 28-09 Payed on 21-09-2026'),(14,'2026-09-22','completed','bill_monthly','SLT 5,043.07 Due: 22-09 Payed on 21-09-2026'),(15,'2026-09-12','info','donation','Nishantha 10,000/= recieved on 12-Aug-2026'),(16,'2026-09-13','completed','lending','Mani 8,614 - 200 = 8,414 for Groceries of armsgiving'),(17,'2026-09-21','info','tv','Daly: 19.30 ITN Deviyangema pihitay'),(18,'2026-09-20','info','guarantee','Task1'),(19,'2026-09-20','info','taskrepeated','Vehicle insurance');
/*!40000 ALTER TABLE `diary` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-22 10:06:30
