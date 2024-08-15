-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2024 at 12:53 PM
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
-- Database: `miniproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `paymentid` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `accountno` varchar(20) NOT NULL,
  `ifsc` varchar(11) NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `balance` decimal(10,0) NOT NULL,
  `expirydate` date NOT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`paymentid`, `booking_id`, `accountno`, `ifsc`, `cvv`, `balance`, `expirydate`, `account_holder_name`, `dob`) VALUES
(1001, 1, '123456789012', 'ABC12345678', '123', 10000, '2025-08-31', 'JohnDoe', NULL),
(1002, 2, '234567890123', 'DEF98765432', '456', 15000, '2026-07-30', 'AliceSmith', NULL),
(1003, 3, '345678901234', 'GHI87654321', '789', 20000, '2027-12-15', 'BobBrown', NULL),
(1004, 4, '456789012345', 'JKL23456789', '012', 25000, '2028-05-20', 'EmmaJones', NULL),
(1005, 5, '567890123456', 'MNO34567890', '345', 30000, '2029-11-10', 'LiamWilson', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`paymentid`),
  ADD KEY `booking_id` (`booking_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `paymentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1006;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bank`
--
ALTER TABLE `bank`
  ADD CONSTRAINT `bank_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
