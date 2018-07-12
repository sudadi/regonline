-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 12, 2018 at 03:45 PM
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
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, 'uLqRuZhJcW3CwF9799i.Te', 1268889823, 1531379511, 1, 'Admin', 'istrator', 'ADMIN', '0'),
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
(19, '133469', 'ORT-19', '2018-07-19 15:00:00', 3, 0, NULL, 2, 9, 1, '2018-07-12 07:10:11', NULL, 2, 0, 'WEB');

-- --------------------------------------------------------

--
-- Table structure for table `sms_daemons`
--

CREATE TABLE `sms_daemons` (
  `Start` text NOT NULL,
  `Info` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms_full_inbox`
--

CREATE TABLE `sms_full_inbox` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ReceivingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
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
('2011-11-29 17:40:57', '2011-11-29 17:40:04', '0053006500640061006E0067006B0061006E0020006B0065006C00650062006900680061006E0020006D0065006E0067006900720069006D0020006C006F006E00670020007400650078007400200053004D0053002000640065006E00670061006E002000710075006500720079002000530051004C0020006100640061006C00610068002000720075006E006E0069006E0067002000740069006D0065002000790061006E00670020006A0061007500680020006C006500620069006800200063006500700061007400200064006900620061006E00640069006E0067006B0061006E00200063006F006D006D0061006E00640020003F00670061006D006D0075002D0073006D00730064002D0069006E006A006500630074003F002E0020004E0061006D0075006E002E002E00200064', '+628995313157', 'Default_No_Compression', '050003030401', '+6289644000001', -1, 'Sedangkan kelebihan mengirim long text SMS dengan query SQL adalah running time yang jauh lebih cepat dibandingkan command ?gammu-smsd-inject?. Namun.. di sisi lain, kekurangannya adalah agak rumitnya membuat script untuk melakukan hal ini. Sedangkan kelebihan dari command ?gammu-smsd-inject? adalah perintahnya jauh lebih mudah dibandingkan via script query SQL. Akan tetapi mengingat kelebihannya yang lebih efisien, saya kira kesulitan untuk membuat script pengiriman long text SMS dengan query tak perlu dipermasalahkan, toh? saya akan beberkan caranya di sini', 1, '', 'false'),
('0000-00-00 00:00:00', '2011-11-29 17:47:04', '0061006B006800690072006E00790061002000730075006B0073006500730020006A00750067006100200063006F0069002E002E002E', '+6289637032339', 'Default_No_Compression', '', '+6289644000001', -1, 'akhirnya sukses juga coi...', 2, '', 'false'),
('0000-00-00 00:00:00', '2011-11-29 17:53:59', '007700690073002000770065006E00670069002C0020006E00640061006E006700200074007500720075002E002E002E', '+6285292213020', 'Default_No_Compression', '', '+6281100000', -1, 'wis wengi, ndang turu...', 3, '', 'false'),
('0000-00-00 00:00:00', '2011-11-30 03:59:57', '00540045005300540049004E004700200041004A00410020004D00410053002000420052004F002E002E', '+6289673438254', 'Default_No_Compression', '', '+6289644000001', 1, 'TESTING AJA MAS BRO..', 4, '', 'false'),
('2011-11-30 06:12:48', '2011-11-30 04:01:38', '0046006F00720020006C006F006E0067002000740065007800740020006D006500730073006100670065002C00200074006800650020005500440048002000730074006100720074007300200077006900740068002000300035003000300030003300200066006F006C006C006F00770065006400200062007900200062007900740065002000610073002000610020006D0065007300730061006700650020007200650066006500720065006E00630065002000280079006F0075002000630061006E002000700075007400200061006E0079007400680069006E0067002000740068006500720065002C0020006200750074002000690074002000730068006F0075006C006400200062006500200064006900660066006500720065006E007400200066006F00720020006500610063', '+6283869591597', 'Default_No_Compression', '050003FE0201', '+628315000032', 1, 'For long text message, the UDH starts with 050003 followed by byte as a message reference (you can put anything there, but it should be different for each message, D3 in following example), byte for number', 5, '', 'false'),
('0000-00-00 00:00:00', '2011-11-30 05:39:16', '0046006F00720020006C006F006E0067002000740065007800740020006D006500730073006100670065', '+6289673438246', 'Default_No_Compression', '', '+628964011092', 1, 'For long text message', 6, '', 'false'),
('2011-11-30 06:12:51', '2011-11-30 05:46:42', '0046006F00720020006C006F006E0067002000740065007800740020006D006500730073006100670065002C00200074006800650020005500440048002000730074006100720074007300200077006900740068002000300035003000300030003300200066006F006C006C006F00770065006400200062007900200062007900740065002000610073002000610020006D0065007300730061006700650020007200650066006500720065006E00630065002000280079006F0075002000630061006E002000700075007400200061006E0079007400680069006E0067002000740068006500720065002C0020006200750074002000690074002000730068006F0075006C006400200062006500200064006900660066006500720065006E007400200066006F00720020006500610063', '+6289673438257', 'Default_No_Compression', '050003100201', '+628964011091', 1, 'For long text message, the UDH starts with 050003 followed by byte as a message reference (you can put anything there, but it should be different for each message, D3 in following example), byte for number of message', 7, '', 'false'),
('0000-00-00 00:00:00', '2012-05-07 06:32:08', '005300690070002E0070006100670069', '+628995313157', 'Default_No_Compression', '', '+6289644000001', -1, 'Sip.pagi', 8, '', 'false'),
('0000-00-00 00:00:00', '2012-05-07 06:45:16', '005300690070002E0070006100670069', '+628995313157', 'Default_No_Compression', '', '+6289644000001', -1, 'Sip.pagi', 9, '', 'false');

--
-- Triggers `sms_full_inbox`
--
DELIMITER $$
CREATE TRIGGER `full_inbox_before_ins` BEFORE INSERT ON `sms_full_inbox` FOR EACH ROW begin

IF NEW.ReceivingDateTime = '0000-00-00 00:00:00' THEN
        SET NEW.ReceivingDateTime = CURRENT_TIMESTAMP();
END IF;
end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_full_outbox`
--

CREATE TABLE `sms_full_outbox` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InsertIntoDB` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SendingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
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
  `SendingTimeOut` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `DeliveryReport` enum('default','yes','no') DEFAULT 'default',
  `CreatorID` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms_gammu`
--

CREATE TABLE `sms_gammu` (
  `Version` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sms_gammu`
--

INSERT INTO `sms_gammu` (`Version`) VALUES
(13);

-- --------------------------------------------------------

--
-- Table structure for table `sms_inbox`
--

CREATE TABLE `sms_inbox` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ReceivingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
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
-- Triggers `sms_inbox`
--
DELIMITER $$
CREATE TRIGGER `inbox_before_ins` BEFORE INSERT ON `sms_inbox` FOR EACH ROW begin

IF NEW.ReceivingDateTime = '0000-00-00 00:00:00' THEN
        SET NEW.ReceivingDateTime = CURRENT_TIMESTAMP();
END IF;

if NEW.UDH=NULL OR RIGHT(NEW.UDH,2)='01' OR NEW.UDH='' THEN
INSERT INTO `sms_full_inbox`(`UpdatedInDB`,`ReceivingDateTime`,`Text`,`SenderNumber`,`Coding`,`UDH`,`SMSCNumber`,`Class`,`TextDecoded`,`ID`,`RecipientID`,`Processed`) VALUES
(new.UpdatedInDB, new.ReceivingDateTime, new.TEXT, new.SenderNumber,
new.Coding, new.UDH, new.SMSCNumber, new.Class, new.TextDecoded,
new.ID, new.RecipientID, new.Processed);

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
  `InsertIntoDB` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SendingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
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
  `SendingTimeOut` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `DeliveryReport` enum('default','yes','no') DEFAULT 'default',
  `CreatorID` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
CREATE TRIGGER `outbox_before_ins_tr` BEFORE INSERT ON `sms_outbox` FOR EACH ROW BEGIN
 IF NEW.InsertIntoDB = '0000-00-00 00:00:00' THEN
        SET NEW.InsertIntoDB = CURRENT_TIMESTAMP();
    END IF;
    IF NEW.SendingDateTime = '0000-00-00 00:00:00' THEN
        SET NEW.SendingDateTime = CURRENT_TIMESTAMP();
    END IF;
    IF NEW.SendingTimeOut = '0000-00-00 00:00:00' THEN
        SET NEW.SendingTimeOut = CURRENT_TIMESTAMP();
    END IF;
 	
 if length(new.TextDecoded)>160 then
    set @countM=hex((length(new.TextDecoded) div 154)+1);
    set @remains=substring(new.TextDecoded from 154);
    set @randomUDH=hex(FLOOR(1 + (RAND() * 254))); /* get random header '050003D30501';*/
    
  if length(@countM)=1 then
    set @countM=CONCAT('0',@countM);

  end if;

  if length(@remains)>0 then
   set new.UDH=concat('050003',@randomUDH, @countM,'01');
   set new.TextDecoded=left(new.TextDecoded,153);
   set new.MultiPart='true';
   set new.RelativeValidity=255;
  else
    set new.MultiPart='false';
  end if;
 
  end if;
END
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
  `SequencePosition` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sms_outbox_multipart`
--

INSERT INTO `sms_outbox_multipart` (`Text`, `Coding`, `UDH`, `Class`, `TextDecoded`, `ID`, `SequencePosition`) VALUES
(NULL, 'Default_No_Compression', '050003A70303', -1, 'Di Kota Solo, Yaitu Universitas Sebelas Maret.', 9, 3),
(NULL, 'Default_No_Compression', '050003A70302', -1, 'Saya Cintai. Rumah Saya Di Colomadu Karanganyar. Saya Lahir Di Boyolali Tiga Puluh Tahun Yang Lalu. Sekarang Saya Mengajar Di Perguruan Tinggi', 11, 2),
(NULL, 'Default_No_Compression', '050003A70303', -1, 'Di Kota Solo, Yaitu Universitas Sebelas Maret.', 11, 3);

-- --------------------------------------------------------

--
-- Table structure for table `sms_pbk`
--

CREATE TABLE `sms_pbk` (
  `ID` int(11) NOT NULL,
  `GroupID` int(11) NOT NULL DEFAULT '-1',
  `Name` text NOT NULL,
  `Number` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms_pbk_groups`
--

CREATE TABLE `sms_pbk_groups` (
  `Name` text NOT NULL,
  `ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sms_phones`
--

CREATE TABLE `sms_phones` (
  `ID` text NOT NULL,
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InsertIntoDB` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `TimeOut` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Send` enum('yes','no') NOT NULL DEFAULT 'no',
  `Receive` enum('yes','no') NOT NULL DEFAULT 'no',
  `IMEI` varchar(35) NOT NULL,
  `Client` text NOT NULL,
  `Battery` int(11) NOT NULL DEFAULT '-1',
  `Signal` int(11) NOT NULL DEFAULT '-1',
  `Sent` int(11) NOT NULL DEFAULT '0',
  `Received` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sms_phones`
--

INSERT INTO `sms_phones` (`ID`, `UpdatedInDB`, `InsertIntoDB`, `TimeOut`, `Send`, `Receive`, `IMEI`, `Client`, `Battery`, `Signal`, `Sent`, `Received`) VALUES
('', '2012-05-07 07:54:31', '2012-05-07 07:52:06', '2012-05-07 07:54:41', 'yes', 'yes', '354136020259739', 'Gammu 1.30.90, Windows Server 2007 SP1, GCC 4.6, MinGW 3.11', 0, 36, 0, 0);

--
-- Triggers `sms_phones`
--
DELIMITER $$
CREATE TRIGGER `phones_timestamp` BEFORE INSERT ON `sms_phones` FOR EACH ROW BEGIN
    IF NEW.InsertIntoDB = '0000-00-00 00:00:00' THEN
        SET NEW.InsertIntoDB = CURRENT_TIMESTAMP();
    END IF;
    IF NEW.TimeOut = '0000-00-00 00:00:00' THEN
        SET NEW.TimeOut = CURRENT_TIMESTAMP();
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sms_sentitems`
--

CREATE TABLE `sms_sentitems` (
  `UpdatedInDB` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `InsertIntoDB` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `SendingDateTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
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
  `CreatorID` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sms_sentitems`
--

INSERT INTO `sms_sentitems` (`UpdatedInDB`, `InsertIntoDB`, `SendingDateTime`, `DeliveryDateTime`, `Text`, `DestinationNumber`, `Coding`, `UDH`, `SMSCNumber`, `Class`, `TextDecoded`, `ID`, `SenderID`, `SequencePosition`, `Status`, `StatusError`, `TPMR`, `RelativeValidity`, `CreatorID`) VALUES
('2011-11-29 06:35:11', '2011-11-29 06:34:55', '2011-11-29 06:35:11', NULL, '007000610069006A006F0020006B0061006D0070007200650074002000730075006E00640065006C00200062006F006C006F006E0067', '628995313157', 'Default_No_Compression', '', '+6289644000001', -1, 'paijo kampret sundel bolong', 1, '', 1, 'SendingOKNoReport', -1, 86, 255, ''),
('2011-11-29 06:40:17', '2011-11-29 06:40:03', '2011-11-29 06:40:17', NULL, '002A004C006100790061006E0061006E00200069006E006900200064006900730065006400690061006B0061006E0020006F006C006500680020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002E002000480061006C0061006D0061006E0020004100770061006C00200069006E00690020006A00750067006100200064006900730065006400690061006B0061006E0020006F006C006500680020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002E0020007C002000530065006D007500610020006C006100790061006E0061006E0020006C00610069006E002000790061006E006700200074006900640061006B0020006D0065006D0069006C0069006B0069002000740061006E006400610020201C002A201D00200061006B0061006E0020006D0065006E0075006A00750020006B0065002000730069007400750073002000770065006200200070006900680061006B0020006B00650074006900670061002C002000790061006E00670020006B006F006E00740065006E006E007900610020006D0075006E0067006B0069006E00200074006900640061006B0020007300650073007500610069002000640065006E00670061006E00200075006E00640061006E0067002D0075006E00640061006E0067002000640069002000770069006C006100790061006800200041006E00640061002E00200041006E00640061002C002000620075006B0061006E0020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002C002000620065007200740061006E006700670075006E00670020006A0061007700610062002000700065006E007500680020006100740061007300200061006B0073006500730020006B0065002000640061006E002000700065006E006700670075006E00610061006E002000730069007400750073002000770065006200200070006900680061006B0020006B00650074006900670061002E000D000A000D000A', '085292213020', 'Default_No_Compression', '', '+6289644000001', -1, '*Layanan ini disediakan oleh PT Yahoo Indonesia. Halaman Awal ini juga disediakan oleh PT Yahoo Indonesia. | Semua layanan lain yang tidak memiliki tanda “*” akan menuju ke situs web pihak ketiga, yang kontennya mungkin tidak sesuai dengan undang-undang di wilayah Anda. Anda, bukan PT Yahoo Indonesia, bertanggung jawab penuh atas akses ke dan penggunaan situs web pihak ketiga.\r\n\r\n', 2, '', 1, 'SendingOKNoReport', -1, 87, 255, ''),
('2011-11-29 06:41:23', '2011-11-29 06:40:51', '2011-11-29 06:41:23', NULL, '002A004C006100790061006E0061006E00200069006E006900200064006900730065006400690061006B0061006E0020006F006C006500680020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002E002000480061006C0061006D0061006E0020004100770061006C00200069006E00690020006A00750067006100200064006900730065006400690061006B0061006E0020006F006C006500680020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002E0020007C002000530065006D007500610020006C006100790061006E0061006E0020006C00610069006E002000790061006E006700200074006900640061006B0020006D0065006D0069006C0069006B0069002000740061006E006400610020201C002A201D00200061006B0061006E0020006D0065006E0075006A00750020006B0065002000730069007400750073002000770065006200200070006900680061006B0020006B00650074006900670061002C002000790061006E00670020006B006F006E00740065006E006E007900610020006D0075006E0067006B0069006E00200074006900640061006B0020007300650073007500610069002000640065006E00670061006E00200075006E00640061006E0067002D0075006E00640061006E0067002000640069002000770069006C006100790061006800200041006E00640061002E00200041006E00640061002C002000620075006B0061006E0020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002C002000620065007200740061006E006700670075006E00670020006A0061007700610062002000700065006E007500680020006100740061007300200061006B0073006500730020006B0065002000640061006E002000700065006E006700670075006E00610061006E002000730069007400750073002000770065006200200070006900680061006B0020006B00650074006900670061002E000D000A000D000A', '08995313157', 'Default_No_Compression', '', '+6289644000001', -1, '*Layanan ini disediakan oleh PT Yahoo Indonesia. Halaman Awal ini juga disediakan oleh PT Yahoo Indonesia. | Semua layanan lain yang tidak memiliki tanda “*” akan menuju ke situs web pihak ketiga, yang kontennya mungkin tidak sesuai dengan undang-undang di wilayah Anda. Anda, bukan PT Yahoo Indonesia, bertanggung jawab penuh atas akses ke dan penggunaan situs web pihak ketiga.\r\n\r\n', 3, '', 1, 'SendingOKNoReport', -1, 88, 255, ''),
('2011-11-29 07:13:21', '2011-11-29 07:12:56', '2011-11-29 07:13:21', NULL, 'EF9F9F9FEFEFFDEFEDFAFAEFEFDFEFEFFAEFEFEFCFFEEF9FEF9F9F9FFAFAEFEFEFEFFAFDEFEDFAFAEFEFDFEFEFFAEFEFEFCFFEEF9FEFEFDFFAEF9F9F9FEF9FEFFAEFEFFD9FEFDFEFEFEFFAFD9FEFEFEFEF9F9FEFDFEFEFFEEFEFEFEFEBEFEF9FEFDFEF9FEF9FEFEFEFDFEF9FEFEFEFEFEFDAEFFEEF9FFDDFFAEFEFDAEFEFFD9FEFCFEFEF9F9FFAFD9FFAFD9FFBEF9FEFEFFAEFEFEFCFFEEF9FFBDFFAEFEFEFEF9FABEFDFEFFAFAEF9FFEEFFEFD9FEFDFEFEFAAEFEFEFEFFEAFEFFAEFFEEFFAEF', '628995313157', 'Default_No_Compression', '', '+6289644000001', -1, '龟﷯﫯﫯쿾龟﫺﫽﫺���ﻯ鿯﫯龟鿯鿯﫯鿯���﫽鿯鿯���﷟﫯ﶟ龟﫽鿺ﶟﯯ鿯ﻯ鿻���龫﫯鿾ﶟꫯ꿯﫯ﻯ﫯', 4, '', 1, 'SendingOKNoReport', -1, 89, 255, ''),
('2011-11-29 07:14:20', '2011-11-29 07:14:06', '2011-11-29 07:14:20', NULL, 'EF9F9F9FEFEFFDEFEDFAFAEFEFDFEFEFFAEFEFEFCFFEEF9F', '628995313157', 'Default_No_Compression', '', '+6289644000001', -1, '龟﷯﫯﫯쿾', 5, '', 1, 'SendingOKNoReport', -1, 90, 255, ''),
('2011-11-29 07:15:57', '2011-11-29 07:15:37', '2011-11-29 07:15:57', NULL, '002A004C006100790061006E0061006E00200069006E006900200064006900730065006400690061006B0061006E0020006F006C006500680020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002E', '628995313157', 'Default_No_Compression', '', '+6289644000001', -1, '*Layanan ini disediakan oleh PT Yahoo Indonesia.', 6, '', 1, 'SendingOKNoReport', -1, 91, 255, ''),
('2011-11-29 07:16:33', '2011-11-29 07:16:28', '2011-11-29 07:16:33', NULL, '002A004C006100790061006E0061006E00200069006E006900200064006900730065006400690061006B0061006E0020006F006C006500680020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002E002000480061006C0061006D0061006E0020004100770061006C00200069006E00690020006A00750067006100200064006900730065006400690061006B0061006E0020006F006C006500680020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002E0020007C002000530065006D007500610020006C006100790061006E0061006E0020006C00610069006E002000790061006E006700200074006900640061006B0020006D0065006D0069006C0069006B0069002000740061006E006400610020201C002A201D00200061006B0061006E0020006D0065006E0075006A00750020006B0065002000730069007400750073002000770065006200200070006900680061006B0020006B00650074006900670061002C002000790061006E00670020006B006F006E00740065006E006E007900610020006D0075006E0067006B0069006E00200074006900640061006B0020007300650073007500610069002000640065006E00670061006E00200075006E00640061006E0067002D0075006E00640061006E0067002000640069002000770069006C006100790061006800200041006E00640061002E00200041006E00640061002C002000620075006B0061006E0020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002C002000620065007200740061006E006700670075006E00670020006A0061007700610062002000700065006E007500680020006100740061007300200061006B0073006500730020006B0065002000640061006E002000700065006E006700670075006E00610061006E002000730069007400750073002000770065006200200070006900680061006B0020006B00650074006900670061002E', '628995313157', 'Default_No_Compression', '', '+6289644000001', -1, '*Layanan ini disediakan oleh PT Yahoo Indonesia. Halaman Awal ini juga disediakan oleh PT Yahoo Indonesia. | Semua layanan lain yang tidak memiliki tanda “*” akan menuju ke situs web pihak ketiga, yang kontennya mungkin tidak sesuai dengan undang-undang di wilayah Anda. Anda, bukan PT Yahoo Indonesia, bertanggung jawab penuh atas akses ke dan penggunaan situs web pihak ketiga.', 7, '', 1, 'SendingOKNoReport', -1, 92, 255, ''),
('2011-11-29 07:20:09', '2011-11-29 07:19:42', '2011-11-29 07:20:09', NULL, '002A004C006100790061006E0061006E00200069006E006900200064006900730065006400690061006B0061006E0020006F006C006500680020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002E002000480061006C0061006D0061006E0020004100770061006C00200069006E00690020006A00750067006100200064006900730065006400690061006B0061006E0020006F006C006500680020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002E0020007C002000530065006D007500610020006C006100790061006E0061006E0020006C00610069006E002000790061006E006700200074006900640061006B0020006D0065006D0069006C0069006B0069002000740061006E006400610020201C002A201D00200061006B0061006E0020006D0065006E0075006A00750020006B0065002000730069007400750073002000770065006200200070006900680061006B0020006B00650074006900670061002C002000790061006E00670020006B006F006E00740065006E006E007900610020006D0075006E0067006B0069006E00200074006900640061006B0020007300650073007500610069002000640065006E00670061006E00200075006E00640061006E0067002D0075006E00640061006E0067002000640069002000770069006C006100790061006800200041006E00640061002E00200041006E00640061002C002000620075006B0061006E0020005000540020005900610068006F006F00200049006E0064006F006E0065007300690061002C002000620065007200740061006E006700670075006E00670020006A0061007700610062002000700065006E007500680020006100740061007300200061006B0073006500730020006B0065002000640061006E002000700065006E006700670075006E00610061006E002000730069007400750073002000770065006200200070006900680061006B0020006B00650074006900670061002E', '628995313157', 'Default_No_Compression', '', '+6289644000001', -1, '*Layanan ini disediakan oleh PT Yahoo Indonesia. Halaman Awal ini juga disediakan oleh PT Yahoo Indonesia. | Semua layanan lain yang tidak memiliki tanda “*” akan menuju ke situs web pihak ketiga, yang kontennya mungkin tidak sesuai dengan undang-undang di wilayah Anda. Anda, bukan PT Yahoo Indonesia, bertanggung jawab penuh atas akses ke dan penggunaan situs web pihak ketiga.', 8, '', 1, 'SendingOKNoReport', -1, 93, 255, ''),
('2011-11-29 07:42:18', '2011-11-29 07:41:46', '2011-11-29 07:42:18', NULL, '005000650072006B0065006E0061006C006B0061006E0020004E0061006D00610020005300610079006100200052006F0073006900680061006E00200041007200690020005900750061006E0061002E002000530061007900610020004D0065006D0069006C0069006B00690020005400690067006100200041006E0061006B002C00200044007500610020004400690061006E0074006100720061006E007900610020004C0061006B0069002D004C0061006B0069002000440061006E002000530061007400750020004F00720061006E006700200050006500720065006D007000750061006E002E002000530061007900610020004A007500670061002000500075006E00790061002000530065006F00720061006E0067002000490073007400720069002000590061006E00670020', '6285292213020', 'Default_No_Compression', '050003A70301', '+6289644000001', -1, 'Perkenalkan Nama Saya Rosihan Ari Yuana. Saya Memiliki Tiga Anak, Dua Diantaranya Laki-Laki Dan Satu Orang Perempuan. Saya Juga Punya Seorang Istri Yang ', 9, '', 1, 'SendingOKNoReport', -1, 94, 255, 'Gammu'),
('2011-11-29 07:52:51', '2011-11-29 07:52:39', '2011-11-29 07:52:51', NULL, '005000650072006B0065006E0061006C006B0061006E0020004E0061006D00610020005300610079006100200052006F0073006900680061006E00200041007200690020005900750061006E0061002E002000530061007900610020004D0065006D0069006C0069006B00690020005400690067006100200041006E0061006B002C00200044007500610020004400690061006E0074006100720061006E007900610020004C0061006B0069002D004C0061006B0069002000440061006E002000530061007400750020004F00720061006E006700200050006500720065006D007000750061006E002E0020004A007500670061002000500075006E00790061002000530065006F00720061006E0067002000490073007400720069002000590061006E00670020', 'NO TELP TUJUAN', 'Default_No_Compression', '050003A70301', '+6289644000001', -1, 'Perkenalkan Nama Saya Rosihan Ari Yuana. Saya Memiliki Tiga Anak, Dua Diantaranya Laki-Laki Dan Satu Orang Perempuan. Juga Punya Seorang Istri Yang ', 10, '', 1, 'SendingError', -1, -1, 255, 'Gammu2'),
('2011-11-29 07:53:28', '2011-11-29 07:53:05', '2011-11-29 07:53:28', NULL, '005000650072006B0065006E0061006C006B0061006E0020004E0061006D00610020005300610079006100200052006F0073006900680061006E00200041007200690020005900750061006E0061002E002000530061007900610020004D0065006D0069006C0069006B00690020005400690067006100200041006E0061006B002C00200044007500610020004400690061006E0074006100720061006E007900610020004C0061006B0069002D004C0061006B0069002000440061006E002000530061007400750020004F00720061006E006700200050006500720065006D007000750061006E002E0020004A007500670061002000500075006E00790061002000530065006F00720061006E0067002000490073007400720069002000590061006E00670020', '08995313157', 'Default_No_Compression', '050003A70301', '+6289644000001', -1, 'Perkenalkan Nama Saya Rosihan Ari Yuana. Saya Memiliki Tiga Anak, Dua Diantaranya Laki-Laki Dan Satu Orang Perempuan. Juga Punya Seorang Istri Yang ', 11, '', 1, 'SendingOKNoReport', -1, 95, 255, 'Gammu2'),
('2011-11-29 16:43:17', '2011-11-29 14:55:36', '2011-11-29 16:43:17', NULL, '004D00710075006B007100690072006900700020007900610020006B006F006E0065006A002000650071006E00690075002000720065006A0072006F0070006F00630065006A006F007200200068007500670069007900670079006400650077006C0020007400660065006A0020006E00720075007000780075006A006F00620020007800750065006D0079006D00690079006C006900720061006C006A002E0020005400650020007400760079006A0075006800200071006100780075006D00750072002000690062006500770066006F0069007700730020007A007500750063006F007A002000740064007900670075002000670065006C0075006D0020004C00200065006A0071006900670071006500730079006B006C0020006B007900610020006A00640079007400620065007A', '08995313157', 'Default_No_Compression', '050003D30201', '+6289644000001', -1, 'Mqukqirip ya konej eqniu rejropocejor hugiygydewl tfej nrupxujob xuemymiyliralj. Te tvyjuh qaxumur ibewfoiws zuucoz tdygu gelum L ejqigqesykl kya jdytbez', 12, '', 1, 'SendingOKNoReport', -1, 97, 255, 'Gammu 1.23.91'),
('2011-11-29 16:43:24', '2011-11-29 14:59:59', '2011-11-29 16:43:24', NULL, '004D00710075006B007100690072006900700020007900610020006B006F006E0065006A002000650071006E00690075002000720065006A0072006F0070006F00630065006A006F007200200068007500670069007900670079006400650077006C0020007400660065006A0020006E00720075007000780075006A006F00620020007800750065006D0079006D00690079006C006900720061006C006A002E0020005400650020007400760079006A0075006800200071006100780075006D00750072002000690062006500770066006F0069007700730020007A007500750063006F007A002000740064007900670075002000670065006C0075006D0020004C00200065006A0071006900670071006500730079006B006C0020006B007900610020006A00640079007400620065007A', '123465', 'Default_No_Compression', '050003D30201', '+6289644000001', -1, 'Mqukqirip ya konej eqniu rejropocejor hugiygydewl tfej nrupxujob xuemymiyliralj. Te tvyjuh qaxumur ibewfoiws zuucoz tdygu gelum L ejqigqesykl kya jdytbez', 13, '', 1, 'SendingOKNoReport', -1, 98, 255, 'Gammu 1.23.91'),
('2011-11-29 16:43:31', '2011-11-29 15:01:29', '2011-11-29 16:43:31', NULL, '004D00710075006B007100690072006900700020007900610020006B006F006E0065006A002000650071006E00690075002000720065006A0072006F0070006F00630065006A006F007200200068007500670069007900670079006400650077006C0020007400660065006A0020006E00720075007000780075006A006F00620020007800750065006D0079006D00690079006C006900720061006C006A002E0020005400650020007400760079006A0075006800200071006100780075006D00750072002000690062006500770066006F0069007700730020007A007500750063006F007A002000740064007900670075002000670065006C0075006D0020004C00200065006A0071006900670071006500730079006B006C0020006B007900610020006A00640079007400620065007A', '08995313157', 'Default_No_Compression', '050003D30201', '+6289644000001', -1, 'Mqukqirip ya konej eqniu rejropocejor hugiygydewl tfej nrupxujob xuemymiyliralj. Te tvyjuh qaxumur ibewfoiws zuucoz tdygu gelum L ejqigqesykl kya jdytbez', 14, '', 1, 'SendingOKNoReport', -1, 99, 255, 'Gammu 1.23.91'),
('2011-11-29 16:43:36', '2011-11-29 15:01:29', '2011-11-29 16:43:36', NULL, '00750020007800650077007A002000710069007300750062006500760075006D00780079007A006B00200075006600750079006C006500680079007A0063002E0020004E0073006500200078006F00620071002000640066006F006C0069007A00790067007100790073006A00200074002000620076006F00770073007900680079006800790065006D0069006D0020006F007600750074007000610070006500610065006D007000790065002000670069007500750077006200690062002E', '08995313157', 'Default_No_Compression', '050003D30202', '+6289644000001', -1, 'u xewz qisubevumxyzk ufuylehyzc. Nse xobq dfolizygqysj t bvowsyhyhyemim ovutpapeaempye giuuwbib.', 14, '', 2, 'SendingOKNoReport', -1, 100, 255, 'Gammu 1.23.91'),
('2011-11-29 16:43:43', '2011-11-29 16:43:12', '2011-11-29 16:43:43', NULL, '0053006500640061006E0067006B0061006E0020006B0065006C00650062006900680061006E0020006D0065006E0067006900720069006D0020006C006F006E00670020007400650078007400200053004D0053002000640065006E00670061006E002000710075006500720079002000530051004C0020006100640061006C00610068002000720075006E006E0069006E0067002000740069006D0065002000790061006E00670020006A0061007500680020006C006500620069006800200063006500700061007400200064006900620061006E00640069006E0067006B0061006E00200063006F006D006D0061006E00640020201C00670061006D006D0075002D0073006D00730064002D0069006E006A006500630074201D002E0020004E0061006D0075006E002E002E00200064', '08995313157', 'Default_No_Compression', '050003D80401', '+6289644000001', -1, 'Sedangkan kelebihan mengirim long text SMS dengan query SQL adalah running time yang jauh lebih cepat dibandingkan command “gammu-smsd-inject”. Namun.. d', 15, '', 1, 'SendingOKNoReport', -1, 101, 255, ''),
('2011-11-29 16:43:48', '2011-11-29 16:43:12', '2011-11-29 16:43:48', NULL, '0069002000730069007300690020006C00610069006E002C0020006B0065006B007500720061006E00670061006E006E007900610020006100640061006C006100680020006100670061006B002000720075006D00690074006E007900610020006D0065006D0062007500610074002000730063007200690070007400200075006E00740075006B0020006D0065006C0061006B0075006B0061006E002000680061006C00200069006E0069002E00200053006500640061006E0067006B0061006E0020006B0065006C00650062006900680061006E0020006400610072006900200063006F006D006D0061006E00640020201C00670061006D006D0075002D0073006D00730064002D0069006E006A006500630074201D0020006100640061006C0061006800200070006500720069006E', '08995313157', 'Default_No_Compression', '050003D80402', '+6289644000001', -1, 'i sisi lain, kekurangannya adalah agak rumitnya membuat script untuk melakukan hal ini. Sedangkan kelebihan dari command “gammu-smsd-inject” adalah perin', 15, '', 2, 'SendingOKNoReport', -1, 102, 255, ''),
('2011-11-29 16:43:53', '2011-11-29 16:43:12', '2011-11-29 16:43:53', NULL, '007400610068006E007900610020006A0061007500680020006C00650062006900680020006D007500640061006800200064006900620061006E00640069006E0067006B0061006E00200076006900610020007300630072006900700074002000710075006500720079002000530051004C002E00200041006B0061006E00200074006500740061007000690020006D0065006E00670069006E0067006100740020006B0065006C00650062006900680061006E006E00790061002000790061006E00670020006C00650062006900680020006500660069007300690065006E002C002000730061007900610020006B0069007200610020006B006500730075006C006900740061006E00200075006E00740075006B0020006D0065006D0062007500610074002000730063007200690070', '08995313157', 'Default_No_Compression', '050003D80403', '+6289644000001', -1, 'tahnya jauh lebih mudah dibandingkan via script query SQL. Akan tetapi mengingat kelebihannya yang lebih efisien, saya kira kesulitan untuk membuat scrip', 15, '', 3, 'SendingOKNoReport', -1, 103, 255, ''),
('2011-11-29 16:43:58', '2011-11-29 16:43:12', '2011-11-29 16:43:58', NULL, '0074002000700065006E0067006900720069006D0061006E0020006C006F006E00670020007400650078007400200053004D0053002000640065006E00670061006E002000710075006500720079002000740061006B0020007000650072006C0075002000640069007000650072006D006100730061006C00610068006B0061006E002C00200074006F006820260020007300610079006100200061006B0061006E002000620065006200650072006B0061006E00200063006100720061006E00790061002000640069002000730069006E0069', '08995313157', 'Default_No_Compression', '050003D80404', '+6289644000001', -1, 't pengiriman long text SMS dengan query tak perlu dipermasalahkan, toh… saya akan beberkan caranya di sini', 15, '', 4, 'SendingOKNoReport', -1, 104, 255, ''),
('2011-11-29 17:47:09', '2011-11-29 17:46:39', '2011-11-29 17:47:09', NULL, '0061006B006800690072006E00790061002000730075006B0073006500730020006A00750067006100200063006F0069002E002E002E', '089637032339', 'Default_No_Compression', '', '+6289644000001', -1, 'akhirnya sukses juga coi...', 16, '', 1, 'SendingOKNoReport', -1, 105, 255, ''),
('2011-11-29 17:52:50', '2011-11-29 17:52:37', '2011-11-29 17:52:50', NULL, '00740065007300740069006E006700200073006D0073002000700061006E006A0061006E0067002000640065006E00670061006E002000670061006D006D0075002E002000640065006E00670061006E002000740072006900670067006500720020006400690020006D007900730071006C002C0020006B006900720069006D00200073006D0073002000700061006E006A0061006E006700200067006B0020007000650072006C0075002000620069006E00670075006E00670020006C006100670069002000630075006B0075007000200069006E00730065007200740020006B006500200064006200200061006A0061002E002000740065007300740069006E006700200073006D0073002000700061006E006A0061006E0067002000640065006E00670061006E002000670061006D', '085292213020', 'Default_No_Compression', '050003BA0201', '+6289644000001', -1, 'testing sms panjang dengan gammu. dengan trigger di mysql, kirim sms panjang gk perlu bingung lagi cukup insert ke db aja. testing sms panjang dengan gam', 17, '', 1, 'SendingOKNoReport', -1, 106, 255, ''),
('2011-11-29 17:52:55', '2011-11-29 17:52:37', '2011-11-29 17:52:55', NULL, '006D0075002E002000740065007300740069006E006700200073006D0073002000700061006E006A0061006E0067002000640065006E00670061006E002000670061006D006D0075002E002000740065007300740069006E006700200073006D0073002000700061006E006A0061006E0067002000640065006E00670061006E002000670061006D006D0075002E0020', '085292213020', 'Default_No_Compression', '050003BA0202', '+6289644000001', -1, 'mu. testing sms panjang dengan gammu. testing sms panjang dengan gammu. ', 17, '', 2, 'SendingOKNoReport', -1, 107, 255, ''),
('2012-05-06 15:17:54', '2012-05-06 15:17:45', '2012-05-06 15:17:54', NULL, 'FEEFEFEF', '08995313157', 'Default_No_Compression', '', '+6289644000001', -1, 'ﻯ', 18, '', 1, 'SendingOKNoReport', -1, 8, 255, ''),
('2012-05-06 15:27:29', '2012-05-06 15:27:00', '2012-05-06 15:27:29', NULL, '00740065007300740069006E00670020006C006100670069', '08995313157', 'Default_No_Compression', '', '+6289644000001', -1, 'testing lagi', 19, '', 1, 'SendingOKNoReport', -1, 9, 255, ''),
('2012-05-06 17:30:48', '2012-05-06 15:50:02', '2012-05-06 17:30:48', NULL, '00740065007300740069006E00670020006D0061006E006500680020006D00610073002000620072006F0020', '08995313157', 'Default_No_Compression', '', '+6289644000001', -1, 'testing maneh mas bro ', 20, '', 1, 'SendingOKNoReport', -1, 10, 255, '');

--
-- Triggers `sms_sentitems`
--
DELIMITER $$
CREATE TRIGGER `sentitems_timestamp` BEFORE INSERT ON `sms_sentitems` FOR EACH ROW BEGIN
    IF NEW.InsertIntoDB = '0000-00-00 00:00:00' THEN
        SET NEW.InsertIntoDB = CURRENT_TIMESTAMP();
    END IF;
    IF NEW.SendingDateTime = '0000-00-00 00:00:00' THEN
        SET NEW.SendingDateTime = CURRENT_TIMESTAMP();
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
-- Structure for view `vreservasi`
--
DROP TABLE IF EXISTS `vreservasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `vreservasi`  AS  select `res_treservasi`.`id_rsv` AS `id_rsv`,`res_treservasi`.`nores` AS `nores`,`res_treservasi`.`waktu_rsv` AS `waktu_rsv`,`res_treservasi`.`nourut` AS `nourut`,`res_treservasi`.`kode_cekin` AS `kode_cekin`,`res_tpasien`.`norm` AS `norm`,`res_tpasien`.`nama` AS `nama`,`res_tpasien`.`gender` AS `gender`,`res_tpasien`.`tgl_lahir` AS `tgl_lahir`,`res_tpasien`.`notelp` AS `notelp`,`res_tpasien`.`alamat` AS `alamat`,`res_tpasien`.`propinsi` AS `propinsi`,`res_tpasien`.`kota` AS `kota`,`res_tpasien`.`kec` AS `kec`,`res_tpasien`.`kel` AS `kel`,`res_jadwal`.`id_jadwal` AS `id_jadwal`,`res_jadwal`.`id_hari` AS `id_hari`,`res_refdokter`.`id_dokter` AS `id_dokter`,`res_refdokter`.`nama_dokter` AS `nama_dokter`,`res_refklinik`.`id_klinik` AS `id_klinik`,`res_refklinik`.`nama_klinik` AS `nama_klinik`,`res_refklinik`.`kode_poli` AS `kode_poli`,`res_sebab_sakit`.`id_sebab` AS `id_sebab`,`res_sebab_sakit`.`sebab` AS `sebab`,`res_jns_pasien`.`jns_id` AS `jns_id`,`res_jns_pasien`.`jns_nama` AS `jns_nama`,`res_refjns_layan`.`id_jns_layan` AS `id_jns_layan`,`res_refjns_layan`.`jns_layan` AS `jns_layan`,`res_treservasi`.`status` AS `status`,`res_treservasi`.`sync` AS `sync`,`res_treservasi`.`jenis_rsv` AS `jenis_rsv`,`res_treservasi`.`user_id` AS `user_id`,`res_treservasi`.`first_update` AS `first_update`,`res_treservasi`.`last_update` AS `last_update` from (((((((`res_treservasi` left join `res_tpasien` on((`res_treservasi`.`norm` = `res_tpasien`.`norm`))) left join `res_sebab_sakit` on((`res_treservasi`.`sebab_id` = `res_sebab_sakit`.`id_sebab`))) left join `res_jadwal` on((`res_treservasi`.`jadwal_id` = `res_jadwal`.`id_jadwal`))) left join `res_jns_pasien` on((`res_treservasi`.`jns_pasien_id` = `res_jns_pasien`.`jns_id`))) left join `res_refdokter` on((`res_jadwal`.`dokter_id` = `res_refdokter`.`id_dokter`))) left join `res_refklinik` on((`res_jadwal`.`klinik_id` = `res_refklinik`.`id_klinik`))) left join `res_refjns_layan` on((`res_jadwal`.`jns_layan_id` = `res_refjns_layan`.`id_jns_layan`))) ;

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
  ADD KEY `outbox_sender` (`SenderID`);

--
-- Indexes for table `sms_outbox_multipart`
--
ALTER TABLE `sms_outbox_multipart`
  ADD PRIMARY KEY (`ID`,`SequencePosition`);

--
-- Indexes for table `sms_pbk`
--
ALTER TABLE `sms_pbk`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sms_pbk_groups`
--
ALTER TABLE `sms_pbk_groups`
  ADD PRIMARY KEY (`ID`);

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
  ADD KEY `sentitems_sender` (`SenderID`);

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
  MODIFY `id_rsv` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sms_full_inbox`
--
ALTER TABLE `sms_full_inbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sms_full_outbox`
--
ALTER TABLE `sms_full_outbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sms_inbox`
--
ALTER TABLE `sms_inbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_outbox`
--
ALTER TABLE `sms_outbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `sms_pbk`
--
ALTER TABLE `sms_pbk`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_pbk_groups`
--
ALTER TABLE `sms_pbk_groups`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

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
