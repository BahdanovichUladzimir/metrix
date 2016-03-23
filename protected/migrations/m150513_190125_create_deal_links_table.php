<?php

class m150513_190125_create_deal_links_table extends CDbMigration
{
	public function up()
	{
        $this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

            -- Дамп структуры для таблица dev_dont_stop.DealLinks
            CREATE TABLE IF NOT EXISTS `DealLinks` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `link` varchar(255) NOT NULL DEFAULT '' COMMENT 'Link',
              `link_type` varchar(50) DEFAULT NULL COMMENT 'Link type',
              `deal_id` int(11) unsigned DEFAULT NULL COMMENT 'Deal ID',
              PRIMARY KEY (`id`),
              KEY `FK_DealLinks_Deals` (`deal_id`),
              CONSTRAINT `FK_DealLinks_Deals` FOREIGN KEY (`deal_id`) REFERENCES `Deals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Дамп данных таблицы dev_dont_stop.DealLinks: ~0 rows (приблизительно)
            /*!40000 ALTER TABLE `DealLinks` DISABLE KEYS */;
            /*!40000 ALTER TABLE `DealLinks` ENABLE KEYS */;
            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

	public function down()
	{
		$this->execute("
		    SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            DROP TABLE `DealLinks`;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
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