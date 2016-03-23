<?php

class m150402_110606_create_cms_module_tables extends CDbMigration
{


	// Налоговая Советское района 237 37 16 , 290 96 57, 399 24 16 // Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
          CREATE TABLE IF NOT EXISTS `cms_block` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `updated` timestamp NULL DEFAULT NULL,
          `name` varchar(255) NOT NULL,
          `published` tinyint(1) unsigned NOT NULL DEFAULT '1',
          `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`),
          UNIQUE KEY `name` (`name`),
          KEY `name_deleted` (`name`,`deleted`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


        CREATE TABLE IF NOT EXISTS `cms_block_content` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `blockId` int(10) unsigned NOT NULL,
          `locale` varchar(50) NOT NULL,
          `body` longtext,
          PRIMARY KEY (`id`),
          UNIQUE KEY `blockId_locale` (`blockId`,`locale`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

        CREATE TABLE IF NOT EXISTS `cms_page` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `updated` timestamp NULL DEFAULT NULL,
          `parentId` int(10) unsigned NOT NULL DEFAULT '0',
          `name` varchar(255) NOT NULL,
          `type` varchar(255) DEFAULT NULL,
          `published` tinyint(1) unsigned NOT NULL DEFAULT '1',
          `deleted` tinyint(1) unsigned NOT NULL DEFAULT '0',
          PRIMARY KEY (`id`),
          UNIQUE KEY `name` (`name`),
          KEY `name_deleted` (`name`,`deleted`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

        CREATE TABLE IF NOT EXISTS `cms_page_content` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `pageId` int(10) unsigned NOT NULL,
          `locale` varchar(50) NOT NULL,
          `heading` varchar(255) DEFAULT NULL,
          `body` longtext,
          `url` varchar(255) DEFAULT NULL,
          `pageTitle` varchar(255) DEFAULT NULL,
          `breadcrumb` varchar(255) DEFAULT NULL,
          `metaTitle` varchar(255) DEFAULT NULL,
          `metaDescription` varchar(255) DEFAULT NULL,
          `metaKeywords` varchar(255) DEFAULT NULL,
          PRIMARY KEY (`id`),
          UNIQUE KEY `contentId_locale` (`pageId`,`locale`)
        ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            DROP TABLE IF EXISTS `cms_block`;
            DROP TABLE IF EXISTS `cms_block_content`;
            DROP TABLE IF EXISTS `cms_page`;
            DROP TABLE IF EXISTS `cms_page_content`;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
        ");
	}

}