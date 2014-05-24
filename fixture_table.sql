-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Erstellungszeit: 24. Mai 2014 um 13:48
-- Server Version: 5.5.34
-- PHP-Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Datenbank: `proj01_02`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `fixture_table`
--

CREATE TABLE `fixture_table` (
  `my_id` int(11) NOT NULL AUTO_INCREMENT,
  `foo` int(11) NOT NULL,
  `bar` varchar(75) NOT NULL,
  `notes` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `date01` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `time01` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tel` varchar(75) NOT NULL,
  `notes01` text NOT NULL,
  `notes02` blob NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `decimalnr` decimal(65,2) NOT NULL,
  `select_list` enum('small','medium','large') NOT NULL DEFAULT 'small',
  `changed` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `filepath1` varchar(500) DEFAULT NULL,
  `filepath2` varchar(255) NOT NULL,
  PRIMARY KEY (`my_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Daten für Tabelle `fixture_table`
--

INSERT INTO `fixture_table` (`my_id`, `foo`, `bar`, `notes`, `is_active`, `date01`, `time01`, `tel`, `notes01`, `notes02`, `email`, `password`, `decimalnr`, `select_list`, `changed`, `filepath1`, `filepath2`) VALUES
(1, 2147483647, 'foobarbazbar', '<p>foobar</p>', 0, '2014-05-09 00:00:00', '0000-00-00 00:00:00', '+41 079 754 32 59', '<p>batbar baz</p>', 0x3c703e636a666575726a6668673c2f703e, '7starch@gmail.com', '8843d7f92416211de9ebb963ff4ce28125932878', 15.75, 'small', '2014-05-20 06:20:31', NULL, ''),
(2, 456745677, 'foobarbazbat', '<p>foobarbazbat787878</p>', 1, '2014-05-14 00:00:00', '0000-00-00 02:02:00', '+417537859', '<p>foobarbazbat</p>', '', 'donjuan@marco.de', '8843d7f92416211de9ebb963ff4ce28125932878', 16.64, 'medium', '2014-05-24 11:45:08', 'uploads/IMG_0001.JPG', 'uploads/IMG_0003.JPG'),
(3, 25678658, 'xdfsxhgsrsdhg', '<p>sdfgdsfgsdgg</p>', 1, '2013-03-03 00:00:00', '0000-00-00 03:03:00', '+410779872437', '<p>dfhgdfhghfdhdh</p>', '', '7starch@gamail.com', '8843d7f92416211de9ebb963ff4ce28125932878', 0.08, 'large', '2014-05-24 11:47:06', 'uploads/avatar_admin.png', 'uploads/Batman.jpg'),
(4, 2147483647, 'dfghdfghdfgh', '<p>cfdhgdghdh</p>', 0, '2444-12-14 00:00:00', '0000-00-00 04:04:00', '+413754859', '<p>xdsfgdsgfsgf</p>', 0x3c703e7864736667647367667367663c2f703e, '7starch@gmail.com', '8843d7f92416211de9ebb963ff4ce28125932878', 1.50, 'small', '2014-05-20 08:16:09', '', '');
