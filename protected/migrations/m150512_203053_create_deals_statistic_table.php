<?php

class m150512_203053_create_deals_statistic_table extends CDbMigration
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


            -- Дамп структуры для таблица dev_dont_stop.DealsStatistics
            CREATE TABLE IF NOT EXISTS `DealsStatistics` (
              `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `deal_id` int(11) unsigned DEFAULT NULL COMMENT 'Deal ID',
              `views` int(11) unsigned DEFAULT '0' COMMENT 'Views',
              `unique_views` int(11) unsigned DEFAULT '0' COMMENT 'Unique views',
              `date` DATE NULL DEFAULT NULL COMMENT 'Date',
              PRIMARY KEY (`id`),
              KEY `FK_DealsStatistics_Deals` (`deal_id`),
              CONSTRAINT `FK_DealsStatistics_Deals` FOREIGN KEY (`deal_id`) REFERENCES `Deals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Дамп данных таблицы dev_dont_stop.DealsStatistics: ~0 rows (приблизительно)
            /*!40000 ALTER TABLE `DealsStatistics` DISABLE KEYS */;
            /*!40000 ALTER TABLE `DealsStatistics` ENABLE KEYS */;
            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            DROP TABLE `DealsStatistics`;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
        ");
	}

}