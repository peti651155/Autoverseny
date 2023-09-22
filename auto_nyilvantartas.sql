-- --------------------------------------------------------
-- Hoszt:                        127.0.0.1
-- Szerver verzió:               8.0.30 - MySQL Community Server - GPL
-- Szerver OS:                   Win64
-- HeidiSQL Verzió:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Adatbázis struktúra mentése a auto_nyilvantartas.
CREATE DATABASE IF NOT EXISTS `auto_nyilvantartas` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `auto_nyilvantartas`;

-- Struktúra mentése tábla auto_nyilvantartas. auto
CREATE TABLE IF NOT EXISTS `auto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `manufacture_year` int NOT NULL,
  `power` int NOT NULL,
  `weight` int NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `image_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tábla adatainak mentése auto_nyilvantartas.auto: ~24 rows (hozzávetőleg)
INSERT INTO `auto` (`id`, `model`, `manufacture_year`, `power`, `weight`, `deleted_at`, `image_name`) VALUES
	(1, 'Audi A5', 2020, 312, 1450, NULL, 'bmw-650d93c6ad310.jpg'),
	(2, 'BMW M4', 2015, 300, 1450, NULL, NULL),
	(3, 'Mercedes C200', 2018, 183, 1440, NULL, NULL),
	(4, 'Tesla Model 3', 2021, 283, 1610, NULL, NULL),
	(5, 'Ford Mustang', 2017, 450, 1800, NULL, NULL),
	(6, 'Honda Civic', 2016, 158, 1270, NULL, NULL),
	(7, 'Toyota Corolla', 2020, 139, 1300, NULL, NULL),
	(8, 'Nissan Altima', 2019, 188, 1420, NULL, NULL),
	(9, 'Volkswagen Golf', 2018, 147, 1204, NULL, NULL),
	(10, 'Hyundai Elantra', 2021, 128, 1250, NULL, NULL),
	(11, 'Chevrolet Cruze', 2017, 153, 1334, NULL, NULL),
	(12, 'Mazda 3', 2021, 186, 1340, NULL, NULL),
	(13, 'Subaru Impreza', 2020, 152, 1400, NULL, NULL),
	(14, 'Kia Forte', 2019, 147, 1278, NULL, NULL),
	(15, 'Porsche 911', 2018, 443, 1515, NULL, NULL),
	(16, 'Lexus IS', 2016, 241, 1585, NULL, NULL),
	(17, 'Jaguar XF', 2017, 180, 1605, NULL, NULL),
	(18, 'Infiniti Q50', 2020, 208, 1620, NULL, NULL),
	(19, 'Volvo S60', 2021, 250, 1612, NULL, NULL),
	(20, 'Acura TLX', 2019, 206, 1550, NULL, NULL),
	(21, 'Alfa Romeo Giulia', 2018, 280, 1524, NULL, NULL),
	(22, 'Cadillac CTS', 2017, 268, 1620, NULL, NULL),
	(58, 'Opel astra H', 2023, 125, 1151, NULL, NULL),
	(65, 'Teszt', 2022, 222, 2222, NULL, NULL);

-- Struktúra mentése tábla auto_nyilvantartas. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Tábla adatainak mentése auto_nyilvantartas.doctrine_migration_versions: ~1 rows (hozzávetőleg)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20230919135119', '2023-09-19 13:51:35', 24);

-- Struktúra mentése tábla auto_nyilvantartas. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tábla adatainak mentése auto_nyilvantartas.messenger_messages: ~0 rows (hozzávetőleg)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
