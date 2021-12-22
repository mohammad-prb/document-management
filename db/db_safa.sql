-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 14, 2021 at 12:59 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_safa`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_aza`
--

CREATE TABLE `tbl_aza` (
  `id` int(11) NOT NULL,
  `codePerseneli` int(6) NOT NULL,
  `vaziat` tinyint(4) NOT NULL DEFAULT '1',
  `nam` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `famil` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `pass` varchar(50) COLLATE utf8_persian_ci NOT NULL,
  `sath` tinyint(4) NOT NULL,
  `tarikhSabt` date NOT NULL,
  `zamanSabt` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_aza`
--

INSERT INTO `tbl_aza` (`id`, `codePerseneli`, `vaziat`, `nam`, `famil`, `pass`, `sath`, `tarikhSabt`, `zamanSabt`) VALUES
(1, 123, 1, 'داوود', 'پوربهزاد', '25d55ad283aa400af464c76d713c07ad', 1, '1399-05-13', '12:35:15'),
(2, 456123, 1, 'داوود', 'رضایی اصل', '6b9ebff0c8d4ffaec2e3657a59fcb47a', 2, '1399-05-13', '12:35:15'),
(3, 1234, 1, 'امیر مهدی', 'قاسم زاده', '2f8a18480a2c2e8cb1d9fb876c1d4e6d', 3, '1399-05-13', '12:35:15'),
(4, 4523, 0, 'قلی', 'قلیایی', '9b43d23851af0fc818039e606cd6341e', 4, '1399-07-14', '16:43:24'),
(5, 4653, 1, 'امیر رضا', 'رضایی', '7a572da2183309852083a2de89d67999', 2, '1399-07-14', '16:43:24'),
(6, 4567, 1, 'سید دانیال', 'کاظمی', '9b43d23851af0fc818039e606cd6341e', 3, '1399-07-14', '16:43:24'),
(7, 35245, 1, 'غلامعلی', 'دانیالی', '2f8a18480a2c2e8cb1d9fb876c1d4e6d', 4, '1399-07-14', '16:43:24'),
(8, 12345, 1, 'دانیال', 'محمد زاده اصل', 'c8075c504eeaaed272705414acc5f56a', 2, '1399-07-14', '16:43:24'),
(9, 355, 1, 'محمد مهدی', 'پوردانیال', '2f8a18480a2c2e8cb1d9fb876c1d4e6d', 3, '1399-07-14', '16:43:24'),
(10, 3213, 1, 'کاظم', 'حسن پور', '9b43d23851af0fc818039e606cd6341e', 4, '1399-07-14', '16:43:24'),
(11, 6896, 1, 'فرید', 'کریمی', '2f8a18480a2c2e8cb1d9fb876c1d4e6d', 2, '1399-07-14', '16:43:24'),
(12, 985, 1, 'مریم', 'باروز', '9b43d23851af0fc818039e606cd6341e', 3, '1399-07-14', '16:43:24'),
(13, 9875, 0, 'نرگس', 'محمد زاده', '2f8a18480a2c2e8cb1d9fb876c1d4e6d', 4, '1399-07-14', '16:43:24'),
(14, 6875, 1, 'نفیسه', 'رضا زاده', '118f4930fdb6743648a137a2924ba4ba', 2, '1399-07-14', '16:43:24'),
(15, 4568, 1, 'حسن', 'چودن', '2f8a18480a2c2e8cb1d9fb876c1d4e6d', 3, '1399-07-14', '16:43:24'),
(16, 6542, 0, 'حسین', 'دایی', '93fdaaa774c82091f364f8e6e69dbde2', 4, '1399-07-14', '16:43:24'),
(17, 78568, 1, 'مرتضی', 'سارنی', '0e7cb97990b7995fb1fafd5179e2b9a8', 2, '1399-07-14', '16:43:24'),
(18, 7565, 1, 'وحید', 'صارمی', '2b3bafba6e496adfe3348d76ca0b491f', 3, '1399-07-14', '16:43:24'),
(19, 8566, 1, 'سعید', 'بحجت', '2f8a18480a2c2e8cb1d9fb876c1d4e6d', 4, '1399-07-14', '16:43:24'),
(20, 3655, 1, 'راحله', 'هاشمی', '9b43d23851af0fc818039e606cd6341e', 2, '1399-07-14', '16:43:24'),
(21, 56552, 1, 'آرزو', 'خزایی', '2f8a18480a2c2e8cb1d9fb876c1d4e6d', 3, '1399-07-14', '16:43:24'),
(22, 4444, 1, 'سارا', 'خادم الحسینی', '9b43d23851af0fc818039e606cd6341e', 4, '1399-07-14', '16:43:24'),
(23, 5635, 1, 'پریسا', 'اکبری', '2f8a18480a2c2e8cb1d9fb876c1d4e6d', 3, '1399-07-14', '16:43:24'),
(24, 3546, 1, 'علی', 'قاسمی', '9b43d23851af0fc818039e606cd6341e', 3, '1399-07-14', '16:43:24'),
(25, 456456, 1, 'علیرضا', 'قربانی', '74bde0283649248ef0933201aeaf497d', 2, '1399-07-14', '22:11:42'),
(27, 53452, 1, 'صالح', 'صالحی', '7d8c31bc9f787657a6abed0639dfdfda', 4, '1399-07-14', '22:14:08'),
(28, 78545, 1, 'رضا', 'رضایی', 'ceda19b352c54aaa5e79ed8d9d6cdd43', 3, '1399-07-18', '22:13:20'),
(29, 4563, 1, 'علی', 'رضایی', '955db917817eabcc9ae85d8ae9e81fa8', 3, '1399-10-01', '19:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barchasb`
--

CREATE TABLE `tbl_barchasb` (
  `id` bigint(20) NOT NULL,
  `barchasb` varchar(60) COLLATE utf8_persian_ci NOT NULL,
  `tarikhSabt` date NOT NULL,
  `zamanSabt` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_barchasb`
--

INSERT INTO `tbl_barchasb` (`id`, `barchasb`, `tarikhSabt`, `zamanSabt`) VALUES
(36, 'فروش', '1399-10-01', '21:27:13'),
(37, 'حسابداری', '1399-10-01', '21:27:24'),
(38, 'بازرگانی', '1399-10-01', '21:27:32'),
(39, 'انبار', '1399-10-01', '21:27:38'),
(40, 'منابع انسانی', '1399-10-01', '21:28:22'),
(41, 'آموزش', '1399-10-01', '21:45:51'),
(42, 'دستورالعمل', '1399-10-01', '21:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_barchasb_matlab`
--

CREATE TABLE `tbl_barchasb_matlab` (
  `id` bigint(20) NOT NULL,
  `dastehID` bigint(20) NOT NULL,
  `barchasbID` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_barchasb_matlab`
--

INSERT INTO `tbl_barchasb_matlab` (`id`, `dastehID`, `barchasbID`) VALUES
(138, 18, 37),
(139, 18, 36),
(140, 16, 37),
(141, 16, 42),
(142, 16, 36),
(143, 15, 42),
(144, 15, 36),
(145, 17, 39),
(146, 17, 38),
(147, 17, 37),
(148, 17, 42),
(149, 17, 36),
(150, 19, 41),
(151, 19, 36),
(152, 19, 40),
(153, 20, 41);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_captcha`
--

CREATE TABLE `tbl_captcha` (
  `id` int(11) NOT NULL,
  `address` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_persian_ci NOT NULL,
  `adad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_captcha`
--

INSERT INTO `tbl_captcha` (`id`, `address`, `adad`) VALUES
(1, '74', 67315),
(2, '753', 97242),
(3, '1234', 68721),
(4, '4513', 13885),
(5, '4534', 49315),
(6, '6465', 19542),
(7, '6546', 45671),
(8, '7353', 63924),
(9, '7535', 13945),
(10, '12374', 27438),
(11, '41234', 75196),
(12, '45312', 12473),
(13, '68543', 26429),
(14, '78574', 74675),
(15, '123574', 54826),
(16, '452342', 49484),
(17, '452345', 16529),
(18, '645635', 48219),
(19, '1525347', 41358),
(20, '4523674', 14342);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_dasteh`
--

CREATE TABLE `tbl_dasteh` (
  `id` bigint(20) NOT NULL,
  `dasteh` text COLLATE utf8_persian_ci NOT NULL,
  `sath` tinyint(4) NOT NULL,
  `vaziat` tinyint(4) NOT NULL DEFAULT '1',
  `tarikhSabt` date NOT NULL,
  `zamanSabt` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_dasteh`
--

INSERT INTO `tbl_dasteh` (`id`, `dasteh`, `sath`, `vaziat`, `tarikhSabt`, `zamanSabt`) VALUES
(15, 'دستورالعمل های فروشگاهی', 4, 1, '1399-10-01', '21:29:15'),
(16, 'دستورالعمل تخفیف', 4, 1, '1399-10-01', '21:37:51'),
(17, 'دستورالعمل ورود کالا و کنترل های کیفی', 3, 1, '1399-10-01', '21:42:15'),
(18, 'لیست قیمت عطر', 4, 1, '1399-10-01', '21:43:49'),
(19, 'اصطلاحات پرکاربرد دنیای عطر وکلن', 4, 1, '1399-10-01', '21:47:37'),
(20, 'معرفی کالا', 4, 1, '1399-10-22', '21:46:05');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pdf`
--

CREATE TABLE `tbl_pdf` (
  `id` bigint(20) NOT NULL,
  `address` varchar(100) COLLATE utf8_persian_ci NOT NULL,
  `dastehID` bigint(20) NOT NULL,
  `vaziat` tinyint(4) NOT NULL DEFAULT '1',
  `tarikhErsal` date NOT NULL,
  `zamanErsal` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_pdf`
--

INSERT INTO `tbl_pdf` (`id`, `address`, `dastehID`, `vaziat`, `tarikhErsal`, `zamanErsal`) VALUES
(11, 'dsfr.pdf', 15, 1, '1399-10-01', '21:32:21'),
(12, 'takhfii.pdf', 16, 1, '1399-10-01', '21:40:36'),
(13, 'dsvrkh.pdf', 17, 1, '1399-10-01', '21:42:48'),
(14, 'list.pdf', 18, 1, '1399-10-01', '21:44:24'),
(15, '4_433307271829651876.pdf', 19, 1, '1400-04-05', '19:04:48');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sath`
--

CREATE TABLE `tbl_sath` (
  `id` tinyint(4) NOT NULL,
  `namSath` varchar(50) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tbl_sath`
--

INSERT INTO `tbl_sath` (`id`, `namSath`) VALUES
(1, 'ادمین'),
(2, 'هیئت مدیره'),
(3, 'مدیران میانی'),
(4, 'پرسنل عادی');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_aza`
--
ALTER TABLE `tbl_aza`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_aza_codePerseneli_uindex` (`codePerseneli`);

--
-- Indexes for table `tbl_barchasb`
--
ALTER TABLE `tbl_barchasb`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_barchasb_matlab`
--
ALTER TABLE `tbl_barchasb_matlab`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_captcha`
--
ALTER TABLE `tbl_captcha`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_captcha_address_uindex` (`address`);

--
-- Indexes for table `tbl_dasteh`
--
ALTER TABLE `tbl_dasteh`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_pdf`
--
ALTER TABLE `tbl_pdf`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tbl_pdf_address_uindex` (`address`);

--
-- Indexes for table `tbl_sath`
--
ALTER TABLE `tbl_sath`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_aza`
--
ALTER TABLE `tbl_aza`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `tbl_barchasb`
--
ALTER TABLE `tbl_barchasb`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `tbl_barchasb_matlab`
--
ALTER TABLE `tbl_barchasb_matlab`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;
--
-- AUTO_INCREMENT for table `tbl_captcha`
--
ALTER TABLE `tbl_captcha`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `tbl_dasteh`
--
ALTER TABLE `tbl_dasteh`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `tbl_pdf`
--
ALTER TABLE `tbl_pdf`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `tbl_sath`
--
ALTER TABLE `tbl_sath`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
