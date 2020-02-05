-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2019 at 02:31 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pao-cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `firstname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `middlename` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'profile-placeholder.jpg',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `gender`, `username`, `password`, `type`, `status`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Mar', 'G', 'Lapuz', 'Male', 'lapuzmar', '$2y$10$fLkwXtCxtHz/.H62R/iH4.4WV/5MAxHRHtgT7BNZcyrHl1Y5ocT8u', 'Super Admin', 'Available', '1544064339.jpeg', 'ZJlRXOuxRtpiiGVVELYdQTfj0qUxcvyYvol8O7nkcyGlF734ohT6ISBu2a0g', NULL, '2018-12-05 18:45:40'),
(2, 'Aaron', 'D', 'Matawaran', 'Male', 'aaronmatawaran', '$2y$10$ahG2JJMJId8z8x3lFMllVelC.Fen2xmmydsx6XNf.rwdUolK3XmfO', 'Super Admin', 'Available', '1544064891.jpeg', '92S6ijg0HG9qksmAZF9hEggJR3zDiT6kKHudkcEMkKgoRe5nHaGPQRU2sw1J', '2018-12-05 18:53:05', '2018-12-05 18:54:51'),
(3, 'Arlan', 'G', 'Cabuso', 'Male', 'arlancabuso', '$2y$10$77R2seQai2SMUlmGxv3aCe0n.JhQZd796sPuzYu1ORP1Mkj29w7Ma', 'Super Admin', 'Available', '1544064911.jpeg', 'kjbCPqz7YM06TFiAGEi9pyI3ci6MJIIAPHqJ0QGFvTylvpySHvNkhgITolwZ', '2018-12-05 18:54:06', '2018-12-05 18:55:11'),
(4, 'Shernon', 'S', 'Severino', 'Male', 'shernonseverino', '$2y$10$uzWohr30GfPsU4QeGHZZ0Om72oh.OSW6ewr.YPlLRXUMFPtxbcLla', 'Super Admin', 'Available', '1544065009.jpeg', '7EE3VWXGXRm3v7e7B1vdLVU4d6kerYrbLjoVuMDwCY3pKwkrEjV8Wm2tnRg8', '2018-12-05 18:54:29', '2018-12-05 18:56:49'),
(5, 'I\'m', 'A', 'Staff', 'Male', 'staff', '$2y$10$Pv.e7Xet129vir8aGvkK3.vMpbxJKWyel/fcgMblsDnHrOsCtD6Ee', 'Staff', 'Available', 'profile-placeholder.jpg', NULL, '2019-01-02 03:45:56', '2019-01-02 03:45:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
