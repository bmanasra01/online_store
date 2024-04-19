-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 02, 2024 at 07:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `c_name` varchar(32) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_number` int(10) NOT NULL,
  `address` varchar(255) NOT NULL,
  `Date_of_Birth` date NOT NULL,
  `phone` int(32) NOT NULL,
  `card_id` int(16) NOT NULL,
  `card_expirationdate` date NOT NULL,
  `card_name` varchar(32) NOT NULL,
  `bank_name` varchar(32) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `customer_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`c_name`, `email`, `id_number`, `address`, `Date_of_Birth`, `phone`, `card_id`, `card_expirationdate`, `card_name`, `bank_name`, `username`, `password`, `customer_id`) VALUES
('bader manasra', 'badermanasra@gmail.com', 123456789, 'ramallah', '2024-02-22', 598111111, 2147483647, '0000-00-00', 'visa', 'arabic bank', 'bader_manasra', '123456789', 2);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`email`, `password`) VALUES
('bader@gmail.com', '1234');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(32) NOT NULL,
  `customer_id` int(32) NOT NULL,
  `date` date NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `date`, `is_confirmed`) VALUES
(1, 2, '2024-02-02', 0),
(2, 2, '2024-02-02', 0),
(3, 2, '2024-02-02', 0),
(4, 2, '2024-02-02', 0),
(5, 2, '2024-02-02', 0),
(6, 2, '2024-02-02', 0),
(7, 2, '2024-02-02', 0),
(8, 2, '2024-02-02', 0),
(9, 2, '2024-02-02', 0),
(10, 2, '2024-02-02', 0),
(11, 2, '2024-02-02', 0),
(12, 2, '2024-02-02', 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `p_id` int(32) NOT NULL,
  `quantity` int(32) NOT NULL,
  `order_id` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`p_id`, `quantity`, `order_id`) VALUES
(1, 6, 2),
(1, 6, 3),
(2, 1, 4),
(5, 1, 5),
(4, 1, 6),
(1, 1, 7),
(2, 1, 8),
(1, 1, 9),
(2, 1, 10),
(5, 1, 11),
(1, 1, 12);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(10) NOT NULL,
  `p_name` varchar(32) NOT NULL,
  `p_description` varchar(255) NOT NULL,
  `p_category` varchar(30) NOT NULL DEFAULT 'Normal',
  `p_price` int(30) NOT NULL,
  `p_quantity` int(32) NOT NULL,
  `p_remarks` varchar(32) NOT NULL,
  `p_photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `p_name`, `p_description`, `p_category`, `p_price`, `p_quantity`, `p_remarks`, `p_photo`) VALUES
(1, 'tammer', 'rrrrrrrrrrrr', 'normal', 20, 19, 'good', 'uploads/pic1.jpg'),
(2, 'kofiya', 'eeeee', 'on sale', 30, 14, 'yes yes', 'uploads/pic5.jpg'),
(3, 'gazaz', 'nice', 'featured', 50, 25, 'good', 'uploads/pic6.jpeg'),
(4, 'glass', 'nice', 'on sale', 25, 19, 'good', 'uploads/pic6.jpeg'),
(5, 'ibriq', 'nice', 'featured', 35, 20, 'good', 'uploads/pic8.jpg'),
(6, 'صحن مخزرف', 'جميل جدا', 'featured', 45, 59, 'يبدو انه تحفة فنية', 'uploads/pic6.jpeg'),
(7, 'ابريق زجاج', 'جميل جدا ', 'on sale', 25, 28, 'رائع لاحظ', 'uploads/pic7.jpeg'),
(8, 'سخام', 'سيء جدا', 'on sale', 1, 60, 'مش ولا بد', 'uploads/pic3.jpeg'),
(9, 'ffff', 'rsrsrs', 'high demand', 23, 19, 'uyukfytfyf', 'uploads/pic9.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `card_id` (`card_id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`p_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`p_id`) REFERENCES `product` (`p_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
