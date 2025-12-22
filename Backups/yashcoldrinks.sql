-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 05:57 PM
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
(1, 'Yash', '202cb962ac59075b964b07152d234b70', '9405416771', 'admin');

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
(2, 'Akola Jeera');

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
(6, 'English Jeera-250');

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
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `productname` varchar(200) NOT NULL,
  `ml` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `priceperbox` double NOT NULL,
  `totalbillamount` double NOT NULL,
  `agencyname` varchar(200) NOT NULL,
  `buydate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`id`, `productname`, `ml`, `quantity`, `priceperbox`, `totalbillamount`, `agencyname`, `buydate`) VALUES
(1, 'ThumsUp', 250, 10, 520, 5200, 'Mamta Traders', '2025-05-21 15:00:00'),
(2, 'Demo', 1, 1, 1, 1, 'DemoAgency', '2025-05-23 13:20:02'),
(3, 'Demo1', 1, 1, 1, 1, 'DemoAgency', '2025-05-23 13:22:01'),
(4, 'Demo2', 1, 1, 1, 1, 'DemoAgency2', '2025-05-23 13:42:31'),
(5, 'Demo3', 1, 1, 1, 1, 'DemoAgency3', '2025-05-23 13:45:26'),
(6, 'Demo4', 1, 1, 1, 1, '1', '2025-05-23 13:46:54'),
(7, 'Demo4', 1, 2, 2, 111, '23', '2025-05-23 13:53:13'),
(8, 'csvd', 45, 345, 345, 53, '53', '2025-05-23 13:54:32'),
(9, 'Demo5', 1, 2, 3, 4, '5', '2025-05-23 14:53:31'),
(10, 'Demo4', 9, 8, 7, 6, '5', '2025-05-23 15:05:03'),
(11, 'Demo5', 5, 5, 5, 5, '5', '2025-05-23 15:07:07'),
(12, 'dskfajlk55qq55q', 9, -546, 9, 9, '99', '2025-05-24 05:24:33'),
(13, 'dfa', 5, 5, 5, 5, '5', '2025-05-23 15:15:28'),
(14, 'fd', 1, 1, 1, 1, '1', '2025-05-23 15:17:05'),
(15, 'gf', 1, 4, 4, 4, '4', '2025-05-23 15:19:13'),
(16, 'fgdsg', 1, 7, 45, 6, '5', '2025-05-23 15:27:37'),
(17, 'HKJHKJH', 4, 4, 44, 4, '4', '2025-05-23 15:30:06'),
(18, 'DW', 5, 5, 5, 5, '5', '2025-05-23 15:41:11'),
(19, 'DW', 5, 5, 5, 5, '5', '2025-05-23 15:41:19'),
(20, 'DF', 4444, 4, 4, 4, '4', '2025-05-23 15:45:26'),
(21, '5', 5, 5, 55, 5, '5', '2025-05-23 15:46:35'),
(22, 'kdk', 65456, 45, 4564, 6546546, '456', '2025-05-23 15:49:53'),
(23, 'dskfajlk55qq55q', 5, 5, 5, 5, '5', '2025-05-23 15:50:18'),
(24, 'mlml', 5, 5, 5, 5, '5', '2025-05-23 15:50:41');

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

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `agencylist`
--
ALTER TABLE `agencylist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productlist`
--
ALTER TABLE `productlist`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `agencylist`
--
ALTER TABLE `agencylist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `productlist`
--
ALTER TABLE `productlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `totalstocksadded`
--
ALTER TABLE `totalstocksadded`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `sale_items_ibfk_1` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
