-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2020 at 11:22 PM
-- Server version: 5.7.31-0ubuntu0.16.04.1
-- PHP Version: 7.3.22-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mritransferapi`
--

-- --------------------------------------------------------

--
-- Table structure for table `archieve_transfer`
--

CREATE TABLE `archieve_transfer` (
  `transfer_id` int(11) NOT NULL,
  `transfer_req_id` varchar(8) NOT NULL,
  `transfer_type` tinyint(4) NOT NULL,
  `jenis_pembayaran_id` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `waktu_request` datetime NOT NULL,
  `jadwal_transfer` datetime NOT NULL,
  `norek` varchar(34) NOT NULL,
  `pemilik_rekening` varchar(70) NOT NULL,
  `bank` varchar(25) NOT NULL,
  `kode_bank` varchar(8) NOT NULL,
  `berita_transfer` varchar(18) NOT NULL,
  `jumlah` int(16) NOT NULL,
  `terotorisasi` tinyint(4) NOT NULL,
  `hasil_transfer` tinyint(4) NOT NULL,
  `ket_transfer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `data_transfer`
--

CREATE TABLE `data_transfer` (
  `transfer_id` int(11) NOT NULL,
  `transfer_req_id` varchar(8) NOT NULL,
  `transfer_type` tinyint(4) NOT NULL,
  `jenis_pembayaran_id` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `waktu_request` datetime NOT NULL,
  `jadwal_transfer` datetime NOT NULL,
  `norek` varchar(34) NOT NULL,
  `pemilik_rekening` varchar(70) NOT NULL,
  `bank` varchar(25) NOT NULL,
  `kode_bank` varchar(8) NOT NULL,
  `berita_transfer` varchar(18) NOT NULL,
  `jumlah` int(16) NOT NULL,
  `terotorisasi` tinyint(4) NOT NULL,
  `hasil_transfer` tinyint(4) NOT NULL,
  `ket_transfer` text NOT NULL,
  `nm_pembuat` varchar(50) NOT NULL,
  `nm_validasi` varchar(50) NOT NULL,
  `nm_otorisasi` varchar(50) NOT NULL,
  `nm_manual` varchar(50) NOT NULL,
  `jenis_project` varchar(50) NOT NULL,
  `nm_project` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pembayaran`
--

CREATE TABLE `jenis_pembayaran` (
  `jenispembayaranid` int(11) NOT NULL,
  `jenispembayaran` varchar(30) NOT NULL,
  `max_transfer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `roleid` int(11) NOT NULL,
  `role` varchar(255) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`roleid`, `role`, `level`) VALUES
(1, 'administrator', 1),
(2, 'user', 2),
(3, 'owner', 3);

-- --------------------------------------------------------

--
-- Table structure for table `saldo`
--

CREATE TABLE `saldo` (
  `saldo_id` int(11) NOT NULL,
  `saldo` int(11) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

CREATE TABLE `token` (
  `id_token` int(11) NOT NULL,
  `token` varchar(225) DEFAULT '0',
  `user_id` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `token`
--

INSERT INTO `token` (`id_token`, `token`, `user_id`) VALUES
(1, '$2y$05$uPeOKLcLOQ/9Hw3qJR9vSeMgAWEaKcwRRemvt3vJ27fwGRuEGroVq', 4);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_login` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `roleid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `user_login`, `nama`, `user_password`, `roleid`) VALUES
(1, 'hendra', 'hendra@mri-research-ind.com', 'hendra', 'ed9ac0332a09ec5d57bd3e06035c02bc', 1),
(4, '001', 'ina.puspito@gmail.com', 'Ina Puspito', 'dfff02ee86f3e8fc332bf74eb0e64a6c', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id` int(11) NOT NULL,
  `roleid` int(11) NOT NULL,
  `menuid` int(11) NOT NULL,
  `submenuid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`id`, `roleid`, `menuid`, `submenuid`) VALUES
(1, 1, 2, 2),
(45, 1, 2, 1),
(46, 1, 2, 3),
(47, 1, 3, 6),
(48, 1, 3, 7),
(49, 1, 4, 8),
(50, 1, 4, 9),
(51, 1, 4, 10),
(52, 1, 4, 11),
(54, 2, 4, 8),
(55, 2, 4, 9),
(56, 2, 4, 10),
(57, 2, 4, 11),
(58, 3, 2, 1),
(59, 3, 2, 3),
(60, 3, 3, 6),
(61, 3, 3, 7),
(62, 3, 4, 8),
(63, 3, 4, 9),
(64, 3, 4, 10),
(65, 3, 4, 11),
(66, 3, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `id` int(11) NOT NULL,
  `menu` varchar(128) NOT NULL,
  `url` varchar(128) DEFAULT NULL,
  `icon` varchar(128) DEFAULT NULL,
  `is_active` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`id`, `menu`, `url`, `icon`, `is_active`) VALUES
(1, 'Dashboard', 'dashboard', 'nav-icon fas fa-tachometer-alt', '1'),
(2, 'User Management', '#', 'fas fa-user-tie', '1'),
(3, 'Token', '#', 'nav-icon fas fa-key', '1'),
(4, 'Data Transfer', '#', 'nav-icon fas fa-table', '1');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `sub_menu` varchar(128) DEFAULT NULL,
  `url` varchar(128) DEFAULT NULL,
  `icon` varchar(128) DEFAULT NULL,
  `is_active` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id`, `menu_id`, `sub_menu`, `url`, `icon`, `is_active`) VALUES
(1, 2, 'List User', 'user/listuser', 'far fa-circle nav-icon', 1),
(2, 2, 'List Role', 'role/listrole', 'far fa-circle nav-icon', 1),
(3, 2, 'Type Payment', 'typepay/listtypepay', 'far fa-circle nav-icon', 1),
(4, 2, 'Menu User', 'menu/listmenu', 'far fa-circle nav-icon', 1),
(5, 2, 'Sub Menu User', 'menu/listsubmenu', 'far fa-circle nav-icon', 1),
(6, 3, 'API Key', 'token/apikey', 'far fa-circle nav-icon', 1),
(7, 3, 'Session Key BCA', 'token/sessionkey', 'far fa-circle nav-icon', 1),
(8, 4, 'List Transfer Pending', 'transfer/listtransfer', 'far fa-circle nav-icon', 1),
(9, 4, 'Transfer Otorisasi', 'transfer/otorisasi', 'far fa-circle nav-icon', 1),
(10, 4, 'Transfer Manual', 'transfer/transfermanual', 'far fa-circle nav-icon', 1),
(11, 4, 'Laporan Transfer', 'transfer/laporantransfer', 'far fa-circle nav-icon', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(50) NOT NULL,
  `date_created` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `archieve_transfer`
--
ALTER TABLE `archieve_transfer`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `data_transfer`
--
ALTER TABLE `data_transfer`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `jenis_pembayaran`
--
ALTER TABLE `jenis_pembayaran`
  ADD PRIMARY KEY (`jenispembayaranid`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`roleid`);

--
-- Indexes for table `saldo`
--
ALTER TABLE `saldo`
  ADD PRIMARY KEY (`saldo_id`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id_token`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`,`username`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `archieve_transfer`
--
ALTER TABLE `archieve_transfer`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `data_transfer`
--
ALTER TABLE `data_transfer`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jenis_pembayaran`
--
ALTER TABLE `jenis_pembayaran`
  MODIFY `jenispembayaranid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `roleid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `saldo`
--
ALTER TABLE `saldo`
  MODIFY `saldo_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id_token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;
--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
