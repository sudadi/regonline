-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 05, 2018 at 05:36 PM
-- Server version: 5.7.23-0ubuntu0.18.04.1
-- PHP Version: 7.2.7-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbregonline`
--

-- --------------------------------------------------------

--
-- Table structure for table `res_treservasi`
--

CREATE TABLE `res_treservasi` (
  `id_rsv` bigint(20) NOT NULL,
  `norm` varchar(10) NOT NULL,
  `nores` varchar(15) NOT NULL,
  `waktu_rsv` datetime NOT NULL,
  `jadwal_id` int(6) NOT NULL,
  `nourut` int(4) NOT NULL,
  `kode_cekin` varchar(10) DEFAULT NULL,
  `jns_jaminan_id` int(4) NOT NULL,
  `sebab_id` tinyint(2) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1.reservasi; 2. checkin; 3.Batal system; 4.Batal User',
  `first_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `sync` tinyint(1) NOT NULL DEFAULT '0',
  `jenis_rsv` varchar(5) NOT NULL,
  `identity` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `res_treservasi`
--
ALTER TABLE `res_treservasi`
  ADD PRIMARY KEY (`id_rsv`),
  ADD KEY `norm` (`norm`),
  ADD KEY `id_jadwal` (`jadwal_id`),
  ADD KEY `jns_pasien` (`jns_jaminan_id`),
  ADD KEY `sebab` (`sebab_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `res_treservasi`
--
ALTER TABLE `res_treservasi`
  MODIFY `id_rsv` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `res_treservasi`
--
ALTER TABLE `res_treservasi`
  ADD CONSTRAINT `res_treservasi_ibfk_1` FOREIGN KEY (`norm`) REFERENCES `res_tpasien` (`norm`),
  ADD CONSTRAINT `res_treservasi_ibfk_2` FOREIGN KEY (`jadwal_id`) REFERENCES `res_jadwal` (`id_jadwal`),
  ADD CONSTRAINT `res_treservasi_ibfk_3` FOREIGN KEY (`jns_jaminan_id`) REFERENCES `res_jns_jaminan` (`id_jaminan`),
  ADD CONSTRAINT `res_treservasi_ibfk_5` FOREIGN KEY (`sebab_id`) REFERENCES `res_sebab_sakit` (`id_sebab`),
  ADD CONSTRAINT `res_treservasi_ibfk_6` FOREIGN KEY (`jns_jaminan_id`) REFERENCES `res_jns_jaminan` (`id_jaminan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
