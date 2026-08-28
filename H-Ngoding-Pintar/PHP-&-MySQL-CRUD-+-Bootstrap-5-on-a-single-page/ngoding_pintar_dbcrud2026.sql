-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2026 at 06:00 AM
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
-- Database: `ngoding_pintar_dbcrud2026`
--

-- --------------------------------------------------------

--
-- Table structure for table `tgoods`
--

CREATE TABLE `tgoods` (
  `id_goods` int(11) NOT NULL,
  `code` varchar(15) NOT NULL,
  `name` varchar(100) NOT NULL,
  `origin` varchar(25) NOT NULL,
  `amount` int(4) NOT NULL,
  `unit` varchar(15) NOT NULL,
  `date_received` date NOT NULL,
  `date_saved` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tgoods`
--

INSERT INTO `tgoods` (`id_goods`, `code`, `name`, `origin`, `amount`, `unit`, `date_received`, `date_saved`) VALUES
(1, 'INV-2022-001', 'office desk', 'Purchasing', 1, 'Units', '2022-06-01', '2022-06-10 13:59:19'),
(2, 'INV-2022-002', 'office Chair', 'Grant', 5, 'Units', '2022-06-02', '2022-06-10 13:59:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tgoods`
--
ALTER TABLE `tgoods`
  ADD PRIMARY KEY (`id_goods`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tgoods`
--
ALTER TABLE `tgoods`
  MODIFY `id_goods` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
