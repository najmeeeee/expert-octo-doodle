-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 08:09 PM
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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ussrid` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `role` int(11) NOT NULL DEFAULT 2 CHECK (`role` in (1,2)),
  `gender` varchar(50) NOT NULL,
  `place` varchar(50) NOT NULL,
  `Dob` date NOT NULL,
  `phno` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ussrid`, `fname`, `lname`, `email`, `pass`, `role`, `gender`, `place`, `Dob`, `phno`) VALUES
(1, 'najmiya', 'muhammed', 'najmiya@gmail.com', 'e519605dba831341fb40c93d089df35067e6eec7e948711113ded34b6ed5af6c', 1, 'female', 'Calicut', '2024-07-02', '526327537'),
(2, 'sheethal', 's', 'sheet@gmail.com', '$2y$10$ukXSiIVKM90jFBW34qjQ.ef9PZnWHrjhTxxZJcR45fMVdOOQ61aYu', 2, 'female', 'kottayam', '0000-00-00', '9946840039'),
(3, 'jesna ', 'jose', 'jesna@gmail.com', '$2y$10$bRoOz5O8MQTyEZDoKDWV7Oy.7puGdmzhd0.Gu7VkrxRvKCv1HHKoG', 2, 'female', 'kottayam', '0222-02-12', '9526327537');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ussrid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `pass` (`pass`),
  ADD UNIQUE KEY `phno` (`phno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ussrid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
