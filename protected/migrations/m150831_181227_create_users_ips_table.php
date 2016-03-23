<?php

class m150831_181227_create_users_ips_table extends CDbMigration
{



	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

            -- Дамп структуры для таблица dev_dont_stop.UsersIps
            CREATE TABLE IF NOT EXISTS `UsersIps` (
              `user_id` int(11) DEFAULT NULL COMMENT 'User ID',
              `ip` varchar(50) DEFAULT NULL COMMENT 'IP',
              KEY `FK__Users` (`user_id`),
              CONSTRAINT `FK__Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

            -- Дамп данных таблицы dev_dont_stop.UsersIps: ~0 rows (приблизительно)
            /*!40000 ALTER TABLE `UsersIps` DISABLE KEYS */;
            /*!40000 ALTER TABLE `UsersIps` ENABLE KEYS */;
            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
		");
	}

	public function safeDown()
	{
        $this->execute("
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            DROP TABLE `UsersIps`;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
        ");
	}

}