-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2024 at 03:01 PM
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
-- Database: `nice`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `attRN` int(11) NOT NULL,
  `empID` int(11) DEFAULT NULL,
  `attDate` date DEFAULT NULL,
  `attTimeIn` datetime DEFAULT NULL,
  `attTimeOut` datetime DEFAULT NULL,
  `attStats` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`attRN`, `empID`, `attDate`, `attTimeIn`, `attTimeOut`, `attStats`) VALUES
(22, 4, '2024-10-22', '2024-10-22 12:20:00', '2024-10-22 12:20:00', 'Cancelled'),
(23, 4, '2024-10-22', '2024-10-22 00:25:00', '2024-10-22 00:21:00', 'Cancelled'),
(24, 10, '2024-10-24', '2024-10-24 07:47:00', '2024-10-24 19:47:00', 'Cancelled'),
(25, 4, '2024-10-26', '2024-10-26 00:54:00', '2024-10-26 01:53:00', NULL),
(26, 5, '2024-10-26', '2024-10-26 00:55:00', '2024-10-26 00:53:00', NULL),
(27, 5, '2024-10-26', '2024-10-26 00:56:00', '2024-10-26 00:56:00', 'Present');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `depCode` int(11) NOT NULL,
  `depName` varchar(250) NOT NULL,
  `depHead` varchar(250) NOT NULL,
  `depTelNo` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`depCode`, `depName`, `depHead`, `depTelNo`) VALUES
(135, 'Bsit/121213232', 'Solon443333', '323232sasa'),
(188, '12', '2r', 'dgfdg'),
(194, 'gfdg', 'fdgfdg', 'fdgfd'),
(198, 'diovic', 'solon', '12'),
(199, 'marc', 'aljon', '12121');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `empID` int(11) NOT NULL,
  `depCode` int(11) DEFAULT NULL,
  `empFName` varchar(50) DEFAULT NULL,
  `empLName` varchar(50) DEFAULT NULL,
  `empRPH` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`empID`, `depCode`, `empFName`, `empLName`, `empRPH`) VALUES
(4, 135, 'kyla', 'dorio', 12.00),
(5, 135, 'kyla', 'doriosasa', 1.00),
(8, 188, 'diovic', 'solon', 1212.00),
(9, 199, 'Marc', 'rean', 121.00),
(10, 199, 'diovicsasasa', 'ssolon', 21222.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`attRN`),
  ADD KEY `empID` (`empID`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`depCode`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`empID`),
  ADD KEY `depCode` (`depCode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `attRN` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `depCode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `empID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`empID`) REFERENCES `employees` (`empID`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`depCode`) REFERENCES `departments` (`depCode`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
