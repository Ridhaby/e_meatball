-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2022 at 05:29 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e-meatballs_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `pedagang_location_tb`
--

CREATE TABLE `pedagang_location_tb` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pedagang_location_tb`
--

INSERT INTO `pedagang_location_tb` (`id`, `email`, `latitude`, `longitude`) VALUES
(1, 'gzyan@gmail.com', '5.5228006', '95.3219001');

-- --------------------------------------------------------

--
-- Table structure for table `pedagang_profile_tb`
--

CREATE TABLE `pedagang_profile_tb` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `toko_image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `pembeli_location_tb`
--

CREATE TABLE `pembeli_location_tb` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `latitude` varchar(100) NOT NULL,
  `longitude` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembeli_location_tb`
--

INSERT INTO `pembeli_location_tb` (`id`, `email`, `latitude`, `longitude`) VALUES
(1, 's.darmawan8484@gmail.com', '5.5228002', '95.3219');

-- --------------------------------------------------------

--
-- Table structure for table `pembeli_profile_tb`
--

CREATE TABLE `pembeli_profile_tb` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `profile_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembeli_profile_tb`
--

INSERT INTO `pembeli_profile_tb` (`id`, `nama`, `no_hp`, `alamat`, `email`, `profile_img`) VALUES
(1, 'Surya Darmawan', '0853727283823', 'Peunayong', 's.darmawan8484@gmail.com', '1655909926.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_tb`
--

CREATE TABLE `product_tb` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `sub_title` varchar(255) NOT NULL,
  `price` int(100) NOT NULL,
  `product_image_name` varchar(255) NOT NULL,
  `email_id` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_tb`
--

INSERT INTO `product_tb` (`id`, `title`, `sub_title`, `price`, `product_image_name`, `email_id`) VALUES
(1, 'Bakso Biasa', 'Mie + Bakso Kecil', 22000, '1652381151.jpg', 'gzyan@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users_tb`
--

CREATE TABLE `users_tb` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL,
  `notfication_token` varchar(255) NOT NULL,
  `verification_code` varchar(100) NOT NULL,
  `varified_status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users_tb`
--

INSERT INTO `users_tb` (`id`, `nama`, `email`, `password`, `role`, `notfication_token`, `verification_code`, `varified_status`) VALUES
(1, 'Ghuzzyan', 'gzyan@gmail.com', '$2y$10$whq9BbLn3ABAffYWs/cr0OqiGHmNXwxl/VG6S90GI3hhuGh8fnwWO', 'pedagang', '', '10147', '1'),
(2, 'Surya Darmawan', 's.darmawan8484@gmail.com', '$2y$10$gqPzTz3QyHk1ERhAo.cMouNzSuumnWazsjpICIHf9IUEEaGej5/7G', 'pembeli', 'de10bwDqRgm0aTZ6XMatQI:APA91bHrrRdqi_MK4ssBlXsZvLDKJwUmXlg29T5zCBKHt-sqO_3t3nadJBbiUvIUo9R_9chZ3yjMnO5ETk1rcXtkPMdWgCpk-CfyNNKQL0A_lqYoC-HG82K-6fN6t5j_-w2s3DZLeETO', '19867', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_padang_tb`
--

CREATE TABLE `user_padang_tb` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `desc_toko` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_padang_tb`
--

INSERT INTO `user_padang_tb` (`id`, `email`, `nama`, `alamat`, `no_hp`, `nama_toko`, `desc_toko`, `image`) VALUES
(1, 'gzyan@gmail.com', 'Gzyan', 'Neusu Jaya Banda Aceh', '085273744733', 'Bakso Pak Gzyan', 'Harga kaki lima, Rasa bintang lima', '1655913064.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pedagang_location_tb`
--
ALTER TABLE `pedagang_location_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pedagang_profile_tb`
--
ALTER TABLE `pedagang_profile_tb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `pembeli_location_tb`
--
ALTER TABLE `pembeli_location_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pembeli_profile_tb`
--
ALTER TABLE `pembeli_profile_tb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `product_tb`
--
ALTER TABLE `product_tb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_tb`
--
ALTER TABLE `users_tb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_padang_tb`
--
ALTER TABLE `user_padang_tb`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `pedagang_location_tb`
--
ALTER TABLE `pedagang_location_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pedagang_profile_tb`
--
ALTER TABLE `pedagang_profile_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pembeli_location_tb`
--
ALTER TABLE `pembeli_location_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pembeli_profile_tb`
--
ALTER TABLE `pembeli_profile_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_tb`
--
ALTER TABLE `product_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users_tb`
--
ALTER TABLE `users_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_padang_tb`
--
ALTER TABLE `user_padang_tb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
