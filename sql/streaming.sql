-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 09, 2021 at 11:41 PM
-- Server version: 10.3.25-MariaDB-0ubuntu0.20.04.1
-- PHP Version: 7.3.27-9+ubuntu20.04.1+deb.sury.org+1
-- CREATE: EroLn[siddiq sanjaya bakti]


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `streaming`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `id` int(11) NOT NULL,
  `id_user` varchar(30) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('server','client') NOT NULL DEFAULT 'client',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Table structure for table `comment_video`
--

CREATE TABLE `comment_video` (
  `id` int(11) NOT NULL,
  `id_user` varchar(30) DEFAULT NULL,
  `id_video` varchar(20) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `comment_at` varchar(100) DEFAULT 'CURRENT_TIMESTAMP'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comment_video`
--

--
-- Table structure for table `data_video`
--

CREATE TABLE `data_video` (
  `id` int(11) NOT NULL,
  `id_video` varchar(25) DEFAULT NULL,
  `480` varchar(255) DEFAULT NULL,
  `720` varchar(255) DEFAULT NULL,
  `1080` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_video`
--

--
-- Table structure for table `detail_user`
--

CREATE TABLE `detail_user` (
  `id` int(11) NOT NULL,
  `id_user` varchar(30) NOT NULL,
  `fullname` varchar(30) DEFAULT NULL,
  `country` varchar(20) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_user`
--

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `id_user` varchar(30) NOT NULL,
  `id_video` varchar(25) NOT NULL,
  `judul` varchar(200) NOT NULL,
  `genre` varchar(100) NOT NULL,
  `produksi` varchar(50) NOT NULL,
  `durasi` varchar(12) NOT NULL,
  `rilis` date NOT NULL,
  `sinopsis` text NOT NULL,
  `gambar` varchar(100) NOT NULL,
  `watch` int(255) DEFAULT 0,
  `upload_at` varchar(100) DEFAULT 'CURRENT_TIMESTAMP'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video`
--
--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`id_user`,`username`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `comment_video`
--
ALTER TABLE `comment_video`
  ADD KEY `id` (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_video` (`id_video`);

--
-- Indexes for table `data_video`
--
ALTER TABLE `data_video`
  ADD KEY `id` (`id`),
  ADD KEY `id_video` (`id_video`);

--
-- Indexes for table `detail_user`
--
ALTER TABLE `detail_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_user_ibfk_1` (`id_user`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id_video`),
  ADD KEY `id` (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `comment_video`
--
ALTER TABLE `comment_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `data_video`
--
ALTER TABLE `data_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT15;

--
-- AUTO_INCREMENT for table `detail_user`
--
ALTER TABLE `detail_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment_video`
--
ALTER TABLE `comment_video`
  ADD CONSTRAINT `comment_video_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `account` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_video_ibfk_2` FOREIGN KEY (`id_video`) REFERENCES `video` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `data_video`
--
ALTER TABLE `data_video`
  ADD CONSTRAINT `data_video_ibfk_1` FOREIGN KEY (`id_video`) REFERENCES `video` (`id_video`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_user`
--
ALTER TABLE `detail_user`
  ADD CONSTRAINT `detail_user_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `account` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `account` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
