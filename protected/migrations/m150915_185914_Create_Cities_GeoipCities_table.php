<?php

class m150915_185914_Create_Cities_GeoipCities_table extends CDbMigration
{



	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute(
			"
			/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

            -- Дамп структуры для таблица dev_dont_stop.Cities_GeoipCities
            CREATE TABLE IF NOT EXISTS `Cities_GeoipCities` (
              `id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `city_id` int(11) unsigned DEFAULT NULL COMMENT 'City_id',
              `geoip_city_id` int(10) unsigned DEFAULT NULL COMMENT 'Geoip city ID',
              PRIMARY KEY (`id`),
              KEY `FK_Cities_GeoipCities_Cities` (`city_id`),
              CONSTRAINT `FK_Cities_GeoipCities_Cities` FOREIGN KEY (`city_id`) REFERENCES `Cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Дамп данных таблицы dev_dont_stop.Cities_GeoipCities: ~0 rows (приблизительно)
            /*!40000 ALTER TABLE `Cities_GeoipCities` DISABLE KEYS */;
            /*!40000 ALTER TABLE `Cities_GeoipCities` ENABLE KEYS */;
            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
            "
		);
	}

	public function safeDown()
	{
        $this->execute(
            "
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            DROP TABLE `Cities_GeoipCities`;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
            "
        );

    }

}