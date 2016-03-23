<?php

class m151028_211645_create_banners_module_tables extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute("
			/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
			/*!40101 SET NAMES utf8mb4 */;
			/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
			/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

			-- Дамп структуры для таблица dev_dont_stop.Banners
			CREATE TABLE IF NOT EXISTS `Banners` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
			  `user_id` int(10) DEFAULT NULL COMMENT 'User ID',
			  `link` varchar(255) NOT NULL DEFAULT '' COMMENT 'Link',
			  `image` varchar(255) NOT NULL DEFAULT '' COMMENT 'Image',
			  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name',
			  `approve` int(3) NOT NULL DEFAULT '0' COMMENT 'Approve',
			  `published` int(3) NOT NULL DEFAULT '0' COMMENT 'Published',
			  PRIMARY KEY (`id`),
			  KEY `FK_Banners_Users` (`user_id`),
			  CONSTRAINT `FK_Banners_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			-- Экспортируемые данные не выделены.


			-- Дамп структуры для таблица dev_dont_stop.BannersCats
			CREATE TABLE IF NOT EXISTS `BannersCats` (
			  `id` int(50) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
			  `banner_id` int(10) unsigned DEFAULT NULL COMMENT 'ID',
			  `category_id` int(10) unsigned DEFAULT NULL COMMENT 'ID',
			  PRIMARY KEY (`id`),
			  KEY `FK_BannersCats_Banners` (`banner_id`),
			  KEY `FK_BannersCats_DealsCategories` (`category_id`),
			  CONSTRAINT `FK_BannersCats_Banners` FOREIGN KEY (`banner_id`) REFERENCES `Banners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
			  CONSTRAINT `FK_BannersCats_DealsCategories` FOREIGN KEY (`category_id`) REFERENCES `DealsCategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			-- Экспортируемые данные не выделены.


			-- Дамп структуры для таблица dev_dont_stop.BannersCities
			CREATE TABLE IF NOT EXISTS `BannersCities` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
			  `banner_id` int(10) unsigned DEFAULT NULL COMMENT 'Banner ID',
			  `city_id` int(10) unsigned DEFAULT NULL COMMENT 'City ID',
			  PRIMARY KEY (`id`),
			  KEY `FK_BannersCities_Banners` (`banner_id`),
			  KEY `FK_BannersCities_Cities` (`city_id`),
			  CONSTRAINT `FK_BannersCities_Banners` FOREIGN KEY (`banner_id`) REFERENCES `Banners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
			  CONSTRAINT `FK_BannersCities_Cities` FOREIGN KEY (`city_id`) REFERENCES `Cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			-- Экспортируемые данные не выделены.


			-- Дамп структуры для таблица dev_dont_stop.BannersClicks
			CREATE TABLE IF NOT EXISTS `BannersClicks` (
			  `id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
			  `banner_id` int(10) unsigned DEFAULT NULL COMMENT 'Banner ID',
			  `date` date DEFAULT NULL COMMENT 'Date',
			  `clicks_count` int(50) unsigned NOT NULL DEFAULT '0' COMMENT 'Clicks count',
			  PRIMARY KEY (`id`),
			  KEY `FK_BannersClicks_Banners` (`banner_id`),
			  CONSTRAINT `FK_BannersClicks_Banners` FOREIGN KEY (`banner_id`) REFERENCES `Banners` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;

			-- Экспортируемые данные не выделены.


			-- Дамп структуры для таблица dev_dont_stop.BannersPrices
			CREATE TABLE IF NOT EXISTS `BannersPrices` (
			  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
			  `city_id` int(10) unsigned DEFAULT NULL COMMENT 'City ID',
			  `category_id` int(10) unsigned DEFAULT NULL COMMENT 'Category ID',
			  `price` float unsigned DEFAULT '0' COMMENT 'Price',
			  PRIMARY KEY (`id`),
			  KEY `FK_BannersPrices_Cities` (`city_id`),
			  KEY `FK_BannersPrices_DealsCategories` (`category_id`),
			  CONSTRAINT `FK_BannersPrices_Cities` FOREIGN KEY (`city_id`) REFERENCES `Cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
			  CONSTRAINT `FK_BannersPrices_DealsCategories` FOREIGN KEY (`category_id`) REFERENCES `DealsCategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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
            DROP TABLE `Banners`;
            DROP TABLE `BannersCats`;
            DROP TABLE `BannersCities`;
            DROP TABLE `BannersClicks`;
            DROP TABLE `BannersPrices`;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
        ");
	}

}