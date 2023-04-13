-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 13, 2023 at 01:07 AM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `college-event-website`
--
CREATE DATABASE IF NOT EXISTS `college-event-website` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `college-event-website`;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `adminId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  PRIMARY KEY (`adminId`),
  KEY `Admins_FK` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `commentId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `eventId` int NOT NULL,
  `text` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rating` double NOT NULL,
  `date` date NOT NULL,
  `time` varchar(5) NOT NULL,
  PRIMARY KEY (`commentId`),
  KEY `Comment_UserId_FK` (`userId`),
  KEY `Comment_EventId_FK` (`eventId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `eventId` int NOT NULL AUTO_INCREMENT,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date` date NOT NULL,
  `time` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `category` varchar(20) NOT NULL,
  `locationId` int NOT NULL,
  PRIMARY KEY (`eventId`),
  KEY `Location_FK` (`locationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
CREATE TABLE IF NOT EXISTS `location` (
  `locationId` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  PRIMARY KEY (`locationId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privateevents`
--

DROP TABLE IF EXISTS `privateevents`;
CREATE TABLE IF NOT EXISTS `privateevents` (
  `privateEventId` int NOT NULL AUTO_INCREMENT,
  `eventId` int NOT NULL,
  `universityId` int NOT NULL,
  `createdById` int NOT NULL,
  PRIMARY KEY (`privateEventId`),
  KEY `PrivE_ID_FK` (`eventId`),
  KEY `PrivE_Univ_FK` (`universityId`),
  KEY `PrivE_Created_FK` (`createdById`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publicevents`
--

DROP TABLE IF EXISTS `publicevents`;
CREATE TABLE IF NOT EXISTS `publicevents` (
  `publicEventId` int NOT NULL AUTO_INCREMENT,
  `eventId` int NOT NULL,
  `createdById` int NOT NULL,
  PRIMARY KEY (`publicEventId`),
  KEY `Pub_Events_Id_FK` (`eventId`),
  KEY `Pub_Events_Created_FK` (`createdById`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rsoevents`
--

DROP TABLE IF EXISTS `rsoevents`;
CREATE TABLE IF NOT EXISTS `rsoevents` (
  `rsoEventId` int NOT NULL AUTO_INCREMENT,
  `eventId` int NOT NULL,
  `rsoId` int NOT NULL,
  `createdById` int NOT NULL,
  PRIMARY KEY (`rsoEventId`),
  KEY `RSOE_EventId_FK` (`eventId`),
  KEY `RSOE_RSOId_FK` (`rsoId`),
  KEY `RSOE_Created_FK` (`createdById`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rsomembers`
--

DROP TABLE IF EXISTS `rsomembers`;
CREATE TABLE IF NOT EXISTS `rsomembers` (
  `rsoMembersId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  `rsoId` int NOT NULL,
  PRIMARY KEY (`rsoMembersId`),
  KEY `RSOMem_User_FK` (`userId`),
  KEY `RSOMem_RSOId_FK` (`rsoId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rsos`
--

DROP TABLE IF EXISTS `rsos`;
CREATE TABLE IF NOT EXISTS `rsos` (
  `rsoId` int NOT NULL AUTO_INCREMENT,
  `createdById` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`rsoId`),
  KEY `RSO_Created_FK` (`createdById`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `superadmins`
--

DROP TABLE IF EXISTS `superadmins`;
CREATE TABLE IF NOT EXISTS `superadmins` (
  `superAdminId` int NOT NULL AUTO_INCREMENT,
  `userId` int NOT NULL,
  PRIMARY KEY (`superAdminId`),
  KEY `SuperAdmins_FK` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

DROP TABLE IF EXISTS `universities`;
CREATE TABLE IF NOT EXISTS `universities` (
  `universityId` int NOT NULL AUTO_INCREMENT,
  `createdById` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`universityId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `university` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `FOREIGN` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `Comment_EventId_FK` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Comment_UserId_FK` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `Location_FK` FOREIGN KEY (`locationId`) REFERENCES `location` (`locationId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `privateevents`
--
ALTER TABLE `privateevents`
  ADD CONSTRAINT `PrivE_Created_FK` FOREIGN KEY (`createdById`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PrivE_ID_FK` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `PrivE_Univ_FK` FOREIGN KEY (`universityId`) REFERENCES `universities` (`universityId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `publicevents`
--
ALTER TABLE `publicevents`
  ADD CONSTRAINT `Pub_Events_Created_FK` FOREIGN KEY (`createdById`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Pub_Events_Id_FK` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rsoevents`
--
ALTER TABLE `rsoevents`
  ADD CONSTRAINT `RSOE_Created_FK` FOREIGN KEY (`createdById`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `RSOE_EventId_FK` FOREIGN KEY (`eventId`) REFERENCES `events` (`eventId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `RSOE_RSOId_FK` FOREIGN KEY (`rsoId`) REFERENCES `rsos` (`rsoId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rsomembers`
--
ALTER TABLE `rsomembers`
  ADD CONSTRAINT `RSOMem_RSOId_FK` FOREIGN KEY (`rsoId`) REFERENCES `rsos` (`rsoId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `RSOMem_User_FK` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `rsos`
--
ALTER TABLE `rsos`
  ADD CONSTRAINT `RSO_Created_FK` FOREIGN KEY (`createdById`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `superadmins`
--
ALTER TABLE `superadmins`
  ADD CONSTRAINT `SuperAdmin_FK` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
