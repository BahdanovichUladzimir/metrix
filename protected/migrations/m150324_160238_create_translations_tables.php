<?php

class m150324_160238_create_translations_tables extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
        /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        /*!40101 SET NAMES utf8mb4 */;
        /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
        /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

        -- Дамп структуры базы данных dev_dont_stop
        CREATE DATABASE IF NOT EXISTS `dev_dont_stop` /*!40100 DEFAULT CHARACTER SET utf8 */;
        USE `dev_dont_stop`;


        -- Дамп структуры для таблица dev_dont_stop.Message
        CREATE TABLE IF NOT EXISTS `Message` (
          `id` int(11) NOT NULL DEFAULT '0',
          `language` varchar(16) NOT NULL DEFAULT '',
          `translation` text,
          PRIMARY KEY (`id`,`language`),
          CONSTRAINT `FK_Message_SourceMessage` FOREIGN KEY (`id`) REFERENCES `SourceMessage` (`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        -- Экспортируемые данные не выделены.


        -- Дамп структуры для таблица SourceMessage
        CREATE TABLE IF NOT EXISTS `SourceMessage` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `category` varchar(32) DEFAULT NULL,
          `message` text,
          PRIMARY KEY (`id`)
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