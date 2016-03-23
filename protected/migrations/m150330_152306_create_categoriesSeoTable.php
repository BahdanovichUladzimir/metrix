<?php

class m150330_152306_create_categoriesSeoTable extends CDbMigration
{
	public function up()
	{
        $this->execute("
        /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        /*!40101 SET NAMES utf8mb4 */;
        /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
        /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

        -- Дамп структуры базы данных dev_dont_stop
        CREATE DATABASE IF NOT EXISTS `dev_dont_stop` /*!40100 DEFAULT CHARACTER SET utf8 */;
        USE `dev_dont_stop`;


        -- Дамп структуры для таблица dev_dont_stop.DealsCategoriesSeo
        CREATE TABLE IF NOT EXISTS `DealsCategoriesSeo` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
          `category_id` int(11) unsigned DEFAULT NULL COMMENT 'Category ID',
          `city_id` int(10) unsigned DEFAULT NULL COMMENT 'City ID',
          `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Title',
          `h1` varchar(255) NOT NULL DEFAULT '' COMMENT 'H1',
          `description` varchar(255) NOT NULL DEFAULT '' COMMENT 'Description',
          `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT 'Keywords',
          `seotext` text NOT NULL COMMENT 'Seo text',
          `language` varchar(15) NOT NULL DEFAULT '' COMMENT 'Language',
          PRIMARY KEY (`id`),
          KEY `FK_DealsCategoriesSeo_DealsCategories` (`category_id`),
          KEY `FK_DealsCategoriesSeo_Cities` (`city_id`),
          CONSTRAINT `FK_DealsCategoriesSeo_Cities` FOREIGN KEY (`city_id`) REFERENCES `Cities` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
          CONSTRAINT `FK_DealsCategoriesSeo_DealsCategories` FOREIGN KEY (`category_id`) REFERENCES `DealsCategories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

        -- Экспортируемые данные не выделены.
        /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
        /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
        /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

	public function down()
	{
		$this->execute("DROP TABLE `DealsCategoriesSeo`");
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