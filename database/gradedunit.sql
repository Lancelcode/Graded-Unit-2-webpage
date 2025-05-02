-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 07:47 PM
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
(29, 36, 'Hi this is the tip number 1', '2025-05-02 09:25:36'),
(38, 39, 'yes sir', '2025-05-02 16:45:09'),
(39, 40, 'hello crif', '2025-05-02 18:22:40');

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
(38, 35, '1234567890', '2025-05-01', 'fumanchu', '233', '2025-05-01 19:17:11'),
(39, 39, '32435678', '2025-05-08', 'user', '3223', '2025-05-02 17:17:15');

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
(10, NULL, 'fumanchu', 'fu@fu', 'testing please', '2025-05-01 21:45:49', 1, 'here you have!', 'admin@admin', '2025-05-02 10:52:49'),
(11, NULL, 'fumanchu', 'fu@fu', 'what 123', '2025-05-01 21:45:57', 1, 'bruh 321', 'admin@admin', '2025-05-02 10:52:49'),
(12, 35, 'fumanchu', 'fu@fu', 'yes?', '2025-05-01 21:46:35', 1, 'no!', 'admin@admin', '2025-05-02 10:52:49'),
(13, 36, 'admin@admin', 'admin@admin', 'sdfghjkl;', '2025-05-02 08:51:59', 1, 'bckhgfv,jhgvb', 'admin@admin', '2025-05-02 10:52:49'),
(14, 40, 'cris', 'crif@gmail.com', 'I love your website, its brutal', '2025-05-02 17:23:03', 0, NULL, NULL, NULL);

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
(98, 35, 0, 0, 0, 10, 'Certificate of Gold 🥇', '🥇', 'Thank you for your contribution! You\'ve unlocked full recognition!', 0, 1.00, '2025-05-01 21:25:32'),
(99, 35, 75, 6, 3, 1, 'Certificate of Gold 🥇', '🥇', 'Thank you for your contribution! You\'ve unlocked full recognition!', 0, 250.00, '2025-05-01 21:28:28'),
(100, 36, 75, 7, 1, 2, 'Certificate of Silver 🥈', '🥈', 'Great job! You\'re making a positive environmental impact.', 25, 250.00, '2025-05-02 08:07:05'),
(101, 36, 75, 7, 1, 2, 'Certificate of Gold 🥇', '🥇', 'Thank you for your contribution! You\'ve unlocked full recognition!', 0, 250.00, '2025-05-02 08:11:10'),
(102, 36, 75, 7, 1, 2, 'Certificate of Silver 🥈', '🥈', 'Great job! You\'re making a positive environmental impact.', 25, 250.00, '2025-05-02 08:18:40'),
(103, 37, 65, 5, 3, 2, 'Certificate of Silver 🥈', '🥈', 'Great job! You\'re making a positive environmental impact.', 35, 350.00, '2025-05-02 09:25:59'),
(105, 39, 60, 4, 4, 2, 'Certificate of Bronze 🥉', '🥉', 'Nice effort! Keep building sustainable habits.', 40, 400.00, '2025-05-02 14:07:17'),
(106, 40, 80, 7, 2, 1, 'Certificate of Gold 🥇', '🥇', 'Thank you for your contribution! You\'ve unlocked full recognition!', 0, 200.00, '2025-05-02 17:21:40');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cardid` int(10) DEFAULT NULL,
  `status` enum('active','inactive','deactivated') NOT NULL DEFAULT 'active',
  `company_name` varchar(100) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `new_users`
--

INSERT INTO `new_users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `cardid`, `status`, `company_name`, `contact_person`, `phone_number`) VALUES
(34, 'test1', 'test@test.test', '$2y$10$azg83r8x.QMs767x0yLGs.p9cDYfg7FOebTXxGb8H4Avvhk2QH08K', 'admin', '2025-05-01 17:23:54', NULL, 'inactive', 'test1 company', 'testone', '11111111111111111111'),
(35, 'fumanchu', 'fu@fu', '$2y$10$n4vh11tJxOgY5MPkKfH5Q.0XKnyot30AWMCy.TAAKWC3KYn7MjKgy', 'user', '2025-05-01 17:34:52', NULL, 'deactivated', 'fum fum fum co', 'smoke', '00000000000000000'),
(36, 'admin@admin', 'admin@admin', '$2y$10$VdFdg3VD8VoaIuHaSG327u3.y8Qy8PHuZ.orewXdhofHYxvgJP09q', 'admin', '2025-05-01 21:47:23', NULL, 'active', 'admin corporation', 'administrator', '00000000000000000000'),
(37, 'jamoncin', 'pernil@pernil', '$2y$10$Hwwe8aOkZ0lGX1bpCtjP7uOwoEAnIdCStqnJ4U0KuoMzkignZKG2i', 'user', '2025-05-02 00:26:03', NULL, 'active', 'JAM company', 'pig', '64521765476547654312'),
(39, 'Joe', 'joe@joe.com', '$2y$10$gDVJKK.y0c99dkaMLJrdZOObGQsRo5AN7YlsPglg1vZvJU4IooQ6S', 'user', '2025-05-02 12:24:05', NULL, 'active', 'joe.Corporation', 'Joe DOE', '5555555555555555555'),
(40, 'cris', 'crif@gmail.com', '$2y$10$7nHeemAINX68isS/zeOY4OYXpof6s48TZ6RAQgfuPOyaWvnwc/o4O', 'user', '2025-05-02 17:20:19', NULL, 'active', 'Crif', 'Crif', '08897956689');

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `credit_cards`
--
ALTER TABLE `credit_cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `green_calculator_results`
--
ALTER TABLE `green_calculator_results`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `new_users`
--
ALTER TABLE `new_users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
