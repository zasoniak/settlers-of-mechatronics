-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 31, 2014 at 10:34 AM
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
  `game_id` int(11) NOT NULL,
  `thief_location` int(11) NOT NULL DEFAULT '0',
  `is_changed` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `boards`
--

INSERT INTO `boards` (`id`, `game_id`, `thief_location`, `is_changed`) VALUES
(1, 1, 17, 1),
(2, 2, 50, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=51 ;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `board_id`, `player_id`, `is_used`, `type`) VALUES
(1, 1, NULL, 0, 'knight'),
(2, 1, NULL, 0, 'monopoly'),
(3, 1, NULL, 0, 'knight'),
(4, 1, NULL, 0, 'knight'),
(5, 1, NULL, 0, 'knight'),
(6, 1, NULL, 0, 'knight'),
(7, 1, NULL, 0, 'knight'),
(8, 1, NULL, 0, 'knight'),
(9, 1, NULL, 0, 'monopoly'),
(10, 1, NULL, 0, 'victorypoint'),
(11, 1, NULL, 0, 'yearofplenty'),
(12, 1, NULL, 0, 'knight'),
(13, 1, NULL, 0, 'knight'),
(14, 1, NULL, 0, 'victorypoint'),
(15, 1, NULL, 0, 'yearofplenty'),
(16, 1, NULL, 0, 'victorypoint'),
(17, 1, NULL, 0, 'victorypoint'),
(18, 1, NULL, 0, 'knight'),
(19, 1, NULL, 0, 'roadbuilding'),
(20, 1, NULL, 0, 'victorypoint'),
(21, 1, NULL, 0, 'knight'),
(22, 1, NULL, 0, 'knight'),
(23, 1, NULL, 0, 'knight'),
(24, 1, NULL, 0, 'knight'),
(25, 1, NULL, 0, 'roadbuilding'),
(26, 2, NULL, 0, 'knight'),
(27, 2, NULL, 0, 'roadbuilding'),
(28, 2, NULL, 0, 'victorypoint'),
(29, 2, NULL, 0, 'victorypoint'),
(30, 2, NULL, 0, 'roadbuilding'),
(31, 2, NULL, 0, 'yearofplenty'),
(32, 2, NULL, 0, 'knight'),
(33, 2, NULL, 0, 'monopoly'),
(34, 2, NULL, 0, 'knight'),
(35, 2, NULL, 0, 'knight'),
(36, 2, NULL, 0, 'victorypoint'),
(37, 2, NULL, 0, 'knight'),
(38, 2, NULL, 0, 'victorypoint'),
(39, 2, NULL, 0, 'victorypoint'),
(40, 2, NULL, 0, 'knight'),
(41, 2, NULL, 0, 'monopoly'),
(42, 2, NULL, 0, 'knight'),
(43, 2, NULL, 0, 'knight'),
(44, 2, NULL, 0, 'knight'),
(45, 2, NULL, 0, 'knight'),
(46, 2, NULL, 0, 'yearofplenty'),
(47, 2, NULL, 0, 'knight'),
(48, 2, NULL, 0, 'knight'),
(49, 2, NULL, 0, 'knight'),
(50, 2, NULL, 0, 'knight');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_changed` tinyint(1) NOT NULL DEFAULT '1',
  `is_finished` tinyint(1) NOT NULL DEFAULT '0',
  `turn_number` int(11) NOT NULL DEFAULT '0',
  `current_player` int(11) NOT NULL DEFAULT '1',
  `active_thief` int(11) NOT NULL,
  `dice1` smallint(6) NOT NULL DEFAULT '0',
  `dice2` smallint(6) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `is_changed`, `is_finished`, `turn_number`, `current_player`, `active_thief`, `dice1`, `dice2`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 5, 2, 0, 5, 3, '2014-03-31 00:36:18', '2014-03-30 22:36:18'),
(2, 1, 0, 8, 2, 1, 3, 4, '2014-03-31 10:30:50', '2014-03-31 08:30:50');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_host` tinyint(1) NOT NULL DEFAULT '0',
  `color` enum('red','blue','green','yellow','orange','violet') COLLATE utf8_bin DEFAULT NULL,
  `turn_order` int(11) NOT NULL DEFAULT '1',
  `wood` int(11) NOT NULL DEFAULT '0',
  `stone` int(11) NOT NULL DEFAULT '0',
  `sheep` int(11) NOT NULL DEFAULT '0',
  `clay` int(11) NOT NULL DEFAULT '0',
  `wheat` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `game_id`, `user_id`, `is_host`, `color`, `turn_order`, `wood`, `stone`, `sheep`, `clay`, `wheat`) VALUES
(1, 1, 4, 1, 'yellow', 1, 4, 0, 0, 0, 4),
(2, 1, 1, 0, 'green', 2, 1, 3, 2, 0, 2),
(3, 2, 3, 1, 'yellow', 1, 0, 3, 0, 0, 1),
(4, 2, 1, 0, 'blue', 2, 0, 0, -4, 2, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=19 ;

--
-- Dumping data for table `ports`
--

INSERT INTO `ports` (`id`, `type`, `board_id`, `x`, `y`, `z`) VALUES
(1, 'default', 1, -10, -15, 25),
(2, 'clay', 1, 0, 25, -25),
(3, 'default', 1, 10, -25, 15),
(4, 'default', 1, 25, -10, -15),
(5, 'sheep', 1, -25, 0, 25),
(6, 'wheat', 1, 15, 10, -25),
(7, 'default', 1, -15, 25, -10),
(8, 'wood', 1, 25, -25, 0),
(9, 'stone', 1, -25, 15, 10),
(10, 'default', 2, -10, -15, 25),
(11, 'clay', 2, 0, 25, -25),
(12, 'default', 2, 10, -25, 15),
(13, 'default', 2, 25, -10, -15),
(14, 'stone', 2, -25, 0, 25),
(15, 'sheep', 2, 15, 10, -25),
(16, 'wood', 2, -15, 25, -10),
(17, 'wheat', 2, 25, -25, 0),
(18, 'default', 2, -25, 15, 10);

-- --------------------------------------------------------

--
-- Table structure for table `roads`
--

CREATE TABLE IF NOT EXISTS `roads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=145 ;

--
-- Dumping data for table `roads`
--

INSERT INTO `roads` (`id`, `board_id`, `player_id`, `x`, `y`, `z`) VALUES
(1, 1, NULL, -20, -5, 25),
(2, 1, NULL, -20, 5, 15),
(3, 1, NULL, -20, 15, 5),
(4, 1, NULL, -20, 25, -5),
(5, 1, NULL, -10, -15, 25),
(6, 1, NULL, -10, -5, 15),
(7, 1, NULL, -10, 5, 5),
(8, 1, 2, -10, 15, -5),
(9, 1, NULL, -10, 25, -15),
(10, 1, NULL, 0, -25, 25),
(11, 1, NULL, 0, -15, 15),
(12, 1, NULL, 0, -5, 5),
(13, 1, NULL, 0, 5, -5),
(14, 1, NULL, 0, 15, -15),
(15, 1, NULL, 0, 25, -25),
(16, 1, NULL, 10, -25, 15),
(17, 1, NULL, 10, -15, 5),
(18, 1, NULL, 10, -5, -5),
(19, 1, NULL, 10, 5, -15),
(20, 1, NULL, 10, 15, -25),
(21, 1, NULL, 20, -25, 5),
(22, 1, NULL, 20, -15, -5),
(23, 1, NULL, 20, -5, -15),
(24, 1, NULL, 20, 5, -25),
(25, 1, NULL, 25, -5, -20),
(26, 1, NULL, 15, 5, -20),
(27, 1, 2, 5, 15, -20),
(28, 1, NULL, -5, 25, -20),
(29, 1, NULL, 25, -15, -10),
(30, 1, NULL, 15, -5, -10),
(31, 1, NULL, 5, 5, -10),
(32, 1, NULL, -5, 15, -10),
(33, 1, NULL, -15, 25, -10),
(34, 1, NULL, 25, -25, 0),
(35, 1, NULL, 15, -15, 0),
(36, 1, NULL, 5, -5, 0),
(37, 1, NULL, -5, 5, 0),
(38, 1, NULL, -15, 15, 0),
(39, 1, NULL, -25, 25, 0),
(40, 1, NULL, 15, -25, 10),
(41, 1, NULL, 5, -15, 10),
(42, 1, NULL, -5, -5, 10),
(43, 1, 1, -15, 5, 10),
(44, 1, NULL, -25, 15, 10),
(45, 1, NULL, 5, -25, 20),
(46, 1, NULL, -5, -15, 20),
(47, 1, NULL, -15, -5, 20),
(48, 1, NULL, -25, 5, 20),
(49, 1, NULL, -5, -20, 25),
(50, 1, NULL, 5, -20, 15),
(51, 1, NULL, 15, -20, 5),
(52, 1, NULL, 25, -20, -5),
(53, 1, NULL, -15, -10, 25),
(54, 1, NULL, -5, -10, 15),
(55, 1, NULL, 5, -10, 5),
(56, 1, NULL, 15, -10, -5),
(57, 1, NULL, 25, -10, -15),
(58, 1, NULL, -25, 0, 25),
(59, 1, 1, -15, 0, 15),
(60, 1, NULL, -5, 0, 5),
(61, 1, NULL, 5, 0, -5),
(62, 1, NULL, 15, 0, -15),
(63, 1, NULL, 25, 0, -25),
(64, 1, NULL, -25, 10, 15),
(65, 1, NULL, -15, 10, 5),
(66, 1, NULL, -5, 10, -5),
(67, 1, NULL, 5, 10, -15),
(68, 1, NULL, 15, 10, -25),
(69, 1, NULL, -25, 20, 5),
(70, 1, NULL, -15, 20, -5),
(71, 1, NULL, -5, 20, -15),
(72, 1, NULL, 5, 20, -25),
(73, 2, NULL, -20, -5, 25),
(74, 2, NULL, -20, 5, 15),
(75, 2, NULL, -20, 15, 5),
(76, 2, NULL, -20, 25, -5),
(77, 2, NULL, -10, -15, 25),
(78, 2, NULL, -10, -5, 15),
(79, 2, NULL, -10, 5, 5),
(80, 2, NULL, -10, 15, -5),
(81, 2, NULL, -10, 25, -15),
(82, 2, NULL, 0, -25, 25),
(83, 2, 3, 0, -15, 15),
(84, 2, NULL, 0, -5, 5),
(85, 2, NULL, 0, 5, -5),
(86, 2, 4, 0, 15, -15),
(87, 2, NULL, 0, 25, -25),
(88, 2, NULL, 10, -25, 15),
(89, 2, NULL, 10, -15, 5),
(90, 2, NULL, 10, -5, -5),
(91, 2, NULL, 10, 5, -15),
(92, 2, NULL, 10, 15, -25),
(93, 2, NULL, 20, -25, 5),
(94, 2, NULL, 20, -15, -5),
(95, 2, NULL, 20, -5, -15),
(96, 2, NULL, 20, 5, -25),
(97, 2, NULL, 25, -5, -20),
(98, 2, 4, 15, 5, -20),
(99, 2, NULL, 5, 15, -20),
(100, 2, NULL, -5, 25, -20),
(101, 2, NULL, 25, -15, -10),
(102, 2, NULL, 15, -5, -10),
(103, 2, 3, 5, 5, -10),
(104, 2, NULL, -5, 15, -10),
(105, 2, NULL, -15, 25, -10),
(106, 2, NULL, 25, -25, 0),
(107, 2, NULL, 15, -15, 0),
(108, 2, NULL, 5, -5, 0),
(109, 2, NULL, -5, 5, 0),
(110, 2, NULL, -15, 15, 0),
(111, 2, NULL, -25, 25, 0),
(112, 2, NULL, 15, -25, 10),
(113, 2, 3, 5, -15, 10),
(114, 2, NULL, -5, -5, 10),
(115, 2, NULL, -15, 5, 10),
(116, 2, NULL, -25, 15, 10),
(117, 2, NULL, 5, -25, 20),
(118, 2, NULL, -5, -15, 20),
(119, 2, NULL, -15, -5, 20),
(120, 2, NULL, -25, 5, 20),
(121, 2, NULL, -5, -20, 25),
(122, 2, NULL, 5, -20, 15),
(123, 2, NULL, 15, -20, 5),
(124, 2, NULL, 25, -20, -5),
(125, 2, NULL, -15, -10, 25),
(126, 2, NULL, -5, -10, 15),
(127, 2, 3, 5, -10, 5),
(128, 2, NULL, 15, -10, -5),
(129, 2, NULL, 25, -10, -15),
(130, 2, NULL, -25, 0, 25),
(131, 2, NULL, -15, 0, 15),
(132, 2, NULL, -5, 0, 5),
(133, 2, NULL, 5, 0, -5),
(134, 2, NULL, 15, 0, -15),
(135, 2, NULL, 25, 0, -25),
(136, 2, NULL, -25, 10, 15),
(137, 2, NULL, -15, 10, 5),
(138, 2, NULL, -5, 10, -5),
(139, 2, NULL, 5, 10, -15),
(140, 2, NULL, 15, 10, -25),
(141, 2, NULL, -25, 20, 5),
(142, 2, NULL, -15, 20, -5),
(143, 2, NULL, -5, 20, -15),
(144, 2, NULL, 5, 20, -25);

-- --------------------------------------------------------

--
-- Table structure for table `settlements`
--

CREATE TABLE IF NOT EXISTS `settlements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_town` tinyint(1) NOT NULL DEFAULT '0',
  `board_id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=109 ;

--
-- Dumping data for table `settlements`
--

INSERT INTO `settlements` (`id`, `is_town`, `board_id`, `player_id`, `deleted_at`, `x`, `y`, `z`) VALUES
(1, 0, 1, NULL, NULL, -25, -5, 25),
(2, 0, 1, NULL, NULL, -25, 5, 15),
(3, 0, 1, NULL, NULL, -25, 5, 25),
(4, 0, 1, NULL, NULL, -25, 15, 5),
(5, 0, 1, NULL, NULL, -25, 15, 15),
(6, 0, 1, NULL, NULL, -25, 25, -5),
(7, 0, 1, NULL, NULL, -25, 25, 5),
(8, 0, 1, NULL, NULL, -15, -15, 25),
(9, 0, 1, 1, NULL, -15, -5, 15),
(10, 0, 1, NULL, '2014-03-30 22:21:10', -15, -5, 25),
(11, 0, 1, 1, NULL, -15, 5, 5),
(12, 0, 1, NULL, '2014-03-30 22:21:10', -15, 5, 15),
(13, 0, 1, 2, NULL, -15, 15, -5),
(14, 0, 1, NULL, '2014-03-30 22:22:01', -15, 15, 5),
(15, 0, 1, NULL, NULL, -15, 25, -15),
(16, 0, 1, NULL, '2014-03-30 22:22:01', -15, 25, -5),
(17, 0, 1, NULL, NULL, -5, -25, 25),
(18, 0, 1, NULL, NULL, -5, -15, 15),
(19, 0, 1, NULL, NULL, -5, -15, 25),
(20, 0, 1, NULL, NULL, -5, -5, 5),
(21, 0, 1, NULL, '2014-03-30 22:21:10', -5, -5, 15),
(22, 0, 1, NULL, NULL, -5, 5, -5),
(23, 0, 1, NULL, '2014-03-30 22:24:46', -5, 5, 5),
(24, 0, 1, NULL, NULL, -5, 15, -15),
(25, 0, 1, NULL, '2014-03-30 22:22:01', -5, 15, -5),
(26, 0, 1, NULL, NULL, -5, 25, -25),
(27, 0, 1, NULL, NULL, -5, 25, -15),
(28, 0, 1, NULL, NULL, 5, -25, 15),
(29, 0, 1, NULL, NULL, 5, -25, 25),
(30, 0, 1, NULL, NULL, 5, -15, 5),
(31, 0, 1, NULL, NULL, 5, -15, 15),
(32, 0, 1, NULL, NULL, 5, -5, -5),
(33, 0, 1, NULL, NULL, 5, -5, 5),
(34, 0, 1, NULL, NULL, 5, 5, -15),
(35, 0, 1, NULL, NULL, 5, 5, -5),
(36, 0, 1, 2, NULL, 5, 15, -25),
(37, 0, 1, NULL, '2014-03-30 22:22:26', 5, 15, -15),
(38, 0, 1, NULL, '2014-03-30 22:22:26', 5, 25, -25),
(39, 0, 1, NULL, NULL, 15, -25, 5),
(40, 0, 1, NULL, NULL, 15, -25, 15),
(41, 0, 1, NULL, NULL, 15, -15, -5),
(42, 0, 1, NULL, NULL, 15, -15, 5),
(43, 0, 1, NULL, NULL, 15, -5, -15),
(44, 0, 1, NULL, NULL, 15, -5, -5),
(45, 0, 1, NULL, NULL, 15, 5, -25),
(46, 0, 1, NULL, NULL, 15, 5, -15),
(47, 0, 1, NULL, '2014-03-30 22:22:26', 15, 15, -25),
(48, 0, 1, NULL, NULL, 25, -25, -5),
(49, 0, 1, NULL, NULL, 25, -25, 5),
(50, 0, 1, NULL, NULL, 25, -15, -15),
(51, 0, 1, NULL, NULL, 25, -15, -5),
(52, 0, 1, NULL, NULL, 25, -5, -25),
(53, 0, 1, NULL, NULL, 25, -5, -15),
(54, 0, 1, NULL, NULL, 25, 5, -25),
(55, 0, 2, NULL, NULL, -25, -5, 25),
(56, 0, 2, NULL, NULL, -25, 5, 15),
(57, 0, 2, NULL, NULL, -25, 5, 25),
(58, 0, 2, NULL, NULL, -25, 15, 5),
(59, 0, 2, NULL, NULL, -25, 15, 15),
(60, 0, 2, NULL, NULL, -25, 25, -5),
(61, 0, 2, NULL, NULL, -25, 25, 5),
(62, 0, 2, NULL, NULL, -15, -15, 25),
(63, 0, 2, NULL, NULL, -15, -5, 15),
(64, 0, 2, NULL, NULL, -15, -5, 25),
(65, 0, 2, NULL, NULL, -15, 5, 5),
(66, 0, 2, NULL, NULL, -15, 5, 15),
(67, 0, 2, NULL, NULL, -15, 15, -5),
(68, 0, 2, NULL, NULL, -15, 15, 5),
(69, 0, 2, NULL, NULL, -15, 25, -15),
(70, 0, 2, NULL, NULL, -15, 25, -5),
(71, 0, 2, NULL, NULL, -5, -25, 25),
(72, 0, 2, 3, NULL, -5, -15, 15),
(73, 0, 2, NULL, '2014-03-31 08:24:19', -5, -15, 25),
(74, 0, 2, NULL, NULL, -5, -5, 5),
(75, 0, 2, NULL, '2014-03-31 08:24:19', -5, -5, 15),
(76, 0, 2, NULL, NULL, -5, 5, -5),
(77, 0, 2, NULL, NULL, -5, 5, 5),
(78, 0, 2, 4, NULL, -5, 15, -15),
(79, 0, 2, NULL, '2014-03-31 08:25:26', -5, 15, -5),
(80, 0, 2, NULL, NULL, -5, 25, -25),
(81, 0, 2, NULL, '2014-03-31 08:25:26', -5, 25, -15),
(82, 0, 2, NULL, NULL, 5, -25, 15),
(83, 0, 2, NULL, NULL, 5, -25, 25),
(84, 0, 2, 3, NULL, 5, -15, 5),
(85, 0, 2, NULL, '2014-03-31 08:24:19', 5, -15, 15),
(86, 0, 2, NULL, NULL, 5, -5, -5),
(87, 0, 2, NULL, '2014-03-31 08:30:46', 5, -5, 5),
(88, 0, 2, 3, NULL, 5, 5, -15),
(89, 0, 2, NULL, '2014-03-31 08:26:00', 5, 5, -5),
(90, 0, 2, NULL, NULL, 5, 15, -25),
(91, 0, 2, NULL, '2014-03-31 08:25:26', 5, 15, -15),
(92, 0, 2, NULL, NULL, 5, 25, -25),
(93, 0, 2, NULL, NULL, 15, -25, 5),
(94, 0, 2, NULL, NULL, 15, -25, 15),
(95, 0, 2, NULL, NULL, 15, -15, -5),
(96, 0, 2, NULL, '2014-03-31 08:30:46', 15, -15, 5),
(97, 0, 2, NULL, NULL, 15, -5, -15),
(98, 0, 2, NULL, NULL, 15, -5, -5),
(99, 0, 2, 4, NULL, 15, 5, -25),
(100, 0, 2, NULL, '2014-03-31 08:25:35', 15, 5, -15),
(101, 0, 2, NULL, '2014-03-31 08:25:34', 15, 15, -25),
(102, 0, 2, NULL, NULL, 25, -25, -5),
(103, 0, 2, NULL, NULL, 25, -25, 5),
(104, 0, 2, NULL, NULL, 25, -15, -15),
(105, 0, 2, NULL, NULL, 25, -15, -5),
(106, 0, 2, NULL, NULL, 25, -5, -25),
(107, 0, 2, NULL, NULL, 25, -5, -15),
(108, 0, 2, NULL, '2014-03-31 08:25:34', 25, 5, -25);

-- --------------------------------------------------------

--
-- Table structure for table `tiles`
--

CREATE TABLE IF NOT EXISTS `tiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `board_id` int(11) NOT NULL,
  `type` enum('desert','stone','wood','clay','sheep','wheat','ocean') COLLATE utf8_bin NOT NULL DEFAULT 'ocean',
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  `probability` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=75 ;

--
-- Dumping data for table `tiles`
--

INSERT INTO `tiles` (`id`, `board_id`, `type`, `x`, `y`, `z`, `probability`) VALUES
(1, 1, 'ocean', -30, 0, 30, NULL),
(2, 1, 'ocean', -30, 10, 20, NULL),
(3, 1, 'ocean', -30, 20, 10, NULL),
(4, 1, 'ocean', -30, 30, 0, NULL),
(5, 1, 'ocean', -20, -10, 30, NULL),
(6, 1, 'clay', -20, 0, 20, 6),
(7, 1, 'stone', -20, 10, 10, 4),
(8, 1, 'wood', -20, 20, 0, 6),
(9, 1, 'ocean', -20, 30, -10, NULL),
(10, 1, 'ocean', -10, -20, 30, NULL),
(11, 1, 'wood', -10, -10, 20, 8),
(12, 1, 'wheat', -10, 0, 10, 5),
(13, 1, 'wood', -10, 10, 0, 3),
(14, 1, 'sheep', -10, 20, -10, 5),
(15, 1, 'ocean', -10, 30, -20, NULL),
(16, 1, 'ocean', 0, -30, 30, NULL),
(17, 1, 'desert', 0, -20, 20, NULL),
(18, 1, 'clay', 0, -10, 10, 3),
(19, 1, 'sheep', 0, 0, 0, 4),
(20, 1, 'stone', 0, 10, -10, 11),
(21, 1, 'wheat', 0, 20, -20, 9),
(22, 1, 'ocean', 0, 30, -30, NULL),
(23, 1, 'ocean', 10, -30, 20, NULL),
(24, 1, 'clay', 10, -20, 10, 10),
(25, 1, 'wheat', 10, -10, 0, 9),
(26, 1, 'sheep', 10, 0, -10, 2),
(27, 1, 'stone', 10, 10, -20, 8),
(28, 1, 'ocean', 10, 20, -30, NULL),
(29, 1, 'ocean', 20, -30, 10, NULL),
(30, 1, 'sheep', 20, -20, 0, 10),
(31, 1, 'wheat', 20, -10, -10, 12),
(32, 1, 'wood', 20, 0, -20, 11),
(33, 1, 'ocean', 20, 10, -30, NULL),
(34, 1, 'ocean', 30, -30, 0, NULL),
(35, 1, 'ocean', 30, -20, -10, NULL),
(36, 1, 'ocean', 30, -10, -20, NULL),
(37, 1, 'ocean', 30, 0, -30, NULL),
(38, 2, 'ocean', -30, 0, 30, NULL),
(39, 2, 'ocean', -30, 10, 20, NULL),
(40, 2, 'ocean', -30, 20, 10, NULL),
(41, 2, 'ocean', -30, 30, 0, NULL),
(42, 2, 'ocean', -20, -10, 30, NULL),
(43, 2, 'wood', -20, 0, 20, 11),
(44, 2, 'wood', -20, 10, 10, 4),
(45, 2, 'wheat', -20, 20, 0, 3),
(46, 2, 'ocean', -20, 30, -10, NULL),
(47, 2, 'ocean', -10, -20, 30, NULL),
(48, 2, 'wheat', -10, -10, 20, 6),
(49, 2, 'clay', -10, 0, 10, 12),
(50, 2, 'desert', -10, 10, 0, NULL),
(51, 2, 'wood', -10, 20, -10, 5),
(52, 2, 'ocean', -10, 30, -20, NULL),
(53, 2, 'ocean', 0, -30, 30, NULL),
(54, 2, 'wood', 0, -20, 20, 9),
(55, 2, 'clay', 0, -10, 10, 8),
(56, 2, 'wheat', 0, 0, 0, 2),
(57, 2, 'stone', 0, 10, -10, 8),
(58, 2, 'sheep', 0, 20, -20, 9),
(59, 2, 'ocean', 0, 30, -30, NULL),
(60, 2, 'ocean', 10, -30, 20, NULL),
(61, 2, 'wheat', 10, -20, 10, 10),
(62, 2, 'stone', 10, -10, 0, 4),
(63, 2, 'clay', 10, 0, -10, 3),
(64, 2, 'sheep', 10, 10, -20, 5),
(65, 2, 'ocean', 10, 20, -30, NULL),
(66, 2, 'ocean', 20, -30, 10, NULL),
(67, 2, 'sheep', 20, -20, 0, 6),
(68, 2, 'stone', 20, -10, -10, 10),
(69, 2, 'sheep', 20, 0, -20, 11),
(70, 2, 'ocean', 20, 10, -30, NULL),
(71, 2, 'ocean', 30, -30, 0, NULL),
(72, 2, 'ocean', 30, -20, -10, NULL),
(73, 2, 'ocean', 30, -10, -20, NULL),
(74, 2, 'ocean', 30, 0, -30, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE IF NOT EXISTS `trades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `host_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `wood` smallint(6) NOT NULL,
  `sheep` smallint(6) NOT NULL,
  `stone` smallint(6) NOT NULL,
  `clay` smallint(6) NOT NULL,
  `wheat` smallint(6) NOT NULL,
  `updated` tinyint(1) NOT NULL,
  `accepted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

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
  `image` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nickname`, `email`, `password`, `games_played`, `games_won`, `games_completed`, `image`, `created_at`, `updated_at`) VALUES
(1, 'Fellglen', 'k.j.kowalewski@gmail.com', '$2y$10$g58nvoxgxOEPrE1yM5.AAOo3ipXoYQvAGSdSZhCpy1ar3LXobNKAy', 0, 0, 0, 'konrad.jpg', '2014-03-18 10:26:48', '0000-00-00 00:00:00'),
(2, 'Sony', 'zasoniak@hotmail.com', '$2y$10$BqKlSy.9mrltQCxkjvCPN.VofLM28g9xiZE0Bs2MV94qjCdmRZxva', 0, 0, 0, 'sony.jpg', '2014-03-30 22:35:44', '0000-00-00 00:00:00'),
(3, 'mroova', 'michal@kowalik.net', '$2y$10$og2d4CD82z9BeFeUQBsJsOmPVJO0pr8RI0kcmVa5qKVyaJ/Kn9KOm', 0, 0, 0, 'mroova.jpg', '2014-03-18 10:27:05', '0000-00-00 00:00:00'),
(4, 'Riffglen', 'r.r.kowalewski@gmail.com', '$2y$10$4smlXIBWTRYL20FCTnVu9eheP9nZcFYQMnWEht4Q2T2WO8EKbSK/6', 0, 0, 0, 'mlody.jpg', '2014-03-18 10:29:57', '2014-03-12 21:04:14');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
