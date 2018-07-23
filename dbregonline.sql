-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 23 Jul 2018 pada 20.14
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 5.6.35

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
-- Fungsi
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
-- Struktur dari tabel `auth_groups`
--

CREATE TABLE `auth_groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `auth_groups`
--

INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_login_attempts`
--

CREATE TABLE `auth_login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_users`
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
-- Dumping data untuk tabel `auth_users`
--

INSERT INTO `auth_users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, 'uLqRuZhJcW3CwF9799i.Te', 1268889823, 1532360459, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(2, '127.0.0.1', 'web', '57f99d889086c8456456dcccd6401aef0ba2058c', NULL, '', NULL, NULL, NULL, NULL, 1268889823, NULL, 1, 'Registrasi', 'Web', 'RSO', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth_users_groups`
--

CREATE TABLE `auth_users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `auth_users_groups`
--

INSERT INTO `auth_users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `res_jadwal`
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
-- Dumping data untuk tabel `res_jadwal`
--

INSERT INTO `res_jadwal` (`id_jadwal`, `dokter_id`, `klinik_id`, `jns_layan_id`, `id_hari`, `jam_mulai`, `jam_selesai`, `kuota_perjam`, `status`) VALUES
(1, 1, 1, 2, 1, '07:00:00', '14:00:00', 30, 1),
(2, 3, 1, 2, 4, '08:00:00', '15:00:00', 20, 1),
(3, 1, 1, 1, 4, '08:00:00', '15:00:00', 20, 0),
(4, 4, 1, 2, 5, '08:00:00', '15:00:00', 10, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `res_jns_pasien`
--

CREATE TABLE `res_jns_pasien` (
  `jns_id` int(3) NOT NULL,
  `jns_nama` varchar(100) DEFAULT NULL,
  `jns_flag` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `res_jns_pasien`
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
-- Struktur dari tabel `res_refdokter`
--

CREATE TABLE `res_refdokter` (
  `id_dokter` int(8) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `res_refdokter`
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
-- Struktur dari tabel `res_refjns_layan`
--

CREATE TABLE `res_refjns_layan` (
  `id_jns_layan` tinyint(4) NOT NULL,
  `jns_layan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `res_refjns_layan`
--

INSERT INTO `res_refjns_layan` (`id_jns_layan`, `jns_layan`) VALUES
(1, 'Reguler'),
(2, 'Eksekutif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `res_refklinik`
--

CREATE TABLE `res_refklinik` (
  `id_klinik` int(4) NOT NULL,
  `nama_klinik` varchar(100) NOT NULL,
  `kode_poli` varchar(5) NOT NULL,
  `tipe_layan` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1.Reguler; 2.Eksekutif',
  `kuota` int(4) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0.Tidak Aktif; 1. Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `res_refklinik`
--

INSERT INTO `res_refklinik` (`id_klinik`, `nama_klinik`, `kode_poli`, `tipe_layan`, `kuota`, `status`) VALUES
(1, 'Ortopedi', 'ORT', 3, 20, 1),
(2, 'Gigi & Mulut', 'GP1', 1, 0, 1),
(3, 'Rehabilitasi Medik', 'IRM', 1, 0, 1),
(4, 'Penyakit Dalam', 'INT', 1, 0, 1),
(15, 'Akupuntur', 'AKP', 1, 0, 1),
(17, 'Neurologi & Saraf', 'SAR', 1, 0, 1),
(18, 'Bedah Umum', 'AKP', 1, 0, 1),
(24, 'Sub Sp. Spine', 'ORT', 1, 0, 1),
(100, 'Herbal', 'HER', 1, 0, 0),
(101, 'Ortopedi Wijaya Kusuma', 'ORT', 1, 0, 0),
(102, 'Sub. Sp Onkology', 'ORT', 1, 0, 1),
(103, 'Sub. Sp Hand and Micro Surgery', 'ORT', 1, 0, 1),
(104, 'Sub. Sp. Sport Medicine', 'ORT', 1, 0, 1),
(400, 'Sub. Sp. Adult Reconstruction', 'ORT', 1, 0, 1),
(401, 'Sub. Sp. Pediatric', 'ORT', 1, 0, 1),
(533, 'Rekam Medik', '', 1, 0, 0),
(569, 'Poli Anestesi', '', 1, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `res_sebab_sakit`
--

CREATE TABLE `res_sebab_sakit` (
  `id_sebab` tinyint(2) NOT NULL,
  `sebab` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `res_sebab_sakit`
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
-- Struktur dari tabel `res_tgl_libur`
--

CREATE TABLE `res_tgl_libur` (
  `id_libur` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `ket` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1. Aktif; 0. Disable'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `res_tgl_libur`
--

INSERT INTO `res_tgl_libur` (`id_libur`, `tanggal`, `ket`, `status`) VALUES
(1, '2018-06-12', 'Libur Hari Raya Idul Fitri', 1),
(2, '2018-06-26', 'Libur Hari Kartini', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `res_tpasien`
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
-- Dumping data untuk tabel `res_tpasien`
--

INSERT INTO `res_tpasien` (`norm`, `nama`, `gender`, `tgl_lahir`, `notelp`, `alamat`, `propinsi`, `kota`, `kec`, `kel`) VALUES
('133469', 'SUDADI, SDR', 'L', '1978-06-21', '08995313157', 'Selokaton', 0, 0, 0, 0),
('317993', 'Maskur', 'L', '1950-11-28', '08995313157', 'solo', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `res_treservasi`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `sms_full_inbox`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `sms_full_outbox`
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
-- Trigger `sms_full_outbox`
--
DELIMITER $$
CREATE TRIGGER `copy_to_inbox_aft_ins` AFTER INSERT ON `sms_full_outbox` FOR EACH ROW BEGIN

INSERT INTO sms_outbox (ID,DestinationNumber,TextDecoded,CreatorID,Coding,Class)
VALUES (new.ID, new.DestinationNumber, new.TextDecoded, new.CreatorID, new.Coding, new.Class);

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `set_send_time` BEFORE INSERT ON `sms_full_outbox` FOR EACH ROW BEGIN
IF new.`SendingDateTime`='' OR new.`SendingDateTime`=null OR 		         	new.`SendingDateTime`=0 THEN
SET new.`SendingDateTime`=CURRENT_TIMESTAMP;
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sms_gammu`
--

CREATE TABLE `sms_gammu` (
  `Version` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `sms_gammu`
--

INSERT INTO `sms_gammu` (`Version`) VALUES
(17);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sms_inbox`
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
-- Trigger `sms_inbox`
--
DELIMITER $$
CREATE TRIGGER `insert_full_inbox` BEFORE INSERT ON `sms_inbox` FOR EACH ROW BEGIN

IF new.`SenderNumber`='' OR new.`SenderNumber`=NULL THEN
	set new.`SenderNumber`='INFO';
END IF;

SET new.`SenderNumber`=REPLACE(new.`SenderNumber`,'+62','0');

IF NEW.UDH=NULL OR RIGHT(NEW.UDH,2)='01' OR NEW.UDH='' THEN
	INSERT INTO `sms_full_inbox`(`UpdatedInDB`,`ReceivingDateTime`,`Text`,`SenderNumber`,`Coding`,`UDH`,`SMSCNumber`,`Class`,`TextDecoded`,`RecipientID`,`Processed`) VALUES
(new.UpdatedInDB, new.ReceivingDateTime, new.TEXT, new.SenderNumber,
new.Coding, new.UDH, new.SMSCNumber, new.Class, new.TextDecoded, new.RecipientID, new.Processed);
	UPDATE sms_full_inbox SET Processed='false' WHERE SenderNumber=new.SenderNumber;
ELSE
	UPDATE sms_full_inbox SET textdecoded=CONCAT(textdecoded,new.TextDecoded)
	WHERE LEFT(udh,10)=LEFT(new.UDH,10);
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sms_outbox`
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
-- Trigger `sms_outbox`
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
-- Struktur dari tabel `sms_outbox_multipart`
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
-- Struktur dari tabel `sms_phones`
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
-- Dumping data untuk tabel `sms_phones`
--

INSERT INTO `sms_phones` (`ID`, `UpdatedInDB`, `InsertIntoDB`, `TimeOut`, `Send`, `Receive`, `IMEI`, `IMSI`, `NetCode`, `NetName`, `Client`, `Battery`, `Signal`, `Sent`, `Received`) VALUES
('', '2018-07-23 10:45:33', '2018-07-20 19:03:04', '2018-07-23 10:45:43', 'yes', 'yes', '351589046379118', '510114113337585', '510 11', '', 'Gammu 1.39.0, Linux, kernel 4.15.0-24-generic (#26-Ubuntu SMP Wed Jun 13 08:44:47 UTC 2018), GCC 7.2', 100, 36, 8, 24);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sms_sentitems`
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
-- Trigger `sms_sentitems`
--
DELIMITER $$
CREATE TRIGGER `update_stat_out` AFTER INSERT ON `sms_sentitems` FOR EACH ROW BEGIN
IF (new.StatusError = -1) THEN
	UPDATE sms_full_outbox SET sms_full_outbox.Status=1, sms_full_outbox.SendingDateTime = new.SendingDateTime
    WHERE sms_full_outbox.ID = new.ID;
ELSE
	UPDATE sms_full_outbox SET sms_full_outbox.Status = 2, sms_full_outbox.SendingDateTime = new.SendingDateTime
    WHERE sms_full_outbox.ID = new.ID;
END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `vreservasi`
-- (Lihat di bawah untuk tampilan aktual)
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
-- Stand-in struktur untuk tampilan `vsms`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `vsms` (
`ID` int(11) unsigned
,`Number` varchar(20)
,`TextDecoded` mediumtext
,`UpdatedInDB` timestamp
,`TransTime` timestamp
,`Coding` varchar(22)
,`Class` int(11)
,`stat` varchar(5)
,`Type` varchar(6)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `vreservasi`
--
DROP TABLE IF EXISTS `vreservasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `vreservasi`  AS  select `res_treservasi`.`id_rsv` AS `id_rsv`,`res_treservasi`.`nores` AS `nores`,`res_treservasi`.`waktu_rsv` AS `waktu_rsv`,`res_treservasi`.`nourut` AS `nourut`,`res_treservasi`.`kode_cekin` AS `kode_cekin`,`res_tpasien`.`norm` AS `norm`,`res_tpasien`.`nama` AS `nama`,`res_tpasien`.`gender` AS `gender`,`res_tpasien`.`tgl_lahir` AS `tgl_lahir`,`res_tpasien`.`notelp` AS `notelp`,`res_tpasien`.`alamat` AS `alamat`,`res_tpasien`.`propinsi` AS `propinsi`,`res_tpasien`.`kota` AS `kota`,`res_tpasien`.`kec` AS `kec`,`res_tpasien`.`kel` AS `kel`,`res_jadwal`.`id_jadwal` AS `id_jadwal`,`res_jadwal`.`id_hari` AS `id_hari`,`res_refdokter`.`id_dokter` AS `id_dokter`,`res_refdokter`.`nama_dokter` AS `nama_dokter`,`res_refklinik`.`id_klinik` AS `id_klinik`,`res_refklinik`.`nama_klinik` AS `nama_klinik`,`res_refklinik`.`kode_poli` AS `kode_poli`,`res_sebab_sakit`.`id_sebab` AS `id_sebab`,`res_sebab_sakit`.`sebab` AS `sebab`,`res_jns_pasien`.`jns_id` AS `jns_id`,`res_jns_pasien`.`jns_nama` AS `jns_nama`,`res_refjns_layan`.`id_jns_layan` AS `id_jns_layan`,`res_refjns_layan`.`jns_layan` AS `jns_layan`,`res_treservasi`.`status` AS `status`,`res_treservasi`.`sync` AS `sync`,`res_treservasi`.`jenis_rsv` AS `jenis_rsv`,`res_treservasi`.`user_id` AS `user_id`,`res_treservasi`.`first_update` AS `first_update`,`res_treservasi`.`last_update` AS `last_update` from (((((((`res_treservasi` left join `res_tpasien` on((`res_treservasi`.`norm` = `res_tpasien`.`norm`))) left join `res_sebab_sakit` on((`res_treservasi`.`sebab_id` = `res_sebab_sakit`.`id_sebab`))) left join `res_jadwal` on((`res_treservasi`.`jadwal_id` = `res_jadwal`.`id_jadwal`))) left join `res_jns_pasien` on((`res_treservasi`.`jns_pasien_id` = `res_jns_pasien`.`jns_id`))) left join `res_refdokter` on((`res_jadwal`.`dokter_id` = `res_refdokter`.`id_dokter`))) left join `res_refklinik` on((`res_jadwal`.`klinik_id` = `res_refklinik`.`id_klinik`))) left join `res_refjns_layan` on((`res_jadwal`.`jns_layan_id` = `res_refjns_layan`.`id_jns_layan`))) ;

-- --------------------------------------------------------

--
-- Struktur untuk view `vsms`
--
DROP TABLE IF EXISTS `vsms`;

CREATE ALGORITHM=UNDEFINED DEFINER=`admin`@`localhost` SQL SECURITY DEFINER VIEW `vsms`  AS  select `a`.`ID` AS `ID`,`a`.`SenderNumber` AS `Number`,`a`.`TextDecoded` AS `TextDecoded`,`a`.`UpdatedInDB` AS `UpdatedInDB`,`a`.`ReceivingDateTime` AS `TransTime`,`a`.`Coding` AS `Coding`,`a`.`Class` AS `Class`,`a`.`Processed` AS `stat`,'inbox' AS `Type` from `sms_full_inbox` `a` union select `b`.`ID` AS `ID`,`b`.`DestinationNumber` AS `Number`,`b`.`TextDecoded` AS `TextDecoded`,`b`.`UpdatedInDB` AS `UpdatedInDB`,`b`.`SendingDateTime` AS `TransTime`,`b`.`Coding` AS `Coding`,`b`.`Class` AS `Class`,`b`.`Status` AS `stat`,'outbox' AS `TYPE` from `sms_full_outbox` `b` where ((`b`.`Coding` <> '8bit') and (`b`.`Class` <> 127)) order by `TransTime` desc ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_login_attempts`
--
ALTER TABLE `auth_login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_users`
--
ALTER TABLE `auth_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indeks untuk tabel `res_jadwal`
--
ALTER TABLE `res_jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `jns_layan_id` (`jns_layan_id`),
  ADD KEY `res_jadwal_ibfk_1` (`dokter_id`),
  ADD KEY `res_jadwal_ibfk_2` (`klinik_id`);

--
-- Indeks untuk tabel `res_jns_pasien`
--
ALTER TABLE `res_jns_pasien`
  ADD PRIMARY KEY (`jns_id`);

--
-- Indeks untuk tabel `res_refdokter`
--
ALTER TABLE `res_refdokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indeks untuk tabel `res_refjns_layan`
--
ALTER TABLE `res_refjns_layan`
  ADD PRIMARY KEY (`id_jns_layan`);

--
-- Indeks untuk tabel `res_refklinik`
--
ALTER TABLE `res_refklinik`
  ADD PRIMARY KEY (`id_klinik`);

--
-- Indeks untuk tabel `res_sebab_sakit`
--
ALTER TABLE `res_sebab_sakit`
  ADD PRIMARY KEY (`id_sebab`);

--
-- Indeks untuk tabel `res_tgl_libur`
--
ALTER TABLE `res_tgl_libur`
  ADD PRIMARY KEY (`id_libur`);

--
-- Indeks untuk tabel `res_tpasien`
--
ALTER TABLE `res_tpasien`
  ADD PRIMARY KEY (`norm`);

--
-- Indeks untuk tabel `res_treservasi`
--
ALTER TABLE `res_treservasi`
  ADD PRIMARY KEY (`id_rsv`),
  ADD KEY `norm` (`norm`),
  ADD KEY `id_jadwal` (`jadwal_id`),
  ADD KEY `jns_pasien` (`jns_pasien_id`),
  ADD KEY `sebab` (`sebab_id`);

--
-- Indeks untuk tabel `sms_full_inbox`
--
ALTER TABLE `sms_full_inbox`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `sms_full_outbox`
--
ALTER TABLE `sms_full_outbox`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `outbox_date` (`SendingDateTime`,`SendingTimeOut`),
  ADD KEY `outbox_sender` (`SenderID`);

--
-- Indeks untuk tabel `sms_gammu`
--
ALTER TABLE `sms_gammu`
  ADD PRIMARY KEY (`Version`);

--
-- Indeks untuk tabel `sms_inbox`
--
ALTER TABLE `sms_inbox`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `sms_outbox`
--
ALTER TABLE `sms_outbox`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `outbox_date` (`SendingDateTime`,`SendingTimeOut`),
  ADD KEY `outbox_sender` (`SenderID`(250));

--
-- Indeks untuk tabel `sms_outbox_multipart`
--
ALTER TABLE `sms_outbox_multipart`
  ADD PRIMARY KEY (`ID`,`SequencePosition`);

--
-- Indeks untuk tabel `sms_phones`
--
ALTER TABLE `sms_phones`
  ADD PRIMARY KEY (`IMEI`);

--
-- Indeks untuk tabel `sms_sentitems`
--
ALTER TABLE `sms_sentitems`
  ADD PRIMARY KEY (`ID`,`SequencePosition`),
  ADD KEY `sentitems_date` (`DeliveryDateTime`),
  ADD KEY `sentitems_tpmr` (`TPMR`),
  ADD KEY `sentitems_dest` (`DestinationNumber`),
  ADD KEY `sentitems_sender` (`SenderID`(250));

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `auth_groups`
--
ALTER TABLE `auth_groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `auth_login_attempts`
--
ALTER TABLE `auth_login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `auth_users`
--
ALTER TABLE `auth_users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `res_jadwal`
--
ALTER TABLE `res_jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `res_refdokter`
--
ALTER TABLE `res_refdokter`
  MODIFY `id_dokter` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT untuk tabel `res_refjns_layan`
--
ALTER TABLE `res_refjns_layan`
  MODIFY `id_jns_layan` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `res_refklinik`
--
ALTER TABLE `res_refklinik`
  MODIFY `id_klinik` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=570;

--
-- AUTO_INCREMENT untuk tabel `res_tgl_libur`
--
ALTER TABLE `res_tgl_libur`
  MODIFY `id_libur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `res_treservasi`
--
ALTER TABLE `res_treservasi`
  MODIFY `id_rsv` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sms_full_inbox`
--
ALTER TABLE `sms_full_inbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sms_full_outbox`
--
ALTER TABLE `sms_full_outbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sms_inbox`
--
ALTER TABLE `sms_inbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sms_outbox`
--
ALTER TABLE `sms_outbox`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `auth_users_groups`
--
ALTER TABLE `auth_users_groups`
  ADD CONSTRAINT `auth_users_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`),
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `auth_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `res_jadwal`
--
ALTER TABLE `res_jadwal`
  ADD CONSTRAINT `res_jadwal_ibfk_1` FOREIGN KEY (`dokter_id`) REFERENCES `res_refdokter` (`id_dokter`),
  ADD CONSTRAINT `res_jadwal_ibfk_2` FOREIGN KEY (`klinik_id`) REFERENCES `res_refklinik` (`id_klinik`),
  ADD CONSTRAINT `res_jadwal_ibfk_3` FOREIGN KEY (`jns_layan_id`) REFERENCES `res_refjns_layan` (`id_jns_layan`);

--
-- Ketidakleluasaan untuk tabel `res_treservasi`
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
