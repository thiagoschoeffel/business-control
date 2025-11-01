-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: business-control
-- ------------------------------------------------------
-- Server version	5.7.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `app_modules`
--

DROP TABLE IF EXISTS `app_modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `name_class` varchar(255) NOT NULL,
  `level_class` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_modules`
--

LOCK TABLES `app_modules` WRITE;
/*!40000 ALTER TABLE `app_modules` DISABLE KEYS */;
INSERT INTO `app_modules` VALUES (1,'GESTÃO DE USUÁRIOS','User',1,'2021-02-04 13:27:18',NULL),(2,'DASHBOARD MATÉRIA-PRIMA','Dashboard',2,'2021-02-04 13:28:34',NULL),(3,'GESTÃO DE MATÉRIA-PRIMA','Raw_material',3,'2021-02-04 13:34:48',NULL),(4,'GESTÃO DE TIPOS DE BLOCO','Block_type',4,'2021-02-04 13:34:48',NULL),(5,'GESTÃO DE TIPOS DE MOLDADO','Molded_type',5,'2021-02-04 13:34:48',NULL),(6,'GESTÃO DE SILOS','Silo',6,'2021-02-04 13:34:48',NULL),(7,'GESTÃO DE OPERADORES','Operator',7,'2021-02-04 13:34:48',NULL),(8,'GESTÃO DE ENTRADA DE MATÉRIA-PRIMA','Raw_material_entrance',8,'2021-02-04 13:34:48',NULL),(9,'GESTÃO DE APONTAMENTO DE PRODUÇÃO - REQUISIÇÃO','Requisition',9,'2021-02-04 13:34:49',NULL),(10,'GESTÃO DE APONTAMENTO DE PRODUÇÃO - BLOCO','Block',10,'2021-02-04 13:34:49',NULL),(11,'GESTÃO DE APONTAMENTO DE PRODUÇÃO - MOLDADO','Molded',11,'2021-02-04 13:34:49',NULL),(12,'GESTÃO DE APONTAMENTO DE PRODUÇÃO - REFUGOS DE MOLDADO','Molded_refugee',12,'2021-02-04 13:34:49',NULL),(13,'GESTÃO DE PARADA DE MÁQUINA','Machine_stop',13,'2021-02-04 13:34:49','2021-02-11 16:25:50'),(14,'GESTÃO DE SAÍDA DE BLOCO','Block_output',14,'2021-02-04 13:34:49','2021-02-11 16:25:50'),(15,'GESTÃO DE MOTIVOS','Reason',15,'2021-02-04 14:54:33',NULL),(16,'GESTÃO DE SETORES','Sector',16,'2021-02-11 16:25:49',NULL),(17,'GESTÃO DE SAÍDA DE MOLDADO','Molded_output',17,'2021-02-11 16:25:50',NULL),(18,'GESTÃO DE MÁQUINAS','Machine',18,'2021-02-11 16:35:24',NULL),(19,'GESTÃO DE INVENTÁRIO DE BLOCO','Block_inventory',19,'2021-06-04 18:26:28',NULL);
/*!40000 ALTER TABLE `app_modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `app_users`
--

DROP TABLE IF EXISTS `app_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(60) NOT NULL,
  `last_name` varchar(60) NOT NULL,
  `email` varchar(220) NOT NULL,
  `login` varchar(3) NOT NULL,
  `password` varchar(255) NOT NULL,
  `permissions` varchar(255) DEFAULT NULL,
  `first_access` char(1) NOT NULL DEFAULT 'S',
  `last_access` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_un` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Users for system access.';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_users`
--

LOCK TABLES `app_users` WRITE;
/*!40000 ALTER TABLE `app_users` DISABLE KEYS */;
INSERT INTO `app_users` VALUES (1,'ADMIN','','admin@example.com.br','adm','$2a$12$dONn6wXlOznj96jeeaXZsuYoi4QhXS/8g06vMIOqZOgRj2gktqfJq','1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19','N','2025-10-31 21:21:31','2025-10-31 21:15:00','2025-11-01 00:21:31');
/*!40000 ALTER TABLE `app_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_block_types`
--

DROP TABLE IF EXISTS `rwm_block_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_block_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `raw_material_percent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_block_types`
--

LOCK TABLES `rwm_block_types` WRITE;
/*!40000 ALTER TABLE `rwm_block_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_block_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_blocks`
--

DROP TABLE IF EXISTS `rwm_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requisition` int(11) NOT NULL,
  `requisition_sequence` int(11) DEFAULT '0',
  `date_time_start` datetime NOT NULL,
  `date_time_finish` datetime NOT NULL,
  `record` int(11) NOT NULL,
  `weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `virgin_weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `recycled_weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `density` decimal(10,2) NOT NULL DEFAULT '0.00',
  `block_type` int(11) NOT NULL,
  `raw_material_percent` decimal(10,2) NOT NULL DEFAULT '0.00',
  `length` int(4) NOT NULL,
  `width` int(4) NOT NULL,
  `height` int(4) NOT NULL,
  `cubic_meters` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `silos` varchar(255) NOT NULL,
  `operators` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_gmp_blocks_gmp_requisitions` (`requisition`),
  KEY `idx_blocks_type_height_finish` (`block_type`,`height`,`date_time_finish`),
  KEY `idx_blocks_req_seq` (`requisition`,`requisition_sequence`),
  CONSTRAINT `FK_gmp_blocks_gmp_requisitions` FOREIGN KEY (`requisition`) REFERENCES `rwm_requisitions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_blocks`
--

LOCK TABLES `rwm_blocks` WRITE;
/*!40000 ALTER TABLE `rwm_blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_blocks_inventory`
--

DROP TABLE IF EXISTS `rwm_blocks_inventory`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_blocks_inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time_inventory` datetime NOT NULL,
  `block_type` int(11) NOT NULL,
  `height` int(4) NOT NULL DEFAULT '0',
  `quantity_inventory` decimal(10,2) NOT NULL DEFAULT '0.00',
  `cubic_meters` decimal(10,4) NOT NULL DEFAULT '0.0000',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `rwm_blocks_inventory_FK` (`block_type`),
  KEY `idx_inv_type_height_date` (`block_type`,`height`,`date_time_inventory`),
  CONSTRAINT `rwm_blocks_inventory_FK` FOREIGN KEY (`block_type`) REFERENCES `rwm_block_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_blocks_inventory`
--

LOCK TABLES `rwm_blocks_inventory` WRITE;
/*!40000 ALTER TABLE `rwm_blocks_inventory` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_blocks_inventory` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_blocks_output`
--

DROP TABLE IF EXISTS `rwm_blocks_output`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_blocks_output` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time_output` datetime NOT NULL,
  `requisition` int(11) NOT NULL,
  `requisition_sequence` int(11) NOT NULL,
  `machine` int(11) DEFAULT '0',
  `fabrication_order` int(11) NOT NULL DEFAULT '0',
  `requisition_operators` varchar(255) DEFAULT NULL,
  `output_operators` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_out_req_seq_date` (`requisition`,`requisition_sequence`,`date_time_output`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_blocks_output`
--

LOCK TABLES `rwm_blocks_output` WRITE;
/*!40000 ALTER TABLE `rwm_blocks_output` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_blocks_output` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_machine_stops`
--

DROP TABLE IF EXISTS `rwm_machine_stops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_machine_stops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time_start` datetime NOT NULL,
  `date_time_finish` datetime NOT NULL,
  `machine` int(11) NOT NULL,
  `reason` int(11) NOT NULL,
  `note` longtext,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_machine_stops`
--

LOCK TABLES `rwm_machine_stops` WRITE;
/*!40000 ALTER TABLE `rwm_machine_stops` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_machine_stops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_machines`
--

DROP TABLE IF EXISTS `rwm_machines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_machines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sector` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_machines`
--

LOCK TABLES `rwm_machines` WRITE;
/*!40000 ALTER TABLE `rwm_machines` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_machines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_molded_refugees`
--

DROP TABLE IF EXISTS `rwm_molded_refugees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_molded_refugees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `molded` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `reason` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_gmp_molded_refugees_gmp_moldeds` (`molded`),
  CONSTRAINT `FK_gmp_molded_refugees_gmp_moldeds` FOREIGN KEY (`molded`) REFERENCES `rwm_moldeds` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_molded_refugees`
--

LOCK TABLES `rwm_molded_refugees` WRITE;
/*!40000 ALTER TABLE `rwm_molded_refugees` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_molded_refugees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_molded_types`
--

DROP TABLE IF EXISTS `rwm_molded_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_molded_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `package_quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_molded_types`
--

LOCK TABLES `rwm_molded_types` WRITE;
/*!40000 ALTER TABLE `rwm_molded_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_molded_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_moldeds`
--

DROP TABLE IF EXISTS `rwm_moldeds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_moldeds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requisition` int(11) NOT NULL,
  `molded_type` int(11) DEFAULT '0',
  `date_time_start` datetime NOT NULL,
  `date_time_finish` datetime NOT NULL,
  `record` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `package_weight` decimal(10,2) NOT NULL DEFAULT '0.00',
  `weight_considered_unit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_weight_considered` decimal(10,2) NOT NULL DEFAULT '0.00',
  `silos` varchar(255) NOT NULL,
  `operators` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_gmp_moldeds_gmp_requisitions` (`requisition`),
  CONSTRAINT `FK_gmp_moldeds_gmp_requisitions` FOREIGN KEY (`requisition`) REFERENCES `rwm_requisitions` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_moldeds`
--

LOCK TABLES `rwm_moldeds` WRITE;
/*!40000 ALTER TABLE `rwm_moldeds` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_moldeds` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_moldeds_output`
--

DROP TABLE IF EXISTS `rwm_moldeds_output`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_moldeds_output` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time_output` datetime NOT NULL,
  `molded_type` int(11) NOT NULL,
  `quantity_output` decimal(10,2) NOT NULL DEFAULT '0.00',
  `fabrication_order` int(11) NOT NULL DEFAULT '0',
  `requisition_operators` varchar(255) NOT NULL,
  `output_operators` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_moldeds_output`
--

LOCK TABLES `rwm_moldeds_output` WRITE;
/*!40000 ALTER TABLE `rwm_moldeds_output` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_moldeds_output` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_operators`
--

DROP TABLE IF EXISTS `rwm_operators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_operators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sector` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_operators`
--

LOCK TABLES `rwm_operators` WRITE;
/*!40000 ALTER TABLE `rwm_operators` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_operators` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_raw_material_entrances`
--

DROP TABLE IF EXISTS `rwm_raw_material_entrances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_raw_material_entrances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time_entrance` datetime NOT NULL,
  `invoice` bigint(20) NOT NULL,
  `raw_material` int(11) NOT NULL,
  `quantity` decimal(10,2) DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `gmp_raw_material_entrances_gmp_raw_materials_fk` (`raw_material`),
  CONSTRAINT `gmp_raw_material_entrances_gmp_raw_materials_fk` FOREIGN KEY (`raw_material`) REFERENCES `rwm_raw_materials` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_raw_material_entrances`
--

LOCK TABLES `rwm_raw_material_entrances` WRITE;
/*!40000 ALTER TABLE `rwm_raw_material_entrances` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_raw_material_entrances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_raw_materials`
--

DROP TABLE IF EXISTS `rwm_raw_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_raw_materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `date_initial_inventory` datetime NOT NULL,
  `quantity_initial_inventory` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_raw_materials`
--

LOCK TABLES `rwm_raw_materials` WRITE;
/*!40000 ALTER TABLE `rwm_raw_materials` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_raw_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_reasons`
--

DROP TABLE IF EXISTS `rwm_reasons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_reasons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_reasons`
--

LOCK TABLES `rwm_reasons` WRITE;
/*!40000 ALTER TABLE `rwm_reasons` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_reasons` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_requisitions`
--

DROP TABLE IF EXISTS `rwm_requisitions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_requisitions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_time_start` datetime NOT NULL,
  `date_time_finish` datetime NOT NULL,
  `record` int(11) NOT NULL,
  `raw_material` int(11) NOT NULL,
  `quantity` decimal(10,2) NOT NULL DEFAULT '0.00',
  `quantity_considered` decimal(10,2) NOT NULL DEFAULT '0.00',
  `silos` varchar(255) NOT NULL,
  `operators` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_requisitions`
--

LOCK TABLES `rwm_requisitions` WRITE;
/*!40000 ALTER TABLE `rwm_requisitions` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_requisitions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_sectors`
--

DROP TABLE IF EXISTS `rwm_sectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_sectors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_sectors`
--

LOCK TABLES `rwm_sectors` WRITE;
/*!40000 ALTER TABLE `rwm_sectors` DISABLE KEYS */;
INSERT INTO `rwm_sectors` VALUES (1,'SETOR 1','2025-11-01 00:22:49',NULL);
/*!40000 ALTER TABLE `rwm_sectors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rwm_silos`
--

DROP TABLE IF EXISTS `rwm_silos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rwm_silos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `description` (`description`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rwm_silos`
--

LOCK TABLES `rwm_silos` WRITE;
/*!40000 ALTER TABLE `rwm_silos` DISABLE KEYS */;
/*!40000 ALTER TABLE `rwm_silos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `vbi_producaomateriaprima`
--

DROP TABLE IF EXISTS `vbi_producaomateriaprima`;
/*!50001 DROP VIEW IF EXISTS `vbi_producaomateriaprima`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vbi_producaomateriaprima` AS SELECT 
 1 AS `datahorainicialrequisicao`,
 1 AS `datahorafinalrequisicao`,
 1 AS `ficharequisicao`,
 1 AS `materiaprimarequisicao`,
 1 AS `quantidadekgrequisicao`,
 1 AS `datahorainicialbloco`,
 1 AS `datahorafinalbloco`,
 1 AS `fichabloco`,
 1 AS `pesokgbloco`,
 1 AS `pesovirgemkgbloco`,
 1 AS `pesorecicladokgbloco`,
 1 AS `densidadebloco`,
 1 AS `tipobloco`,
 1 AS `porcentagemmaterialvirgembloco`,
 1 AS `comprimentommbloco`,
 1 AS `largurammbloco`,
 1 AS `alturammbloco`,
 1 AS `metroscubicosbloco`,
 1 AS `datahorainicialmoldada`,
 1 AS `datahorafinalmoldada`,
 1 AS `fichamoldada`,
 1 AS `quantidadeundmoldada`,
 1 AS `pesoproducaokgmoldada`*/;
SET character_set_client = @saved_cs_client;

--
-- Dumping routines for database 'business-control'
--

--
-- Final view structure for view `vbi_producaomateriaprima`
--

/*!50001 DROP VIEW IF EXISTS `vbi_producaomateriaprima`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vbi_producaomateriaprima` AS select `req`.`date_time_start` AS `datahorainicialrequisicao`,`req`.`date_time_finish` AS `datahorafinalrequisicao`,`req`.`record` AS `ficharequisicao`,`rwm`.`description` AS `materiaprimarequisicao`,`req`.`quantity` AS `quantidadekgrequisicao`,`blk`.`date_time_start` AS `datahorainicialbloco`,`blk`.`date_time_finish` AS `datahorafinalbloco`,`blk`.`record` AS `fichabloco`,`blk`.`weight` AS `pesokgbloco`,`blk`.`virgin_weight` AS `pesovirgemkgbloco`,`blk`.`recycled_weight` AS `pesorecicladokgbloco`,`blk`.`density` AS `densidadebloco`,`bkt`.`description` AS `tipobloco`,`blk`.`raw_material_percent` AS `porcentagemmaterialvirgembloco`,`blk`.`length` AS `comprimentommbloco`,`blk`.`width` AS `largurammbloco`,`blk`.`height` AS `alturammbloco`,`blk`.`cubic_meters` AS `metroscubicosbloco`,`mld`.`date_time_start` AS `datahorainicialmoldada`,`mld`.`date_time_finish` AS `datahorafinalmoldada`,`mld`.`record` AS `fichamoldada`,`mld`.`quantity` AS `quantidadeundmoldada`,`mld`.`total_weight_considered` AS `pesoproducaokgmoldada` from ((((`rwm_requisitions` `req` left join `rwm_blocks` `blk` on((`req`.`id` = `blk`.`requisition`))) left join `rwm_moldeds` `mld` on((`req`.`id` = `mld`.`requisition`))) left join `rwm_raw_materials` `rwm` on((`req`.`raw_material` = `rwm`.`id`))) left join `rwm_block_types` `bkt` on((`blk`.`block_type` = `bkt`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-31 21:23:48
