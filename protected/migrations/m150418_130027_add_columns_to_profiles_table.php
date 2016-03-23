<?php

class m150418_130027_add_columns_to_profiles_table extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `Profiles`
                CHANGE COLUMN `user_id` `user_id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'User ID' FIRST,
                CHANGE COLUMN `first_name` `first_name` VARCHAR(255) NULL DEFAULT NULL COMMENT 'First name' AFTER `user_id`,
                CHANGE COLUMN `last_name` `last_name` VARCHAR(255) NULL DEFAULT NULL COMMENT 'Last name' AFTER `first_name`,
                ADD COLUMN `phone` VARCHAR(50) NULL COMMENT 'Phone' AFTER `last_name`,
                ADD COLUMN `email` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Email' AFTER `phone`,
                ADD COLUMN `description` TEXT NOT NULL COMMENT 'Description' AFTER `email`,
                ADD COLUMN `avatar` VARCHAR(255) NOT NULL COMMENT 'Avatar' AFTER `description`,
                ADD COLUMN `city_id` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'City ID' AFTER `avatar`,
                ADD COLUMN `type` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Type' AFTER `city_id`,
                ADD COLUMN `facebook` VARCHAR(255) NULL COMMENT 'Facebook URL' AFTER `type`,
                ADD COLUMN `twitter` VARCHAR(255) NULL COMMENT 'Twitter URL' AFTER `facebook`,
                ADD COLUMN `skype` VARCHAR(255) NULL COMMENT 'Skype' AFTER `twitter`,
                ADD COLUMN `linkedin` VARCHAR(255) NULL COMMENT 'Linkedin URL' AFTER `skype`,
                ADD COLUMN `vimeo` VARCHAR(255) NULL COMMENT 'Vimeo URL' AFTER `linkedin`,
                ADD COLUMN `vk` VARCHAR(255) NULL COMMENT 'Vkontakte URL' AFTER `vimeo`,
                ADD COLUMN `ok` VARCHAR(255) NULL COMMENT 'Odnoklassniki URL' AFTER `vk`;
            ALTER TABLE `Profiles`
                ADD CONSTRAINT `FK_Profiles_Cities` FOREIGN KEY (`city_id`) REFERENCES `Cities` (`id`) ON UPDATE CASCADE ON DELETE SET NULL;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
            /*!40101 SET NAMES utf8mb4 */;
            /*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
            /*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

            ALTER TABLE `Profiles`
                DROP COLUMN `phone`,
                DROP COLUMN `email`,
                DROP COLUMN `description`,
                DROP COLUMN `avatar`,
                DROP COLUMN `city_id`,
                DROP COLUMN `type`,
                DROP COLUMN `facebook`,
                DROP COLUMN `twitter`,
                DROP COLUMN `skype`,
                DROP COLUMN `linkedin`,
                DROP COLUMN `vimeo`,
                DROP COLUMN `vk`,
                DROP COLUMN `ok`;

            /*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
            /*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
            /*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
        ");
	}

}