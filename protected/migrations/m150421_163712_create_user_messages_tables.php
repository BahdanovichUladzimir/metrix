<?php

class m150421_163712_create_user_messages_tables extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            DROP TABLE IF EXISTS `UsersMessages`;
            DROP TABLE IF EXISTS `UsersMessagesRecievers`;
            DROP TABLE IF EXISTS `UsersMessagesStatuses`;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
        ");
        $this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


            -- Дамп структуры для таблица dev_dont_stop.Dialogues
            CREATE TABLE IF NOT EXISTS `Dialogues` (
              `id` int(50) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `sender_id` int(10) DEFAULT NULL COMMENT 'Sender ID',
              `receiver_id` int(10) DEFAULT NULL COMMENT 'Receiver ID',
              `created_at` int(12) NOT NULL DEFAULT '0' COMMENT 'Created at',
              `sender_new_messages` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Sender new messages',
              `receiver_new_messages` int(5) unsigned NOT NULL DEFAULT '0' COMMENT 'Receiver new messages',
              `sender_messages` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Sender messages',
              `receiver_messages` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Receiver messages',
              PRIMARY KEY (`id`),
              KEY `FK_Dialogues_Users` (`sender_id`),
              KEY `FK_Dialogues_Users_2` (`receiver_id`),
              CONSTRAINT `FK_Dialogues_Users` FOREIGN KEY (`sender_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
              CONSTRAINT `FK_Dialogues_Users_2` FOREIGN KEY (`receiver_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Экспортируемые данные не выделены.


            -- Дамп структуры для таблица dev_dont_stop.UserMessages
            CREATE TABLE IF NOT EXISTS `UserMessages` (
              `id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `body` text NOT NULL COMMENT 'Body',
              `is_read` enum('0','1') NOT NULL DEFAULT '0' COMMENT 'Is read',
              `deleted_by` enum('sender','receiver') DEFAULT NULL COMMENT 'Deleted by',
              `created_at` int(12) unsigned DEFAULT '0' COMMENT 'Created at',
              `dialog_id` int(50) unsigned DEFAULT NULL COMMENT 'Dialog ID',
              `sender_id` int(11) DEFAULT NULL COMMENT 'Sender ID',
              PRIMARY KEY (`id`),
              KEY `FK_UserMessages_Dialogues` (`dialog_id`),
              KEY `FK_UserMessages_Users` (`sender_id`),
              CONSTRAINT `FK_UserMessages_Dialogues` FOREIGN KEY (`dialog_id`) REFERENCES `Dialogues` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `FK_UserMessages_Users` FOREIGN KEY (`sender_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
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
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            DROP TABLE IF EXISTS `UserMessages`;
            DROP TABLE IF EXISTS `Dialogues`;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
        ");
	}

}