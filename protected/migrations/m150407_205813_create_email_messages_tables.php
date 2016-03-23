<?php

class m150407_205813_create_email_messages_tables extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

            -- Дамп структуры для таблица dev_dont_stop.EmailMessages
            CREATE TABLE IF NOT EXISTS `EmailMessages` (
              `id` int(50) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `from` varchar(50) DEFAULT NULL COMMENT 'From email',
              `to` varchar(50) DEFAULT NULL COMMENT 'To email',
              `subject` varchar(50) NOT NULL DEFAULT '' COMMENT 'Subject',
              `message` text NOT NULL COMMENT 'Message',
              `created_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Created date',
              `sent_date` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sent date',
              `recipient_id` int(10) DEFAULT NULL COMMENT 'Recipient user ID',
              `is_sent` int(1) unsigned DEFAULT '0' COMMENT 'Is sent',
              `type_id` int(3) unsigned DEFAULT NULL COMMENT 'Type ID',
              PRIMARY KEY (`id`),
              KEY `FK_EmailMessages_EmailMessagesTypes` (`type_id`),
              KEY `FK_EmailMessages_Users` (`recipient_id`),
              CONSTRAINT `FK_EmailMessages_Users` FOREIGN KEY (`recipient_id`) REFERENCES `Users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              CONSTRAINT `FK_EmailMessages_EmailMessagesTypes` FOREIGN KEY (`type_id`) REFERENCES `EmailMessagesTypes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Экспортируемые данные не выделены.


            -- Дамп структуры для таблица dev_dont_stop.EmailMessagesTypes
            CREATE TABLE IF NOT EXISTS `EmailMessagesTypes` (
              `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `name` varchar(50) DEFAULT NULL COMMENT 'Name',
              `label` varchar(255) DEFAULT '' COMMENT 'Label',
              PRIMARY KEY (`id`),
              UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Экспортируемые данные не выделены.
            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

            DROP TABLE IF EXISTS `EmailMessages`;
            DROP TABLE IF EXISTS `EmailMessagesTypes`;

            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

        ");
	}

}