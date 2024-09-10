-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 10, 2024 at 05:08 AM
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
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `check_in_date` date NOT NULL,
  `check_out_date` date NOT NULL,
  `room_name` varchar(250) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `check_in_date`, `check_out_date`, `room_name`, `available`) VALUES
(5, '2222-03-22', '3333-03-31', 'Platinum', 1),
(6, '2222-03-22', '3333-03-31', 'Platinum', 1),
(7, '7654-05-22', '5555-04-04', 'Gold', 1),
(8, '4555-04-03', '4557-03-22', 'Platinum', 1),
(9, '2024-10-02', '2024-12-03', 'Platinum', 1),
(10, '2024-09-24', '2024-09-29', 'Platinum', 1),
(11, '2024-09-19', '2024-09-23', 'Platinum', 1),
(12, '2024-10-01', '2024-10-02', 'Gold', 1),
(13, '2024-10-01', '2024-10-02', 'Gold', 1),
(14, '2024-10-01', '2024-10-02', 'Platinum', 1),
(15, '2024-10-01', '2024-10-21', 'Platinum', 1),
(16, '2024-10-01', '2024-10-02', 'Platinum', 1),
(17, '2024-10-01', '2024-10-02', 'Platinum', 1),
(18, '2024-10-01', '2024-10-02', 'Gold', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
