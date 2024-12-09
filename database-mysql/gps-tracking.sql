-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.1.0 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.6.0.6765
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_gps_tracking
CREATE DATABASE IF NOT EXISTS `db_gps_tracking` /*!40100 DEFAULT CHARACTER SET latin1 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_gps_tracking`;

-- Dumping structure for table db_gps_tracking.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gps_tracking.admin: ~0 rows (approximately)
INSERT INTO `admin` (`id`, `username`, `password`) VALUES
	(1, 'admin', 'ed2dfbf696098eb97c36e5aa3ac3d668');

-- Dumping structure for table db_gps_tracking.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gps_tracking.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table db_gps_tracking.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gps_tracking.migrations: ~6 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(2, '2019_08_19_000000_create_failed_jobs_table', 1),
	(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(4, '2024_12_04_133953_create_admin_table', 1),
	(5, '2024_12_04_133954_create_users_table', 1),
	(6, '2024_12_04_133955_create_tracking_table', 1);

-- Dumping structure for table db_gps_tracking.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gps_tracking.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table db_gps_tracking.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gps_tracking.personal_access_tokens: ~0 rows (approximately)

-- Dumping structure for table db_gps_tracking.tracking
CREATE TABLE IF NOT EXISTS `tracking` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gps_tracking.tracking: ~99 rows (approximately)
INSERT INTO `tracking` (`id`, `id_user`, `latitude`, `longitude`, `date`, `time`) VALUES
	(62, 1, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:15:01'),
	(63, 1, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:15:11'),
	(64, 1, '-2.1900293429061', '102.639271', '2024-12-07', '14:15:22'),
	(65, 1, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:15:31'),
	(66, 1, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:15:42'),
	(67, 1, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:15:52'),
	(68, 1, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:16:02'),
	(69, 1, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:16:12'),
	(70, 1, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:16:36'),
	(71, 1, '-2.1900293429061', '102.639271', '2024-12-07', '14:16:46'),
	(72, 1, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:16:56'),
	(73, 1, '-2.1900293429061', '102.639271', '2024-12-07', '14:17:06'),
	(74, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:26:14'),
	(75, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:26:25'),
	(76, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:26:35'),
	(77, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:26:45'),
	(78, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:26:55'),
	(79, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:27:05'),
	(80, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:27:15'),
	(81, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:27:25'),
	(82, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:27:36'),
	(83, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:27:45'),
	(84, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:27:56'),
	(85, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:28:06'),
	(86, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:28:16'),
	(87, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:28:26'),
	(88, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:28:36'),
	(89, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:28:46'),
	(90, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:28:57'),
	(91, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:29:07'),
	(92, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:29:17'),
	(93, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:29:27'),
	(94, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:29:37'),
	(95, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:29:47'),
	(96, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:29:57'),
	(97, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:30:07'),
	(98, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:30:17'),
	(99, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:30:28'),
	(100, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:30:38'),
	(101, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:30:48'),
	(102, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:30:58'),
	(103, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:31:08'),
	(104, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:31:18'),
	(105, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:31:29'),
	(106, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:31:39'),
	(107, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:31:49'),
	(108, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:31:59'),
	(109, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:32:09'),
	(110, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:32:19'),
	(111, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:32:30'),
	(112, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:32:40'),
	(113, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:32:50'),
	(114, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:33:00'),
	(115, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:33:11'),
	(116, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:33:22'),
	(117, 6, '-2.1900300583687', '102.63929432179', '2024-12-07', '14:33:31'),
	(118, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:35:04'),
	(119, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:35:14'),
	(120, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:35:25'),
	(121, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:35:35'),
	(122, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:35:45'),
	(123, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:35:55'),
	(124, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:36:06'),
	(125, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:36:16'),
	(126, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:36:26'),
	(127, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:36:36'),
	(128, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:36:46'),
	(129, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:36:56'),
	(130, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:37:06'),
	(131, 6, '-2.1900293429061', '102.639271', '2024-12-07', '14:37:17'),
	(132, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:19:13'),
	(133, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:19:23'),
	(134, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:19:45'),
	(135, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:19:56'),
	(136, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:20:05'),
	(137, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:20:16'),
	(138, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:20:27'),
	(139, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:20:37'),
	(140, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:20:46'),
	(141, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:20:57'),
	(142, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:21:07'),
	(143, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:21:17'),
	(144, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:21:27'),
	(145, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:21:37'),
	(146, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:21:47'),
	(147, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:21:57'),
	(148, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:22:08'),
	(149, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:22:17'),
	(150, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:22:28'),
	(151, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:22:38'),
	(152, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:22:48'),
	(153, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:22:58'),
	(154, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:23:08'),
	(155, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:23:18'),
	(156, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:23:29'),
	(157, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:23:39'),
	(158, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:23:49'),
	(159, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:23:59'),
	(160, 7, '-2.1900293429061', '102.639271', '2024-12-07', '18:24:09');

-- Dumping structure for table db_gps_tracking.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table db_gps_tracking.users: ~2 rows (approximately)
INSERT INTO `users` (`id`, `username`, `password`) VALUES
	(6, 'demo', 'ba0efa407066e5d2430bd3917f5d0d24'),
	(7, 'lamhot', '2209bffaaac5a45b887cc48359da01fa');

-- Dumping structure for view db_gps_tracking.view_tracking
-- Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `view_tracking` (
	`id` BIGINT(20) UNSIGNED NOT NULL,
	`id_user` BIGINT(19) NOT NULL,
	`latitude` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`longitude` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`date` DATE NOT NULL,
	`time` TIME NOT NULL,
	`username` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci'
) ENGINE=MyISAM;

-- Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `view_tracking`;
CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `view_tracking` AS select `tracking`.`id` AS `id`,`tracking`.`id_user` AS `id_user`,`tracking`.`latitude` AS `latitude`,`tracking`.`longitude` AS `longitude`,`tracking`.`date` AS `date`,`tracking`.`time` AS `time`,`users`.`username` AS `username` from (`tracking` join `users`) where (`tracking`.`id_user` = `users`.`id`);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
