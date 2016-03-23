<?php

class m150505_124134_create_payments_tables extends CDbMigration
{
	/*public function up()
	{
	}

	public function down()
	{
		echo "m150505_124134_create_payments_tables does not support migration down.\n";
		return false;
	}*/


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
        /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
        /*!40101 SET NAMES utf8mb4 */;
        /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
        /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

        -- Дамп структуры для таблица dev_dont_stop.Payments
        CREATE TABLE IF NOT EXISTS `Payments` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор платежа',
          `type_id` int(3) unsigned DEFAULT NULL COMMENT 'Идентификатор статуса платежа',
          `app_category_id` int(3) unsigned DEFAULT NULL COMMENT 'Application category ID',
          `app_item_id` int(11) unsigned DEFAULT NULL COMMENT 'Application category item ID',
          `user_id` int(11) DEFAULT NULL COMMENT 'Идентификатор пользователя',
          `time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Дата-время платежа UNIX',
          `amount` double(10,4) DEFAULT NULL COMMENT 'Amount',
          `real_amount` double(10,4) DEFAULT NULL COMMENT 'Real amount',
          PRIMARY KEY (`id`),
          KEY `FK_Payments_PaymentsStatuses` (`type_id`),
          KEY `FK_Payments_Users` (`user_id`),
          KEY `FK_Payments_AppCategories` (`app_category_id`),
          CONSTRAINT `FK_Payments_PaymentsTypes` FOREIGN KEY (`type_id`) REFERENCES `PaymentsTypes` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
          CONSTRAINT `FK_Payments_AppCategories` FOREIGN KEY (`app_category_id`) REFERENCES `AppCategories` (`id`),
          CONSTRAINT `FK_Payments_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
        ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

        -- Дамп данных таблицы dev_dont_stop.Payments: ~0 rows (приблизительно)
        /*!40000 ALTER TABLE `Payments` DISABLE KEYS */;
        INSERT IGNORE INTO `Payments` (`id`, `type_id`, `app_category_id`, `app_item_id`, `user_id`, `time`, `amount`, `real_amount`) VALUES
            (1, 1, 1, 25, 3, 0, 150.0000, 50.0000),
            (2, 2, 2, 25, 3, 0, 350.0000, 150.0000);
        /*!40000 ALTER TABLE `Payments` ENABLE KEYS */;


        -- Дамп структуры для таблица dev_dont_stop.PaymentsTypes
        CREATE TABLE IF NOT EXISTS `PaymentsTypes` (
          `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статуса',
          `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Имя статуса',
          `type` enum('incoming','outgoing') DEFAULT NULL COMMENT 'Type',
          PRIMARY KEY (`id`),
          UNIQUE KEY `name` (`name`)
        ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

        -- Дамп данных таблицы dev_dont_stop.PaymentsTypes: ~0 rows (приблизительно)
        /*!40000 ALTER TABLE `PaymentsTypes` DISABLE KEYS */;
        INSERT IGNORE INTO `PaymentsTypes` (`id`, `name`, `type`) VALUES
            (1, 'test_type', 'incoming'),
            (2, 'test_type_2', 'outgoing');
        /*!40000 ALTER TABLE `PaymentsTypes` ENABLE KEYS */;
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
        DROP TABLE IF EXISTS `PaymentsTypes`;
        DROP TABLE IF EXISTS `Payments`;
        /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
        /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
        /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

}