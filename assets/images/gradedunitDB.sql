-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 01:32 PM
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
-- Database: `gradedunit`
--

-- --------------------------------------------------------

--
-- Table structure for table `community_tips`
--

CREATE TABLE `community_tips` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `community_tips`
--

INSERT INTO `community_tips` (`id`, `user_id`, `message`, `created_at`) VALUES
(9, 8, 'test', '2025-04-23 16:08:09'),
(14, 8, 'mmmmmmmmmmmmmmmmmmmmmmm', '2025-04-23 16:13:54'),
(18, 8, 's', '2025-04-23 16:29:14'),
(19, 8, 'kaboom', '2025-04-23 16:29:27'),
(20, 8, 'tatattatttattatta ratattata', '2025-04-23 16:29:36'),
(21, 8, 'tengo un mensajeeeee', '2025-04-23 16:30:34'),
(22, 8, 'this is another message', '2025-04-23 16:30:46'),
(23, 8, 'rokkkkkonuhbukh', '2025-04-23 16:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `credit_cards`
--

CREATE TABLE `credit_cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_number` varchar(16) NOT NULL,
  `expiry_date` date NOT NULL,
  `cardholder_name` varchar(100) NOT NULL,
  `cvv` varchar(4) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `credit_cards`
--

INSERT INTO `credit_cards` (`id`, `user_id`, `card_number`, `expiry_date`, `cardholder_name`, `cvv`, `created_at`) VALUES
(8, 6, '1111111111111112', '2222-03-01', 'colacao', '444', '2024-12-11 14:50:11'),
(11, 6, '123456789009', '2222-11-11', 'sava', '', '2024-12-11 15:28:15'),
(13, 7, '1111222233334444', '2025-01-01', 'koka', '', '2024-12-12 17:50:40'),
(14, 10, '146273839379', '2024-12-20', 'Kt', '', '2024-12-12 22:52:51'),
(15, 6, '1111222233334444', '2024-12-21', 'Kuku', '', '2024-12-12 22:52:53'),
(16, 6, '1111111111111111', '2025-06-08', 'koko', '', '2024-12-13 10:22:07'),
(17, 6, '1111111111111111', '2024-12-27', 'weder', '', '2024-12-14 18:17:52'),
(18, 11, '1111111111111111', '2024-12-12', 'fulanito', '', '2024-12-15 12:33:46'),
(19, 14, '1234567890', '2032-02-22', 'Cri Cri', '', '2024-12-15 15:04:36'),
(20, 15, '123456100', '2030-10-10', 'Lola Wars', '', '2024-12-15 15:13:56'),
(21, 16, '1234567891234567', '2034-01-01', 'Alfonso', '', '2024-12-15 15:55:50'),
(22, 17, '786421294532', '2029-06-07', 'Peter Parker', '', '2024-12-15 15:58:50'),
(23, 19, '1111111111111111', '2029-12-05', 'James Sneddon', '', '2024-12-15 21:58:20'),
(31, 8, '1234567890', '2025-01-01', 'test 0123', '', '2025-04-23 17:31:47'),
(34, 28, '5427', '2025-04-23', '2477475', '', '2025-04-24 20:23:07');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `visible_to_public` tinyint(1) DEFAULT 0,
  `admin_response` text DEFAULT NULL,
  `admin_username` varchar(100) DEFAULT NULL,
  `admin_response_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `name`, `email`, `message`, `created_at`, `visible_to_public`, `admin_response`, `admin_username`, `admin_response_at`) VALUES
(5, 28, 'admin', 'admin@admin', 'question ?', '2025-04-24 08:17:32', 1, 'good question mate', 'admin', '2025-04-24 23:47:35'),
(6, 8, 'test@test.com', 'test@test.com', 'testing 123', '2025-04-24 11:13:26', 1, 'this is being tested, Mate!', 'admin', '2025-04-24 23:47:35'),
(7, 8, 'test@test.com', 'test@test.com', 'uuuuuuuuuuuuuuuuuuuuuuu', '2025-04-24 11:19:35', 1, 'lets gooooo', 'admin', '2025-04-24 23:47:35'),
(8, 8, 'test@test.com', 'test@test.com', 'lol', '2025-04-24 22:29:17', 1, 'ooooooo', 'admin', '2025-04-24 23:47:35');

-- --------------------------------------------------------

--
-- Table structure for table `green_calculator_results`
--

CREATE TABLE `green_calculator_results` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `total_score` int(11) NOT NULL,
  `green_count` int(11) NOT NULL,
  `amber_count` int(11) NOT NULL,
  `red_count` int(11) NOT NULL,
  `award_level` varchar(50) NOT NULL,
  `emoji` char(2) DEFAULT NULL,
  `feedback_message` text DEFAULT NULL,
  `shortfall` int(11) NOT NULL,
  `donation_cost` decimal(6,2) NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `green_calculator_results`
--

INSERT INTO `green_calculator_results` (`id`, `user_id`, `total_score`, `green_count`, `amber_count`, `red_count`, `award_level`, `emoji`, `feedback_message`, `shortfall`, `donation_cost`, `submitted_at`) VALUES
(1, 8, 60, 4, 4, 2, '🥈 Silver', NULL, NULL, 40, 400.00, '2025-04-20 19:03:14'),
(2, 8, 60, 4, 4, 2, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-20 19:06:58'),
(3, 8, 100, 10, 0, 0, 'Gold 🏅', NULL, NULL, 0, 0.00, '2025-04-20 19:08:08'),
(4, 8, 100, 10, 0, 0, 'Gold 🏅', NULL, NULL, 0, 0.00, '2025-04-20 19:10:51'),
(5, 8, 90, 9, 0, 1, 'Gold 🏅', NULL, NULL, 10, 100.00, '2025-04-20 19:12:50'),
(6, 8, 80, 8, 0, 2, 'Gold 🏅', NULL, NULL, 20, 200.00, '2025-04-20 19:13:04'),
(7, 8, 70, 7, 0, 3, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-20 19:13:13'),
(8, 8, 70, 7, 0, 3, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-20 19:16:42'),
(9, 8, 60, 6, 0, 4, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 21:32:01'),
(10, 8, 60, 6, 0, 4, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 21:32:33'),
(11, 8, 60, 6, 0, 4, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 21:42:15'),
(12, 8, 60, 6, 0, 4, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 21:42:33'),
(13, 8, 65, 6, 1, 3, 'Silver 🥈', NULL, NULL, 35, 350.00, '2025-04-21 21:44:03'),
(14, 8, 65, 6, 1, 3, 'Silver 🥈', NULL, NULL, 35, 350.00, '2025-04-21 21:44:56'),
(15, 8, 60, 6, 0, 4, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 21:49:33'),
(16, 8, 50, 0, 10, 0, 'Bronze 🥉', NULL, NULL, 50, 500.00, '2025-04-21 21:49:59'),
(17, 8, 60, 6, 0, 4, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 21:52:57'),
(18, 8, 60, 6, 0, 4, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 21:53:10'),
(19, 8, 50, 0, 10, 0, 'Bronze 🥉', NULL, NULL, 50, 500.00, '2025-04-21 21:53:34'),
(20, 8, 50, 0, 10, 0, 'Bronze 🥉', NULL, NULL, 50, 500.00, '2025-04-21 21:53:50'),
(21, 8, 70, 6, 2, 2, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-21 21:59:00'),
(22, 8, 50, 0, 10, 0, 'Bronze 🥉', NULL, NULL, 50, 500.00, '2025-04-21 21:59:45'),
(23, 8, 80, 8, 0, 2, 'Gold 🏅', NULL, NULL, 20, 200.00, '2025-04-21 22:15:36'),
(24, 8, 70, 6, 2, 2, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-21 22:16:28'),
(25, 8, 75, 6, 3, 1, 'Silver 🥈', NULL, NULL, 25, 250.00, '2025-04-21 22:21:00'),
(26, 8, 75, 6, 3, 1, 'Silver 🥈', NULL, NULL, 25, 250.00, '2025-04-21 22:22:13'),
(27, 8, 75, 6, 3, 1, 'Silver 🥈', NULL, NULL, 25, 250.00, '2025-04-21 22:23:22'),
(28, 8, 60, 5, 2, 3, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 22:33:36'),
(29, 8, 60, 5, 2, 3, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 22:52:29'),
(30, 8, 70, 6, 2, 2, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-21 22:53:17'),
(31, 8, 60, 5, 2, 3, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 22:53:29'),
(32, 8, 60, 5, 2, 3, 'Silver 🥈', NULL, NULL, 40, 400.00, '2025-04-21 22:54:06'),
(33, 26, 70, 6, 2, 2, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-21 23:25:42'),
(34, 8, 80, 7, 2, 1, 'Gold 🏅', NULL, NULL, 20, 200.00, '2025-04-23 14:11:05'),
(35, 8, 80, 7, 2, 1, 'Gold 🏅', NULL, NULL, 20, 200.00, '2025-04-23 14:11:59'),
(36, 8, 70, 7, 0, 3, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-23 16:45:27'),
(37, 8, 80, 8, 0, 2, 'Gold 🏅', NULL, NULL, 20, 200.00, '2025-04-23 16:45:54'),
(38, 8, 80, 8, 0, 2, 'Gold 🏅', NULL, NULL, 20, 200.00, '2025-04-23 17:01:30'),
(39, 8, 75, 6, 3, 1, 'Silver 🥈', NULL, NULL, 25, 250.00, '2025-04-23 17:05:26'),
(40, 8, 75, 6, 3, 1, 'Silver 🥈', NULL, NULL, 25, 250.00, '2025-04-23 17:05:53'),
(41, 8, 75, 6, 3, 1, 'Silver 🥈', NULL, NULL, 25, 250.00, '2025-04-23 17:06:19'),
(42, 8, 75, 6, 3, 1, 'Silver 🥈', NULL, NULL, 25, 250.00, '2025-04-23 17:06:41'),
(43, 8, 75, 6, 3, 1, 'Silver 🥈', NULL, NULL, 25, 250.00, '2025-04-23 17:07:56'),
(44, 28, 85, 7, 3, 0, 'Gold 🏅', NULL, NULL, 15, 150.00, '2025-04-24 21:54:53'),
(45, 28, 85, 7, 3, 0, 'Gold 🏅', NULL, NULL, 15, 150.00, '2025-04-24 21:55:18'),
(46, 28, 90, 9, 0, 1, 'Gold 🏅', NULL, NULL, 10, 100.00, '2025-04-24 21:59:11'),
(47, 28, 50, 5, 0, 5, 'Bronze 🥉', NULL, NULL, 50, 500.00, '2025-04-24 22:00:11'),
(48, 28, 0, 0, 0, 10, 'Certificate of Encouragement 👏', NULL, NULL, 100, 1000.00, '2025-04-24 22:00:47'),
(49, 8, 70, 7, 0, 3, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-24 22:44:42'),
(50, 8, 70, 7, 0, 3, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-24 22:45:53'),
(51, 8, 70, 7, 0, 3, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-24 22:46:06'),
(52, 28, 80, 7, 2, 1, 'Gold 🏅', NULL, NULL, 20, 200.00, '2025-04-24 23:11:12'),
(53, 28, 65, 3, 7, 0, 'Silver 🥈', NULL, NULL, 35, 350.00, '2025-04-25 00:17:30'),
(54, 28, 65, 3, 7, 0, 'Silver 🥈', NULL, NULL, 35, 350.00, '2025-04-25 00:17:43'),
(55, 28, 0, 0, 0, 10, 'Certificate of Encouragement 👏', NULL, NULL, 100, 1000.00, '2025-04-25 00:18:06'),
(56, 28, 50, 0, 10, 0, 'Bronze 🥉', NULL, NULL, 50, 500.00, '2025-04-25 00:22:30'),
(57, 28, 70, 6, 2, 2, 'Silver 🥈', NULL, NULL, 30, 300.00, '2025-04-25 00:23:25'),
(58, 28, 65, 6, 1, 3, 'Silver 🥈', NULL, NULL, 35, 350.00, '2025-04-25 00:45:39'),
(59, 28, 30, 2, 2, 6, 'Certificate of Encouragement 👏', NULL, NULL, 70, 700.00, '2025-04-25 00:46:04'),
(60, 28, 40, 3, 2, 5, 'Bronze 🥉', NULL, NULL, 60, 600.00, '2025-04-25 00:49:30'),
(61, 28, 9, 3, 0, 0, 'Gold', '🥇', 'You’re a sustainability champion! Exceptional work.', 0, 0.00, '2025-04-25 00:50:15'),
(62, 28, 45, 3, 3, 4, 'Bronze', '🥉', 'Nice effort! Keep building sustainable habits.', 55, 550.00, '2025-04-25 00:53:52'),
(63, 28, 35, 2, 3, 5, 'Certificate of Encouragement', '🌱', 'Every step counts. Keep growing your green impact!', 65, 650.00, '2025-04-25 00:54:53'),
(64, 28, 35, 2, 3, 5, 'Certificate of Encouragement', '🌱', 'Every step counts. Keep growing your green impact!', 65, 650.00, '2025-04-25 00:56:12'),
(65, 28, 35, 2, 3, 5, 'Certificate of Encouragement 👏', '💪', 'You\'re making progress. Small steps matter — keep going!', 65, 650.00, '2025-04-25 01:02:53'),
(66, 28, 35, 2, 3, 5, 'Certificate of Encouragement 👏', '💪', 'You\'re making progress. Small steps matter — keep going!', 65, 650.00, '2025-04-25 01:03:12'),
(67, 28, 35, 2, 3, 5, 'Certificate of Encouragement 👏', '💪', 'You\'re making progress. Small steps matter — keep going!', 65, 650.00, '2025-04-25 01:03:31'),
(68, 28, 65, 5, 3, 2, 'Silver', '🥈', 'Great job! You\'re making a positive environmental impact.', 35, 350.00, '2025-04-25 01:03:42'),
(69, 28, 60, 4, 4, 2, 'Bronze', '🥉', 'Nice effort! Keep building sustainable habits.', 40, 400.00, '2025-04-25 01:04:03'),
(70, 28, 50, 3, 4, 3, 'Certificate of Encouragement 👏', '🌟', 'You\'re almost there! Just a few more changes will go a long way.', 50, 500.00, '2025-04-25 01:04:15'),
(71, 28, 50, 3, 4, 3, 'Certificate of participation 👏', '🌟', 'You\'re almost there! Just a few more changes will go a long way.', 50, 500.00, '2025-04-25 01:05:49'),
(72, 28, 55, 4, 3, 3, 'Certificate of Bronze', '🥉', 'Nice effort! Keep building sustainable habits.', 45, 450.00, '2025-04-25 01:05:58'),
(73, 28, 55, 4, 3, 3, '🥉 Certificate of Bronze', '🥉', 'Nice effort! Keep building sustainable habits.', 45, 450.00, '2025-04-25 01:07:37'),
(74, 28, 55, 4, 3, 3, 'Certificate of Bronze 🥉', '🥉', 'Nice effort! Keep building sustainable habits.', 45, 450.00, '2025-04-25 01:08:54'),
(75, 28, 50, 3, 4, 3, 'Certificate of participation 👏', '🌟', 'You\'re almost there! Just a few more changes will go a long way.', 50, 500.00, '2025-04-25 01:09:08'),
(76, 28, 75, 6, 3, 1, 'Certificate of Silver 🥈', '🥈', 'Great job! You\'re making a positive environmental impact.', 25, 250.00, '2025-04-25 01:16:06');

-- --------------------------------------------------------

--
-- Table structure for table `new_users`
--

CREATE TABLE `new_users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `two_factor_secret` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cardid` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `new_users`
--

INSERT INTO `new_users` (`id`, `username`, `email`, `password`, `role`, `two_factor_secret`, `created_at`, `cardid`) VALUES
(5, 'a', 'a@a', 'ca978112ca1bbdcafac231b39a23dc4da786eff8147c4e72b9807785afee48bb', 'user', NULL, '2024-12-01 17:44:46', NULL),
(6, 'Pepito', 'pp@pp', 'd53315bea08cec50d2591fcaf3b32dc5d289cdc6c16b7e8bed8c8e3f7ceaa34e', 'user', NULL, '2024-12-04 10:46:02', NULL),
(7, '12', '12@12', '6b51d431df5d7f141cbececcf79edf3dd861c3b4069f0b11661a3eefacbba918', 'user', NULL, '2024-12-06 21:15:13', NULL),
(8, 'test@test.com', 'test@test.com', '9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08', 'user', NULL, '2024-12-06 21:31:31', NULL),
(9, '1234', '1234@1234.com', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', 'user', NULL, '2024-12-06 21:49:14', NULL),
(10, 'Kitipun', 'kiti@gm.com', '535fa30d7e25dd8a49f1536779734ec8286108d115da5045d77f3b4185d8f790', 'user', NULL, '2024-12-12 22:49:05', NULL),
(11, 'Fulanito', 'f@f', '252f10c83610ebca1a059c0bae8255eba2f95be4d1d7bcfa89d7248a82d9f111', 'user', NULL, '2024-12-15 12:08:20', NULL),
(12, 'evelinmihaylov', 'evelinmihaylov@hotmail.com', '5e56e3537355f988e26a2c4a29107d440b8e755610042963b5aabac56dbb99d7', 'user', NULL, '2024-12-15 14:44:58', NULL),
(13, 'cri24', 'cri24@gp.com', 'ff2000faf7892694bf34d3bc461a8326926dd0dbb3c6ee4a178adb23abf0e738', 'user', NULL, '2024-12-15 14:57:20', NULL),
(14, 'cri24', 'cri1988@gp.com', 'ff2000faf7892694bf34d3bc461a8326926dd0dbb3c6ee4a178adb23abf0e738', 'user', NULL, '2024-12-15 15:03:07', NULL),
(15, '123', '123@lol.com', '07123e1f482356c415f684407a3b8723e10b2cbbc0b8fcd6282c49d37c9c1abc', 'user', NULL, '2024-12-15 15:13:01', NULL),
(16, 'alfonso', 'alfonso@hotmail.com', 'c7e52d8590eaed2bc3558eacd21b5ed7d1ac0770507440f8bc2748308090bc77', 'user', NULL, '2024-12-15 15:54:36', NULL),
(17, 'Antonio', 'antonio@hotmail.com', '4ee3679892e6ac5a5b513eba7fd529d363d7a96508421c5dbd44b01b349cf514', 'user', NULL, '2024-12-15 15:57:59', NULL),
(18, 'joe', 'joe@joe', 'de3bbd0fd7945e42581643b18cdf28dd3ed61d9c3d541b7b016081564b65a3f3', 'user', NULL, '2024-12-15 17:31:15', NULL),
(19, 'Jamie', 'Jamie@test.com', '1b4f0e9851971998e732078544c96b36c3d01cedf7caa332359d6f1d83567014', 'user', NULL, '2024-12-15 21:57:35', NULL),
(20, 'Djiby .S .R', 'sr@sr', 'cc8844298c08e2fb7ba75080b9fad6fbd23d63bf3534c713e87ad87cee8f5b57', 'user', NULL, '2024-12-16 13:54:19', NULL),
(21, 'Log', 'dhrhj@gm.com', '776c5ada6a2017e7768bb85e544cd511202571caeace54d3e5c2df156b34ea10', 'user', NULL, '2024-12-16 14:08:35', NULL),
(22, 'Lola', 'lola@gm.com', '47acf82a48cfa5c340ea536cdd66c75ef85eb8d3fcff468fc7c8abcaceb15ed0', 'user', NULL, '2024-12-16 14:09:37', NULL),
(23, 'alberto', 'alberto@hotmail.com', '4bdbc215d8dc3c571e802a69bced0c3071cc4a1f129ad97e15b357018aac6cd4', 'user', NULL, '2024-12-16 14:31:57', NULL),
(24, 'k', 'k@k', '8254c329a92850f6d539dd376f4816ee2764517da5e0235514af433164480d7a', 'admin', NULL, '2024-12-18 14:52:11', NULL),
(25, 'ju@ga.dor', 'ju@ga.dor', 'e31fc8c47486e7aaa098e85c54adb0d9d30a2cc5467163c614764ec360e0803f', 'user', NULL, '2025-03-15 16:01:28', NULL),
(26, '1', '1@1', '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b', 'user', NULL, '2025-04-21 13:27:25', NULL),
(27, 'puto', 'puto@puto', '6ada028b2d096d946ddfb32453673d6116a10d664593ca86b73b6de12e060355', 'admin', '', '2025-04-23 19:35:28', NULL),
(28, 'admin', 'admin@admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 'admin', NULL, '2025-04-23 21:30:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `success_stories`
--

CREATE TABLE `success_stories` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL COMMENT 'path or URL to image',
  `reduction_percentage` decimal(5,2) NOT NULL COMMENT 'e.g. 12.50'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `community_tips`
--
ALTER TABLE `community_tips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `credit_cards`
--
ALTER TABLE `credit_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `green_calculator_results`
--
ALTER TABLE `green_calculator_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `new_users`
--
ALTER TABLE `new_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `success_stories`
--
ALTER TABLE `success_stories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `community_tips`
--
ALTER TABLE `community_tips`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `credit_cards`
--
ALTER TABLE `credit_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `green_calculator_results`
--
ALTER TABLE `green_calculator_results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `new_users`
--
ALTER TABLE `new_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `success_stories`
--
ALTER TABLE `success_stories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `community_tips`
--
ALTER TABLE `community_tips`
  ADD CONSTRAINT `community_tips_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `new_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `new_users` (`id`);

--
-- Constraints for table `green_calculator_results`
--
ALTER TABLE `green_calculator_results`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `new_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
