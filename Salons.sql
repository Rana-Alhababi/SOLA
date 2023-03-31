-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 17, 2022 at 02:04 AM
-- Server version: 5.7.34
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Salons`
--

-- --------------------------------------------------------

--
-- Table structure for table `Manager`
--

CREATE TABLE `Manager` (
  `ID` varchar(10) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Manager`
--

INSERT INTO `Manager` (`ID`, `first_name`, `last_name`, `user_name`, `password`) VALUES
('22222222', 'Jood', 'Hamlan', 'Jood_Hamlan', '$2y$10$OKkKzDgjDtdA6mcI1I/YKeouOJnPJz3qgLMilDNMmmTA8.MD5Uzsi'),
('22333333', 'Leen', 'Luhaidan', 'Leen_Luhaidan', '$2y$10$XdDSVRVxQHT2op1zZh8t5eHuy8y/Wsbc1k6Z.gpBP2wXv4BwH37bG'),
('22444444', 'Huriyyah', 'Thunayan', 'Huriyyah_Thunayan', '$2y$10$HaH09g61wpQmo/BRX4s4seMPFE9TLwSQw1KthoA4Yt/u6NKpeaZXS'),
('22555555', 'Rana', 'Hababi', 'Rana_Hababi', '$2y$10$prrtBbtHzcoAw3ssF9RoOeHGAHLxw/L2k2mMgXk.XaQcHK8yWN9F6');

-- --------------------------------------------------------

--
-- Table structure for table `Rating`
--

CREATE TABLE `Rating` (
  `RID` int(3) NOT NULL,
  `SID` int(2) NOT NULL,
  `title` varchar(50) NOT NULL,
  `rating` int(3) NOT NULL,
  `PreviousRating` int(3) NOT NULL,
  `total` int(100) NOT NULL,
  `count` int(3) NOT NULL,
  `average` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Rating`
--

INSERT INTO `Rating` (`RID`, `SID`, `title`, `rating`, `PreviousRating`, `total`, `count`, `average`) VALUES
(6, 2, 'scheduling appointment:', 2, 0, 10, 6, 2),
(7, 2, 'value to service:', 3, 0, 12, 5, 2),
(8, 2, 'service:', 3, 0, 13, 5, 3),
(9, 2, 'customer care:', 4, 0, 16, 5, 3),
(10, 2, 'product quality:', 5, 0, 11, 5, 4),
(55, 3, 'scheduling appointment:', 1, 1, 11, 5, 2),
(56, 3, 'value to service:', 1, 1, 11, 5, 2),
(57, 3, 'service:', 1, 5, 14, 5, 3),
(58, 3, 'customer care:', 1, 5, 17, 5, 3),
(59, 3, 'product quality:', 1, 5, 20, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Review`
--

CREATE TABLE `Review` (
  `RevID` int(11) NOT NULL,
  `Description` varchar(128) NOT NULL,
  `service` set('1','2','3') NOT NULL,
  `SID` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Review`
--

INSERT INTO `Review` (`RevID`, `Description`, `service`, `SID`) VALUES
(7, 'Good Nail Service', '1', 2),
(8, 'Good Nail Service', '1', 2),
(9, 'Good Nail service', '1', 3);

-- --------------------------------------------------------

--
-- Table structure for table `SalonsList`
--

CREATE TABLE `SalonsList` (
  `SID` int(5) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Location` varchar(700) NOT NULL,
  `Description` varchar(600) NOT NULL,
  `PhoneNubmer` int(13) NOT NULL,
  `workingDays` set('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
  `OpenHour` time DEFAULT NULL,
  `CloseHour` time DEFAULT NULL,
  `Logo` varchar(455) NOT NULL,
  `service` set('1','2','3') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SalonsList`
--

INSERT INTO `SalonsList` (`SID`, `Name`, `Location`, `Description`, `PhoneNubmer`, `workingDays`, `OpenHour`, `CloseHour`, `Logo`, `service`) VALUES
(2, 'Raff Spa', 'https://g.page/raffnailspa?share', 'Nail care', 50000010, 'Monday,Tuesday,Wednesday,Thursday', '00:33:00', '21:33:00', 'uploads/SHINailSpa.png', '2'),
(3, 'Nail polish', 'https://goo.gl/maps/fKPKaGvnmHUe4Da17', 'Good nail service', 500181415, 'Sunday,Monday,Tuesday,Wednesday', '09:00:00', '00:00:00', 'uploads/lapalma.jpeg', '1');

-- --------------------------------------------------------

--
-- Table structure for table `Services`
--

CREATE TABLE `Services` (
  `ServiceID` set('1','2','3') NOT NULL,
  `Service` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Services`
--

INSERT INTO `Services` (`ServiceID`, `Service`) VALUES
('1', 'Nail care'),
('2', 'Hair dye'),
('1,2', 'Nail care,Hair dye'),
('3', 'Lashes'),
('1,3', 'Nail care,Lashes'),
('2,3', 'Hair dye,Lashes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Manager`
--
ALTER TABLE `Manager`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Rating`
--
ALTER TABLE `Rating`
  ADD PRIMARY KEY (`RID`),
  ADD KEY `SID` (`SID`);

--
-- Indexes for table `Review`
--
ALTER TABLE `Review`
  ADD PRIMARY KEY (`RevID`),
  ADD KEY `SID` (`SID`),
  ADD KEY `service` (`service`) USING BTREE;

--
-- Indexes for table `SalonsList`
--
ALTER TABLE `SalonsList`
  ADD PRIMARY KEY (`SID`),
  ADD KEY `sd` (`service`),
  ADD KEY `workingDays` (`workingDays`);

--
-- Indexes for table `Services`
--
ALTER TABLE `Services`
  ADD PRIMARY KEY (`ServiceID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Rating`
--
ALTER TABLE `Rating`
  MODIFY `RID` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `Review`
--
ALTER TABLE `Review`
  MODIFY `RevID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `SalonsList`
--
ALTER TABLE `SalonsList`
  MODIFY `SID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Rating`
--
ALTER TABLE `Rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`SID`) REFERENCES `SalonsList` (`SID`);

--
-- Constraints for table `Review`
--
ALTER TABLE `Review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`service`) REFERENCES `Services` (`ServiceID`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`SID`) REFERENCES `SalonsList` (`SID`);

--
-- Constraints for table `SalonsList`
--
ALTER TABLE `SalonsList`
  ADD CONSTRAINT `salonslist_ibfk_1` FOREIGN KEY (`service`) REFERENCES `Services` (`ServiceID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
