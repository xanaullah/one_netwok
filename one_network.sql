-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2024 at 05:30 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `one_network`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `profile_image`, `created_at`, `updated_at`) VALUES
(1, 'Sana', 'production@gmail.com', '$2y$10$Ao0asHVdvNNQu.o/fIkBW.7BSTm14eCK2q0bxFQAws9msSKGCZ4fq', '123456789', '345345', NULL, '2024-08-20 15:52:41', '2024-08-20 15:52:41'),
(6, '343423', '343443434@gmail.com', '$2y$10$pScCgporKrpQ/NdiJdI9ceCdfz64yc3Nq4nWoJaxXoWcLjsutOkSq', 'Sana', '3434343', NULL, '2024-08-20 15:56:57', '2024-08-20 15:56:57'),
(7, 'khan', 'khan@gmail.com', '$2y$10$gYAJ/fV5DP1eNOl.QP0ljeD3.4eF9lk/4Tg65MaO27lioEiX.WNJS', 'Sana', 'ullah', 'uploads/66c4bfb202daf7.92211518.jpeg', '2024-08-20 15:57:43', '2024-08-20 16:09:22'),
(8, 'Ali', 'ali@gmail.com', '$2y$10$PGbgiAnfECd75QdWe5DAWu3h157cLnkzhOzD/aDRuzy7s5VEw317q', 'Ali', 'Khan', 'uploads/66c4d53dd1e7d5.74948217.jpeg', '2024-08-20 16:35:02', '2024-08-20 17:41:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
