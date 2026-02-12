-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2026 at 03:43 PM
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
-- Database: `dermsignal_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account`
--

CREATE TABLE `tbl_account` (
  `ac_id` int(11) NOT NULL,
  `ac_username` varchar(255) NOT NULL,
  `ac_email` varchar(400) NOT NULL,
  `ac_password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `account_status_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_account`
--

INSERT INTO `tbl_account` (`ac_id`, `ac_username`, `ac_email`, `ac_password`, `role_id`, `account_status_id`) VALUES
(2, 'shibal1', 'shibal@gmail.com', '$2y$10$p2Mbo9cxssQGcOe2vPpVCuxnxOlTdPySyrbfQ0GzwydLBI2HK5SNe', 1, 1),
(3, 'uniform1', 'uniform@gmail.com', '$2y$10$6X5caxJ7hgH2jHJTVSMhVer80umvvkjZlKnYvhko6dTOdt.duBZIK', 1, 2),
(5, 'kiko1', 'kiko@gmail.com', '$2y$10$d69zFFkiMBnrYJyVixN.ieoydzdc/bsOiH7Nppy1mdwFSmFyCsTwS', 1, 1),
(6, 'admin', 'admin@gmail.com', '$2y$10$egNxXzs.VSGfoHHq23iaR.mUC5za/vs3UwOF2OvSHHtIPooXIxl1i', 2, 1),
(8, 'jcdavid123', 'jcdavid123c@gmail.com', '$2y$10$D8ufRQ4.ZB64gtT7KfFjWOC26PZMrUHtEld3gY2ieW8lSHp4IkFe2', 2, 1),
(12, 'jcdavid123c', 'jcdavid21@gmail.com', '$2y$10$eaOHu6gTMPtdkcJNnAD5MuaE7zkLxy0r4S2kT6ZPi5TC2DH.INlX2', 1, 1),
(13, 'santos', 'santos@gmail.com', '$2y$10$h1w97Y.aGsIxG91vSXuXHuhaHSQkK0U4EvEA32hMdAqNNwtnEUKEa', 3, 1),
(14, 'admin1', 'admin1@gmail.com', '$2y$10$3txKbILRPnAT4tb0Q5mReeKgMLvHz1Jo4/z/7.rI.OQVeFHH5aOv6', 2, 1),
(15, 'anareyes', 'anareyes@gmail.com', '$2y$10$CO.mcf6gniWC6VOIJtjmUeMFo25FxAPTLLuockG/ZPcnqg5Kt/M.a', 3, 1),
(16, 'johncruz', 'johncruz@gmail.com', '$2y$10$pzh0g73BjAtXGgvVcc0qCOAT61KhH4AB3IOXu89NnRqCq4o8iLiF.', 3, 1),
(17, 'jhyraadmin', 'jhyramarie28@gmail.com', '$2y$10$H9K4foruWujuct/x3WcXzeKSvZjpG0vgdOzrzJnPIOlzFGtwatm7W', 2, 1),
(18, 'Jhyra', 'jhyramarie281@gmail.com', '$2y$10$euf8WIS8Ck.0hCgpNl/LruQcD930fq51t9jNsupb01o6D8zyKJOee', 1, 1),
(19, 'alexin', 'alexin@gmail.com', '$2y$10$HWegti4WS1WggotaIONdX.eSovSFR7MFTkXg27p1TJhC7z1gdhavm', 1, 1),
(20, 'Kevin', 'kevin@gmail.com', '$2y$10$Zzk1A3z0IT5SYL.NJ7ZzYuMRryxI6t7VmI3vok85il2hpR3UH/NPW', 1, 1),
(21, 'Cj', 'cj@gmail.com', '$2y$10$hW21yYFVJsqKEhZ.ZCf2eey3y6Vkudn5YneggMU3ILhQty4ApwrZe', 1, 1),
(22, 'alexin123', 'alexin1@gmail.com', '$2y$10$k78oI5axha8e4a36T7LBzO.6DbFR.SjxXtlpKqJyn6jqtGXEqXhku', 1, 1),
(23, 'cjborjal', 'cjborjal@gmail.com', '$2y$10$0NB3rTYgldoGV8PUqLDfw.PPTSogbYlWEo5n9uwFu2BtMCEz/btyS', 1, 1),
(24, 'gmvl', 'gma@gmail.com', '$2y$10$.2SNRRAIvw1H8XI7kFpGOeBLg4/WXFZ0EiTqHXotWgtr.2VcKmcLW', 1, 1),
(25, 'luisa', 'luisa@gmail.com', '$2y$10$lsBbM6N2VPKeVN0xWLLAmeKVIo7eRaxgF7epeCiYMnWBEzwLvRTmW', 1, 1),
(26, 'emman', 'emman@gmail.com', '$2y$10$z5s3RXy9vgp1CdCGZQIiQ.kTtY1OxuO2iaGMcNKxfVE/vnQPs5M8S', 1, 1),
(27, 'jhy', 'jmarie@gmail.com', '$2y$10$pr5sXgo3lhh3q0WIeM1sfuurMyu/MPN1HZGJllI384kuHPl5Fv9k2', 1, 1),
(28, 'derma-parapina', 'dermaparapina@gmail.com', '$2y$10$aZkOKVjwInTMFbBUkPp.q.Ab3u3qXTwfPxApFXrcCT4ULOQ6AA7Z.', 3, 1),
(29, 'Gmm123', 'Gmm@gmail.com', '$2y$10$DLF9yfsRGGcvkPap9sDqO.iaT6V2F6nRdU5dr6rpbNIrulc/r202e', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_account_details`
--

CREATE TABLE `tbl_account_details` (
  `ac_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `gender` enum('Male','Female','Other') DEFAULT NULL,
  `contact` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_account_details`
--

INSERT INTO `tbl_account_details` (`ac_id`, `first_name`, `middle_name`, `last_name`, `gender`, `contact`, `address`) VALUES
(2, 'Shibal', 'Magat', 'Mandusay', 'Male', '', ''),
(3, 'Uniform', 'Resource', 'Locator', 'Male', '', ''),
(4, 'lelouch', 'hitler', 'luoda', 'Male', '', ''),
(5, 'Kiko ', 'Miranda', 'Music', 'Male', '', ''),
(6, 'Admin', 'Jhyra', 'Jhyra', 'Male', '', ''),
(12, 'jc', '', 'david', NULL, NULL, NULL),
(13, 'Maria', 'Faye', 'Santos', 'Female', '', ''),
(14, 'JC', '', 'david', 'Male', '09565535401', 'Wala'),
(15, 'Ana', '', 'Reyes', 'Female', '09512847442', 'Quezon City'),
(16, 'john', '', 'cruz', 'Male', '09565535401', 'Quezon City'),
(17, 'Jhyra', 'Mamangon', 'Mariano', 'Female', '+639493444483', '#12 osmena'),
(18, 'Jhyra', 'Mamangon', 'Mariano', NULL, '09493444483', 'QC'),
(19, 'Alexin', 'Balan', 'Parapina', NULL, NULL, NULL),
(20, 'Kevin', 'Cedric', 'Mendoza', NULL, NULL, NULL),
(21, 'CJ', 'James', 'Borjal', NULL, NULL, NULL),
(22, 'Alexin', 'Balan', 'Parapina', NULL, NULL, NULL),
(23, 'Christian', 'James', 'Borjal', NULL, NULL, NULL),
(24, 'Glenn Mar', 'Villorente', 'Lagutan', NULL, NULL, NULL),
(25, 'Luisa', 'Mamangon', 'Mariano', NULL, NULL, NULL),
(26, 'emman', 'galupo', 'galupo', NULL, NULL, NULL),
(27, 'jhyra', 'marie', 'mariano', NULL, NULL, NULL),
(28, 'Alexin', 'Kaye', 'Parapina', 'Female', '+639493444484', 'muzon'),
(29, 'Gmm', 'Gmm', 'Gmm', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ac_status`
--

CREATE TABLE `tbl_ac_status` (
  `ac_status_id` int(11) NOT NULL,
  `ac_status` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_estonian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ac_status`
--

INSERT INTO `tbl_ac_status` (`ac_status_id`, `ac_status`) VALUES
(1, 'Active'),
(2, 'Deactivated');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_appointments`
--

CREATE TABLE `tbl_appointments` (
  `appointment_id` int(11) NOT NULL,
  `ac_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `derm_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `appointment_status` enum('Pending','Confirmed','Completed','Cancelled') DEFAULT 'Pending',
  `notes` text DEFAULT NULL,
  `gcash_reference` varchar(100) DEFAULT NULL,
  `downpayment_amount` decimal(10,2) DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `payment_status` enum('Pending','Verified','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_appointments`
--

INSERT INTO `tbl_appointments` (`appointment_id`, `ac_id`, `service_id`, `derm_id`, `appointment_date`, `appointment_time`, `appointment_status`, `notes`, `gcash_reference`, `downpayment_amount`, `payment_proof`, `payment_status`, `created_at`) VALUES
(3, 12, 21, 1, '2025-11-13', '10:00:00', 'Confirmed', '', '2132313', 50.00, '690a113f4672f.jpeg', 'Verified', '2025-11-04 14:44:15'),
(4, 18, 3, 1, '2025-12-15', '12:25:00', 'Completed', '', '0123456789012', 250.00, '6937dea31e138.jpg', 'Pending', '2025-12-09 08:32:35'),
(5, 18, 3, 1, '2025-12-16', '10:40:00', 'Confirmed', '', '0123456789012', 250.00, '693adf408aee4.jpg', 'Pending', '2025-12-11 15:12:00'),
(6, 18, 8, 1, '2025-12-16', '13:40:00', 'Confirmed', '', '0123456789012', 1250.00, '693b9642cbc51.jpg', 'Pending', '2025-12-12 04:12:50'),
(7, 18, 10, 1, '2025-12-13', '01:10:00', 'Pending', '', '0123456789012', 750.00, '693ba49da0dc9.jpg', 'Pending', '2025-12-12 05:14:05'),
(8, 26, 3, 1, '2025-12-13', '14:20:00', 'Pending', 'dsdasd', '0123456789012', 250.00, '693bf87812cd5.jpg', 'Pending', '2025-12-12 11:11:52');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_log`
--

CREATE TABLE `tbl_audit_log` (
  `log_user_id` int(11) DEFAULT NULL,
  `log_username` varchar(50) DEFAULT NULL,
  `log_user_type` varchar(50) DEFAULT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_audit_log`
--

INSERT INTO `tbl_audit_log` (`log_user_id`, `log_username`, `log_user_type`, `log_date`) VALUES
(6, 'admin', '2', '2024-12-11 11:52:16'),
(1, 'jhaymark198', '1', '2024-12-11 13:39:42'),
(8, 'jcdavid123', '1', '2025-10-19 05:41:06'),
(8, 'jcdavid123', '2', '2025-10-19 06:07:19'),
(12, 'jcdavid123c', '1', '2025-10-19 09:33:14'),
(8, 'jcdavid123', '2', '2025-10-19 09:58:25'),
(8, 'jcdavid123', '2', '2025-10-19 10:33:08'),
(8, 'jcdavid123', '2', '2025-10-19 16:09:26'),
(12, 'jcdavid123c', '1', '2025-10-19 16:10:56'),
(8, 'jcdavid123', '2', '2025-10-19 16:51:38'),
(8, 'jcdavid123', '2', '2025-10-19 16:51:38'),
(13, 'santos', '3', '2025-10-19 16:59:31'),
(13, 'santos', '3', '2025-10-19 16:59:49'),
(13, 'santos', '3', '2025-10-19 17:09:42'),
(13, 'santos', '3', '2025-10-20 04:57:03'),
(12, 'jcdavid123c', '1', '2025-10-20 05:26:25'),
(13, 'santos', '3', '2025-10-20 05:27:43'),
(8, 'jcdavid123', '2', '2025-10-20 05:41:42'),
(13, 'santos', '3', '2025-10-20 05:43:42'),
(13, 'santos', '3', '2025-10-20 05:47:57'),
(13, 'santos', '3', '2025-10-20 06:27:51'),
(12, 'jcdavid123c', '1', '2025-10-20 06:54:02'),
(8, 'jcdavid123', '2', '2025-10-20 07:06:22'),
(12, 'jcdavid123c', '1', '2025-10-20 07:22:16'),
(8, 'jcdavid123', '2', '2025-10-20 08:05:33'),
(12, 'jcdavid123c', '1', '2025-10-20 12:09:10'),
(8, 'jcdavid123', '2', '2025-10-20 12:09:36'),
(12, 'jcdavid123c', '1', '2025-10-20 12:10:52'),
(13, 'santos', '3', '2025-10-20 12:11:50'),
(12, 'jcdavid123c', '1', '2025-10-20 13:56:28'),
(8, 'jcdavid123', '2', '2025-10-21 03:29:39'),
(12, 'jcdavid123c', '1', '2025-10-21 04:57:08'),
(8, 'jcdavid123', '2', '2025-10-21 05:37:47'),
(12, 'jcdavid123c', '1', '2025-10-21 05:51:18'),
(12, 'jcdavid123c', '1', '2025-10-21 06:24:14'),
(8, 'jcdavid123', '2', '2025-10-21 06:24:28'),
(8, 'jcdavid123', '2', '2025-10-21 06:25:36'),
(12, 'jcdavid123c', '1', '2025-10-21 13:48:20'),
(12, 'jcdavid123c', '1', '2025-10-21 13:55:27'),
(8, 'jcdavid123', '2', '2025-10-21 14:07:08'),
(12, 'jcdavid123c', '1', '2025-10-21 14:07:30'),
(12, 'jcdavid123c', '1', '2025-10-21 14:11:34'),
(8, 'jcdavid123', '2', '2025-10-21 14:12:01'),
(12, 'jcdavid123c', '1', '2025-10-21 14:16:11'),
(13, 'santos', '3', '2025-10-23 14:53:55'),
(13, 'santos', '3', '2025-10-23 15:18:30'),
(13, 'santos', '3', '2025-10-23 15:19:15'),
(13, 'santos', '3', '2025-10-23 15:19:53'),
(12, 'jcdavid123c', '1', '2025-10-23 15:21:20'),
(12, 'jcdavid123c', '1', '2025-10-23 15:24:58'),
(13, 'santos', '3', '2025-10-23 15:25:27'),
(8, 'jcdavid123', '2', '2025-11-04 11:08:08'),
(12, 'jcdavid123c', '1', '2025-11-04 11:08:22'),
(8, 'jcdavid123', '2', '2025-11-04 11:58:56'),
(12, 'jcdavid123c', '1', '2025-11-04 14:05:59'),
(8, 'jcdavid123', '2', '2025-11-04 14:44:54'),
(8, 'jcdavid123', '2', '2025-11-04 14:45:27'),
(12, 'jcdavid123c', '1', '2025-11-04 14:45:43'),
(13, 'santos', '3', '2025-11-04 14:46:02'),
(8, 'jcdavid123', '2', '2025-11-04 15:00:16'),
(12, 'jcdavid123c', '1', '2025-11-04 15:00:26'),
(12, 'jcdavid123c', '1', '2025-11-05 12:17:59'),
(8, 'jcdavid123', '2', '2025-11-05 12:18:18'),
(8, 'jcdavid123', '2', '2025-12-08 07:11:59'),
(8, 'jcdavid123', '2', '2025-12-08 09:58:05'),
(17, 'jhyraadmin', '2', '2025-12-09 08:04:03'),
(18, 'Jhyra', '1', '2025-12-09 08:05:29'),
(18, 'Jhyra', '1', '2025-12-09 08:14:23'),
(13, 'santos', '3', '2025-12-09 08:23:20'),
(18, 'Jhyra', '1', '2025-12-09 08:27:13'),
(17, 'jhyraadmin', '2', '2025-12-09 08:38:36'),
(13, 'santos', '3', '2025-12-09 08:43:38'),
(19, 'alexin', '1', '2025-12-09 09:10:03'),
(20, 'Kevin', '1', '2025-12-09 09:12:23'),
(17, 'jhyraadmin', '2', '2025-12-09 09:14:04'),
(21, 'Cj', '1', '2025-12-09 09:16:57'),
(17, 'jhyraadmin', '2', '2025-12-09 09:17:48'),
(18, 'Jhyra', '1', '2025-12-09 09:20:41'),
(18, 'Jhyra', '1', '2025-12-10 13:34:32'),
(17, 'jhyraadmin', '2', '2025-12-10 13:35:13'),
(18, 'Jhyra', '1', '2025-12-10 13:37:01'),
(17, 'jhyraadmin', '2', '2025-12-10 13:38:05'),
(17, 'jhyraadmin', '2', '2025-12-10 13:40:40'),
(18, 'Jhyra', '1', '2025-12-10 13:41:23'),
(17, 'jhyraadmin', '2', '2025-12-10 13:47:35'),
(18, 'Jhyra', '1', '2025-12-10 13:49:44'),
(18, 'Jhyra', '1', '2025-12-10 13:56:48'),
(18, 'Jhyra', '1', '2025-12-10 13:57:30'),
(17, 'jhyraadmin', '2', '2025-12-10 13:57:45'),
(18, 'Jhyra', '1', '2025-12-10 14:01:57'),
(18, 'Jhyra', '1', '2025-12-11 15:03:58'),
(13, 'santos', '3', '2025-12-11 15:12:16'),
(17, 'jhyraadmin', '2', '2025-12-11 15:14:31'),
(18, 'Jhyra', '1', '2025-12-11 15:18:57'),
(17, 'jhyraadmin', '2', '2025-12-11 15:21:44'),
(18, 'Jhyra', '1', '2025-12-11 15:26:14'),
(17, 'jhyraadmin', '2', '2025-12-11 15:39:25'),
(17, 'jhyraadmin', '2', '2025-12-11 16:33:39'),
(18, 'Jhyra', '1', '2025-12-11 16:36:14'),
(17, 'jhyraadmin', '2', '2025-12-11 16:37:16'),
(17, 'jhyraadmin', '2', '2025-12-12 03:43:20'),
(18, 'Jhyra', '1', '2025-12-12 03:46:42'),
(19, 'alexin', '1', '2025-12-12 03:51:06'),
(20, 'Kevin', '1', '2025-12-12 03:51:56'),
(23, 'cjborjal', '1', '2025-12-12 03:54:56'),
(24, 'gmvl', '1', '2025-12-12 03:58:26'),
(17, 'jhyraadmin', '2', '2025-12-12 04:01:40'),
(17, 'jhyraadmin', '2', '2025-12-12 04:04:08'),
(24, 'gmvl', '1', '2025-12-12 04:04:33'),
(17, 'jhyraadmin', '2', '2025-12-12 04:11:30'),
(18, 'Jhyra', '1', '2025-12-12 04:11:59'),
(20, 'Kevin', '1', '2025-12-12 04:15:48'),
(17, 'jhyraadmin', '2', '2025-12-12 04:24:51'),
(18, 'Jhyra', '1', '2025-12-12 04:36:53'),
(25, 'luisa', '1', '2025-12-12 04:37:46'),
(18, 'Jhyra', '1', '2025-12-12 05:10:19'),
(13, 'santos', '3', '2025-12-12 05:11:14'),
(18, 'Jhyra', '1', '2025-12-12 05:12:40'),
(13, 'santos', '3', '2025-12-12 05:27:59'),
(18, 'Jhyra', '1', '2025-12-12 05:28:42'),
(17, 'jhyraadmin', '2', '2025-12-12 08:33:09'),
(13, 'santos', '3', '2025-12-12 10:15:04'),
(17, 'jhyraadmin', '2', '2025-12-12 10:53:22'),
(26, 'emman', '1', '2025-12-12 10:55:58'),
(13, 'santos', '3', '2025-12-12 11:07:48'),
(17, 'jhyraadmin', '2', '2026-01-18 13:58:48'),
(13, 'santos', '3', '2026-01-18 14:01:00'),
(13, 'santos', '3', '2026-01-18 14:02:32'),
(27, 'jhy', '1', '2026-01-18 14:05:22'),
(17, 'jhyraadmin', '2', '2026-01-18 14:05:47'),
(17, 'jhyraadmin', '2', '2026-01-18 14:07:21'),
(17, 'jhyraadmin', '2', '2026-01-19 07:04:47'),
(27, 'jhy', '1', '2026-01-19 07:22:34'),
(27, 'jhy', '1', '2026-01-19 11:37:02'),
(27, 'jhy', '1', '2026-01-21 10:03:58'),
(27, 'jhy', '1', '2026-01-21 10:25:24'),
(27, 'jhy', '1', '2026-02-02 04:40:17'),
(17, 'jhyraadmin', '2', '2026-02-02 09:08:32'),
(17, 'jhyraadmin', '2', '2026-02-02 09:34:28'),
(27, 'jhy', '1', '2026-02-07 06:38:16'),
(17, 'jhyraadmin', '2', '2026-02-07 06:45:17'),
(27, 'jhy', '1', '2026-02-07 08:12:31'),
(27, 'jhy', '1', '2026-02-07 11:25:44'),
(29, 'Gmm123', '1', '2026-02-07 11:31:28'),
(27, 'jhy', '1', '2026-02-11 14:28:35'),
(17, 'jhyraadmin', '2', '2026-02-11 14:29:35');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_audit_trail`
--

CREATE TABLE `tbl_audit_trail` (
  `trail_user_id` int(11) DEFAULT NULL,
  `trail_username` varchar(50) DEFAULT NULL,
  `trail_activity` varchar(50) DEFAULT NULL,
  `trail_user_type` varchar(50) DEFAULT NULL,
  `trail_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_audit_trail`
--

INSERT INTO `tbl_audit_trail` (`trail_user_id`, `trail_username`, `trail_activity`, `trail_user_type`, `trail_date`) VALUES
(6, 'admin', 'Deactivated Account ID: 3', 'Admin', '2024-12-11 11:59:31'),
(8, 'jcdavid123', 'Updated Service ID: 30', 'Admin', '2025-10-19 10:31:59'),
(8, 'jcdavid123', 'Updated Service ID: 30', 'Admin', '2025-10-19 10:32:09'),
(8, 'jcdavid123', 'Deleted Service ID: 37', 'Admin', '2025-10-19 11:37:46'),
(8, 'jcdavid123', 'Updated Service ID: 1', 'Admin', '2025-10-19 11:43:23'),
(8, 'jcdavid123', 'Updated Service ID: 1', 'Admin', '2025-10-19 11:44:53'),
(8, 'jcdavid123', 'Added Product: Chicken Wings', 'Admin', '2025-11-05 13:30:32'),
(8, 'jcdavid123', 'Added Product: Chicken Wings', 'Admin', '2025-11-05 13:38:18'),
(8, 'jcdavid123', 'Updated Product ID: 20', 'Admin', '2025-11-05 13:48:15'),
(8, 'jcdavid123', 'Updated Product ID: 20', 'Admin', '2025-11-05 13:48:24'),
(8, 'jcdavid123', 'Updated Product ID: 20', 'Admin', '2025-11-05 14:01:32'),
(8, 'jcdavid123', 'Deactivated Account ID: 1', 'Admin', '2025-11-05 14:16:57'),
(8, 'jcdavid123', 'Deactivated Account ID: 1', 'Admin', '2025-11-05 14:20:13'),
(8, 'jcdavid123', 'Deactivated Account ID: 1', 'Admin', '2025-12-08 09:59:50'),
(17, 'jhyraadmin', 'Updated Service ID: 30', 'Admin', '2025-12-12 05:05:40'),
(17, 'jhyraadmin', 'Deactivated Account ID: 23', 'Admin', '2025-12-12 08:54:45'),
(17, 'jhyraadmin', 'Deactivated Account ID: 23', 'Admin', '2025-12-12 08:54:54'),
(17, 'jhyraadmin', 'Added Product: Spaghetti', 'Admin', '2025-12-12 11:02:00'),
(17, 'jhyraadmin', 'Deleted Service ID: 30', 'Admin', '2025-12-12 11:18:46'),
(17, 'jhyraadmin', 'Deleted Service ID: 14', 'Admin', '2025-12-12 11:19:56'),
(17, 'jhyraadmin', 'Updated Service ID: 1', 'Admin', '2026-02-02 09:22:02'),
(17, 'jhyraadmin', 'Updated Service ID: 29', 'Admin', '2026-02-02 09:35:26'),
(17, 'jhyraadmin', 'Updated Service ID: 21', 'Admin', '2026-02-02 09:39:22'),
(17, 'jhyraadmin', 'Updated Service ID: 22', 'Admin', '2026-02-02 09:39:48'),
(17, 'jhyraadmin', 'Updated Service ID: 20', 'Admin', '2026-02-02 09:40:19'),
(17, 'jhyraadmin', 'Updated Service ID: 23', 'Admin', '2026-02-02 09:40:54'),
(17, 'jhyraadmin', 'Updated Service ID: 24', 'Admin', '2026-02-02 09:41:18'),
(17, 'jhyraadmin', 'Updated Service ID: 25', 'Admin', '2026-02-02 09:41:43'),
(17, 'jhyraadmin', 'Updated Service ID: 26', 'Admin', '2026-02-02 09:42:03'),
(17, 'jhyraadmin', 'Updated Service ID: 27', 'Admin', '2026-02-02 09:43:09'),
(17, 'jhyraadmin', 'Updated Service ID: 13', 'Admin', '2026-02-02 09:44:31'),
(17, 'jhyraadmin', 'Updated Service ID: 12', 'Admin', '2026-02-02 09:44:48'),
(17, 'jhyraadmin', 'Updated Service ID: 11', 'Admin', '2026-02-02 09:45:05'),
(17, 'jhyraadmin', 'Updated Service ID: 8', 'Admin', '2026-02-02 09:46:22'),
(17, 'jhyraadmin', 'Updated Service ID: 7', 'Admin', '2026-02-02 09:46:48'),
(17, 'jhyraadmin', 'Updated Service ID: 35', 'Admin', '2026-02-02 09:48:23'),
(17, 'jhyraadmin', 'Updated Service ID: 34', 'Admin', '2026-02-02 09:48:43'),
(17, 'jhyraadmin', 'Updated Service ID: 33', 'Admin', '2026-02-02 09:49:05'),
(17, 'jhyraadmin', 'Updated Service ID: 15', 'Admin', '2026-02-02 09:49:54'),
(17, 'jhyraadmin', 'Updated Service ID: 16', 'Admin', '2026-02-02 09:50:28'),
(17, 'jhyraadmin', 'Deleted Service ID: 28', 'Admin', '2026-02-07 06:51:54'),
(17, 'jhyraadmin', 'Updated Service ID: 36', 'Admin', '2026-02-07 06:54:00'),
(17, 'jhyraadmin', 'Updated Service ID: 32', 'Admin', '2026-02-07 06:54:24'),
(17, 'jhyraadmin', 'Deleted Service ID: 31', 'Admin', '2026-02-07 06:55:21'),
(17, 'jhyraadmin', 'Updated Service ID: 10', 'Admin', '2026-02-07 06:56:00'),
(17, 'jhyraadmin', 'Deleted Service ID: 9', 'Admin', '2026-02-07 06:56:23'),
(17, 'jhyraadmin', 'Updated Service ID: 2', 'Admin', '2026-02-07 06:56:50'),
(17, 'jhyraadmin', 'Updated Service ID: 3', 'Admin', '2026-02-07 06:57:08'),
(17, 'jhyraadmin', 'Updated Service ID: 4', 'Admin', '2026-02-07 06:57:27'),
(17, 'jhyraadmin', 'Updated Service ID: 5', 'Admin', '2026-02-07 06:57:45'),
(17, 'jhyraadmin', 'Updated Service ID: 6', 'Admin', '2026-02-07 06:58:07'),
(17, 'jhyraadmin', 'Updated Service ID: 19', 'Admin', '2026-02-07 07:00:04'),
(17, 'jhyraadmin', 'Updated Service ID: 18', 'Admin', '2026-02-07 07:00:54'),
(17, 'jhyraadmin', 'Updated Service ID: 17', 'Admin', '2026-02-07 07:01:15'),
(17, 'jhyraadmin', 'Deleted Product: Spaghetti (ID: 21)', 'Admin', '2026-02-11 14:38:25');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_best_seller`
--

CREATE TABLE `tbl_best_seller` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `concern_id` int(11) NOT NULL,
  `ingredients_id` int(11) NOT NULL,
  `prod_stocks` int(11) NOT NULL,
  `prod_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_billing_details`
--

CREATE TABLE `tbl_billing_details` (
  `ac_details_id` int(11) NOT NULL,
  `ac_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `unit_number` varchar(50) NOT NULL,
  `barangay` varchar(50) NOT NULL,
  `postal_code` varchar(20) NOT NULL,
  `city` varchar(50) NOT NULL,
  `region` varchar(20) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `payment_type_id` int(11) NOT NULL,
  `delivery_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_billing_details`
--

INSERT INTO `tbl_billing_details` (`ac_details_id`, `ac_id`, `email`, `first_name`, `middle_name`, `last_name`, `unit_number`, `barangay`, `postal_code`, `city`, `region`, `phone_number`, `payment_type_id`, `delivery_type_id`) VALUES
(1, 4, 'lelouch@gmail.com', 'lelouch', NULL, 'luoda', 'Rosal', 'Sabang', '3006', 'Baliuag', 'Region 4', '', 1, 1),
(2, 18, 'jhyramarie281@gmail.com', 'Jhyra', NULL, 'Mariano', '#12 mindanao ave', 'qc', '1112', 'Baliwag', 'Region 2', '09773200369', 1, 1),
(3, 24, 'gma@gmail.com', 'Glenn Mar', NULL, 'Lagutan', 'c', 'c', 'c', 'Baliwag', 'Region 2', '09773200369', 1, 1),
(4, 20, 'kevin@gmail.com', 'Kevin', NULL, 'Mendoza', '#12 mindanao ave', 'cq', '1112', 'qc', 'Region 2', '09773200369', 1, 1),
(5, 25, 'luisa@gmail.com', 'Luisa', NULL, 'Mariano', 'qc', 'qc', '1112', 'qc', 'Region 2', '09773200369', 1, 2),
(6, 26, 'emman@gmail.com', 'emman', NULL, 'galupo', '1', '1', '1', 'qc', 'Region 2', '09773200369', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart`
--

CREATE TABLE `tbl_cart` (
  `item_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `prod_qnty` int(11) NOT NULL,
  `order_date` date DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cart`
--

INSERT INTO `tbl_cart` (`item_id`, `prod_id`, `prod_qnty`, `order_date`, `status_id`, `account_id`) VALUES
(1, 8, 1, '2024-12-11', 5, 4),
(2, 14, 1, '2024-12-11', 5, 4),
(3, 9, 1, '2024-12-11', 5, 4),
(4, 3, 1, '2024-09-11', 5, 4),
(5, 8, 1, '2024-12-11', 2, 2),
(6, 7, 1, '2024-12-11', 2, 2),
(10, 17, 1, '2025-10-21', 5, 12),
(13, 2, 1, '2025-10-21', 5, 12),
(14, 1, 1, '2025-10-21', 5, 12),
(15, 3, 1, '2025-10-21', 5, 12),
(17, 4, 1, '2025-11-05', 2, 12),
(18, 1, 1, '2025-11-05', 2, 12),
(21, 12, 1, '2025-12-10', 2, 18),
(22, 5, 3, '2025-12-11', 2, 18),
(23, 8, 1, '2025-12-11', 2, 18),
(24, 8, 1, '2025-12-11', 2, 18),
(25, 1, 3, '2025-12-11', 2, 18),
(26, 5, 1, '2025-12-11', 2, 18),
(27, 1, 3, '2025-12-11', 2, 18),
(28, 14, 2, '2025-12-11', 2, 18),
(29, 5, 1, '2025-12-12', 2, 18),
(30, 5, 1, '2025-12-12', 2, 24),
(31, 3, 2, '2025-12-12', 2, 24),
(32, 15, 1, '2025-12-12', 2, 18),
(33, 14, 1, '2025-12-12', 2, 20),
(34, 5, 1, '2025-12-12', 2, 20),
(35, 1, 1, '2025-12-12', 3, 25),
(36, 5, 1, '2025-12-12', 3, 25),
(37, 5, 1, NULL, 1, 18),
(38, 1, 1, '2025-12-12', 2, 26),
(39, 21, 1, '2025-12-12', 2, 26),
(40, 1, 1, NULL, 1, 26),
(41, 1, 4, NULL, 1, 27),
(43, 15, 3, NULL, 1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart_vouchers`
--

CREATE TABLE `tbl_cart_vouchers` (
  `cart_voucher_id` int(11) NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_date` date DEFAULT NULL,
  `status_id` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cart_vouchers`
--

INSERT INTO `tbl_cart_vouchers` (`cart_voucher_id`, `voucher_id`, `account_id`, `added_date`, `order_date`, `status_id`) VALUES
(4, 2, 12, '2025-10-21 06:16:42', '2025-11-05', 2),
(5, 4, 18, '2025-12-10 13:41:34', NULL, 3),
(6, 4, 18, '2025-12-10 13:45:00', NULL, 3),
(7, 4, 18, '2025-12-10 13:54:32', NULL, 3),
(8, 4, 18, '2025-12-11 15:19:22', NULL, 3),
(9, 4, 18, '2025-12-11 16:36:22', NULL, 3),
(10, 4, 24, '2025-12-12 04:04:42', NULL, 3),
(16, 4, 25, '2025-12-12 04:39:33', NULL, 3),
(18, 4, 26, '2025-12-12 10:58:16', NULL, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_concern`
--

CREATE TABLE `tbl_concern` (
  `concern_id` int(11) NOT NULL,
  `concern_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_concern`
--

INSERT INTO `tbl_concern` (`concern_id`, `concern_name`) VALUES
(1, 'Acne'),
(2, 'Acne Scars'),
(3, 'Open Pores'),
(4, 'Pigmentation');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_us`
--

CREATE TABLE `tbl_contact_us` (
  `comment_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_delivery_type`
--

CREATE TABLE `tbl_delivery_type` (
  `delivery_type_id` int(11) NOT NULL,
  `delivery_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_delivery_type`
--

INSERT INTO `tbl_delivery_type` (`delivery_type_id`, `delivery_type`) VALUES
(1, 'ship'),
(2, 'pickup');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dermatologists`
--

CREATE TABLE `tbl_dermatologists` (
  `derm_id` int(11) NOT NULL,
  `ac_id` int(11) DEFAULT NULL,
  `derm_name` varchar(100) NOT NULL,
  `derm_specialization` varchar(255) DEFAULT NULL,
  `derm_image` varchar(255) DEFAULT NULL,
  `derm_status` enum('Active','Inactive') DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_dermatologists`
--

INSERT INTO `tbl_dermatologists` (`derm_id`, `ac_id`, `derm_name`, `derm_specialization`, `derm_image`, `derm_status`) VALUES
(1, 13, 'Dr. Maria Santos', 'Cosmetic Dermatology', 'derm_1_1765517291.png', 'Active'),
(5, 28, 'Dr. Alexin Parapina', 'Cosmetic Dermatology', NULL, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_derm_schedule`
--

CREATE TABLE `tbl_derm_schedule` (
  `schedule_id` int(11) NOT NULL,
  `derm_id` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `time_slot` time NOT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `max_bookings` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_derm_schedule`
--

INSERT INTO `tbl_derm_schedule` (`schedule_id`, `derm_id`, `schedule_date`, `time_slot`, `is_available`, `max_bookings`) VALUES
(1, 1, '2025-10-20', '09:00:00', 1, 20),
(2, 1, '2025-10-20', '10:00:00', 1, 20),
(3, 1, '2025-10-20', '11:00:00', 1, 20),
(4, 1, '2025-10-20', '12:00:00', 1, 20),
(5, 1, '2025-10-20', '13:00:00', 1, 20),
(6, 1, '2025-10-20', '14:00:00', 1, 20),
(7, 1, '2025-10-20', '15:00:00', 1, 20),
(8, 1, '2025-10-20', '16:00:00', 1, 20),
(9, 1, '2025-10-20', '17:00:00', 1, 20),
(10, 1, '2025-10-21', '09:00:00', 1, 20),
(11, 1, '2025-10-21', '10:00:00', 1, 20),
(12, 1, '2025-10-21', '11:00:00', 1, 20),
(13, 1, '2025-10-21', '12:00:00', 1, 20),
(14, 1, '2025-10-21', '13:00:00', 1, 20),
(15, 1, '2025-10-21', '14:00:00', 1, 20),
(16, 1, '2025-10-21', '15:00:00', 1, 20),
(17, 1, '2025-10-21', '16:00:00', 1, 20),
(18, 1, '2025-10-21', '17:00:00', 1, 20),
(19, 1, '2025-10-22', '09:00:00', 1, 20),
(20, 1, '2025-10-22', '10:00:00', 1, 20),
(21, 1, '2025-10-22', '11:00:00', 1, 20),
(22, 1, '2025-10-22', '12:00:00', 1, 20),
(23, 1, '2025-10-22', '13:00:00', 1, 20),
(24, 1, '2025-10-22', '14:00:00', 1, 20),
(25, 1, '2025-10-22', '15:00:00', 1, 20),
(26, 1, '2025-10-22', '16:00:00', 1, 20),
(27, 1, '2025-10-22', '17:00:00', 1, 20),
(28, 1, '2025-10-23', '09:00:00', 1, 20),
(29, 1, '2025-10-23', '10:00:00', 1, 20),
(30, 1, '2025-10-23', '11:00:00', 1, 20),
(31, 1, '2025-10-23', '12:00:00', 1, 20),
(32, 1, '2025-10-23', '13:00:00', 1, 20),
(33, 1, '2025-10-23', '14:00:00', 1, 20),
(34, 1, '2025-10-23', '15:00:00', 1, 20),
(35, 1, '2025-10-23', '16:00:00', 1, 20),
(36, 1, '2025-10-23', '17:00:00', 1, 20),
(37, 1, '2025-10-24', '09:00:00', 1, 20),
(38, 1, '2025-10-24', '10:00:00', 1, 20),
(39, 1, '2025-10-24', '11:00:00', 1, 20),
(40, 1, '2025-10-24', '12:00:00', 1, 20),
(41, 1, '2025-10-24', '13:00:00', 1, 20),
(42, 1, '2025-10-24', '14:00:00', 1, 20),
(43, 1, '2025-10-24', '15:00:00', 1, 20),
(44, 1, '2025-10-24', '16:00:00', 1, 20),
(45, 1, '2025-10-24', '17:00:00', 1, 20),
(46, 1, '2025-10-25', '09:00:00', 1, 20),
(47, 1, '2025-10-25', '10:00:00', 1, 20),
(48, 1, '2025-10-25', '11:00:00', 1, 20),
(49, 1, '2025-10-25', '12:00:00', 1, 20),
(50, 1, '2025-10-25', '13:00:00', 1, 20),
(51, 1, '2025-10-25', '14:00:00', 1, 20),
(52, 1, '2025-10-25', '15:00:00', 1, 20),
(53, 1, '2025-10-25', '16:00:00', 1, 20),
(54, 1, '2025-10-25', '17:00:00', 1, 20),
(55, 1, '2025-10-27', '09:00:00', 1, 20),
(56, 1, '2025-10-27', '10:00:00', 1, 20),
(57, 1, '2025-10-27', '11:00:00', 1, 20),
(58, 1, '2025-10-27', '12:00:00', 1, 20),
(59, 1, '2025-10-27', '13:00:00', 1, 20),
(60, 1, '2025-10-27', '14:00:00', 1, 20),
(61, 1, '2025-10-27', '15:00:00', 1, 20),
(62, 1, '2025-10-27', '16:00:00', 1, 20),
(63, 1, '2025-10-27', '17:00:00', 1, 20),
(64, 1, '2025-10-28', '09:00:00', 1, 20),
(65, 1, '2025-10-28', '10:00:00', 1, 20),
(66, 1, '2025-10-28', '11:00:00', 1, 20),
(67, 1, '2025-10-28', '12:00:00', 1, 20),
(68, 1, '2025-10-28', '13:00:00', 1, 20),
(69, 1, '2025-10-28', '14:00:00', 1, 20),
(70, 1, '2025-10-28', '15:00:00', 1, 20),
(71, 1, '2025-10-28', '16:00:00', 1, 20),
(72, 1, '2025-10-28', '17:00:00', 1, 20),
(73, 1, '2025-10-29', '09:00:00', 1, 20),
(74, 1, '2025-10-29', '10:00:00', 1, 20),
(75, 1, '2025-10-29', '11:00:00', 1, 20),
(76, 1, '2025-10-29', '12:00:00', 1, 20),
(77, 1, '2025-10-29', '13:00:00', 1, 20),
(78, 1, '2025-10-29', '14:00:00', 1, 20),
(79, 1, '2025-10-29', '15:00:00', 1, 20),
(80, 1, '2025-10-29', '16:00:00', 1, 20),
(81, 1, '2025-10-29', '17:00:00', 1, 20),
(82, 1, '2025-10-30', '09:00:00', 1, 20),
(83, 1, '2025-10-30', '10:00:00', 1, 20),
(84, 1, '2025-10-30', '11:00:00', 1, 20),
(85, 1, '2025-10-30', '12:00:00', 1, 20),
(86, 1, '2025-10-30', '13:00:00', 1, 20),
(87, 1, '2025-10-30', '14:00:00', 1, 20),
(88, 1, '2025-10-30', '15:00:00', 1, 20),
(89, 1, '2025-10-30', '16:00:00', 1, 20),
(90, 1, '2025-10-30', '17:00:00', 1, 20),
(91, 1, '2025-10-31', '09:00:00', 1, 20),
(92, 1, '2025-10-31', '10:00:00', 1, 20),
(93, 1, '2025-10-31', '11:00:00', 1, 20),
(94, 1, '2025-10-31', '12:00:00', 1, 20),
(95, 1, '2025-10-31', '13:00:00', 1, 20),
(96, 1, '2025-10-31', '14:00:00', 1, 20),
(97, 1, '2025-10-31', '15:00:00', 1, 20),
(98, 1, '2025-10-31', '16:00:00', 1, 20),
(99, 1, '2025-10-31', '17:00:00', 1, 20),
(100, 1, '2025-11-01', '09:00:00', 1, 20),
(101, 1, '2025-11-01', '10:00:00', 1, 20),
(102, 1, '2025-11-01', '11:00:00', 1, 20),
(103, 1, '2025-11-01', '12:00:00', 1, 20),
(104, 1, '2025-11-01', '13:00:00', 1, 20),
(105, 1, '2025-11-01', '14:00:00', 1, 20),
(106, 1, '2025-11-01', '15:00:00', 1, 20),
(107, 1, '2025-11-01', '16:00:00', 1, 20),
(108, 1, '2025-11-01', '17:00:00', 1, 20),
(109, 1, '2025-11-03', '09:00:00', 1, 20),
(110, 1, '2025-11-03', '10:00:00', 1, 20),
(111, 1, '2025-11-03', '11:00:00', 1, 20),
(112, 1, '2025-11-03', '12:00:00', 1, 20),
(113, 1, '2025-11-03', '13:00:00', 1, 20),
(114, 1, '2025-11-03', '14:00:00', 1, 20),
(115, 1, '2025-11-03', '15:00:00', 1, 20),
(116, 1, '2025-11-03', '16:00:00', 1, 20),
(117, 1, '2025-11-03', '17:00:00', 1, 20),
(118, 1, '2025-11-04', '09:00:00', 1, 20),
(119, 1, '2025-11-04', '10:00:00', 1, 20),
(120, 1, '2025-11-04', '11:00:00', 1, 20),
(121, 1, '2025-11-04', '12:00:00', 1, 20),
(122, 1, '2025-11-04', '13:00:00', 1, 20),
(123, 1, '2025-11-04', '14:00:00', 1, 20),
(124, 1, '2025-11-04', '15:00:00', 1, 20),
(125, 1, '2025-11-04', '16:00:00', 1, 20),
(126, 1, '2025-11-04', '17:00:00', 1, 20),
(127, 1, '2025-11-05', '09:00:00', 1, 20),
(128, 1, '2025-11-05', '10:00:00', 1, 20),
(129, 1, '2025-11-05', '11:00:00', 1, 20),
(130, 1, '2025-11-05', '12:00:00', 1, 20),
(131, 1, '2025-11-05', '13:00:00', 1, 20),
(132, 1, '2025-11-05', '14:00:00', 1, 20),
(133, 1, '2025-11-05', '15:00:00', 1, 20),
(134, 1, '2025-11-05', '16:00:00', 1, 20),
(135, 1, '2025-11-05', '17:00:00', 1, 20),
(136, 1, '2025-11-06', '09:00:00', 1, 20),
(137, 1, '2025-11-06', '10:00:00', 1, 20),
(138, 1, '2025-11-06', '11:00:00', 1, 20),
(139, 1, '2025-11-06', '12:00:00', 1, 20),
(140, 1, '2025-11-06', '13:00:00', 1, 20),
(141, 1, '2025-11-06', '14:00:00', 1, 20),
(142, 1, '2025-11-06', '15:00:00', 1, 20),
(143, 1, '2025-11-06', '16:00:00', 1, 20),
(144, 1, '2025-11-06', '17:00:00', 1, 20),
(145, 1, '2025-11-07', '09:00:00', 1, 20),
(146, 1, '2025-11-07', '10:00:00', 1, 20),
(147, 1, '2025-11-07', '11:00:00', 1, 20),
(148, 1, '2025-11-07', '12:00:00', 1, 20),
(149, 1, '2025-11-07', '13:00:00', 1, 20),
(150, 1, '2025-11-07', '14:00:00', 1, 20),
(151, 1, '2025-11-07', '15:00:00', 1, 20),
(152, 1, '2025-11-07', '16:00:00', 1, 20),
(153, 1, '2025-11-07', '17:00:00', 1, 20),
(154, 1, '2025-11-08', '09:00:00', 1, 20),
(155, 1, '2025-11-08', '10:00:00', 1, 20),
(156, 1, '2025-11-08', '11:00:00', 1, 20),
(157, 1, '2025-11-08', '12:00:00', 1, 20),
(158, 1, '2025-11-08', '13:00:00', 1, 20),
(159, 1, '2025-11-08', '14:00:00', 1, 20),
(160, 1, '2025-11-08', '15:00:00', 1, 20),
(161, 1, '2025-11-08', '16:00:00', 1, 20),
(162, 1, '2025-11-08', '17:00:00', 1, 20),
(163, 1, '2025-11-10', '09:00:00', 1, 20),
(164, 1, '2025-11-10', '10:00:00', 1, 20),
(165, 1, '2025-11-10', '11:00:00', 1, 20),
(166, 1, '2025-11-10', '12:00:00', 1, 20),
(167, 1, '2025-11-10', '13:00:00', 1, 20),
(168, 1, '2025-11-10', '14:00:00', 1, 20),
(169, 1, '2025-11-10', '15:00:00', 1, 20),
(170, 1, '2025-11-10', '16:00:00', 1, 20),
(171, 1, '2025-11-10', '17:00:00', 1, 20),
(172, 1, '2025-11-11', '09:00:00', 1, 20),
(173, 1, '2025-11-11', '10:00:00', 1, 20),
(174, 1, '2025-11-11', '11:00:00', 1, 20),
(175, 1, '2025-11-11', '12:00:00', 1, 20),
(176, 1, '2025-11-11', '13:00:00', 1, 20),
(177, 1, '2025-11-11', '14:00:00', 1, 20),
(178, 1, '2025-11-11', '15:00:00', 1, 20),
(179, 1, '2025-11-11', '16:00:00', 1, 20),
(180, 1, '2025-11-11', '17:00:00', 1, 20),
(181, 1, '2025-11-12', '09:00:00', 1, 20),
(182, 1, '2025-11-12', '10:00:00', 1, 20),
(183, 1, '2025-11-12', '11:00:00', 1, 20),
(184, 1, '2025-11-12', '12:00:00', 1, 20),
(185, 1, '2025-11-12', '13:00:00', 1, 20),
(186, 1, '2025-11-12', '14:00:00', 1, 20),
(187, 1, '2025-11-12', '15:00:00', 1, 20),
(188, 1, '2025-11-12', '16:00:00', 1, 20),
(189, 1, '2025-11-12', '17:00:00', 1, 20),
(190, 1, '2025-11-13', '09:00:00', 1, 20),
(191, 1, '2025-11-13', '10:00:00', 1, 20),
(192, 1, '2025-11-13', '11:00:00', 1, 20),
(193, 1, '2025-11-13', '12:00:00', 1, 20),
(194, 1, '2025-11-13', '13:00:00', 1, 20),
(195, 1, '2025-11-13', '14:00:00', 1, 20),
(196, 1, '2025-11-13', '15:00:00', 1, 20),
(197, 1, '2025-11-13', '16:00:00', 1, 20),
(198, 1, '2025-11-13', '17:00:00', 1, 20),
(199, 1, '2025-11-14', '09:00:00', 1, 20),
(200, 1, '2025-11-14', '10:00:00', 1, 20),
(201, 1, '2025-11-14', '11:00:00', 1, 20),
(202, 1, '2025-11-14', '12:00:00', 1, 20),
(203, 1, '2025-11-14', '13:00:00', 1, 20),
(204, 1, '2025-11-14', '14:00:00', 1, 20),
(205, 1, '2025-11-14', '15:00:00', 1, 20),
(206, 1, '2025-11-14', '16:00:00', 1, 20),
(207, 1, '2025-11-14', '17:00:00', 1, 20),
(208, 1, '2025-11-15', '09:00:00', 1, 20),
(209, 1, '2025-11-15', '10:00:00', 1, 20),
(210, 1, '2025-11-15', '11:00:00', 1, 20),
(211, 1, '2025-11-15', '12:00:00', 1, 20),
(212, 1, '2025-11-15', '13:00:00', 1, 20),
(213, 1, '2025-11-15', '14:00:00', 1, 20),
(214, 1, '2025-11-15', '15:00:00', 1, 20),
(215, 1, '2025-11-15', '16:00:00', 1, 20),
(216, 1, '2025-11-15', '17:00:00', 1, 20),
(217, 1, '2025-11-17', '09:00:00', 1, 20),
(218, 1, '2025-11-17', '10:00:00', 1, 20),
(219, 1, '2025-11-17', '11:00:00', 1, 20),
(220, 1, '2025-11-17', '12:00:00', 1, 20),
(221, 1, '2025-11-17', '13:00:00', 1, 20),
(222, 1, '2025-11-17', '14:00:00', 1, 20),
(223, 1, '2025-11-17', '15:00:00', 1, 20),
(224, 1, '2025-11-17', '16:00:00', 1, 20),
(225, 1, '2025-11-17', '17:00:00', 1, 20),
(226, 1, '2025-11-18', '09:00:00', 1, 20),
(227, 1, '2025-11-18', '10:00:00', 1, 20),
(228, 1, '2025-11-18', '11:00:00', 1, 20),
(229, 1, '2025-11-18', '12:00:00', 1, 20),
(230, 1, '2025-11-18', '13:00:00', 1, 20),
(231, 1, '2025-11-18', '14:00:00', 1, 20),
(232, 1, '2025-11-18', '15:00:00', 1, 20),
(233, 1, '2025-11-18', '16:00:00', 1, 20),
(234, 1, '2025-11-18', '17:00:00', 1, 20),
(703, 1, '2025-12-04', '17:25:00', 1, 1),
(704, 1, '2025-12-04', '18:25:00', 1, 1),
(705, 1, '2025-12-15', '12:25:00', 1, 1),
(706, 1, '2025-12-16', '10:40:00', 1, 1),
(707, 1, '2025-12-16', '13:40:00', 1, 1),
(708, 1, '2025-12-13', '01:10:00', 1, 1),
(709, 1, '2025-12-13', '14:20:00', 1, 1),
(710, 1, '2025-12-13', '15:15:00', 1, 1),
(711, 1, '2025-12-13', '16:15:00', 1, 1),
(712, 1, '2025-12-17', '08:08:00', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ingredients`
--

CREATE TABLE `tbl_ingredients` (
  `ingredients_id` int(11) NOT NULL,
  `ingredient_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_ingredients`
--

INSERT INTO `tbl_ingredients` (`ingredients_id`, `ingredient_name`) VALUES
(1, 'Salicylic Acid'),
(2, 'Niacinamide'),
(3, 'Glycolic Acid'),
(4, 'Retinol'),
(5, 'Vitamin C');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item_reviews`
--

CREATE TABLE `tbl_item_reviews` (
  `rv_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `rv_comment` varchar(255) NOT NULL,
  `rating` int(5) NOT NULL,
  `rv_date` date NOT NULL DEFAULT current_timestamp(),
  `ac_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order_vouchers`
--

CREATE TABLE `tbl_order_vouchers` (
  `order_voucher_id` int(11) NOT NULL,
  `receipt_id` int(11) NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL,
  `applied_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_page_reviews`
--

CREATE TABLE `tbl_page_reviews` (
  `review_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `review_title` varchar(100) NOT NULL,
  `rating` decimal(2,1) NOT NULL,
  `review_text` text NOT NULL,
  `reviewer_image` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_page_reviews`
--

INSERT INTO `tbl_page_reviews` (`review_id`, `account_id`, `review_title`, `rating`, `review_text`, `reviewer_image`, `is_verified`, `status`, `created_at`) VALUES
(4, 18, 'Acne & Oily Skin', 5.0, 'After just a few days, I noticed that my skin looked more plump and refreshed, especially in the morning. It also sits really well under makeup—no pilling at all. The mild floral scent is pleasant but not overpowering.', '6937dff565255.png', 0, 'rejected', '2025-12-09 08:38:13'),
(5, 19, 'Dry & Dull Skin', 5.0, 'Rich and nourishing! I use this every night and wake up with soft, bouncy skin. It’s thick, so a little goes a long way. The only downside is that it takes a bit of time to fully absorb, but once it does, it feels luxurious. Great for dry weather.', '6937e7bb637d7.png', 0, 'rejected', '2025-12-09 09:11:23'),
(6, 20, 'Sensitive & Redness-Prone', 5.0, 'I have extremely sensitive skin that turns red even with mild products, but this gel worked wonders. It instantly cooled my skin and reduced redness within minutes. No stinging, no irritation—just pure soothing. Perfect for flare-ups.', '6937e84f17910.png', 0, 'rejected', '2025-12-09 09:13:51'),
(7, 21, 'Acne & Oily Skin', 5.0, 'Very mild and non-foaming, which I love. It cleans my face without leaving it tight or blotchy. My redness around the nose looked slightly calmer after a week. Not great for removing makeup, but excellent as a daily gentle wash.', '6937e92e068d7.png', 0, 'pending', '2025-12-09 09:17:34'),
(8, 18, 'Acne & Oily Skin', 5.0, 'lopit', '693976fdd82db.png', 0, 'rejected', '2025-12-10 13:34:53'),
(9, 18, 'Sensitive & Redness-Prone', 5.0, 'Rich and nourishing! I use this every night and wake up with soft, bouncy skin. It’s thick, so a little goes a long way. The only downside is that it takes a bit of time to fully absorb, but once it does, it feels luxurious. Great for dry weather.', '693b90c96b228.png', 0, 'approved', '2025-12-12 03:49:29'),
(10, 19, 'Acne & Oily Skin', 5.0, 'After just a few days, I noticed that my skin looked more plump and refreshed, especially in the morning. It also sits really well under makeup—no pilling at all. The mild floral scent is pleasant but not overpowering.', '693b9148037a0.png', 0, 'approved', '2025-12-12 03:51:36'),
(11, 20, 'Dry & Dull Skin', 5.0, 'Rich and nourishing! I use this every night and wake up with soft, bouncy skin. It’s thick, so a little goes a long way. The only downside is that it takes a bit of time to fully absorb, but once it does, it feels luxurious. Great for dry weather.', '693b917a12504.png', 0, 'approved', '2025-12-12 03:52:26'),
(12, 23, 'Acne & Oily Skin', 5.0, 'Rich and nourishing! I use this every night and wake up with soft, bouncy skin. It’s thick, so a little goes a long way. The only downside is that it takes a bit of time to fully absorb, but once it does, it feels luxurious. Great for dry weather.', '693b922907e2e.png', 0, 'approved', '2025-12-12 03:55:21'),
(13, 24, 'Sensitive & Redness-Prone', 5.0, 'Rich and nourishing! I use this every night and wake up with soft, bouncy skin. It’s thick, so a little goes a long way. The only downside is that it takes a bit of time to fully absorb, but once it does, it feels luxurious. Great for dry weather.', '693b9314c861c.png', 0, 'approved', '2025-12-12 03:59:16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment_type`
--

CREATE TABLE `tbl_payment_type` (
  `payment_type_id` int(11) NOT NULL,
  `payment_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_payment_type`
--

INSERT INTO `tbl_payment_type` (`payment_type_id`, `payment_type`) VALUES
(1, 'gcash'),
(2, 'cash');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `prod-short-desc` varchar(255) NOT NULL,
  `prod_description` text NOT NULL,
  `concern_id` int(11) NOT NULL,
  `ingredients_id` int(11) NOT NULL,
  `prod_stocks` int(11) NOT NULL,
  `prod_discount` int(11) NOT NULL,
  `prod_img` varchar(255) NOT NULL,
  `prod_hover_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`prod_id`, `prod_name`, `prod_price`, `prod-short-desc`, `prod_description`, `concern_id`, `ingredients_id`, `prod_stocks`, `prod_discount`, `prod_img`, `prod_hover_img`) VALUES
(1, 'Acne Refining Foaming Cleanser', 500, 'Deep Cleansing | Reduces Breakouts', 'DermSignal Acne Refining Foaming Cleanser has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 3, 2, 37, 20, 'prod-1-ref-cleanser.png', 'prod-1-ref-cleanser-hover.png'),
(2, 'Acne Refining Gel', 260, 'Targets Acne | Controls Oil Production', 'DermSignal Acne Refining Gel is a water-based gel that has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 1, 4, 50, 10, 'prod-2-ref-gel.png', 'prod-2-ref-gel-hover.png'),
(3, 'Acne Refining Spot Corrector', 300, 'Precision Treatment | Reduces Pimples Fast', 'DermSignal Acne Refining Spot Corrector is a serum that has a synergistic blend of Iris, Zinc, Vitamin A, Niacinamide, and Salicylic Acid designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 1, 2, 48, 10, 'prod-3-ref-spot.png', 'prod-3-ref-spot-hover.png'),
(4, 'Acne Refining Toner', 450, 'Balances Skin | Minimizes Pores', 'A DermSignal Acne Refining Toner is an alcohol-free toner that has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin.\r\nIt helps in reducing sebum production and acne breakouts.', 1, 1, 49, 10, 'prod-4-ref-toner.png', 'prod-4-ref-toner-hover.png'),
(5, 'Skin Renewal Foaming Cleanser', 460, 'Gentle Cleansing | Refreshes & Revives Skin', 'DermSignal Skin Renewal Foaming Cleanser contains salicylic acid that helps hydrate, remove dirt and excess oil on the face.', 3, 1, 43, 10, 'prod-5-renew-cleanser.png', 'prod-5-renew-cleanser-hover.png'),
(6, 'Skin Renewal Creme', 500, 'Nourishing Hydration | Restores Skin\'s Radiance', 'DermSignal Skin Renewal Creme contains natural AHAs that help increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothen rough skin.', 2, 3, 50, 10, 'prod-6-renew-cream.png', 'prod-6-renew-cream-hover.png'),
(7, 'Skin Renewal Fruit Mix Booster', 340, 'Revitalizing Formula | Boosts Skin Glow', 'DermSignal Skin Renewal Fruit Mix Booster contains natural AHAs. This product helps increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothens rough skin.', 2, 5, 49, 10, 'prod-7-renew-spot.png', 'prod-7-renew-spot-hover.png'),
(8, 'Skin Renewal Tonic', 600, 'Refreshing Toner | Rejuvenates & Hydrates Skin', 'DermSignal Skin Renewal Tonic contains natural AHAs. This product helps increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothens rough skin.', 2, 4, 47, 10, 'prod-8-renew-toner.png', 'prod-8-renew-toner-hover.png'),
(9, 'Skin Lightening Soap', 300, 'Brightening Formula | Evens Skin Tone', 'DermSignal Skin Lightening Soap harnesses the power of Vitamin C, a potent antioxidant known for its brightening and skin-tone-evening properties. This gentle formula helps reduce the appearance of dark spots, leaving your skin looking radiant, smooth, an', 4, 5, 50, 10, 'prod-9-light-soap.png', 'prod-9-light-soap-hover.png'),
(10, 'Skin Lightening Night Booster', 650, 'Overnight Brightening | Reduces Dark Spots', 'DermSignal Skin Lightening Night Booster is enriched with Glycolic Acid, a powerful exfoliant that helps fade dark spots, even out skin tone, and promote a brighter, smoother complexion. Wake up to revitalized, glowing skin as it works overnight to reveal', 4, 3, 50, 15, 'prod-10-light-spot.png', 'prod-10-light-spot-hover.png'),
(11, 'Skin Lightening Toner', 475, 'Clarifying Formula | Evens Skin Tone', 'DermSignal Skin Lightening Toner combines the brightening power of Vitamin C with the exfoliating benefits of Glycolic Acid to gently cleanse, even out skin tone, and reduce the appearance of dark spots. Achieve a refreshed, radiant complexion with this d', 4, 5, 50, 10, 'prod-11-light-toner.png', 'prod-11-light-toner-hover.png'),
(12, '[Rx] TREVISO Isotretinoin 10mg (Box of 30s)', 1500, 'Clear Skin Treatment | Reduces Severe Acne', 'An established prescription acne medication that deactivates hyperactive oil glands: the center of acne pathology. Correct dosing and treatment protocols may give an 80% chance of cure. Ideal for patients who have recurring acne and do not respond to diff', 1, 4, 49, 20, 'prod-12-iso.webp', 'prod-12-iso-hover.png'),
(13, '[Rx] ACRESIL Clindamycin Capsule 300mg (28s)', 560, 'Bacterial Infection Treatment | Effective Antibiotic', '\r\n[Rx] ACRESIL Clindamycin 300mg (28s) is an antibiotic for treating bacterial infections, including skin, respiratory, and bone infections. Use as prescribed by your healthcare provider.', 1, 4, 50, 10, 'prod-13-acresil.jpg', 'prod-13-acre-hover.webp'),
(14, '[Rx] Betamethasone Valerate 1mg/g 0.1% (w/w) Topical Cream 15g', 380, 'Inflammation Relief | Reduces Skin Redness & Itching', '[Rx] Betamethasone Valerate 0.1% Topical Cream (15g) is a corticosteroid used to relieve inflammation, redness, and itching associated with skin conditions like eczema and psoriasis. Apply as directed by your healthcare provider.', 4, 3, 47, 10, 'prod-14-beta.webp', 'prod-14-beta-hover.webp'),
(15, '[Rx] PIDCLIN Doxycycline Capsule 100mg', 720, 'Broad-Spectrum Antibiotic | Treats Bacterial Infections', '[Rx] PIDCLIN Doxycycline 100mg Capsule is an antibiotic used to treat various bacterial infections, including respiratory, skin, and urinary tract infections. It also treats acne and certain sexually transmitted infections. Use as prescribed by your healt', 1, 4, 49, 10, 'prod-15-doxy.webp', 'prod-15-doxy.webp');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prod_bestseller`
--

CREATE TABLE `tbl_prod_bestseller` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `prod-short-desc` varchar(255) NOT NULL,
  `prod_description` text NOT NULL,
  `concern_id` int(11) NOT NULL,
  `ingredients_id` int(11) NOT NULL,
  `prod_stocks` int(11) NOT NULL,
  `prod_discount` int(11) NOT NULL,
  `prod_img` varchar(255) NOT NULL,
  `prod_hover_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_prod_bestseller`
--

INSERT INTO `tbl_prod_bestseller` (`prod_id`, `prod_name`, `prod_price`, `prod-short-desc`, `prod_description`, `concern_id`, `ingredients_id`, `prod_stocks`, `prod_discount`, `prod_img`, `prod_hover_img`) VALUES
(1, 'Acne Refining Foaming Cleanser', 500, 'Deep Cleansing | Reduces Breakouts', 'DermSignal Acne Refining Foaming Cleanser has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 3, 2, 50, 20, 'prod-1-ref-cleanser.png', 'prod-1-ref-cleanser-hover.png'),
(3, 'Acne Refining Spot Corrector', 300, 'Precision Treatment | Reduces Pimples Fast', 'DermSignal Acne Refining Spot Corrector is a serum that has a synergistic blend of Iris, Zinc, Vitamin A, Niacinamide, and Salicylic Acid designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 1, 2, 50, 10, 'prod-3-ref-spot.png', 'prod-3-ref-spot-hover.png'),
(6, 'Skin Renewal Creme', 500, 'Nourishing Hydration | Restores Skin\'s Radiance', 'DermSignal Skin Renewal Creme contains natural AHAs that help increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothen rough skin.', 2, 3, 50, 10, 'prod-6-renew-cream.png', 'prod-6-renew-cream-hover.webp'),
(7, 'Skin Renewal Fruit Mix Booster', 340, 'Revitalizing Formula | Boosts Skin Glow', 'DermSignal Skin Renewal Fruit Mix Booster contains natural AHAs. This product helps increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothens rough skin.', 2, 5, 50, 10, 'prod-7-renew-spot.png', 'prod-7-renew-spot-hover.png'),
(11, 'Skin Lightening Toner', 475, 'Clarifying Formula | Evens Skin Tone', 'DermSignal Skin Lightening Toner combines the brightening power of Vitamin C with the exfoliating benefits of Glycolic Acid to gently cleanse, even out skin tone, and reduce the appearance of dark spots. Achieve a refreshed, radiant complexion with this d', 4, 5, 50, 10, 'prod-11-light-toner.png', 'prod-11-light-toner-hover.png'),
(12, '[Rx] TREVISO Isotretinoin 10mg (Box of 30s)', 1500, 'Clear Skin Treatment | Reduces Severe Acne', 'An established prescription acne medication that deactivates hyperactive oil glands: the center of acne pathology. Correct dosing and treatment protocols may give an 80% chance of cure. Ideal for patients who have recurring acne and do not respond to diff', 1, 4, 50, 20, 'prod-12-iso.webp', 'prod-12-iso-hover.webp'),
(13, '[Rx] ACRESIL Clindamycin Capsule 300mg (28s)', 560, 'Bacterial Infection Treatment | Effective Antibiotic', '\r\n[Rx] ACRESIL Clindamycin 300mg (28s) is an antibiotic for treating bacterial infections, including skin, respiratory, and bone infections. Use as prescribed by your healthcare provider.', 1, 4, 50, 10, 'prod-13-acresil.jpg', 'prod-13-acre-hover.webp'),
(15, '[Rx] PIDCLIN Doxycycline Capsule 100mg', 720, 'Broad-Spectrum Antibiotic | Treats Bacterial Infections', '[Rx] PIDCLIN Doxycycline 100mg Capsule is an antibiotic used to treat various bacterial infections, including respiratory, skin, and urinary tract infections. It also treats acne and certain sexually transmitted infections. Use as prescribed by your healt', 1, 4, 50, 10, 'prod-15-doxy.webp', 'prod-15-doxy.webp');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prod_newarrivals`
--

CREATE TABLE `tbl_prod_newarrivals` (
  `prod_id` int(11) NOT NULL,
  `prod_name` varchar(255) NOT NULL,
  `prod_price` int(11) NOT NULL,
  `prod-short-desc` varchar(255) NOT NULL,
  `prod_description` text NOT NULL,
  `concern_id` int(11) NOT NULL,
  `ingredients_id` int(11) NOT NULL,
  `prod_stocks` int(11) NOT NULL,
  `prod_discount` int(11) NOT NULL,
  `prod_img` varchar(255) NOT NULL,
  `prod_hover_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_nopad_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_prod_newarrivals`
--

INSERT INTO `tbl_prod_newarrivals` (`prod_id`, `prod_name`, `prod_price`, `prod-short-desc`, `prod_description`, `concern_id`, `ingredients_id`, `prod_stocks`, `prod_discount`, `prod_img`, `prod_hover_img`) VALUES
(2, 'Acne Refining Gel', 260, 'Targets Acne | Controls Oil Production', 'DermSignal Acne Refining Gel is a water-based gel that has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin. It helps in reducing sebum production and acne breakouts.', 1, 4, 50, 10, 'prod-2-ref-gel.png', 'prod-2-ref-gel-hover'),
(4, 'Acne Refining Toner', 450, 'Balances Skin | Minimizes Pores', 'A DermSignal Acne Refining Toner is an alcohol-free toner that has a synergistic blend of Iris, Zinc, Vitamin A, and Niacinamide designed for oily and acne prone skin.\r\nIt helps in reducing sebum production and acne breakouts.', 1, 1, 50, 10, 'prod-4-ref-toner.png', 'prod-4-ref-toner-hover.png'),
(5, 'Skin Renewal Foaming Cleanser', 460, 'Gentle Cleansing | Refreshes & Revives Skin', 'DermSignal Skin Renewal Foaming Cleanser contains salicylic acid that helps hydrate, remove dirt and excess oil on the face.', 3, 1, 50, 10, 'prod-5-renew-cleanser.png', 'prod-5-renew-cleanser-hover.png'),
(7, 'Skin Renewal Fruit Mix Booster', 340, 'Revitalizing Formula | Boosts Skin Glow', 'DermSignal Skin Renewal Fruit Mix Booster contains natural AHAs. This product helps increase the production of collagen and glycosaminoglycan that are responsible for reducing surface wrinkles, fine lines, and smoothens rough skin.', 2, 5, 50, 10, 'prod-7-renew-spot.png', 'prod-7-renew-spot-hover.png'),
(9, 'Skin Lightening Soap', 300, 'Brightening Formula | Evens Skin Tone', 'DermSignal Skin Lightening Soap harnesses the power of Vitamin C, a potent antioxidant known for its brightening and skin-tone-evening properties. This gentle formula helps reduce the appearance of dark spots, leaving your skin looking radiant, smooth, an', 4, 5, 50, 10, 'prod-9-light-soap.png', 'prod-9-light-soap-hover.png'),
(10, 'Skin Lightening Night Booster', 650, 'Overnight Brightening | Reduces Dark Spots', 'DermSignal Skin Lightening Night Booster is enriched with Glycolic Acid, a powerful exfoliant that helps fade dark spots, even out skin tone, and promote a brighter, smoother complexion. Wake up to revitalized, glowing skin as it works overnight to reveal', 4, 3, 50, 15, 'prod-10-light-spot.png', 'prod-10-light-spot-hover.png'),
(11, 'Skin Lightening Toner', 475, 'Clarifying Formula | Evens Skin Tone', 'DermSignal Skin Lightening Toner combines the brightening power of Vitamin C with the exfoliating benefits of Glycolic Acid to gently cleanse, even out skin tone, and reduce the appearance of dark spots. Achieve a refreshed, radiant complexion with this d', 4, 5, 50, 10, 'prod-11-light-toner.png', 'prod-11-light-toner-hover.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ratings`
--

CREATE TABLE `tbl_ratings` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_receipt`
--

CREATE TABLE `tbl_receipt` (
  `receipt_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `receipt_img` varchar(255) NOT NULL,
  `receipt_number` varchar(50) NOT NULL,
  `deposit_amount` int(11) NOT NULL,
  `uploaded_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_receipt`
--

INSERT INTO `tbl_receipt` (`receipt_id`, `account_id`, `receipt_img`, `receipt_number`, `deposit_amount`, `uploaded_date`) VALUES
(1, 4, '6758ec27af450.jpeg', '2332323232176', 3000, '2024-12-11'),
(2, 4, '6758eedbb6917.jpeg', '2332323232176', 3000, '2024-12-11'),
(3, 4, '6758fd69d8467.jpeg', '2332323232176', 1760, '2024-12-11'),
(4, 4, '6758fddbd8a7a.jpeg', '2332323232176', 100, '2024-12-11'),
(5, 4, '675900317d407.jpeg', '2332323232176', 500, '2024-12-11'),
(6, 2, '6759025f2eada.jpeg', '2332323232171', 1760, '2024-12-11'),
(7, 2, '67590bc02f2ce.jpeg', '1222312311331', 3000, '2024-12-11'),
(8, 1, '675915a0ebd77.jpeg', '2332323232171', 1760, '2024-12-11'),
(9, 4, '675926d22d7ba.jpeg', '2332323232176', 1760, '2024-12-11'),
(10, 4, '67592719eaa62.jpeg', '2332323232176', 3000, '2024-12-11'),
(11, 4, '675927ffc19da.jpeg', '2332323232171', 3000, '2024-12-11'),
(12, 4, '67592a5c27ea4.jpeg', '2332323232176', 1760, '2024-12-11'),
(13, 2, '67595422b6619.jpeg', '2332323232171', 3000, '2024-12-11'),
(14, 12, '68f71942cd7e3.jpg', '3212313131313', 847, '2025-10-21'),
(15, 12, '68f721e2d038c.png', '2134214213111', 252, '2025-10-21'),
(16, 12, '68f7238750189.jpg', '3212313131313', 346, '2025-10-21'),
(17, 12, '68f726e390fb8.png', '3212313131313', 336, '2025-10-21'),
(18, 18, '69397903a2f9e.jpg', '1234567890123', 4000, '2025-12-10'),
(19, 18, '69397988b474a.jpg', '1234567890123', 2000, '2025-12-10'),
(20, 18, '693ade0a613d6.jpg', '1234567890123', 2000, '2025-12-11'),
(21, 18, '693ae158a4c9c.jpg', '1234567890123', 3000, '2025-12-11'),
(22, 18, '693af329a0eb0.jpg', '1234567890123', 500, '2025-12-11'),
(23, 24, '693b94a6cc879.jpg', '1234567890123', 600, '2025-12-12'),
(24, 24, '693b94f432a54.jpg', '1234567890123', 600, '2025-12-12'),
(25, 18, '693b96763692c.jpg', '1234567890123', 600, '2025-12-12'),
(26, 20, '693b9786f1305.jpg', '1234567890123', 1000, '2025-12-12'),
(27, 25, '693b9cd38c6b2.jpg', '1234567890123', 600, '2025-12-12'),
(28, 26, '693bf69314094.jpg', '1234567890123', 2200, '2025-12-12');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_role`
--

CREATE TABLE `tbl_role` (
  `role_Id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_role`
--

INSERT INTO `tbl_role` (`role_Id`, `role_name`) VALUES
(1, 'user'),
(2, 'admin'),
(3, 'dermatologist');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_services`
--

CREATE TABLE `tbl_services` (
  `service_id` int(11) NOT NULL,
  `service_name` varchar(100) NOT NULL,
  `service_price` float NOT NULL,
  `sessions` int(11) NOT NULL,
  `procedure_benefits` varchar(255) NOT NULL,
  `service_group` varchar(50) NOT NULL,
  `service_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_services`
--

INSERT INTO `tbl_services` (`service_id`, `service_name`, `service_price`, `sessions`, `procedure_benefits`, `service_group`, `service_image`) VALUES
(1, 'Consultation', 500, 5, 'Dermatologic evaluation and professional treatment recommendations.', 'Consultation', 'dermatologic_botox.jpg'),
(2, 'Acne Facial', 500, 5, 'Reduces inflammation, treats acne, and deeply cleanses the skin to prevent future breakouts.', 'Facial Services', 'acne_facial.png'),
(3, 'Whitening Facial', 500, 5, 'Brightens and evens out skin tone for a radiant complexion.', 'Facial Services', 'whitening_facial.png'),
(4, 'Anti-Aging Facial', 500, 5, 'Reduces wrinkles and fine lines for youthful, firm skin.', 'Facial Services', 'anti-aging_facial.png'),
(5, 'Gold Facial', 500, 5, 'Uses gold-infused products to rejuvenate and revitalize the skin.', 'Facial Services', 'gold_facial.png'),
(6, 'Pore Minimizing Facial', 500, 5, 'Tightens and reduces the appearance of large pores for smoother skin.', 'Facial Services', 'pore_minimizing_facial.png'),
(7, 'Diamond Peel Facial', 700, 5, 'Exfoliates using diamond-tipped tools to remove dead skin cells and improve texture.', 'Facial Services', 'diamondpeel_facial.jpg'),
(8, 'Hydra Facial', 2500, 5, 'Combines cleansing, exfoliation, extraction, hydration, and antioxidant protection for clear, hydrated skin.', 'Facial Services', 'hydra_facial.jpg'),
(10, 'Jet Peel', 1500, 5, 'A non-invasive treatment that exfoliates and hydrates the skin using a jet of air and liquid.', 'Facial Services', 'jet_peel.png'),
(11, 'Whitening Drip', 2500, 5, 'Brightens the skin and promotes an even complexion.', 'DRIPS', 'whitening_drips.jpg'),
(12, 'Anti-Aging Drip', 2500, 5, 'Improves skin elasticity and reduces signs of aging with antioxidants and nutrients.', 'DRIPS', 'antiaging_drips.jpg'),
(13, 'Slimming Drip', 2500, 5, 'Boosts metabolism and supports detoxification for weight management.', 'DRIPS', 'slimming_drip.jpg'),
(15, 'PRP Hair Regrow & Service', 10000, 5, 'Uses platelet-rich plasma to stimulate hair growth, strengthen follicles, and improve scalp health.', 'PRP Hair Treatment', 'prp_hair_regrow_hairtreatment.jpg'),
(16, 'Tattoo Removal', 2500, 5, 'Safely removes unwanted tattoos using laser technology.', 'Q Laser Services', 'q_lazer_tattooremoval.jpg'),
(17, 'Vitiligo Paramedical Tattoo', 20000, 5, 'Camouflages depigmented areas using natural skin-tone pigments.', 'Dermatologic Services', 'dermatologic_vilitigo_paramedica_tattool.jpg'),
(18, 'Stretch Marks Paramedical Tattoo', 20000, 5, 'Covers and blends stretch marks to match the surrounding skin.', 'Dermatologic Services', 'dermatologic_stretchmark_paramedical.jpg'),
(19, 'Nose Augmentation', 20000, 5, 'Enhances the shape and contour of the nose for improved facial harmony.', 'Dermatologic Services', 'geneo_facial.png'),
(20, 'Sclerotherapy', 3000, 5, 'Treats varicose and spider veins by injecting a solution that collapses them.', 'Dermatologic Services', 'dermatologic_sclerotherapy.jpg'),
(21, 'Pimple Injection', 100, 5, 'Reduces inflammation in cystic acne with corticosteroid injections.', 'Dermatologic Services', 'dermatologic_pimpleinjection.jpg'),
(22, 'Keloid Injections', 1000, 5, 'Shrinks keloid scars using corticosteroids.', 'Dermatologic Services', 'dermatologic_keloidinjection.jpg'),
(23, 'COGS or Threads', 20000, 5, 'Tightens sagging skin using specialized lifting threads.', 'Dermatologic Services', 'dermatologic_cogsthreads.jpg'),
(24, 'Warts Removal', 3500, 5, 'Removes warts safely and effectively using dermatologic techniques.', 'Dermatologic Services', 'dermatologic_warts_removal.jpg'),
(25, 'Facenade', 5000, 5, 'Firming and rejuvenation treatment for the face.', 'Dermatologic Services', 'geneo_facial.jpg'),
(26, 'Firming Treatment', 5000, 5, 'Tightens and firms the skin for a more youthful appearance.', 'Dermatologic Services', 'hifu_face.jpg'),
(27, 'V Dissolve', 2500, 5, 'Targets and reduces fat deposits for a more contoured appearance.', 'Dermatologic Services', 'img_3475.jpg'),
(29, 'Profhilo', 30000, 5, 'Hydrates and remodels aging skin using injectable hyaluronic acid.', 'Dermatologic Services', 'dermatologic_profhilo.jpg'),
(32, 'HIFU - Face & Neck', 12000, 5, 'Firms and lifts both facial and neck areas.', 'HIFU', 'hifu_facial_&_neck.png'),
(33, 'HIFU - Arms', 10000, 5, 'Tones and tightens arm skin.', 'HIFU', 'hifu_arms.jpg'),
(34, 'HIFU - Abdomen', 13000, 5, 'Firms and sculpts the abdominal area.', 'HIFU', 'hifu_abdomen.jpg'),
(35, 'HIFU - Waist', 10000, 5, 'Reduces and tightens skin around the waist.', 'HIFU', 'hifu_waist.jpg'),
(36, 'HIFU - Thighs', 15000, 5, 'Tightens and firms the thigh area.', 'HIFU', 'hifu_thighs.png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_status`
--

CREATE TABLE `tbl_status` (
  `status_id` int(11) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_status`
--

INSERT INTO `tbl_status` (`status_id`, `status_name`) VALUES
(1, 'PENDING'),
(2, 'DELIVERED'),
(3, 'PROCESS'),
(4, 'OUT FOR DELIVERY'),
(5, 'CANCELED'),
(6, 'RESERVE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transactions`
--

CREATE TABLE `tbl_transactions` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `user_activity` varchar(100) NOT NULL,
  `activity_date` date NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transactions`
--

INSERT INTO `tbl_transactions` (`user_id`, `user_name`, `user_type`, `user_activity`, `activity_date`, `item_id`) VALUES
(8, 'jcdavid123', '2', 'Set item for delivery', '2025-10-21', 18),
(8, 'jcdavid123', '2', 'Claimed item Acne Refining Foaming Cleanser', '2025-10-21', 18),
(8, 'jcdavid123', '2', 'Claimed item Acne Refining Foaming Cleanser', '2025-10-21', 18),
(8, 'jcdavid123', '2', 'Claimed item Acne Refining Foaming Cleanser', '2025-10-21', 18),
(8, 'jcdavid123', '2', 'Claimed item Acne Refining Foaming Cleanser', '2025-10-21', 18),
(8, 'jcdavid123', '2', 'Claimed item Acne Refining Foaming Cleanser', '2025-10-21', 18),
(8, 'jcdavid123', '2', 'Set item for delivery', '2025-11-05', 17),
(8, 'jcdavid123', '2', 'Claimed item Acne Refining Toner', '2025-11-05', 17),
(8, 'jcdavid123', '2', 'Set item for delivery', '2025-11-05', 18),
(8, 'jcdavid123', '2', 'Claimed item Acne Refining Foaming Cleanser', '2025-11-05', 18),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-10', 21),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-10', 23),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-10', 22),
(17, 'jhyraadmin', '2', 'Claimed item [Rx] TREVISO Isotretinoin 10mg (Box of 30s)', '2025-12-10', 21),
(17, 'jhyraadmin', '2', 'Claimed item Skin Renewal Foaming Cleanser', '2025-12-11', 22),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-11', 25),
(17, 'jhyraadmin', '2', 'Claimed item Acne Refining Foaming Cleanser', '2025-12-11', 25),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-11', 24),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-11', 28),
(17, 'jhyraadmin', '2', 'Claimed item [Rx] Betamethasone Valerate 1mg/g 0.1% (w/w) Topical Cream 15g', '2025-12-11', 28),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-11', 27),
(17, 'jhyraadmin', '2', 'Claimed item Skin Renewal Tonic', '2025-12-11', 24),
(17, 'jhyraadmin', '2', 'Claimed item Acne Refining Foaming Cleanser', '2025-12-11', 27),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-11', 26),
(17, 'jhyraadmin', '2', 'Claimed item Skin Renewal Tonic', '2025-12-11', 23),
(17, 'jhyraadmin', '2', 'Claimed item Skin Renewal Foaming Cleanser', '2025-12-11', 26),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-12', 31),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-12', 30),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-12', 29),
(17, 'jhyraadmin', '2', 'Claimed item Acne Refining Spot Corrector', '2025-12-12', 31),
(17, 'jhyraadmin', '2', 'Claimed item Skin Renewal Foaming Cleanser', '2025-12-12', 30),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-12', 32),
(17, 'jhyraadmin', '2', 'Claimed item [Rx] PIDCLIN Doxycycline Capsule 100mg', '2025-12-12', 32),
(17, 'jhyraadmin', '2', 'Claimed item Skin Renewal Foaming Cleanser', '2025-12-12', 29),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-12', 34),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-12', 33),
(17, 'jhyraadmin', '2', 'Claimed item Skin Renewal Foaming Cleanser', '2025-12-12', 34),
(17, 'jhyraadmin', '2', 'Claimed item [Rx] Betamethasone Valerate 1mg/g 0.1% (w/w) Topical Cream 15g', '2025-12-12', 33),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-12', 39),
(17, 'jhyraadmin', '2', 'Set item for delivery', '2025-12-12', 38),
(17, 'jhyraadmin', '2', 'Claimed item Spaghetti', '2025-12-12', 39),
(17, 'jhyraadmin', '2', 'Claimed item Acne Refining Foaming Cleanser', '2025-12-12', 38);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vouchers`
--

CREATE TABLE `tbl_vouchers` (
  `voucher_id` int(11) NOT NULL,
  `voucher_code` varchar(50) NOT NULL,
  `voucher_name` varchar(255) NOT NULL,
  `voucher_type` enum('product','service','both') NOT NULL DEFAULT 'both',
  `discount_type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `discount_value` decimal(10,2) NOT NULL,
  `min_purchase` decimal(10,2) DEFAULT 0.00,
  `max_discount` decimal(10,2) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) DEFAULT 0,
  `total_revenue_generated` decimal(15,2) DEFAULT 0.00,
  `total_discount_given` decimal(15,2) DEFAULT 0.00,
  `target_items` text DEFAULT NULL COMMENT 'JSON array of product/service IDs',
  `promo_category` varchar(100) DEFAULT NULL COMMENT 'e.g., Anniversary, Holiday, Flash Sale',
  `is_active` tinyint(1) DEFAULT 1,
  `auto_apply` tinyint(1) DEFAULT 0 COMMENT 'Auto-apply on homepage/booking',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_vouchers`
--

INSERT INTO `tbl_vouchers` (`voucher_id`, `voucher_code`, `voucher_name`, `voucher_type`, `discount_type`, `discount_value`, `min_purchase`, `max_discount`, `start_date`, `end_date`, `usage_limit`, `used_count`, `total_revenue_generated`, `total_discount_given`, `target_items`, `promo_category`, `is_active`, `auto_apply`, `created_by`, `created_at`) VALUES
(2, 'BOOSTEABE08', 'Boost Low Performers - Oct 2025', 'both', 'percentage', 25.00, 0.00, 0.00, '2025-10-15', '2025-11-20', 0, 1, 336.00, 120.00, '[{\"type\":\"product\",\"id\":\"1\",\"name\":\"Acne Refining Foaming Cleanser\"},{\"type\":\"product\",\"id\":\"2\",\"name\":\"Acne Refining Gel\"},{\"type\":\"product\",\"id\":\"3\",\"name\":\"Acne Refining Spot Corrector\"},{\"type\":\"product\",\"id\":\"4\",\"name\":\"Acne Refining Toner\"},{\"type\":\"product\",\"id\":\"5\",\"name\":\"Skin Renewal Foaming Cleanser\"}]', 'Special', 0, 0, 8, '2025-10-20 10:39:49'),
(4, 'BDAY123', 'Birthday Sale', 'product', 'percentage', 20.00, 0.00, 500.00, '2025-12-10', '2025-12-13', 0, 0, 0.00, 0.00, '', 'Birthday', 0, 0, 17, '2025-12-10 13:40:11'),
(7, 'VALENS143', 'Valentine Sale', 'both', 'percentage', 15.00, 0.00, 0.00, '2026-02-11', '2026-02-15', 0, 0, 0.00, 0.00, '', 'Holiday', 1, 1, 17, '2026-02-11 14:31:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_voucher_usage`
--

CREATE TABLE `tbl_voucher_usage` (
  `usage_id` int(11) NOT NULL,
  `voucher_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `order_type` enum('product','service') NOT NULL,
  `order_id` int(11) NOT NULL COMMENT 'receipt_id or appointment_id',
  `discount_amount` decimal(10,2) NOT NULL,
  `original_amount` decimal(10,2) NOT NULL,
  `final_amount` decimal(10,2) NOT NULL,
  `used_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_voucher_usage`
--

INSERT INTO `tbl_voucher_usage` (`usage_id`, `voucher_id`, `account_id`, `order_type`, `order_id`, `discount_amount`, `original_amount`, `final_amount`, `used_date`) VALUES
(1, 2, 12, 'product', 17, 120.00, 480.00, 336.00, '2025-10-21 06:23:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_account`
--
ALTER TABLE `tbl_account`
  ADD PRIMARY KEY (`ac_id`);

--
-- Indexes for table `tbl_account_details`
--
ALTER TABLE `tbl_account_details`
  ADD PRIMARY KEY (`ac_id`);

--
-- Indexes for table `tbl_ac_status`
--
ALTER TABLE `tbl_ac_status`
  ADD PRIMARY KEY (`ac_status_id`);

--
-- Indexes for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `ac_id` (`ac_id`),
  ADD KEY `service_id` (`service_id`),
  ADD KEY `derm_id` (`derm_id`);

--
-- Indexes for table `tbl_best_seller`
--
ALTER TABLE `tbl_best_seller`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_billing_details`
--
ALTER TABLE `tbl_billing_details`
  ADD PRIMARY KEY (`ac_details_id`);

--
-- Indexes for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `tbl_cart_vouchers`
--
ALTER TABLE `tbl_cart_vouchers`
  ADD PRIMARY KEY (`cart_voucher_id`),
  ADD KEY `voucher_id` (`voucher_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `idx_order_date` (`order_date`);

--
-- Indexes for table `tbl_concern`
--
ALTER TABLE `tbl_concern`
  ADD PRIMARY KEY (`concern_id`);

--
-- Indexes for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  ADD PRIMARY KEY (`comment_id`);

--
-- Indexes for table `tbl_delivery_type`
--
ALTER TABLE `tbl_delivery_type`
  ADD PRIMARY KEY (`delivery_type_id`);

--
-- Indexes for table `tbl_dermatologists`
--
ALTER TABLE `tbl_dermatologists`
  ADD PRIMARY KEY (`derm_id`);

--
-- Indexes for table `tbl_derm_schedule`
--
ALTER TABLE `tbl_derm_schedule`
  ADD PRIMARY KEY (`schedule_id`),
  ADD KEY `derm_id` (`derm_id`);

--
-- Indexes for table `tbl_ingredients`
--
ALTER TABLE `tbl_ingredients`
  ADD PRIMARY KEY (`ingredients_id`);

--
-- Indexes for table `tbl_item_reviews`
--
ALTER TABLE `tbl_item_reviews`
  ADD PRIMARY KEY (`rv_id`);

--
-- Indexes for table `tbl_order_vouchers`
--
ALTER TABLE `tbl_order_vouchers`
  ADD PRIMARY KEY (`order_voucher_id`),
  ADD KEY `receipt_id` (`receipt_id`),
  ADD KEY `voucher_id` (`voucher_id`);

--
-- Indexes for table `tbl_page_reviews`
--
ALTER TABLE `tbl_page_reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_prod_bestseller`
--
ALTER TABLE `tbl_prod_bestseller`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_prod_newarrivals`
--
ALTER TABLE `tbl_prod_newarrivals`
  ADD PRIMARY KEY (`prod_id`);

--
-- Indexes for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `tbl_receipt`
--
ALTER TABLE `tbl_receipt`
  ADD PRIMARY KEY (`receipt_id`);

--
-- Indexes for table `tbl_role`
--
ALTER TABLE `tbl_role`
  ADD PRIMARY KEY (`role_Id`);

--
-- Indexes for table `tbl_services`
--
ALTER TABLE `tbl_services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `tbl_vouchers`
--
ALTER TABLE `tbl_vouchers`
  ADD PRIMARY KEY (`voucher_id`),
  ADD UNIQUE KEY `voucher_code` (`voucher_code`);

--
-- Indexes for table `tbl_voucher_usage`
--
ALTER TABLE `tbl_voucher_usage`
  ADD PRIMARY KEY (`usage_id`),
  ADD KEY `voucher_id` (`voucher_id`),
  ADD KEY `account_id` (`account_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_account`
--
ALTER TABLE `tbl_account`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_account_details`
--
ALTER TABLE `tbl_account_details`
  MODIFY `ac_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tbl_ac_status`
--
ALTER TABLE `tbl_ac_status`
  MODIFY `ac_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_best_seller`
--
ALTER TABLE `tbl_best_seller`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_billing_details`
--
ALTER TABLE `tbl_billing_details`
  MODIFY `ac_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_cart`
--
ALTER TABLE `tbl_cart`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `tbl_cart_vouchers`
--
ALTER TABLE `tbl_cart_vouchers`
  MODIFY `cart_voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_concern`
--
ALTER TABLE `tbl_concern`
  MODIFY `concern_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_delivery_type`
--
ALTER TABLE `tbl_delivery_type`
  MODIFY `delivery_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_dermatologists`
--
ALTER TABLE `tbl_dermatologists`
  MODIFY `derm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_derm_schedule`
--
ALTER TABLE `tbl_derm_schedule`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=713;

--
-- AUTO_INCREMENT for table `tbl_ingredients`
--
ALTER TABLE `tbl_ingredients`
  MODIFY `ingredients_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_item_reviews`
--
ALTER TABLE `tbl_item_reviews`
  MODIFY `rv_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_order_vouchers`
--
ALTER TABLE `tbl_order_vouchers`
  MODIFY `order_voucher_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_page_reviews`
--
ALTER TABLE `tbl_page_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_prod_bestseller`
--
ALTER TABLE `tbl_prod_bestseller`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_prod_newarrivals`
--
ALTER TABLE `tbl_prod_newarrivals`
  MODIFY `prod_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_receipt`
--
ALTER TABLE `tbl_receipt`
  MODIFY `receipt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tbl_role`
--
ALTER TABLE `tbl_role`
  MODIFY `role_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_services`
--
ALTER TABLE `tbl_services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_vouchers`
--
ALTER TABLE `tbl_vouchers`
  MODIFY `voucher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_voucher_usage`
--
ALTER TABLE `tbl_voucher_usage`
  MODIFY `usage_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_appointments`
--
ALTER TABLE `tbl_appointments`
  ADD CONSTRAINT `tbl_appointments_ibfk_1` FOREIGN KEY (`ac_id`) REFERENCES `tbl_account` (`ac_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_appointments_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `tbl_services` (`service_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_appointments_ibfk_3` FOREIGN KEY (`derm_id`) REFERENCES `tbl_dermatologists` (`derm_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_cart_vouchers`
--
ALTER TABLE `tbl_cart_vouchers`
  ADD CONSTRAINT `tbl_cart_vouchers_ibfk_1` FOREIGN KEY (`voucher_id`) REFERENCES `tbl_vouchers` (`voucher_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_cart_vouchers_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `tbl_account` (`ac_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_derm_schedule`
--
ALTER TABLE `tbl_derm_schedule`
  ADD CONSTRAINT `tbl_derm_schedule_ibfk_1` FOREIGN KEY (`derm_id`) REFERENCES `tbl_dermatologists` (`derm_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_order_vouchers`
--
ALTER TABLE `tbl_order_vouchers`
  ADD CONSTRAINT `fk_order_voucher_receipt` FOREIGN KEY (`receipt_id`) REFERENCES `tbl_receipt` (`receipt_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_voucher_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `tbl_vouchers` (`voucher_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_page_reviews`
--
ALTER TABLE `tbl_page_reviews`
  ADD CONSTRAINT `tbl_page_reviews_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `tbl_account` (`ac_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_ratings`
--
ALTER TABLE `tbl_ratings`
  ADD CONSTRAINT `tbl_ratings_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `tbl_account` (`ac_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_ratings_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `tbl_products` (`prod_id`) ON DELETE CASCADE;

--
-- Constraints for table `tbl_voucher_usage`
--
ALTER TABLE `tbl_voucher_usage`
  ADD CONSTRAINT `fk_voucher_usage_account` FOREIGN KEY (`account_id`) REFERENCES `tbl_account` (`ac_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_voucher_usage_voucher` FOREIGN KEY (`voucher_id`) REFERENCES `tbl_vouchers` (`voucher_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
