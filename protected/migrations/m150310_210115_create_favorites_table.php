<?php

class m150310_210115_create_favorites_table extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            -- Дамп структуры для таблица FavoritesCookies
            CREATE TABLE IF NOT EXISTS `FavoritesCookies` (
              `id` char(32) NOT NULL COMMENT 'Cookie',
              `expire` int(12) DEFAULT NULL COMMENT 'Expire time',
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Дамп данных таблицы FavoritesCookies: ~0 rows (приблизительно)
            /*!40000 ALTER TABLE `FavoritesCookies` DISABLE KEYS */;
            /*!40000 ALTER TABLE `FavoritesCookies` ENABLE KEYS */;

            -- Дамп структуры для таблица CookiesFavorites
            CREATE TABLE IF NOT EXISTS `CookiesFavorites` (
              `id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `cookie_id` char(32) DEFAULT NULL COMMENT 'Cookie',
              `deal_id` int(11) unsigned DEFAULT NULL COMMENT 'Deal ID',
              PRIMARY KEY (`id`),
              KEY `FK_CookiesFavorites_FavoritesCookies` (`cookie_id`),
              KEY `FK_CookiesFavorites_Deals` (`deal_id`),
              CONSTRAINT `FK_CookiesFavorites_FavoritesCookies` FOREIGN KEY (`cookie_id`) REFERENCES `FavoritesCookies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
              CONSTRAINT `FK_CookiesFavorites_Deals` FOREIGN KEY (`deal_id`) REFERENCES `Deals` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

            -- Дамп данных таблицы CookiesFavorites: ~0 rows (приблизительно)
            /*!40000 ALTER TABLE `CookiesFavorites` DISABLE KEYS */;
            /*!40000 ALTER TABLE `CookiesFavorites` ENABLE KEYS */;

            -- Дамп структуры для таблица UsersFavorites
            CREATE TABLE IF NOT EXISTS `UsersFavorites` (
              `id` int(255) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
              `deal_id` int(11) unsigned DEFAULT NULL COMMENT 'Deal ID',
              `user_id` int(11) DEFAULT NULL COMMENT 'User ID',
              PRIMARY KEY (`id`),
              KEY `FK_SessionFavorites_Deals` (`deal_id`),
              KEY `FK_UsersFavorites_Users` (`user_id`),
              CONSTRAINT `FK_UsersFavorites_Deals` FOREIGN KEY (`deal_id`) REFERENCES `Deals` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
              CONSTRAINT `FK_UsersFavorites_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

            -- Дамп данных таблицы UsersFavorites: ~0 rows (приблизительно)
            /*!40000 ALTER TABLE `UsersFavorites` DISABLE KEYS */;
            /*!40000 ALTER TABLE `UsersFavorites` ENABLE KEYS */;
            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            DROP TABLE `UsersFavorites`;
            DROP TABLE `CookiesFavorites`;
            DROP TABLE `FavoritesCookies`;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
        ");
	}

}