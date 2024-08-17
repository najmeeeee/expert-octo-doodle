-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2024 at 05:06 AM
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
(1, NULL, 'ttt', '2024-08-26', 'www', 9, 'Male', 1350),
(2, NULL, 'iii', '2024-08-31', 'lll', 6, 'Male', 900),
(3, NULL, 'iii', '2024-08-31', 'lll', 6, 'Male', 900),
(4, 17, 'mmm', '2024-08-26', 'wwww', 1, 'Male', 150),
(5, 17, 'mmm', '2024-08-26', 'wwww', 1, 'Male', 150),
(6, 17, 'mmm', '2024-08-26', 'wwww', 1, 'Male', 150),
(7, 17, 'mmm', '2024-08-26', 'wwww', 1, 'Male', 150),
(8, 17, 'bbb', '2024-08-19', 'aa', 3, 'Male', 450),
(9, 17, 'bbb', '2024-08-19', 'aa', 3, 'Male', 450),
(10, 17, 'kkkk', '2024-08-29', 'qqqq', 8, 'Male', 1200),
(11, 17, 'kkkk', '2024-08-29', 'qqqq', 8, 'Male', 1200),
(12, 17, 'kkkk', '2024-08-29', 'qqqq', 8, 'Male', 1200),
(13, 17, 'kkkk', '2024-08-29', 'qqqq', 8, 'Male', 1200),
(14, 17, 'kkkk', '2024-08-29', 'qqqq', 8, 'Male', 1200),
(15, 17, 'kkkk', '2024-08-29', 'qqqq', 8, 'Male', 1200);

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
