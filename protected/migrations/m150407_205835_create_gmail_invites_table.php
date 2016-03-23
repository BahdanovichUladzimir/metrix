<?php

class m150407_205835_create_gmail_invites_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

            -- Дамп структуры для таблица GmailInvites
            CREATE TABLE IF NOT EXISTS `GmailInvites` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `user_id` int(11) DEFAULT NULL COMMENT 'User ID',
              `invite_email` varchar(255) DEFAULT NULL COMMENT 'Invite email',
              PRIMARY KEY (`id`),
              KEY `FK_GmailInvites_Users` (`user_id`),
              CONSTRAINT `FK_GmailInvites_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Экспортируемые данные не выделены.
            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

	public function down()
	{
		$this->execute("
		    DROP TABLE IF EXISTS `GmailInvites`;
		");
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}