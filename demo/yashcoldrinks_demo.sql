-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: yashcoldrinks_demo
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

CREATE DATABASE IF NOT EXISTS `yashcoldrinks_demo` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `yashcoldrinks_demo`;

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL,
  `mobile` varchar(300) NOT NULL,
  `role` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Admin','202cb962ac59075b964b07152d234b70','1234567890','admin');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `agencylist`
--

DROP TABLE IF EXISTS `agencylist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agencylist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `agencyName` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agencylist`
--

LOCK TABLES `agencylist` WRITE;
/*!40000 ALTER TABLE `agencylist` DISABLE KEYS */;
INSERT INTO `agencylist` VALUES (1,'Coca-Cola Distributors'),(2,'PepsiCo Agency'),(3,'Local Traders');
/*!40000 ALTER TABLE `agencylist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_items`
--

DROP TABLE IF EXISTS `bill_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `productname` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `scheme` varchar(200) DEFAULT NULL,
  `schemebottles` double DEFAULT NULL,
  `priceperbox` double NOT NULL,
  `totalamount` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `bill_id` (`bill_id`),
  CONSTRAINT `bill_items_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_items`
--

LOCK TABLES `bill_items` WRITE;
/*!40000 ALTER TABLE `bill_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `bill_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `counter_name` varchar(200) NOT NULL,
  `total_bill_amount` double NOT NULL DEFAULT 0,
  `paid_amount` double NOT NULL DEFAULT 0,
  `payment_status` enum('Paid','Unpaid','Partially Paid') DEFAULT 'Unpaid',
  `bill_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counterlist`
--

DROP TABLE IF EXISTS `counterlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `counterlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `counterName` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counterlist`
--

LOCK TABLES `counterlist` WRITE;
/*!40000 ALTER TABLE `counterlist` DISABLE KEYS */;
INSERT INTO `counterlist` VALUES (1,'Counter 1'),(2,'Counter 2'),(3,'Counter 3');
/*!40000 ALTER TABLE `counterlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `expense_date` date NOT NULL,
  `expense_type` varchar(100) NOT NULL,
  `amount` double NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `amount_paid` double NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_type` enum('full','partial') DEFAULT 'partial',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `bill_id` (`bill_id`),
  CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productlist`
--

DROP TABLE IF EXISTS `productlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productname` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productlist`
--

LOCK TABLES `productlist` WRITE;
/*!40000 ALTER TABLE `productlist` DISABLE KEYS */;
INSERT INTO `productlist` VALUES (1,'ThumsUp-250'),(2,'Sprite-250'),(3,'Fanta-250'),(4,'Coca-Cola-250'),(5,'Limca-250'),(6,'Maaza-250');
/*!40000 ALTER TABLE `productlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'ThumsUp-250','Refreshing ThumsUp cold drink 250ml',20.00,NULL,'Cola',100,1,'2026-02-13 07:08:53','2026-02-13 07:08:53'),(2,'Sprite-250','Refreshing Sprite lemon drink 250ml',20.00,NULL,'Lemon',100,1,'2026-02-13 07:08:53','2026-02-13 07:08:53'),(3,'Fanta-250','Refreshing Fanta orange drink 250ml',20.00,NULL,'Orange',100,1,'2026-02-13 07:08:53','2026-02-13 07:08:53'),(4,'Coca-Cola-250','Classic Coca-Cola 250ml',20.00,NULL,'Cola',100,1,'2026-02-13 07:08:53','2026-02-13 07:08:53'),(5,'Limca-250','Refreshing Limca lime drink 250ml',20.00,NULL,'Lemon',100,1,'2026-02-13 07:08:53','2026-02-13 07:08:53'),(6,'Maaza-250','Mango flavored Maaza drink 250ml',25.00,NULL,'Mango',100,1,'2026-02-13 07:08:53','2026-02-13 07:08:53');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sell`
--

DROP TABLE IF EXISTS `sell`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sell` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) DEFAULT NULL,
  `productname` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `scheme` varchar(200) DEFAULT NULL,
  `schemebottles` double DEFAULT NULL,
  `priceperbox` double NOT NULL,
  `totalbillamount` double NOT NULL,
  `countername` varchar(200) DEFAULT NULL,
  `paymentmethod` varchar(100) DEFAULT NULL,
  `bill_items` text DEFAULT NULL,
  `sellDate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sell`
--

LOCK TABLES `sell` WRITE;
/*!40000 ALTER TABLE `sell` DISABLE KEYS */;
/*!40000 ALTER TABLE `sell` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productname` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `bottles` double NOT NULL DEFAULT 0,
  `totalbottles` double NOT NULL DEFAULT 0,
  `priceperbox` double NOT NULL,
  `totalbillamount` double NOT NULL,
  `paid_amount` double DEFAULT 0,
  `payment_status` enum('Paid','Unpaid','Partial') DEFAULT 'Unpaid',
  `payment_mode` varchar(100) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `agencyname` varchar(200) NOT NULL,
  `buydate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` VALUES (1,'ThumsUp-250',20,24,480,520,10400,10400,'Paid','Cash','2026-02-10 10:00:00','Coca-Cola Distributors','2026-02-10 10:00:00'),(2,'Sprite-250',15,24,360,500,7500,7500,'Paid','PhonePe','2026-02-10 11:00:00','Coca-Cola Distributors','2026-02-10 11:00:00'),(3,'Fanta-250',10,24,240,480,4800,2400,'Partial','Cash','2026-02-11 09:00:00','PepsiCo Agency','2026-02-11 09:00:00'),(4,'Coca-Cola-250',25,24,600,520,13000,0,'Unpaid',NULL,NULL,'Local Traders','2026-02-12 08:00:00'),(5,'Limca-250',12,24,288,460,5520,5520,'Paid','Cash','2026-02-12 14:00:00','Coca-Cola Distributors','2026-02-12 14:00:00'),(6,'Maaza-250',18,24,432,540,9720,0,'Unpaid',NULL,NULL,'PepsiCo Agency','2026-02-13 09:00:00');
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `totalstocksadded`
--

DROP TABLE IF EXISTS `totalstocksadded`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `totalstocksadded` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productname` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `bottles` double NOT NULL DEFAULT 0,
  `totalbottles` double NOT NULL DEFAULT 0,
  `priceperbox` double NOT NULL,
  `totalbillamount` double NOT NULL,
  `paid_amount` double DEFAULT 0,
  `payment_status` enum('Paid','Unpaid','Partial') DEFAULT 'Unpaid',
  `payment_mode` varchar(100) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `agencyname` varchar(200) NOT NULL,
  `buydate` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `totalstocksadded`
--

LOCK TABLES `totalstocksadded` WRITE;
/*!40000 ALTER TABLE `totalstocksadded` DISABLE KEYS */;
INSERT INTO `totalstocksadded` VALUES (1,'ThumsUp-250',20,24,480,520,10400,10400,'Paid','Cash','2026-02-10 10:00:00','Coca-Cola Distributors','2026-02-10 10:00:00'),(2,'Sprite-250',15,24,360,500,7500,7500,'Paid','PhonePe','2026-02-10 11:00:00','Coca-Cola Distributors','2026-02-10 11:00:00'),(3,'Fanta-250',10,24,240,480,4800,2400,'Partial','Cash','2026-02-11 09:00:00','PepsiCo Agency','2026-02-11 09:00:00'),(4,'Coca-Cola-250',25,24,600,520,13000,0,'Unpaid',NULL,NULL,'Local Traders','2026-02-12 08:00:00'),(5,'Limca-250',12,24,288,460,5520,5520,'Paid','Cash','2026-02-12 14:00:00','Coca-Cola Distributors','2026-02-12 14:00:00'),(6,'Maaza-250',18,24,432,540,9720,0,'Unpaid',NULL,NULL,'PepsiCo Agency','2026-02-13 09:00:00');
/*!40000 ALTER TABLE `totalstocksadded` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-13 13:38:28
