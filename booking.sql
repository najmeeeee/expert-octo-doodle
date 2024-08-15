-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2024 at 12:55 PM
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
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `ussrid` int(11) DEFAULT NULL,
  `residents_name` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `place` varchar(100) DEFAULT NULL,
  `no_of_stay` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `ussrid`, `residents_name`, `dob`, `place`, `no_of_stay`, `gender`, `amount`) VALUES
(1, NULL, 'nj', '2000-12-22', 'Anakkampoyil', 3, 'Male', NULL),
(2, NULL, 'nj', '2000-12-22', 'Anakkampoyil', 3, 'Male', NULL),
(3, NULL, 'i', '1000-08-07', 'cakicut', 9, NULL, NULL),
(4, NULL, 'i', '1000-08-07', 'cakicut', 9, '', NULL),
(5, NULL, 'arum', '1000-02-23', 'cakicut', 2, 'Other', NULL),
(35, NULL, 'jesna', '1666-02-22', 'kottayam', 12, 'Male', 1800),
(36, NULL, 'jesna', '1777-02-22', 'kottayam', 12, 'Male', 1200),
(37, NULL, 'jesna', '1777-02-22', 'kottayam', 12, 'Male', 1800),
(38, NULL, 'jesna', '2004-09-22', 'kottayam', 12, 'Male', 1800),
(39, NULL, 'jesna', '2005-02-22', 'kottayam', 12, 'Male', 1800),
(40, NULL, 'jesna', '2004-02-22', 'kottayam', 12, 'Male', 1800),
(41, NULL, 'jesna', '2003-03-22', 'kottayam', 12, 'Male', 1800),
(42, NULL, 'jesna', '2003-03-22', 'kottayam', 12, 'Male', 1800),
(43, NULL, 'riya', '1999-02-22', 'kumli', 20, 'Other', 2000),
(44, NULL, 'riya', '2000-12-22', 'kumli', 20, 'Other', 3000),
(45, NULL, 'JohnDoe', '2000-02-22', 'kumli', NULL, 'Other', 3000),
(46, NULL, 'riya', '1666-02-22', 'kumli', 20, 'Other', 3000),
(47, NULL, 'JohnDoe', '2000-02-22', 'kumli', NULL, 'Other', 3000),
(48, NULL, 'jesna', '1666-02-22', 'kottayam', 12, 'Male', 1800),
(49, NULL, 'jesna', '1666-02-22', 'kottayam', 12, 'Male', 1800),
(50, NULL, 'jesna', '1777-02-22', 'kottayam', 12, 'Male', 1200),
(51, NULL, 'riya', '1888-02-22', 'hh', 2, 'Male', 300),
(52, NULL, 'riya', '1888-02-22', 'hh', 2, 'Male', 300),
(53, NULL, 'riya', '2000-02-22', 'hh', 2, 'Male', 300),
(54, NULL, 'JohnDoe', '2000-02-22', 'hh', NULL, 'Male', 300),
(55, NULL, 'riya', '2000-02-22', 'hh', 2, 'Male', 300),
(56, NULL, 'riya', '1999-02-22', 'hh', 2, 'Male', 300),
(57, NULL, 'riya', '2000-02-22', 'hh', 2, 'Male', 300),
(58, NULL, 'JohnDoe', '1222-02-22', 'hh', NULL, 'Male', 300),
(59, NULL, 'riya', '1222-11-22', 'hh', 2, 'Male', 300),
(60, NULL, 'riya', '1777-12-22', 'hh', 2, 'Male', 300),
(61, NULL, 'riya', '2000-10-22', 'hh', 2, 'Male', 300);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `ussrid` (`ussrid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`ussrid`) REFERENCES `user` (`ussrid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
