-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 04 Mar 2014, 12:13
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `catan`
--
CREATE DATABASE IF NOT EXISTS `catan` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `catan`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `boards`
--

CREATE TABLE IF NOT EXISTS `boards` (
  `id` int(11) NOT NULL,
  `thief` int(11) NOT NULL,
  `finished` tinyint(1) NOT NULL DEFAULT '0',
  `is_changed` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `type` enum('knight','victorypoint','monopoly','yearofplenty','roadbuilding') CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `fields`
--

CREATE TABLE IF NOT EXISTS `fields` (
  `id` int(11) NOT NULL,
  `type` enum('dessert','stone','wood','clay','sheep','wheat') COLLATE utf8_bin NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `z` int(11) NOT NULL,
  `probability` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `players`
--

CREATE TABLE IF NOT EXISTS `players` (
  `id` int(11) NOT NULL,
  `board_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `wood` int(11) NOT NULL DEFAULT '0',
  `stone` int(11) NOT NULL DEFAULT '0',
  `sheep` int(11) NOT NULL DEFAULT '0',
  `clay` int(11) NOT NULL DEFAULT '0',
  `wheat` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `ports`
--

CREATE TABLE IF NOT EXISTS `ports` (
  `id` int(11) NOT NULL,
  `type` enum('default','wood','stone','sheep','clay','wheat') COLLATE utf8_bin NOT NULL,
  `field1_id` int(11) NOT NULL,
  `field2_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roads`
--

CREATE TABLE IF NOT EXISTS `roads` (
  `id` int(11) NOT NULL,
  `player_id` int(11) NOT NULL,
  `field1_id` int(11) NOT NULL,
  `field2_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `settlements`
--

CREATE TABLE IF NOT EXISTS `settlements` (
  `id` int(11) NOT NULL,
  `is_town` tinyint(1) NOT NULL DEFAULT '0',
  `player_id` int(11) NOT NULL,
  `field1_id` int(11) NOT NULL,
  `field2_id` int(11) NOT NULL,
  `field3_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `nickname` varchar(250) COLLATE utf8_bin NOT NULL,
  `email` varchar(250) COLLATE utf8_bin NOT NULL,
  `password` varchar(64) COLLATE utf8_bin NOT NULL,
  `games_played` int(11) NOT NULL DEFAULT '0',
  `games_won` int(11) NOT NULL DEFAULT '0',
  `games_completed` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
