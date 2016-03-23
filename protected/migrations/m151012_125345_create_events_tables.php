<?php

class m151012_125345_create_events_tables extends CDbMigration
{



	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute("
		/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица dev_dont_stop.Events
CREATE TABLE IF NOT EXISTS `Events` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Name',
  `description` text NOT NULL COMMENT 'Description',
  `user_id` int(11) DEFAULT NULL COMMENT 'User ID',
  `status_id` int(3) NOT NULL DEFAULT '1' COMMENT 'Status ID',
  `type_id` int(3) unsigned NOT NULL DEFAULT '1' COMMENT 'Type ID',
  `public_status_id` int(3) NOT NULL DEFAULT '1' COMMENT 'Public status ID',
  `url` varchar(255) DEFAULT NULL COMMENT 'Url',
  `login` text NOT NULL COMMENT 'Login (question)',
  `password` varchar(255) NOT NULL DEFAULT '' COMMENT 'Password',
  `date` int(12) unsigned DEFAULT NULL COMMENT 'Event date',
  `time` varchar(255) DEFAULT NULL COMMENT 'Event time',
  PRIMARY KEY (`id`),
  KEY `FK_Events_Users` (`user_id`),
  KEY `FK_Events_EventsTypes` (`type_id`),
  CONSTRAINT `FK_Events_EventsTypes` FOREIGN KEY (`type_id`) REFERENCES `EventsTypes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Events_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы dev_dont_stop.Events: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `Events` DISABLE KEYS */;
INSERT INTO `Events` (`id`, `name`, `description`, `user_id`, `status_id`, `type_id`, `public_status_id`, `url`, `login`, `password`, `date`, `time`) VALUES
	(1, 'Wedding', 'jfdgfjdfj', 1, 1, 1, 1, 'jjgjgkjggjjhjhj', 'watzzzzzaaappp', '12345', NULL, NULL),
	(2, 'Holiday', 'lj;jhoih,nmvncnctdcmhfvj', 1, 1, 1, 1, 'jjgjgkjggjjhjhj', 'watzzzzzaaappp', '12345', NULL, NULL);
/*!40000 ALTER TABLE `Events` ENABLE KEYS */;


-- Дамп структуры для таблица dev_dont_stop.EventsGuests
CREATE TABLE IF NOT EXISTS `EventsGuests` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `event_id` int(10) unsigned DEFAULT NULL COMMENT 'Event ID',
  `name` varchar(255) DEFAULT '' COMMENT 'Guest name',
  `party_id` int(3) unsigned DEFAULT NULL COMMENT 'Party ID',
  `status_id` int(3) unsigned DEFAULT NULL COMMENT 'Status ID',
  `note` text COMMENT 'Note',
  PRIMARY KEY (`id`),
  KEY `FK_EventsGuests_Events` (`event_id`),
  CONSTRAINT `FK_EventsGuests_Events` FOREIGN KEY (`event_id`) REFERENCES `Events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы dev_dont_stop.EventsGuests: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `EventsGuests` DISABLE KEYS */;
INSERT INTO `EventsGuests` (`id`, `event_id`, `name`, `party_id`, `status_id`, `note`) VALUES
	(1, 1, 'Богданович наталья', 1, 2, 'Не пьёт'),
	(2, 1, 'Кункевич Юрий', 1, 4, 'Пьёт только ром'),
	(3, 1, 'Кункевич Инна', 1, 4, 'Пьёт всё, может нажраться 34');
/*!40000 ALTER TABLE `EventsGuests` ENABLE KEYS */;


-- Дамп структуры для таблица dev_dont_stop.EventsInvitedUsers
CREATE TABLE IF NOT EXISTS `EventsInvitedUsers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `event_id` int(10) unsigned DEFAULT NULL COMMENT 'Event ID',
  `user_id` int(10) DEFAULT NULL COMMENT 'User ID',
  PRIMARY KEY (`id`),
  KEY `FK_EventsInvitedUsers_Events` (`event_id`),
  KEY `FK_EventsInvitedUsers_Users` (`user_id`),
  CONSTRAINT `FK_EventsInvitedUsers_Events` FOREIGN KEY (`event_id`) REFERENCES `Events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_EventsInvitedUsers_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы dev_dont_stop.EventsInvitedUsers: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `EventsInvitedUsers` DISABLE KEYS */;
/*!40000 ALTER TABLE `EventsInvitedUsers` ENABLE KEYS */;


-- Дамп структуры для таблица dev_dont_stop.EventsTypes
CREATE TABLE IF NOT EXISTS `EventsTypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` varchar(255) DEFAULT NULL COMMENT 'Name',
  `label` varchar(255) DEFAULT '' COMMENT 'Label',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы dev_dont_stop.EventsTypes: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `EventsTypes` DISABLE KEYS */;
INSERT INTO `EventsTypes` (`id`, `name`, `label`) VALUES
	(1, 'wedding', 'Свадьба'),
	(2, 'birthday', 'День рождения'),
	(3, 'holidays', 'Выходные');
/*!40000 ALTER TABLE `EventsTypes` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

		");
	}

	public function safeDown()
	{
	}

}