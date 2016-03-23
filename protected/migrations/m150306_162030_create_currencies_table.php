<?php

class m150306_162030_create_currencies_table extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            -- Дамп структуры для таблица dev_dont_stop.Currencies
            CREATE TABLE IF NOT EXISTS `Currencies` (
              `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Currency ID',
              `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Currency name',
              `key` varchar(10) NOT NULL DEFAULT '' COMMENT 'Currency key',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

            -- Дамп данных таблицы dev_dont_stop.Currencies: ~3 rows (приблизительно)
            /*!40000 ALTER TABLE `Currencies` DISABLE KEYS */;
            INSERT INTO `Currencies` (`id`, `name`, `key`) VALUES
                (1, 'Российский рубль', 'RUR'),
                (2, 'Белорусский рубль', 'BYR'),
                (3, 'Доллар США', 'USD');
            /*!40000 ALTER TABLE `Currencies` ENABLE KEYS */;
            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
                DROP TABLE `Currencies`;
                SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
        ");
	}

}