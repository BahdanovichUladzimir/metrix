<?php

class m150629_205646_create_deltaindexes_table extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

            -- Дамп структуры для таблица dev_dont_stop.DeltaIndexes
            CREATE TABLE IF NOT EXISTS `DeltaIndexes` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `last_indexed_id` int(50) unsigned NOT NULL DEFAULT '0' COMMENT 'Last indexed ID',
              `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Index name',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

            -- Дамп данных таблицы dev_dont_stop.DeltaIndexes: ~1 rows (приблизительно)
            /*!40000 ALTER TABLE `DeltaIndexes` DISABLE KEYS */;
            INSERT INTO `DeltaIndexes` (`id`, `last_indexed_id`, `name`) VALUES
                (1, 0, 'a4h_deal_delta');
            /*!40000 ALTER TABLE `DeltaIndexes` ENABLE KEYS */;
            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            DROP TABLE `DeltaIndexes`;
        ");
	}

}