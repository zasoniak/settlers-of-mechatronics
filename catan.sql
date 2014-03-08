-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 07, 2014 at 11:46 AM
-- Server version: 5.5.35-0ubuntu0.13.10.2
-- PHP Version: 5.5.3-1ubuntu2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `catan`
--

-- --------------------------------------------------------

--
-- Table structure for table `boards`
--

CREATE TABLE IF NOT EXISTS `boards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `thief` int(11) NOT NULL DEFAULT '0',
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  `is_changed` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `boards`
--

INSERT INTO `boards` (`id`, `thief`, `finished`, `is_changed`) VALUES
(1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('knight','victorypoint','monopoly','yearofplenty','roadbuilding') CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wood` int(11) NOT NULL DEFAULT '0',
  `stone` int(11) NOT NULL DEFAULT '0',
  `sheep` int(11) NOT NULL DEFAULT '0',
  `clay` int(11) NOT NULL DEFAULT '0',
  `wheat` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ports`
--

CREATE TABLE IF NOT EXISTS `ports` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('default','wood','stone','sheep','clay','wheat') COLLATE utf8_bin NOT NULL,
  `board_id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=10 ;

--
-- Dumping data for table `ports`
--

INSERT INTO `ports` (`id`, `type`, `board_id`, `x`, `y`, `z`) VALUES
(1, 'default', 1, 15, 10, -25),
(2, 'wood', 1, -5, 25, -20),
(3, 'default', 1, -20, 25, -5),
(4, 'stone', 1, -25, 15, 10),
(5, 'wheat', 1, -25, 0, 25),
(6, 'clay', 1, -10, -15, 25),
(7, 'default', 1, 10, -25, 15),
(8, 'default', 1, 25, -25, 0),
(9, 'sheep', 1, 25, -5, -20);

-- --------------------------------------------------------

--
-- Table structure for table `roads`
--

CREATE TABLE IF NOT EXISTS `roads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=73 ;

--
-- Dumping data for table `roads`
--

INSERT INTO `roads` (`id`, `board_id`, `x`, `y`, `z`) VALUES
(1, 1, -20, -5, 25),
(2, 1, -20, 5, 15),
(3, 1, -20, 15, 5),
(4, 1, -20, 25, -5),
(5, 1, -10, -15, 25),
(6, 1, -10, -5, 15),
(7, 1, -10, 5, 5),
(8, 1, -10, 15, -5),
(9, 1, -10, 25, -15),
(10, 1, 0, -25, 25),
(11, 1, 0, -15, 15),
(12, 1, 0, -5, 5),
(13, 1, 0, 5, -5),
(14, 1, 0, 15, -15),
(15, 1, 0, 25, -25),
(16, 1, 10, -25, 15),
(17, 1, 10, -15, 5),
(18, 1, 10, -5, -5),
(19, 1, 10, 5, -15),
(20, 1, 10, 15, -25),
(21, 1, 20, -25, 5),
(22, 1, 20, -15, -5),
(23, 1, 20, -5, -15),
(24, 1, 20, 5, -25),
(25, 1, 25, -5, -20),
(26, 1, 15, 5, -20),
(27, 1, 5, 15, -20),
(28, 1, -5, 25, -20),
(29, 1, 25, -15, -10),
(30, 1, 15, -5, -10),
(31, 1, 5, 5, -10),
(32, 1, -5, 15, -10),
(33, 1, -15, 25, -10),
(34, 1, 25, -25, 0),
(35, 1, 15, -15, 0),
(36, 1, 5, -5, 0),
(37, 1, -5, 5, 0),
(38, 1, -15, 15, 0),
(39, 1, -25, 25, 0),
(40, 1, 15, -25, 10),
(41, 1, 5, -15, 10),
(42, 1, -5, -5, 10),
(43, 1, -15, 5, 10),
(44, 1, -25, 15, 10),
(45, 1, 5, -25, 20),
(46, 1, -5, -15, 20),
(47, 1, -15, -5, 20),
(48, 1, -25, 5, 20),
(49, 1, -5, -20, 25),
(50, 1, 5, -20, 15),
(51, 1, 15, -20, 5),
(52, 1, 25, -20, -5),
(53, 1, -15, -10, 25),
(54, 1, -5, -10, 15),
(55, 1, 5, -10, 5),
(56, 1, 15, -10, -5),
(57, 1, 25, -10, -15),
(58, 1, -25, 0, 25),
(59, 1, -15, 0, 15),
(60, 1, -5, 0, 5),
(61, 1, 5, 0, -5),
(62, 1, 15, 0, -15),
(63, 1, 25, 0, -25),
(64, 1, -25, 10, 15),
(65, 1, -15, 10, 5),
(66, 1, -5, 10, -5),
(67, 1, 5, 10, -15),
(68, 1, 15, 10, -25),
(69, 1, -25, 20, 5),
(70, 1, -15, 20, -5),
(71, 1, -5, 20, -15),
(72, 1, 5, 20, -25);

-- --------------------------------------------------------

--
-- Table structure for table `settlements`
--

CREATE TABLE IF NOT EXISTS `settlements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_town` tinyint(1) NOT NULL DEFAULT '0',
  `board_id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=55 ;

--
-- Dumping data for table `settlements`
--

INSERT INTO `settlements` (`id`, `is_town`, `board_id`, `x`, `y`, `z`) VALUES
(1, 0, 1, -25, -5, 25),
(2, 0, 1, -25, 5, 15),
(3, 0, 1, -25, 5, 25),
(4, 0, 1, -25, 15, 5),
(5, 0, 1, -25, 15, 15),
(6, 0, 1, -25, 25, -5),
(7, 0, 1, -25, 25, 5),
(8, 0, 1, -15, -15, 25),
(9, 0, 1, -15, -5, 15),
(10, 0, 1, -15, -5, 25),
(11, 0, 1, -15, 5, 5),
(12, 0, 1, -15, 5, 15),
(13, 0, 1, -15, 15, -5),
(14, 0, 1, -15, 15, 5),
(15, 0, 1, -15, 25, -15),
(16, 0, 1, -15, 25, -5),
(17, 0, 1, -5, -25, 25),
(18, 0, 1, -5, -15, 15),
(19, 0, 1, -5, -15, 25),
(20, 0, 1, -5, -5, 5),
(21, 0, 1, -5, -5, 15),
(22, 0, 1, -5, 5, -5),
(23, 0, 1, -5, 5, 5),
(24, 0, 1, -5, 15, -15),
(25, 0, 1, -5, 15, -5),
(26, 0, 1, -5, 25, -25),
(27, 0, 1, -5, 25, -15),
(28, 0, 1, 5, -25, 15),
(29, 0, 1, 5, -25, 25),
(30, 0, 1, 5, -15, 5),
(31, 0, 1, 5, -15, 15),
(32, 0, 1, 5, -5, -5),
(33, 0, 1, 5, -5, 5),
(34, 0, 1, 5, 5, -15),
(35, 0, 1, 5, 5, -5),
(36, 0, 1, 5, 15, -25),
(37, 0, 1, 5, 15, -15),
(38, 0, 1, 5, 25, -25),
(39, 0, 1, 15, -25, 5),
(40, 0, 1, 15, -25, 15),
(41, 0, 1, 15, -15, -5),
(42, 0, 1, 15, -15, 5),
(43, 0, 1, 15, -5, -15),
(44, 0, 1, 15, -5, -5),
(45, 0, 1, 15, 5, -25),
(46, 0, 1, 15, 5, -15),
(47, 0, 1, 15, 15, -25),
(48, 0, 1, 25, -25, -5),
(49, 0, 1, 25, -25, 5),
(50, 0, 1, 25, -15, -15),
(51, 0, 1, 25, -15, -5),
(52, 0, 1, 25, -5, -25),
(53, 0, 1, 25, -5, -15),
(54, 0, 1, 25, 5, -25);

-- --------------------------------------------------------

--
-- Table structure for table `tiles`
--

CREATE TABLE IF NOT EXISTS `tiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('desert','stone','wood','clay','sheep','wheat','ocean') COLLATE utf8_bin NOT NULL DEFAULT 'ocean',
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  `probability` int(11) DEFAULT NULL,
  `board_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=38 ;

--
-- Dumping data for table `tiles`
--

INSERT INTO `tiles` (`id`, `type`, `x`, `y`, `z`, `probability`, `board_id`) VALUES
(1, 'ocean', -30, 0, 30, NULL, 1),
(2, 'ocean', -30, 10, 20, NULL, 1),
(3, 'ocean', -30, 20, 10, NULL, 1),
(4, 'ocean', -30, 30, 0, NULL, 1),
(5, 'ocean', -20, -10, 30, NULL, 1),
(6, 'wood', -20, 0, 20, 3, 1),
(7, 'stone', -20, 10, 10, 10, 1),
(8, 'stone', -20, 20, 0, 8, 1),
(9, 'ocean', -20, 30, -10, NULL, 1),
(10, 'ocean', -10, -20, 30, NULL, 1),
(11, 'clay', -10, -10, 20, 8, 1),
(12, 'sheep', -10, 0, 10, 4, 1),
(13, 'wood', -10, 10, 0, 3, 1),
(14, 'wheat', -10, 20, -10, 12, 1),
(15, 'ocean', -10, 30, -20, NULL, 1),
(16, 'ocean', 0, -30, 30, NULL, 1),
(17, 'wheat', 0, -20, 20, 9, 1),
(18, 'wheat', 0, -10, 10, 6, 1),
(19, 'sheep', 0, 0, 0, 5, 1),
(20, 'clay', 0, 10, -10, 2, 1),
(21, 'clay', 0, 20, -20, 5, 1),
(22, 'ocean', 0, 30, -30, NULL, 1),
(23, 'ocean', 10, -30, 20, NULL, 1),
(24, 'sheep', 10, -20, 10, 11, 1),
(25, 'wood', 10, -10, 0, 10, 1),
(26, 'sheep', 10, 0, -10, 4, 1),
(27, 'stone', 10, 10, -20, 11, 1),
(28, 'ocean', 10, 20, -30, NULL, 1),
(29, 'ocean', 20, -30, 10, NULL, 1),
(30, 'desert', 20, -20, 0, NULL, 1),
(31, 'wood', 20, -10, -10, 6, 1),
(32, 'wheat', 20, 0, -20, 9, 1),
(33, 'ocean', 20, 10, -30, NULL, 1),
(34, 'ocean', 30, -30, 0, NULL, 1),
(35, 'ocean', 30, -20, -10, NULL, 1),
(36, 'ocean', 30, -10, -20, NULL, 1),
(37, 'ocean', 30, 0, -30, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(250) COLLATE utf8_bin NOT NULL,
  `email` varchar(250) COLLATE utf8_bin NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  `games_played` int(11) NOT NULL DEFAULT '0',
  `games_won` int(11) NOT NULL DEFAULT '0',
  `games_completed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
