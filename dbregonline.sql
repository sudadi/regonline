-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 18, 2018 at 05:09 PM
-- Server version: 5.7.22-0ubuntu18.04.1
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

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`admin`@`localhost` FUNCTION `SPLIT_STR` (`X` VARCHAR(255), `delim` VARCHAR(12), `pos` INT) RETURNS VARCHAR(255) CHARSET latin1 BEGIN
    RETURN
    REPLACE
        (
            SUBSTRING(
                SUBSTRING_INDEX(X, delim, pos),
                LENGTH(
                    SUBSTRING_INDEX(X, delim, pos -1)
                ) + 1
            ),
            delim,
            ''
        ) ;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Table structure for table `auth_login_attempts`
--

CREATE TABLE `auth_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users`
--

CREATE TABLE `auth_users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(254) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_users`
--

INSERT INTO `auth_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, 'uLqRuZhJcW3CwF9799i.Te', 1268889823, 1531793725, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(2, '127.0.0.1', 'web', '57f99d889086c8456456dcccd6401aef0ba2058c', NULL, '', NULL, NULL, NULL, NULL, 1268889823, NULL, 1, 'Registrasi', 'Web', 'RSO', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `auth_users_groups`
--

CREATE TABLE `auth_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `auth_users_groups`
--

INSERT INTO `auth_users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `res_jadwal`
--

CREATE TABLE `res_jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `dokter_id` int(8) NOT NULL,
  `klinik_id` int(4) NOT NULL,
  `jns_layan_id` tinyint(4) NOT NULL,
  `id_hari` tinyint(4) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota_perjam` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_jadwal`
--

INSERT INTO `res_jadwal` (`id_jadwal`, `dokter_id`, `klinik_id`, `jns_layan_id`, `id_hari`, `jam_mulai`, `jam_selesai`, `kuota_perjam`, `status`) VALUES
(1, 1, 1, 2, 1, '07:00:00', '14:00:00', 30, 1),
(2, 1, 1, 2, 4, '08:00:00', '15:00:00', 20, 0),
(3, 1, 1, 1, 4, '08:00:00', '15:00:00', 20, 0);

-- --------------------------------------------------------

--
-- Table structure for table `res_jns_pasien`
--

CREATE TABLE `res_jns_pasien` (
  `jns_id` int(3) NOT NULL,
  `jns_nama` varchar(100) DEFAULT NULL,
  `jns_flag` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_jns_pasien`
--

INSERT INTO `res_jns_pasien` (`jns_id`, `jns_nama`, `jns_flag`) VALUES
(1, 'Askes', 0),
(2, 'Umum', 1),
(5, 'JKN', 1),
(7, 'IKS', 1),
(8, 'Program', 0),
(10, 'Asuransi', 0),
(15, 'Tidak Membayar', 0),
(16, 'Jamkesmas', 0),
(18, 'Jamkesda', 0),
(19, 'SKTM', 0),
(20, 'Fasilitas', 1),
(21, 'Askes', 0),
(22, 'PKMS Silver', 0),
(23, 'PKMS Gold', 0),
(24, 'PT. JASA RAHARJA', 0),
(26, 'PT. JASA RAHARJA ', 0);

-- --------------------------------------------------------

--
-- Table structure for table `res_refdokter`
--

CREATE TABLE `res_refdokter` (
  `id_dokter` int(8) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_refdokter`
--

INSERT INTO `res_refdokter` (`id_dokter`, `nama_dokter`, `status`) VALUES
(1, 'dr. ANUNG BUDI SATRIADI Sp.OT(K)', 1),
(3, 'dr. ISMAIL MARIYANTO Sp.OT(K)', 1),
(4, 'dr. IWAN BUDIWAN ANWAR  Sp.OT(K)', 1),
(5, 'dr. MUJADDID IDULHAQ, Sp.OT.', 1),
(6, 'dr. PAMUDJI UTOMO Sp.OT(K)', 1),
(7, 'dr. R. ANDHI PRIJOSEDJATI Sp.OT(K)', 1),
(8, 'Dr. TANGKAS SIBARANI, Sp.OT(K)', 1),
(9, 'dr. Tito Sumarwoto, Sp.OT', 1),
(10, 'dr. Rieva Ermawan, Sp.OT', 1),
(11, 'dr. HERY BUDI SUMARYONO  Sp.An', 1),
(12, 'Dr. BAMBANG WIJOYO SANTOSO Sp.An', 1),
(13, 'dr. DEDI YULI ISMAWAN  Sp.An.', 1),
(14, 'dr. SISWARNI Sp.KFR.', 1),
(15, 'dr. KOMANG KUSUMAWATI  Sp.KFR', 1),
(16, 'dr. RETNO SETIANING  Sp.KFR.', 1),
(17, 'dr. ADHI KURNIAWAN Sp.KFR', 1),
(18, 'dr. HANDRY TRI HANDOJO Sp.Rad', 1),
(19, 'dr. R. SAFIL RUDIARTO HENDROYOGI Sp.Rad', 1),
(20, 'dr. LELI SABARIYAH  Sp.Rad.', 1),
(21, 'dr. RUMI SEKARSATI Sp.PD', 1),
(22, 'dr. HITAPUTRA AGUNG WARDHANA Sp.B', 1),
(23, 'dr. NUGROHO DZULKARNAEN SALIM  Sp.S.', 1),
(24, 'dr. FARIDA Sp.PK', 1),
(25, 'drg. ALI IMRON  Sp.KG', 1),
(26, 'drg. TITIK RETNANINGTYAS', 1),
(27, 'dr. KSHANTI ADHITYA  Sp.EM.', 1),
(28, 'dr. Niluh Tantri Fitriyanti, Sp.PD', 1),
(29, 'drg. RUKTI ALFIAH, M.M.', 1),
(30, 'dr. HARRY HARYANA Sp.KFR', 1),
(31, 'dr. MAKTAL BUDIYARTA', 1),
(32, 'dr. AMIN MUSTOFA MARS', 1),
(33, 'dr. AGUNG ARI BUDY SISWANTO, Sp.An', 1),
(35, 'dr. I DEWA GEDE SUCI INDRA WARDHANA', 1),
(37, 'dr. NAFIUDIN, Sp.PD.', 1),
(38, 'Dr. Yusuf Subagyo, Sp.P', 1),
(39, 'dr. Agung Priatmaja, Sp.KJ, M.Kes', 1),
(40, 'dr. JIMMY FITRIA', 1),
(41, 'dr. JAMILATUN ROSIDAH', 1),
(42, 'dr. Aminah, Sp.KK', 1),
(43, 'dr. NURLELI MANURUNG', 1),
(44, 'dr. Ahmad Bi Utomo, Sp.U', 1),
(45, 'dr. ASEP SANTOSO, Sp.OT', 1),
(46, 'Dr. Vita S., Sp.A.', 1),
(47, 'dr. Romanianto, Sp.OT(K)', 1),
(48, 'dr. Hendra Cahya Kumara, Sp.OT', 1),
(49, 'dr. DANANG KUNTO ADI, Sp.An., M,Kes. ', 1),
(52, 'dr. Seti Aji Hadinoto, Sp.OT', 1),
(111, 'Dokter Sp. ORTOPEDI', 1),
(222, 'Dokter Sp. Rehabilitasi Medik', 1);

-- --------------------------------------------------------

--
-- Table structure for table `res_refjns_layan`
--

CREATE TABLE `res_refjns_layan` (
  `id_jns_layan` tinyint(4) NOT NULL,
  `jns_layan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_refjns_layan`
--

INSERT INTO `res_refjns_layan` (`id_jns_layan`, `jns_layan`) VALUES
(1, 'Reguler'),
(2, 'Eksekutif');

-- --------------------------------------------------------

--
-- Table structure for table `res_refklinik`
--

CREATE TABLE `res_refklinik` (
  `id_klinik` int(4) NOT NULL,
  `nama_klinik` varchar(100) NOT NULL,
  `kode_poli` varchar(5) NOT NULL,
  `tipe_layan` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1.Reguler; 2.Eksekutif',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0.Tidak Aktif; 1. Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_refklinik`
--

INSERT INTO `res_refklinik` (`id_klinik`, `nama_klinik`, `kode_poli`, `tipe_layan`, `status`) VALUES
(1, 'Ortopedi', 'ORT', 3, 1),
(2, 'Gigi & Mulut', 'GP1', 1, 1),
(3, 'Rehabilitasi Medik', 'IRM', 1, 1),
(4, 'Penyakit Dalam', 'INT', 1, 1),
(15, 'Akupuntur', 'AKP', 1, 1),
(17, 'Neurologi & Saraf', 'SAR', 1, 1),
(18, 'Bedah Umum', 'AKP', 1, 1),
(24, 'Sub Sp. Spine', 'ORT', 1, 1),
(100, 'Herbal', 'HER', 1, 0),
(101, 'Ortopedi Wijaya Kusuma', 'ORT', 1, 0),
(102, 'Sub. Sp Onkology', 'ORT', 1, 1),
(103, 'Sub. Sp Hand and Micro Surgery', 'ORT', 1, 1),
(104, 'Sub. Sp. Sport Medicine', 'ORT', 1, 1),
(400, 'Sub. Sp. Adult Reconstruction', 'ORT', 1, 1),
(401, 'Sub. Sp. Pediatric', 'ORT', 1, 1),
(533, 'Rekam Medik', '', 1, 0),
(569, 'Poli Anestesi', '', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `res_sebab_sakit`
--

CREATE TABLE `res_sebab_sakit` (
  `id_sebab` tinyint(2) NOT NULL,
  `sebab` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_sebab_sakit`
--

INSERT INTO `res_sebab_sakit` (`id_sebab`, `sebab`) VALUES
(1, 'Bencana Alam'),
(2, 'Bermain'),
(3, 'Cacat Sejak Lahir'),
(4, 'Jatuh'),
(5, 'Kecelakaan Kerja'),
(6, 'Kecelakaan lalu lintas'),
(7, 'Kelainan'),
(8, 'Olah raga'),
(9, 'Sakit');

-- --------------------------------------------------------

--
-- Table structure for table `res_tgl_libur`
--

CREATE TABLE `res_tgl_libur` (
  `id_libur` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `ket` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1. Aktif; 0. Disable'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_tgl_libur`
--

INSERT INTO `res_tgl_libur` (`id_libur`, `tanggal`, `ket`, `status`) VALUES
(1, '2018-06-12', 'Libur Hari Raya Idul Fitri', 1),
(2, '2018-06-26', 'Libur Hari Kartini', 1);

-- --------------------------------------------------------

--
-- Table structure for table `res_tpasien`
--

CREATE TABLE `res_tpasien` (
  `norm` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `propinsi` int(11) NOT NULL,
  `kota` int(11) NOT NULL,
  `kec` int(11) NOT NULL,
  `kel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_tpasien`
--

INSERT INTO `res_tpasien` (`norm`, `nama`, `gender`, `tgl_lahir`, `notelp`, `alamat`, `propinsi`, `kota`, `kec`, `kel`) VALUES
('133469', 'SUDADI, SDR', 'L', '1978-06-21', '08995313157', 'Selokaton', 0, 0, 0, 0),
('317993', 'Maskur', 'L', '1950-11-28', '08995313157', 'solo', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `res_treservasi`
--

CREATE TABLE `res_treservasi` (
  `id_rsv` bigint(20) NOT NULL,
  `norm` varchar(10) NOT NULL,
  `nores` varchar(15) NOT NULL,
  `waktu_rsv` datetime NOT NULL,
  `jadwal_id` int(11) NOT NULL,
  `nourut` int(4) NOT NULL,
  `kode_cekin` varchar(10) DEFAULT NULL,
  `jns_pasien_id` int(11) NOT NULL,
  `sebab_id` tinyint(2) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0.reservasi; 1. checkin; 2.Batat',
  `first_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_update` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `sync` tinyint(1) NOT NULL DEFAULT '0',
  `jenis_rsv` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `res_treservasi`
--

INSERT INTO `res_treservasi` (`id_rsv`, `norm`, `nores`, `waktu_rsv`, `jadwal_id`, `nourut`, `kode_cekin`, `jns_pasien_id`, `sebab_id`, `status`, `first_update`, `last_update`, `user_id`, `sync`, `jenis_rsv`) VALUES
(19, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-12 07:10:11', NULL, 2, 0, 'WEB'),
(20, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-13 07:10:11', NULL, 2, 0, 'WEB'),
(21, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-13 07:10:11', NULL, 2, 0, 'WEB'),
(22, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-13 07:10:11', NULL, 2, 0, 'SMS'),
(23, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-14 07:10:11', NULL, 2, 0, 'WEB'),
(24, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-14 07:10:11', NULL, 2, 0, 'SMS'),
(25, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-14 07:10:11', NULL, 2, 0, 'SMS'),
(26, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-15 07:10:11', NULL, 2, 0, 'WA'),
(27, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-15 07:10:11', NULL, 2, 0, 'WA'),
(28, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-15 07:10:11', NULL, 2, 0, 'SMS'),
(29, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-15 07:10:11', NULL, 2, 0, 'WEB'),
(30, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-16 07:10:11', NULL, 2, 0, 'WA'),
(31, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-16 07:10:11', NULL, 2, 0, 'SMS'),
(32, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-16 07:10:11', NULL, 2, 0, 'WEB'),
(33, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-17 02:10:11', NULL, 2, 0, 'WEB'),
(34, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-17 02:10:11', NULL, 2, 0, 'WEB'),
(35, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-17 01:10:11', NULL, 2, 0, 'WEB'),
(36, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-17 02:44:11', NULL, 2, 0, 'SMS');

-- --------------------------------------------------------

--
-- Table structure for table `sms_full_inbox`
--

CREATE TABLE `sms_full_inbox` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ReceivingDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Text` text NOT NULL,
  `SenderNumber` varchar(20) NOT NULL DEFAULT '',
  `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
  `UDH` text NOT NULL,
  `SMSCNumber` varchar(20) NOT NULL DEFAULT '',
  `Class` int(11) NOT NULL DEFAULT '-1',
  `TextDecoded` text NOT NULL,
  `ID` int(10) UNSIGNED NOT NULL,
  `RecipientID` text NOT NULL,
  `Processed` enum('false','true') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sms_full_inbox`
--

INSERT INTO `sms_full_inbox` (`UpdatedInDB`, `ReceivingDateTime`, `Text`, `SenderNumber`, `Coding`, `UDH`, `SMSCNumber`, `Class`, `TextDecoded`, `ID`, `RecipientID`, `Processed`) VALUES
('2018-07-18 07:32:01', '2018-07-17 02:13:21', '00480061006900200073006F0062002C0020006B0061006C006900200069006E00690020006700770020006D00770020006B0061007300690068002000740061007500200063006100720061006E007900610020006E0067006500620065006E006500720069006E00200061007400610075002000620061007300610020006700610075006C006E0079006100200046006C0061007300680069006E006700200062006C00610063006B0062006500720072007900200073006F00620061007400200079006700200072007500730061006B002E00200053006F0066007400770061007200650020006E007900610020006100740061007500200067006100670061006C00200062006F006F00740069006E00670020006100740061007500200062006100680061007300610020006A0061', '+6283818181831', 'Default_No_Compression', '050003850201', '+628315000032', -1, 'Hai sob, kali ini gw mw kasih tau caranya ngebenerin atau basa gaulnya Flashing blackberry sobat yg rusak. Software nya atau gagal booting atau bahasa jawane macet pada saat di hidupkan (loading terus)', 1, '', 'true'),
('2018-07-18 07:31:54', '2018-07-18 03:40:58', '0059006F002E002E', '+628995313157', 'Default_No_Compression', '', '+628964011134', -1, 'Yo..', 3, '', 'true'),
('2018-07-18 08:47:59', '2018-07-18 08:26:06', '002800410058004900530029002000410059004F002000530045004D0041004E0047004100540020006B006900720069006D0020003200200053004D00530020006C0061006700690021002000200042006900610072002000640061007000610074002000200042004F004E00550053002000330030003000200053004D00530020006B0065002000530045004D005500410020004F00500045005200410054004F005200200073006500680061007200690061006E002100200049005200490054002000490054005500200041005800490053002E00200049006E0066006F003800330038', 'AXIS', 'Default_No_Compression', '', '+628184422876', -1, '(AXIS) AYO SEMANGAT kirim 2 SMS lagi!  Biar dapat  BONUS 300 SMS ke SEMUA OPERATOR seharian! IRIT ITU AXIS. Info838', 4, '', 'true'),
('2018-07-18 08:58:13', '2018-07-18 08:53:05', '005900410059002100200042004F004E00550053002000330030003000200053004D00530020006B0065002000730065006D007500610020006F00700065007200610074006F00720020006B0061006D007500200073007500640061006800200061006B00740069006600210020004E0069006B006D00610074006900200073002E00640020006A0061006D002000310032006D006C006D002E00200044006F0077006E006C006F0061006400200041005800490053006E0065007400200061007400610075002000740065006C00700020002A0031003200330023002000640061006E002000740065006D0075006B0061006E002000500052004F004D004F00200041005800490053', '', 'Unicode_No_Compression', '', '', 127, 'YAY! BONUS 300 SMS ke semua operator kamu sudah aktif! Nikmati s.d jam 12mlm. Download AXISnet atau telp *123# dan temukan PROMO AXIS', 5, '', 'true'),
('2018-07-18 09:39:29', '2018-07-18 08:56:23', '004100200073006500740020006F00660020006B00650079002F00760061006C00750065002000700061006900720073002000740068006100740020006D006100700020006100200067006900760065006E00200064006100740061005400790070006500200074006F00200069007400730020004D0049004D004500200074007900700065002C00200077006800690063006800200067006500740073002000730065006E007400200069006E00200074006800650020004100630063006500700074002000720065007100750065007300740020006800650061006400650072', '+6283818181831', 'Default_No_Compression', '', '+628315000032', -1, 'A set of key/value pairs that map a given dataType to its MIME type, which gets sent in the Accept request header', 6, '', 'true'),
('2018-07-18 09:42:50', '2018-07-18 09:26:24', '00530075006400610068002000630065006B002000700065006E00610077006100720061006E0020007300700065007300690061006C00200075006E00740075006B0020006B0061006D00750020006800610072006900200069006E0069003F002000430065006B0020002A0031003200330023002000730065006B006100720061006E00670020002600200061006D00620069006C002000700065006E00610077006100720061006E0020007400650072006200610069006B006E007900610021002000410046004F003000370041', 'AXIS', 'Default_No_Compression', '', '+62818445009', -1, 'Sudah cek penawaran spesial untuk kamu hari ini? Cek *123# sekarang & ambil penawaran terbaiknya! AFO07A', 7, '', 'true'),
('2018-07-18 09:26:56', '2018-07-18 09:26:37', '0053006900610070002000670061006E002E002E', '+6281578034054', 'Default_No_Compression', '', '+62816124', -1, 'Siap gan..', 8, '', 'true'),
('2018-07-18 10:00:53', '2018-07-18 09:59:28', '0028004100580049005300290020004B0075006F00740061002000700061006B00650074002000640061007400610020006B0061006D00750020006400690020006A0061006D002000300030002E00300030002D00310031002E00350039002000740065006C0061006800200064006900670075006E0061006B0061006E002000730065006C0075007200750068006E00790061002E002000500065006E006700670075006E00610061006E002000730065006C0061006E006A00750074006E0079006100200061006B0061006E002000640069006B0065006E0061006B0061006E0020007400610072006900660020006E006F0072006D0061006C002E00200049006E0066006F003800330038', '+628995313157', 'Default_No_Compression', '', '+628964011134', -1, '(AXIS) Kuota paket data kamu di jam 00.00-11.59 telah digunakan seluruhnya. Penggunaan selanjutnya akan dikenakan tarif normal. Info838', 9, '', 'true');

-- --------------------------------------------------------

--
-- Table structure for table `sms_full_outbox`
--

CREATE TABLE `sms_full_outbox` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InsertIntoDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SendingDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SendBefore` time NOT NULL DEFAULT '23:59:59',
  `SendAfter` time NOT NULL DEFAULT '00:00:00',
  `Text` text,
  `DestinationNumber` varchar(20) NOT NULL DEFAULT '',
  `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
  `UDH` text,
  `Class` int(11) DEFAULT '-1',
  `TextDecoded` text NOT NULL,
  `ID` int(10) UNSIGNED NOT NULL,
  `MultiPart` enum('false','true') DEFAULT 'false',
  `RelativeValidity` int(11) DEFAULT '-1',
  `SenderID` varchar(255) DEFAULT NULL,
  `SendingTimeOut` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DeliveryReport` enum('default','yes','no') DEFAULT 'default',
  `CreatorID` text NOT NULL,
  `Status` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sms_full_outbox`
--

INSERT INTO `sms_full_outbox` (`UpdatedInDB`, `InsertIntoDB`, `SendingDateTime`, `SendBefore`, `SendAfter`, `Text`, `DestinationNumber`, `Coding`, `UDH`, `Class`, `TextDecoded`, `ID`, `MultiPart`, `RelativeValidity`, `SenderID`, `SendingTimeOut`, `DeliveryReport`, `CreatorID`, `Status`) VALUES
('2018-07-17 09:05:17', '2018-07-17 09:04:55', '2018-07-17 09:04:55', '23:59:59', '00:00:00', NULL, '+6283818181831', 'Default_No_Compression', NULL, -1, 'I know this was already answered, but I used this and extended it a little more in my code so that you didn\'t have search by only the uid. I just want to share it for anyone else who may need that functionality.', 3, 'false', -1, NULL, '2018-07-17 09:04:55', 'default', 'dede', 1),
('2018-07-17 09:59:29', '2018-07-17 09:09:28', '2018-07-17 09:09:28', '23:59:59', '00:00:00', NULL, '+6283865765051', 'Default_No_Compression', NULL, -1, 'I know this was already answered, but I used this and extended it a little more in my code so that you didn\'t have search by only the uid. I just want to share it for anyone else who may need that functionality.', 4, 'false', -1, NULL, '2018-07-17 09:09:28', 'default', 'dede', 1),
('2018-07-18 08:25:00', '2018-07-18 08:24:50', '2018-07-18 08:24:50', '23:59:59', '00:00:00', NULL, '08995313157', 'Default_No_Compression', NULL, -1, 'testing melalui form sms', 5, 'false', -1, NULL, '2018-07-18 08:24:50', 'default', 'Admin', 1),
('2018-07-18 08:48:07', '2018-07-18 08:47:55', '2018-07-18 08:47:55', '23:59:59', '00:00:00', NULL, '083865765051', 'Default_No_Compression', NULL, -1, 'testing lagi mas bro lewat form ', 6, 'false', -1, NULL, '2018-07-18 08:47:55', 'default', 'Admin', 1),
('2018-07-18 08:49:12', '2018-07-18 08:49:00', '2018-07-18 08:49:00', '23:59:59', '00:00:00', NULL, '081576034054', 'Default_No_Compression', NULL, -1, 'A set of key/value pairs that map a given dataType to its MIME type, which gets sent in the Accept request header', 7, 'false', -1, NULL, '2018-07-18 08:49:00', 'default', 'Admin', 1),
('2018-07-18 08:51:47', '2018-07-18 08:51:15', '2018-07-18 08:51:15', '23:59:59', '00:00:00', NULL, '081578034054', 'Default_No_Compression', NULL, -1, 'A set of key/value pairs that map a given dataType to its MIME type, which gets sent in the Accept request header', 8, 'false', -1, NULL, '2018-07-18 08:51:15', 'default', 'Admin', 1),
('2018-07-18 08:56:23', '2018-07-18 08:55:50', '2018-07-18 08:55:50', '23:59:59', '00:00:00', NULL, '083818181831', 'Default_No_Compression', NULL, -1, 'A set of key/value pairs that map a given dataType to its MIME type, which gets sent in the Accept request header', 9, 'false', -1, NULL, '2018-07-18 08:55:50', 'default', 'Admin', 1),
('2018-07-18 09:23:21', '2018-07-18 09:00:04', '2018-07-18 09:00:04', '23:59:59', '00:00:00', NULL, '081578034054', 'Default_No_Compression', NULL, -1, 'In this post I show you delete multiple records from mysql database on the basis of selected checkbox in php. You have show lots of tutorial on this things but today I have show you how to use Ajax and JQuery for delete multiple records on the basis of checked checkboxes on one single click without page refresh. ', 10, 'false', -1, NULL, '2018-07-18 09:00:04', 'default', 'Admin', 1),
('2018-07-18 09:23:26', '2018-07-18 09:09:07', '2018-07-18 09:09:07', '23:59:59', '00:00:00', NULL, '081578034054', 'Default_No_Compression', NULL, -1, 'In this post I show you delete multiple records from mysql database on the basis of selected checkbox in php. You have show lots of tutorial on this things but today I have show you how to use Ajax and JQuery for delete multiple records on the basis of checked checkboxes on one single click without page refresh. ', 11, 'false', -1, NULL, '2018-07-18 09:09:07', 'default', 'Admin', 1),
('2018-07-18 10:03:35', '2018-07-18 10:03:16', '2018-07-18 10:03:16', '23:59:59', '00:00:00', NULL, '+628995313157', 'Default_No_Compression', NULL, -1, 'The individual signals on a serial port are unidirectional and when connecting two devices the outputs of one device must be connected to the inputs of the other. Devices are divided into two categories data terminal equipment (DTE) and data circuit-terminating equipment (DCE). A line that is an output on a DTE device is an input on a DCE device and vice versa so a DCE device can be connected to a DTE device with a straight wired cable.', 12, 'false', -1, NULL, '2018-07-18 10:03:16', 'default', 'Admin', 1);

--
-- Triggers `sms_full_outbox`
--
DELIMITER $$
CREATE TRIGGER `copy_to_inbox_aft_ins` AFTER INSERT ON `sms_full_outbox` FOR EACH ROW BEGIN

INSERT INTO sms_outbox (ID,DestinationNumber,TextDecoded,CreatorID,Coding,Class)
VALUES (new.ID, new.DestinationNumber, new.TextDecoded, new.CreatorID, new.Coding, new.Class);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_gammu`
--

CREATE TABLE `sms_gammu` (
  `Version` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sms_gammu`
--

INSERT INTO `sms_gammu` (`Version`) VALUES
(17);

-- --------------------------------------------------------

--
-- Table structure for table `sms_inbox`
--

CREATE TABLE `sms_inbox` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ReceivingDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Text` text NOT NULL,
  `SenderNumber` varchar(20) NOT NULL DEFAULT '',
  `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
  `UDH` text NOT NULL,
  `SMSCNumber` varchar(20) NOT NULL DEFAULT '',
  `Class` int(11) NOT NULL DEFAULT '-1',
  `TextDecoded` text NOT NULL,
  `ID` int(10) UNSIGNED NOT NULL,
  `RecipientID` text NOT NULL,
  `Processed` enum('false','true') NOT NULL DEFAULT 'false',
  `Status` int(11) NOT NULL DEFAULT '-1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sms_inbox`
--

INSERT INTO `sms_inbox` (`UpdatedInDB`, `ReceivingDateTime`, `Text`, `SenderNumber`, `Coding`, `UDH`, `SMSCNumber`, `Class`, `TextDecoded`, `ID`, `RecipientID`, `Processed`, `Status`) VALUES
('2018-07-17 02:13:23', '2018-07-17 02:13:21', '00480061006900200073006F0062002C0020006B0061006C006900200069006E00690020006700770020006D00770020006B0061007300690068002000740061007500200063006100720061006E007900610020006E0067006500620065006E006500720069006E00200061007400610075002000620061007300610020006700610075006C006E0079006100200046006C0061007300680069006E006700200062006C00610063006B0062006500720072007900200073006F00620061007400200079006700200072007500730061006B002E00200053006F0066007400770061007200650020006E007900610020006100740061007500200067006100670061006C00200062006F006F00740069006E00670020006100740061007500200062006100680061007300610020006A0061', '+6283818181831', 'Default_No_Compression', '050003850201', '+628315000032', -1, 'Hai sob, kali ini gw mw kasih tau caranya ngebenerin atau basa gaulnya Flashing blackberry sobat yg rusak. Software nya atau gagal booting atau bahasa ja', 1, '', 'false', 0),
('2018-07-17 02:13:23', '2018-07-17 02:13:22', '00770061006E00650020006D00610063006500740020007000610064006100200073006100610074002000640069002000680069006400750070006B0061006E00200028006C006F006100640069006E00670020007400650072007500730029', '+6283818181831', 'Default_No_Compression', '050003850202', '+628315000032', -1, 'wane macet pada saat di hidupkan (loading terus)', 2, '', 'false', 0),
('2018-07-17 09:59:26', '2018-07-17 09:05:18', '00490020006B006E006F007700200074006800690073002000770061007300200061006C0072006500610064007900200061006E007300770065007200650064002C002000620075007400200049002000750073006500640020007400680069007300200061006E006400200065007800740065006E006400650064002000690074002000610020006C006900740074006C00650020006D006F0072006500200069006E0020006D007900200063006F0064006500200073006F0020007400680061007400200079006F00750020006400690064006E002700740020006800610076006500200073006500610072006300680020006200790020006F006E006C007900200074006800650020007500690064002E002000490020006A007500730074002000770061006E007400200074006F', '+6283818181831', 'Default_No_Compression', '050003180201', '+628315000032', -1, 'I know this was already answered, but I used this and extended it a little more in my code so that you didn\'t have search by only the uid. I just want to', 3, '', 'false', 0),
('2018-07-17 09:59:26', '2018-07-17 09:05:19', '00200073006800610072006500200069007400200066006F007200200061006E0079006F006E006500200065006C00730065002000770068006F0020006D006100790020006E00650065006400200074006800610074002000660075006E006300740069006F006E0061006C006900740079002E', '+6283818181831', 'Default_No_Compression', '050003180202', '+628315000032', -1, ' share it for anyone else who may need that functionality.', 4, '', 'false', 0),
('2018-07-18 03:41:11', '2018-07-18 03:40:58', '0059006F002E002E', '+628995313157', 'Default_No_Compression', '', '+628964011134', -1, 'Yo..', 5, '', 'false', 0),
('2018-07-18 08:26:13', '2018-07-18 08:26:06', '002800410058004900530029002000410059004F002000530045004D0041004E0047004100540020006B006900720069006D0020003200200053004D00530020006C0061006700690021002000200042006900610072002000640061007000610074002000200042004F004E00550053002000330030003000200053004D00530020006B0065002000530045004D005500410020004F00500045005200410054004F005200200073006500680061007200690061006E002100200049005200490054002000490054005500200041005800490053002E00200049006E0066006F003800330038', 'AXIS', 'Default_No_Compression', '', '+628184422876', -1, '(AXIS) AYO SEMANGAT kirim 2 SMS lagi!  Biar dapat  BONUS 300 SMS ke SEMUA OPERATOR seharian! IRIT ITU AXIS. Info838', 6, '', 'false', 0),
('2018-07-18 08:53:05', '2018-07-18 08:53:05', '005900410059002100200042004F004E00550053002000330030003000200053004D00530020006B0065002000730065006D007500610020006F00700065007200610074006F00720020006B0061006D007500200073007500640061006800200061006B00740069006600210020004E0069006B006D00610074006900200073002E00640020006A0061006D002000310032006D006C006D002E00200044006F0077006E006C006F0061006400200041005800490053006E0065007400200061007400610075002000740065006C00700020002A0031003200330023002000640061006E002000740065006D0075006B0061006E002000500052004F004D004F00200041005800490053', '', 'Unicode_No_Compression', '', '', 127, 'YAY! BONUS 300 SMS ke semua operator kamu sudah aktif! Nikmati s.d jam 12mlm. Download AXISnet atau telp *123# dan temukan PROMO AXIS', 7, '', 'false', 2),
('2018-07-18 09:23:19', '2018-07-18 08:56:23', '004100200073006500740020006F00660020006B00650079002F00760061006C00750065002000700061006900720073002000740068006100740020006D006100700020006100200067006900760065006E00200064006100740061005400790070006500200074006F00200069007400730020004D0049004D004500200074007900700065002C00200077006800690063006800200067006500740073002000730065006E007400200069006E00200074006800650020004100630063006500700074002000720065007100750065007300740020006800650061006400650072', '+6283818181831', 'Default_No_Compression', '', '+628315000032', -1, 'A set of key/value pairs that map a given dataType to its MIME type, which gets sent in the Accept request header', 8, '', 'false', 0),
('2018-07-18 09:26:34', '2018-07-18 09:26:24', '00530075006400610068002000630065006B002000700065006E00610077006100720061006E0020007300700065007300690061006C00200075006E00740075006B0020006B0061006D00750020006800610072006900200069006E0069003F002000430065006B0020002A0031003200330023002000730065006B006100720061006E00670020002600200061006D00620069006C002000700065006E00610077006100720061006E0020007400650072006200610069006B006E007900610021002000410046004F003000370041', 'AXIS', 'Default_No_Compression', '', '+62818445009', -1, 'Sudah cek penawaran spesial untuk kamu hari ini? Cek *123# sekarang & ambil penawaran terbaiknya! AFO07A', 9, '', 'false', 0),
('2018-07-18 09:26:49', '2018-07-18 09:26:37', '0053006900610070002000670061006E002E002E', '+6281578034054', 'Default_No_Compression', '', '+62816124', -1, 'Siap gan..', 10, '', 'false', 0),
('2018-07-18 09:59:37', '2018-07-18 09:59:28', '0028004100580049005300290020004B0075006F00740061002000700061006B00650074002000640061007400610020006B0061006D00750020006400690020006A0061006D002000300030002E00300030002D00310031002E00350039002000740065006C0061006800200064006900670075006E0061006B0061006E002000730065006C0075007200750068006E00790061002E002000500065006E006700670075006E00610061006E002000730065006C0061006E006A00750074006E0079006100200061006B0061006E002000640069006B0065006E0061006B0061006E0020007400610072006900660020006E006F0072006D0061006C002E00200049006E0066006F003800330038', '+628995313157', 'Default_No_Compression', '', '+628964011134', -1, '(AXIS) Kuota paket data kamu di jam 00.00-11.59 telah digunakan seluruhnya. Penggunaan selanjutnya akan dikenakan tarif normal. Info838', 11, '', 'false', 0);

--
-- Triggers `sms_inbox`
--
DELIMITER $$
CREATE TRIGGER `inbox_before_ins` BEFORE INSERT ON `sms_inbox` FOR EACH ROW begin

if NEW.UDH=NULL OR RIGHT(NEW.UDH,2)='01' OR NEW.UDH='' THEN
INSERT INTO `sms_full_inbox`(`UpdatedInDB`,`ReceivingDateTime`,`Text`,`SenderNumber`,`Coding`,`UDH`,`SMSCNumber`,`Class`,`TextDecoded`,`RecipientID`,`Processed`) VALUES
(new.UpdatedInDB, new.ReceivingDateTime, new.TEXT, new.SenderNumber,
new.Coding, new.UDH, new.SMSCNumber, new.Class, new.TextDecoded, new.RecipientID, new.Processed);

ELSE
UPDATE sms_full_inbox SET textdecoded=CONCAT(textdecoded,new.TextDecoded)
WHERE LEFT(udh,10)=LEFT(new.UDH,10);

END if;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_outbox`
--

CREATE TABLE `sms_outbox` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InsertIntoDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SendingDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SendBefore` time NOT NULL DEFAULT '23:59:59',
  `SendAfter` time NOT NULL DEFAULT '00:00:00',
  `Text` text,
  `DestinationNumber` varchar(20) NOT NULL DEFAULT '',
  `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
  `UDH` text,
  `Class` int(11) DEFAULT '-1',
  `TextDecoded` text NOT NULL,
  `ID` int(10) UNSIGNED NOT NULL,
  `multipart` varchar(6) DEFAULT '0',
  `RelativeValidity` int(11) DEFAULT '-1',
  `SenderID` varchar(255) DEFAULT NULL,
  `SendingTimeOut` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `DeliveryReport` enum('default','yes','no') DEFAULT 'default',
  `CreatorID` text NOT NULL,
  `Retries` int(3) DEFAULT '0',
  `Priority` int(11) DEFAULT '0',
  `Status` enum('SendingOK','SendingOKNoReport','SendingError','DeliveryOK','DeliveryFailed','DeliveryPending','DeliveryUnknown','Error','Reserved') NOT NULL DEFAULT 'Reserved',
  `StatusCode` int(11) NOT NULL DEFAULT '-1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Triggers `sms_outbox`
--
DELIMITER $$
CREATE TRIGGER `outbox_after_ins_tr` AFTER INSERT ON `sms_outbox` FOR EACH ROW BEGIN
 set @seq=2;
 set @udh=left(new.udh,10);
 while (length(@remains)>0 and @seq<256) do

   set @part=left(@remains,153);
   if length(hex(@seq))=1 then
      set @seqx=CONCAT('0',hex(@seq));
   else
      set @seqx=hex(@seq);
   end if;

   set @remains=substring(@remains from 154);
   insert into sms_outbox_multipart  (SequencePosition,UDH,TextDecoded,id) values (@seq,concat(@udh,@seqx),@part,new.ID);
   set @seq=@seq+1;
 end while;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `outbox_before_ins_tr` BEFORE INSERT ON `sms_outbox` FOR EACH ROW BEGIN    if length(new.TextDecoded)>160 then     set @countM=hex((length(new.TextDecoded) div 154)+1);     set @remains=substring(new.TextDecoded from 154);     set @randomUDH=hex(FLOOR(1 + (RAND() * 254)));         if length(@countM)=1 then     set @countM=CONCAT('0',@countM);    end if;    if length(@remains)>0 then    set new.UDH=concat('050003',@randomUDH, @countM,'01');    set new.TextDecoded=left(new.TextDecoded,153);    set new.MultiPart='1';    set new.RelativeValidity=255;   else     set new.MultiPart='0';   end if;     end if;    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_outbox_multipart`
--

CREATE TABLE `sms_outbox_multipart` (
  `Text` text,
  `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
  `UDH` text,
  `Class` int(11) DEFAULT '-1',
  `TextDecoded` text,
  `ID` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `SequencePosition` int(11) NOT NULL DEFAULT '1',
  `Status` enum('SendingOK','SendingOKNoReport','SendingError','DeliveryOK','DeliveryFailed','DeliveryPending','DeliveryUnknown','Error','Reserved') NOT NULL DEFAULT 'Reserved',
  `StatusCode` int(11) NOT NULL DEFAULT '-1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `sms_phones`
--

CREATE TABLE `sms_phones` (
  `ID` text NOT NULL,
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InsertIntoDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `TimeOut` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Send` enum('yes','no') NOT NULL DEFAULT 'no',
  `Receive` enum('yes','no') NOT NULL DEFAULT 'no',
  `IMEI` varchar(35) NOT NULL,
  `IMSI` varchar(35) NOT NULL,
  `NetCode` varchar(10) DEFAULT 'ERROR',
  `NetName` varchar(35) DEFAULT 'ERROR',
  `Client` text NOT NULL,
  `Battery` int(11) NOT NULL DEFAULT '-1',
  `Signal` int(11) NOT NULL DEFAULT '-1',
  `Sent` int(11) NOT NULL DEFAULT '0',
  `Received` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sms_phones`
--

INSERT INTO `sms_phones` (`ID`, `UpdatedInDB`, `InsertIntoDB`, `TimeOut`, `Send`, `Receive`, `IMEI`, `IMSI`, `NetCode`, `NetName`, `Client`, `Battery`, `Signal`, `Sent`, `Received`) VALUES
('', '2018-07-18 10:08:22', '2018-07-18 09:23:19', '2018-07-18 10:08:32', 'yes', 'yes', '351589046379118', '510114113337585', '510 11', 'XLe', 'Gammu 1.39.0, Linux, kernel 4.15.0-24-generic (#26-Ubuntu SMP Wed Jun 13 08:44:47 UTC 2018), GCC 7.2', 100, 33, 9, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sms_sentitems`
--

CREATE TABLE `sms_sentitems` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InsertIntoDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `SendingDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `DeliveryDateTime` timestamp NULL DEFAULT NULL,
  `Text` text NOT NULL,
  `DestinationNumber` varchar(20) NOT NULL DEFAULT '',
  `Coding` enum('Default_No_Compression','Unicode_No_Compression','8bit','Default_Compression','Unicode_Compression') NOT NULL DEFAULT 'Default_No_Compression',
  `UDH` text NOT NULL,
  `SMSCNumber` varchar(20) NOT NULL DEFAULT '',
  `Class` int(11) NOT NULL DEFAULT '-1',
  `TextDecoded` text NOT NULL,
  `ID` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `SenderID` varchar(255) NOT NULL,
  `SequencePosition` int(11) NOT NULL DEFAULT '1',
  `Status` enum('SendingOK','SendingOKNoReport','SendingError','DeliveryOK','DeliveryFailed','DeliveryPending','DeliveryUnknown','Error') NOT NULL DEFAULT 'SendingOK',
  `StatusError` int(11) NOT NULL DEFAULT '-1',
  `TPMR` int(11) NOT NULL DEFAULT '-1',
  `RelativeValidity` int(11) NOT NULL DEFAULT '-1',
  `CreatorID` text NOT NULL,
  `StatusCode` int(11) NOT NULL DEFAULT '-1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sms_sentitems`
--

INSERT INTO `sms_sentitems` (`UpdatedInDB`, `InsertIntoDB`, `SendingDateTime`, `DeliveryDateTime`, `Text`, `DestinationNumber`, `Coding`, `UDH`, `SMSCNumber`, `Class`, `TextDecoded`, `ID`, `SenderID`, `SequencePosition`, `Status`, `StatusError`, `TPMR`, `RelativeValidity`, `CreatorID`, `StatusCode`) VALUES
('2018-07-17 02:09:17', '2018-07-17 02:08:23', '2018-07-17 02:09:17', NULL, '00480061006900200073006F0062002C0020006B0061006C006900200069006E00690020006700770020006D00770020006B0061007300690068002000740061007500200063006100720061006E007900610020006E0067006500620065006E006500720069006E00200061007400610075002000620061007300610020006700610075006C006E0079006100200046006C0061007300680069006E006700200062006C00610063006B0062006500720072007900200073006F00620061007400200079006700200072007500730061006B002E00200053006F0066007400770061007200650020006E007900610020006100740061007500200067006100670061006C00200062006F006F00740069006E00670020006100740061007500200062006100680061007300610020006A0061', '+6283865765051', 'Default_No_Compression', '050003F20201', '+62818445009', -1, 'Hai sob, kali ini gw mw kasih tau caranya ngebenerin atau basa gaulnya Flashing blackberry sobat yg rusak. Software nya atau gagal booting atau bahasa ja', 1, '', 1, 'SendingOKNoReport', -1, 49, 255, 'dede', -1),
('2018-07-17 02:09:18', '2018-07-17 02:08:23', '2018-07-17 02:09:18', NULL, '00770061006E00650020006D00610063006500740020007000610064006100200073006100610074002000640069002000680069006400750070006B0061006E00200028006C006F006100640069006E00670020007400650072007500730029', '+6283865765051', 'Default_No_Compression', '050003F20202', '+62818445009', -1, 'wane macet pada saat di hidupkan (loading terus)', 1, '', 2, 'SendingOKNoReport', -1, 50, 255, 'dede', -1),
('2018-07-17 02:13:21', '2018-07-17 02:12:24', '2018-07-17 02:13:21', NULL, '00480061006900200073006F0062002C0020006B0061006C006900200069006E00690020006700770020006D00770020006B0061007300690068002000740061007500200063006100720061006E007900610020006E0067006500620065006E006500720069006E00200061007400610075002000620061007300610020006700610075006C006E0079006100200046006C0061007300680069006E006700200062006C00610063006B0062006500720072007900200073006F00620061007400200079006700200072007500730061006B002E00200053006F0066007400770061007200650020006E007900610020006100740061007500200067006100670061006C00200062006F006F00740069006E00670020006100740061007500200062006100680061007300610020006A0061', '+6283818181831', 'Default_No_Compression', '050003850201', '+62818445009', -1, 'Hai sob, kali ini gw mw kasih tau caranya ngebenerin atau basa gaulnya Flashing blackberry sobat yg rusak. Software nya atau gagal booting atau bahasa ja', 2, '', 1, 'SendingOKNoReport', -1, 51, 255, 'dede', -1),
('2018-07-17 02:13:22', '2018-07-17 02:12:24', '2018-07-17 02:13:22', NULL, '00770061006E00650020006D00610063006500740020007000610064006100200073006100610074002000640069002000680069006400750070006B0061006E00200028006C006F006100640069006E00670020007400650072007500730029', '+6283818181831', 'Default_No_Compression', '050003850202', '+62818445009', -1, 'wane macet pada saat di hidupkan (loading terus)', 2, '', 2, 'SendingOKNoReport', -1, 52, 255, 'dede', -1),
('2018-07-17 09:05:17', '2018-07-17 09:04:55', '2018-07-17 09:05:17', NULL, '00490020006B006E006F007700200074006800690073002000770061007300200061006C0072006500610064007900200061006E007300770065007200650064002C002000620075007400200049002000750073006500640020007400680069007300200061006E006400200065007800740065006E006400650064002000690074002000610020006C006900740074006C00650020006D006F0072006500200069006E0020006D007900200063006F0064006500200073006F0020007400680061007400200079006F00750020006400690064006E002700740020006800610076006500200073006500610072006300680020006200790020006F006E006C007900200074006800650020007500690064002E002000490020006A007500730074002000770061006E007400200074006F', '+6283818181831', 'Default_No_Compression', '050003180201', '+62818445009', -1, 'I know this was already answered, but I used this and extended it a little more in my code so that you didn\'t have search by only the uid. I just want to', 3, '', 1, 'SendingOKNoReport', -1, 53, 255, 'dede', -1),
('2018-07-17 09:05:19', '2018-07-17 09:04:55', '2018-07-17 09:05:19', NULL, '00200073006800610072006500200069007400200066006F007200200061006E0079006F006E006500200065006C00730065002000770068006F0020006D006100790020006E00650065006400200074006800610074002000660075006E006300740069006F006E0061006C006900740079002E', '+6283818181831', 'Default_No_Compression', '050003180202', '+62818445009', -1, ' share it for anyone else who may need that functionality.', 3, '', 2, 'SendingOKNoReport', -1, 54, 255, 'dede', -1),
('2018-07-17 09:59:29', '2018-07-17 09:09:28', '2018-07-17 09:59:29', NULL, '00490020006B006E006F007700200074006800690073002000770061007300200061006C0072006500610064007900200061006E007300770065007200650064002C002000620075007400200049002000750073006500640020007400680069007300200061006E006400200065007800740065006E006400650064002000690074002000610020006C006900740074006C00650020006D006F0072006500200069006E0020006D007900200063006F0064006500200073006F0020007400680061007400200079006F00750020006400690064006E002700740020006800610076006500200073006500610072006300680020006200790020006F006E006C007900200074006800650020007500690064002E002000490020006A007500730074002000770061006E007400200074006F', '+6283865765051', 'Default_No_Compression', '0500033F0201', '+62818445009', -1, 'I know this was already answered, but I used this and extended it a little more in my code so that you didn\'t have search by only the uid. I just want to', 4, '', 1, 'SendingOK', -1, 55, 255, 'dede', -1),
('2018-07-17 09:59:30', '2018-07-17 09:09:28', '2018-07-17 09:59:30', NULL, '00200073006800610072006500200069007400200066006F007200200061006E0079006F006E006500200065006C00730065002000770068006F0020006D006100790020006E00650065006400200074006800610074002000660075006E006300740069006F006E0061006C006900740079002E', '+6283865765051', 'Default_No_Compression', '0500033F0202', '+62818445009', -1, ' share it for anyone else who may need that functionality.', 4, '', 2, 'SendingOK', -1, 56, 255, 'dede', -1),
('2018-07-18 08:25:00', '2018-07-18 08:24:50', '2018-07-18 08:25:00', NULL, '00740065007300740069006E00670020006D0065006C0061006C0075006900200066006F0072006D00200073006D0073', '08995313157', 'Default_No_Compression', '', '+62818445009', -1, 'testing melalui form sms', 5, '', 1, 'SendingOK', -1, 95, 255, 'Admin', -1),
('2018-07-18 08:48:07', '2018-07-18 08:47:55', '2018-07-18 08:48:07', NULL, '00740065007300740069006E00670020006C0061006700690020006D00610073002000620072006F0020006C006500770061007400200066006F0072006D0020', '083865765051', 'Default_No_Compression', '', '+62818445009', -1, 'testing lagi mas bro lewat form ', 6, '', 1, 'SendingOK', -1, 96, 255, 'Admin', -1),
('2018-07-18 08:49:12', '2018-07-18 08:49:00', '2018-07-18 08:49:12', NULL, '004100200073006500740020006F00660020006B00650079002F00760061006C00750065002000700061006900720073002000740068006100740020006D006100700020006100200067006900760065006E00200064006100740061005400790070006500200074006F00200069007400730020004D0049004D004500200074007900700065002C00200077006800690063006800200067006500740073002000730065006E007400200069006E00200074006800650020004100630063006500700074002000720065007100750065007300740020006800650061006400650072', '081576034054', 'Default_No_Compression', '', '+62818445009', -1, 'A set of key/value pairs that map a given dataType to its MIME type, which gets sent in the Accept request header', 7, '', 1, 'SendingOK', -1, 97, 255, 'Admin', -1),
('2018-07-18 08:51:47', '2018-07-18 08:51:15', '2018-07-18 08:51:47', NULL, '004100200073006500740020006F00660020006B00650079002F00760061006C00750065002000700061006900720073002000740068006100740020006D006100700020006100200067006900760065006E00200064006100740061005400790070006500200074006F00200069007400730020004D0049004D004500200074007900700065002C00200077006800690063006800200067006500740073002000730065006E007400200069006E00200074006800650020004100630063006500700074002000720065007100750065007300740020006800650061006400650072', '081578034054', 'Default_No_Compression', '', '+62818445009', -1, 'A set of key/value pairs that map a given dataType to its MIME type, which gets sent in the Accept request header', 8, '', 1, 'SendingOK', -1, 98, 255, 'Admin', -1),
('2018-07-18 08:56:23', '2018-07-18 08:55:50', '2018-07-18 08:56:23', NULL, '004100200073006500740020006F00660020006B00650079002F00760061006C00750065002000700061006900720073002000740068006100740020006D006100700020006100200067006900760065006E00200064006100740061005400790070006500200074006F00200069007400730020004D0049004D004500200074007900700065002C00200077006800690063006800200067006500740073002000730065006E007400200069006E00200074006800650020004100630063006500700074002000720065007100750065007300740020006800650061006400650072', '083818181831', 'Default_No_Compression', '', '+62818445009', -1, 'A set of key/value pairs that map a given dataType to its MIME type, which gets sent in the Accept request header', 9, '', 1, 'SendingOK', -1, 99, 255, 'Admin', -1),
('2018-07-18 09:23:21', '2018-07-18 09:00:04', '2018-07-18 09:23:21', NULL, '0049006E0020007400680069007300200070006F0073007400200049002000730068006F007700200079006F0075002000640065006C0065007400650020006D0075006C007400690070006C00650020007200650063006F007200640073002000660072006F006D0020006D007900730071006C0020006400610074006100620061007300650020006F006E00200074006800650020006200610073006900730020006F0066002000730065006C0065006300740065006400200063006800650063006B0062006F007800200069006E0020007000680070002E00200059006F007500200068006100760065002000730068006F00770020006C006F007400730020006F00660020007400750074006F007200690061006C0020006F006E002000740068006900730020007400680069006E', '081578034054', 'Default_No_Compression', '050003980301', '+62818445009', -1, 'In this post I show you delete multiple records from mysql database on the basis of selected checkbox in php. You have show lots of tutorial on this thin', 10, '', 1, 'SendingOK', -1, 100, 255, 'Admin', -1),
('2018-07-18 09:23:23', '2018-07-18 09:00:04', '2018-07-18 09:23:23', NULL, '00670073002000620075007400200074006F0064006100790020004900200068006100760065002000730068006F007700200079006F007500200068006F007700200074006F002000750073006500200041006A0061007800200061006E00640020004A0051007500650072007900200066006F0072002000640065006C0065007400650020006D0075006C007400690070006C00650020007200650063006F0072006400730020006F006E00200074006800650020006200610073006900730020006F006600200063006800650063006B0065006400200063006800650063006B0062006F0078006500730020006F006E0020006F006E0065002000730069006E0067006C006500200063006C00690063006B00200077006900740068006F007500740020007000610067006500200072', '081578034054', 'Default_No_Compression', '050003980302', '+62818445009', -1, 'gs but today I have show you how to use Ajax and JQuery for delete multiple records on the basis of checked checkboxes on one single click without page r', 10, '', 2, 'SendingOK', -1, 101, 255, 'Admin', -1),
('2018-07-18 09:23:24', '2018-07-18 09:00:04', '2018-07-18 09:23:24', NULL, '006500660072006500730068002E0020', '081578034054', 'Default_No_Compression', '050003980303', '+62818445009', -1, 'efresh. ', 10, '', 3, 'SendingOK', -1, 102, 255, 'Admin', -1),
('2018-07-18 09:23:26', '2018-07-18 09:09:07', '2018-07-18 09:23:26', NULL, '0049006E0020007400680069007300200070006F0073007400200049002000730068006F007700200079006F0075002000640065006C0065007400650020006D0075006C007400690070006C00650020007200650063006F007200640073002000660072006F006D0020006D007900730071006C0020006400610074006100620061007300650020006F006E00200074006800650020006200610073006900730020006F0066002000730065006C0065006300740065006400200063006800650063006B0062006F007800200069006E0020007000680070002E00200059006F007500200068006100760065002000730068006F00770020006C006F007400730020006F00660020007400750074006F007200690061006C0020006F006E002000740068006900730020007400680069006E', '081578034054', 'Default_No_Compression', '050003930301', '+62818445009', -1, 'In this post I show you delete multiple records from mysql database on the basis of selected checkbox in php. You have show lots of tutorial on this thin', 11, '', 1, 'SendingOK', -1, 103, 255, 'Admin', -1),
('2018-07-18 09:23:27', '2018-07-18 09:09:07', '2018-07-18 09:23:27', NULL, '00670073002000620075007400200074006F0064006100790020004900200068006100760065002000730068006F007700200079006F007500200068006F007700200074006F002000750073006500200041006A0061007800200061006E00640020004A0051007500650072007900200066006F0072002000640065006C0065007400650020006D0075006C007400690070006C00650020007200650063006F0072006400730020006F006E00200074006800650020006200610073006900730020006F006600200063006800650063006B0065006400200063006800650063006B0062006F0078006500730020006F006E0020006F006E0065002000730069006E0067006C006500200063006C00690063006B00200077006900740068006F007500740020007000610067006500200072', '081578034054', 'Default_No_Compression', '050003930302', '+62818445009', -1, 'gs but today I have show you how to use Ajax and JQuery for delete multiple records on the basis of checked checkboxes on one single click without page r', 11, '', 2, 'SendingOK', -1, 104, 255, 'Admin', -1),
('2018-07-18 09:23:29', '2018-07-18 09:09:07', '2018-07-18 09:23:29', NULL, '006500660072006500730068002E0020', '081578034054', 'Default_No_Compression', '050003930303', '+62818445009', -1, 'efresh. ', 11, '', 3, 'SendingOK', -1, 105, 255, 'Admin', -1),
('2018-07-18 10:03:35', '2018-07-18 10:03:16', '2018-07-18 10:03:35', NULL, '00540068006500200069006E0064006900760069006400750061006C0020007300690067006E0061006C00730020006F006E00200061002000730065007200690061006C00200070006F00720074002000610072006500200075006E00690064006900720065006300740069006F006E0061006C00200061006E00640020007700680065006E00200063006F006E006E0065006300740069006E0067002000740077006F0020006400650076006900630065007300200074006800650020006F0075007400700075007400730020006F00660020006F006E006500200064006500760069006300650020006D00750073007400200062006500200063006F006E006E0065006300740065006400200074006F002000740068006500200069006E00700075007400730020006F006600200074', '+628995313157', 'Default_No_Compression', '0500037F0301', '+62818445009', -1, 'The individual signals on a serial port are unidirectional and when connecting two devices the outputs of one device must be connected to the inputs of t', 12, '', 1, 'SendingOK', -1, 106, 255, 'Admin', -1),
('2018-07-18 10:03:36', '2018-07-18 10:03:16', '2018-07-18 10:03:36', NULL, '006800650020006F0074006800650072002E0020004400650076006900630065007300200061007200650020006400690076006900640065006400200069006E0074006F002000740077006F002000630061007400650067006F0072006900650073002000640061007400610020007400650072006D0069006E0061006C002000650071007500690070006D0065006E007400200028004400540045002900200061006E00640020006400610074006100200063006900720063007500690074002D007400650072006D0069006E006100740069006E0067002000650071007500690070006D0065006E0074002000280044004300450029002E002000410020006C0069006E00650020007400680061007400200069007300200061006E0020006F007500740070007500740020006F006E', '+628995313157', 'Default_No_Compression', '0500037F0302', '+62818445009', -1, 'he other. Devices are divided into two categories data terminal equipment (DTE) and data circuit-terminating equipment (DCE). A line that is an output on', 12, '', 2, 'SendingOK', -1, 107, 255, 'Admin', -1),
('2018-07-18 10:03:37', '2018-07-18 10:03:16', '2018-07-18 10:03:37', NULL, '002000610020004400540045002000640065007600690063006500200069007300200061006E00200069006E0070007500740020006F006E002000610020004400430045002000640065007600690063006500200061006E00640020007600690063006500200076006500720073006100200073006F0020006100200044004300450020006400650076006900630065002000630061006E00200062006500200063006F006E006E0065006300740065006400200074006F002000610020004400540045002000640065007600690063006500200077006900740068002000610020007300740072006100690067006800740020007700690072006500640020006300610062006C0065002E', '+628995313157', 'Default_No_Compression', '0500037F0303', '+62818445009', -1, ' a DTE device is an input on a DCE device and vice versa so a DCE device can be connected to a DTE device with a straight wired cable.', 12, '', 3, 'SendingOK', -1, 108, 255, 'Admin', -1);

--
-- Triggers `sms_sentitems`
--
DELIMITER $$
CREATE TRIGGER `update_stat_out` AFTER INSERT ON `sms_sentitems` FOR EACH ROW BEGIN

IF (new.StatusError = -1) THEN
	UPDATE sms_full_outbox SET sms_full_outbox.Status = 1
    WHERE sms_full_outbox.ID = new.ID;
ELSE
	UPDATE sms_full_outbox SET sms_full_outbox.Status = 2
    WHERE sms_full_outbox.ID = new.ID;
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `vreservasi`
-- (See below for the actual view)
--
CREATE TABLE `vreservasi` (
`id_rsv` bigint(20)
,`nores` varchar(15)
,`waktu_rsv` datetime
,`nourut` int(4)
,`kode_cekin` varchar(10)
,`norm` varchar(10)
,`nama` varchar(200)
,`gender` varchar(1)
,`tgl_lahir` date
,`notelp` varchar(15)
,`alamat` varchar(255)
,`propinsi` int(11)
,`kota` int(11)
,`kec` int(11)
,`kel` int(11)
,`id_jadwal` int(11)
,`id_hari` tinyint(4)
,`id_dokter` int(8)
,`nama_dokter` varchar(100)
,`id_klinik` int(4)
,`nama_klinik` varchar(100)
,`kode_poli` varchar(5)
,`id_sebab` tinyint(2)
,`sebab` varchar(100)
,`jns_id` int(3)
,`jns_nama` varchar(100)
,`id_jns_layan` tinyint(4)
,`jns_layan` varchar(50)
,`status` tinyint(2)
,`sync` tinyint(1)
,`jenis_rsv` varchar(5)
,`user_id` int(11)
,`first_update` timestamp
,`last_update` datetime
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vsms`
-- (See below for the actual view)
--
CREATE TABLE `vsms` (
`ID` int(11) unsigned
,`Number` varchar(20)
,`TextDecoded` mediumtext
,`UpdatedInDB` timestamp
,`Coding` varchar(22)
,`Class` int(11)
,`stat` varchar(5)
,`Type` varchar(6)
);

-- --------------------------------------------------------

--
-- Structure for view `vreservasi`
--
DROP TABLE IF EXISTS `vreservasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `vreservasi`  AS  select `res_treservasi`.`id_rsv` AS `id_rsv`,`res_treservasi`.`nores` AS `nores`,`res_treservasi`.`waktu_rsv` AS `waktu_rsv`,`res_treservasi`.`nourut` AS `nourut`,`res_treservasi`.`kode_cekin` AS `kode_cekin`,`res_tpasien`.`norm` AS `norm`,`res_tpasien`.`nama` AS `nama`,`res_tpasien`.`gender` AS `gender`,`res_tpasien`.`tgl_lahir` AS `tgl_lahir`,`res_tpasien`.`notelp` AS `notelp`,`res_tpasien`.`alamat` AS `alamat`,`res_tpasien`.`propinsi` AS `propinsi`,`res_tpasien`.`kota` AS `kota`,`res_tpasien`.`kec` AS `kec`,`res_tpasien`.`kel` AS `kel`,`res_jadwal`.`id_jadwal` AS `id_jadwal`,`res_jadwal`.`id_hari` AS `id_hari`,`res_refdokter`.`id_dokter` AS `id_dokter`,`res_refdokter`.`nama_dokter` AS `nama_dokter`,`res_refklinik`.`id_klinik` AS `id_klinik`,`res_refklinik`.`nama_klinik` AS `nama_klinik`,`res_refklinik`.`kode_poli` AS `kode_poli`,`res_sebab_sakit`.`id_sebab` AS `id_sebab`,`res_sebab_sakit`.`sebab` AS `sebab`,`res_jns_pasien`.`jns_id` AS `jns_id`,`res_jns_pasien`.`jns_nama` AS `jns_nama`,`res_refjns_layan`.`id_jns_layan` AS `id_jns_layan`,`res_refjns_layan`.`jns_layan` AS `jns_layan`,`res_treservasi`.`status` AS `status`,`res_treservasi`.`sync` AS `sync`,`res_treservasi`.`jenis_rsv` AS `jenis_rsv`,`res_treservasi`.`user_id` AS `user_id`,`res_treservasi`.`first_update` AS `first_update`,`res_treservasi`.`last_update` AS `last_update` from (((((((`res_treservasi` left join `res_tpasien` on((`res_treservasi`.`norm` = `res_tpasien`.`norm`))) left join `res_sebab_sakit` on((`res_treservasi`.`sebab_id` = `res_sebab_sakit`.`id_sebab`))) left join `res_jadwal` on((`res_treservasi`.`jadwal_id` = `res_jadwal`.`id_jadwal`))) left join `res_jns_pasien` on((`res_treservasi`.`jns_pasien_id` = `res_jns_pasien`.`jns_id`))) left join `res_refdokter` on((`res_jadwal`.`dokter_id` = `res_refdokter`.`id_dokter`))) left join `res_refklinik` on((`res_jadwal`.`klinik_id` = `res_refklinik`.`id_klinik`))) left join `res_refjns_layan` on((`res_jadwal`.`jns_layan_id` = `res_refjns_layan`.`id_jns_layan`))) ;

-- --------------------------------------------------------

--
-- Structure for view `vsms`
--
DROP TABLE IF EXISTS `vsms`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `vsms`  AS  select `a`.`ID` AS `ID`,`a`.`SenderNumber` AS `Number`,`a`.`TextDecoded` AS `TextDecoded`,`a`.`UpdatedInDB` AS `UpdatedInDB`,`a`.`Coding` AS `Coding`,`a`.`Class` AS `Class`,`a`.`Processed` AS `stat`,'inbox' AS `Type` from `sms_full_inbox` `a` union select `b`.`ID` AS `ID`,`b`.`DestinationNumber` AS `Number`,`b`.`TextDecoded` AS `TextDecoded`,`b`.`UpdatedInDB` AS `UpdatedInDB`,`b`.`Coding` AS `Coding`,`b`.`Class` AS `Class`,`b`.`Status` AS `stat`,'outbox' AS `TYPE` from `sms_full_outbox` `b` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_login_attempts`
--
ALTER TABLE `auth_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_users`
--
ALTER TABLE `auth_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `res_jadwal`
--
ALTER TABLE `res_jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `jns_layan_id` (`jns_layan_id`),
  ADD KEY `res_jadwal_ibfk_1` (`dokter_id`),
  ADD KEY `res_jadwal_ibfk_2` (`klinik_id`);

--
-- Indexes for table `res_jns_pasien`
--
ALTER TABLE `res_jns_pasien`
  ADD PRIMARY KEY (`jns_id`);

--
-- Indexes for table `res_refdokter`
--
ALTER TABLE `res_refdokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indexes for table `res_refjns_layan`
--
ALTER TABLE `res_refjns_layan`
  ADD PRIMARY KEY (`id_jns_layan`);

--
-- Indexes for table `res_refklinik`
--
ALTER TABLE `res_refklinik`
  ADD PRIMARY KEY (`id_klinik`);

--
-- Indexes for table `res_sebab_sakit`
--
ALTER TABLE `res_sebab_sakit`
  ADD PRIMARY KEY (`id_sebab`);

--
-- Indexes for table `res_tgl_libur`
--
ALTER TABLE `res_tgl_libur`
  ADD PRIMARY KEY (`id_libur`);

--
-- Indexes for table `res_tpasien`
--
ALTER TABLE `res_tpasien`
  ADD PRIMARY KEY (`norm`);

--
-- Indexes for table `res_treservasi`
--
ALTER TABLE `res_treservasi`
  ADD PRIMARY KEY (`id_rsv`),
  ADD KEY `norm` (`norm`),
  ADD KEY `id_jadwal` (`jadwal_id`),
  ADD KEY `jns_pasien` (`jns_pasien_id`),
  ADD KEY `sebab` (`sebab_id`);

--
-- Indexes for table `sms_full_inbox`
--
ALTER TABLE `sms_full_inbox`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sms_full_outbox`
--
ALTER TABLE `sms_full_outbox`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `outbox_date` (`SendingDateTime`,`SendingTimeOut`),
  ADD KEY `outbox_sender` (`SenderID`);

--
-- Indexes for table `sms_gammu`
--
ALTER TABLE `sms_gammu`
  ADD PRIMARY KEY (`Version`);

--
-- Indexes for table `sms_inbox`
--
ALTER TABLE `sms_inbox`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sms_outbox`
--
ALTER TABLE `sms_outbox`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `outbox_date` (`SendingDateTime`,`SendingTimeOut`),
  ADD KEY `outbox_sender` (`SenderID`(250));

--
-- Indexes for table `sms_outbox_multipart`
--
ALTER TABLE `sms_outbox_multipart`
  ADD PRIMARY KEY (`ID`,`SequencePosition`);

--
-- Indexes for table `sms_phones`
--
ALTER TABLE `sms_phones`
  ADD PRIMARY KEY (`IMEI`);

--
-- Indexes for table `sms_sentitems`
--
ALTER TABLE `sms_sentitems`
  ADD PRIMARY KEY (`ID`,`SequencePosition`),
  ADD KEY `sentitems_date` (`DeliveryDateTime`),
  ADD KEY `sentitems_tpmr` (`TPMR`),
  ADD KEY `sentitems_dest` (`DestinationNumber`),
  ADD KEY `sentitems_sender` (`SenderID`(250));

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_login_attempts`
--
ALTER TABLE `auth_login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_users`
--
ALTER TABLE `auth_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `res_jadwal`
--
ALTER TABLE `res_jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `res_refdokter`
--
ALTER TABLE `res_refdokter`
  MODIFY `id_dokter` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT for table `res_refjns_layan`
--
ALTER TABLE `res_refjns_layan`
  MODIFY `id_jns_layan` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `res_refklinik`
--
ALTER TABLE `res_refklinik`
  MODIFY `id_klinik` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=570;

--
-- AUTO_INCREMENT for table `res_tgl_libur`
--
ALTER TABLE `res_tgl_libur`
  MODIFY `id_libur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `res_treservasi`
--
ALTER TABLE `res_treservasi`
  MODIFY `id_rsv` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `sms_full_inbox`
--
ALTER TABLE `sms_full_inbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sms_full_outbox`
--
ALTER TABLE `sms_full_outbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `sms_inbox`
--
ALTER TABLE `sms_inbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sms_outbox`
--
ALTER TABLE `sms_outbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  ADD CONSTRAINT `auth_users_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`),
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `auth_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `res_jadwal`
--
ALTER TABLE `res_jadwal`
  ADD CONSTRAINT `res_jadwal_ibfk_1` FOREIGN KEY (`dokter_id`) REFERENCES `res_refdokter` (`id_dokter`),
  ADD CONSTRAINT `res_jadwal_ibfk_2` FOREIGN KEY (`klinik_id`) REFERENCES `res_refklinik` (`id_klinik`),
  ADD CONSTRAINT `res_jadwal_ibfk_3` FOREIGN KEY (`jns_layan_id`) REFERENCES `res_refjns_layan` (`id_jns_layan`);

--
-- Constraints for table `res_treservasi`
--
ALTER TABLE `res_treservasi`
  ADD CONSTRAINT `res_treservasi_ibfk_1` FOREIGN KEY (`norm`) REFERENCES `res_tpasien` (`norm`),
  ADD CONSTRAINT `res_treservasi_ibfk_2` FOREIGN KEY (`jadwal_id`) REFERENCES `res_jadwal` (`id_jadwal`),
  ADD CONSTRAINT `res_treservasi_ibfk_3` FOREIGN KEY (`jns_pasien_id`) REFERENCES `res_jns_pasien` (`jns_id`),
  ADD CONSTRAINT `res_treservasi_ibfk_5` FOREIGN KEY (`sebab_id`) REFERENCES `res_sebab_sakit` (`id_sebab`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
