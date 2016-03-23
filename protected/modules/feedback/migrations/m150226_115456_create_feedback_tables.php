<?php

class m150226_115456_create_feedback_tables extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


            -- Дамп структуры для таблицы FeedbackQuestionsStatuses
            CREATE TABLE IF NOT EXISTS `FeedbackQuestionsStatuses` (
              `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Status ID',
              `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Status name',
              `label` varchar(50) NOT NULL DEFAULT '' COMMENT 'Status label',
              PRIMARY KEY (`id`),
              UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

            -- Дамп данных таблицы FeedbackQuestionsStatuses: ~2 rows (приблизительно)
            /*!40000 ALTER TABLE `FeedbackQuestionsStatuses` DISABLE KEYS */;
            INSERT INTO `FeedbackQuestionsStatuses` (`id`, `name`, `label`) VALUES
                (1, 'published', 'Published'),
                (2, 'not_published', 'Not published');
            /*!40000 ALTER TABLE `FeedbackQuestionsStatuses` ENABLE KEYS */;


            -- Дамп структуры для таблицы FeedbackStatuses
            CREATE TABLE IF NOT EXISTS `FeedbackStatuses` (
              `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Status ID',
              `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Status name',
              `label` varchar(50) NOT NULL DEFAULT '' COMMENT 'Status label',
              PRIMARY KEY (`id`),
              UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

            -- Дамп данных таблицы FeedbackStatuses: ~3 rows (приблизительно)
            /*!40000 ALTER TABLE `FeedbackStatuses` DISABLE KEYS */;
            INSERT INTO `FeedbackStatuses` (`id`, `name`, `label`) VALUES
                (1, 'replied', 'Replied'),
                (2, 'not_replied', 'Not replied');
            /*!40000 ALTER TABLE `FeedbackStatuses` ENABLE KEYS */;


            -- Дамп структуры для таблицы FeedbackCategoriesStatuses
            CREATE TABLE IF NOT EXISTS `FeedbackCategoriesStatuses` (
              `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Status ID',
              `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Status name',
              `label` varchar(50) NOT NULL DEFAULT '' COMMENT 'Status label',
              PRIMARY KEY (`id`),
              UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

            -- Дамп данных таблицы FeedbackCategoriesStatuses: ~2 rows (приблизительно)
            /*!40000 ALTER TABLE `FeedbackCategoriesStatuses` DISABLE KEYS */;
            INSERT INTO `FeedbackCategoriesStatuses` (`id`, `name`, `label`) VALUES
                (1, 'published', 'Published'),
                (3, 'not_published', 'Not Published');
            /*!40000 ALTER TABLE `FeedbackCategoriesStatuses` ENABLE KEYS */;


            -- Дамп структуры для таблицы FeedbackCategories
            CREATE TABLE IF NOT EXISTS `FeedbackCategories` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Category ID',
              `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Parent category ID',
              `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name',
              `description` text NOT NULL COMMENT 'Description',
              `status_id` int(3) unsigned DEFAULT NULL COMMENT 'Status ID',
              PRIMARY KEY (`id`),
              KEY `FK_FeedbackCategories_FeedbackCategoriesStatuses` (`status_id`),
              CONSTRAINT `FK_FeedbackCategories_FeedbackCategoriesStatuses` FOREIGN KEY (`status_id`) REFERENCES `FeedbackCategoriesStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


            -- Дамп структуры для таблицы Feedback
            CREATE TABLE IF NOT EXISTS `Feedback` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Message ID',
              `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Message title',
              `user_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'User email',
              `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'User name',
              `user_id` int(11) DEFAULT NULL COMMENT 'User ID',
              `status_id` int(11) unsigned DEFAULT NULL COMMENT 'Status ID',
              `recipient_id` int(11) DEFAULT NULL COMMENT 'Recipient user ID',
              `category_id` int(11) DEFAULT NULL COMMENT 'Category ID',
              `message` text NOT NULL COMMENT 'Message text',
              `reply` text NOT NULL COMMENT 'Reply text',
              `created_date` int(12) unsigned NOT NULL DEFAULT '0' COMMENT 'Created date',
              `reply_date` int(12) unsigned NOT NULL DEFAULT '0' COMMENT 'Reply date',
              PRIMARY KEY (`id`),
              KEY `FK_Feedback_FeedbackStatuses` (`status_id`),
              KEY `FK_Feedback_Users` (`user_id`),
              KEY `FK_Feedback_Users_2` (`recipient_id`),
              CONSTRAINT `FK_Feedback_FeedbackStatuses` FOREIGN KEY (`status_id`) REFERENCES `FeedbackStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              CONSTRAINT `FK_Feedback_FeedbackCategories` FOREIGN KEY (`category_id`) REFERENCES `FeedbackCategories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              CONSTRAINT `FK_Feedback_Users_2` FOREIGN KEY (`recipient_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;


            -- Дамп структуры для таблицы FeedbackQuestions
            CREATE TABLE IF NOT EXISTS `FeedbackQuestions` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Question ID',
              `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Question title',
              `status_id` int(11) unsigned DEFAULT NULL COMMENT 'Status ID',
              `question` text NOT NULL COMMENT 'Question text',
              `reply` text NOT NULL COMMENT 'Reply text',
              `created_date` int(12) unsigned NOT NULL DEFAULT '0' COMMENT 'Created date',
              `category_id` int(11) unsigned DEFAULT NULL COMMENT 'Category ID',
              PRIMARY KEY (`id`),
              KEY `FK_Feedback_FeedbackStatuses` (`status_id`),
              KEY `FK_FeedbackQuestions_FeedbackCategories` (`category_id`),
              CONSTRAINT `FK_FeedbackQuestions_FeedbackCategories` FOREIGN KEY (`category_id`) REFERENCES `FeedbackCategories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              CONSTRAINT `FK_FeedbackQuestions_FeedbackQuestionsStatuses` FOREIGN KEY (`status_id`) REFERENCES `FeedbackQuestionsStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

            -- Дамп данных таблицы FeedbackQuestions: ~0 rows (приблизительно)
            /*!40000 ALTER TABLE `FeedbackQuestions` DISABLE KEYS */;
            /*!40000 ALTER TABLE `FeedbackQuestions` ENABLE KEYS */;

            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            SET foreign_key_checks = 0;
            DROP TABLE `FeedbackCategories`;
            DROP TABLE `Feedback`;
            DROP TABLE `FeedbackQuestions`;
            DROP TABLE `FeedbackQuestionsStatuses`;
            DROP TABLE `FeedbackCategoriesStatuses`;
            DROP TABLE `FeedbackStatuses`;
            SET foreign_key_checks = 1;
        ");
	}

}