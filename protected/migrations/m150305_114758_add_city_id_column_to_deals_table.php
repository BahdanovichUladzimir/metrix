<?php

class m150305_114758_add_city_id_column_to_deals_table extends CDbMigration
{



	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `Deals`
              ADD COLUMN `city_id` INT(11) UNSIGNED NULL DEFAULT NULL COMMENT 'City ID' AFTER `user_id`;
            ALTER TABLE `Deals`
	          ADD CONSTRAINT `FK_Deals_Cities` FOREIGN KEY (`city_id`) REFERENCES `Cities` (`id`) ON UPDATE CASCADE ON DELETE SET NULL;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `Deals`
	          DROP FOREIGN KEY `FK_Deals_Cities`;
            ALTER TABLE `Deals`
	          DROP COLUMN `city_id`;
        ");
	}

}