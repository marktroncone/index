-- phpMyAdmin SQL Dump
-- version 4.0.10.18
-- https://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Sep 10, 2017 at 09:49 AM
-- Server version: 5.6.36-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `linetime`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `username` text NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`username`, `password`) VALUES
('mark', 'Mark1234!');

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  `address` text,
  `latitude` decimal(9,6) DEFAULT NULL,
  `longitude` decimal(9,6) DEFAULT NULL,
  `queue_time` float DEFAULT NULL,
  `hr_min` tinytext,
  `place_type` tinytext,
  `logo` tinytext,
  `added_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=190 ;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `name`, `address`, `latitude`, `longitude`, `queue_time`, `hr_min`, `place_type`, `logo`, `added_time`, `updated_time`) VALUES
(173, 'sas', 'Portsaid street, Giza, Giza Governorate, Egypt', '29.959811', '31.213964', 14, 'MIN', 'nightclub', 'fbd7939d674997cdb4692d34de8633c4.jpg', '2017-09-07 17:38:11', '2017-09-08 00:38:11'),
(176, 'Fat Controller ', '136 North Terrace, Adelaide, South Australia, Australia', '-34.922005', '138.597278', 20, 'MIN', 'nightclub', '9f61408e3afb633e50cdf1b20de6f466.jpg', '2017-09-04 23:13:46', '2017-09-05 06:13:46'),
(180, 'Mr Kim''s', '17 Crippen Place, Adelaide, South Australia, Australia', '-34.922955', '138.594234', 20, 'MIN', 'nightclub', 'c81e728d9d4c2f636f067f89cc14862c.jpg', '2017-09-06 00:47:49', '2017-09-06 07:47:49'),
(182, 'Big Window', '99 Hindley Street, Adelaide, South Australia, Australia', '-34.923381', '138.595830', 45, 'MIN', 'nightclub', 'a684eceee76fc522773286a895bc8436.jpg', '2017-09-04 16:14:40', '2017-09-04 23:14:40'),
(184, 'Super California ', '9 Hindley Street, Adelaide, South Australia, Australia', '-34.923243', '138.598979', 45, 'MIN', 'nightclub', '1385974ed5904a438616ff7bdb3f7439.jpg', '2017-09-05 01:35:59', '2017-09-05 08:35:59'),
(185, 'Black Bull on Hindley', '58 Hindley Street, Adelaide, South Australia, Australia', '-34.922769', '138.597239', 10, 'MIN', 'nightclub', '8f53295a73878494e9bc8dd6c3c7104f.jpg', '2017-09-10 11:08:32', '2017-09-10 00:55:07'),
(186, 'The Woolshed ', '94-100 Hindley Street, Adelaide, South Australia, Australia', '-34.922799', '138.595764', 20, 'MIN', 'nightclub', 'c9f0f895fb98ab9159f51fd0297e236d.jpg', '2017-09-10 15:35:56', '2017-09-08 23:48:57'),
(187, 'Hacienda', 'Synagogue Place, Adelaide, South Australia, Australia', '-34.922310', '138.606763', 5, 'MIN', 'nightclub', '31fefc0e570cb3860f2a6d4b38c6490d.jpg', '2017-09-09 15:10:17', '2017-09-09 22:10:17'),
(189, 'Electric Circus', '17 Crippen Place, Adelaide, South Australia, Australia', '-34.922967', '138.594087', 0, '', 'nightclub', 'f033ab37c30201f73f142449d037028d.jpg', '2017-09-10 12:32:18', '2017-09-10 12:28:18');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
