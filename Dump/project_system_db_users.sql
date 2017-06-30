-- MySQL dump 10.13  Distrib 5.7.17, for macos10.12 (x86_64)
--
-- Host: 127.0.0.1    Database: project_system_db
-- ------------------------------------------------------
-- Server version	5.6.22

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
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','admin','admin@admin.com','1234',1),(2,'john_smith','john','smith','smith@gmail.com','1234',2),(3,'singh_komal','singh','komal','komalsingh@gmail.com','1234',2),(4,'yad_singh','yad','singh','yad_singh@gmail.com','1234',2),(5,'jatinder_singh','jatinder','singh','jatinder_singh@yahoo.in','1234',2),(6,'Jagga_Singh','singh','Jagga','Jagga_Singh@live.in','1234',2),(7,'Amrendra_Bahubali','Amrendra','Bahubali','Bahubali@gmail.com','1234',2),(8,'Shivgami_Devi','Shivgami','devi','Shivgami_Devi@bahubali.in','1234',2),(9,'Kutappa_singh','Kutappa','Singh','Kutappa_singh@yahoo.in','1234',2),(10,'chemmasaab','Harman','Chemma','chemmasaab@gmail.com','1234',2),(11,'Pooja','Pooja','Saini','Pooja@GMAIL.COM','1234',2),(12,'LoveleenKaur','Loveleen','Kaur','LoveleenKaur@live.com','1234',2),(13,'pawan_reru','reru','reru','rerupawan@gmail.com','1234',2),(14,'mouse','Mouse','Rat','mouse@gmail.com','12345',2),(15,'Pragati ','Pragati','Koirala','pragatikrl@yahoo.com','mouse123',2),(16,'Isha','isha','rana','isha@gmail.com','gmail',2);
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

-- Dump completed on 2017-06-30 14:09:23
