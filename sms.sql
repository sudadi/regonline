-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Jul 2018 pada 16.33
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
-- Database: `sms`
--

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
CREATE TRIGGER `inbox_before_ins` BEFORE INSERT ON `sms_inbox` FOR EACH ROW begin

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
  `MultiPart` varchar(6) DEFAULT '0',
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
CREATE TRIGGER `outbox_before_ins_tr` BEFORE INSERT ON `sms_outbox` FOR EACH ROW BEGIN
 	
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
   set new.MultiPart='1';
   set new.RelativeValidity=255;
  else
    set new.MultiPart='0';
  end if;
 
  end if;
  
END
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
('', '2018-07-14 19:46:25', '2018-07-14 17:27:24', '2018-07-14 19:46:35', 'yes', 'yes', '351726040832946,GR1NB1J293', '', 'ERROR', 'ERROR', 'Gammu 1.39.0, Windows Server 2007 SP1, MS VC 1900', 100, 63, 3, 0);

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
-- Indexes for dumped tables
--

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
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
