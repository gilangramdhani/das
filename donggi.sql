-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 15, 2025 at 10:42 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `donggi`
--

-- --------------------------------------------------------

--
-- Table structure for table `data`
--

CREATE TABLE `data` (
  `id` bigint(20) NOT NULL,
  `cerobong` varchar(255) NOT NULL,
  `parameter` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `waktu` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data`
--

INSERT INTO `data` (`id`, `cerobong`, `parameter`, `value`, `waktu`) VALUES
(1, '1', 'SO2', '26.53', '2025-03-12 11:57:00'),
(2, '1', 'NOx', '311.65', '2025-03-12 11:57:00'),
(3, '1', 'PM', '31.74', '2025-03-12 11:57:00'),
(4, '1', 'CO', '16.15', '2025-03-12 11:57:00'),
(5, '1', 'O2', '14.95', '2025-03-12 11:57:00'),
(6, '1', 'Flow', '171.39', '2025-03-12 11:57:00'),
(7, '1', 'SO2', '39.67', '2025-03-12 12:02:00'),
(8, '1', 'NOx', '319.79', '2025-03-12 12:02:00'),
(9, '1', 'PM', '34.51', '2025-03-12 12:02:00'),
(10, '1', 'CO', '49.63', '2025-03-12 12:02:00'),
(11, '1', 'O2', '18.19', '2025-03-12 12:02:00'),
(12, '1', 'Flow', '208.45', '2025-03-12 12:02:00');

-- --------------------------------------------------------

--
-- Table structure for table `notif`
--

CREATE TABLE `notif` (
  `notif_id` int(11) NOT NULL,
  `notif_date` datetime NOT NULL,
  `notif_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `parameter`
--

CREATE TABLE `parameter` (
  `parameter_id` int(11) NOT NULL,
  `parameter_code` varchar(255) NOT NULL,
  `parameter_name` varchar(255) NOT NULL,
  `parameter_threshold` varchar(255) NOT NULL,
  `parameter_unit` varchar(255) NOT NULL,
  `parameter_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parameter`
--

INSERT INTO `parameter` (`parameter_id`, `parameter_code`, `parameter_name`, `parameter_threshold`, `parameter_unit`, `parameter_status`) VALUES
(1, 'SO2', 'Sulfur Dioksida (SO2)', '150', 'mg/Nm<sup>3</sup>', ''),
(2, 'NOx', 'Nitrogen Oksida (NOx)', '320', 'mg/Nm<sup>3</sup>', ''),
(3, 'PM', 'Partikulat (PM)', '50', 'mg/Nm<sup>3</sup>', ''),
(4, 'CO', 'Karbon Monoksida (CO)', '50', 'mg/Nm<sup>3</sup>', ''),
(5, 'O2', 'oksigen', '25', '%', ''),
(6, 'Flow', 'laju_alir', '500', 'm<sup>3</sup>/s', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data`
--
ALTER TABLE `data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notif`
--
ALTER TABLE `notif`
  ADD PRIMARY KEY (`notif_id`);

--
-- Indexes for table `parameter`
--
ALTER TABLE `parameter`
  ADD PRIMARY KEY (`parameter_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data`
--
ALTER TABLE `data`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `notif`
--
ALTER TABLE `notif`
  MODIFY `notif_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parameter`
--
ALTER TABLE `parameter`
  MODIFY `parameter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
