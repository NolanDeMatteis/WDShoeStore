-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 12, 2026 at 06:25 PM
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
-- Database: `shoestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `firstName` varchar(40) NOT NULL,
  `lastName` varchar(40) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `address` varchar(100) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` char(2) NOT NULL,
  `zip` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `firstName`, `lastName`, `email`, `phone_number`, `address`, `city`, `state`, `zip`) VALUES
(1, 'John', 'Doe', 'j.doe@example.com', '770-555-0143', '101 Sugarloaf Parkway', 'Lawrenceville', 'GA', '30043'),
(2, 'Jane', 'Smith', 'jane.smith@example.com', '678-555-0199', '450 Collins Hill Road', 'Lawrenceville', 'GA', '30043'),
(3, 'Michael', 'Green', 'mgreen92@example.com', '404-555-0122', '825 Duluth Highway', 'Lawrenceville', 'GA', '30043'),
(4, 'Emily', 'Taylor', 'emily.t@example.com', '770-555-0155', '312 Pike Boulevard', 'Lawrenceville', 'GA', '30043'),
(5, 'David', 'Miller', 'dmiller@example.com', '678-555-0177', '1200 Riverside Parkway', 'Lawrenceville', 'GA', '30043');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shoe_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `shoe_id`, `quantity`, `order_date`) VALUES
(3, 1, 1, 2, '2026-07-12 12:09:59');

-- --------------------------------------------------------

--
-- Table structure for table `shoe`
--

CREATE TABLE `shoe` (
  `shoe_id` int(11) NOT NULL,
  `brand` varchar(40) NOT NULL,
  `model_name` varchar(50) NOT NULL,
  `shoe_size` decimal(3,1) NOT NULL,
  `color` varchar(30) NOT NULL,
  `price` decimal(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shoe`
--

INSERT INTO `shoe` (`shoe_id`, `brand`, `model_name`, `shoe_size`, `color`, `price`) VALUES
(1, 'Nike', 'Air Force 1 Low', 10.0, 'White', 115.01),
(2, 'Adidas', 'Ultraboost Light', 9.5, 'Black', 190.00),
(3, 'Jordan', 'Air Jordan 1 Retro High', 11.0, 'Red/Black', 180.00),
(4, 'New Balance', '990v6', 10.5, 'Grey', 199.99),
(5, 'Brooks', 'Ghost 16', 9.0, 'Blue', 140.00),
(6, 'Asics', 'GEL-Kayano 30', 10.0, 'Black/White', 160.00),
(7, 'Puma', 'Suede Classic', 8.5, 'Navy', 75.00),
(8, 'Vans', 'Old Skool', 12.0, 'Black/White', 70.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `shoe_id` (`shoe_id`);

--
-- Indexes for table `shoe`
--
ALTER TABLE `shoe`
  ADD PRIMARY KEY (`shoe_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `shoe`
--
ALTER TABLE `shoe`
  MODIFY `shoe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shoe_id`) REFERENCES `shoe` (`shoe_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
