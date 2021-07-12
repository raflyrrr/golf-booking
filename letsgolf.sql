-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 12, 2021 at 04:26 PM
-- Server version: 5.7.24
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `letsgolf`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `transnum` bigint(20) UNSIGNED NOT NULL,
  `username` text NOT NULL,
  `tgl` date NOT NULL,
  `start` int(10) NOT NULL,
  `end` int(10) NOT NULL,
  `duration` int(10) NOT NULL,
  `field` varchar(30) NOT NULL,
  `price` int(20) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Waiting for Confirmation',
  `datecreated` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `name` text NOT NULL,
  `phonenum` text NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`name`, `phonenum`, `username`, `password`, `role`) VALUES
('admin', '021', 'admin', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `field`
--

CREATE TABLE `field` (
  `fieldnum` varchar(30) NOT NULL,
  `harga` int(10) NOT NULL,
  `hargamalam` int(11) NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `transaksi`
-- (See below for the actual view)
--
CREATE TABLE `transaksi` (
`transnum` bigint(20) unsigned
,`tgl` date
,`username` varchar(20)
,`phonenum` text
,`start` int(10)
,`end` int(10)
,`duration` int(10)
,`fieldnum` varchar(30)
,`price` int(20)
,`status` varchar(30)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `verifikasi`
-- (See below for the actual view)
--
CREATE TABLE `verifikasi` (
`transnum` bigint(20) unsigned
,`username` varchar(20)
,`phonenum` text
,`tgl` date
,`start` int(10)
,`end` int(10)
,`duration` int(10)
,`fieldnum` varchar(30)
,`status` varchar(30)
);

-- --------------------------------------------------------

--
-- Structure for view `transaksi`
--
DROP TABLE IF EXISTS `transaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `transaksi`  AS  select `booking`.`transnum` AS `transnum`,`booking`.`tgl` AS `tgl`,`customer`.`username` AS `username`,`customer`.`phonenum` AS `phonenum`,`booking`.`start` AS `start`,`booking`.`end` AS `end`,`booking`.`duration` AS `duration`,`field`.`fieldnum` AS `fieldnum`,`booking`.`price` AS `price`,`booking`.`status` AS `status` from ((`booking` join `customer` on((`booking`.`username` = `customer`.`username`))) join `field` on((`booking`.`field` = `field`.`fieldnum`))) where (`booking`.`status` <> 'Waiting for Confirmation') ;

-- --------------------------------------------------------

--
-- Structure for view `verifikasi`
--
DROP TABLE IF EXISTS `verifikasi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `verifikasi`  AS  select `booking`.`transnum` AS `transnum`,`customer`.`username` AS `username`,`customer`.`phonenum` AS `phonenum`,`booking`.`tgl` AS `tgl`,`booking`.`start` AS `start`,`booking`.`end` AS `end`,`booking`.`duration` AS `duration`,`field`.`fieldnum` AS `fieldnum`,`booking`.`status` AS `status` from ((`booking` join `customer` on((`booking`.`username` = `customer`.`username`))) join `field` on((`booking`.`field` = `field`.`fieldnum`))) where (`booking`.`status` = 'Waiting for Confirmation') ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`transnum`),
  ADD UNIQUE KEY `transnum` (`transnum`),
  ADD KEY `field` (`field`);

--
-- Indexes for table `field`
--
ALTER TABLE `field`
  ADD PRIMARY KEY (`fieldnum`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `transnum` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`field`) REFERENCES `field` (`fieldnum`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
