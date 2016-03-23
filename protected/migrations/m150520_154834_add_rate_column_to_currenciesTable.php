<?php

class m150520_154834_add_rate_column_to_currenciesTable extends CDbMigration
{

	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
        $this->execute("
            ALTER TABLE `Currencies`
	            ADD COLUMN `rate` FLOAT UNSIGNED NULL DEFAULT NULL COMMENT 'Currency rate' AFTER `key`;
            ALTER TABLE `Currencies`
	            ADD COLUMN `date` INT(11) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Update date' AFTER `rate`;
        ");
	}

	public function safeDown()
	{
        $this->execute("
            ALTER TABLE `Currencies`
                DROP COLUMN `rate`;
            ALTER TABLE `Currencies`
                DROP COLUMN `date`;
		");
	}

}