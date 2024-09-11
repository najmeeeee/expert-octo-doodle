-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2024 at 07:26 AM
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
  `accountno` varchar(20) NOT NULL,
  `ifsc` varchar(11) NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `balance` decimal(10,0) NOT NULL,
  `expirydate` date NOT NULL,
  `account_holder_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`accountno`, `ifsc`, `cvv`, `balance`, `expirydate`, `account_holder_name`) VALUES
('1234567890', 'sbi0001', '123', 7600, '2030-04-12', 'abc');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `ussrid` int(11) DEFAULT NULL,
  `residents_name` varchar(100) DEFAULT NULL,
  `bookingdate` date DEFAULT NULL,
  `place` varchar(100) DEFAULT NULL,
  `no_of_stay` int(11) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `checkin_date` date DEFAULT NULL,
  `status` varchar(50) DEFAULT 'requested',
  `description` text DEFAULT 'waiting for the response'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `ussrid`, `residents_name`, `bookingdate`, `place`, `no_of_stay`, `gender`, `amount`, `checkin_date`, `status`, `description`) VALUES
(1, 18, 'we', '2024-09-09', 'we', 5, 'Male', 750, '2024-10-01', 'Pending', 'Pending Confirmation');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `cid` int(11) NOT NULL,
  `ussrid` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(10) DEFAULT NULL,
  `phno` varchar(55) DEFAULT NULL,
  `message` varchar(100) DEFAULT NULL,
  `reply` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`cid`, `ussrid`, `name`, `email`, `phno`, `message`, `reply`) VALUES
(1, 17, NULL, 'my@gmail.c', '9764563221', 'is it safe', 'yes it is'),
(2, 17, NULL, 'k@gmail.co', '9643335788', 'location', NULL),
(3, 0, NULL, 'hi@gmail.c', '9745677899', 'how is the vibe', 'peaceful'),
(4, 0, 'meera', 'd@gmail.co', '8987654567', 'how is the service', NULL),
(5, 0, 'meera', 'd@gmail.co', '8987654567', 'how is the service', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orgtransaction`
--

CREATE TABLE `orgtransaction` (
  `transaction_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `transaction_date` date DEFAULT NULL,
  `credited_amount` decimal(10,2) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orgtransaction`
--

INSERT INTO `orgtransaction` (`transaction_id`, `booking_id`, `transaction_date`, `credited_amount`, `name`) VALUES
(1, NULL, '2024-08-16', 1200.00, 'JohnDoe'),
(2, NULL, '2024-08-16', 1200.00, 'JohnDoe'),
(3, NULL, '2024-08-16', 1200.00, 'JohnDoe'),
(4, NULL, '2024-08-16', 1200.00, 'JohnDoe'),
(5, NULL, '2024-08-16', 1200.00, 'JohnDoe'),
(6, NULL, '2024-08-16', 1200.00, 'JohnDoe'),
(7, NULL, '2024-08-16', 1050.00, 'JohnDoe'),
(8, NULL, '2024-08-16', 1050.00, 'JohnDoe'),
(9, NULL, '2024-08-16', 750.00, 'abc'),
(10, NULL, '2024-08-16', 750.00, 'abc'),
(11, NULL, '2024-08-16', 450.00, 'abc'),
(12, NULL, '2024-08-16', 450.00, 'abc');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `review_id` int(11) NOT NULL,
  `ussrid` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`review_id`, `ussrid`, `rating`, `review_text`, `created_at`) VALUES
(5, 17, 2, 'dine', '2024-09-08 05:15:20');

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

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ussrid` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(256) DEFAULT NULL,
  `role` int(11) NOT NULL DEFAULT 2,
  `gender` varchar(50) NOT NULL,
  `place` varchar(50) NOT NULL,
  `Dob` date NOT NULL,
  `phno` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ussrid`, `fname`, `lname`, `email`, `pass`, `role`, `gender`, `place`, `Dob`, `phno`) VALUES
(2, 'sheethal', 's', 'sheet@gmail.com', '$2y$10$ukXSiIVKM90jFBW34qjQ.ef9PZnWHrjhTxxZJcR45fMVdOOQ61aYu', 2, 'female', 'kottayam', '0000-00-00', '9946840039'),
(13, 'arun', 'kumar', 'arun@gmail.com', '6f1b14f6b5bbeb876015dc376ff4c593f8495cc12abce2766d7bd10c33a20fd0', 1, 'Male', 'AdminPlace', '2024-07-03', '9230567890'),
(14, 'ovana', 'd', 'd@gmail.com', '8f50c0be66b619d0d0b694624a8a9715e95f3c286e9f856ca7cf65f9cc3f23d4', 2, 'female', 'punjab', '2004-06-08', '9988776645'),
(15, 'm', 'n', 'n@gmail.com', 'b6c1a5cd0ba02ecd66939b4a1b1a1c35991ed5fcc76959ef4bfabc03762a50e8', 2, 'female', 'punjab', '2006-04-08', '7788899657'),
(16, 'g', 'h', 'g@gmail.com', 'b8eef32a38faf1c08925edd15fcb39cba2c6dfe57a965c9b14d06418516501b0', 2, 'female', 'punjab', '2000-09-08', '6677877898'),
(17, 'kk', 'pp', 'kk3@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 2, 'female', 'ooo', '2024-08-06', '9087654321'),
(19, 'ttt', 'mmm', 'tm@gmail.com', '4e20613ec3a63732f98630b9429e1600d47a08f059496d39ffd353f0c3038f39', 2, 'other', 'goa', '2000-07-03', '9877654433'),
(20, 'h', 't', 't@gmail.com', 'e24df920078c3dd4e7e8d2442f00e5c9ab2a231bb3918d65cc50906e49ecaef4', 2, 'female', 'gggg', '1967-07-09', '9556778643'),
(22, 'sandra', 'john', 's@gmail.com', 'd34115b61acb7d6e14be460183068ef3b292fd734ce9408a84150a4b6d616294', 1, 'Female', 'adminp', '2024-09-03', '9471118232');

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
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `orgtransaction`
--
ALTER TABLE `orgtransaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `fk_user` (`ussrid`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ussrid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phno` (`phno`),
  ADD UNIQUE KEY `pass` (`pass`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orgtransaction`
--
ALTER TABLE `orgtransaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ussrid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`ussrid`) REFERENCES `user` (`ussrid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
