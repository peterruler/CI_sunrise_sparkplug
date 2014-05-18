-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Erstellungszeit: 18. Mai 2014 um 10:14
-- Server Version: 5.5.34
-- PHP-Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `proj01_02`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fixture_table`
--

DROP TABLE IF EXISTS `fixture_table`;
CREATE TABLE IF NOT EXISTS `fixture_table` (
  `my_id` int(11) NOT NULL AUTO_INCREMENT,
  `foo` int(11) NOT NULL,
  `bar` varchar(75) NOT NULL,
  `notes` text NOT NULL,
  `date01` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time01` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tel` varchar(75) NOT NULL,
  `notes01` text NOT NULL,
  `notes02` blob NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `decimalnr` decimal(65,2) NOT NULL,
  `select_list` enum('small','medium','large') NOT NULL DEFAULT 'small',
  `changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`my_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Daten für Tabelle `fixture_table`
--

INSERT INTO `fixture_table` (`my_id`, `foo`, `bar`, `notes`, `date01`, `time01`, `tel`, `notes01`, `notes02`, `is_active`, `email`, `password`, `decimalnr`, `select_list`, `changed`) VALUES
('', 4, 'foobarbazbar', 'foobar', '2014-05-09 00:00:00', '2014-05-16 08:36:15', '+41 079 754 32 59', 'batbar baz', '', 0, '7starch@gmail.com', '8843d7f92416211de9ebb963ff4ce28125932878', 15.75, 'large', '2014-05-18 08:15:47'),
('', 5, 'foobarbazbat', 'foobartestbazbat1976', '2014-05-14 00:00:00', '2014-05-23 11:24:47', '+417537859', 'foobarbazbat', '', 1, 'donjuan@marco.de', '8843d7f92416211de9ebb963ff4ce28125932878', 16.64, 'medium', '2014-05-18 08:16:01');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
