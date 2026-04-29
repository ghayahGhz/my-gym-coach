/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.16-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: my_gym_coach
-- ------------------------------------------------------
-- Server version	10.11.16-MariaDB

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
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `done_dates`
--

DROP TABLE IF EXISTS `done_dates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `done_dates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_profile_id` bigint(20) unsigned NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `done_dates_user_profile_id_date_unique` (`user_profile_id`,`date`),
  CONSTRAINT `done_dates_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `done_dates`
--

LOCK TABLES `done_dates` WRITE;
/*!40000 ALTER TABLE `done_dates` DISABLE KEYS */;
/*!40000 ALTER TABLE `done_dates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `exercises`
--

DROP TABLE IF EXISTS `exercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exercises` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `muscle` varchar(255) NOT NULL,
  `muscle_ar` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `is_time` tinyint(1) NOT NULL DEFAULT 0,
  `youtube_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `exercises_key_unique` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercises`
--

LOCK TABLES `exercises` WRITE;
/*!40000 ALTER TABLE `exercises` DISABLE KEYS */;
INSERT INTO `exercises` VALUES
(1,'bp','بنش برس','chest','صدر','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(2,'df','فلاي دمبل','chest','صدر','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(3,'pu','تمرين الضغط','chest','صدر','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(4,'cf','كابل فلاي','chest','صدر','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(5,'lp','لات بول داون','back','ظهر','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(6,'crw','كابل رو','back','ظهر','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(7,'dl','ديد ليفت','back','ظهر','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(8,'puu','عقلة','back','ظهر','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(9,'sq','سكوات','legs','أرجل','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(10,'lpr','ليج بريس','legs','أرجل','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(11,'ht','هيب ثرست','legs','أرجل','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(12,'lu','لانج','legs','أرجل','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(13,'rdl','رومانيان ديد ليفت','legs','أرجل','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(14,'cal','رفع الكعب','legs','أرجل','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(15,'sp','ضغط الكتف','shoulder','كتف','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(16,'lr','رفع جانبي','shoulder','كتف','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(17,'fr','رفع أمامي','shoulder','كتف','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(18,'cru','كرنش','abs','بطن','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(19,'pl','بلانك','abs','بطن','strength',1,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(20,'rt','روسيان تويست','abs','بطن','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(21,'hlr','رفع الأرجل المعلقة','abs','بطن','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(22,'bc','بايسيكل كرنش','abs','بطن','strength',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(23,'tm','جهاز الجري','cardio','كارديو','cardio',1,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(24,'bh','دراجة HIIT','cardio','كارديو','cardio',1,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(25,'scc','ستير كلايمر','cardio','كارديو','cardio',1,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(26,'el','إليبتيكال','cardio','كارديو','cardio',1,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(27,'ks','تمرين الكيتل بيل','cardio','كارديو','cardio',0,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(28,'bst','إطالة الظهر','stretch','إطالة','stretch',1,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(29,'lst','إطالة الأرجل','stretch','إطالة','stretch',1,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19'),
(30,'sst','إطالة الكتف','stretch','إطالة','stretch',1,NULL,'2026-04-27 17:56:19','2026-04-27 17:56:19');
/*!40000 ALTER TABLE `exercises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2026_04_27_201300_create_exercises_table',1),
(5,'2026_04_27_201300_create_user_profiles_table',1),
(6,'2026_04_27_201301_create_done_dates_table',1),
(7,'2026_04_27_201301_create_user_exercises_table',1),
(8,'2026_04_29_000001_add_user_id_to_user_profiles',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_exercises`
--

DROP TABLE IF EXISTS `user_exercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_exercises` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_profile_id` bigint(20) unsigned NOT NULL,
  `exercise_id` bigint(20) unsigned NOT NULL,
  `day` varchar(255) NOT NULL,
  `sets` int(11) NOT NULL DEFAULT 3,
  `reps` int(11) NOT NULL DEFAULT 10,
  `weight` decimal(6,1) NOT NULL DEFAULT 0.0,
  `done` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_exercises_user_profile_id_foreign` (`user_profile_id`),
  KEY `user_exercises_exercise_id_foreign` (`exercise_id`),
  CONSTRAINT `user_exercises_exercise_id_foreign` FOREIGN KEY (`exercise_id`) REFERENCES `exercises` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_exercises_user_profile_id_foreign` FOREIGN KEY (`user_profile_id`) REFERENCES `user_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_exercises`
--

LOCK TABLES `user_exercises` WRITE;
/*!40000 ALTER TABLE `user_exercises` DISABLE KEYS */;
INSERT INTO `user_exercises` VALUES
(2,2,22,'thu',3,10,0.0,0,1,'2026-04-27 18:05:42','2026-04-27 18:05:42'),
(3,7,22,'sat',3,10,0.0,0,1,'2026-04-29 16:38:56','2026-04-29 16:38:56'),
(4,7,17,'sat',3,10,0.0,0,2,'2026-04-29 16:39:04','2026-04-29 16:39:04');
/*!40000 ALTER TABLE `user_exercises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profiles`
--

DROP TABLE IF EXISTS `user_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(255) NOT NULL DEFAULT 'female',
  `weight` decimal(5,1) NOT NULL DEFAULT 70.0,
  `height` decimal(5,1) NOT NULL DEFAULT 170.0,
  `session_dur` int(11) NOT NULL DEFAULT 90,
  `rest_dur` int(11) NOT NULL DEFAULT 90,
  `days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '["sat","tue","thu"]' CHECK (json_valid(`days`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_profiles_user_id_foreign` (`user_id`),
  CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
INSERT INTO `user_profiles` VALUES
(1,NULL,'Test User','female',65.0,165.0,90,90,'[\"sat\",\"tue\",\"thu\"]','2026-04-27 18:03:54','2026-04-27 18:03:54'),
(2,NULL,'غاية','female',50.0,148.0,90,90,'[\"sat\",\"tue\",\"thu\"]','2026-04-27 18:05:10','2026-04-27 18:05:10'),
(3,NULL,'Test','female',65.0,165.0,90,90,'[\"sat\",\"tue\"]','2026-04-29 16:08:56','2026-04-29 16:08:56'),
(4,NULL,'غاية','female',50.0,148.0,90,90,'[\"sat\",\"tue\",\"thu\",\"fri\"]','2026-04-29 16:09:26','2026-04-29 16:09:26'),
(5,3,'غاية','female',55.0,162.0,90,90,'[\"sat\",\"tue\",\"thu\"]','2026-04-29 16:34:34','2026-04-29 16:34:34'),
(6,1,'غاية','female',50.0,150.0,90,90,'[\"sat\",\"tue\",\"thu\"]','2026-04-29 16:35:06','2026-04-29 16:35:06'),
(7,4,'test','female',70.0,170.0,60,90,'[\"sat\",\"tue\",\"thu\"]','2026-04-29 16:38:42','2026-04-29 16:38:42');
/*!40000 ALTER TABLE `user_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` enum('male','female') NOT NULL DEFAULT 'female',
  `weight` double DEFAULT NULL,
  `height` double DEFAULT NULL,
  `session_duration` int(11) NOT NULL DEFAULT 90,
  `workout_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`workout_days`)),
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'test','ghayh0000@gmail.com','$2y$12$Y2kaI7VgTOJH6MR9QAglLu8.9Xl534T6P9o.ZBa5WGzcMXAxF8CKC','female',NULL,NULL,90,NULL,NULL,'2026-04-29 16:25:46','2026-04-29 16:25:46'),
(2,'Ghayah','test2@test.com','$2y$12$aoAdbzoJuOZsX/koNg4AFeuaH6vPGYaqDe9L7pFjM3nq6y..icvei','female',NULL,NULL,90,NULL,NULL,'2026-04-29 16:33:30','2026-04-29 16:33:30'),
(3,'غاية','test@mygymcoach.com','$2y$12$TZ94fdk3nU1SCywrqvPwju1VX50gKQU1W5qsSWc3klcYNMuCZq7nS','female',NULL,NULL,90,NULL,NULL,'2026-04-29 16:34:34','2026-04-29 16:34:34'),
(4,'test','ghyah0000@gmail.com','$2y$12$LMu2knYYCECcKEj7ERV2UORWxzYsUtRVNfPg55Q50biuiEeOcEQEK','female',NULL,NULL,90,NULL,NULL,'2026-04-29 16:38:16','2026-04-29 16:38:16');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'my_gym_coach'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-29 22:50:36
