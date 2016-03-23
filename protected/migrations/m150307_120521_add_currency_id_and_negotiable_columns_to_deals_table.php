<?php

class m150307_120521_add_currency_id_and_negotiable_columns_to_deals_table extends CDbMigration
{



	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `Deals`
                ADD COLUMN `negotiable` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Negotiable' AFTER `archive`,
                ADD COLUMN `currency_id` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'Currency ID' AFTER `city_id`,
                ADD CONSTRAINT `FK_Deals_Currencies` FOREIGN KEY (`currency_id`) REFERENCES `Currencies` (`id`) ON UPDATE CASCADE ON DELETE SET NULL;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `Deals`
                DROP COLUMN `negotiable`,
                DROP COLUMN `currency_id`,
                DROP FOREIGN KEY `FK_Deals_Currencies`;
        ");
	}

}