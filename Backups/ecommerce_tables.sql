-- Additional tables for E-commerce functionality
-- Run this after importing the main yashcoldrinks.sql

-- Products table for customer-facing e-commerce
CREATE TABLE IF NOT EXISTS `products` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Orders table for customer orders
CREATE TABLE IF NOT EXISTS `orders` (
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

-- Order items table
CREATE TABLE IF NOT EXISTS `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `order_items_order_fk` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_fk` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample products from productlist
INSERT INTO `products` (`name`, `description`, `price`, `category`, `stock_quantity`, `is_active`)
SELECT 
    `productname`,
    CONCAT('Refreshing ', `productname`, ' cold drink'),
    CASE 
        WHEN `productname` LIKE '%250%' THEN 20.00
        WHEN `productname` LIKE '%500%' THEN 35.00
        WHEN `productname` LIKE '%1L%' THEN 60.00
        WHEN `productname` LIKE '%2L%' THEN 95.00
        ELSE 25.00
    END,
    CASE 
        WHEN `productname` LIKE '%Sprite%' OR `productname` LIKE '%7Up%' THEN 'Lemon'
        WHEN `productname` LIKE '%ThumsUp%' OR `productname` LIKE '%Coca%' OR `productname` LIKE '%Pepsi%' THEN 'Cola'
        WHEN `productname` LIKE '%Fanta%' OR `productname` LIKE '%Mirinda%' THEN 'Orange'
        WHEN `productname` LIKE '%Jeera%' THEN 'Jeera Soda'
        ELSE 'Other'
    END,
    100,
    1
FROM `productlist`
WHERE NOT EXISTS (SELECT 1 FROM `products` WHERE `products`.`name` = `productlist`.`productname`);
