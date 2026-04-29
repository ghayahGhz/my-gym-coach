/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.16-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: my_gym_coach
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
(1,'bp','بنش برس','chest','صدر','strength',0,'https://www.youtube.com/watch?v=vcBig73ojpE','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(2,'df','فلاي دمبل','chest','صدر','strength',0,'https://www.youtube.com/watch?v=eozdVDA78K0','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(3,'pu','تمرين الضغط','chest','صدر','strength',0,'https://www.youtube.com/watch?v=IODxDxX7oi4','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(4,'cf','كابل فلاي','chest','صدر','strength',0,'https://www.youtube.com/watch?v=Iwe6AmxVf7o','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(5,'lp','لات بول داون','back','ظهر','strength',0,'https://www.youtube.com/watch?v=CAwf7n6Luuc','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(6,'crw','كابل رو','back','ظهر','strength',0,'https://www.youtube.com/watch?v=GZbfZ033f74','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(7,'dl','ديد ليفت','back','ظهر','strength',0,'https://www.youtube.com/watch?v=op9kVnSso6Q','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(8,'puu','عقلة','back','ظهر','strength',0,'https://www.youtube.com/watch?v=eGo4IYlbE5g','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(9,'sq','سكوات','legs','أرجل','strength',0,'https://www.youtube.com/watch?v=gsNoPYwWXeM','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(10,'lpr','ليج بريس','legs','أرجل','strength',0,'https://www.youtube.com/watch?v=IZxyjW7MPJQ','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(11,'ht','هيب ثرست','legs','أرجل','strength',0,'https://www.youtube.com/watch?v=SEdqd1n0cvg','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(12,'lu','لانج','legs','أرجل','strength',0,'https://www.youtube.com/watch?v=QOVaHwm-Q6U','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(13,'rdl','رومانيان ديد ليفت','legs','أرجل','strength',0,'https://www.youtube.com/watch?v=JCXUYuzwNrM','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(14,'cal','رفع الكعب','legs','أرجل','strength',0,'https://www.youtube.com/watch?v=-M4-G8p1fCI','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(15,'sp','ضغط الكتف','shoulder','كتف','strength',0,'https://www.youtube.com/watch?v=qEwKCR5JCog','2026-04-29 16:57:57','2026-04-29 17:05:39'),
(16,'lr','رفع جانبي','shoulder','كتف','strength',0,'https://www.youtube.com/watch?v=3VcKaXpzqRo','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(17,'fr','رفع أمامي','shoulder','كتف','strength',0,'https://www.youtube.com/watch?v=sOoBQukXMFo','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(18,'cru','كرنش','abs','بطن','strength',0,'https://www.youtube.com/watch?v=Xyd_fa5zoEU','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(19,'pl','بلانك','abs','بطن','strength',1,'https://www.youtube.com/watch?v=pSHjTRCQxIw','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(20,'rt','روسيان تويست','abs','بطن','strength',0,'https://www.youtube.com/watch?v=wkD8rjkodUI','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(21,'hlr','رفع الأرجل المعلقة','abs','بطن','strength',0,'https://www.youtube.com/watch?v=hdng3Nm1x_E','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(22,'bc','بايسيكل كرنش','abs','بطن','strength',0,'https://www.youtube.com/watch?v=9FGilxCbdz8','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(23,'tm','جهاز الجري','cardio','كارديو','cardio',1,'https://www.youtube.com/watch?v=kMMbqSCHPEA','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(24,'bh','دراجة HIIT','cardio','كارديو','cardio',1,'https://www.youtube.com/watch?v=PqjpFWGf_5E','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(25,'scc','ستير كلايمر','cardio','كارديو','cardio',1,'https://www.youtube.com/watch?v=n1GXCNtMB8o','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(26,'el','إليبتيكال','cardio','كارديو','cardio',1,'https://www.youtube.com/watch?v=AsDzYuEv6V0','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(27,'ks','تمرين الكيتل بيل','cardio','كارديو','cardio',0,'https://www.youtube.com/watch?v=sSESeQAir2M','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(28,'bst','إطالة الظهر','stretch','إطالة','stretch',1,'https://www.youtube.com/watch?v=g8M6oFWX5bU','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(29,'lst','إطالة الأرجل','stretch','إطالة','stretch',1,'https://www.youtube.com/watch?v=_HDZODHx3TU','2026-04-29 16:57:58','2026-04-29 17:05:39'),
(30,'sst','إطالة الكتف','stretch','إطالة','stretch',1,'https://www.youtube.com/watch?v=8lDC4Ri9zAQ','2026-04-29 16:57:58','2026-04-29 17:05:39');
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(9,'0001_01_01_000000_create_users_table',1),
(10,'0001_01_01_000001_create_cache_table',1),
(11,'0001_01_01_000002_create_jobs_table',1),
(12,'2026_04_27_201300_create_exercises_table',1),
(13,'2026_04_27_201300_create_user_profiles_table',1),
(14,'2026_04_27_201301_create_done_dates_table',1),
(15,'2026_04_27_201301_create_user_exercises_table',1),
(16,'2026_04_29_000001_add_user_id_to_user_profiles',1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_exercises`
--

LOCK TABLES `user_exercises` WRITE;
/*!40000 ALTER TABLE `user_exercises` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profiles`
--

LOCK TABLES `user_profiles` WRITE;
/*!40000 ALTER TABLE `user_profiles` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
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

-- Dump completed on 2026-04-29 23:05:57
