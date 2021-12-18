-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2021 at 09:27 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `smart_parking`
--

-- --------------------------------------------------------

--
-- Table structure for table `kartu`
--

CREATE TABLE `kartu` (
  `card_uid` varchar(250) NOT NULL,
  `id_user` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kartu`
--

INSERT INTO `kartu` (`card_uid`, `id_user`, `saldo`) VALUES
('ADA123', 1, 10000),
('IDCARD1234', 2, 15000);

-- --------------------------------------------------------

--
-- Table structure for table `parkir`
--

CREATE TABLE `parkir` (
  `id_parkir` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `card_uid` varchar(250) NOT NULL,
  `waktu_masuk` datetime NOT NULL,
  `waktu_keluar` datetime NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `parkir`
--

INSERT INTO `parkir` (`id_parkir`, `id_user`, `card_uid`, `waktu_masuk`, `waktu_keluar`, `total`) VALUES
(1, 2, 'IDCARD1234', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0),
(2, 1, 'ADA123', '2021-12-15 00:27:43', '2021-12-15 00:45:43', 15000),
(3, 1, 'ADA123', '2021-12-15 08:43:43', '2021-12-15 09:45:43', 15000),
(4, 1, 'IDCARD1234', '2021-12-15 08:43:43', '2021-12-15 09:45:43', 15000),
(5, 1, 'HALODUNIA', '2021-12-17 08:43:43', '2021-12-17 09:45:43', 15000),
(6, 1, 'HALODUNIA', '2021-12-20 08:43:43', '2021-12-20 09:45:43', 15000);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `nama` varchar(250) NOT NULL,
  `role` enum('pengelola','pengunjung') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`, `nama`, `role`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 'admin', 'pengelola'),
(2, 'adrian', 'adrian', 'adrian@gmail.com', 'Albertus', 'pengunjung'),
(3, 'adrian', 'felix', 'felix@gmail.com', 'felix', 'pengunjung'),
(4, 'felix', 'Test1234', 'felix@gmail.com', 'Antonius', 'pengunjung'),
(5, 'adrian', 'michson', 'michson@gmail.com', 'michson', 'pengunjung'),
(6, 'yoel', 'Test1234', 'yoel@gmail.com', 'Yoel', 'pengunjung');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id_voucher` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kode_voucher` varchar(250) NOT NULL,
  `status` varchar(100) NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `voucher`
--

INSERT INTO `voucher` (`id_voucher`, `id_user`, `kode_voucher`, `status`, `nominal`) VALUES
(1, 1, 'KODEVOUCHERNICH', 'menunggu pembayaran', 5000),
(4, 2, 'KODEVOUCHERNICH', 'menunggu pembayaran', 10000),
(5, 2, 'KODEVOUCHERNICH', 'menunggu pembayaran', 15000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kartu`
--
ALTER TABLE `kartu`
  ADD PRIMARY KEY (`card_uid`);

--
-- Indexes for table `parkir`
--
ALTER TABLE `parkir`
  ADD PRIMARY KEY (`id_parkir`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id_voucher`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parkir`
--
ALTER TABLE `parkir`
  MODIFY `id_parkir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id_voucher` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
