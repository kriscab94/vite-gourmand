-- MySQL dump 10.13  Distrib 8.0.41, for Win64 (x86_64)
--
-- Host: localhost    Database: vite_gourmand
-- ------------------------------------------------------
-- Server version	8.0.41

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `avis`
--

DROP TABLE IF EXISTS `avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avis` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int DEFAULT NULL,
  `note` int DEFAULT NULL,
  `commentaire` text,
  `valide` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  CONSTRAINT `avis_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avis`
--

LOCK TABLES `avis` WRITE;
/*!40000 ALTER TABLE `avis` DISABLE KEYS */;
INSERT INTO `avis` VALUES (1,3,5,'ce plat etait tout simplement bon',1),(2,2,1,'a vomir vraiment',1);
/*!40000 ALTER TABLE `avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `menu_id` int DEFAULT NULL,
  `nb_personnes` int DEFAULT NULL,
  `prix_total` decimal(8,2) DEFAULT NULL,
  `prix_livraison` decimal(8,2) DEFAULT NULL,
  `adresse_livraison` text,
  `date_evenement` date DEFAULT NULL,
  `heure_livraison` time DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ville` varchar(100) NOT NULL DEFAULT 'Bordeaux',
  `distance_km` decimal(6,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `menu_id` (`menu_id`),
  CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commandes`
--

LOCK TABLES `commandes` WRITE;
/*!40000 ALTER TABLE `commandes` DISABLE KEYS */;
INSERT INTO `commandes` VALUES (1,7,1,9,243.00,0.00,'8 avenue de la paix','2026-02-22','19:38:00','en attente','2026-02-11 18:38:46','Bordeaux',0.00),(2,7,1,4,120.00,0.00,'KUGJBKJRER67TY94Z','2026-02-27','20:50:00','terminée','2026-02-11 18:50:20','Bordeaux',0.00),(3,7,1,4,120.00,0.00,'KUGJBKJRER67TY94Z','2026-02-27','20:50:00','terminée','2026-02-11 18:50:30','Bordeaux',0.00),(4,7,1,4,120.00,0.00,'avenue de la france','2026-02-28','14:31:00','en attente','2026-02-12 20:31:35','Bordeaux',0.00),(5,7,1,6,180.00,0.00,'kkkorrrnfn de la paix','2026-02-21','10:31:00','en attente','2026-02-12 20:32:08','Bordeaux',0.00),(6,9,1,4,120.00,0.00,'ezegzrrheherher','2026-02-21','07:35:00','en attente','2026-02-13 01:35:55','bordeaux',0.00),(7,9,1,4,361.00,241.00,'ELQMEPLGKSEGM','2026-02-25','09:36:00','en attente','2026-02-13 01:36:28','paris',400.00);
/*!40000 ALTER TABLE `commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horaires`
--

DROP TABLE IF EXISTS `horaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `horaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jour` varchar(20) DEFAULT NULL,
  `heure_ouverture` time DEFAULT NULL,
  `heure_fermeture` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horaires`
--

LOCK TABLES `horaires` WRITE;
/*!40000 ALTER TABLE `horaires` DISABLE KEYS */;
/*!40000 ALTER TABLE `horaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_plats`
--

DROP TABLE IF EXISTS `menu_plats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_plats` (
  `menu_id` int NOT NULL,
  `plat_id` int NOT NULL,
  PRIMARY KEY (`menu_id`,`plat_id`),
  KEY `plat_id` (`plat_id`),
  CONSTRAINT `menu_plats_ibfk_1` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`),
  CONSTRAINT `menu_plats_ibfk_2` FOREIGN KEY (`plat_id`) REFERENCES `plats` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_plats`
--

LOCK TABLES `menu_plats` WRITE;
/*!40000 ALTER TABLE `menu_plats` DISABLE KEYS */;
INSERT INTO `menu_plats` VALUES (1,1),(2,2),(1,3),(2,4),(1,5),(2,6);
/*!40000 ALTER TABLE `menu_plats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(150) DEFAULT NULL,
  `description` text,
  `prix_base` decimal(8,2) DEFAULT NULL,
  `nb_personnes_min` int DEFAULT NULL,
  `theme` varchar(100) DEFAULT NULL,
  `regime` varchar(100) DEFAULT NULL,
  `conditions_menu` text,
  `stock` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'Menu Classique','Menu traditionnel français',120.00,4,'classique','standard','Commander 48h avant',4),(2,'Menu Noël','Menu spécial fêtes',200.00,6,'noel','standard','Commander 1 semaine avant',5);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status_history`
--

DROP TABLE IF EXISTS `order_status_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_status_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int DEFAULT NULL,
  `statut` varchar(50) DEFAULT NULL,
  `date_modification` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`),
  CONSTRAINT `order_status_history_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status_history`
--

LOCK TABLES `order_status_history` WRITE;
/*!40000 ALTER TABLE `order_status_history` DISABLE KEYS */;
INSERT INTO `order_status_history` VALUES (1,1,'en attente','2026-02-11 18:38:46'),(2,2,'en attente','2026-02-11 18:50:20'),(3,3,'en attente','2026-02-11 18:50:30'),(4,3,'annulee','2026-02-11 19:09:40'),(5,3,'accepté','2026-02-11 22:15:08'),(6,3,'accepté','2026-02-11 22:22:46'),(7,3,'terminée','2026-02-11 22:31:12'),(8,2,'terminée','2026-02-11 22:49:16'),(9,4,'en attente','2026-02-12 20:31:35'),(10,5,'en attente','2026-02-12 20:32:08'),(11,6,'en attente','2026-02-13 01:35:55'),(12,7,'en attente','2026-02-13 01:36:28');
/*!40000 ALTER TABLE `order_status_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plats`
--

DROP TABLE IF EXISTS `plats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) DEFAULT NULL,
  `type` enum('entree','plat','dessert') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plats`
--

LOCK TABLES `plats` WRITE;
/*!40000 ALTER TABLE `plats` DISABLE KEYS */;
INSERT INTO `plats` VALUES (1,'Salade César','entree'),(2,'Foie gras','entree'),(3,'Boeuf bourguignon','plat'),(4,'Saumon grillé','plat'),(5,'Tiramisu','dessert'),(6,'Fondant chocolat','dessert');
/*!40000 ALTER TABLE `plats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `adresse` text,
  `password_hash` varchar(255) DEFAULT NULL,
  `role` enum('user','employe','admin') DEFAULT 'user',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Admin','Principal','admin@vitegourmand.fr','0600000000','Bordeaux','admin123','admin',1,'2026-02-10 21:20:16'),(2,'Employe','Test','employe@vitegourmand.fr','0600000001','Bordeaux','employe123','employe',1,'2026-02-10 21:20:16'),(3,'Client','Test','client@test.fr','0600000002','Paris','client123','user',1,'2026-02-10 21:20:16'),(7,'cabanis','kris','kris.cabanis2@gmail.com','0646165687','8 rue marais duntz','$2y$10$njE8A9hQqw5FVu/TMB1ZIeXYiypnKNNp8m4DjVRDVgP1vZeyPzV2i','employe',1,'2026-02-11 17:49:27'),(8,'Employe','Compte','kris.cabanis3@gmail.com','','Bordeaux','$2y$10$8NTxD2oeUM8Yu6aAuMv6we19wzd9zXAxaHVpFTHxSaU.YINegSuDC','employe',0,'2026-02-11 23:05:36'),(9,'cabanis2','kris','kris.cabanis4@gmail.com','0646165689','DE LA PAIX','$2y$10$3ByUjEJfQLwIWctkel3Tueqp/UPhlMVAFhYYvQXa3L0/jpWRhg/bK','user',1,'2026-02-13 00:03:31');
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

-- Dump completed on 2026-02-16 17:24:16
