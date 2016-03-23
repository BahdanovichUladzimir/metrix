<?php

class m150306_163916_add_currency_id_column_to_countries_table extends CDbMigration
{


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `Countries`
                ADD COLUMN `currency_id` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'Currency ID' AFTER `priority`,
                ADD CONSTRAINT `FK_Countries_Currencies` FOREIGN KEY (`currency_id`) REFERENCES `Currencies` (`id`) ON UPDATE CASCADE ON DELETE SET NULL;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `Countries`
                DROP FOREIGN KEY `FK_Countries_Currencies`,
                DROP COLUMN `currency_id`;
        ");
	}

}