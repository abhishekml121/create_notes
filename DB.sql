-- MySQL dump 10.13  Distrib 5.7.32, for Linux (x86_64)
--
-- Host: localhost    Database: user_notes
-- ------------------------------------------------------
-- Server version	5.7.32-0ubuntu0.18.04.1

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
-- Table structure for table `award_to_developer`
--

DROP TABLE IF EXISTS `award_to_developer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `award_to_developer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `award_id` tinyint(1) NOT NULL,
  `number_of_time` varchar(2) NOT NULL DEFAULT '0',
  `ip_address` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `award_to_developer`
--

LOCK TABLES `award_to_developer` WRITE;
/*!40000 ALTER TABLE `award_to_developer` DISABLE KEYS */;
INSERT INTO `award_to_developer` VALUES (1,1,'','::1','2020-11-09','09:26:03');
/*!40000 ALTER TABLE `award_to_developer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forget_password_otp`
--

DROP TABLE IF EXISTS `forget_password_otp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forget_password_otp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=170 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forget_password_otp`
--

LOCK TABLES `forget_password_otp` WRITE;
/*!40000 ALTER TABLE `forget_password_otp` DISABLE KEYS */;
INSERT INTO `forget_password_otp` VALUES (25,'a@gmail.com','580008','::1','2020-11-11','08:49:20'),(169,'abhishekmpoz@gmail.com','995364','::1','2020-11-17','07:11:27');
/*!40000 ALTER TABLE `forget_password_otp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `message_from_users`
--

DROP TABLE IF EXISTS `message_from_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `message_from_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `message` text,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `message_from_users`
--

LOCK TABLES `message_from_users` WRITE;
/*!40000 ALTER TABLE `message_from_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `message_from_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `note_id` varchar(25) NOT NULL,
  `topic` text NOT NULL,
  `note_html` text NOT NULL,
  `note_markdown` text NOT NULL,
  `access_type` varchar(25) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `self_views` varchar(255) DEFAULT '0',
  `watch_later` tinyint(1) DEFAULT '0',
  `imp_note` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `note_id` (`note_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
INSERT INTO `notes` VALUES (1,20,'1K0w3GF0igqm','adj matrix','<p>Front-End Performance Checklist\nUpdated every year is this huge checklist of everything you need to know to create fast experiences on the web today.</p>\n\n<p>Front-End Performance Checklist  </p>\n\n<p>Front-End Performance Checklist\nUpdated every year is this huge checklist of everything you need to know to create fast experiences on the web today.</p>\n\n<p>Front-End Performance Checklist</p>\n\n<pre><code>&lt;!DOCTYPE html&gt;\n&lt;html lang=\"en\"&gt;\n&lt;head&gt;\n    &lt;meta charset=\"UTF-8\"&gt;\n    &lt;meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\"&gt;\n    &lt;title&gt;Document&lt;/title&gt;\n&lt;/head&gt;\n&lt;body&gt;\n   &lt;ul&gt;&lt;/ul&gt;\n    &lt;script&gt;\n        let h=45;\n        let hh=h-5;\n        console.log(hh);\n\n    &lt;/script&gt;\n&lt;/body&gt;\n&lt;/html&gt;\n</code></pre>','Front-End Performance Checklist\r\nUpdated every year is this huge checklist of everything you need to know to create fast experiences on the web today.\r\n\r\nFront-End Performance Checklist  \r\n\r\n\r\nFront-End Performance Checklist\r\nUpdated every year is this huge checklist of everything you need to know to create fast experiences on the web today.\r\n\r\nFront-End Performance Checklist\r\n\r\n    <!DOCTYPE html>\r\n    <html lang=\"en\">\r\n    <head>\r\n        <meta charset=\"UTF-8\">\r\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n        <title>Document</title>\r\n    </head>\r\n    <body>\r\n       <ul></ul>\r\n        <script>\r\n            let h=45;\r\n            let hh=h-5;\r\n            console.log(hh);\r\n    \r\n        </script>\r\n    </body>\r\n    </html>','Public','2020-11-14','05:45:16','3',1,0);
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes_subject`
--

DROP TABLE IF EXISTS `notes_subject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes_subject` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `note_id` varchar(25) NOT NULL,
  `subject_name` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `note_id` (`note_id`),
  CONSTRAINT `notes_subject_ibfk_1` FOREIGN KEY (`note_id`) REFERENCES `notes` (`note_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes_subject`
--

LOCK TABLES `notes_subject` WRITE;
/*!40000 ALTER TABLE `notes_subject` DISABLE KEYS */;
INSERT INTO `notes_subject` VALUES (1,20,'1K0w3GF0igqm','sfsdf');
/*!40000 ALTER TABLE `notes_subject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes_tag`
--

DROP TABLE IF EXISTS `notes_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes_tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `note_id` varchar(25) NOT NULL,
  `tag_name` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `note_id` (`note_id`),
  CONSTRAINT `notes_tag_ibfk_1` FOREIGN KEY (`note_id`) REFERENCES `notes` (`note_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes_tag`
--

LOCK TABLES `notes_tag` WRITE;
/*!40000 ALTER TABLE `notes_tag` DISABLE KEYS */;
INSERT INTO `notes_tag` VALUES (1,20,'1K0w3GF0igqm','dggd');
/*!40000 ALTER TABLE `notes_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscribed_users`
--

DROP TABLE IF EXISTS `subscribed_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscribed_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscribed_users`
--

LOCK TABLES `subscribed_users` WRITE;
/*!40000 ALTER TABLE `subscribed_users` DISABLE KEYS */;
INSERT INTO `subscribed_users` VALUES (1,'abhishekmpoz@gmail.com','2020-11-12','11:06:55'),(2,'maltikamal1800@gmail.com','2020-11-14','05:55:51');
/*!40000 ALTER TABLE `subscribed_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `hashed_password` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (20,'','a@gmail.com','$2y$10$NBoJiuUQsC4k52RpUGB2GOdW7Zkxz6V/fptztYH0ecd9lLkBQshhi','2020-11-08','11:40:37'),(21,'a@gmail','','$2y$10$b8hyKxbzuA6hDGjnu3IXP.5uw3I0I4LzG7etBcwedqulqR5KJWaUO','2020-11-08','11:40:55'),(22,'','a5@gmail.com','$2y$10$wtPrrT9IHcWU32VfpNwwQOzbWOWqOdU1M8C.iRjfIdD9IcYwXi8Iy','2020-11-09','01:21:18'),(23,'','abhishekmpoz@gmail.com','$2y$10$6sKHr5A.4T4YGTgUmyyN5OgdTITLEXNP1jTtBTs.tB7Gen.rBS8bu','2020-11-10','07:22:50');
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

-- Dump completed on 2020-11-20  5:44:39
