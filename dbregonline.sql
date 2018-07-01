-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 01 Jul 2018 pada 20.44
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal`
--

CREATE TABLE `jadwal` (
  `id_jadwal` int(11) NOT NULL,
  `id_dokter` int(8) NOT NULL,
  `id_klinik` int(4) NOT NULL,
  `jnslayan` tinyint(1) NOT NULL,
  `id_hari` tinyint(4) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `kuota_perjam` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jadwal`
--

INSERT INTO `jadwal` (`id_jadwal`, `id_dokter`, `id_klinik`, `jnslayan`, `id_hari`, `jam_mulai`, `jam_selesai`, `kuota_perjam`, `status`) VALUES
(1, 1, 1, 2, 1, '07:00:00', '14:00:00', 30, 1),
(2, 1, 1, 2, 4, '08:00:00', '15:00:00', 20, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pasien`
--

CREATE TABLE `jenis_pasien` (
  `jenis_id` int(3) NOT NULL,
  `jenis_nama` varchar(100) DEFAULT NULL,
  `jenis_flag` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_pasien`
--

INSERT INTO `jenis_pasien` (`jenis_id`, `jenis_nama`, `jenis_flag`) VALUES
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
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(1, '::1', 'sudadi', 1530459674);

-- --------------------------------------------------------

--
-- Struktur dari tabel `refdokter`
--

CREATE TABLE `refdokter` (
  `id_dokter` int(8) NOT NULL,
  `nama_dokter` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `refdokter`
--

INSERT INTO `refdokter` (`id_dokter`, `nama_dokter`, `status`) VALUES
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
-- Struktur dari tabel `refjns_layan`
--

CREATE TABLE `refjns_layan` (
  `id_jnslayan` tinyint(4) NOT NULL,
  `jnslayan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `refjns_layan`
--

INSERT INTO `refjns_layan` (`id_jnslayan`, `jnslayan`) VALUES
(1, 'Reguler'),
(2, 'Eksekutif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `refklinik`
--

CREATE TABLE `refklinik` (
  `id_klinik` int(4) NOT NULL,
  `nama_klinik` varchar(100) NOT NULL,
  `kode_poli` varchar(5) NOT NULL,
  `tipe_layanan` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1.Reguler; 2.Eksekutif',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0.Tidak Aktif; 1. Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `refklinik`
--

INSERT INTO `refklinik` (`id_klinik`, `nama_klinik`, `kode_poli`, `tipe_layanan`, `status`) VALUES
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
-- Struktur dari tabel `sebab_sakit`
--

CREATE TABLE `sebab_sakit` (
  `ss_id` tinyint(2) NOT NULL,
  `ss_nama` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `sebab_sakit`
--

INSERT INTO `sebab_sakit` (`ss_id`, `ss_nama`) VALUES
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
-- Struktur dari tabel `tgl_libur`
--

CREATE TABLE `tgl_libur` (
  `id_libur` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `ket` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1. Aktif; 0. Disable'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tgl_libur`
--

INSERT INTO `tgl_libur` (`id_libur`, `tanggal`, `ket`, `status`) VALUES
(1, '2018-06-12', 'Libur Hari Raya Idul Fitri', 1),
(2, '2018-06-26', 'Libur Hari Kartini', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tpasien`
--

CREATE TABLE `tpasien` (
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
-- Dumping data untuk tabel `tpasien`
--

INSERT INTO `tpasien` (`norm`, `nama`, `gender`, `tgl_lahir`, `notelp`, `alamat`, `propinsi`, `kota`, `kec`, `kel`) VALUES
('133469', 'SUDADI, SDR', 'L', '1978-06-21', '08995313157', 'Selokaton', 0, 0, 0, 0),
('317993', 'Maskur', 'L', '1950-11-28', '08995313157', 'solo', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `treservasi`
--

CREATE TABLE `treservasi` (
  `id_rsv` bigint(20) NOT NULL,
  `norm` varchar(10) NOT NULL,
  `notelp` varchar(15) NOT NULL,
  `nores` varchar(15) NOT NULL,
  `waktu_rsv` datetime NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `id_klinik` int(4) NOT NULL,
  `id_dokter` int(8) NOT NULL,
  `nourut` int(4) NOT NULL,
  `kode_cekin` varchar(10) DEFAULT NULL,
  `cara_bayar` int(11) NOT NULL,
  `id_jnslayan` int(4) NOT NULL,
  `sebab` tinyint(4) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0.reservasi; 1. checkin; 2.Batat',
  `tgl_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  `sync` tinyint(1) NOT NULL DEFAULT '0',
  `jenis_res` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `treservasi`
--

INSERT INTO `treservasi` (`id_rsv`, `norm`, `notelp`, `nores`, `waktu_rsv`, `id_jadwal`, `id_klinik`, `id_dokter`, `nourut`, `kode_cekin`, `cara_bayar`, `id_jnslayan`, `sebab`, `status`, `tgl_update`, `user_id`, `sync`, `jenis_res`) VALUES
(3, '133469', '08995313157', 'ORT-3', '2018-06-28 08:00:00', 2, 1, 1, 0, NULL, 2, 2, 9, 1, '2018-06-25 20:25:23', 2, 0, 'WA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tsms`
--

CREATE TABLE `tsms` (
  `id_sms` int(11) NOT NULL,
  `no_telp` varchar(16) NOT NULL,
  `pesan` text NOT NULL,
  `stat_kirim` tinyint(4) DEFAULT NULL,
  `stat_baca` tinyint(1) NOT NULL DEFAULT '0',
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tsms`
--

INSERT INTO `tsms` (`id_sms`, `no_telp`, `pesan`, `stat_kirim`, `stat_baca`, `waktu`) VALUES
(1, '08995313157', 'dddd', 0, 1, '2018-06-27 20:18:32'),
(2, '083818181831', 'ffff', NULL, 1, '2018-06-27 20:18:32'),
(3, '083818181831', 'ljkjljlkjlk', NULL, 0, '2018-07-01 18:13:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
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
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'administrator', '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36', '', 'admin@admin.com', '', NULL, NULL, 'uLqRuZhJcW3CwF9799i.Te', 1268889823, 1530459689, 1, 'Admin', 'istrator', 'ADMIN', '0'),
(2, '127.0.0.1', 'web', '57f99d889086c8456456dcccd6401aef0ba2058c', NULL, '', NULL, NULL, NULL, NULL, 1268889823, NULL, 1, 'Registrasi', 'Web', 'RSO', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `vreservasi`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `vreservasi` (
`id_rsv` bigint(20)
,`norm` varchar(10)
,`notelp` varchar(15)
,`nores` varchar(15)
,`waktu_rsv` datetime
,`tgl_update` timestamp
,`status` tinyint(2)
,`cara_bayar` int(11)
,`nourut` int(4)
,`sync` tinyint(1)
,`username` varchar(100)
,`nama_dokter` varchar(100)
,`nama_klinik` varchar(100)
,`nama` varchar(200)
,`tgl_lahir` date
,`jnslayan` tinyint(1)
,`nmjnspasien` varchar(100)
,`nmjnslayan` varchar(50)
);

-- --------------------------------------------------------

--
-- Struktur untuk view `vreservasi`
--
DROP TABLE IF EXISTS `vreservasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vreservasi`  AS  select `a`.`id_rsv` AS `id_rsv`,`a`.`norm` AS `norm`,`a`.`notelp` AS `notelp`,`a`.`nores` AS `nores`,`a`.`waktu_rsv` AS `waktu_rsv`,`a`.`tgl_update` AS `tgl_update`,`a`.`status` AS `status`,`a`.`cara_bayar` AS `cara_bayar`,`a`.`nourut` AS `nourut`,`a`.`sync` AS `sync`,`users`.`username` AS `username`,`refdokter`.`nama_dokter` AS `nama_dokter`,`refklinik`.`nama_klinik` AS `nama_klinik`,`tpasien`.`nama` AS `nama`,`tpasien`.`tgl_lahir` AS `tgl_lahir`,`jadwal`.`jnslayan` AS `jnslayan`,`jenis_pasien`.`jenis_nama` AS `nmjnspasien`,`refjns_layan`.`jnslayan` AS `nmjnslayan` from (((((((`treservasi` `a` join `users` on((`users`.`id` = `a`.`user_id`))) join `tpasien` on((`a`.`norm` = `tpasien`.`norm`))) join `refklinik` on((`a`.`id_klinik` = `refklinik`.`id_klinik`))) join `refdokter` on((`a`.`id_dokter` = `refdokter`.`id_dokter`))) join `jadwal` on((`a`.`id_jadwal` = `jadwal`.`id_jadwal`))) join `jenis_pasien` on((`jenis_pasien`.`jenis_id` = `a`.`cara_bayar`))) join `refjns_layan` on((`refjns_layan`.`id_jnslayan` = `a`.`id_jnslayan`))) ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_dokter` (`id_dokter`),
  ADD KEY `id_klinik` (`id_klinik`);

--
-- Indeks untuk tabel `jenis_pasien`
--
ALTER TABLE `jenis_pasien`
  ADD PRIMARY KEY (`jenis_id`);

--
-- Indeks untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `refdokter`
--
ALTER TABLE `refdokter`
  ADD PRIMARY KEY (`id_dokter`);

--
-- Indeks untuk tabel `refjns_layan`
--
ALTER TABLE `refjns_layan`
  ADD PRIMARY KEY (`id_jnslayan`);

--
-- Indeks untuk tabel `refklinik`
--
ALTER TABLE `refklinik`
  ADD PRIMARY KEY (`id_klinik`);

--
-- Indeks untuk tabel `sebab_sakit`
--
ALTER TABLE `sebab_sakit`
  ADD PRIMARY KEY (`ss_id`);

--
-- Indeks untuk tabel `tgl_libur`
--
ALTER TABLE `tgl_libur`
  ADD PRIMARY KEY (`id_libur`);

--
-- Indeks untuk tabel `tpasien`
--
ALTER TABLE `tpasien`
  ADD PRIMARY KEY (`norm`);

--
-- Indeks untuk tabel `treservasi`
--
ALTER TABLE `treservasi`
  ADD PRIMARY KEY (`id_rsv`),
  ADD KEY `norm` (`norm`),
  ADD KEY `id_jadwal` (`id_jadwal`);

--
-- Indeks untuk tabel `tsms`
--
ALTER TABLE `tsms`
  ADD PRIMARY KEY (`id_sms`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  MODIFY `id_jadwal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `refdokter`
--
ALTER TABLE `refdokter`
  MODIFY `id_dokter` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=223;

--
-- AUTO_INCREMENT untuk tabel `refjns_layan`
--
ALTER TABLE `refjns_layan`
  MODIFY `id_jnslayan` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `refklinik`
--
ALTER TABLE `refklinik`
  MODIFY `id_klinik` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=570;

--
-- AUTO_INCREMENT untuk tabel `tgl_libur`
--
ALTER TABLE `tgl_libur`
  MODIFY `id_libur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `treservasi`
--
ALTER TABLE `treservasi`
  MODIFY `id_rsv` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tsms`
--
ALTER TABLE `tsms`
  MODIFY `id_sms` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal`
--
ALTER TABLE `jadwal`
  ADD CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_klinik`) REFERENCES `refklinik` (`id_klinik`),
  ADD CONSTRAINT `jadwal_ibfk_2` FOREIGN KEY (`id_dokter`) REFERENCES `refdokter` (`id_dokter`);

--
-- Ketidakleluasaan untuk tabel `treservasi`
--
ALTER TABLE `treservasi`
  ADD CONSTRAINT `treservasi_ibfk_1` FOREIGN KEY (`norm`) REFERENCES `tpasien` (`norm`),
  ADD CONSTRAINT `treservasi_ibfk_2` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`);

--
-- Ketidakleluasaan untuk tabel `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `users_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
