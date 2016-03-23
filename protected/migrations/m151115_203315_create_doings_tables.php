<?php

class m151115_203315_create_doings_tables extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

            -- Дамп структуры для таблица dev_dont_stop.Doings
            CREATE TABLE IF NOT EXISTS `Doings` (
              `id` int(50) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `category_id` int(10) unsigned DEFAULT NULL COMMENT 'Category ID',
              `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name',
              `description` text NOT NULL COMMENT 'Description',
              PRIMARY KEY (`id`),
              KEY `FK_Doings_EventsDoingsCategories` (`category_id`),
              CONSTRAINT `FK_Doings_EventsDoingsCategories` FOREIGN KEY (`category_id`) REFERENCES `EventsDoingsCategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Экспортируемые данные не выделены.


            -- Дамп структуры для таблица dev_dont_stop.EventsDoings
            CREATE TABLE IF NOT EXISTS `EventsDoings` (
              `id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `name` varchar(255) DEFAULT NULL COMMENT 'Name',
              `category_id` int(10) unsigned DEFAULT NULL COMMENT 'Category',
              `event_id` int(10) unsigned DEFAULT NULL COMMENT 'Event ID',
              `comment` text COMMENT 'Comment',
              `price` float DEFAULT '0' COMMENT 'Price',
              `status` int(2) unsigned DEFAULT '1' COMMENT 'Status',
              PRIMARY KEY (`id`),
              KEY `FK_EventsDoings_Events` (`event_id`),
              KEY `FK_EventsDoings_EventsDoingsCategories` (`category_id`),
              CONSTRAINT `FK_EventsDoings_Events` FOREIGN KEY (`event_id`) REFERENCES `Events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `FK_EventsDoings_EventsDoingsCategories` FOREIGN KEY (`category_id`) REFERENCES `EventsDoingsCategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Экспортируемые данные не выделены.


            -- Дамп структуры для таблица dev_dont_stop.EventsDoingsCategories
            CREATE TABLE IF NOT EXISTS `EventsDoingsCategories` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name',
              `description` text NOT NULL COMMENT 'Description',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Экспортируемые данные не выделены.


            -- Дамп структуры для таблица dev_dont_stop.EventsTypesDoings
            CREATE TABLE IF NOT EXISTS `EventsTypesDoings` (
              `id` int(100) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `type_id` int(10) unsigned DEFAULT NULL COMMENT 'Event type ID',
              `doing_id` int(50) unsigned DEFAULT NULL COMMENT 'Doing ID',
              PRIMARY KEY (`id`),
              KEY `FK_EventsTypesDoings_EventsTypes` (`type_id`),
              KEY `FK_EventsTypesDoings_Doings` (`doing_id`),
              CONSTRAINT `FK_EventsTypesDoings_Doings` FOREIGN KEY (`doing_id`) REFERENCES `Doings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `FK_EventsTypesDoings_EventsTypes` FOREIGN KEY (`type_id`) REFERENCES `EventsTypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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