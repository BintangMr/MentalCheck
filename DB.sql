-- MariaDB dump 10.19  Distrib 10.5.9-MariaDB, for osx10.16 (x86_64)
--
-- Host: 127.0.0.1    Database: mental_check
-- ------------------------------------------------------
-- Server version	10.5.9-MariaDB

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
-- Table structure for table `question_answers`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_answers` (
  `id` bigint(20) unsigned NOT NULL,
  `question_id` bigint(20) unsigned NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `point` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_answers_question_id_foreign` (`question_id`),
  CONSTRAINT `question_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_answers`
--

INSERT INTO `question_answers` VALUES (1,1,'Ya',50,'2021-05-05 14:45:14','2021-05-05 14:45:14',NULL),(2,1,'Tidak',10,'2021-05-05 14:45:14','2021-05-05 14:45:14',NULL),(3,2,'Ya',50,'2021-05-05 14:45:33','2021-05-05 14:45:33',NULL),(4,2,'Tidak',10,'2021-05-05 14:45:33','2021-05-05 14:45:33',NULL),(5,3,'Ya',50,'2021-05-05 14:46:35','2021-05-05 14:46:35',NULL),(6,3,'Tidak',10,'2021-05-05 14:46:35','2021-05-05 14:46:35',NULL),(7,4,'Ya',50,'2021-05-05 14:46:57','2021-05-05 14:46:57',NULL),(8,4,'Tidak',10,'2021-05-05 14:46:57','2021-05-05 14:46:57',NULL),(9,5,'Ya',50,'2021-05-05 14:47:36','2021-05-05 14:47:36',NULL),(10,5,'Tidak',10,'2021-05-05 14:47:36','2021-05-05 14:47:36',NULL);

--
-- Table structure for table `question_categories`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_categories` (
  `id` bigint(20) unsigned NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_categories`
--

INSERT INTO `question_categories` VALUES (1,'Depresi','Depresi adalah gangguan suasana hati (mood) yang ditandai dengan perasaan sedih yang mendalam dan rasa tidak peduli.','frown',1,'2021-05-05 05:24:57','2021-05-05 05:24:57',NULL),(2,'Bipolar Disorder','Suatu gangguan yang berhubungan dengan perubahan suasana hati mulai dari posisi terendah depresif/tertekan ke tertinggi/manik.','meh',1,'2021-05-05 05:26:15','2021-05-05 05:26:15',NULL),(3,'Autisme','Autisme adalah Gangguan perkembangan serius yang mengganggu kemampuan berkomunikasi dan berinteraksi.','cloud-drizzle',1,'2021-05-05 05:27:21','2021-05-05 05:27:21',NULL),(4,'Anxiety Disorder','Rasa cemas atau anxiety adalah hal yang normal dirasakan ketika seseorang menghadapi situasi atau mendengar berita yang menimbulkan rasa takut atau khawatir. Namun, Anxiety juga bisa muncul tanpa sebab atau sulit dikendalikan.','minimize',1,'2021-05-05 05:27:54','2021-05-05 05:27:54',NULL);

--
-- Table structure for table `question_category_images`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_category_images` (
  `id` bigint(20) unsigned NOT NULL,
  `question_category_id` bigint(20) unsigned NOT NULL,
  `original_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modified_filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extension` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_category_images_question_category_id_foreign` (`question_category_id`),
  CONSTRAINT `question_category_images_question_category_id_foreign` FOREIGN KEY (`question_category_id`) REFERENCES `question_categories` (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_category_images`
--

INSERT INTO `question_category_images` VALUES (1,1,'new-services-1.jpg','1-2021-05-05 12:24:57.jpg','jpg',29804.00,'2021-05-05 05:24:57','2021-05-05 05:24:57'),(2,2,'new-services-3.jpg','2-2021-05-05 12:26:15.jpg','jpg',13961.00,'2021-05-05 05:26:15','2021-05-05 05:26:15'),(3,3,'new-services-2.jpg','3-2021-05-05 12:27:21.jpg','jpg',18601.00,'2021-05-05 05:27:21','2021-05-05 05:27:21'),(4,4,'new-services-4.png','4-2021-05-05 12:27:54.png','png',291707.00,'2021-05-05 05:27:54','2021-05-05 05:27:54');

--
-- Table structure for table `questions`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` bigint(20) unsigned NOT NULL,
  `question_category_id` bigint(20) unsigned NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_question_category_id_foreign` (`question_category_id`),
  CONSTRAINT `questions_question_category_id_foreign` FOREIGN KEY (`question_category_id`) REFERENCES `question_categories` (`id`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` VALUES (1,1,'Apakah Anda mengalami kesedihan yang intens, sulit ditebak, dan berlangsung selama beberapa hari?',1,'2021-05-05 14:45:14','2021-05-05 14:45:14',NULL),(2,1,'Apakah Anda sempat berfikir untuk bunuh diri?',1,'2021-05-05 14:45:33','2021-05-05 14:45:33',NULL),(3,1,'Apakah Anda merasa lelah atau kurang bertenaga?',1,'2021-05-05 14:46:35','2021-05-05 14:46:35',NULL),(4,1,'Apakah Anda merasa putus asa?',1,'2021-05-05 14:46:57','2021-05-05 14:46:57',NULL),(5,1,'Apakah Anda mengonsumsi Alkohol atau obat-obatan untuk mengendalikan suasana hati?',1,'2021-05-05 14:47:36','2021-05-05 14:47:36',NULL);

--
-- Table structure for table `users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
);
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES (1,'Chandra Ramdhan Purnama','euclife@outlook.co.id',NULL,'$2y$10$Jem75LELC3BBHIalwSrmY.ZIkXKgjNH4bmcYnzLKfQtCqtRTbO.jW',NULL,NULL,1,NULL,'2021-05-05 05:22:43','2021-05-05 05:22:43',NULL),(2,'Chandra Member','member@gmail.com',NULL,'$2y$10$I2c9uAn7uK.eP/Ccz9JGY.s/nCnXs/Thqu8yM3rZNR6YQJH/Me3ei',NULL,NULL,0,NULL,'2021-05-05 06:50:28','2021-05-05 06:50:28',NULL);
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-06  6:55:11
