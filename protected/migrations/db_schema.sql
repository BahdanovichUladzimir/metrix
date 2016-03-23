-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.5.41-log - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.1.0.4867
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры базы данных dev_dont_stop
CREATE DATABASE IF NOT EXISTS `dev_dont_stop` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dev_dont_stop`;


-- Дамп структуры для таблица dev_dont_stop.Ads
CREATE TABLE IF NOT EXISTS `Ads` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор товара',
  `title` varchar(255) DEFAULT NULL COMMENT 'Имя товара',
  `intro` text NOT NULL COMMENT 'Краткое описание товара',
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Метка публикации товара пользователем(1 - опубликован, 0 - не опубликован)',
  `description` text NOT NULL COMMENT 'Полное описание товара',
  `user_id` int(11) DEFAULT NULL COMMENT 'Уникальный идентификатор пользователя добавившего товар',
  `status_id` int(3) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор статуса товара',
  `created_date` int(12) unsigned DEFAULT NULL COMMENT 'Дата создания в секундах UNIX время',
  `published_date` int(12) unsigned DEFAULT NULL COMMENT 'Дата публикации в секундах UNIX время',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Приоритет',
  PRIMARY KEY (`id`),
  KEY `FK_Deals_DealsStatuses` (`status_id`),
  KEY `FK_Deals_Users` (`user_id`),
  CONSTRAINT `ads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Ads_AdsStatuses` FOREIGN KEY (`status_id`) REFERENCES `AdsStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.AdsImages
CREATE TABLE IF NOT EXISTS `AdsImages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор изображения',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя изображения',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя файла изображения',
  `ext` varchar(5) DEFAULT '' COMMENT 'Расширение файла изображения',
  `path` varchar(255) DEFAULT NULL COMMENT 'Путь к изображению',
  `url` varchar(255) DEFAULT NULL COMMENT 'Url адрес изображения',
  `width` int(11) DEFAULT '0' COMMENT 'Ширина изображения',
  `height` int(11) DEFAULT '0' COMMENT 'Высота изображения',
  `ad_id` int(11) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор предложения',
  PRIMARY KEY (`id`),
  KEY `FK_DealsImages_Deals` (`ad_id`),
  CONSTRAINT `FK_AdsImages_Ads` FOREIGN KEY (`ad_id`) REFERENCES `Ads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.AdsStatuses
CREATE TABLE IF NOT EXISTS `AdsStatuses` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статуса',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Имя статуса',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.AdsVideos
CREATE TABLE IF NOT EXISTS `AdsVideos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор изображения',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя изображения',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя файла изображения',
  `ext` varchar(5) DEFAULT '' COMMENT 'Расширение файла изображения',
  `path` varchar(255) DEFAULT NULL COMMENT 'Путь к изображению',
  `url` varchar(255) DEFAULT NULL COMMENT 'Url адрес изображения',
  `width` int(11) DEFAULT '0' COMMENT 'Ширина изображения',
  `height` int(11) DEFAULT '0' COMMENT 'Высота изображения',
  `duration` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Длительность видео в секундах',
  `ad_id` int(11) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор предложения',
  PRIMARY KEY (`id`),
  KEY `FK__Deals` (`ad_id`),
  CONSTRAINT `FK_AdsVideos_Ads` FOREIGN KEY (`ad_id`) REFERENCES `Ads` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.AppCategories
CREATE TABLE IF NOT EXISTS `AppCategories` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор категории приложения',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя категории приложения',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Articles
CREATE TABLE IF NOT EXISTS `Articles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статьи',
  `title` varchar(11) NOT NULL DEFAULT '' COMMENT 'Название статьи',
  `intro` text NOT NULL COMMENT 'Краткое описание статьи',
  `content` text NOT NULL COMMENT 'Текст статьи',
  `category_id` int(11) unsigned DEFAULT NULL COMMENT 'Идентификатор категории статьи',
  `status_id` int(3) unsigned DEFAULT NULL COMMENT 'Идентификатор статуса',
  `created_date` int(12) NOT NULL DEFAULT '0' COMMENT 'Дата создания',
  `published_date` int(12) NOT NULL DEFAULT '0' COMMENT 'Дата публикации',
  PRIMARY KEY (`id`),
  KEY `FK_Articles_ArticlesCategories` (`category_id`),
  KEY `FK_Articles_ArticlesStatuses` (`status_id`),
  CONSTRAINT `FK_Articles_ArticlesCategories` FOREIGN KEY (`category_id`) REFERENCES `ArticlesCategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Articles_ArticlesStatuses` FOREIGN KEY (`status_id`) REFERENCES `ArticlesStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.ArticlesCategories
CREATE TABLE IF NOT EXISTS `ArticlesCategories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор категории',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Уникальный идентификатор родительской категории',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Имя категории',
  `description` text NOT NULL COMMENT 'Описание категории',
  `status_id` int(3) unsigned DEFAULT NULL COMMENT 'Идентификатор статуса категории',
  PRIMARY KEY (`id`),
  KEY `FK__ArticlesCategoriesStatuses` (`status_id`),
  CONSTRAINT `FK__ArticlesCategoriesStatuses` FOREIGN KEY (`status_id`) REFERENCES `ArticlesCategoriesStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.ArticlesCategoriesStatuses
CREATE TABLE IF NOT EXISTS `ArticlesCategoriesStatuses` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статуса',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Имя статуса',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.ArticlesStatuses
CREATE TABLE IF NOT EXISTS `ArticlesStatuses` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статуса',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Имя статуса',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.AuthAssignment
CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` int(11) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`),
  KEY `FK_AuthAssignment_Users` (`userid`),
  CONSTRAINT `AuthAssignment_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_AuthAssignment_Users` FOREIGN KEY (`userid`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.AuthItem
CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.AuthItemChild
CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `AuthItemChild_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `AuthItemChild_ibfk_2` FOREIGN KEY (`child`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Cities
CREATE TABLE IF NOT EXISTS `Cities` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор города',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'Название города',
  `country_id` int(11) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор страны',
  `key` varchar(50) DEFAULT '' COMMENT 'Ключ (например msk или spb)',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Приоритет',
  `longitude` float unsigned NOT NULL DEFAULT '0' COMMENT 'Долгота в градусах (координата)',
  `latitude` float unsigned NOT NULL DEFAULT '0' COMMENT 'Широта в градусах (координата)',
  PRIMARY KEY (`id`),
  KEY `FK__Countries` (`country_id`),
  CONSTRAINT `FK__Countries` FOREIGN KEY (`country_id`) REFERENCES `Countries` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Comments
CREATE TABLE IF NOT EXISTS `Comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор комментария',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Заголовок комментария',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Идентификатор родительского комментария',
  `description` text NOT NULL COMMENT 'Текст комментария',
  `app_category_id` int(3) unsigned DEFAULT NULL COMMENT 'Идентификатор категории приложения',
  `app_category_item_id` bigint(11) DEFAULT NULL COMMENT 'Идентификатор итема категории',
  `user_id` int(11) DEFAULT NULL COMMENT 'Идентификатор пользователя',
  `status_id` int(3) unsigned DEFAULT NULL COMMENT 'Идентификатор статуса комментария',
  `created_date` int(40) unsigned NOT NULL DEFAULT '0' COMMENT 'Дата создания комментария UNIX',
  `published_date` int(40) unsigned NOT NULL DEFAULT '0' COMMENT 'Дата публикации комментария UNIX',
  PRIMARY KEY (`id`),
  KEY `FK_Comments_AppCategories` (`app_category_id`),
  KEY `FK_Comments_Users` (`user_id`),
  KEY `FK_Comments_CommentsStatuses` (`status_id`),
  CONSTRAINT `FK_Comments_AppCategories` FOREIGN KEY (`app_category_id`) REFERENCES `AppCategories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK_Comments_CommentsStatuses` FOREIGN KEY (`status_id`) REFERENCES `CommentsStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_Comments_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.CommentsStatuses
CREATE TABLE IF NOT EXISTS `CommentsStatuses` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Идентификатор статуса комментария',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Имя статуса',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Config
CREATE TABLE IF NOT EXISTS `Config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `param` varchar(128) NOT NULL,
  `value` text NOT NULL,
  `default` text NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `param` (`param`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Countries
CREATE TABLE IF NOT EXISTS `Countries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор страны',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Название страны',
  `key` varchar(5) NOT NULL DEFAULT '' COMMENT 'Ключ (например en, ru)',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Приоритет',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Deals
CREATE TABLE IF NOT EXISTS `Deals` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор товара',
  `name` varchar(255) DEFAULT NULL COMMENT 'Имя товара',
  `intro` text NOT NULL COMMENT 'Краткое описание товара',
  `is_published` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Метка публикации товара пользователем(1 - опубликован, 0 - не опубликован)',
  `description` text NOT NULL COMMENT 'Полное описание товара',
  `price` int(11) NOT NULL DEFAULT '0' COMMENT 'Цена товара',
  `user_id` int(11) DEFAULT NULL COMMENT 'Уникальный идентификатор пользователя добавившего товар',
  `status_id` int(3) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор статуса товара',
  `created_date` int(12) unsigned DEFAULT NULL COMMENT 'Дата создания в секундах UNIX время',
  `published_date` int(12) unsigned DEFAULT NULL COMMENT 'Дата публикации в секундах UNIX время',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Приоритет',
  PRIMARY KEY (`id`),
  KEY `FK_Deals_DealsStatuses` (`status_id`),
  KEY `FK_Deals_Users` (`user_id`),
  CONSTRAINT `FK_Deals_DealsStatuses` FOREIGN KEY (`status_id`) REFERENCES `DealsStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_Deals_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.DealsCategories
CREATE TABLE IF NOT EXISTS `DealsCategories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор категории',
  `parent_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Уникальный идентификатор родителькой категории',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя категории',
  `description` text COMMENT 'Описание категории',
  `status_id` int(3) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор статуса категории',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `FK_DealsCategories_DealsCategoriesStatuses` (`status_id`),
  CONSTRAINT `FK_DealsCategories_DealsCategoriesStatuses` FOREIGN KEY (`status_id`) REFERENCES `DealsCategoriesStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.DealsCategoriesParams
CREATE TABLE IF NOT EXISTS `DealsCategoriesParams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор записи',
  `deal_category_id` int(11) unsigned DEFAULT NULL COMMENT 'Идентификатор категории предложения',
  `deal_param_id` int(11) unsigned DEFAULT NULL COMMENT 'Идентификатор параметра предложения',
  PRIMARY KEY (`id`),
  KEY `FK__DealsCategories` (`deal_category_id`),
  KEY `FK__DealsParams` (`deal_param_id`),
  CONSTRAINT `FK__DealsCategories` FOREIGN KEY (`deal_category_id`) REFERENCES `DealsCategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK__DealsParams` FOREIGN KEY (`deal_param_id`) REFERENCES `DealsParams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.DealsCategoriesStatuses
CREATE TABLE IF NOT EXISTS `DealsCategoriesStatuses` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статуса',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT 'Имя статуса',
  `label` varchar(50) NOT NULL DEFAULT '' COMMENT 'Status label',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.DealsImages
CREATE TABLE IF NOT EXISTS `DealsImages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор изображения',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя изображения',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя файла изображения',
  `ext` varchar(5) DEFAULT '' COMMENT 'Расширение файла изображения',
  `path` varchar(255) DEFAULT NULL COMMENT 'Путь к изображению',
  `url` varchar(255) DEFAULT NULL COMMENT 'Url адрес изображения',
  `width` int(11) DEFAULT '0' COMMENT 'Ширина изображения',
  `height` int(11) DEFAULT '0' COMMENT 'Высота изображения',
  `deal_id` int(11) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор предложения',
  PRIMARY KEY (`id`),
  KEY `FK_DealsImages_Deals` (`deal_id`),
  CONSTRAINT `FK_DealsImages_Deals` FOREIGN KEY (`deal_id`) REFERENCES `Deals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.DealsParams
CREATE TABLE IF NOT EXISTS `DealsParams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор параметра',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя параметра',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.DealsParamsValues
CREATE TABLE IF NOT EXISTS `DealsParamsValues` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор',
  `deal_id` int(11) unsigned DEFAULT NULL COMMENT 'Идентификатор предложения',
  `param_id` int(11) unsigned DEFAULT NULL COMMENT 'Идентификато параметра',
  `value` varchar(255) DEFAULT NULL COMMENT 'Значение параметра',
  PRIMARY KEY (`id`),
  KEY `FK_DealsParamsValues_Deals` (`deal_id`),
  KEY `FK_DealsParamsValues_DealsParams` (`param_id`),
  CONSTRAINT `FK_DealsParamsValues_Deals` FOREIGN KEY (`deal_id`) REFERENCES `Deals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_DealsParamsValues_DealsParams` FOREIGN KEY (`param_id`) REFERENCES `DealsParams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.DealsStatuses
CREATE TABLE IF NOT EXISTS `DealsStatuses` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статуса',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Имя статуса',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.DealsVideos
CREATE TABLE IF NOT EXISTS `DealsVideos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор изображения',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя изображения',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя файла изображения',
  `ext` varchar(5) DEFAULT '' COMMENT 'Расширение файла изображения',
  `path` varchar(255) DEFAULT NULL COMMENT 'Путь к изображению',
  `url` varchar(255) DEFAULT NULL COMMENT 'Url адрес изображения',
  `width` int(11) DEFAULT '0' COMMENT 'Ширина изображения',
  `height` int(11) DEFAULT '0' COMMENT 'Высота изображения',
  `duration` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Длительность видео в секундах',
  `deal_id` int(11) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор предложения',
  PRIMARY KEY (`id`),
  KEY `FK__Deals` (`deal_id`),
  CONSTRAINT `FK_DealsVideos_Deals` FOREIGN KEY (`deal_id`) REFERENCES `Deals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Deals_DealsCategories
CREATE TABLE IF NOT EXISTS `Deals_DealsCategories` (
  `id` int(11) DEFAULT NULL COMMENT 'Уникальный идентификатор записи',
  `deal_id` int(11) unsigned NOT NULL COMMENT 'Уникальный идентификатор товара',
  `category_id` int(11) unsigned NOT NULL COMMENT 'Уникальный идентификатор категории товара',
  KEY `FK_Deals_DealsCategories_Deals` (`deal_id`),
  KEY `FK_Deals_DealsCategories_DealsCategories` (`category_id`),
  CONSTRAINT `FK_Deals_DealsCategories_Deals` FOREIGN KEY (`deal_id`) REFERENCES `Deals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Deals_DealsCategories_DealsCategories` FOREIGN KEY (`category_id`) REFERENCES `DealsCategories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица-связка (связь MANY TO MANY) товаров и категорий товаров (таблицы products и products_categories)';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Districts
CREATE TABLE IF NOT EXISTS `Districts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор района',
  `name` varchar(255) DEFAULT '' COMMENT 'Название района',
  `city_id` int(11) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор города',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Приоритет',
  PRIMARY KEY (`id`),
  KEY `FK_Districts_Cities` (`city_id`),
  CONSTRAINT `FK_Districts_Cities` FOREIGN KEY (`city_id`) REFERENCES `Cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Таблица районов городов';

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Feedback
CREATE TABLE IF NOT EXISTS `Feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор сообщения',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT 'Заголовок сообщения',
  `user_email` varchar(255) NOT NULL DEFAULT '' COMMENT 'Email пользователя, отправившего сообщение',
  `user_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя пользователя отправившего сообщение',
  `user_id` int(11) DEFAULT NULL COMMENT 'Идентификатор пользователя, отправившего сообщение',
  `status_id` int(11) unsigned DEFAULT NULL COMMENT 'Идентификатор статуса сообщения',
  `recipient_id` int(11) DEFAULT NULL COMMENT 'Идентификатор пользователя (админа) принявшего сообщение',
  `description` text NOT NULL COMMENT 'Текст сообщения',
  `created_date` int(12) unsigned NOT NULL DEFAULT '0' COMMENT 'Дата/время создания сообщения UNIX',
  `reply_date` int(12) unsigned NOT NULL DEFAULT '0' COMMENT 'Дата/время ответа на сообщение UNIX',
  PRIMARY KEY (`id`),
  KEY `FK_Feedback_FeedbackStatuses` (`status_id`),
  KEY `FK_Feedback_Users` (`user_id`),
  KEY `FK_Feedback_Users_2` (`recipient_id`),
  CONSTRAINT `FK_Feedback_FeedbackStatuses` FOREIGN KEY (`status_id`) REFERENCES `FeedbackStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_Feedback_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Feedback_Users_2` FOREIGN KEY (`recipient_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.FeedbackStatuses
CREATE TABLE IF NOT EXISTS `FeedbackStatuses` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статуса',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Имя статуса',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Message
CREATE TABLE IF NOT EXISTS `Message` (
  `id` int(11) NOT NULL DEFAULT '0',
  `language` varchar(16) NOT NULL DEFAULT '',
  `translation` text,
  PRIMARY KEY (`id`,`language`),
  CONSTRAINT `FK_Message_SourceMessage` FOREIGN KEY (`id`) REFERENCES `SourceMessage` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Migration
CREATE TABLE IF NOT EXISTS `Migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Payments
CREATE TABLE IF NOT EXISTS `Payments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор платежа',
  `status_id` int(3) unsigned DEFAULT NULL COMMENT 'Идентификатор статуса платежа',
  `user_id` int(11) DEFAULT NULL COMMENT 'Идентификатор пользователя',
  `time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Дата-время платежа UNIX',
  `amount` double(10,4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Payments_PaymentsStatuses` (`status_id`),
  KEY `FK_Payments_Users` (`user_id`),
  CONSTRAINT `FK_Payments_PaymentsStatuses` FOREIGN KEY (`status_id`) REFERENCES `PaymentsStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `FK_Payments_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.PaymentsStatuses
CREATE TABLE IF NOT EXISTS `PaymentsStatuses` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статуса',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Имя статуса',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Profiles
CREATE TABLE IF NOT EXISTS `Profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.ProfilesFields
CREATE TABLE IF NOT EXISTS `ProfilesFields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `varname` varchar(50) NOT NULL DEFAULT '',
  `title` varchar(255) NOT NULL DEFAULT '',
  `field_type` varchar(50) NOT NULL DEFAULT '',
  `field_size` int(3) NOT NULL DEFAULT '0',
  `field_size_min` int(3) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` text,
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` text,
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Rating
CREATE TABLE IF NOT EXISTS `Rating` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор рейтинга',
  `app_category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Уникальный идентификатор категории приложения',
  `app_category_item_id` bigint(11) unsigned NOT NULL DEFAULT '0' COMMENT 'Уникальный идентификатор итема категории приложения',
  PRIMARY KEY (`id`),
  KEY `FK_Rating_AppCategories` (`app_category_id`),
  CONSTRAINT `FK_Rating_AppCategories` FOREIGN KEY (`app_category_id`) REFERENCES `AppCategories` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.RatingParams
CREATE TABLE IF NOT EXISTS `RatingParams` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор параметра рейтинга',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя параметра рейтинга',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.RatingParamsValues
CREATE TABLE IF NOT EXISTS `RatingParamsValues` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор',
  `rating_id` int(11) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор рейтинга',
  `rating_param_id` int(11) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор параметра рейтинга',
  `value` float unsigned NOT NULL DEFAULT '0' COMMENT 'Значение параметра рейтинга',
  PRIMARY KEY (`id`),
  KEY `FK__Rating` (`rating_id`),
  KEY `FK__RatingParams` (`rating_param_id`),
  CONSTRAINT `FK__Rating` FOREIGN KEY (`rating_id`) REFERENCES `Rating` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK__RatingParams` FOREIGN KEY (`rating_param_id`) REFERENCES `RatingParams` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Rights
CREATE TABLE IF NOT EXISTS `Rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`),
  CONSTRAINT `Rights_ibfk_1` FOREIGN KEY (`itemname`) REFERENCES `AuthItem` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.SourceMessage
CREATE TABLE IF NOT EXISTS `SourceMessage` (
  `id` int(11) NOT NULL,
  `category` varchar(32) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.tbl_migration
CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Underground
CREATE TABLE IF NOT EXISTS `Underground` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор метро',
  `city_id` int(11) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор города',
  `name` varchar(255) DEFAULT NULL COMMENT 'Название метро',
  `longitude` float DEFAULT '0' COMMENT 'Долгота(координаты)',
  `latitude` float DEFAULT '0' COMMENT 'Широта(координаты)',
  `priority` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT 'Приоритет',
  PRIMARY KEY (`id`),
  KEY `FK__Cities` (`city_id`),
  CONSTRAINT `FK__Cities` FOREIGN KEY (`city_id`) REFERENCES `Cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.Users
CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ballance` double NOT NULL DEFAULT '0' COMMENT 'Балланс',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username` (`username`),
  UNIQUE KEY `user_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.UsersFriends
CREATE TABLE IF NOT EXISTS `UsersFriends` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор записи',
  `user_id` int(11) DEFAULT NULL COMMENT 'Уникальный идентификатор юзера',
  `friend_id` int(11) DEFAULT NULL COMMENT 'Уникальный идентификатор юзера',
  PRIMARY KEY (`id`),
  KEY `FK_UsersFriends_Users` (`user_id`),
  KEY `FK_UsersFriends_Users_2` (`friend_id`),
  CONSTRAINT `FK_UsersFriends_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_UsersFriends_Users_2` FOREIGN KEY (`friend_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.UsersImages
CREATE TABLE IF NOT EXISTS `UsersImages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор изображения',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя изображения',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя файла изображения',
  `ext` varchar(5) DEFAULT '' COMMENT 'Расширение файла изображения',
  `path` varchar(255) DEFAULT NULL COMMENT 'Путь к изображению',
  `url` varchar(255) DEFAULT NULL COMMENT 'Url адрес изображения',
  `width` int(11) DEFAULT '0' COMMENT 'Ширина изображения',
  `height` int(11) DEFAULT '0' COMMENT 'Высота изображения',
  `user_id` int(11) DEFAULT NULL COMMENT 'Уникальный идентификатор предложения',
  PRIMARY KEY (`id`),
  KEY `FK__Deals` (`user_id`),
  CONSTRAINT `FK_UsersImages_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.UsersMessages
CREATE TABLE IF NOT EXISTS `UsersMessages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор сообщения',
  `sender_id` int(11) DEFAULT NULL COMMENT 'Уникальный идентификатор пользователя отправителя',
  `content` text NOT NULL COMMENT 'Текст сообщения',
  `created_date` int(12) NOT NULL DEFAULT '0' COMMENT 'Время отправки сообщения',
  PRIMARY KEY (`id`),
  KEY `FK__Users` (`sender_id`),
  CONSTRAINT `FK__Users` FOREIGN KEY (`sender_id`) REFERENCES `Users` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.UsersMessagesRecievers
CREATE TABLE IF NOT EXISTS `UsersMessagesRecievers` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникалшьный идентификатор записи',
  `message_id` int(11) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор сообщения',
  `reciever_id` int(11) DEFAULT NULL COMMENT 'Уникальный идентификатор пользователя получателя',
  `status_id` int(3) unsigned DEFAULT NULL COMMENT 'Уникальный идентификатор статуса',
  `receipt_time` int(12) DEFAULT NULL COMMENT 'Время получения',
  PRIMARY KEY (`id`),
  KEY `FK_UsersMessagesRecievers_UsersMessages` (`message_id`),
  KEY `FK_UsersMessagesRecievers_Users` (`reciever_id`),
  KEY `FK_UsersMessagesRecievers_UsersMessagesStatuses` (`status_id`),
  CONSTRAINT `FK_UsersMessagesRecievers_Users` FOREIGN KEY (`reciever_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_UsersMessagesRecievers_UsersMessages` FOREIGN KEY (`message_id`) REFERENCES `UsersMessages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_UsersMessagesRecievers_UsersMessagesStatuses` FOREIGN KEY (`status_id`) REFERENCES `UsersMessagesStatuses` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.UsersMessagesStatuses
CREATE TABLE IF NOT EXISTS `UsersMessagesStatuses` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор статуса',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT 'Имя статуса',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Экспортируемые данные не выделены.


-- Дамп структуры для таблица dev_dont_stop.UsersVideos
CREATE TABLE IF NOT EXISTS `UsersVideos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор изображения',
  `name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя изображения',
  `file_name` varchar(255) NOT NULL DEFAULT '' COMMENT 'Имя файла изображения',
  `ext` varchar(5) DEFAULT '' COMMENT 'Расширение файла изображения',
  `path` varchar(255) DEFAULT NULL COMMENT 'Путь к изображению',
  `url` varchar(255) DEFAULT NULL COMMENT 'Url адрес изображения',
  `width` int(11) DEFAULT '0' COMMENT 'Ширина изображения',
  `height` int(11) DEFAULT '0' COMMENT 'Высота изображения',
  `duration` int(50) unsigned NOT NULL DEFAULT '0' COMMENT 'Длительность видео в секундах',
  `user_id` int(11) DEFAULT NULL COMMENT 'Уникальный идентификатор предложения',
  PRIMARY KEY (`id`),
  KEY `FK__Deals` (`user_id`),
  CONSTRAINT `FK_UsersVideos_Users` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- Экспортируемые данные не выделены.
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
