<?php

class m151023_230440_create_alcohol_table extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute("

		/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
		/*!40101 SET NAMES utf8mb4 */;
		/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
		/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

		-- Дамп структуры для таблица dev_dont_stop.Alcohol
		CREATE TABLE IF NOT EXISTS `Alcohol` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
		  `event_id` int(10) unsigned DEFAULT NULL COMMENT 'Event ID',
		  `men` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Men count',
		  `women` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Women count',
		  `children` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Children count',
		  `not_drinking_men` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Not drinking men count',
		  `not_drinking_women` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Not drinking women count',
		  `event_duration` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Event duration in hours',
		  `alcohol_consumption` int(10) unsigned DEFAULT NULL COMMENT 'Alcohol consumption',
		  `season` int(10) unsigned DEFAULT NULL COMMENT 'Пора года',
		  PRIMARY KEY (`id`),
		  KEY `FK_Alcohol_Events` (`event_id`),
		  CONSTRAINT `FK_Alcohol_Events` FOREIGN KEY (`event_id`) REFERENCES `Events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		-- Экспортируемые данные не выделены.
		/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
		/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
		/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

		");
	}

	public function safeDown()
	{
	}

}