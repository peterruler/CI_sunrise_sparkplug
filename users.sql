-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

DROP TABLE 'users';
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `forgot_password` int(11) DEFAULT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `activation_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_on` DATETIME DEFAULT '0000-00-00 00:00:00',
  `last_login` DATETIME DEFAULT '0000-00-00 00:00:00',
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `company` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=77 ;

--
-- Daten für Tabelle `users`
--

INSERT INTO `users` (
`id`,
 `ip_address`,
  `password`,
  `forgot_password`,
  `email`,
  `activation_code`,
   `remember_code`,
   `created_on`,
   `last_login`,
   `active`,
   `first_name`,
   `last_name`,
   `company`,
   `phone`
   )
   VALUES
   (
   NULL,
   '127.0.0.1',
   SHA1('1234'),
   NULL,
   'admin@gmail.com',
   NULL,
   NULL,
   'CURRENT_TIMESTAMP',
   'CURRENT_TIMESTAMP',
   '1',
   'peter',
   'ruler',
   'none',
   '078 123 45 67'
   );