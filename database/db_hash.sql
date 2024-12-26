-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2024 at 11:10 AM
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
-- Database: `db_hash`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `user_id`, `product_id`, `product_name`, `qty`, `price`, `status`, `created`) VALUES
(22, 12, 24, 'MARTILYO', 1, 250, 'success', '2024-12-18 16:49:51'),
(23, 12, 26, 'GULOK', 2, 245, 'success', '2024-12-18 16:50:02'),
(24, 12, 24, 'MARTILYO', 2, 250, 'success', '2024-12-19 16:54:48'),
(25, 12, 27, 'TANSI', 3, 80, 'success', '2024-12-19 16:55:00'),
(26, 12, 24, 'MARTILYO', 1, 250, 'success', '2024-12-19 17:23:40'),
(27, 12, 24, 'MARTILYO', 1, 250, 'success', '2024-12-19 17:56:25'),
(28, 12, 30, 'SCREW', 1, 120, 'success', '2024-12-19 18:01:16');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `last_email_sent` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `qty`, `price`, `created`, `last_email_sent`) VALUES
(24, 'MARTILYO', 13, 250, '2024-12-12 22:36:02', '2024-12-13 01:27:58'),
(25, 'PALAKOL', 5, 100, '2024-12-12 22:36:55', '2024-12-12 14:51:59'),
(26, 'GULOK', 5, 185, '2024-12-12 22:37:11', '2024-12-18 08:50:47'),
(27, 'TANSI', 12, 80, '2024-12-13 08:33:53', NULL),
(28, 'DRILLS', 5, 260, '2024-12-13 08:45:30', '2024-12-13 01:52:01'),
(29, 'PILLER', 9, 150, '2024-12-13 08:47:48', NULL),
(30, 'SCREW', 9, 120, '2024-12-13 08:48:12', NULL),
(31, 'TAPE 2X', 9, 5, '2024-12-13 08:48:39', NULL),
(33, 'TURNILYO', 5, 150, '2024-12-13 09:04:54', NULL),
(35, 'WRENCH', 18, 450, '2024-12-13 11:40:09', NULL),
(36, 'MARKER', 10, 150, '2024-12-13 11:57:44', '2024-12-18 06:47:03'),
(37, 'GUNTING', 10, 185, '2024-12-18 16:42:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sales` int(11) NOT NULL,
  `discounted_sales` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `user_id`, `sales`, `discounted_sales`, `created`, `amount`) VALUES
(19, 12, 250, 250, '2024-12-18 16:49:56', 250.00),
(20, 12, 490, 490, '2024-12-18 16:50:08', 490.00),
(21, 12, 500, 500, '2024-12-19 16:54:53', 500.00),
(22, 12, 240, 240, '2024-12-19 16:55:05', 240.00),
(23, 12, 250, 250, '2024-12-19 17:23:45', 250.00),
(24, 12, 250, 240, '2024-12-19 17:56:36', 240.00),
(25, 12, 120, 120, '2024-12-19 18:01:20', 120.00);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created`) VALUES
(12, 'jecmerchandiseadmin', '$2y$10$P3dCF0Kc00.ww3J5De466eGSK20Z78ozMSxuVrCNWeKxFZb1IOFTu', '2024-12-12 22:35:05');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `sign_in` datetime NOT NULL,
  `sign_out` datetime NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`id`, `username`, `type`, `sign_in`, `sign_out`, `created`) VALUES
(1, 'jecmerchandiseadmin', '', '2024-12-12 22:35:13', '2024-12-12 23:49:08', '2024-12-12 22:35:13'),
(2, 'jecmerchandiseadmin', '', '2024-12-12 23:49:16', '2024-12-12 23:49:29', '2024-12-12 23:49:16'),
(3, 'jecmerchandiseadmin', '', '2024-12-12 23:49:55', '2024-12-12 23:49:56', '2024-12-12 23:49:55'),
(4, 'jecmerchandiseadmin', '', '2024-12-13 07:52:52', '2024-12-13 07:53:14', '2024-12-13 07:52:52'),
(5, 'jecmerchandiseadmin', '', '2024-12-13 08:33:02', '2024-12-13 09:34:04', '2024-12-13 08:33:02'),
(6, 'jecmerchandiseadmin', '', '2024-12-13 09:34:19', '2024-12-13 10:49:01', '2024-12-13 09:34:19'),
(7, 'jecmerchandiseadmin', '', '2024-12-13 11:39:12', '2024-12-13 11:45:24', '2024-12-13 11:39:12'),
(8, 'jecmerchandiseadmin', '', '2024-12-13 11:45:31', '2024-12-13 11:45:34', '2024-12-13 11:45:31'),
(9, 'jecmerchandiseadmin', '', '2024-12-13 11:47:24', '2024-12-13 11:48:09', '2024-12-13 11:47:24'),
(10, 'jecmerchandiseadmin', '', '2024-12-13 11:54:32', '0000-00-00 00:00:00', '2024-12-13 11:54:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `history`
--
ALTER TABLE `history`
  ADD CONSTRAINT `history_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
