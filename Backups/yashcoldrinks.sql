-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2026 at 12:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `yashcoldrinks`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` varchar(300) NOT NULL,
  `mobile` varchar(300) NOT NULL,
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `mobile`, `role`) VALUES
(1, 'Yash', '202cb962ac59075b964b07152d234b70', '9405416771', 'admin'),
(2, 'tejas', '0e7517141fb53f21ee439b355b5a1d0a', '8767245556', 'admin'),
(3, 'Prathamesh Pakade', 'cad5c3a025dfd754d6487ddf28b17839', '8010410131', 'manager');

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'approval_code', '5f5b3fd2147df58ce2307dcb4d7db5ab', '2026-02-18 11:15:54');

-- --------------------------------------------------------

--
-- Table structure for table `agencylist`
--

CREATE TABLE `agencylist` (
  `id` int(11) NOT NULL,
  `agencyName` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agencylist`
--

INSERT INTO `agencylist` (`id`, `agencyName`) VALUES
(1, 'Mamta Traders'),
(2, 'Akola Jeera'),
(3, 'Akola Jeera'),
(4, 'Akola Jeera'),
(5, 'Trends'),
(6, 'fdhjkjfdshkhgsd'),
(7, 'Sakshi Agency');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `counter_name` varchar(200) NOT NULL,
  `total_bill_amount` double NOT NULL DEFAULT 0,
  `paid_amount` double NOT NULL DEFAULT 0,
  `payment_status` enum('Paid','Unpaid','Partially Paid') DEFAULT 'Unpaid',
  `bill_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `counter_name`, `total_bill_amount`, `paid_amount`, `payment_status`, `bill_date`, `customer_name`, `customer_phone`) VALUES
(6, 'Counter 1', 100, 100, 'Paid', '2026-01-05 19:18:06', '', ''),
(8, 'Counter 1', 1000, 1000, 'Paid', '2026-01-06 18:01:10', '', ''),
(9, 'Counter 2', 400, 400, 'Paid', '2026-01-06 18:01:53', '', ''),
(10, 'counter 3', 500, 500, 'Paid', '2026-01-06 18:08:10', '', ''),
(11, 'Counter 2', 1000, 1000, 'Paid', '2026-01-06 18:32:07', '', ''),
(12, 'Counter 2', 5000, 5000, 'Paid', '2026-01-06 18:35:22', '', ''),
(13, 'Counter 1', 230, 230, 'Paid', '2026-01-06 19:06:12', '', ''),
(14, 'test counter', 1020, 1020, 'Paid', '2026-01-07 06:44:18', '', ''),
(15, 'vjkjfdv', 230, 0, 'Unpaid', '2026-01-07 07:13:58', '', ''),
(16, 'vjkjfdv', 63600, 63600, 'Paid', '2026-01-09 16:24:23', '', ''),
(17, 'Tahura Generals', 6000, 6000, 'Paid', '2026-02-07 08:14:42', 'Tahura', '');

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `productname` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `scheme` varchar(200) DEFAULT NULL,
  `schemebottles` double DEFAULT NULL,
  `priceperbox` double NOT NULL,
  `totalamount` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_items`
--

INSERT INTO `bill_items` (`id`, `bill_id`, `productname`, `quantity`, `scheme`, `schemebottles`, `priceperbox`, `totalamount`) VALUES
(3, 6, 'Demo', 1, '-', NULL, 100, 100),
(5, 8, 'ThumsUp', 1, '-', NULL, 1000, 1000),
(6, 9, 'Demo1', 1, '-', NULL, 400, 400),
(7, 10, 'Demo4', 2, '-', NULL, 250, 500),
(8, 11, 'ThumsUp', 1, '-', NULL, 1000, 1000),
(9, 12, 'dfa', 1, '-', NULL, 5000, 5000),
(10, 13, 'ThumsUp', 1, '5', 4, 230, 230),
(11, 14, 'Demo5', 2, '-', NULL, 230, 460),
(12, 14, 'csvd', 1, '-', NULL, 560, 560),
(13, 15, 'Demo3', 1, '-', NULL, 230, 230),
(14, 16, 'Fanta 600ml', 120, '-', NULL, 530, 63600),
(15, 17, 'Tejas', 50, '-', NULL, 120, 6000);

-- --------------------------------------------------------

--
-- Table structure for table `counterlist`
--

CREATE TABLE `counterlist` (
  `id` int(11) NOT NULL,
  `counterName` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counterlist`
--

INSERT INTO `counterlist` (`id`, `counterName`) VALUES
(1, 'Counter 1'),
(2, 'Counter 2'),
(3, 'counter 3'),
(4, 'DEmo Counter 1'),
(5, 'test counter'),
(6, 'vjkjfdv'),
(7, 'Tahura Generals');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `monthly_salary` double NOT NULL DEFAULT 0,
  `join_date` date DEFAULT NULL,
  `status` enum('Active','Inactive') DEFAULT 'Active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `phone`, `role`, `monthly_salary`, `join_date`, `status`, `created_at`) VALUES
(1, 'Demo Employ 1', '9999999889', 'Delivery partner', 10000, '2026-01-06', 'Active', '2026-01-06 19:34:52');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `expense_date` date NOT NULL,
  `expense_type` varchar(100) NOT NULL,
  `amount` double NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_date`, `expense_type`, `amount`, `description`, `created_at`) VALUES
(1, '2026-01-05', 'Fuel', 10, '', '2026-01-05 19:21:07'),
(2, '2026-01-06', 'fuel', 500, 'fjhdeu', '2026-01-06 05:55:43'),
(3, '2026-01-06', 'Transport', 200, 'challan', '2026-01-06 18:31:14'),
(4, '2026-01-07', 'Fuel', 200, '', '2026-01-06 18:33:04'),
(5, '2026-01-07', 'Fuel', 200, 'yu', '2026-01-07 06:47:51'),
(6, '2026-02-07', 'Fuel', 1000, 'petrol', '2026-02-07 08:17:37');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) NOT NULL,
  `amount_paid` double NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `payment_type` enum('full','partial') DEFAULT 'partial',
  `payment_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `bill_id`, `amount_paid`, `payment_method`, `payment_type`, `payment_date`) VALUES
(1, 6, 100, 'Cash', 'partial', '2026-01-05 19:18:06'),
(2, 8, 1000, 'Cash', 'partial', '2026-01-06 18:01:10'),
(3, 9, 400, 'PhonePe', 'partial', '2026-01-06 18:01:53'),
(4, 11, 1000, 'Cash', 'partial', '2026-01-06 18:32:07'),
(5, 12, 5000, 'PhonePe', 'partial', '2026-01-06 18:35:22'),
(6, 10, 500, 'PhonePe', 'full', '2026-01-06 18:36:03'),
(7, 13, 230, 'PhonePe', 'partial', '2026-01-06 19:06:12'),
(8, 14, 1020, 'Cash', 'partial', '2026-01-07 06:44:18'),
(9, 16, 63600, 'PhonePe', 'partial', '2026-01-09 16:24:23'),
(10, 17, 1000, 'Cash', 'partial', '2026-02-07 08:20:22'),
(11, 17, 5000, 'PhonePe', 'full', '2026-02-07 08:21:40');

-- --------------------------------------------------------

--
-- Table structure for table `productlist`
--

CREATE TABLE `productlist` (
  `id` int(11) NOT NULL,
  `productname` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productlist`
--

INSERT INTO `productlist` (`id`, `productname`) VALUES
(1, 'ThumsUp-250'),
(2, 'Sprite-250'),
(5, 'Fanta-250'),
(6, 'English Jeera-250'),
(7, 'Oyster Mushroom'),
(8, 'Coca cola'),
(9, 'Sweet Orange'),
(10, 'Fanta 600ml'),
(11, 'Tejas');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category`, `stock_quantity`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'ThumsUp-250', 'Refreshing ThumsUp-250 cold drink', 20.00, NULL, 'Cola', 100, 1, '2026-01-05 18:05:40', '2026-01-05 18:05:40'),
(2, 'Sprite-250', 'Refreshing Sprite-250 cold drink', 20.00, NULL, 'Lemon', 100, 1, '2026-01-05 18:05:40', '2026-01-05 18:05:40'),
(3, 'Fanta-250', 'Refreshing Fanta-250 cold drink', 20.00, NULL, 'Orange', 100, 1, '2026-01-05 18:05:40', '2026-01-05 18:05:40'),
(4, 'English Jeera-250', 'Refreshing English Jeera-250 cold drink', 20.00, NULL, 'Jeera Soda', 100, 1, '2026-01-05 18:05:40', '2026-01-05 18:05:40');

-- --------------------------------------------------------

--
-- Table structure for table `salary_payments`
--

CREATE TABLE `salary_payments` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `payment_date` date NOT NULL,
  `payment_month` varchar(20) NOT NULL,
  `payment_method` varchar(50) DEFAULT 'Cash',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `salary_payments`
--

INSERT INTO `salary_payments` (`id`, `employee_id`, `amount`, `payment_date`, `payment_month`, `payment_method`, `notes`, `created_at`) VALUES
(1, 1, 10000, '2026-01-07', '2026-01', 'Cash', 'advance', '2026-01-06 19:52:43'),
(2, 1, 10000, '2026-02-07', '2026-01', 'Cash', 'dfsnkak', '2026-02-07 08:29:08');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `total_amount` double NOT NULL,
  `sale_date` datetime DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_name`, `mobile`, `total_amount`, `sale_date`, `created_at`) VALUES
(1, 'sajkdjal', 'KDJSAKJDLKAjl', 0, '2025-05-24 10:54:33', '2025-05-24 05:24:33');

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `ml` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `unit_price` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `product_name`, `ml`, `quantity`, `unit_price`) VALUES
(1, 1, 12, NULL, 0, 555, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sell`
--

CREATE TABLE `sell` (
  `id` int(11) NOT NULL,
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
  `sellDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sell`
--

INSERT INTO `sell` (`id`, `bill_id`, `productname`, `quantity`, `scheme`, `schemebottles`, `priceperbox`, `totalbillamount`, `countername`, `paymentmethod`, `bill_items`, `sellDate`) VALUES
(3, 6, 'Demo', 1, '-', NULL, 100, 100, 'Counter 1', 'Cash', '[[\"Demo\",\"1\",\"-\",\"-\",\"100.00\",\"100.00\",\"Edit\\n                 Delete\"]]', '2026-01-05 19:18:06'),
(5, 8, 'ThumsUp', 1, '-', NULL, 1000, 1000, 'Counter 1', 'Cash', '[[\"ThumsUp\",\"1\",\"-\",\"-\",\"1000.00\",\"1000.00\",\"Edit\\n                 Delete\"]]', '2026-01-06 18:01:10'),
(6, 9, 'Demo1', 1, '-', NULL, 400, 400, 'Counter 2', 'PhonePe', '[[\"Demo1\",\"1\",\"-\",\"-\",\"400.00\",\"400.00\",\"Edit\\n                 Delete\"]]', '2026-01-06 18:01:53'),
(7, 10, 'Demo4', 2, '-', NULL, 250, 500, 'counter 3', 'Unpaid', '[[\"Demo4\",\"2\",\"-\",\"-\",\"250.00\",\"500.00\",\"Edit\\n                 Delete\"]]', '2026-01-06 18:08:10'),
(8, 11, 'ThumsUp', 1, '-', NULL, 1000, 1000, 'Counter 2', 'Cash', '[[\"ThumsUp\",\"1\",\"-\",\"-\",\"1000.00\",\"1000.00\",\"Edit\\n                 Delete\"]]', '2026-01-06 18:32:07'),
(9, 12, 'dfa', 1, '-', NULL, 5000, 5000, 'Counter 2', 'PhonePe', '[[\"dfa\",\"1\",\"-\",\"-\",\"5000.00\",\"5000.00\",\"Edit\\n                 Delete\"]]', '2026-01-06 18:35:22'),
(10, 13, 'ThumsUp', 1, '5', 4, 230, 230, 'Counter 1', 'PhonePe', '[[\"ThumsUp\",\"1\",\"5\",\"4\",\"230.00\",\"230.00\",\"Edit\\n                 Delete\"]]', '2026-01-06 19:06:12'),
(11, 14, 'Demo5', 2, '-', NULL, 230, 460, 'test counter', 'Cash', '[[\"Demo5\",\"2\",\"-\",\"-\",\"230.00\",\"460.00\",\"Edit\\n                 Delete\"],[\"csvd\",\"1\",\"-\",\"-\",\"560.00\",\"560.00\",\"Edit\\n                 Delete\"]]', '2026-01-07 06:44:18'),
(12, 14, 'csvd', 1, '-', NULL, 560, 560, 'test counter', 'Cash', '[[\"Demo5\",\"2\",\"-\",\"-\",\"230.00\",\"460.00\",\"Edit\\n                 Delete\"],[\"csvd\",\"1\",\"-\",\"-\",\"560.00\",\"560.00\",\"Edit\\n                 Delete\"]]', '2026-01-07 06:44:18'),
(13, 15, 'Demo3', 1, '-', NULL, 230, 230, 'vjkjfdv', 'Unpaid', '[[\"Demo3\",\"1\",\"-\",\"-\",\"230.00\",\"230.00\",\"Edit\\n                 Delete\"]]', '2026-01-07 07:13:58'),
(14, 16, 'Fanta 600ml', 120, '-', NULL, 530, 63600, 'vjkjfdv', 'PhonePe', '[[\"Fanta 600ml\",\"120\",\"-\",\"-\",\"530.00\",\"63600.00\",\"Edit\\n                 Delete\"]]', '2026-01-09 16:24:23'),
(15, 17, 'Tejas', 50, '-', NULL, 120, 6000, 'Tahura Generals', 'Unpaid', '[[\"Tejas\",\"50\",\"-\",\"-\",\"120.00\",\"6000.00\",\"Edit\\n                 Delete\"]]', '2026-02-07 08:14:42');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `productname` varchar(200) NOT NULL,
  `ml` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `priceperbox` double NOT NULL,
  `totalbillamount` double NOT NULL,
  `paid_amount` double DEFAULT 0,
  `payment_status` enum('Paid','Unpaid','Partial') DEFAULT 'Unpaid',
  `payment_mode` varchar(100) DEFAULT NULL,
  `payment_date` timestamp NULL DEFAULT NULL,
  `agencyname` varchar(200) NOT NULL,
  `buydate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `expiry_date` date DEFAULT NULL,
  `batch_number` varchar(100) DEFAULT NULL,
  `low_stock_threshold` int(11) DEFAULT 5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `productname`, `ml`, `quantity`, `priceperbox`, `totalbillamount`, `paid_amount`, `payment_status`, `payment_mode`, `payment_date`, `agencyname`, `buydate`, `expiry_date`, `batch_number`, `low_stock_threshold`) VALUES
(1, 'ThumsUp', 250, 7, 520, 5200, 5200, 'Paid', ',Cash', '2026-01-06 18:05:13', 'Mamta Traders', '2026-01-06 19:06:12', NULL, NULL, 5),
(4, 'Demo2', 1, 1, 1, 1, 0, 'Unpaid', NULL, NULL, 'DemoAgency2', '2025-05-23 13:42:31', NULL, NULL, 5),
(7, 'Demo4', 1, 1, 2, 111, 111, 'Paid', ',PhonePe', '2026-01-06 18:33:50', '23', '2026-01-06 18:33:50', NULL, NULL, 5),
(8, 'csvd', 45, 344, 345, 53, 0, 'Unpaid', NULL, NULL, '53', '2026-01-07 06:44:18', NULL, NULL, 5),
(10, 'Demo4', 9, 8, 7, 6, 0, 'Unpaid', NULL, NULL, '5', '2025-05-23 15:05:03', NULL, NULL, 5),
(11, 'Demo5', 5, 5, 5, 5, 0, 'Unpaid', NULL, NULL, '5', '2025-05-23 15:07:07', NULL, NULL, 5),
(12, 'dskfajlk55qq55q', 9, -546, 9, 9, 0, 'Unpaid', NULL, NULL, '99', '2025-05-24 05:24:33', NULL, NULL, 5),
(13, 'dfa', 5, 4, 5, 5, 0, 'Unpaid', NULL, NULL, '5', '2026-01-06 18:35:22', NULL, NULL, 5),
(14, 'fd', 1, 1, 1, 1, 0, 'Unpaid', NULL, NULL, '1', '2025-05-23 15:17:05', NULL, NULL, 5),
(15, 'gf', 1, 4, 4, 4, 0, 'Unpaid', NULL, NULL, '4', '2025-05-23 15:19:13', NULL, NULL, 5),
(16, 'fgdsg', 1, 7, 45, 6, 0, 'Unpaid', NULL, NULL, '5', '2025-05-23 15:27:37', NULL, NULL, 5),
(17, 'HKJHKJH', 4, 4, 44, 4, 0, 'Unpaid', NULL, NULL, '4', '2025-05-23 15:30:06', NULL, NULL, 5),
(18, 'DW', 5, 5, 5, 5, 0, 'Unpaid', NULL, NULL, '5', '2025-05-23 15:41:11', NULL, NULL, 5),
(19, 'DW', 5, 5, 5, 5, 0, 'Unpaid', NULL, NULL, '5', '2025-05-23 15:41:19', NULL, NULL, 5),
(20, 'DF', 4444, 4, 4, 4, 0, 'Unpaid', NULL, NULL, '4', '2025-05-23 15:45:26', NULL, NULL, 5),
(21, '5', 5, 1, 55, 5, 0, 'Unpaid', NULL, NULL, '5', '2026-01-06 19:06:12', NULL, NULL, 5),
(22, 'kdk', 65456, 45, 4564, 6546546, 1000, 'Partial', ',Cash', '2026-01-06 18:34:33', '456', '2026-01-06 18:34:33', NULL, NULL, 5),
(23, 'dskfajlk55qq55q', 5, 5, 5, 5, 0, 'Unpaid', NULL, NULL, '5', '2025-05-23 15:50:18', NULL, NULL, 5),
(24, 'mlml', 5, 5, 5, 5, 0, 'Unpaid', NULL, NULL, '5', '2025-05-23 15:50:41', NULL, NULL, 5),
(25, 'Test Product', 24, 5, 150, 750, 0, 'Unpaid', NULL, NULL, 'Test Agency', '2026-01-05 18:37:45', NULL, NULL, 5),
(27, 'Tejas', 12, 400, 80, 36000, 12000, 'Partial', ',Cash', '2026-02-07 08:24:46', 'Sakshi Agency', '2026-02-07 08:24:46', '2027-12-12', 'djfsklsdl', 100);

-- --------------------------------------------------------

--
-- Table structure for table `totalstocksadded`
--

CREATE TABLE `totalstocksadded` (
  `id` int(11) NOT NULL,
  `productname` varchar(200) NOT NULL,
  `ml` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `priceperbox` double NOT NULL,
  `totalbillamount` double NOT NULL,
  `agencyname` varchar(200) NOT NULL,
  `buydate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `totalstocksadded`
--

INSERT INTO `totalstocksadded` (`id`, `productname`, `ml`, `quantity`, `priceperbox`, `totalbillamount`, `agencyname`, `buydate`) VALUES
(1, 'ThumsUp', 250, 10, 520, 5200, 'Mamta Traders', '2025-05-21 15:00:00'),
(2, 'sda', 4, 7, 8, 7, '8', '2025-05-23 13:56:08'),
(3, 'Demo5', 1, 2, 3, 4, '5', '2025-05-23 14:53:31'),
(4, 'Demo4', 9, 8, 7, 6, '5', '2025-05-23 15:05:03'),
(5, 'Demo5', 5, 5, 5, 5, '5', '2025-05-23 15:07:07'),
(6, 'dskfajlk55qq55q', 9, 9, 9, 9, '99', '2025-05-23 15:11:41'),
(7, 'dfa', 5, 5, 5, 5, '5', '2025-05-23 15:15:28'),
(8, 'fd', 1, 1, 1, 1, '1', '2025-05-23 15:17:05'),
(9, 'gf', 1, 4, 4, 4, '4', '2025-05-23 15:19:13'),
(10, 'fgdsg', 1, 7, 45, 6, '5', '2025-05-23 15:27:37'),
(11, 'HKJHKJH', 4, 4, 44, 4, '4', '2025-05-23 15:30:06'),
(12, 'DW', 5, 5, 5, 5, '5', '2025-05-23 15:41:11'),
(13, 'DW', 5, 5, 5, 5, '5', '2025-05-23 15:41:19'),
(14, 'DF', 4444, 4, 4, 4, '4', '2025-05-23 15:45:26'),
(15, '5', 5, 5, 55, 5, '5', '2025-05-23 15:46:35'),
(16, 'kdk', 65456, 45, 4564, 6546546, '456', '2025-05-23 15:49:53'),
(17, 'dskfajlk55qq55q', 5, 5, 5, 5, '5', '2025-05-23 15:50:18'),
(18, 'mlml', 5, 5, 5, 5, '5', '2025-05-23 15:50:41');

-- --------------------------------------------------------

--
-- Table structure for table `webauthn_credentials`
--

CREATE TABLE `webauthn_credentials` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `credential_id` text NOT NULL,
  `public_key` text NOT NULL,
  `sign_count` int(11) NOT NULL DEFAULT 0,
  `credential_name` varchar(255) NOT NULL DEFAULT 'My Fingerprint',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_used` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `webauthn_credentials`
--

INSERT INTO `webauthn_credentials` (`id`, `user_id`, `credential_id`, `public_key`, `sign_count`, `credential_name`, `created_at`, `last_used`) VALUES
(2, 2, 'ihvAbe6zCcp+8YzVpc/20g==', '-----BEGIN PUBLIC KEY-----\nMFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAE8tPHW7K+UNuMhi60gNJdZZE686Vr\nEuswMb+4eFqyuzOLYVk+d9cPpJ1BXUIwuuApWsiiTXAgL5dt0o2FXK8Zxw==\n-----END PUBLIC KEY-----\n', 0, 'My Device', '2026-02-18 11:21:44', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `agencylist`
--
ALTER TABLE `agencylist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `counterlist`
--
ALTER TABLE `counterlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bill_id` (`bill_id`);

--
-- Indexes for table `productlist`
--
ALTER TABLE `productlist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_payments`
--
ALTER TABLE `salary_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`sale_id`);

--
-- Indexes for table `sell`
--
ALTER TABLE `sell`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `totalstocksadded`
--
ALTER TABLE `totalstocksadded`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `webauthn_credentials`
--
ALTER TABLE `webauthn_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agencylist`
--
ALTER TABLE `agencylist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `counterlist`
--
ALTER TABLE `counterlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `productlist`
--
ALTER TABLE `productlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `salary_payments`
--
ALTER TABLE `salary_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sell`
--
ALTER TABLE `sell`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `totalstocksadded`
--
ALTER TABLE `totalstocksadded`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `webauthn_credentials`
--
ALTER TABLE `webauthn_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD CONSTRAINT `bill_items_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`bill_id`) REFERENCES `bills` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salary_payments`
--
ALTER TABLE `salary_payments`
  ADD CONSTRAINT `salary_payments_ibfk_1` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);

--
-- Constraints for table `webauthn_credentials`
--
ALTER TABLE `webauthn_credentials`
  ADD CONSTRAINT `fk_webauthn_user` FOREIGN KEY (`user_id`) REFERENCES `admin` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
