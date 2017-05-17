-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2016 at 02:11 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--
CREATE DATABASE IF NOT EXISTS `shop` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `shop`;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_ID` int(6) NOT NULL COMMENT 'this is the category ID',
  `catName` varchar(255) NOT NULL COMMENT 'the category name',
  `catDesc` varchar(255) NOT NULL COMMENT 'the category description',
  `catOrdring` int(11) DEFAULT NULL COMMENT 'the ordring methd of the categoruy',
  `catVisabilty` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'the visabilty of the category',
  `catAllowComment` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'the allowing of the comment',
  `catAllowAds` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'the allowing of the ads'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_ID`, `catName`, `catDesc`, `catOrdring`, `catVisabilty`, `catAllowComment`, `catAllowAds`) VALUES
(1, 'mobiles', 'this is the new category', 1, 0, 0, 0),
(2, 'labtops', 'this is the laptops category', 2, 1, 1, 1),
(3, 'Smart TV', 'this the new smart TV', 4, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_ID` int(11) NOT NULL,
  `commentName` text NOT NULL,
  `commentStatuse` tinyint(4) NOT NULL,
  `commentDate` date NOT NULL,
  `item_ID` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_ID`, `commentName`, `commentStatuse`, `commentDate`, `item_ID`, `userId`) VALUES
(4, 'the new coments', 0, '2016-08-10', 5, 25),
(5, 'this is my new comment', 0, '2016-08-08', 6, 26);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_ID` int(11) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `itemDesc` text NOT NULL,
  `itemPrice` varchar(255) NOT NULL,
  `itemAddingDate` date NOT NULL,
  `itemCountryMade` varchar(255) NOT NULL,
  `itemImage` varchar(255) NOT NULL,
  `itemStatuse` varchar(255) NOT NULL,
  `itemRating` smallint(6) NOT NULL,
  `itemApprove` tinyint(4) NOT NULL DEFAULT '0',
  `cat_ID` int(11) NOT NULL,
  `userId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_ID`, `itemName`, `itemDesc`, `itemPrice`, `itemAddingDate`, `itemCountryMade`, `itemImage`, `itemStatuse`, `itemRating`, `itemApprove`, `cat_ID`, `userId`) VALUES
(5, 'samsung Note 7', 'the new phone from samsung', '$20100', '2016-08-26', 'korea', '', '1', 0, 0, 1, 1),
(6, 'Apple laptob', 'the new laptob from apple', '$21000', '2016-08-27', 'USA', '', '1', 0, 0, 2, 26),
(7, 'Sony Smart TV', 'the new UHD quality is now in the new TV from sony', '$3000', '2016-08-27', 'japan', '', '2', 0, 0, 3, 25),
(8, 'IPHONE 6 Plus', 'the new phone from apple with IOS 9.3.3', '$7600', '2016-08-27', 'USA', '', '1', 0, 0, 1, 25),
(9, 'samsung SUHD TV', 'the new smart tv from samsung', '$12000', '2016-08-27', 'korea', '', '3', 0, 0, 3, 26),
(10, 'hp Smart Touch 15', 'the new laptop from HP', '$5000', '2016-08-27', 'USA', '', '4', 0, 0, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL COMMENT 'the user id',
  `userName` varchar(255) NOT NULL COMMENT 'the user name',
  `password` varchar(255) NOT NULL COMMENT 'the password',
  `email` varchar(255) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `groubId` int(11) NOT NULL DEFAULT '0' COMMENT 'id for the user permission',
  `trustStatuse` int(11) NOT NULL DEFAULT '0' COMMENT 'trusted sealer',
  `regStatuse` int(11) NOT NULL DEFAULT '0' COMMENT 'status of the registration',
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `userName`, `password`, `email`, `fullName`, `groubId`, `trustStatuse`, `regStatuse`, `Date`) VALUES
(1, 'alaa', '4c1b52409cf6be3896cf163fa17b32e4da293f2e', 'alaa_dragneel@yahoo.com', 'sasuke_alaa', 1, 0, 1, '2016-08-01'),
(25, 'moaalaa', '4c1b52409cf6be3896cf163fa17b32e4da293f2e', 'alaa@alaa.com', 'moa alaa', 0, 0, 0, '2016-08-26'),
(26, 'mohamed', '4c1b52409cf6be3896cf163fa17b32e4da293f2e', 'alaa_dragneel@yahoo.com', 'alaa_dragneel', 0, 0, 0, '2016-08-26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_ID`),
  ADD UNIQUE KEY `catName` (`catName`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_ID`),
  ADD KEY `itemComment` (`item_ID`),
  ADD KEY `usersComment` (`userId`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_ID`),
  ADD KEY `member_1` (`userId`),
  ADD KEY `cat_1` (`cat_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_ID` int(6) NOT NULL AUTO_INCREMENT COMMENT 'this is the category ID', AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'the user id', AUTO_INCREMENT=27;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `itemComment` FOREIGN KEY (`item_ID`) REFERENCES `items` (`item_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usersComment` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `cat_1` FOREIGN KEY (`cat_ID`) REFERENCES `categories` (`cat_ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `member_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
