	CREATE TABLE IF NOT EXISTS `rex_maru_cache`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `option` varchar(255) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;