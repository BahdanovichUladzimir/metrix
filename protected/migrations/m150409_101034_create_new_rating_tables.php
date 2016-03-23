<?php

class m150409_101034_create_new_rating_tables extends CDbMigration
{
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

            -- Дамп структуры для таблица dev_dont_stop.DealsCategoriesRatings
            CREATE TABLE IF NOT EXISTS `DealsCategoriesRatings` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `category_id` int(10) unsigned DEFAULT NULL COMMENT 'Category ID',
              `rating_id` int(10) unsigned DEFAULT NULL COMMENT 'Rating ID',
              PRIMARY KEY (`id`),
              KEY `FK_DealsCategoriesRatings_DealsCategories` (`category_id`),
              KEY `FK_DealsCategoriesRatings_Ratings` (`rating_id`),
              CONSTRAINT `FK_DealsCategoriesRatings_DealsCategories` FOREIGN KEY (`category_id`) REFERENCES `DealsCategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `FK_DealsCategoriesRatings_Ratings` FOREIGN KEY (`rating_id`) REFERENCES `Ratings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Экспортируемые данные не выделены.


            -- Дамп структуры для таблица dev_dont_stop.Ratings
            CREATE TABLE IF NOT EXISTS `Ratings` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `name` varchar(50) DEFAULT NULL COMMENT 'Name',
              `label` varchar(50) DEFAULT '' COMMENT 'Label',
              `description` text COMMENT 'Description',
              PRIMARY KEY (`id`),
              UNIQUE KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Экспортируемые данные не выделены.


            -- Дамп структуры для таблица dev_dont_stop.UsersRatingsValues
            CREATE TABLE IF NOT EXISTS `UsersRatingsValues` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `user_id` int(10) DEFAULT NULL COMMENT 'User ID',
              `deal_id` int(10) unsigned DEFAULT NULL COMMENT 'Deal ID',
              `rating_id` int(10) unsigned DEFAULT NULL COMMENT 'Rating ID',
              `value` int(2) DEFAULT NULL COMMENT 'Value',
              `note` varchar(255) DEFAULT '' COMMENT 'Note',
              PRIMARY KEY (`id`),
              UNIQUE KEY `user_id_deal_id_rating_id` (`user_id`,`deal_id`,`rating_id`),
              KEY `FK_UsersRatings_Deals` (`deal_id`),
              KEY `FK_UsersRatings_Ratings` (`rating_id`),
              CONSTRAINT `FK_UsersRatings_Deals` FOREIGN KEY (`deal_id`) REFERENCES `Deals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `FK_UsersRatings_Ratings` FOREIGN KEY (`rating_id`) REFERENCES `Ratings` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `FK_UsersRatings_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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

            DROP TABLE IF EXISTS `RatingsRatings`;
            DROP TABLE IF EXISTS `UsersRatingsValues`;
            DROP TABLE IF EXISTS `DealsCategoriesRatings`;

            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

}