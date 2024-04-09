-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 01, 2023 at 11:53 AM
-- Server version: 5.7.33
-- PHP Version: 8.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bicycle_rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`, `email`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(2, 'admin2', '$2y$10$6vm05f2b9dnF6QddReLuLOCmBNyXOh1uwLB2CBedOIHNRpGnNaQpe', 'AdminTwo', 'admin2@admin.com', '2023-06-16 12:52:58', '2023-06-16 12:52:58', '2023-06-16 12:52:58');

-- --------------------------------------------------------

--
-- Table structure for table `bicycle`
--

CREATE TABLE `bicycle` (
  `id` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `price` decimal(5,2) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by_admin` int(11) DEFAULT NULL,
  `created_by_employee` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL,
  `updated_by_employee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bicycle`
--

INSERT INTO `bicycle` (`id`, `type`, `price`, `status`, `created_at`, `updated_at`, `created_by_admin`, `created_by_employee`, `updated_by_admin`, `updated_by_employee`) VALUES
(14, 'with basket', '550.00', 0, '2023-06-22 16:01:02', '2023-06-22 20:11:31', 2, NULL, NULL, NULL),
(15, 'with seat', '200.00', 0, '2023-06-22 16:01:14', '2023-06-22 20:11:59', 2, NULL, NULL, NULL),
(16, 'none', '100.00', 0, '2023-06-22 16:01:22', '2023-06-22 20:11:42', 2, NULL, NULL, NULL),
(17, 'with basket and seat', '200.00', 0, '2023-06-22 16:01:31', '2023-06-22 20:11:47', 2, NULL, NULL, NULL),
(18, 'with basket', '200.00', 0, '2023-06-22 16:01:42', '2023-06-22 20:11:38', 2, NULL, NULL, NULL),
(19, 'with seat', '200.00', 0, '2023-06-22 16:01:49', '2023-06-22 20:13:15', 2, NULL, NULL, NULL),
(20, 'with basket and seat', '300.00', 0, '2023-06-22 16:02:00', '2023-06-22 20:12:05', 2, NULL, NULL, NULL),
(21, 'with basket and seat', '200.00', 0, '2023-06-22 16:02:09', '2023-06-22 20:11:24', 2, NULL, NULL, NULL),
(22, 'with basket', '500.00', 1, '2023-06-30 17:57:17', '2023-06-30 18:27:48', 2, NULL, NULL, NULL),
(23, 'with seat', '300.00', 1, '2023-06-30 17:57:25', '2023-06-30 17:57:25', 2, NULL, NULL, NULL),
(24, 'with basket and seat', '600.00', 1, '2023-06-30 17:57:34', '2023-06-30 17:57:34', 2, NULL, NULL, NULL),
(25, 'none', '100.00', 1, '2023-06-30 17:57:45', '2023-06-30 19:48:50', 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(30) NOT NULL,
  `phoneNo` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `remark` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `username`, `password`, `name`, `phoneNo`, `email`, `remark`, `created_at`, `updated_at`, `created_by_admin`) VALUES
(5, 'saf', '$2y$10$bz7bEwNyuBUaz7F4VPz39.DMNrWojj.7sQ2zH778YFjWGr2lGjzXC', 'affs', '01236565', 'adf@fsf.sf', '', '2023-06-16 13:42:56', '2023-06-16 13:42:56', NULL),
(6, 'Ali', '$2y$10$Ow68xbcO28NXDios26poj.WSq6W74aEt2.jTHidfkfMgwkBYFWV06', 'ali', '01223232', 'af2@df.fs', '', '2023-06-17 15:04:59', '2023-06-22 18:26:59', NULL),
(10, 'fa', '$2y$10$pgit/twA/D5Vj6dqwBWmXOM//kShFMMFPdYEnKKHqybmNCo8RLeAO', 'affsf', '01256445665', 'sfas@fs.vdsf', 'student', '2023-06-30 19:11:20', '2023-06-30 19:11:51', 2),
(12, 'rwrq', '$2y$10$f38YcfRPsVKC.uRQzvDCG.g0c993bMRSsZD0FPKEpne7XrK8Z5Tuu', 'saf', '012346565', 'sfa@fs.cvfsf', 'student', '2023-06-30 19:43:38', '2023-06-30 19:44:08', 2),
(13, 'rewfwf', '$2y$10$1FrenkisiHL59u2/OpxvQunPQM1dqRoEuwTMRoo4/1nkM6u16P8cm', 'ffsfsfsf', '012323033', 'ff@fsf.fsfcxdcfgvb', 'safaf', '2023-06-30 19:49:49', '2023-06-30 19:50:13', 2);

-- --------------------------------------------------------

--
-- Table structure for table `rental_info`
--

CREATE TABLE `rental_info` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `matric_no` varchar(8) NOT NULL,
  `phoneNo` varchar(11) NOT NULL,
  `damage` varchar(255) DEFAULT NULL,
  `fine` varchar(255) DEFAULT NULL,
  `rental_start_day` timestamp NOT NULL,
  `rental_end_day` timestamp NOT NULL,
  `rental_fee` decimal(5,2) NOT NULL,
  `bicycle_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_by_admin` int(11) DEFAULT NULL,
  `created_by_employee` int(11) DEFAULT NULL,
  `updated_by_admin` int(11) DEFAULT NULL,
  `updated_by_employee` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rental_info`
--

INSERT INTO `rental_info` (`id`, `name`, `matric_no`, `phoneNo`, `damage`, `fine`, `rental_start_day`, `rental_end_day`, `rental_fee`, `bicycle_id`, `created_at`, `updated_at`, `created_by_admin`, `created_by_employee`, `updated_by_admin`, `updated_by_employee`) VALUES
(21, 'Ali', 'AA123', '01213233', '0', '0', '2023-06-17 00:02:00', '2023-06-30 00:02:00', '20.00', 14, '2023-06-22 16:02:54', '2023-06-22 20:11:31', 2, NULL, NULL, 6),
(22, 'Abu', 'AA125', '0121223232', '0', '0', '2023-06-23 00:04:00', '2023-06-28 00:04:00', '360.00', 18, '2023-06-22 16:04:26', '2023-06-22 20:11:38', NULL, 5, NULL, 6),
(23, 'POi', 'AI21210', '01212232', '0', '0', '2023-05-22 16:21:00', '2023-05-27 16:21:00', '360.00', 16, '2023-06-22 16:21:22', '2023-06-22 20:11:42', NULL, 5, NULL, 6),
(24, 'Loi', 'Sd32323', '2022232323', '0', '0', '2022-11-23 05:21:00', '2022-11-23 06:21:00', '3.00', 17, '2023-06-22 16:22:01', '2023-06-22 20:11:47', NULL, 5, NULL, 6),
(25, 'AEW', 'AAS223', '012232232', '0', '0', '2023-06-22 18:04:00', '2023-06-23 02:04:00', '24.00', 15, '2023-06-22 18:04:25', '2023-06-22 20:11:53', NULL, 5, NULL, 6),
(26, 'ADV', 'AD56565', '0121323232', '0', '0', '2023-06-22 18:27:00', '2023-06-29 18:27:00', '10.00', 20, '2023-06-22 18:27:28', '2023-06-22 20:12:05', NULL, 6, NULL, 6),
(27, 'Lio', 'Aa4565', '01223232', '0', '0', '2023-06-22 18:57:00', '2023-06-23 18:57:00', '72.00', 21, '2023-06-22 18:57:58', '2023-06-22 20:11:24', NULL, 6, NULL, 6),
(32, 'da', 'D56', '010122323', '0', '2', '2023-06-22 20:13:00', '2023-06-23 20:13:00', '74.00', 19, '2023-06-22 20:13:15', '2023-06-22 20:13:15', NULL, 6, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bicycle`
--
ALTER TABLE `bicycle`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bicycle_ibfk_1` (`created_by_admin`),
  ADD KEY `bicycle_ibfk_2` (`created_by_employee`),
  ADD KEY `bicycle_ibfk_3` (`updated_by_admin`),
  ADD KEY `bicycle_ibfk_4` (`updated_by_employee`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_ibfk_1` (`created_by_admin`);

--
-- Indexes for table `rental_info`
--
ALTER TABLE `rental_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_info_ibfk_1` (`bicycle_id`),
  ADD KEY `rental_info_ibfk_2` (`created_by_admin`),
  ADD KEY `rental_info_ibfk_3` (`created_by_employee`),
  ADD KEY `rental_info_ibfk_4` (`updated_by_admin`),
  ADD KEY `rental_info_ibfk_5` (`updated_by_employee`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bicycle`
--
ALTER TABLE `bicycle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rental_info`
--
ALTER TABLE `rental_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bicycle`
--
ALTER TABLE `bicycle`
  ADD CONSTRAINT `bicycle_ibfk_1` FOREIGN KEY (`created_by_admin`) REFERENCES `admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `bicycle_ibfk_2` FOREIGN KEY (`created_by_employee`) REFERENCES `employee` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `bicycle_ibfk_3` FOREIGN KEY (`updated_by_admin`) REFERENCES `admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `bicycle_ibfk_4` FOREIGN KEY (`updated_by_employee`) REFERENCES `employee` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`created_by_admin`) REFERENCES `admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `rental_info`
--
ALTER TABLE `rental_info`
  ADD CONSTRAINT `rental_info_ibfk_1` FOREIGN KEY (`bicycle_id`) REFERENCES `bicycle` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rental_info_ibfk_2` FOREIGN KEY (`created_by_admin`) REFERENCES `admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rental_info_ibfk_3` FOREIGN KEY (`created_by_employee`) REFERENCES `employee` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rental_info_ibfk_4` FOREIGN KEY (`updated_by_admin`) REFERENCES `admin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `rental_info_ibfk_5` FOREIGN KEY (`updated_by_employee`) REFERENCES `employee` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
